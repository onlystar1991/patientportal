<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Healthfusion_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id) {
		self::$name = "healthfusion";
		self::$loginType = "client";

		$app = new self();
		$app->user_id = $user_id;
		$app->credentials = false;
		$app->url = 'https://www.healthfusion.com/';
		
		return $app;
	}
}

?>
