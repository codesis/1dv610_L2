<?php
/**
 * class @LoginView
 * methods;
 * @login
 */
class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $message = '';
	private $holdUsername = '';
	private $passwordTest = '';
	private $hash = '';

	public function login () {
		$this->hash = password_hash('Password', PASSWORD_DEFAULT);
		// for when user tries to log in with faults
		if (isset($_POST[self::$login])) {
			$this->faultyLoginCredentials();
		    // when user logs in with or without keep my logged in checked
		    if ($_POST[self::$name] == 'Admin' && password_verify($_POST[self::$password], $this->hash)) {
			$this->verifiedLoginCredentials();
		    }
		    if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE['PHPSESSID'])) {
			$this->message = '';
			}
		}
		if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
				$this->message = 'Welcome back with cookie';
			}
			$_SESSION['username'] = $_COOKIE[self::$cookieName];
			$_SESSION['password'] = $_COOKIE[self::$cookiePassword];
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
	private function faultyLoginCredentials () {
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
		$_SESSION['password'] = $_POST[self::$password];		
	}
	/**
	 * Unsets the session
	 * Sets feedback to Bye Bye!
	 * Kills cookies
	 * 
	 * Should be called when user clicks log out
	 */
	private function logOut () {
		if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
			$this->message = 'Bye bye!';
		} 
		session_unset();
		setcookie(self::$cookieName, self::$name, time() - 3600);
		setcookie(self::$cookiePassword, $this->hash, time() - 3600);
	}
	/**
	 * Create cookie and new message
	 * 
	 * Should be called after a login attempt has med determined with Keep me logged in checked
	 */
	private function keepMeLoggedIn () {
		setcookie(self::$cookieName, $_POST[self::$name], time() + 3600);
		setcookie(self::$cookiePassword, $this->hash, time() + 3600);
	}
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		if(isset($_SESSION['username'])) {
			return $this->generateLogoutButtonHTML($this->message);
		} else {
			return $this->generateLoginFormHTML($this->message);
		}
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->holdUsername . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="' . $this->passwordTest . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getCookieBool() {
		return $this->cookieSetBool;
	}
	
}
