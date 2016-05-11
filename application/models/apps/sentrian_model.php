<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sentrian_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id=false) {
		self::$name = "sentrian";
		self::$loginType = "client";

		$app = parent::init($user_id);

		$app->url = "https://evaluate.sentrian.com/login/";
		
		return $app;
	}
}

?>
