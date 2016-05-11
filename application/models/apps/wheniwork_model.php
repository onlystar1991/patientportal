<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wheniwork_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id=false)
	{
		self::$name = "wheniwork";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://app.wheniwork.com/";
		$app->redirectionURL = "https://app.wheniwork.com/";
		
		return $app;
	}

	public function getCookie() {
		$browser = self::get_serialized_browser($this->user_id);

		$browser->post('https://app.wheniwork.com/login',
					array(	'email' => $this->credentials->email,
							'password' => $this->credentials->password));

		$data = $browser->getCurrentCookieValue('wheniwork_cred');

		self::update_serialized_browser($this->user_id, $browser);

		return(array('name' => 'wheniwork_cred', 'value' => $data));
	}
}

?>
