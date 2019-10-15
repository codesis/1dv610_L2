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

	public function returnWithCookies ($username, $password) {
		if ($_COOKIE[self::$cookieName] == $username && password_verify($password, $_COOKIE[self::$cookiePassword])) {
			if ($this->getLoggedInStatus()) {
				$this->message = 'Welcome back with cookie';
			}
		} 
		else {
			$this->message = 'Wrong information in cookies';
			setcookie(self::$cookieName, '', time() - 3600);
			setcookie(self::$cookiePassword, '', time() -3600);
		}	
	}

}
