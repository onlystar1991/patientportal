<?php

require_once(APPPATH . '/controllers/test/Toast.php');
require_once(APPPATH . '/controllers/user.php');

class user_model_test extends Toast
{
	private $UserController;

	function __construct()
	{
		parent::__construct(__FILE__); // Remember this
		$this->UserController = new User(true);
	}

	function _pre() {

		//Adding office to DB

		$data = array (
			'office_id' => '987654321',
			'brand_name' => 'Test',
			'address' => 'Test Address',
			'city' => 'Test',
			'state' => 'TE',
			'zip_code' => '23456',
			'phone' => '5555555555'
		);

		$this->db->insert('brands', $data);

		//Adding user to DB

		$data = array (
			'first_name' => 'Unit',
			'last_name' => 'Test',
			'username' => 'unit_test_user_pre',
			'email' => 'unit_test@unlicrea.com',
			'password' => md5('unit_test_password'),
			'office_phone' => '555-555-5555',
			'cell_phone' => '555-555-5555',
			'user_role' => 'Doctor',
			'office_id' => '987654321'
		);

		$this->db->insert('user', $data);
	}

	function test_register() {
		$_POST = array (
			'first_name' => 'Unit',
			'last_name' => 'Test',
			'user_name' => 'unit_test_user',
			'email_address' => 'unit_test@unlicrea.com',
			'password' => 'unit_test_password',
			'office_phone' => '555-555-5555',
			'cell_phone' => '555-555-5555',
			'user_role' => 'Doctor',
			'office_id' => '987654321'
		);

		$this->_assert_true($this->UserController->user_model->add_user());
		$this->UserController->user_model->login('unit_test_user', 'unit_test_password');

		$userdata = $this->UserController->user_model->get_user_data($this->UserController->session->userdata['user_id']);

		$this->_assert_equals($userdata->first_name, 'Unit');
		$this->_assert_equals($userdata->last_name, 'Test');
		$this->_assert_equals($userdata->username, 'unit_test_user');
		$this->_assert_equals($userdata->email, 'unit_test@unlicrea.com');
		$this->_assert_equals($userdata->password, md5('unit_test_password'));
		$this->_assert_equals($userdata->office_phone, '555-555-5555');
		$this->_assert_equals($userdata->cell_phone, '555-555-5555');
		$this->_assert_equals($userdata->user_role, 'Doctor');
		$this->_assert_equals($userdata->office_id, '987654321');
	}

	function test_login() {
		$this->_assert_true($this->UserController->user_model->login('unit_test_user_pre', 'unit_test_password'));
	}

	function test_logout() {
		$this->test_login();
		$this->UserController->user_model->logout();
		if(isset($this->UserController->session->userdata['user_id'])) { $this->_fail('User is not logged out'); }
	}

	function _post() {

		//Remove unit test office from database
		$this->db->delete('brands', array('office_id' => '987654321')); 

		//Remove unit test users from database
		$this->db->delete('user', array('username' => 'unit_test_user'));
		$this->db->delete('user', array('username' => 'unit_test_user_pre'));
	}
}

?>