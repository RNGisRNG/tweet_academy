<?php
include_once 'DB.php';

class BASE
{
    protected const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
    public array $answer;
    protected DB $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    protected function cleanResult(array $array): array
    {
        foreach ($array as $elem => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $item) {
                    if (is_int($key)) {
                        unset($array[$elem][$key]);
                    }
                }
            } else {
                if (is_int($elem)) {
                    unset($array[$elem]);
                }
            }
        }
        return $array;
    }

    protected function getUserID($tag): int
    {
        $query = "SELECT id FROM user WHERE tag = :tag";
        $param = [':tag' => $tag];
        $result = $this->db->executeQuery($query, $param);
        if (empty($result)) {
            $this->setAnswer('User does not exist.', false);
            return false;
        }
        return $result[0]['id'];
    }

    protected function setAnswer(string $message, bool $status, array $data = []): void
    {
        $this->answer['msg'] = $message;
        $this->answer['success'] = $status;
        if (!empty($data)) {
            $this->answer['data'] = $data;
        }
    }
}

?>
