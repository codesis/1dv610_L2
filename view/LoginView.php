<?php

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

	public function login () {
		$hash = password_hash('Password', PASSWORD_DEFAULT);
		if (isset($_POST[self::$login])) {
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
		if ($_POST[self::$name] == 'Admin' && password_verify($_POST[self::$password], $hash)) {
			if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
				$this->message = 'Welcome';
			}
			$_SESSION['username'] = $_POST[self::$name];
			$_SESSION['password'] = $_POST[self::$password];
		}
	}
		if (isset($_POST[self::$logout])) {
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
				$this->message = 'See you next time!';
			}
			session_unset();
		}
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
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
	}
	
}