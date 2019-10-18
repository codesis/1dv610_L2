<?php

namespace controller;

require_once('LoginController.php');
require_once('RegistrationController.php');
require_once('./model/Database.php');
require_once('./view/DateTimeView.php');
require_once('./view/LayoutView.php');
require_once('./view/MessageView.php');
require_once('./view/LoginView.php');
require_once('./view/RegisterView.php');
require_once('./view/CookiesView.php');

class AppController {
    private $isLoggedIn = false;
    
    private $loginController;
    private $dateTimeView;
    private $layoutView;
    private $messageView;
    private $loginView;
    private $registerView;
    private $cookieView;

    private $message;
    private $renderLogin = false;
    
    public function __construct ($database) {
        $this->dateTimeView = new \view\DateTimeView();
        $this->layoutView = new \view\LayoutView();
        $this->messageView = new \view\MessageView();
        $this->loginView = new \view\LoginView();
        $this->registerView = new \view\RegisterView();
        $this->cookieView = new \view\CookiesView();

        $this->loginController = new \controller\LoginController($this->loginView, $this->messageView, $this->cookieView, $database);
        $this->registrationController = new \controller\RegistrationController($this->registerView, $this->messageView, $database);

        $this->username = $this->registerView->getUsername();
        $this->password = $this->registerView->getPassword();
    }

    public function route () {
        if ($this->registerView->renderRegisterPage()) {
            $this->register();           
        } else {
            $this->checkIfNewUser();
        }
    }

    private function checkIfNewUser () {
        if ($this->cookieView->getNewUserCookie()) {
            $this->welcomeNewUser();
        } else {
            $this->checkLoggedInStatus();
            $this->login();    
        }
    }

    private function welcomeNewUser () {
        $this->loginController->setNewUsernameToForm();
        $this->message = $this->loginController->getMessage();    

        $response = $this->loginView->response($this->isLoggedIn, $this->message);
        $this->layoutView->render($this->isLoggedIn, $this->loginView, $this->dateTimeView, $this->message, $response);    
    }

    private function register () {
        if ($this->registerView->registerNewUser()) {
            $this->registrationController->registerNewUser();
            $this->checkNewUserBool();
        }
        $this->redirectNewUser();
    }

    private function checkNewUserBool () {
        if ($this->registrationController->getNewUserBool()) {
            $this->renderLogin = true;
        } else {
        $this->message = $this->registrationController->getMessage();
        }
    }

    private function redirectNewUser () {
        if ($this->renderLogin) {
            $this->loginView->loginPageRedirect();
        } else {
            $this->registerResponse();
        }
    }

    private function registerResponse () {
        $response = $this->registerView->response($this->message);
        $this->layoutView->render($this->isLoggedIn, $this->loginView, $this->dateTimeView, $this->message, $response);
        $this->message = $this->registrationController->getMessage();
    }

    private function checkLoggedInStatus () {
        if ($this->cookieView->getLoggedInStatus()) {
            $this->isLoggedIn = $this->cookieView->getLoggedInCookie();
        }
        if ($this->logout());
    }

    private function login () {
        if ($this->loginView->login()) {   
            $this->isLoggedIn = $this->loginController->login();
            $this->message = $this->loginController->getMessage();

        }
        $this->loginResponse();
    }

    private function logout () {
        if ($this->loginView->logOut()) {
            $this->isLoggedIn = $this->loginController->logout();
            $this->message = $this->loginController->getMessage();
        }
    }

    private function loginResponse () {
        $response = $this->loginView->response($this->isLoggedIn, $this->message);
        $this->layoutView->render($this->isLoggedIn, $this->loginView, $this->dateTimeView, $this->message, $response);
    }
}
