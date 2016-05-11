<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_base_model extends CI_Model {

	public static $name;
	public static $loginType;
	public static $blockTopNavigation = false;

	public $user_id;
	public $credentials;
	public $url;
	public $redirectionURL;
	public $cookiesToRemove = array();

	private $brandsWithPermission;
	
	public function __construct()
	{
		parent::__construct();

		$this->credentials = new StdClass;
		require_once('simpletest/browser.php');
	}

	public static function init($user_id=false) {

		$app = new static();
		$app->credentials = false;

		$CI =& get_instance();

		if($user_id !== false) {
			$app->user_id = $user_id;

			$CI->db->where('user_id', $user_id);
			$query = $CI->db->get('app_' . static::$name);

			$returned_value = $query->result();

			if($returned_value) {
				$returned_value = $returned_value[0];
				$returned_value = static::decrypt_row($returned_value);
				unset($returned_value->user_id);
				$app->credentials = $returned_value;
			}
		}

		$app->brandsWithPermission = array();

		$CI->db->where('app_name', static::$name);
		$query = $CI->db->get("brands_apps_permissions");

		$returned_value = $query->result();

		foreach($returned_value as $row) {
			$app->brandsWithPermission[$row->brand_id] = $row->can_access;
		}

		return $app;
	}

	public function __get($name) {
		if($name == "brandsWithPermission")
			return $this->brandsWithPermission;

		return false;
	}

	public function set_brand_permission($brand_id, $value) {
		$this->brandsWithPermission[$brand_id] = $value;

		$CI =& get_instance();
		$CI->db->where("app_name", static::$name);
		$CI->db->where("brand_id", $brand_id);
		$query = $CI->db->get("brands_apps_permissions");

		if($query->result()) {
			$CI->db->where("app_name", static::$name);
			$CI->db->where("brand_id", $brand_id);
			$CI->db->update("brands_apps_permissions", array("can_access" => $value));
		} else {
			$insertionArray = array("app_name" => static::$name,
									"brand_id" => $brand_id,
									"can_access" => $value);

			$CI->db->insert("brands_apps_permissions", $insertionArray);
		}
	}

	public static function availableApps() {
		$CI =& get_instance();
		$apps = $CI->db->list_tables();
		$apps = array_filter($apps, function($value) {
			return strpos($value, 'app_') === 0;
		});

		foreach($apps as &$value) {
			$value = substr($value, 4);
		}

		return $apps;
	}

	protected static function encrypt_row($row) {
		$CI =& get_instance();
		$CI->load->library('encrypt');

		foreach ($row as $key => &$value) {
			if($key != 'user_id' && $key != 'id') {
				$value = $CI->encrypt->encode($value);
			}
		}

		return $row;
	}

	protected static function decrypt_row($row) {
		$CI =& get_instance();
		$CI->load->library('encrypt');

		foreach ($row as $key => &$value) {
			if($key != 'user_id' && $key != 'id') {
				$value = $CI->encrypt->decode($value);
			}
		}

		return $row;
	}

	protected static function get_serialized_browser($user_id) {
		$CI =& get_instance();
		$CI->db->where('user_id', $user_id);
		$query = $CI->db->get('browsers');

		$returned_value = $query->result();

		if(!$returned_value) {
			$browser = new SimpleBrowser();
			$browser->setConnectionTimeout(5);
			return $browser;
		}
		
		return unserialize(base64_decode($returned_value[0]->serialization));
	}

	protected static function update_serialized_browser($user_id, $browser) {
		$CI =& get_instance();
		$CI->db->delete('browsers', array('user_id' => $user_id)); 

		$data = array(
			'user_id' => $user_id,
			'serialization' => base64_encode(serialize($browser))
		);

		return $CI->db->insert('browsers', $data);
	}

	public function updateCredentials($data) {
		if(empty($data)) { return false; }
		if(empty(array_keys($data))) { return false; }

		$columns = $this->db->list_fields('app_' . static::$name);
		$keys = array_intersect($columns, array_keys($data));
		$dbArray = array();

		foreach ($keys as $key) {
			$dbArray[$key] = $data[$key];
		}

		$dbArray = self::encrypt_row($dbArray);

		if($this->credentials == false) {
			$dbArray["user_id"] = $this->user_id;
			$this->db->insert('app_' . static::$name, $dbArray);
		} else {
			$this->db->where('user_id', $this->user_id);
			$this->db->update('app_' . static::$name, $dbArray);
		}

		foreach ($dbArray as $key => $value) {
			$this->credentials->$key = $value;
		}
	}
}

?>
