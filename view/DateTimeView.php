<?php

namespace view;

class DateTimeView {


	public function show() {
		\date_default_timezone_set('Europe/Stockholm');
		$dayOfWeek = date('l');
		$dateOfDay = date('jS');
		$month = date('F ');
		$year = date('Y');
		$time = date('H:i:s');
		
		$timeString = $dayOfWeek . ', the ' . $dateOfDay . ' of ' . $month . $year . ', The time is ' . $time;

		return '<p>' . $timeString . '</p>';
	}
}
