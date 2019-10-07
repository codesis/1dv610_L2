<?php

class CookiesView {
    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';

    	/**
	 * Create cookie and new message
	 * 
	 * Should be called after a login attempt has med determined with Keep me logged in checked
	 */
	private function keepMeLoggedIn () {
		setcookie(self::$cookieName, $_POST[self::$name], time() + 3600);
		setcookie(self::$cookiePassword, $this->hash, time() + 3600);
	}

    	/**
	 * Checks wether cookies data is correct or faulty
	 * Kills cookies if cookie data is uncorrect or faulty
	 * 
	 * Should be called upon returning to page with cookie data
	 */
	private function returnWithCookies () {
		if ($_COOKIE[self::$cookieName] == 'Admin' && password_verify('Password', $_COOKIE[self::$cookiePassword])) {
			if (!isset($_SESSION['username'])) {
				$this->message = 'Welcome back with cookie';
			}
			$_SESSION['username'] = $_COOKIE[self::$cookieName];
		} 
		else {
			$this->message = 'Wrong information in cookies';
			setcookie(self::$cookieName, '', time() - 3600);
			setcookie(self::$cookiePassword, '', time() -3600);
		}	
	}

}
