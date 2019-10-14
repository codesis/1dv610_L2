<?php

namespace view;

class CookiesView {
    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';

	public function loggedInCookie ($username) {
		setcookie(self::$cookieName, $username, time() + 3600);
	}

	public function getLoggedInCookie () {
		if (!isset($_COOKIE[self::$cookieName])) {
			return false;
		} else {
			return true;
		}
	}

	public function getCookiesBool () {
		if (!isset($_COOKIE[self::$cookiePassword])) {
			return false;
		} else {
			return true;
		}
	}
	
	public function keepMeLoggedIn ($username, $password) {
		setcookie(self::$cookieName, $username, time() + 3600);
		setcookie(self::$cookiePassword, $password, time() + 3600);
	}

	public function killCookies ($username, $password) {
		setcookie(self::$cookieName, $username, time() - 3600);
		setcookie(self::$cookiePassword, $password, time() - 3600);
	}

	public function returnWithCookies ($username, $password) {
		if ($_COOKIE[self::$cookieName] == $username && password_verify($password, $_COOKIE[self::$cookiePassword])) {
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
