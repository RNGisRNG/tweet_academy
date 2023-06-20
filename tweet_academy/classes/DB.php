<?php

class DB
{
    private PDO $db;
    private string $host;
    private string $dbName;
    private string $dbType;
    private string $login;
    private string $password;

    public function __construct(string $dbName = 'common-database', string $host = 'localhost', $login = 'root', $password = 'root', string $dbType = 'mysql')
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->dbType = $dbType;
        $this->login = $login;
        $this->password = $password;
    }

    public function executeQuery(string $query, array $param = null): array
    {
        $this->connectToDb();
        try {
            $stmt = $this->db->prepare($query);
            if ($param === null) {
                $stmt->execute();
            } else {
                $stmt->execute($param);
            }
            return $stmt->fetchAll();
        } catch (PDOException $err) {
            echo $err->getMessage();
            exit();
        }
    }

    private
    function connectToDb(): void
    {
        if (!isset($this->db)) {
            $connection = $this->dbType . ":host=" . $this->host . ";dbname=" . $this->dbName;
            try {
                $this->db = new PDO($connection, $this->login, $this->password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $err) {
                echo $err;
            }
        }
    }
}

?>
