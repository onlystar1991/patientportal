<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Yammer_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static $blockTopNavigation = true;
	
	public static function init($user_id) {
		self::$name = "yammer";
		self::$loginType = "client";

		$app = parent::init($user_id);

		if($app->credentials !== false) {
			$app->url = "https://www.yammer.com/" . $app->credentials->domain . "/?show_login=true";
		}
		
		return $app;
	}
}

?>
