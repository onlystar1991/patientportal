<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sherpacrm_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id) {
		self::$name = "sherpacrm";
		self::$loginType = "client";

		$app = parent::init($user_id);

		$app->url = "http://training.sherpacrm.com/login";
		
		return $app;
	}
}

?>
