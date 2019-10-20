<?php

namespace view;

class CookiesView {
	private static $cookieLoggedIn = 'LoginView::CookieLoggedIn';
	private static $cookieUserLoggedIn = 'LoginView::CookieUserLoggedIn';
    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $cookieRegistration = 'RegistrationView::CookieRegistration';
	private static $phpSessCookie = 'PHPSESSID';

	public function loggedInCookie ($username) {
		setcookie(self::$cookieLoggedIn, $username, time() + 3600);
	}

	public function setCookieUserLoggedIn ($username) {
		setcookie(self::$cookieUserLoggedIn, $username, time() + 3600);
	}

	private function checkIfUserCookieExist () {
		return isset($_COOKIE[self::$cookieUserLoggedIn]);
	}

	public function getCookieUserLoggedIn () {
		if ($this->checkIfUserCookieExist()) {
		    return $_COOKIE[self::$cookieUserLoggedIn];
		}
	}

	public function getLoggedInStatus () {
		return isset($_COOKIE[self::$cookieLoggedIn]);
	}

	public function getLoggedInCookie () {
		if ($this->getLoggedInStatus()) {
		    return $_COOKIE[self::$cookieLoggedIn];
		}
	}

	public function checkPHPSessIdCookie () {
		return isset($_COOKIE[self::$phpSessCookie]);
	}
	

	public function checkKeepMeLoggedInCookies () { 
		return isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]);
	}

	public function getCookieName () {
		if (isset($_COOKIE[self::$cookieName])) {
			return $_COOKIE[self::$cookieName];
		}
	}

	public function getCookiePassword () {
		if (isset($_COOKIE[self::$cookiePassword])) {
			return $_COOKIE[self::$cookiePassword];
		}
	}

	public function newUserRegistratedCookie ($username) {
		setcookie(self::$cookieRegistration, $username, time() + 1);
	}

	public function getNewUserCookie () {
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

	public function killCookies () {
		setcookie(self::$cookieName, '', time() - 3600);
		setcookie(self::$cookiePassword, '', time() - 3600);
		setcookie(self::$cookieLoggedIn, '', time() - 3600);
		setcookie(self::$cookieUserLoggedIn, '', time() - 3600);

		session_regenerate_id(self::$phpSessCookie);
		session_unset();
	}

	public function returnWithCookies () {
		if (password_verify($this->getCookieName(), $this->getLoggedInCookie())) {
			return true;
		}
	}

	public function verifyLoggedInUsernameCookie () {
		if (password_verify($this->getCookieUserLoggedIn(), $this->getLoggedInCookie())) {
			return true;
		} 
	}

}
