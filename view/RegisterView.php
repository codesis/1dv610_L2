<?php
require_once('LoginView.php');

// upcoming for the registration page
class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	private $message = '';
	private $holdUsername = '';
    private $takenUsernameArray = array('Admin');
    
	/**
	 * Called when a register attempt is made
	 * 
	 * Changes feedback depending on outcome
	 */
	private function register () {
		if (isset($_POST[self::$register])) {
			if (empty($_POST[self::$name]) && empty($_POST[self::$password]) && empty($_POST[self::$passwordRepeat])) {
				$this->message = 'Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.';
			} 
			if (strlen($_POST[self::$name]) >= 3 && (empty($_POST[self::$password]) || strlen($_POST[self::$password]) <=5) && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
				$this->holdUsername = $_POST[self::$name];
				$this->message = 'Password has too few characters, at least 6 characters.';
			} 
			if (strlen($_POST[self::$name]) <= 2 && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
				$this->holdUsername = $_POST[self::$name];
				$this->message = 'Username has too few characters, at least 3 characters.';
			} 
			if (strlen($_POST[self::$name]) >= 3 && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] != $_POST[self::$passwordRepeat]) {
				$this->holdUsername = $_POST[self::$name];
				$this->message = 'Passwords do not match.';
			} 
			if (in_array($_POST[self::$name], $this->takenUsernameArray) && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
				$this->holdUsername = $_POST[self::$name];
				$this->message = 'User exists, pick another username.';
			} 
			if ($_POST[self::$name] != strip_tags($_POST[self::$name]) && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
				$this->holdUsername = strip_tags($_POST[self::$name]);
				$this->message = 'Username contains invalid characters.';
			}	else if (strlen($_POST[self::$name]) >= 3 && !in_array($_POST[self::$name], $this->takenUsernameArray) && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
                $newusername = $_POST[self::$name];
                array_push($this->takenUsernameArray, $newusername);
				$_SESSION['newuser'] = $_POST[self::$name];
				header('Location: ?');
			}

		}
	}
	/**
	 * Feedback changes depending on which faulty credential
	 * 
	 * Should be called when a register attempt is made
	 */
	// private function faultyRegisterCredentials () {
	// 	if (empty($_POST[self::$name]) && empty($_POST[self::$password]) && empty($_POST[self::$passwordRepeat])) {
	// 		$this->message = 'Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.';
	// 	} 
	// 	if (strlen($_POST[self::$name]) >= 3 && (empty($_POST[self::$password]) || strlen($_POST[self::$password]) <=5) && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
	// 		$this->holdUsername = $_POST[self::$name];
	// 		$this->message = 'Password has too few characters, at least 6 characters.';
	// 	} 
	// 	if (strlen($_POST[self::$name]) <= 2 && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
	// 		$this->holdUsername = $_POST[self::$name];
	// 		$this->message = 'Username has too few characters, at least 3 characters.';
	// 	} 
	// 	if (strlen($_POST[self::$name]) >= 3 && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] != $_POST[self::$passwordRepeat]) {
	// 		$this->holdUsername = $_POST[self::$name];
	// 		$this->message = 'Passwords do not match.';
	// 	} 
	// 	if (in_array($_POST[self::$name], $this->takenUsernameArray) && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
	// 		$this->holdUsername = $_POST[self::$name];
	// 		$this->message = 'User exists, pick another username.';
	// 	} 
	// 	if ($_POST[self::$name] != strip_tags($_POST[self::$name]) && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] === $_POST[self::$passwordRepeat]) {
	// 		$this->holdUsername = strip_tags($_POST[self::$name]);
	// 		$this->message = 'Username contains invalid characters.';
	// 	}
	// }
	/**
	 * Called when valid registration is made
	 */
	private function verifiedRegisterCredentials () {
    }
    private function setRegisteredUsers ($takenUsernameArray, $newusername) {
        array_push($takenUsernameArray, $new);
        $this->takenUsernameArray = $takenUsernameArray;
    }
	/**
	 * Returns takenUsernameArray
	 */
	public function getRegisteredUsers () {
		return $this->takenUsernameArray;
	}
	/**
	 * Calls register(). 
	 * Returns generateRegisterFormHTML() when user enters register page
	 */
	public function response () {
		$LoginView = new LoginView();
		$this->register();
		if (isset($_GET['register'])) {
		return $this->generateRegisterFormHTML($this->message);
		} 
	}
	/**
	 * Generate a register form in HTML
	 * 
	 * Should be called when user enters register page
	 */
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
