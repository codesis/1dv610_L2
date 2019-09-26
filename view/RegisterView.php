<?php

// upcoming for the registration page
class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $messageId = 'RegisterView::Message';
	private $message = '';


	/**
	* Generate HTML code for register page
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function register () {
		if (isset($_POST['register'])) {
			$this->message = 'pressed register button';
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
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="" />
					<label for="' . self::$password . '">Repeat password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="" />
					
					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
	}
}
