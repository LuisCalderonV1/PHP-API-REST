<?php 
// include main configuration file
DEFINE('BASE_URI', $_SERVER["DOCUMENT_ROOT"] . '/blog/');

require(BASE_URI . "app/config/config.php");

require(BASE_URI . "app/controllers/PostController.php");

require(BASE_URI . "app/controllers/auth/RegisterController.php");

require(BASE_URI . "app/controllers/auth/LoginController.php");

require(BASE_URI . "app/libraries/Auth.php");

require(BASE_URI . "app/router/Router.php");

require(BASE_URI . "app/database/DatabaseConnection.php");

require(BASE_URI . "app/middlewares/Middleware.php");

require(BASE_URI . "app/request/Request.php");

require_once (BASE_URI . 'vendor/autoload.php');

$dbConnection = (new DatabaseConnection($db))->getConnection();