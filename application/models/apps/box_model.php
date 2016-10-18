<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Box_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id) {
		self::$name = "box";
		self::$loginType = "client";

		$app = parent::init($user_id);

		if($app->credentials !== false) {
			$app->url = "https://app.box.com/logout";
		}

		return $app;
	}
}

?>
