<?php
include_once "../scripts/global/handleErrors.php";
include_once 'USER.php';
include_once 'BASE.php';
include_once 'MESSAGE.php';
include_once 'TWEET.php';
include_once 'CHECKER.php';

class CONTROLLER
{
    private string $action;
    private USER $user;
    private TWEET $tweet;
    private MESSAGE $message;
    private CHECKER $checker;
    private array $values;
    private array $controllerValues = [
        'login' => 'login',
        'register' => 'register',
        'logout' => 'logout',
        'delete_user' => 'deleteUser',
        'get_tweets' => 'getTweets',
        'get_tweets_from_followers' => 'getTweetsFromFollowers',
        'update_profile' => 'updateProfile',
        'send_message' => 'sendMessage',
        'get_messages' => 'getMessages',
        'get_user' => 'getUser',
        'follow_user' => 'followUser',
        'unfollow_user' => 'unfollowUser',
        'search_user' => 'searchUser',
        'send_tweet' => 'sendTweet',
        'get_num_followers' => 'getNumFollowers',
        'get_num_following' => 'getNumFollowing',
        'get_num_tweets' => 'getNumTweets',
        'get_followers' => 'getFollowers',
        'get_following' => 'getFollowing',
        'get_user_tweets' => 'getUserTweets',
        'get_user_info' => 'getUserInfo',
        'get_user_conversations' => 'getUserConversations',
    ];

    public function __construct()
    {
        $this->checker = new CHECKER();
        $this->getAction();
    }

    private function getAction(): void
    {
        if (isset($_GET['action'])) {
            $this->action = filter_input(INPUT_GET, 'action');
            $this->values = filter_input_array(INPUT_GET);
            unset($this->values['action']);
        } elseif (isset($_POST['action'])) {
            $this->action = filter_input(INPUT_POST, 'action');
            $this->values = filter_input_array(INPUT_POST);
            unset($this->values['action']);
        } else {
            throw new InvalidArgumentException(json_encode(['msg' => 'No action set', 'success' => false]));
        }
    }

    public function handleRequest(): void
    {
        if (isset($this->controllerValues[$this->action])) {
            $function = $this->controllerValues[$this->action];
            $this->$function();
        } else {
            throw new InvalidArgumentException(json_encode(['msg' => 'This action is invalid', 'success' => false]));
        }
    }

    private function login(): void
    {
        try {
            if (!$this->checker->checkLogin($this->values)) {
                throw new InvalidArgumentException(json_encode($this->checker->answer));
            }
            $this->user = new USER($this->values);
            $this->user->login();
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function handleResponse($class): void
    {
        echo json_encode($class->answer);
    }

    private function register(): void
    {
        try {
            if (!$this->checker->checkRegister($this->values)) {
                throw new InvalidArgumentException(json_encode($this->checker->answer));
            }
            $this->user = new USER($this->values);
            $this->user->register();
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getUser(): void
    {
        try {
            if (!$this->checker->checkGetUser($this->values)) {
                throw new InvalidArgumentException(json_encode($this->checker->answer));
            }
            $this->user = new USER($this->values);
            echo json_encode($this->user->getUserValues());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function updateProfile(): void
    {
        try {
            if (!$this->checker->checkUpdateProfile($this->values)) {
                throw new InvalidArgumentException(json_encode($this->checker->answer));
            }
            $this->user = new USER($this->values);
            $this->user->updateProfile();
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function sendMessage(): void
    {
        try {
            $this->message = new MESSAGE($this->values);
            $this->message->sendMessage();
            $this->handleResponse($this->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getMessages(): void
    {
        try {
            $this->message = new MESSAGE($this->values);
            $this->message->getMessages();
            $this->handleResponse($this->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function followUser(): void
    {
        try {
            if (!$this->checker->checkFollows($this->values)) {
                throw new InvalidArgumentException(json_encode($this->checker->answer));
            }
            $this->user = new USER($this->values);
            $this->user->followUser();
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function unfollowUser(): void
    {
        try {
            if (!$this->checker->checkFollows($this->values)) {
                throw new InvalidArgumentException(json_encode($this->checker->answer));
            }
            $this->user = new USER($this->values);
            $this->user->unfollowUser();
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function searchUser(): void
    {
        try {
            $this->user = new USER();
            $this->user->searchUser($this->values['search']);
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function sendTweet(): void
    {
        try {
            $this->tweet = new TWEET();
            $this->tweet->sendTweet();
            $this->handleResponse($this->tweet);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getTweets(): void
    {
        try {
            $this->tweet = new TWEET();
            $this->tweet->getTweets();
            $this->handleResponse($this->tweet);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getTweetsFromFollowers(): void
    {
        try {
            $this->tweet = new TWEET();
            $this->tweet->getTweetsByFollowed();
            $this->handleResponse($this->tweet);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function sendComment(): void
    {
        try {
            $this->tweet = new TWEET();
            $this->tweet->sendComment();
            $this->handleResponse($this->tweet);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getNumFollowers(): void
    {
        try {
            $this->user = new USER();
            $this->user->getNumFollowers();
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function logout(): void
    {
        try {
            $this->user = new USER();
            $this->user->logout();
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getUserConversations(): void
    {
        try {
            $this->message = new MESSAGE();
            $this->message->getUserConversations();
            $this->handleResponse($this->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getUserTweets(): void
    {
        try {
            $this->tweet = new TWEET();
            $this->tweet->getUserTweets($this->values);
            $this->handleResponse($this->tweet);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function deleteUser(): void
    {
        try {
            $this->user = new USER();
            $this->user->deleteUser();
            $this->handleResponse($this->user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

?>
