<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('bluestep_model.php');

class Bluestep_admin_1_model extends Bluestep_model {
	
	public static $name;
	public static $loginType;
	
	public static function init($user_id) {
		self::$name = "bluestep_admin_1";
		$app = parent::init($user_id);
		return $app;
	}
}

?>
