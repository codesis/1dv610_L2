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
        $this->checkRegisterCredentials();
        if (!$this->database->registerNewUser($this->username, $this->password)) {
            $this->message = $this->messageView->usernameExistMessage();
            // return false;
        } else {
            // return true;
        }
    }
    
    private function checkRegisterCredentials () {
		if ($this->usernameExist && $this->passwordExist) {
            $this->emptyCredentials();
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

        if ($this->password === false) {
            $this->message = $this->messageView->notMatchingPasswordsMessage();
        }
    }

    public function tryToRegisterNewUser () {
        if (!$this->database->registerNewUser($this->username, $this->password)) {
            $this->message = $this->messageView->usernameExistMessage();
            return false;
        } else {
            return true;
        }
	}

    public function getMessage () {
        return $this->message;
    }
}
