<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uberconference_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id=false)
	{
		self::$name = "uberconference";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://www.uberconference.com";
		$app->redirectionURL = "https://www.uberconference.com";
		
		return $app;
	}

	public function getCookie() {

		$browser = self::get_serialized_browser($this->user_id);

		$browser->post('https://www.uberconference.com/api/i1/login',
					json_encode(array(	"email" => $this->credentials->email,
							"password" => $this->credentials->password,
							"oauth" => "false")));

		$data = $browser->getCurrentCookieValue('RHSID00');

		self::update_serialized_browser($this->user_id, $browser);

		return(array('name' => 'RHSID00', 'value' => $data));
	}
}

?>
