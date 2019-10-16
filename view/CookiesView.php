<?php

namespace view;

class CookiesView {
	private static $cookieLoggedIn = 'LoginView::CookieLoggedIn';
    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $cookieRegistration = 'RegistrationView::CookieRegistration';

	public function loggedInCookie ($username) {
		setcookie(self::$cookieLoggedIn, $username, time() + 3600);
	}

	public function getLoggedInStatus () {
		return isset($_COOKIE[self::$cookieLoggedIn]);
	}

	public function getLoggedInCookie () {
		if ($this->getLoggedInStatus()) {
		    return $_COOKIE[self::$cookieLoggedIn];
		}
	}

	public function checkKeepMeLoggedInCookies () { 
		if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			return true;
		} else {
			return false;
		}
	}

	public function newUserRegistratedCookie ($username) {
		setcookie(self::$cookieRegistration, $username, time() + 3600);
	}

	public function getRegistratedCookie () {
		if (isset($_COOKIE[self::$cookieRegistration])) {
			return $_COOKIE[self::$cookieRegistration];
		}
	}

	public function killRegistratedCookie () {
		setcookie(self::$cookieRegistration, '', time() -3600);
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
			return true;
		} else {
			return false;
		}
	}

	public function verifyLoggedInUsernameCookie ($username) {
		if (password_verify($username, $_COOKIE[self::$cookieLoggedIn])) {
			return true;
		} else {
			return false;
		}
	}

}
