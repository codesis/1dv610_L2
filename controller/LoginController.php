<?php

namespace controller;

require_once('./view/LoginView.php');
require_once('./view/CookiesView.php');
require_once('./view/MessageView.php');
require_once('./model/Database.php');

class LoginController {
    private $loginView;
    private $cookieView;
    private $username;
    private $usernameExist;
    private $passwordExist;
    private $password;
    private $messageView;
    private $message;
    private $database;

    private $isLoggedIn = false;

    public function __construct (\view\LoginView $loginView, \view\MessageView $messageView, \model\Database $database) {
        $this->loginView = $loginView;
        $this->username = $this->loginView->getUsername();
        $this->usernameExist = $this->loginView->usernameFilledIn();
        $this->passwordExist = $this->loginView->passwordFilledIn();
        $this->password = $this->loginView->getPassword();

        $this->messageView = $messageView;

        // $this->cookieView = $cookieView;
        $this->database = $database;

        $this->database->connectToDatabase();
    }

    public function login () {
        $this->checkLoginCredentials();
        $this->verifiedLoginCredentials();

        return $this->isLoggedIn;
    }

    private function verifiedLoginCredentials () {
		if ($this->database->checkIfUserExist($this->username, $this->password)) {
            if ($this->loginView->keepUserLoggedIn()) {
                $this->message = $this->messageView->welcomeCookiesMessage();
            } else {
                $this->message = $this->messageView->welcomeMessage();
            }
            $this->loginView->setSessionToLoggedIn(true);
            $this->isLoggedIn = true;
        }
	}

	private function checkLoginCredentials () {
		if ($this->usernameExist && $this->passwordExist) {
            if ($this->username == '') {
                $this->message = $this->messageView->missingUsernameMessage();
            } else if ($this->password == '') {
                $this->message = $this->messageView->missingPasswordMessage();
            } else {
                $this->message = $this->messageView->wrongCredentialsMessage();
            }
        }
    } 
    
    public function logout () {
        $this->loginView->logOut();
        $this->message = $this->messageView->logoutMessage();
    }
    
    public function getMessage () {
        return $this->message;
    }
}
