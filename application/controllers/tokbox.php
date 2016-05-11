<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tokbox extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('tokbox_model');
		$this->load->model('user_model');
		$this->load->helper('url');

		if(!$this->session->userdata('user_id')) {
			redirect(base_url());
		}
	}

	public function index() {
		echo 'Invalid request';
	}

	public function token() {
		
		$this->tokbox_model->generateToken(TOKBOX_NOTIFICATIONS_SESSION);
	}
}
?>
