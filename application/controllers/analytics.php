<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends CI_Controller {

	private static $appNames;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('analytics_model');

		if(!$this->session->userdata('user_name')) {
			redirect(base_url());
		} else {
			$userObject = User_model::init(array('id' => $this->session->userdata('user_id')));
			if($userObject->user_role != 2) { redirect(base_url()); }
		}
	}

	public function index()
	{
		echo 'Invalid request';
	}

	public function apps() {
		$results = $this->analytics_model->apps_usage();
		echo(json_encode($results));
	}

	public function users() {
		$results = $this->analytics_model->users_usage();
		echo(json_encode($results));
	}
}

?>