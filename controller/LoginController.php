<?php

namespace controller;


class LoginController {
    private $loginView;
    private $cookieView;
    private $isUserLoggedIn;
    private $username;
    private $usernameExist;
    private $hashedUsername;

    private $passwordExist;
    private $password;
    private $hashedPassword;
    private $messageView;
    private $message;
    private $database;

    private $isLoggedIn = false;

    public function __construct (\view\LoginView $loginView, \view\MessageView $messageView, \view\CookiesView $cookieView, \model\Database $database) {
        $this->loginView = $loginView;
        $this->username = $this->loginView->getUsername();
        $this->usernameExist = $this->loginView->usernameFilledIn();
        $this->hashedUsername = password_hash($this->username, PASSWORD_DEFAULT); // move to loginview?
        
        $this->passwordExist = $this->loginView->passwordFilledIn();
        $this->password = $this->loginView->getPassword();
        $this->newHashedPassword = password_hash($this->password, PASSWORD_DEFAULT); // move to loginview?

        $this->newPasswordsFilledIn = $this->loginView->passwordsFilledIn();
        $this->tooShortPassword = $this->loginView->tooShortPassword();
        $this->passwordsMatching = $this->loginView->getNewPassword();

        $this->messageView = $messageView;

        $this->cookieView = $cookieView;
        $this->database = $database;

        $this->database->connectToDatabase();
        $this->hashedPassword = $this->database->getHashedPassword($this->username);
    }

      public function login () {
        $this->loginView->setUsername();
        $this->checkLoginCredentials();
        $this->verifiedLoginCredentials();

        $this->checkIfCookiesExist();

        return $this->isLoggedIn;
    }

	private function checkLoginCredentials () {
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

    private function verifiedLoginCredentials () {
		if ($this->database->checkIfUserExist($this->username, $this->password)) { 
            $this->cookieView->setCookieUserLoggedIn($this->username);
            $this->isUserLoggedIn();

            $this->isLoggedIn = true;
        }
    }
    
    public function isUserLoggedIn () {
        if (!$this->cookieView->getLoggedInStatus()) {
            $this->message = $this->messageView->welcomeMessage();
            $this->keepUserLoggedIn();
        }  else {
            $this->message = $this->getEmptyMessage();
        }
        $this->cookieView->loggedInCookie($this->hashedUsername);
    }

    private function keepUserLoggedIn () {
        if ($this->loginView->keepUserLoggedIn()) {
            $this->updateHashAndSetCookies();
            $this->message = $this->messageView->welcomeCookiesMessage();
        }
    }

    private function checkIfCookiesExist () {
        if ($this->cookieView->checkKeepMeLoggedInCookies()) {
            $this->returningWithCookies();
        }
    }

    private function updateHashAndSetCookies () {
        $this->database->updateHashedPassword($this->username, $this->newHashedPassword);
        $this->cookieView->keepMeLoggedIn($this->username, $this->newHashedPassword);
    }

    public function updatePassword () {        
        if ($this->cookieView->verifyLoggedInUsernameCookie()) {
            $this->verifyNewPassword();   
            $this->isLoggedIn = true; 
        } else {
            $this->wrongCookies();
        }
    }

    private function verifyNewPassword () {
        if ($this->tooShortPassword) {
            $this->message = $this->messageView->tooShortPasswordMessage();
        } else {
           $this->notMatchingNewPassword();
        }
    }

    private function notMatchingNewPassword () {
        if (!$this->passwordsMatching) {
            $this->message = $this->messageView->notMatchingPasswordsMessage();
        } else {
            $username = $this->cookieView->getCookieUserLoggedIn();
            $password = $this->loginView->getNewPassword();

            $this->updateUserPassword($username, $password);
        }
    }

    private function updateUserPassword ($username, $password) {
        if ($this->database->updatePassword($username, $password)) {
            $this->message = $this->messageView->passwordUpdatedMessage();
        }    
    }

    public function deleteUser () {
        $username = $this->loginView->getNameOfUser();
        $password = $this->loginView->getUserPassword();

        $this->userWantsToBeDeleted($username, $password);
    }

    private function userWantsToBeDeleted ($username, $password) {
        if (!$this->database->checkIfUserExist($username, $password)) {
            $this->message = $this->messageView->wrongCredentialsMessage();
            $this->isLoggedIn = true;
        } else {
            $this->database->deleteUser($username, $password);
            $this->cookieView->killCookies();
            $this->message = $this->messageView->userDeletedMessage();
        }
    }

    public function returningWithCookies () {
        if ($this->cookieView->returnWithCookies()) {
            $username = $this->cookieView->getCookieName();
            $password = $this->cookieView->getCookiePassword();

            $this->verifyReturnerOfCookies($username, $password);
        }
    }

    private function verifyReturnerOfCookies ($username, $password) {
        if ($this->database->verifyPassword($username, $password)) {
            $this->checkIfCookieMessage();
            $this->isLoggedIn = true;
        } else {
            $this->wrongCookies();
        }
    }

    private function wrongCookies () {
        $this->message = $this->messageView->wrongInformationInCookiesMessage();
        $this->cookieView->killCookies();
        $this->loginView->emptyUsername();
    }

    private function checkIfCookieMessage () {
        if (!$this->cookieView->checkPHPSessIdCookie()) {
            $this->message = $this->messageView->welcomeBackWithCookiesMessage();
        } else {
            $this->getEmptyMessage();
        }
    }

    public function setNewUsernameToForm () {
        $username = $this->cookieView->getNewUserCookie();
        $this->message = $this->messageView->registeredUserMessage();
        $this->loginView->newUserRegistered($username);
    }

    private function getEmptyMessage () {
        return $this->message = $this->messageView->emptyMessage();
    }
    
    public function logout () {
        $this->cookieView->killCookies();

        $this->setLogoutMessage();
    }

    private function setLogoutMessage () {
        if (!$this->cookieView->getLoggedInStatus()) {
            $this->message = $this->getEmptyMessage();
        } else {
            $this->message = $this->messageView->logoutMessage();
        }
    }
    
    public function getMessage () {
        return $this->message;
    }
}
