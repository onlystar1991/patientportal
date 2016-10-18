<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tableau_model extends App_base_model {

	public static $name;
	public static $loginType;

	public static function init($user_id)
	{
		self::$name = "tableau";
		self::$loginType = "server";

		$app = parent::init($user_id);

		$app->url = "https://sso.online.tableau.com";
		$app->redirectionURL = "https://10ay.online.tableau.com/";
		
		return $app;
	}

	public function getCookie() {

		$response = shell_exec('phantomjs /usr/share/nginx/html/ALEX/application/models/phantomjs/tableau.js '
			. escapeshellarg($this->credentials->email) . ' '
			. escapeshellarg($this->credentials->password));

		if(strlen($response) < 10) { return(array('name' => 'JSESSIONID', 'value' => " ")); }
		$response = trim(preg_replace('/\s\s+/', ' ', $response));

		$pattern = '/(?<="JSESSIONID", "path": "\/", "secure": true, "value": ")([\s\S]*?)(?=")/';
		preg_match($pattern, $response, $matches);

		$data = $matches[0];

		return(array('name' => 'JSESSIONID', 'value' => $data));
	}
}

?>
