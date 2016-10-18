<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bluestep_model extends App_base_model {

	public static $blockTopNavigation = true;
	
	public static function init($user_id)
	{
		static::$loginType = "server";

		$app = parent::init($user_id);

		if($app->credentials !== false) {
			$app->url = "https://" . $app->credentials->subdomain . ".bluestep.net";
			$app->redirectionURL = "https://" . $app->credentials->subdomain . ".bluestep.net/shared/home.jsp";
		}

		return $app;
	}

	public function getCookie() {

		$response = shell_exec('phantomjs /usr/share/nginx/html/ALEX/application/models/phantomjs/bluestep.js '
			. escapeshellarg($this->credentials->username) . ' '
			. escapeshellarg($this->credentials->password). ' '
			. escapeshellarg($this->credentials->subdomain));

		$response = trim(preg_replace('/\s\s+/', ' ', $response));
		$response = json_decode($response, true);

		foreach ($response as $value) {
			if($value['domain'] == $this->credentials->subdomain . ".bluestep.net") {
				$data = $value['value'];
				return(array('name' => 'JSESSIONID', 'value' => $data));
			}
		}

		return false;
	}
}

?>
