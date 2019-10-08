<?php

namespace controller;

require_once('LoginController.php');
require_once('./model/Database.php');
require_once('./view/DateTimeView.php');
require_once('./view/LayoutView.php');
require_once('./view/MessageView.php');
require_once('./view/LoginView.php');

class AppController {
    private $isLoggedIn = false;
    
    private $loginController;
    private $dateTimeView;
    private $layoutView;
    private $messageView;
    private $loginView;

    private $message;
    
    public function __construct ($database) {
        $this->dateTimeView = new \view\DateTimeView();
        $this->layoutView = new \view\LayoutView();
        $this->messageView = new \view\MessageView();
        $this->loginView = new \view\LoginView();

        $this->loginController = new \controller\LoginController($this->loginView, $this->messageView, $database);
    }

    public function route () {
        if ($this->loginView->login()) {
            $this->isLoggedIn = $this->loginController->login();
            $this->message = $this->loginController->getMessage();
        }
        $response = $this->loginView->response($this->isLoggedIn, $this->message);
        $this->layoutView->render($this->isLoggedIn, $this->loginView, $this->dateTimeView, $this->message, $response);
    }
}
