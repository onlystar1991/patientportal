<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get_healthchecks() {
		$test = file_get_contents('http://implementation.patientportal.us/' . IMPLEMENTATION_TESTING_FEED);
		return json_decode($test, true);
	}
}

?>