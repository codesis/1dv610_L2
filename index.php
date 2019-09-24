<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
// require_once('view/RegisterView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
// $r = new RegisterView();
$dtv = new DateTimeView();
$lv = new LayoutView();

ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
session_start();
setcookie('PHPSESSID', '', 0, '/; samesite=strict');

$v->login();
if (isset($_SESSION['username'])) {
        $lv->render(true, $v, $dtv);
    } else {
        $lv->render(false, $v, $dtv);
}

