<?php

namespace view;

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';

	private $username;
	private $passwordInput;
	private $passwordRepeatInput;

	public function renderRegisterPage () {
		return isset($_GET['register']);
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

	public function tooShortUsername () {
		if (strlen($this->getUsername()) <= 2) {
			return true;
		}
	}

	public function tooShortPassword () {
		if (strlen($this->getPassword()) <= 6) {
			return true;
		}
	}

	public function passwordsFilledIn () {
		return isset($_POST[self::$password]) && isset($_POST[self::$passwordRepeat]);
	}

	private function passwordsMatching () {
        if ($_POST[self::$password] == $_POST[self::$passwordRepeat]) {
			return true;
		}
	}

	public function getPassword() {
		if ($this->passwordsMatching()) {
		    return $_POST[self::$password];
		} else {
			return false;
		}
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
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

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
