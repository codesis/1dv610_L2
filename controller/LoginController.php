<?php

namespace controller;

require_once('view/LoginView.php');
require_once('view/CookiesView.php');
require_once('model/Database.php');

class LoginController {
    private $loginView;
    private $cookieView;
    private $username;
    private $usernameExist;
    private $passwordExist;
    private $password;
    private $message = '';
    private $database;

    public function __construct (\view\LoginView $loginView, \view\CookieView $cookieView, \model\Database $database) {
        $this->loginView = $loginView;
        $this->username = $this->loginView->getUsername();
        $this->usernameExist = $this->loginView->usernameFilledIn();
        $this->passwordExist = $this->loginView->passwordFilledIn();
        $this->password = $this->loginView->getPassword();


        $this->cookieView = $cookieView;
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
			$this->checkLoginCredentials();

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
		if ($this->database->checkIfUserExist($this->username, $this->password)) {
            if ($this->loginView->keepUserLoggedIn()) {
                $this->message = 'Welcome and you will be remembered';
            }
            $this->loginView->setSessionToLoggedIn(true);
            $this->message = 'Welcome';
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
            $this->message = 'Wrong name or password';
        }
	} 
    private function emptyUsername () {
        if ($this->username == '') {
            $this->message = 'Username is missing';
        }    
    }
    private function emptyPassword () {
        if ($this->password == '') {
            $this->message = 'Password is missing';
        }
    }
    
    public function getMessage () {
        return $this->message;
    }
}
