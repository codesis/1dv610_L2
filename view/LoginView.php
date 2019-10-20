<?php

namespace view;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $updatePassword = 'LoginView::UpdatePassword';
	private static $updatePasswordRepeat = 'LoginView::UpdatePasswordRepeat';
	private static $update = 'LoginView::Update';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $loggedIn = 'LoginView::isLoggedIn';
	private static $updatePasswordURL = 'updatepassword';
	private static $loginPage = '?';
	private static $deleteAccountURL = 'deleteaccount';
	private static $delete = 'LoginView::Delete';
	private static $username = 'LoginView::User';
	private static $userPassword = 'LoginView::UserPassword';
	private static $headerLocationString = 'Location: ?';
	private $holdUsername = '';

	public function loginPageRedirect () {
		return header(self::$headerLocationString);
	}

	public function loginPage () {
		return isset($_GET[self::$loginPage]);
	}
	
	public function login () {
		return isset($_POST[self::$login]);
	}

	public function logOut () {
		return isset($_POST[self::$logout]);
	}

	public function usernameFilledIn () {
		return isset($_POST[self::$name]);
	}

	public function getUsername () {
		if ($this->usernameFilledIn()) {
		    return $_POST[self::$name];
		}
	}

	public function setUsername () {
		if ($this->getUsername()) {
			$this->holdUsername = $this->getUsername();
		}
	}

	public function emptyUsername () {
		return $this->holdUsername = '';
	}

	public function keepUserLoggedIn () {
		return isset($_POST[self::$keep]);
	}

	public function passwordFilledIn () {
		return isset($_POST[self::$password]);
	}

	public function getPassword() {
		if ($this->passwordFilledIn()) {
		    return $_POST[self::$password];
		}
	}

	public function updatePassword () {
		return isset($_POST[self::$update]);
	}

	private function getUpdatePassword () {
		if (isset($_POST[self::$updatePassword])) {
			return $_POST[self::$updatePassword];
		}
	}

	public function tooShortPassword () {
		if (strlen($this->getUpdatePassword()) <= 5) {
			return true;
		} 
	}

	public function passwordsFilledIn () {
		return isset($_POST[self::$updatePassword]) && isset($_POST[self::$updatePasswordRepeat]);
	}

	private function passwordsMatching () {
		if ($this->passwordsFilledIn()) {
			if ($_POST[self::$updatePassword] == $_POST[self::$updatePasswordRepeat]) {
				return true;
			}
		}
	}

	public function getNewPassword() {
		if ($this->passwordsMatching()) {
		    return $_POST[self::$updatePassword];
		} else {
			return false;
		}
	}

	public function newUserRegistered ($username) {
		$this->holdUsername = $username;
	}

	public function response($isLoggedIn, $message) {
		if($isLoggedIn) {
			$response = $this->setResponseToPasswordChange($message);
		} else {
			$response = $this->generateLoginFormHTML($message);
		}
		return $response;
	}

	private function setResponseToPasswordChange ($message) {
		if (isset($_GET[self::$updatePasswordURL])) {
			$response = $this->generateChangePasswordHTML($message);
		} else {
			$response = $this->setResponseToDeleteAccount($message);
		}
		return $response;
	}

	private function setResponseToDeleteAccount ($message) {
		if (isset($_GET[self::$deleteAccountURL])) {
			$response = $this->generateDeleteAccountHTML($message);
		} else {
			$response = $this->generateLogoutButtonHTML($message);
		}
		return $response;
	}

	private function generateLogoutButtonHTML($message) {
		return '
		<a href="?updatepassword">Update password</a>
		<a href="?deleteaccount">Delete account</a>
			<form method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="Logout"/>
			</form>
		';
	}

	private function generateChangePasswordHTML ($message) {
		return '
		<a href="?">Back to start</a>
		<a href="?deleteaccount">Delete account</a>
			<form method="post" >
				<fieldset>
			    <legend>Update password - enter a new password</legend>
			    <p id="' . self::$messageId . '">' . $message .'</p>

				<label for="' . self::$updatePassword . '">Enter new password: </label>
				<input type="password" id="' . self::$updatePassword . '" name="' . self::$updatePassword . '" value="" />

				<label for="' . self::$updatePasswordRepeat . '">Repeat new password: </label>
				<input type="password" id="' . self::$updatePasswordRepeat . '" name="' . self::$updatePasswordRepeat . '" value="" />

				<input type="submit" name="' . self::$update . '" value="Update password"/>
				</fieldset>
			</form>
		';
	}

	private function generateDeleteAccountHTML ($message) {
		return '
		<a href="?">Back to start</a>
		<a href="?updatepassword">Update password</a>
			<form method="post" >
				<fieldset>
			    <legend>Delete account - enter your username and password</legend>
				<p id="' . self::$messageId . '">' . $message .'</p>
				
				<label for="' . self::$username . '">Username :</label>
				<input type="text" id="' . self::$username . '" name="' . self::$username . '" value="" />

				<label for="' . self::$userPassword . '">Password :</label>
				<input type="password" id="' . self::$userPassword . '" name="' . self::$userPassword . '" value="" />

				<input type="submit" name="' . self::$delete . '" value="Delete account"/>
				</fieldset>
			</form>
		';
	}
	
	private function generateLoginFormHTML($message) {
		return '
		<a href="?register">Register a new user</a>
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->holdUsername . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="Login" />
				</fieldset>
			</form>
		';
	}
}
