<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sendinc_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public function __construct()
	{
		self::$name = "sendinc";
		parent::__construct();

		require_once('simpletest/browser.php');
	}

	public static function init($user_id)
	{
		self::$name = "sendinc";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://www.sendinc.com";
		$app->redirectionURL = "https://www.sendinc.com/compose";
		
		return $app;
	}

	public function getCookie() {
		$browser = new SimpleBrowser();

		$browser->post("https://www.sendinc.com/secure/accounts/logIn",
					array(	'email' => $this->credentials->email,
							'password' => $this->credentials->password,
							'remember' => 1));

		$data = $browser->getCurrentCookieValue('send');

		return(array('name' => 'send', 'value' => $data));
	}
}

?>
