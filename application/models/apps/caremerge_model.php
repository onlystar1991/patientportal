<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Caremerge_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id) {
		self::$name = "caremerge";
		self::$loginType = "client";

		$app = new self();
		$app->user_id = $user_id;
		$app->credentials = false;
		$app->url = 'http://www.caremerge.com/web/';
		
		return $app;
	}
}

?>
