<?php

namespace view;

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	private static $registerURL = 'register';

	private $username;
	private $passwordInput;
	private $passwordRepeatInput;

	public function renderRegisterPage () {
		return isset($_GET[self::$registerURL]);
	}

	public function registerNewUser () {
		return isset($_POST[self::$register]);
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
			if ($this->checkUsernameForHTML($this->getUsername())) {
				$this->username = strip_tags($this->getUsername());
			} else {
				$this->username = $this->getUsername();
			}
			return $this->username;
		}
	}

	public function checkUsernameForHTML ($string) {
		if ($string != strip_tags($string)) {
			return true;
		} 
		return false;
	}

	public function tooShortUsername () {
		if (strlen($this->getUsername()) <= 2) {
			return true;
		} 
	}

	public function tooShortPassword () {
		if (strlen($this->getPassword()) <= 5) {
			return true;
		} 
	}

	public function passwordsFilledIn () {
		return isset($_POST[self::$password]) && isset($_POST[self::$passwordRepeat]);
	}

	private function passwordsMatching () {
		if ($this->passwordsFilledIn()) {
			if ($_POST[self::$password] == $_POST[self::$passwordRepeat]) {
				return true;
			}
		}
	}

	public function getPassword() {
		if ($this->passwordsMatching()) {
		    return $_POST[self::$password];
		} else {
			return false;
		}
	}

	public function hashPassword () {
		return password_hash($this->getPassword(), PASSWORD_DEFAULT);
	}

	
	public function response ($message) {
		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}

	private function generateRegisterFormHTML ($message) {
		return '
		<a href="?">Back to login</a>
			<form method="post" > 
				<fieldset>
					<legend>Register - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->username . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="" />
					<label for="' . self::$password . '">Repeat password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" value="" />
					
					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
	}
}
