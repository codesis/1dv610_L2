<?php

namespace controller;

require_once('./view/CookiesView.php');


class RegistrationController {
    private $registerView;
    private $messageView;
    private $database;
    private $cookieView;

    private $username;
    private $usernameExist;
    private $tooShortUsername;
    private $passwordExist;
    private $password;
    private $tooShortPassword;
    private $message;

    private $newUserRegistered = false;

	public function __construct (\view\RegisterView $registerView, \view\MessageView $messageView, \model\Database $database) {
        $this->registerView = $registerView;
        $this->messageView = $messageView;
        $this->database = $database;
        $this->cookieView = new \view\CookiesView();

        $this->username = $this->registerView->getUsername();
        $this->usernameExist = $this->registerView->usernameFilledIn();
        $this->tooShortUsername = $this->registerView->tooShortUsername();
        $this->passwordExist = $this->registerView->passwordsFilledIn();
        $this->password = $this->registerView->getPassword();
        $this->tooShortPassword = $this->registerView->tooShortPassword();
        $this->hashedPassword = $this->registerView->hashPassword();

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
            $this->message = $this->messageView->tooShortCredentialsMessage();
        } else {
            $this->tooShortCredentials();
        }
    }

    private function tooShortCredentials () {
        if ($this->tooShortPassword) {
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
        if (!$this->database->registerNewUser($this->username, $this->password, $this->hashedPassword)) {
            $this->message = $this->messageView->usernameExistMessage();
        } else {
            $this->cookieView->newUserRegistratedCookie($this->username);
            $this->newUserRegistered = true;
        }
    }

    public function getNewUserBool () {
        return $this->newUserRegistered;
    }

    public function getMessage () {
        return $this->message;
    }
}
