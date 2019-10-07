<?php

namespace view;

require_once('RegisterView.php');
/**
 * class @LoginView
 * methods;
 * @login
 * @faultyLoginCredentials
 * @verifiedLoginCredentials
 * @returnWithCookies
 * @logOut
 * @keepMeLoggedIn
 * @response
 * @generateLogoutButtonHTML
 * @generateLoginFormHTML
 */
class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $message = '';
	private $holdUsername = '';
	private $passwordTest = '';
	private $hash = '';

	public function login () {
		return isset($_POST[self::$login]);
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
	 * Unsets the session
	 * Sets feedback to Bye Bye!
	 * Kills cookies
	 * 
	 * Should be called when user clicks log out
	 */
	private function logOut () {
		if (isset($_SESSION['username'])) {
			$this->message = 'Bye bye!';
		} 
		session_destroy();
		setcookie(self::$cookieName, '', time() - 3600);
		setcookie(self::$cookiePassword, '', time() - 3600);
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
		} else if (!isset($_GET['register'])){
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
}
