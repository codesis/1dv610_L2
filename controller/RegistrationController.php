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
    private $registerView;
    private $messageView;
    private $database;

    private $username;
    private $usernameExist;
    private $tooShortUsername;
    private $passwordExist;
    private $password;
    private $tooShortPassword;
    private $message;

	public function __construct (\view\RegisterView $registerView, \view\MessageView $messageView, \model\Database $database) {
        $this->registerView = $registerView;
        $this->messageView = $messageView;
        $this->database = $database;

        $this->username = $this->registerView->getUsername();
        $this->usernameExist = $this->registerView->usernameFilledIn();
        $this->tooShortUsername = $this->registerView->tooShortUsername();
        $this->passwordExist = $this->registerView->passwordsFilledIn();
        $this->password = $this->registerView->getPassword();
        $this->tooShortPassword = $this->registerView->tooShortPassword();

        $this->database->connectToDatabase();
    }

    public function registerNewUser () {
        $this->registerView->setUsername();
        $this->checkRegisterCredentials();
    }
    
    private function checkRegisterCredentials () {
		if ($this->usernameExist && $this->passwordExist) {
            $this->emptyCredentials();
            $this->notMatchingPasswords();
            $this->notAllowedCharactersInUsername();
        }
    } 

    private function emptyCredentials () {
        if ($this->tooShortUsername && $this->tooShortPassword) {
            $this->message = $this->messageView->tooShortUsernameMessage() . ' ' . $this->messageView->tooShortPasswordMessage();
        } else if ($this->tooShortPassword) {
            $this->message = $this->messageView->tooShortPasswordMessage();
        } else if ($this->tooShortUsername) {
            $this->message = $this->messageView->tooShortUsernameMessage();
        }
    }

    private function notMatchingPasswords () {
        if ($this->password === false) {
            $this->message = $this->messageView->notMatchingPasswordsMessage();
        } 
    }

    private function notAllowedCharactersInUsername () {
        if ($this->registerView->checkUsernameForHTML($this->username)) {
            $this->message = $this->messageView->invalidCharacterInUsernameMessage();
        } else {
            $this->validRegistrationAttempt();
        }
    }

    private function validRegistrationAttempt () {
		if ($this->usernameExist && $this->passwordExist) {
            if (!$this->tooShortPassword && !$this->tooShortUsername) {
                if ($this->password) {
                    $this->tryToRegisterNewUser();
                }
            }
        } 
    }

    public function tryToRegisterNewUser () {
        if (!$this->database->registerNewUser($this->username, $this->password)) {
            $this->message = $this->messageView->usernameExistMessage();
            return false;
        } else {
            $this->message = $this->messageView->registeredUserMessage();
            return true;
        }
	}

    public function getMessage () {
        return $this->message;
    }
}
