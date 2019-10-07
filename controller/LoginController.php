<?php

namespace controller;

require_once('view/LoginView.php');
require_once('model/Database.php');

class LoginController {
    private $loginView;
    private $message = '';
    private $database;

    public function __construct (\view\LoginView $loginView, \model\Database $database) {
        $this->loginView = $loginView;
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
		// $RegisterView = new RegisterView();
		// $this->hash = password_hash('Password', PASSWORD_DEFAULT);
		// if (isset($_SESSION['newuser'])) {
		// 	$this->holdUsername = $_SESSION['newuser'];
		// 	$this->message = 'Registered new user.';
		// } 
		if ($this->loginView->login()) {	
			$this->faultyLoginCredentials();

			if (in_array($_POST[self::$name], $RegisterView->getRegisteredUsers()) && password_verify($_POST[self::$password], $this->hash)) {
				$this->verifiedLoginCredentials();
		    }
		    if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE['PHPSESSID'])) {
			    $this->message = '';
			}
		}
		if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			$this->returnWithCookies();
		}
	    if (isset($_POST[self::$logout])) {
		$this->logOut();
	    } 
    }
    	/**
	 * Sets session variable username to signed in username
	 * Calls keepMeLoggedIn() when keep my logged in is checked
	 * 
	 * Should be called when user signs in with verified login credentials
	 */
	private function verifiedLoginCredentials () {
		if (!isset($_SESSION['username'])) {
			$this->message = 'Welcome';
		} else {
			$this->message = '';
		}
		if (!empty($_POST[self::$keep])) {
			$this->keepMeLoggedIn();
			$this->message = 'Welcome and you will be remembered';
		}
		$_SESSION['username'] = $_POST[self::$name];
	}

	/**
	 * Feedback changes depending on which credential is wrong
	 * 
	 * Should be called on faulty login tries
	 */
	public function faultyLoginCredentials () {
		if ($this->loginView->usernameFilledIn() && $this->loginView->passwordFilledIn()) {
            $this->emptyUsername();
            $this->emptyPassword();
        } 
		else {
            $this->message = 'Wrong name or password';
        }
	} 
    private function emptyUsername () {
        if ($this->loginView->getUsername() == '') {
            $this->message = 'Username is missing';
        }    
    }
    private function emptyPassword () {
        if ($this->loginView->getPassword() == '') {
            $this->message = 'Password is missing';
        }
    }
    
    public function getMessage () {
        return $this->message;
    }
}
