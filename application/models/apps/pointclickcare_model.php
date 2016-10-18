<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pointclickcare_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id) {
		self::$name = "pointclickcare";
		self::$loginType = "client";

		$app = parent::init($user_id);

		$app->url = "https://login.pointclickcare.com/home/userLogin.xhtml";
		
		return $app;
	}
}

?>
