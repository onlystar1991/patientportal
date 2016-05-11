<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clearcare_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id=false)
	{
		self::$name = "clearcare";
		self::$loginType = "server";

		$app = parent::init($user_id);

		if($app->credentials) {
			$app->url = "https://" . $app->credentials->subdomain . ".clearcareonline.com";
			$app->redirectionURL = "https://" . $app->credentials->subdomain . ".clearcareonline.com/dashboard/";
		}

		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();

		$browser->get('https://' . $this->credentials->subdomain . '.clearcareonline.com/login/');
		$browser->setField('username', $this->credentials->email);
		$browser->setField('password', $this->credentials->password);
		$browser->clickSubmit('Login');

		$data = $browser->getCurrentCookieValue('cc_session_id');

		return(array('name' => 'cc_session_id', 'value' => $data));
	}
}

?>
