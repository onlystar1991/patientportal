<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Thinkfree_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id=false)
	{
		self::$name = "thinkfree";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "http://member.thinkfree.com";
		$app->redirectionURL = "http://member.thinkfree.com/myoffice/goMyOffice.se";
		
		return $app;
	}

	public function getCookie() {
		$browser = self::get_serialized_browser($this->user_id);

		$browser->post('http://member.thinkfree.com/member/sign_in_box_action.action',
					array(	'redirect' => '/myoffice/goMyOffice.se',
							'smb_user' => $this->credentials->email,
							'smb_password' => $this->credentials->password,
							'saveID' => 'save'));

		$data = $browser->getCurrentCookieValue('smb_session');

		self::update_serialized_browser($this->user_id, $browser);

		return(array('name' => 'smb_session', 'value' => $data));
	}
}

?>
