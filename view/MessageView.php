<?php

namespace view;

class MessageView {
    private $message;

    public function emptyMessage () {
        return $this->message = '';
    }
    
    public function welcomeMessage () {
        return $this->message = 'Welcome';
    }

    public function missingUsernameMessage () {
        return $this->message = 'Username is missing';
    }

    public function missingPasswordMessage () {
        return $this->message = 'Password is missing';
    }

    public function logoutMessage () {
        return $this->message = 'Bye bye!';
    }

    public function wrongCredentialsMessage () {
        return $this->message = 'Wrong name or password';
    }

    public function welcomeCookiesMessage () {
        return $this->message = $this->welcomeMessage() . ' and you will be remembered.';
    }

    public function welcomeBackWithCookiesMessage () {
        return $this->message = $this->welcomeMessage() . ' back with cookie.';
    }

    public function wrongInformationInCookiesMessage () {
        return $this->message = 'Wrong information in cookies.';
    }

    public function usernameExistMessage () {
        return $this->message = 'User exists, pick another username.';
    }

    public function tooShortCredentialsMessage () {
        return $this->message = $this->tooShortUsernameMessage() . ' ' . $this->tooShortPasswordMessage();
    }

    public function tooShortUsernameMessage () {
        return $this->message = 'Username has too few characters, at least 3 characters.';
    }

    public function invalidCharacterInUsernameMessage () {
        return $this->message = 'Username contains invalid characters.';
    }

    public function tooShortPasswordMessage () {
        return $this->message = 'Password has too few characters, at least 6 characters.';
    }

    public function notMatchingPasswordsMessage () {
        return $this->message = 'Passwords do not match.';
    }

    public function registeredUserMessage () {
        return $this->message = 'Registered new user';
    }

    public function passwordUpdatedMessage () {
        return $this->message = 'Password updated successfully';
    }
}
