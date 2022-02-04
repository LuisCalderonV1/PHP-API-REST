<?php
class DataBaseConnection 
{
    private $dbConnection = null;

    public function __construct($db)
    {
        try {
            $this->dbConnection = new PDO("mysql:host={$db['host']};dbname={$db['db']};charset=utf8", $db['username'], $db['password']);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    public static function bindAllValues($statement, $params)
    {
        foreach($params as $param => $value)
        {
            $statement->bindValue(':'.$param, $value);
        }
        return $statement;
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}
