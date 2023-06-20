<?php

class CHECKER
{
    const PASSWORD_ERROR_MSG = 'Password is not valid';
    const PASSWORD_REGEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    const NAME_REGEX = '/^[a-zA-Z0-9_]{3,20}$/';
    public array $answer;


    public function checkLogin(array $userInfos): bool
    {
        $loginValid = true;
        if (!isset($userInfos['email']) || !isset($userInfos['password'])) {
            $this->setAnswer('Please fill in all fields.');
            $loginValid = false;
        } elseif (!$this->checkEmail($userInfos['email'])) {
            $this->setAnswer('Email is not valid.');
            $loginValid = false;
        } elseif (!$this->checkPassword($userInfos['password'])) {
            $this->setAnswer(self::PASSWORD_ERROR_MSG);
            $loginValid = false;
        }
        return $loginValid;
    }

    private function setAnswer(string $msg): void
    {
        $this->answer = ['msg' => $msg, 'success' => false];
    }

    private function checkEmail(string $email): bool
    {
        if ($this->checkInput($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    private function checkInput($input): bool
    {
        if (isset($input) && !empty($input)) {
            return true;
        }
        return false;
    }

    private function checkPassword(string $password, string $confirmPassword = ''): bool
    {
        $passwordLengthGood = (strlen($password) >= 8 && strlen($password) <= 25);
        $passwordRegexGood = preg_match(self::PASSWORD_REGEX, $password);
        $passwordsMatch = ($password === $confirmPassword);
        if (!empty($confirmPassword)) {
            if ($this->checkInput($password) && $passwordLengthGood && $passwordRegexGood && $passwordsMatch) {
                return true;
            }
        } elseif ($this->checkInput($password) && $passwordLengthGood && $passwordRegexGood) {
            return true;
        }
        $this->setAnswer(self::PASSWORD_ERROR_MSG);
        return false;
    }

    public function checkGetUser(array $userInfos): bool
    {
        if (!isset($userInfos['tag'])) {
            $this->setAnswer('Please send a tag.');
            return false;
        }
        if (!$this->checkTag($userInfos['tag'])) {
            $this->setAnswer('Tag is not valid.');
            return false;
        }
        return true;
    }

    private function checkTag(string $tag): bool
    {
        $tagClean = str_replace('@', '', $tag);
        $tagSizeValid = (strlen($tagClean) >= 5 && strlen($tagClean) <= 20);
        $tagValid = str_contains($tag, '@');
        if ($this->checkInput($tag) && preg_match(self::NAME_REGEX, $tagClean) && $tagSizeValid && $tagValid) {
            return true;
        }
        return false;
    }

    public function checkUpdateProfile(array $userInfos): bool
    {
        $checkUpdateProfileValid = true;
        foreach ($userInfos as $key => $info) {
            switch ($key) {
                case 'name':
                    if (!$this->checkName($info)) {
                        $this->setAnswer('Name is not valid.');
                        $checkUpdateProfileValid = false;
                    }
                    break;
                case 'birthdate':
                    if (!$this->checkBirthdate($info)) {
                        $this->setAnswer('Birthdate is not valid.');
                        $checkUpdateProfileValid = false;
                    }
                    break;
                case 'bio':
                    if (!$this->checkBio($info)) {
                        $this->setAnswer('Bio is not valid.');
                        $checkUpdateProfileValid = false;
                    }
                    break;
                case 'password':
                    $issetConfirmPassword = isset($userInfos['confirmPassword']);
                    if ($issetConfirmPassword && !$this->checkPassword($info, $userInfos['confirmPassword'])) {
                        $this->setAnswer(self::PASSWORD_ERROR_MSG);
                        $checkUpdateProfileValid = false;
                    }
                    break;
                case 'tag':
                    if (!$this->checkTag($info)) {
                        $this->setAnswer('Tag is not valid.');
                        $checkUpdateProfileValid = false;
                    }
                    break;
            }
        }
        return $checkUpdateProfileValid;
    }

    private function checkName(string $name): bool
    {
        $nameSizeValid = (strlen($name) >= 5 && strlen($name) <= 20);
        if ($this->checkInput($name) && preg_match(self::NAME_REGEX, $name) && $nameSizeValid) {
            return true;
        }
        return false;
    }

    private function checkBirthdate(string $birthdate): bool
    {
        $todayDate = date('Y-m-d');
        $birthdate = date('Y-m-d', strtotime($birthdate));
        $birthdateIsBeforeToday = ($birthdate < $todayDate);
        if ($this->checkInput($birthdate) && $birthdateIsBeforeToday) {
            return true;
        }
        return false;
    }

    private function checkBio(string $bio): bool
    {
        if ($this->checkInput($bio) && strlen($bio) <= 140) {
            return true;
        }
        return false;
    }

    public function checkRegister(array $userInfos): bool
    {
        $emailSet = isset($userInfos['email']);
        $nameSet = isset($userInfos['name']);
        $birthdateSet = isset($userInfos['birthdate']);
        $passwordSet = isset($userInfos['password']);
        $confirmPasswordSet = isset($userInfos['confirmPassword']);
        $registerValid = true;
        if (!$emailSet || !$nameSet || !$birthdateSet || !$passwordSet || !$confirmPasswordSet) {
            $this->setAnswer('Please fill in all fields.');
            $registerValid = false;
        } elseif (!$this->checkEmail($userInfos['email'])) {
            $this->setAnswer('Email is not valid.');
            $registerValid = false;
        } elseif (!$this->checkPassword($userInfos['password'], $userInfos['confirmPassword'])) {
            $this->setAnswer(self::PASSWORD_ERROR_MSG);
            $registerValid = false;
        } elseif (!$this->checkName($userInfos['name'])) {
            $this->setAnswer('Name is not valid.');
            $registerValid = false;
        } elseif (!$this->checkBirthdate($userInfos['birthdate'])) {
            $this->setAnswer('Birthdate is not valid.');
            $registerValid = false;
        }
        return $registerValid;
    }

    public function checkFollows(array $values): bool
    {
        $tagSet = isset($values['tag']);
        if (!$tagSet || !$this->checkTag($values['tag'])) {
            $this->setAnswer('Tag is not valid.');
            return false;
        }
        return true;
    }

    private function checkTweet(string $tweet): bool
    {
        if ($this->checkInput($tweet) && strlen($this->$tweet) <= 140) {
            return true;
        }
        return false;
    }

    private function checkMessage(string $message): bool
    {
        if ($this->checkInput($message) && strlen($message) <= 140) {
            return true;
        }
        return false;
    }
}

?>
