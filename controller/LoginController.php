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
		if (isset($_POST[self::$login])) {	
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
	 * Feedback changes depending on which credential is wrong
	 * 
	 * Should be called on faulty login tries
	 */
	public function faultyLoginCredentials () {
		if (empty($_POST[self::$name])) {
			$this->message = 'Username is missing';
		} else if (isset($_POST[self::$name]) && empty($_POST[self::$password])) {
			$this->holdUsername = $_POST[self::$name];
			$this->message = 'Password is missing';
		} else if ($this->holdUsername = 'admin' || $this->passwordTest = 'password') {
			$this->holdUsername = $_POST[self::$name];
			$this->passwordTest = '';
			$this->message = 'Wrong name or password';
		} 
	}

}
