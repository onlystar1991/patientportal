<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aerohive_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id=false)
	{
		self::$name = "aerohive";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://.aerohive.com";
		$app->redirectionURL = "https://cloud-va.aerohive.com/";
		
		return $app;
	}

	public function getCookie() {

		$browser = self::get_serialized_browser($this->user_id);

		$browser->post('https://cloud.aerohive.com/oauth/login',
					array(	'username' => $this->credentials->email,
							'password' => $this->credentials->password));

		$data = $browser->getCookieValue('https://.aerohive.com', '', 'oauth2AccessToken');

		self::update_serialized_browser($this->user_id, $browser);

		return(array('name' => 'oauth2AccessToken', 'value' => $data));
	}
}

?>
