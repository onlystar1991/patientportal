<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Eldermark_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id=false)
	{
		self::$name = "eldermark";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "http://dashboard.eldermark.com";
		$app->redirectionURL = "http://dashboard.eldermark.com/demo";

		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();

		$browser->addHeader("Cotent-Type: application/json");
		$browser->post("http://dashboard.eldermark.com/login",
					array(	"username" => $this->credentials->username,
							"password" => $this->credentials->password,
							"communityID" => 118,
							"gmtOffSet" => -120));

		$data = $browser->getCurrentCookieValue('sessionId');

		return(array('name' => 'sessionId', 'value' => $data));
	}
}

?>
