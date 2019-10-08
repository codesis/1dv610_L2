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
    /**
	 * Handles login attempt
	 * Hashes password
	 * 
	 * Calls different methods depending on action
	 */
	public function login () {
		$this->checkLoginCredentials();
    }
    	/**
	 * Sets session variable username to signed in username
	 * Calls keepMeLoggedIn() when keep my logged in is checked
	 * 
	 * Should be called when user signs in with verified login credentials
	 */
	private function verifiedLoginCredentials () {
		if ($this->database->checkIfUserExist($this->username, $this->password)) {
            if ($this->loginView->keepUserLoggedIn()) {
                $this->message = $this->messageView->welcomeCookiesMessage();
            }
            $this->loginView->setSessionToLoggedIn(true);
            $this->message = $this->messageView->welcomeMessage();
        }
	}

	/**
	 * Feedback changes depending on which credential is wrong
	 * 
	 * Should be called on check login tries
	 */
	public function checkLoginCredentials () {
		if ($this->usernameExist && $this->passwordExist) {
            $this->emptyUsername();
            $this->emptyPassword();
            $this->verifiedLoginCredentials();
        } 
		else {
            $this->message = $this->messageView->wrongCredentialsMessage();
        }
	} 
    private function emptyUsername () {
        if ($this->username == '') {
            $this->message = $this->messageView->missingUsernameMessage();
        }    
    }
    private function emptyPassword () {
        if ($this->password == '') {
            $this->message = $this->messageView->missingPasswordMessage();
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
