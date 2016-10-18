<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->model('user_model');

		$this->load->helper('url');

		if(!$this->session->userdata('user_id')) {
			redirect(base_url());
		} else {
			$userObject = User_model::init(array('id' => $this->session->userdata('user_id')));
			if($userObject->user_role != 2) { redirect(base_url()); }
		}
	}

	public function index()
	{
		$healthchecks = $this->admin_model->get_healthchecks();

		$data['healthchecks'] = $healthchecks;

		$this->load->view('/admin/header_view', $data);
		$this->load->view('/admin/index_view', $data);
		$this->load->view('/admin/footer_view', $data);
	}

	public function officebrands($parameter = false)
	{
		$this->load->model('officebrands_model');

		if(is_numeric($parameter)) { return $this->edit_office($parameter); }
		else if($parameter == 'create') { return $this->create_office(); }

		$data['offices'] = Officebrands_model::all();

		$this->load->view('/admin/header_view', $data);
		$this->load->view('/admin/officebrands_view', $data);
		$this->load->view('/admin/footer_view', $data);
	}

	private function edit_office($id) {

		$office = Officebrands_model::init('id', $id);
		$office->update();

		if($this->validate_office_data()) {
			$office->update($this->input->post());
		} else { echo validation_errors(); }

		$data['office'] = $office;

		$this->load->view('/admin/header_view', $data);
		$this->load->view('/admin/edit_office_view', $data);
		$this->load->view('/admin/footer_view', $data);
	}

	private function create_office() {

		if(!(empty($_POST) || empty($_POST['office_id']) || empty($_POST['brand_name']) || empty($_POST['address'])
			|| empty($_POST['city']) || empty($_POST['state']) || empty($_POST['zip_code']))) {
			if($this->validate_office_data()) {

				$office_id = Officebrands_model::create($_POST);
				redirect('/admin/officebrands/' . $office_id, 'refresh');
				return true;

			} else { echo validation_errors(); }
		}

		$data['office'] = Officebrands_model::init();

		$this->load->view('/admin/header_view', $data);
		$this->load->view('/admin/edit_office_view', $data);
		$this->load->view('/admin/footer_view', $data);
	}

	public function users($parameter = false)
	{
		if(is_numeric($parameter)) { return $this->edit_user($parameter); }
		else if($parameter == 'create') { return $this->create_user(); }

		$users = User_model::all();
		$data['users'] = $users;

		$this->load->view('/admin/header_view', $data);
		$this->load->view('/admin/users_view', $data);
		$this->load->view('/admin/footer_view', $data);
	}

	private function edit_user($user_id) {

		if(!(empty($_POST) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])
			|| empty($_POST['office_phone']) || empty($_POST['cell_phone'] || empty($_POST['office_id'])))
			&& $this->validate_user_data()) {

			var_dump($_FILES);
			if(!empty($_FILES) && !empty($_FILES['file']['tmp_name'])) {
				$id = $this->upload_file();
				$_POST['profile_picture'] = $id;
			}

			$this->user_model->update_user_data($user_id, $_POST);
		}

		echo validation_errors();

		$user = User_model::init(array('id' => $user_id));
		$user->profile_picture = $this->user_model->profile_picture_from_id($user->profile_picture);

		$this->load->model('officebrands_model');

		$offices = Officebrands_model::all();

		$data['user'] = $user;
		$data['offices'] = $offices;

		$this->load->view('/admin/header_view', $data);
		$this->load->view('/admin/edit_user_view', $data);
		$this->load->view('/admin/footer_view', $data);
	}

	private function create_user() {

		if(!(empty($_POST) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['username'])
			|| empty($_POST['email']) || empty($_POST['office_phone']) || empty($_POST['cell_phone'] || empty($_POST['office_id'])))) {
			if($this->validate_user_reg_data()) {

				if(!empty($_FILES) && !empty($_FILES['file']['tmp_name'])) {
					$id = $this->upload_file();
					$_POST['profile_picture'] = $id;
				}

				$user_id = User_model::create($_POST);
				redirect('/admin/users/' . $user_id, 'refresh');
				return true;

			} else { echo validation_errors(); }
		}

		$this->load->model('officebrands_model');
		
		$offices = Officebrands_model::all();
		$data['offices'] = $offices;

		$data['profile_picture'] = "/uploads/" . $this->user_model->profile_picture_from_id(0);

		$this->load->view('/admin/header_view', $data);
		$this->load->view('/admin/create_user_view', $data);
		$this->load->view('/admin/footer_view', $data);
	}

	private function upload_file() {
		$storeFolder = '/usr/share/nginx/html/ALEX/uploads/';

		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];

			$hash = hash_file('sha512', $tempFile);
			$filename = $hash . '.' . end((explode(".", $_FILES["file"]["name"])));

			$targetPath = $storeFolder . $filename;
			move_uploaded_file($tempFile, $targetPath);

			$id = $this->user_model->add_uploaded_file($filename);

			return $id;
		}

		return false;
	}

	private function validate_office_data() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('office_id', 'Office ID', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|alpha|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|alpha|xss_clean');
		$this->form_validation->set_rules('state', 'State', 'trim|required|callback_state_exists[state]|xss_clean');

		return $this->form_validation->run();
	}

	private function validate_user_data() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean|alpha');
		$this->form_validation->set_rules('email', 'Your Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('office_phone', 'office phone', 'trim|required|callback_validatePhoneNumber[office_phone]|xss_clean');
		$this->form_validation->set_rules('cell_phone', 'cell_phone', 'required|callback_validatePhoneNumber[cell_phone]|xss_clean');
		$this->form_validation->set_rules('office_id', 'office_id', 'trim|required|xss_clean|callback_officeid_exists');

		return $this->form_validation->run();
	}

	private function validate_user_reg_data() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean|alpha');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|xss_clean|is_unique[user.username]');
		$this->form_validation->set_rules('email', 'Your Email', 'trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('office_phone', 'office phone', 'trim|required|callback_validatePhoneNumber[office_phone]|xss_clean');
		$this->form_validation->set_rules('cell_phone', 'cell_phone', 'required|callback_validatePhoneNumber[cell_phone]|xss_clean');
		$this->form_validation->set_rules('office_id', 'office_id', 'trim|required|xss_clean|callback_officeid_exists');

		return $this->form_validation->run();
	}

	//Start validation callbacks

	public function officeid_exists($value)
	{
		$this->load->model('officebrands_model');
		$office = Officebrands_model::init('id', $value);

		if($office) { return true; }
		else { $this->form_validation->set_message('officeid_exists', 'The entered Office ID does not exist or is not valid'); return false; }
	}

	public function user_role_exists($value)
	{
		if($this->user_model->user_role_exists($value) == true) { return true; }
		else { $this->form_validation->set_message('user_role_exists', 'The entered user role does not exist or is not valid'); return false; }
	}

	public function state_exists($value)
	{
		if(in_array($value, array("AK", "HI", "CA", "NV", "OR", "WA", "AZ", "CO", "ID", "MT", "NE", "NM", "ND", "UT",
			"WY", "AL", "AR", "IL", "IA", "KS", "KY", "LA", "MN", "MS", "MO", "OK", "SD", "TX", "TN", "WI", "CT", "DE",
			"FL", "GA", "IN", "ME", "MD", "MA", "MI", "NH", "NJ", "NY", "NC", "OH", "PA", "RI", "SC", "VT", "VA", "WV"))) {
			return true;
		} else { $this->form_validation->set_message('state_exists', 'The entered State is invalid'); return false; }
	}

	//End validation callbacks

	public function google_analytics()
	{
		$this->load->library('google');
		echo $this->google->getLibraryVersion();  
	}
}

?>
