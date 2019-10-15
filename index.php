<?php
ini_set('session.cookie_lifetime', 0);
session_start();

//INCLUDE THE FILES NEEDED...
include 'settings/settings.php';
require_once('controller/AppController.php');
require_once('model/Database.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$dbName = getenv('dbName');
$dbPassword = getenv('dbPassword');
$dbServer = getenv('dbServer');
$dbUsername = getenv('dbUsername');

$database = new \model\Database($dbServer, $dbName, $dbUsername, $dbPassword);

$appController = new \controller\AppController($database);
$appController->route();
