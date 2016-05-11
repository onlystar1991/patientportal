<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Healthtap_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id=false) {
		self::$name = "healthtap";
		self::$loginType = "client";

		$app = parent::init($user_id);

		$app->url = "https://www.healthtap.com/login";
		$app->cookiesToRemove = array("healthtap.com");
		
		return $app;
	}
}

?>
