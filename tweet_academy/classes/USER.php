<?php

include_once 'DB.php';
include_once 'BASE.php';

class USER extends BASE
{
    private const EMAIL = ':email';
    private const NAME = ':name';
    private const TAG = ':tag';
    private const TARGET_ID = ':targetID';
    private const USER_ID = ':userID';
    private const BIRTHDATE = ':birthdate';
    private const PASSWORD = ':password';
    private const REGISTERED_AT = ':registeredAt';
    private const ID = ':id';
    private const LAST_LOGIN = ':lastLogin';
    private const SALT = 'vive le projet tweet_academy.';
    private const ALGO = 'ripemd160';
    public array $userValues;

    public function __construct(array $userInfos = [])
    {
        parent::__construct();
        $this->userValues = $userInfos;
        if (isset($this->userValues['password'])) {
            $this->userValues['password'] = hash(self::ALGO, $this->userValues['password'] . self::SALT);
        }
    }

    public function register(): bool
    {
        try {
            if (!$this->isUnique('email')) {
                $this->setAnswer('This email is already used.', false);
                return false;
            }
            $query = "INSERT INTO user (email, name, tag, birthdate, password, registeredAt)
                      VALUES (:email, :name, :tag, :birthdate, :password, :registeredAt)";
            $this->userValues['tag'] = '@' . $this->userValues['name'] . random_int(100000, 999999);
            $param = [self::EMAIL => $this->userValues['email'],
                      self::NAME => $this->userValues['name'],
                      self::TAG => $this->userValues['tag'],
                      self::PASSWORD => $this->userValues['password'],
                      self::BIRTHDATE => $this->userValues['birthdate'],
                      self::REGISTERED_AT => date(self::DATE_TIME_FORMAT),];
            $this->db->executeQuery($query, $param);
            $this->setAnswer('You are now registered, please log in.', true);
            return true;
        } catch (PDOException|Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    private function isUnique(string $type): bool
    {
        switch ($type) {
            case 'email':
                $query = "SELECT email FROM user WHERE email = :email";
                $param = [self::EMAIL => $this->userValues['email']];
                break;
            case 'tag':
                $query = "SELECT tag FROM user WHERE tag = :tag";
                $param = [self::TAG => $this->userValues['tag']];
                break;
            default:
                return false;
        }
        $result = $this->db->executeQuery($query, $param);
        return empty($result);
    }

    public function login(): bool
    {
        try {
            $query = "SELECT email FROM user WHERE email = :email AND password = :password AND deleted = false";
            $param = [self::EMAIL => $this->userValues['email'],
                      self::PASSWORD => $this->userValues['password'],];
            $result = $this->db->executeQuery($query, $param);
            if (count($result) === 1) {
                $this->setUserSession();
                $query = "UPDATE user SET lastLogin = :lastLogin WHERE id = :id";
                $param = [self::LAST_LOGIN => date(self::DATE_TIME_FORMAT),
                          self::ID => $_SESSION['user']['id'],];
                $this->db->executeQuery($query, $param);
                $this->setAnswer('You are now logged in.', true);
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $this->setAnswer('Wrong email or password.', false);
        return false;
    }

    private function setUserSession(): void
    {
        $_SESSION['user'] = $this->getUserValues();
    }

    public function getUserValues(): array
    {
        try {
            if (isset($this->userValues['email'])) {
                $value = $this->userValues['email'];
                $query = "SELECT * FROM user WHERE email = :param AND deleted = false";
            } else {
                $value = $this->userValues['tag'];
                $query = "SELECT * FROM user WHERE tag = :param AND deleted = false";
            }
            $param = [':param' => $value,];
            $result = $this->db->executeQuery($query, $param);
            return (count($result) === 1) ? $this->cleanResult($result[0]) : [];
        } catch (PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function updateProfile(): bool
    {
        try {
            $query = 'update user set ';
            $param = [];
            $updateProfileOk = true;
            if (!$this->cleanDuplicateSession()) {
                $this->setAnswer('You are not logged in.', false);
                $updateProfileOk = false;
            } elseif (!$this->updateProfileCheck()) {
                $this->setAnswer('Nothing to update.', false);
                $updateProfileOk = false;
            }
            if (!$updateProfileOk) {
                return false;
            }
            foreach ($this->userValues as $key => $value) {
                $isLast = array_key_last($this->userValues) === $key;
                $query .= $isLast ? "$key = :$key " : "$key = :$key, ";
                $param["$key"] = $value;
            }

            $query .= 'where id = :id and deleted = false';
            $param[':id'] = $_SESSION['user']['id'];
            $this->db->executeQuery($query, $param);
            $this->userValues['tag'] = $_SESSION['user']['tag'];
            $this->setUserSession();
            $this->setAnswer('Your profile has been updated.', true);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    private function cleanDuplicateSession(): bool
    {
        if (empty($_SESSION['user'])) {
            return false;
        }
        foreach ($this->userValues as $key => $value) {
            if ($value === $_SESSION['user'][$key]) {
                unset($this->userValues[$key]);
            }
        }
        return true;
    }

    private function updateProfileCheck(): bool
    {
        $isEmpty = empty($this->userValues);
        $emailGood = !isset($this->userValues['email']) || $this->isUnique('email');
        $tagGood = !isset($this->userValues['tag']) || $this->isUnique('tag');
        if ($isEmpty || !$emailGood || !$tagGood) {
            return false;
        }
        return true;
    }

    public function followUser(): bool
    {
        if (!$this->setUpFollow('follow')) {
            return false;
        }
        $query = "INSERT INTO follow (userID, targetID, since)
                  VALUES (:userID, :targetID, :since)";
        $param = [self::USER_ID => $_SESSION['user']['id'],
                  self::TARGET_ID => $this->getUserID($this->userValues['tag']),
                  ':since' => date(self::DATE_TIME_FORMAT),];
        $this->db->executeQuery($query, $param);
        $this->setAnswer('You are now following ' . $this->userValues['tag'], true);
        return true;
    }

    private function setUpFollow(string $type): bool
    {
        $this->getUserValues();
        $setUpFollowValid = true;
        if (empty($this->userValues)) {
            $this->setAnswer('User not found.', false);
            $setUpFollowValid = false;
        }
        if ($type === 'follow' && $this->isFollowing()) {
            $this->setAnswer('You are already following ' . $this->userValues['tag'], false);
            $setUpFollowValid = false;
        } elseif ($type === 'unfollow' && !$this->isFollowing()) {
            $this->setAnswer('You are not following ' . $this->userValues['tag'], false);
            $setUpFollowValid = false;
        }
        return $setUpFollowValid;
    }

    private function isFollowing(): bool
    {
        $query = "SELECT * FROM follow WHERE userID = :userID AND targetID = :targetID";
        $param = [self::USER_ID => $_SESSION['user']['id'],
                  self::TARGET_ID => $this->getUserID($this->userValues['tag']),];
        $result = $this->db->executeQuery($query, $param);
        return !empty($result);
    }

    public function unfollowUser(): bool
    {
        if (!$this->setUpFollow('unfollow')) {
            return false;
        }
        $query = "DELETE FROM follow WHERE userID = :userID AND targetID = :targetID";
        $param = [self::USER_ID => $_SESSION['user']['id'],
                  self::TARGET_ID => $this->getUserID($this->userValues['tag']),];
        $this->db->executeQuery($query, $param);
        $this->setAnswer('You are no longer following ' . $this->userValues['tag'], true);
        return true;
    }

    public function searchUser(string $tag): bool
    {
        $query = "SELECT * FROM user WHERE tag LIKE :tag AND deleted = false";
        $param = [':tag' => '%' . $tag . '%',];
        $result = $this->cleanResult($this->db->executeQuery($query, $param));
        if (empty($result)) {
            $this->setAnswer('No user found.', false);
            return false;
        } else {
            $this->setAnswer('User found.', true, $result);
            return true;
        }
    }

    public function getNumFollowers(): bool
    {
        if (empty($_SESSION['user'])) {
            $this->setAnswer('You are not logged in.', false);
            return false;
        }
        $query = "SELECT COUNT(*) numFollowers FROM follow WHERE targetID = :targetID";
        $param = [self::TARGET_ID => $_SESSION['user']['id'],];
        $result = $this->db->executeQuery($query, $param);
        if (empty($result)) {
            $this->setAnswer('Nothing found', false);
            return false;
        }
        $this->setAnswer('Number of followers.', true, $this->cleanResult($result[0]));
        return true;
    }

    public function deleteUser(): bool
    {
        if (empty($_SESSION['user'])) {
            $this->setAnswer('You are not logged in.', false);
            return false;
        }
        $query = "UPDATE user SET deleted = true WHERE id = :id";
        $param = [':id' => $_SESSION['user']['id'],];
        $this->db->executeQuery($query, $param);
        $this->logout();
        $this->setAnswer('Your account has been deleted.', true);
        return true;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
        $this->setAnswer('You are now logged out.', true);
    }

}

?>
