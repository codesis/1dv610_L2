<?php

namespace view;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $loggedIn = 'LoginView::isLoggedIn';

	public function login () {
		return isset($_POST[self::$login]);
	}

	public function setSessionToLoggedIn ($bool) {
		$_SESSION[self::$loggedIn] = $bool;
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

	public function passwordFilledIn () {
		return isset($_POST[self::$password]);
	}

	public function getPassword() {
		if ($this->passwordFilledIn()) {
		    return $_POST[self::$password];
		}
	}

	public function keepUserLoggedIn () {
		return isset($_POST[self::$keep]);
	}

	public function response($isLoggedIn, $message) {
		if($isLoggedIn) {
			$response = $this->generateLogoutButtonHTML($message);
		} else {
			$response = $this->generateLoginFormHTML($message);
		}
		return $response;
	}

	private function generateLogoutButtonHTML($message) {
		return '
			<form method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
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
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
}
