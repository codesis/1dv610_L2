<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$r = new RegisterView();
$dtv = new DateTimeView();
$lv = new LayoutView();

session_start();
if (isset($_SESSION['HTTP_USER_AGENT'])) {
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
      session_unset();
    }
  } else {
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
  }
  

$v->login();
if (isset($_SESSION['username'])) {
    $lv->render(true, $v, $dtv, $r);
    } else {
    $lv->render(false, $v, $dtv, $r);
}

