<?php

// upcoming for the registration page
class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	private $message = '';
	private $holdUsername = '';


	/**
	* Generate HTML code for register page
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function register () {
		if (isset($_POST[self::$register])) {
			$this->faultyRegisterCredentials();
		}
	}
	private function faultyRegisterCredentials () {
		if (empty($_POST[self::$name]) && empty($_POST[self::$password]) && empty($_POST[self::$passwordRepeat])) {
			$this->message = 'Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.';
		} else if (strlen($_POST[self::$name]) >= 3 && (empty($_POST[self::$password]) || strlen($_POST[self::$password]) <=5) && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
			$this->holdUsername = $_POST[self::$name];
			$this->message = 'Password has too few characters, at least 6 characters.';
		} else if (strlen($_POST[self::$name]) <= 2 && strlen($_POST[self::$password] >= 6) && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
			$this->holdUsername = $_POST[self::$name];
			$this->message = 'Username has too few characters, at least 3 characters.';
		} else if (strlen($_POST[self::$name]) >= 3 && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] != $_POST[self::$passwordRepeat]) {
			$this->holdUsername = $_POST[self::$name];
			$this->message = 'Passwords do not match.';
		} else if ($_POST[self::$name] === 'Admin' && strlen($_POST[self::$password] >= 6) && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
			$this->holdUsername = $_POST[self::$name];
			$this->message = 'User exists, pick another username.';
		} 
	}

	public function response () {
		$this->register();
		if (isset($_GET['register'])) {
		return $this->generateRegisterFormHTML($this->message);
		}
	}
	private function generateRegisterFormHTML ($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Register - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->holdUsername . '" />

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
