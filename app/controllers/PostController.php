<?php
class PostController 
{
    private $dbConn; 
    private $middleware;
    const ACCESS_BASICO = 1;
    const ACCESS_MEDIO = 2;
    const ACCESS_MEDIO_ALTO = 3;
    const ACCESS_ALTO_MEDIO = 4;
    const ACCESS_ALTO = 5;

    public function __construct($dbConnection)
    {
        $this->dbConn = $dbConnection;
        $this->middleware = New Middleware;
    }

    public function index()
    {
        $this->middleware->checkAccess(['min_required' => self::ACCESS_BASICO]);

        $sql = $this->dbConn->prepare("SELECT posts.id,title,status,content,created_at,email as username FROM posts INNER JOIN users on posts.user_id = users.id");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode( $sql->fetchAll()  );
        exit();
    }

    public function find($postId)
    {
        $this->middleware->checkAccess(['min_required' => self::ACCESS_MEDIO]);
        $sql = $this->dbConn->prepare("SELECT posts.id,title,status,content,created_at,email as username FROM posts INNER JOIN users on posts.user_id = users.id where posts.id=:id");
        $sql->bindValue(':id', $postId);
        $sql->execute();
      
        if($sql->rowCount() > 0){
            header("HTTP/1.1 200 OK");
            echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
        }
        else{
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['name' => 'Not Found', 'details' => ['issue' => 'INVALID_RESOURCE_ID',
            'description'=> 'Specified resource ID does not exist. Please check the resource ID and try again.']]);
        }
        exit();
    }

    public function store()
    {
        $this->middleware->checkAccess(['min_required' => self::ACCESS_MEDIO_ALTO]);
        $input = Request::getInput();

        $sql = "INSERT INTO posts
            (title, status, content, user_id)
            VALUES
            (:title, :status, :content, :user_id)";

        $statement = $this->dbConn->prepare($sql);
        DatabaseConnection::bindAllValues($statement, $input);

        $token = Request::getBearerToken();
        $user_id = Auth::getData($token)->id;

        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $postId = $this->dbConn->lastInsertId();

        if($postId){
            $input['id'] = $postId;
            header("HTTP/1.1 200 OK");
            echo json_encode($input);
            exit();
        }
    }

    public function update($postId){
        $this->middleware->checkAccess(['min_required' => self::ACCESS_ALTO_MEDIO]);
        $input = Request::getInput();
        $fields = Request::getParams();
        
        $sql = "
            UPDATE posts
            SET $fields
            WHERE id='$postId'
            ";
        $statement = $this->dbConn->prepare($sql);
        DatabaseConnection::bindAllValues($statement, $input);
        $statement->execute();
        header("HTTP/1.1 200 OK");
        echo json_encode(['name' => 'Success', 'details' => ['action' => 'Update',
        'description'=> 'Specified resource was updated succefully', 'id resource' => $postId]]);
        exit();
    }

    public function delete($postId){
        $this->middleware->checkAccess(['min_required' => self::ACCESS_ALTO]);
        $statement = $this->dbConn->prepare("DELETE FROM posts where id=:id");
        $statement->bindValue(':id', $postId);
        $statement->execute();
        header("HTTP/1.1 200 OK");
        echo json_encode(['name' => 'Success', 'details' => ['action' => 'Delete',
        'description'=> 'Specified resource was deleted succefully']]);
        exit();
    }
}
