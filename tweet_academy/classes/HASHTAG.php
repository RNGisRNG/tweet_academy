<?php

include_once 'DB.php';

class HASHTAG
{
    private const HASHTAG = ':hashtag';
    private const TWEET_ID = ':tweetID';

    private string $hashtag;
    private DB $db;

    public function __construct(string $hashtag)
    {
        $this->hashtag = $hashtag;
        $this->db = new DB();
    }

    public function sendHashtag($tweetID): void
    {
        if (!$this->checkDBHashtagExists()) {
            $this->addHashtag();
        }
        $this->addTweetHashtag($tweetID);
    }

    private function checkDBHashtagExists(): bool
    {
        try {
            $query = "SELECT * FROM hashtag WHERE name = :hashtag";
            $param = [self::HASHTAG => $this->hashtag];
            $result = $this->db->executeQuery($query, $param);
            return !empty($result);
        } catch (PDOException $e) {
            throw new PDOException("Hashtag not checked. Error: $e");
        }
    }

    private function addHashtag(): void
    {
        try {
            $query = "INSERT INTO hashtag (name) VALUES (:hashtag)";
            $param = [self::HASHTAG => $this->hashtag];
            $this->db->executeQuery($query, $param);
        } catch (PDOException $e) {
            throw new PDOException("Hashtag not added. Error: $e");
        }
    }

    private function addTweetHashtag($tweetID): void
    {
        try {
            $query = "SELECT id FROM hashtag WHERE name = :hashtag";
            $param = [self::HASHTAG => $this->hashtag];
            $result = $this->db->executeQuery($query, $param);
            $hashtagID = $result[0]['id'];
        } catch (PDOException $e) {
            throw new PDOException("Hashtag not added. Error: $e");
        }
    }

}