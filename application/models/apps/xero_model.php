<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Xero_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static $blockTopNavigation = true;

	public static function init($user_id)
	{
		self::$name = "xero";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://go.xero.com";
		$app->redirectionURL = "https://go.xero.com/Dashboard/default.aspx";
		
		return $app;
	}

	public function getCookie() {
		$response = shell_exec('phantomjs /usr/share/nginx/html/ALEX/application/models/phantomjs/xero.js '
			. escapeshellarg($this->credentials->email) . ' '
			. escapeshellarg($this->credentials->password));

		$response = trim(preg_replace('/\s\s+/', ' ', $response));

		$pattern = '/(?<="FedAuth", "path": "\/", "secure": false, "value": ")([\s\S]*?)(?=")/';
		preg_match($pattern, $response, $matches);

		$data = $matches[0];

		return(array('name' => 'FedAuth', 'value' => $data));
	}
}

?>
