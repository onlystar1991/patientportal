<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Practicefusion_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id) {
		self::$name = "practicefusion";
		self::$loginType = "client";

		$app = parent::init($user_id);

		$app->url = "https://pfws.practicefusion.com/apps/ehr/#/login";
		
		return $app;
	}
}

?>
