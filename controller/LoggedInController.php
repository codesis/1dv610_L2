<?php

namespace controller;

require_once('./view/LoginView.php');
require_once('./view/CookiesView.php');
require_once('./view/MessageView.php');
require_once('./model/Database.php');

class LoggedInController {
    private $loginView;
    private $cookieView;
    private $isUserLoggedIn;
    private $username;
    private $hashedUsername;
    private $password;
    private $hashedPassword;
    private $messageView;
    private $message;
    private $database;

    private $isLoggedIn = false;

    public function __construct (\view\LoginView $loginView, \view\MessageView $messageView, \view\CookiesView $cookieView, \model\Database $database) {
        $this->loginView = $loginView;
        $this->username = $this->loginView->getUsername();
        $this->hashedUsername = password_hash($this->username, PASSWORD_DEFAULT);
        
        $this->password = $this->loginView->getPassword();
        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $this->messageView = $messageView;

        $this->cookieView = $cookieView;
        $this->database = $database;

        $this->database->connectToDatabase();
    }
    
    private function verifyUpdatePassword () {
        if ($this->cookieView->verifyLoggedInUsernameCookie($this->hashedUsername)) {
            
        }
    }

    public function tryToUpdatePassword () {
        if (!$this->database->updatePassword($this->username, $this->password)) { // this->password is supposed to be the new password chosen
            $this->message = $this->messageView->usernameExistMessage();
            return false;
        } else {
            $this->message = $this->messageView->registeredUserMessage();
            return true;
        }
	}

    public function getMessage () {
        return $this->message;
    }

}
