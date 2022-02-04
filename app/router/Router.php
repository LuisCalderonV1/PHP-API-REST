<?php

class Router{

    private $db;
    private $requestMethod;
    private $id;
    private $controller;

    public function __construct($dbConnection, $requestMethod, $id, $controllerName)
    {
        $this->db = $dbConnection;
        $this->id = $id;
        $this->requestMethod = $requestMethod;
        $this->controller = new $controllerName($this->db);
    }
    
    public function processRequest()
    {
        //auth
        if($this->requestMethod === 'POST'){
            if(get_class($this->controller)  === 'LoginController'){
                $response = $this->controller->login();
            }
            if(get_class($this->controller)  === 'RegisterController'){
                $response = $this->controller->register();
            }
        }
        //standard API methods
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->id) {
                    $response = $this->controller->find($this->id);
                } else {
                    $response = $this->controller->index();
                };
                break;
            case 'POST':
                $response = $this->controller->store($controllerName);
                break;
            case 'PUT':
                $response = $this->controller->update($this->id);
                break;
            case 'DELETE':
                $response = $this->controller->delete($this->id);
                break;    
            default:
                $response = $this->notFoundResponse();
        }
    }

    public function notFoundResponse(){
        header("HTTP/1.1 404 Not Found");
            echo json_encode(['name' => 'Not Found', 'details' => ['issue' => 'INVALID_REQUEST',
            'description'=> 'Your request can not be processed']]);
    }

}