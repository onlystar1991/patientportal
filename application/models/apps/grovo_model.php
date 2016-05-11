<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Grovo_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id=false)
	{
		self::$name = "grovo";
		self::$loginType = "client";

		$app = parent::init($user_id);

		if($app->credentials !== false) {
			$app->url = "https://app.grovo.com/logout";
		}
		
		return $app;
	}
}

?>
