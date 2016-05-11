<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pandadoc_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id=false)
	{
		self::$name = "pandadoc";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://app.pandadoc.com";
		$app->redirectionURL = "https://app.pandadoc.com/a/#/dashboard/";
		
		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();

		$browser->get('https://app.pandadoc.com/login/');
		$csf = $browser->getFieldByName('csrfmiddlewaretoken');

		$browser->post("https://app.pandadoc.com/login/",
					array(	'csrfmiddlewaretoken' => $csf,
							'remember_me' => 'on',
							'next' => '',
							'username' => $this->credentials->email,
							'password' => $this->credentials->password));

		$data = $browser->getCurrentCookieValue('pd-session-key');

		return(array('name' => 'pd-session-key', 'value' => $data));
	}
}

?>
