<?php

namespace view;

require_once('LoginView.php');

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	private $message = '';
	private $holdUsername = '';
	private $takenUsernameArray = array('Admin');
	private $username;
	private $passwordInput;
	private $passwordRepeatInput;
    

	public function response ($isLoggedIn, $message) {
		$LoginView = new LoginView();
		$this->registerNewUser();
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
