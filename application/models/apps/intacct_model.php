<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Intacct_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static $blockTopNavigation = true;

	public static function init($user_id=false) {
		self::$name = "intacct";
		self::$loginType = "client";

		$app = parent::init($user_id);

		if($app->credentials !== false) {
			if($app->credentials->trial == true) {
				$app->url = "https://trial.intacct.com/ia/acct/login.phtml"; }
			else { $app->url = "https://www.intacct.com/ia/acct/login.phtml?.done=frameset.phtml"; }
		}
		
		return $app;
	}
}

?>
