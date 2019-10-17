<?php

namespace controller;


class LoginController {
    private $loginView;
    private $cookieView;
    private $isUserLoggedIn;
    private $username;
    private $usernameExist;
    private $hashedUsername;

    private $passwordExist;
    private $password;
    private $hashedPassword;
    private $messageView;
    private $message;
    private $database;

    private $isLoggedIn = false;

    public function __construct (\view\LoginView $loginView, \view\MessageView $messageView, \view\CookiesView $cookieView, \model\Database $database) {
        $this->loginView = $loginView;
        $this->username = $this->loginView->getUsername();
        $this->usernameExist = $this->loginView->usernameFilledIn();
        $this->hashedUsername = password_hash($this->username, PASSWORD_DEFAULT);
        
        $this->passwordExist = $this->loginView->passwordFilledIn();
        $this->password = $this->loginView->getPassword();
        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $this->messageView = $messageView;

        $this->cookieView = $cookieView;
        $this->database = $database;

        $this->database->connectToDatabase();
    }

      public function login () {
        $this->loginView->setUsername();
        $this->checkLoginCredentials();
        $this->verifiedLoginCredentials();

        $this->checkIfCookiesExist();

        return $this->isLoggedIn;
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

    private function verifiedLoginCredentials () {
		if ($this->database->checkIfUserExist($this->username, $this->password)) {
            $this->isUserLoggedIn();

            $this->isLoggedIn = true;
        }
    }

    private function returningWithCookies () {
        if ($this->cookieView->returnWithCookies($this->username, $this->password) === true) {
            $this->message = $this->messageView->welcomeBackWithCookiesMessage();
        } else {
            $this->message = $this->messageView->wrongInformationInCookiesMessage();
            // $this->logout();
        }
    }
    
    public function isUserLoggedIn () {
        if ($this->cookieView->getLoggedInStatus() === false) {
            $this->message = $this->messageView->welcomeMessage();
            $this->keepUserLoggedIn();
        }  else {
            $this->message = $this->getEmptyMessage();
        }
        $this->cookieView->loggedInCookie($this->hashedUsername);
    }

    private function checkIfCookiesExist () {
        if ($this->cookieView->checkKeepMeLoggedInCookies() === true) {
            $this->returningWithCookies();
        }
    }

    private function keepUserLoggedIn () {
        if ($this->loginView->keepUserLoggedIn()) {
            $this->cookieView->keepMeLoggedIn($this->username, $this->hashedPassword);
            $this->message = $this->messageView->welcomeCookiesMessage();
        }
    }

    public function getNewUserCookie () {
        $username = $this->cookieView->getNewUserCookie();
        $this->message = $this->messageView->registeredUserMessage();
        $this->loginView->newUserRegistered($username);
    }

    private function getEmptyMessage () {
        return $this->message = $this->messageView->emptyMessage();
    }
    
    public function logout () {
        $this->cookieView->killCookies($this->username, $this->hashedPassword);
        $this->loginView->logOut();
        if ($this->cookieView->getLoggedInStatus() === false) {
            $this->message = $this->getEmptyMessage();
        } else {
            $this->message = $this->messageView->logoutMessage();
        }
    }
    
    public function getMessage () {
        return $this->message;
    }
}
