<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absorblms_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id=false)
	{
		self::$name = "absorblms";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://transcensus.myabsorb.com";
		$app->redirectionURL = "https://transcensus.myabsorb.com/";
		
		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();

		$browser->get('https://transcensus.myabsorb.com/#/login');
		$rvt = $browser->getFieldByName('__RequestVerificationToken');

		$browser->post("https://transcensus.myabsorb.com/Learn/Account/Login",
					array(	'__RequestVerificationToken' => $rvt,
							'username' => $this->credentials->email,
							'password' => $this->credentials->password,
							'rememberMe' => 'false'));

		$data = $browser->getCurrentCookieValue('.ASPXAUTH');

		return(array('name' => '.ASPXAUTH', 'value' => $data));
	}
}

?>
