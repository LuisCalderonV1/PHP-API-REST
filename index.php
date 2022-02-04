<?php
require "app/bootstrap/bootstrap.php";
header_remove('Set-Cookie');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// all of our endpoints start with /post
// everything else results in a 404 Not Found
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ( isset($uri[3]) && !in_array($uri[3], $routes) || !isset($uri[3]) ) {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(['name' => 'Not Found', 'details' => ['issue' => 'ROUTE_NOT_FOUND',
            'description'=> 'The requested route was not found']]);
    exit();
}

$controllerName = ucFirst($uri[3] . 'Controller');

$id = null;

if ( isset($uri[4]) ){
    $id = (int)$uri[4];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and user ID to the PersonController and process the HTTP request:
$router = new Router($dbConnection, $requestMethod, $id, $controllerName);
$router->processRequest();
