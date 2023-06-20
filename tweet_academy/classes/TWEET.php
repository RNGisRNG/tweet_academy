<?php
include_once 'DB.php';
include_once 'BASE.php';
include_once 'HASHTAG.php';

class TWEET extends BASE
{
    private const AUTHOR_ID = ':authorID';
    private const TWEET_CONTENT = ':tweetContent';
    private const SENT_AT = ':sentAt';
    private string $author;

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user']['id'])) {
            throw new InvalidArgumentException('Session not set.');
        }
        $this->author = $_SESSION['user']['id'];
    }

    public function getTweets(): bool
    {
        try {
            $query = "SELECT t.tweetContent, t.sentAt, u.tag authorTag, u.name authorName FROM tweet t
                      join user u on u.id = t.authorID
                      WHERE t.authorID = :authorID AND t.deleted = 0 ORDER BY sentAt DESC";
            $param = [self::AUTHOR_ID => $this->author];
            $result = $this->cleanResult($this->db->executeQuery($query, $param));
            if (empty($result)) {
                $this->setAnswer('No tweets.', false);
                return false;
            }
            $this->setAnswer('Tweets retrieved.', true, $result);
            return true;
        } catch (Exception $e) {
            $this->setAnswer("Tweets not retrieved. Error: $e", false);
            return false;
        }
    }


    public function sendTweet(): bool
    {
        try {
            $content = $_POST['tweetContent'];
            $hashtags = $this->getHashtags($content);
            $now = date(self::DATE_TIME_FORMAT);
            $query = "INSERT INTO tweet (authorID, tweetContent, sentAt)
                  VALUES (:authorID, :tweetContent, :sentAt)";
            $param = [self::AUTHOR_ID => $_SESSION['user']['id'],
                      self::TWEET_CONTENT => $content,
                      self::SENT_AT => $now];
            $this->db->executeQuery($query, $param);
            $query = "SELECT id from tweet
                      WHERE authorID = :authorID AND tweetContent = :tweetContent AND sentAt = :sentAt";
            $result = $this->db->executeQuery($query, $param);
            $this->sendHashtags($hashtags, $result[0]['id']);
            $this->setAnswer('Tweet sent.', true);
            return true;
        } catch (Exception $e) {
            $this->setAnswer("Tweet not sent. Error: $e", false);
            return false;
        }
    }

    private function getHashTags($content): array
    {
        $hashtags = [];
        $content = explode(' ', $content);
        foreach ($content as $word) {
            if (str_starts_with($word, '#')) {
                $hashtags[] = substr($word, 1);
            }
        }
        return $hashtags;
    }

    private function sendHashtags($hashtags, $tweetID): void
    {
        foreach ($hashtags as $hashtag) {
            try {
                $hashtag = new HASHTAG($hashtag);
                $hashtag->sendHashtag($tweetID);
            } catch (Exception $e) {
                $this->setAnswer("Hashtag not sent. Error: $e", false);
            }
        }
    }

    public function sendComment(): bool
    {
        try {
            $content = $_POST['commentContent'];
            $query = "INSERT INTO tweet (authorID, answersTo, tweetContent, sentAt)
                  VALUES (:authorID, :tweetID, :commentContent, :sentAt)";
            $param = [self::AUTHOR_ID => $_SESSION['user']['id'],
                      ':tweetID' => $this->getTweetID($_POST['tweetContent'], $_POST['sentAt'], $_POST['tweetAuthor']),
                      ':commentContent' => $content,
                      self::SENT_AT => date(self::DATE_TIME_FORMAT)];
            $this->db->executeQuery($query, $param);
            $this->setAnswer('Comment sent.', true);
            return true;
        } catch (Exception $e) {
            $this->setAnswer("Comment not sent. Error: $e", false);
            return false;
        }
    }

    private function getTweetID($content, $date, $author)
    {
        try {
            $query = "SELECT id FROM tweet
                      WHERE tweetContent = :tweetContent AND sentAt = :sentAt AND authorID = :authorID";
            $param = [':tweetContent' => $content, ':sentAt' => $date, ':authorID' => $this->getUserID($author)];
            $result = $this->db->executeQuery($query, $param);
            if (empty($result)) {
                $this->setAnswer('Tweet does not exist.', false);
                return false;
            }
            return $result[0]['id'];
        } catch (Exception $e) {
            $this->setAnswer("Tweet not found. Error: $e", false);
            return false;
        }
    }

    public function getTweetsByFollowed(): array
    {
        $followedIDs = $this->getFollowedUsers();
        if (empty($followedIDs)) {
            return [];
        }
        $query = "SELECT t.tweetContent, t.sentAt, t.updatedAt,
                  u.tag `authorTag`, u.name `authorName`
                  FROM tweet t join user u on t.authorID = u.id
                  WHERE authorID IN (";
        $param = [];
        foreach ($followedIDs as $key => $followedID) {
            $query .= ":followedID$key,";
            $param[":followedID$key"] = $followedID['targetID'];
        }
        $query = substr($query, 0, -1);
        $query .= ") AND answersTo IS NULL AND t.deleted = false ORDER BY sentAt DESC";
        $result = $this->cleanResult($this->db->executeQuery($query, $param));
        $this->setAnswer('Tweets retrieved.', true, $result);
        return [];

    }

    private function getFollowedUsers(): array
    {
        try {
            $query = "SELECT targetID FROM follow WHERE userID = :userID";
            $param = [':userID' => $this->author];
            $result = $this->cleanResult($this->db->executeQuery($query, $param));
            if (empty($result)) {
                $this->setAnswer('No followed users.', false);
                return [];
            }
            return $this->cleanResult($result);
        } catch (Exception $e) {
            $this->setAnswer("Followed users not retrieved. Error: $e", false);
            return [];
        }
    }

    public function getUserTweets(array $values): bool
    {
        try {
            $query = "SELECT t.tweetContent, t.sentAt, t.updatedAt,
                      u.tag `authorTag`, u.name `authorName`
                      FROM tweet t join user u on t.authorID = u.id
                      WHERE authorID = :authorID AND answersTo IS NULL AND t.deleted = false ORDER BY sentAt DESC";
            $param = [self::AUTHOR_ID => $this->getUserID($values['tag'])];
            $result = $this->cleanResult($this->db->executeQuery($query, $param));
            if (empty($result)) {
                $this->setAnswer('No tweets.', false);
                return false;
            }
            $this->setAnswer('Tweets retrieved.', true, $result);
            return true;
        } catch (Exception $e) {
            $this->setAnswer("Tweets not retrieved. Error: $e", false);
            return false;
        }
    }
}

?>
