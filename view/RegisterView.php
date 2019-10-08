<?php

namespace view;

require_once('LoginView.php');
/**
 * class RegisterView
 * methods;
 * @register
 * @faultyRegisterCredentials (unused atm)
 * @setRegisteredUsers
 * @getRegisteredUsers
 * @response
 * @genereateRegisterFormHTML
 */
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
    
	/**
	 * Called when a register attempt is made
	 * 
	 * Changes feedback depending on outcome
	 * Redirects when validated creation attempt is made
	 */
	private function registerNewUser () {
		if (isset($_POST[self::$register])) {
			$this->username = $_POST[self::$name];
			$this->passwordInput = $_POST[self::$password];
			$this->passwordRepeatInput = $_POST[self::$passwordRepeat];
			$tooFewCharInUsername = 'Username has too few characters, at least 3 characters.';
			$tooFewCharInPassword = 'Password has too few characters, at least 6 characters.';
			$this->emptyRegisterInputs();
			$this->tooFewCharInPassword();
			$this->tooFewCharInUsername();
			$this->passwordsNotMatching();
			$this->usernameAlreadyExists();
			$this->invalidCharInUsername();
			$this->validUserRegistration();
		}
	}
	private function emptyRegisterInputs () {
		if (empty($this->username) && empty($this->passwordInput) && empty($this->passwordRepeat)) {
			$this->message = $tooFewCharInUsername . $tooFewCharInPassword;
		} 
	}
	private function tooFewCharInPassword () {
		if (strlen($this->username) <= 3 && (empty($this->passwordInput) || strlen($this->passwordInput) <=5) && $this->passwordInput === $this->passwordRepeatInput) {
			$this->holdUsername = $this->username;
			$this->message = $tooFewCharInPassword;
		} 
	}
	private function tooFewCharInUsername () {
		if (strlen($this->username) <= 2 && strlen($this->passwordInput) >= 6 && $this->passwordInput === $this->passwordRepeatInput) {
			$this->holdUsername = $this->username;
			$this->message = $tooFewCharInUsername;
		} 
	}
	private function passwordsNotMatching () {
		if (strlen($this->username) >= 3 && strlen($this->passwordInput) >= 6 && $this->passwordInput != $this->passwordRepeatInput) {
			$this->holdUsername = $this->username;
			$this->message = 'Passwords do not match.';
		} 
	}
	private function usernameAlreadyExists () {
		if (in_array($this->username, $this->takenUsernameArray) && strlen($this->passwordInput) >= 6 && $this->passwordInput === $this->passwordRepeatInput) {
			$this->holdUsername = $this->username;
			$this->message = 'User exists, pick another username.';
		} 
	}
	private function invalidCharInUsername () {
		if ($this->username != strip_tags($this->username) && strlen($this->passwordInput) >= 6 && $this->passwordInput === $this->passwordRepeatInput) {
			$this->holdUsername = strip_tags($this->username);
			$this->message = 'Username contains invalid characters.';
		}	
	}
	private function validUserRegistration () {
		if (strlen($this->username) >= 3 && !in_array($this->username, $this->takenUsernameArray) && strlen($this->passwordInput) >= 6 && $this->passwordInput === $this->passwordRepeatInput) {
			$newusername = $this->username;
			array_push($this->takenUsernameArray, $newusername);
			$_SESSION['newuser'] = $newusername;
			header('Location: ?');
		}
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
		$this->registerNewUser();
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
