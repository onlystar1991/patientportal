<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Grasshopper_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id=false)
	{
		self::$name = "grasshopper";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://.grasshopper.com";
		$app->redirectionURL = "https://portal.grasshopper.com/";

		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();
		$browser->setConnectionTimeout(5);

		//In grasshopper's case, an extra parameter is added to the login page link where we are not aware of
		//So we have to get the page first to include the hidden input values

		$browser->get('https://portal.grasshopper.com/login.aspx');

		$browser->setFieldByName('ctl00$MainContent$UserName', $this->credentials->email);
		$browser->setFieldByName('ctl00$MainContent$Password', $this->credentials->password);

		$browser->clickSubmitByName('ctl00$MainContent$signInButton');

		$data = $browser->getCookieValue('https://.grasshopper.com', '', '.GRASSHOPPERAUTH');

		return(array('name' => '.GRASSHOPPERAUTH', 'value' => $data));
	}
}

?>
