<?php

require_once(APPPATH . '/controllers/test/Toast.php');
require_once(APPPATH . '/controllers/user.php');

class user_test extends Toast
{
	private $UserController;

	function __construct()
	{
		parent::__construct(__FILE__); // Remember this
		$this->UserController = new User(true);
	}

	function _pre() {

		//Preparing unit test user database entry

		$data = array (
			'office_id' => '987654321',
			'brand_name' => 'Test',
			'address' => 'Test Address',
			'city' => 'Test',
			'state' => 'TE',
			'zip_code' => '23456',
			'phone' => '5555555555'
		);

		echo $this->db->insert('brands', $data);
	}

	function test_validatePhoneNumber()
	{
		$result = $this->UserController->validatePhoneNumber('555-555-5555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('5555-555-555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('(555) 555-555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('5555-5555-5555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('55-555-5555-5555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('5555-5555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('555-555-555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('55555-555-555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('5555555555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('555555555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('5 555 55555'); $this->_assert_true($result);
		$result = $this->UserController->validatePhoneNumber('5-555 55555'); $this->_assert_true($result);

		//Test for failure does not exist because the response is visual and should be implemented in integration testing
	}

	function test_officeid_exists()
	{
		$result = $this->UserController->officeid_exists('987654321'); $this->_assert_true($result);

		//Test for failure does not exist because the response is visual and should be implemented in integration testing
	}

	function _post() {

		//Remove unit test office from database
		$this->db->delete('brands', array('office_id' => '987654321')); 
	}
}

?>