<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Insightly_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id)
	{
		self::$name = "insightly";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "http://.insight.ly";
		
		return $app;
	}

	public function getCookie() {

		$browser = self::get_serialized_browser($this->user_id);

		$browser->post('https://login.insight.ly/User/AuthenticateForms',
					array(	'email' => $this->credentials->email,
							'password' => $this->credentials->password,
							'PersistentCookie' => 'yes'));

		$data = $browser->getCurrentCookieValue('Insightly');

		self::update_serialized_browser($this->user_id, $browser);

		$this->redirectionURL = $browser->getURL();

		return(array('name' => 'Insightly', 'value' => $data));
	}
}

?>
