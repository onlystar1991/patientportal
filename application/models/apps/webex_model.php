<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Webex_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static $blockTopNavigation = true;

	public static function init($user_id)
	{
		self::$name = "webex";
		self::$loginType = "server";

		$app = new self();
		$app->user_id = $user_id;
		$app->credentials = new StdClass;

		$app->credentials->domain = "transcensus";
		$app->credentials->username = "achesler";
		$app->credentials->password = "Shenap79";

		$app->url = "https://.webex.com";
		$app->redirectionURL = "https://" . $app->credentials->domain . ".webex.com/";
		
		return $app;
	}

	public function getCookie() {

		$browser = new SimpleBrowser();

		//In webex's case, an extra parameter is added to the login page link where we are not aware of
		//We're redirected to the correct page once we go to the one with the link only

		$browser->get('https://' . $this->credentials->domain . '.webex.com/dispatcher/dispatcher.do?siteurl=' . $this->credentials->domain);
		$loginURL = substr($browser->getURL(), 0, 50) . "login/login.do";

		$browser->addHeader("User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.125 Safari/537.36");
		$browser->addHeader("Referer: https://transcensus.webex.com/mw0401lsp13/mywebex/login/login.do?siteurl=transcensus&Rnd=0.053808982484042645");
		$browser->addHeader("Origin: https://transcensus.webex.com");
		$browser->addHeader("Host: transcensus.webex.com");
		$browser->addHeader("Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8");
		$browser->addHeader("Accept-Encoding:gzip, deflate");
		$browser->addHeader("Accept-Language:en-US,en;q=0.8,ar;q=0.6,zh-CN;q=0.4");
		$browser->addHeader("Upgrade-Insecure-Requests: 1");
		$browser->addHeader("User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.125 Safari/537.36");
		$browser->addHeader("Connection: keep-alive");
		$browser->addHeader("Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8");

		$browser->post($loginURL,
					array(	'userName' => $this->credentials->username,
							'password' => $this->credentials->password,
							'savePwd' => 'on',
							'btnLogon' => 'Log In',
							'skipproductivity' => 'null',
							'oneclicklogin' => '',
							'allowAccountSignUp' => 'true',
							'returnUrl' => '',
							'postFrame' => '',
							'webofficeMWLI' => '',
							'webofficeURL' => '',
							'webofficeMU' => 'false',
							'siteurl' => $this->credentials->domain));

		$data = $browser->getCookieValue('https://.webex.com', '', 'ticket');

		$data = substr($data, 0, -1);

		if($data != false) {
			$data = "\\" . $data . '\\"';
		} else { $data = ""; }

		return(array('name' => 'ticket', 'value' => $data));
	}
}

?>
