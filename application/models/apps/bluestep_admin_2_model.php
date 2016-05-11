<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('bluestep_model.php');

class Bluestep_admin_2_model extends Bluestep_model {
	
	public static $name;
	public static $loginType;
	
	public static function init($user_id=false) {
		self::$name = "bluestep_admin_2";
		$app = parent::init($user_id);
		return $app;
	}
}

?>
