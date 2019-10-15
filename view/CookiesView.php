<?php

namespace view;

class CookiesView {
	private static $cookieLoggedIn = 'LoginView::CookieLoggedIn';
    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';

	public function loggedInCookie ($password) {
		setcookie(self::$cookieLoggedIn, $password, time() + 3600);
	}

	public function getLoggedInStatus () {
		return isset($_COOKIE[self::$cookieLoggedIn]);
	}

	public function getLoggedInCookie () {
		if ($this->getLoggedInStatus()) {
		    return $_COOKIE[self::$cookieLoggedIn];
		}
	}

	public function checkKeepMeLoggedInCookies ($username, $password) { 
		if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			$this->returnWithCookies($username, $password);
		}
	}
	
	public function keepMeLoggedIn ($username, $password) {
		setcookie(self::$cookieName, $username, time() + 3600);
		setcookie(self::$cookiePassword, $password, time() + 3600);
	}

	public function killCookies ($username, $password) {
		setcookie(self::$cookieName, $username, time() - 3600);
		setcookie(self::$cookiePassword, $password, time() - 3600);
		setcookie(self::$cookieLoggedIn, '', time() - 3600);
		session_unset();
		session_destroy();
	}

	public function returnWithCookies ($username, $password) { this needs to be fixed 
		if ($_COOKIE[self::$cookieName] == $username && password_verify($password, $_COOKIE[self::$cookiePassword])) {
			return true;
		} 
		else {
			// setcookie(self::$cookieName, '', time() - 3600);
			// setcookie(self::$cookiePassword, '', time() -3600);
			return false;
		}	
	}

}
