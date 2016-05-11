<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wordpress_model extends App_base_model {

	public static $name;
	public static $loginType;
	
	public static function init($user_id=false) {

		self::$name = "wordpress";
		self::$loginType = "client";

		$app = parent::init($user_id);
		$availableBlogs = new stdClass();

		$CI =& get_instance();
		$CI->db->where('user_id', $user_id);
		$query = $CI->db->get("app_" . self::$name);

		$returned_value = $query->result();

		if(!$returned_value) {
			$app->credentials = false;
		} else {
			foreach ($returned_value as $value) {
				$value = self::decrypt_row($value);
				$name = $value->name;
				$value->url = $value->link . "/" . $value->login_url;
				$availableBlogs->$name = $value;
			}

			$app->credentials = $availableBlogs;
		}

		return $app;
	}

	public function updateCredentials($data) {

		$resultsArray = array();

		if(isset($data['apps'])) {

			$this->db->delete('app_wordpress', array('user_id' => $this->user_id));

			foreach ($data['apps'] as $value) {
				if(!(empty($value['name']) || empty($value['link']) || empty($value['username']) || empty($value['password']))) {
					$database_array = array('user_id' 	=> $this->user_id,
											'name'		=> $value['name'],
											'link'		=> $value['link'],
											'username'	=> $value['username'],
											'password'	=> $value['password']);

					if(!empty($value['login'])) { $database_array['login_url'] = $value['login']; }
					else { $database_array['login_url'] = 'wp-login.php'; }

					$database_array = self::encrypt_row($database_array);

					$this->db->insert('app_wordpress', $database_array);
				}
			}

			return true;
		}

		return false;
	}
}

?>
