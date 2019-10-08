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
}
