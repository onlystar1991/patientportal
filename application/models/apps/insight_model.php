<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Insight_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id)
	{
		self::$name = "insight";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "http://.practicefusion.com";
		$app->redirectionURL = "https://insight.practicefusion.com/";
		
		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();

		$browser->get('https://insight.practicefusion.com/accounts/login/');
		$csf = $browser->getFieldByName('csrfmiddlewaretoken');

		$browser->post("https://insight.practicefusion.com/accounts/login/",
					array(	'csrfmiddlewaretoken' => $csf,
							'next' => '',
							'username' => $this->credentials->email,
							'password' => $this->credentials->password));

		$data = $browser->getCurrentCookieValue('sessionid');

		return(array('name' => 'sessionid', 'value' => $data));
	}
}

?>
