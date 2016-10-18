<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Officebrands_model extends CI_Model {
	
	public $id;
	public $office_id;
	public $brand_name;
	public $address;
	public $city;
	public $state;
	public $zip_code;
	public $phone;

	public function __construct()
	{
		parent::__construct();
	}

	public static function init($key = false, $value = false) {
		$keysArray = array('id', 'office_id');
		$dbArray = array('id', 'office_id', 'brand_name', 'address', 'city', 'state', 'zip_code', 'phone');

		if($key == false) { return new Officebrands_model(); }
		if(!in_array($key, $keysArray)) { return false; }

		$CI =& get_instance();
		$CI->db->where($key, $value);
		$query = $CI->db->get("brands");

		if($query->num_rows() <= 0) { return false; }

		$officeDB = $query->result(); $officeDB = $officeDB[0];

		$office = new Officebrands_model();

		$columns = $CI->db->list_fields('brands');

		foreach ($dbArray as $key) {
			$office->$key = $officeDB->$key;
		}

		return $office;

		return null;
	}

	public static function all() {
		$CI =& get_instance();

		$query = $CI->db->get('brands');
		$returned_value = $query->result();

		if(!$returned_value) return false;
		return($returned_value);
	}

	public static function create($data) {

		$whitelist = array('office_id',
							'brand_name',
							'address',
							'city',
							'state',
							'zip_code',
							'phone');

		$data = array_intersect_key($data, array_flip($whitelist));

		$CI =& get_instance();

		if($CI->db->insert('brands', $data)) { return $CI->db->insert_id(); }
		return false;
	}

	public function update($data = false) {
		if(empty($data)) { return false; }
		if(empty(array_keys($data))) { return false; }

		$columns = $this->db->list_fields('brands');
		if(array_values(array_intersect($columns, array_keys($data))) != array_values(array_keys($data))) { return false; }

		$this->db->where('id', $this->id);
		$this->db->update('brands', $data);

		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}
}

?>