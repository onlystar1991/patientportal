<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Neocertified_model extends App_base_model {

	public static $name;
	public static $loginType;
	public static $blockTopNavigation = true;

	public static function init($user_id) {
		self::$name = "neocertified";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "http://med1.neocertifiedmail.com/";
		$app->redirectionURL = "https://med1.neocertifiedmail.com/Default.aspx?PageName=Home";
		
		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();

		$browser->get("https://med1.neocertifiedmail.com/Default.aspx?PageName=Home");
		$browser->setField('ctl00$ContentCenter$ctl00$txtUsername', $this->credentials->email);
		$browser->setField('ctl00$ContentCenter$ctl00$txtPassword', $this->credentials->password);
		$browser->clickSubmit('Sign in');

		$data = $browser->getCurrentCookieValue('.ASPXAUTH');

		return(array('name' => '.ASPXAUTH', 'value' => $data));
	}
}

?>
