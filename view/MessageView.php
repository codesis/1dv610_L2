<?php

namespace view;

class MessageView {
    private $message;
    private $username = 'Username';
    private $password = 'Password';
    private $isMissing = ' is missing';
    private $characters = 'characters';

    public function welcomeMessage () {
        return $this->message = 'Welcome';
    }

    public function missingUsernameMessage () {
        return $this->message = $this->username . $this->isMissing;
    }

    public function missingPasswordMessage () {
        return $this->message = $this->password . $this->isMissing;
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
        return $this->message = $this->username . ' has too few ' . $this->characters . ' , at least 3 ' . $this->characters . '.';
    }

    public function invalidCharacterInUsername () {
        return $this->message = $this->username . ' contains invalid ' . $this->characters . '.';
    }

    public function tooShortPasswordMessage () {
        return $this->message = $this->password . ' has too few ' . $this->characters . ', at least 6 ' . $this->characters . '.';
    }

    public function notMatchingPasswordsMessage () {
        return $this->message = $this->password . 's do not match.';
    }
}
