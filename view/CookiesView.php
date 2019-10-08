<?php

namespace view;

class CookiesView {
    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';

	public function keepMeLoggedIn () {
		setcookie(self::$cookieName, $_POST[self::$name], time() + 3600);
		setcookie(self::$cookiePassword, $this->hash, time() + 3600);
	}

	public function returnWithCookies () {
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
