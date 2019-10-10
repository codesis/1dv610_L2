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
    private $passwordExist;
    private $password;
    private $message;

	public function __construct (\view\RegisterView $registerView, \view\MessageView $messageView, \model\Database $database) {
        $this->registerView = $registerView;
        $this->messageView = $messageView;
        $this->database = $database;

        $this->username = $this->registerView->getUsername();
        $this->usernameExist = $this->registerView->usernameFilledIn();
        $this->passwordExist = $this->registerView->passwordsFilledIn();
        $this->password = $this->registerView->getPassword();

        $this->database->connectToDatabase();
    }

    public function registerNewUser () {
        $this->checkRegisterCredentials();
        $this->tryToRegisterNewUser($this->username, $this->password);
    }
	
    public function tryToRegisterNewUser ($username, $password) {
        if ($this->checkRegisterCredentials()) {
            if (!$this->database->registerNewUser($username, $password)) {
                $this->messageView->usernameExistMessage();
                return false;
            } else {
                return true;
            }
        }
	}

	private function checkRegisterCredentials () {
		if ($this->usernameExist && $this->passwordExist) {
            if ($this->username == '') {
                $this->message = $this->messageView->missingUsernameMessage();
            } else if ($this->password == '') {
                $this->message = $this->messageView->missingPasswordMessage();
            } else {
                $this->message = $this->messageView->wrongCredentialsMessage();
            }
        }
    } 
    public function getMessage () {
        return $this->message;
    }
}
