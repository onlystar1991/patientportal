<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lua_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id)
	{
		self::$name = "lua";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "http://.getlua.com";
		$app->redirectionURL = "https://getlua.com/main";
		
		return $app;
	}

	public function getCookie() {
		$browser = new SimpleBrowser();

		$browser->get('https://getlua.com/signin');
		$authenticity_token = $browser->getFieldByName("authenticity_token");

		$browser->post("https://getlua.com/signin",
					array(	'user[email]' => $this->credentials->email,
							'user[password]' => $this->credentials->password,
							'authenticity_token' => $authenticity_token));

		$data = $browser->getCurrentCookieValue('_lua_session_production');

		return(array('name' => '_lua_session_production', 'value' => $data));
	}
}

?>
