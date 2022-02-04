<?php
class RegisterController 
{
    private $dbConn; 

    public function __construct($dbConnection)
    {
        $this->dbConn = $dbConnection;
    }

    public function register()
    {
        $input = Request::getInput();

        $sql = "INSERT INTO users
            (name, lastname, email, rol_id, rol, password)
            VALUES
            (:name, :lastname, :email, :rol_id, :rol, :password )";

        $statement = $this->dbConn->prepare($sql);
        DatabaseConnection::bindAllValues($statement, $input);
        $statement->execute();
        $userId = $this->dbConn->lastInsertId();

        if($userId){
            $input['id'] = $userId;
            header("HTTP/1.1 200 OK");
            echo json_encode($input);
            exit();
        }

    }

}
