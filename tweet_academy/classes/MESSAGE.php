<?php
include_once 'DB.php';
include_once 'BASE.php';

class MESSAGE extends BASE
{
    private const ID = ':id';
    private const AUTHOR_ID = ':authorID';
    private const TARGET_ID = ':targetID';
    private const MSG_CONTENT = ':msgContent';
    private const SENT_AT = ':sentAt';
    private string $target;
    private string $author;
    private array $requestValues;

    public function __construct(array $requestValues = [])
    {
        parent::__construct();
        if (!isset($_SESSION['user']['id'])) {
            throw new InvalidArgumentException('Session not set.');
        }
        $this->author = $_SESSION['user']['id'];
        $this->requestValues = $requestValues;
    }

    public function getMessages(): bool
    {
        $query = "SELECT ua.tag as author, ut.tag as target, m.msgContent content, m.sentAt date
                  FROM message m
                  join user ua on m.authorID = ua.id
                  join user ut on m.targetID = ut.id
                  WHERE (authorID = :authorID AND targetID = :targetID)
                  OR (authorID = :targetID AND targetID = :authorID) ORDER BY sentAt";
        $param = [self::AUTHOR_ID => $this->author,
                  self::TARGET_ID => $this->getUserID($this->requestValues['target'])];
        $result = $this->db->executeQuery($query, $param);
        if (empty($result)) {
            $this->setAnswer('No messages.', true);
            return true;
        }
        $this->setAnswer('Messages retrieved.', true, $result);
        return true;
    }

    public function getUserConversations(): bool
    {
        try {
            $query = "SELECT u.tag as target from message m
                    join user u on m.targetID = u.id
                    WHERE (authorID = :authorID AND targetID != :authorID)
                    OR (targetID = :authorID AND authorID != :authorID)
                    GROUP BY target";
            $param = [self::AUTHOR_ID => $this->author];
            $result = $this->cleanResult($this->db->executeQuery($query, $param));
            for ($i = 0; $i < count($result); ++$i) {
                if ($result[$i]['target'] === $_SESSION['user']['tag']) {
                    unset($result[$i]);
                }
            }
            if (empty($result)) {
                $this->setAnswer('No conversations.', false);
                return true;
            }
            $this->setAnswer('Conversations retrieved.', true, $result);
            return true;
        } catch (Exception $e) {
            $this->setAnswer($e->getMessage(), false);
            return false;
        }
    }

    public function sendMessage(): bool
    {
        $query = "INSERT INTO message (authorID, targetID, msgContent, sentAt)
                  VALUES (:authorID, :targetID, :msgContent, :sentAt)";
        $targetId = $this->getUserID($this->requestValues['target']);
        if (!$targetId) {
            return false;
        }
        $param = [self::AUTHOR_ID => $this->author,
                  self::TARGET_ID => $targetId,
                  self::MSG_CONTENT => $this->requestValues['msgContent'],
                  self::SENT_AT => date(self::DATE_TIME_FORMAT)];
        $result = $this->db->executeQuery($query, $param);
        $this->setAnswer('Message sent.', true, $result);
        return true;
    }
}

?>
