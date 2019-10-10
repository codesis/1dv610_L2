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

	public function __construct (\view\RegisterView $registerView, \view\MessageView $messageView, \model\Database $database) {
        $this->registerView = $registerView;
        $this->messageView = $messageView;
        $this->database = $database;

        $this->database->connectToDatabase();
    }

	
    private function registerNewUser () {
	}

}
