<?php
/**
 * 
 * NEEDS TO BE RESTRUCTURED 
 * AND VALID FOR CURRENT CODE SETUP
 * 
 * 
 */

namespace controller;

class RegistrationController {
	
    private function registerNewUser () {
		if (isset($_POST[self::$register])) {
			$this->username = $_POST[self::$name];
			$this->passwordInput = $_POST[self::$password];
			$this->passwordRepeatInput = $_POST[self::$passwordRepeat];
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
	
	public function getRegisteredUsers () {
		return $this->takenUsernameArray;
	}

}
