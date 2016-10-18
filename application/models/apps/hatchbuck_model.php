<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hatchbuck_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id) {
		self::$name = "hatchbuck";
		self::$loginType = "client";

		$app = parent::init($user_id);

		$app->url = "https://app.hatchbuck.com/Login/LogOff";
		
		return $app;
	}
}

?>
