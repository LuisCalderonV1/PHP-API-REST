<?php
class LoginController 
{
    private $dbConn; 

    public function __construct($dbConnection)
    {
        $this->dbConn = $dbConnection;
    }

    public function login()
    {
      $input = Request::getInput();
      $sql = $this->dbConn->prepare("SELECT * FROM users where email=:email AND password=:password");
      $sql->bindValue(':email', $input['email']);
      $sql->bindValue(':password', $input['password']);
      $sql->execute();
      
        if($sql->rowCount() > 0){
            header("HTTP/1.1 200 OK");
            $user = $sql->fetch(PDO::FETCH_ASSOC);
            $token = Auth::SignIn([
                'id' => $user['id'],
                'user' => $user['email'],
                'rol_id' => $user['rol_id']
            ]);
            echo json_encode(['name' => 'Success', 'details' => ['action' => 'Login',
            'description'=> 'Logged in succefully as ' . $user['email']], 'token' => $token,] );
        }
        else{
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['name' => 'Bad Credentials', 'details' => ['issue' => 'INVALID_CREDENTIALS',
            'description'=> 'Specified username-password does not match. Please check and try again.']]);
        }
        exit();
    }

}
