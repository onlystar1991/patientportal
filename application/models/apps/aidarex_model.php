<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aidarex_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static $blockTopNavigation = true;
	
	public static function init($user_id=false)
	{
		self::$name = "aidarex";
		self::$loginType = "client";

		$app = parent::init($user_id);

		if($app->credentials !== false) {
			$app->url = "https://secure.aidarex.com/dis/servlet/dis.Main";
		}
		
		return $app;
	}
}

?>
