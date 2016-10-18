<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enquire_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id)
	{
		self::$name = "enquire";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "http://account.enquiresolutions.com";
		$app->redirectionURL = "https://account.enquiresolutions.com/dashboard";
		
		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();

		$browser->post("https://account.enquiresolutions.com/Account/LogOn",
					array(	'UserName' => $this->credentials->email,
							'Password' => $this->credentials->password,
							'ReturnUrl' => '/'));

		$data = $browser->getCurrentCookieValue('.ASPXAUTH');

		return(array('name' => '.ASPXAUTH', 'value' => $data));
	}
}

?>
