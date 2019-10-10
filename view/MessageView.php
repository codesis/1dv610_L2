<?php

namespace view;

class MessageView {
    private $message;

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
        return $this->message = $this->welcomeMessage() . ' back with cookies.';
    }

    public function tooShortUsernameMessage () {
        return $this->message = 'Username has too few characters, at least 3 characters.';
    }

    public function invalidCharacterInUsername () {
        return $this->message = 'Username contains invalid characters.';
    }

    public function tooShortPasswordMessage () {
        return $this->message = 'Password has too few characters, at least 6 characters.';
    }

    public function notMatchingPasswordsMessage () {
        return $this->message = 'Passwords do not match.';
    }
}
