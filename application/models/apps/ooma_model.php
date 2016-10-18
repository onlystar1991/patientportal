<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ooma_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id) {
		self::$name = "ooma";
		self::$loginType = "client";

		$app = parent::init($user_id);

		$app->url = "https://office.ooma.com/login";
		
		return $app;
	}
}

?>
