<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	private $testmode;
	private $data;
	private $needsToVerify;

	public function __construct($testmode = false) {
		parent::__construct();

		$this->testmode = $testmode;

		$this->load->helper('url');
		$this->load->model('user_model');	//Loads the user_model.php file and adds it as a property ($this->user_model)

		if (!in_array($this->router->fetch_method(), array('index', 'login', 'register', 'logout', 'forgotpassword', 'upload_file'))
			&& !$this->session->userdata('user_name') && !$this->testmode) {

			redirect(base_url());
		}
		
		if($this->session->userdata('user_id')) {
			$userObject = User_model::init(array('id' => $this->session->userdata('user_id')));
			$this->data['controls_view'] = array();
			$this->data['user_apps'] = $userObject->apps;

			if($userObject->user_role == 2) {
				$this->data['controls_view']['admin'] = true; 
			}

			$this->load->model('tokbox_model');
			$this->data['tokbox_api_key'] = TOKBOX_API_KEY;
			$this->data['notifications_session'] = TOKBOX_NOTIFICATIONS_SESSION;
			$this->data['notifications_token'] = $this->tokbox_model->generateToken(TOKBOX_NOTIFICATIONS_SESSION, $this->session->userdata['user_name']);
		}

		$thirtyMinsAgo = new DateTime( "-30 minutes", new DateTimeZone("UTC"));
		$thirtyMinsAgo = $thirtyMinsAgo->getTimestamp();

		# Stores the condition
		$this->needsToVerify = $this->session->userdata("lastMedivaultLoginTimestamp") < $thirtyMinsAgo;
	}

	public function index($error = false) {

		if(($this->session->userdata('user_name') != "")) {
			$this->welcome();
		} else {
			$data = $this->data;
			$data['title'] = 'Home';
			$data['signIn'] = true;

			$this->load->view('header_view',$data);
			if($error) { $this->load->view("error_view", $data); }	//TODO: Add form validation instead of that error view
			$this->load->view("signin_view", $data);
		}
	}

	public function welcome() {
		$data = $this->data;
		$data['title']= 'Welcome';
		$data['loggedIn'] = true;

		$this->load->view('header_view', $data);
		$this->load->view('dashboard_view.php', $data);
		$this->load->view('footer_view', $data);
	}

	public function newmedivault() {
		$user_id = $this->session->userdata['user_id'];
		$user = User_model::init(array("id" => $user_id));

		$data = $this->data;

		$apps = App_base_model::availableApps();
		$office_id = $user->office->id;

		$data["allApps"] = array();

		foreach ($apps as $value) {
			require_once(dirname(__FILE__) . "/../models/apps/" . $value . "_model.php");
		}

		foreach ($apps as $appStr) {
			$user_id = $this->session->userdata['user_id'];

			$app = ucfirst($appStr) . "_model";
			$app = $app::init($user_id);

			if(!isset($app->brandsWithPermission[$office_id]) || $app->brandsWithPermission[$office_id == true]) {
				array_push($data["allApps"], $appStr);
			}
		}

		$gears = $this->input->get('gears');
		$gearsStatus = null;

		switch ($gears) {
			case 'off':
				$gearsStatus = false;
				break;	
			case 'on':
				$gearsStatus = true;
			default:
				break;
		}

		if(!is_null($gearsStatus)) {
			$this->user_model->update_user_data($user_id, array('show_gears' => $gearsStatus));
		}

		$data['title']= 'MediVault';
		$data['gears'] = $user->show_gears;
		$data['loggedIn'] = true;
		$data['needsToVerify'] = $this->needsToVerify;

		$this->load->view('header_view', $data);
		$this->load->view('medivault_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function credentials($app = null) {

		$data = $this->data;

		$userObject = User_model::init(array('id' => $this->session->userdata('user_id')));

		$thirtyMinsAgo = new DateTime( "-30 minutes", new DateTimeZone("UTC"));
		$thirtyMinsAgo = $thirtyMinsAgo->getTimestamp();

		if($this->needsToVerify) {
			redirect('/user/verify_creds');
			return false;
		}

		if(property_exists($userObject->apps, $app)) {
			$appModel = $userObject->apps->$app;
			if(!empty($_POST)) { $appModel->updateCredentials($_POST); }

			$data["credentials"] = $appModel->credentials;

			if(substr($app, 0, strlen('bluestep')) == 'bluestep') {
				$app = 'bluestep';	//BlueStep credentials workaround
			}

			$data['form'] = $this->load->view("credentials/" . $app . "_view", $data, true);
			$this->load->view("credentials/main_view", $data);
		}
	}

	public function verify_creds() {
		$data = $this->data;

		if(isset($_POST["password"])) {
			$user_id = $this->session->userdata('user_id');
			$user = User_model::init(array("id" => $user_id, "password" => $_POST["password"]));

			$response = new stdClass();

			if($user !== false) {
				$timeNow = new DateTime( "now", new DateTimeZone("UTC"));
				$timeNow = $timeNow->getTimestamp();

				$this->session->set_userdata("lastMedivaultLoginTimestamp", $timeNow);

				$response->status = "success";
			} else {
				$response->status = "failed";
				$response->message = "Wrong password";
			}

			echo(json_encode($response));
		} else {
			$this->load->view("medivault_login_view", $data);
		}
	}
	
	public function settings()
	{
		$data = $this->data;
		$data['title'] = 'Settings';

		$post_data = $this->input->post();	//Retrieve all POST data

		if($this->user_model->update_user_data($this->session->userdata('user_id'), $post_data) == 2) {	//Updates user data using the POST data
			$this->load->view('password_update_successful_view');
		}

		$user_data = $this->user_model->get_user_data($this->session->userdata['user_id']);	//Retrieves user data and pass it to the view

		$data['first_name'] = $user_data->first_name;
		$data['last_name'] = $user_data->last_name;
		$data['office_phone'] = $user_data->office_phone;
		$data['cell_phone'] = $user_data->cell_phone;
		$data['username'] = $user_data->username;
		$data['email'] = $user_data->email;

		$data['loggedIn'] = true;
		$this->load->view('header_view',$data);
		$this->load->view("settings_view", $data);
		$this->load->view('footer_view',$data);
	}
	
	
	public function login() {
		$data = $this->data;
		$username = $this->input->post('username');
		$password = $this->input->post('password');	//Hashes the password as MD5 before sending it to the model

		$user = User_model::init(array(	'username' => $username,
										'password' => $password));

		if($user) { /* If returned value from the model is true, if the login is successful */
			
			$newdata = array('user_id' => $user->id,
							'user_name' => $user->username);

			$this->session->set_userdata($newdata);

			$this->load->model("apps/Lua_model");
			$luaApp = Lua_model::init($user->id);

			if($luaApp == false) { redirect('/user/credentials/lua?error=missingcreds'); }
			else {
				$cookie = $luaApp->getCookie();
				$data['url'] = $luaApp->url;
				$data['cookie_name'] = $cookie['name']; $data['cookie_value'] = $cookie['value'];
				$data['redirection'] = base_url();

				$this->load->view('lualogin_view.php', $data);
			}
		}
		else $this->index(true);	//Redirects to index page, sending "true" as an argument, which shows the error view
									//TODO: Replace with form validation
	}

	public function forgotpassword($type = 'createtoken') {

		$data = $this->data;

		switch ($type) {

			case 'createtoken':

				$returnArray = array();

				if(empty($_POST['username']) || empty($_POST['email'])) {
					$returnArray['status'] = 'error';
					$returnArray['errormessages'] = array();

					if(empty($_POST['username'])) { array_push($returnArray['errormessages'], "Username missing"); }
					if(empty($_POST['email'])) { array_push($returnArray['errormessages'], "Email missing"); }

					echo json_encode($returnArray);

					return false;
				}

				$username = $_POST['username']; $email = $_POST['email'];

				$user = User_model::init(array('username' => $username));

				if(!$user || $user->email != $email) {
					$returnArray['status'] = 'error';
					$returnArray['errormessages'] = array();

					array_push($returnArray['errormessages'], "User doesn't match");

					echo json_encode($returnArray);

					return false;
				}

				$user_id = $user->id;
				$user_ip = $this->input->ip_address();

				$token = $this->user_model->generate_password_token($user_id, $user_ip);

				$this->user_model->send_email($user->email, "Password Reset",
					"http://" . DOMAIN . "/user/forgotpassword/reset?user_id=" . $user_id . "&token=" . $token);

				$returnArray['status'] = 'success';
				$returnArray['token'] = $token;

				echo json_encode($returnArray);

				return true;

				break;
			
			case 'reset':

				$data['title'] = "Reset Password";
				$data['signIn'] = true;
				$data['error'] = false;

				if(!empty($_POST['password']) && !empty($_POST['confirm_password'])
					&& !empty($_POST['user_id']) && !empty($_POST['token']))
				{
					$user_id = $_POST['user_id']; $token = $_POST['token'];
					$result = $this->user_model->verify_token($user_id, $token);

					if($result) {
						if($_POST['password'] != $_POST['confirm_password']) {
							$data['error'] = true;
							$data['errormessage'] = 'Password doesn\'t match password confirmation';
						} else {
							$data['user_id'] = $user_id; $data['token'] = $token;
							$this->user_model->update_user_data($user_id, array('password' => $_POST['password']));
							$data['error'] = true; $data['errormessage'] = 'Password updated';
						}
					} else {
						$data['error'] = true; $data['errormessage'] = 'Token doesn\'t match';
					}
				}

				else if(!empty($_GET['user_id']) && !empty($_GET['token'])) {
					$user_id = $_GET['user_id']; $token = $_GET['token'];
					$data['user_id'] = $user_id; $data['token'] = $token;

					$result = $this->user_model->verify_token($user_id, $token);

					if(!$result) { $data['error'] = true; $data['errormessage'] = 'Token doesn\'t match'; }
				}

				else { return false; }

				$this->load->view('header_view', $data);
				$this->load->view("forgotpassword_view", $data);

				break;

			default:
				return false;
				break;
		}
	}
	
	public function thank()
	{
		$data['title'] = 'Thank You';
		$data['loggedIn'] = true;

		$this->load->view('header_view', $data);
		$this->load->view('thank_view.php', $data);
		$this->load->view('footer_view', $data);
	}

	public function register() {
		if($this->validate_reg_data())	//If form validation succeeded
		{
			$this->user_model->add_user();
			$data['title'] = 'Thank';
			$data['signIn'] = true;

			$this->load->view('header_view', $data);
			$this->load->view('thank_view.php', $data);
			$this->load->view('signin_view', $data);
			$this->load->view('footer_view', $data);
		}
		else
		{
			$data['title'] = 'User Registration';
			$data['signIn'] = true;

			$this->load->view('header_view', $data);
			$this->load->view('reg_view', $data);
			$this->load->view('footer_view', $data);
		}
	}

	public function validate_reg_data() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean|alpha');
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|min_length[4]|xss_clean|is_unique[user.username]');
		$this->form_validation->set_rules('email_address', 'Your Email', 'trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('office_phone', 'office phone', 'trim|required|callback_validatePhoneNumber[office_phone]|xss_clean');
		$this->form_validation->set_rules('cell_phone', 'cell_phone', 'required|callback_validatePhoneNumber[cell_phone]|xss_clean');
		$this->form_validation->set_rules('user_role', 'user_role', 'required|callback_user_role_exists[user_role]|xss_clean');
		$this->form_validation->set_rules('office_id', 'office_id', 'trim|required|min_length[4]|xss_clean|callback_officeid_exists');
		$this->form_validation->set_rules('profile_picture', 'profile_picture', 'required|numeric|xss_clean|callback_profile_picture_exists');

		return $this->form_validation->run();
	}

	public function officeid_exists($value)
	{
		$this->load->model('officebrands_model');
		$office = Officebrands_model::init('office_id', $value);

		if($office) { return true; }
		else { $this->form_validation->set_message('officeid_exists', 'The entered Office ID does not exist or is not valid'); return false; }
	}

	public function user_role_exists($value)
	{
		if($this->user_model->user_role_exists($value) == true) { return true; }
		else { $this->form_validation->set_message('user_role_exists', 'The entered user role does not exist or is not valid'); return false; }
	}

	public function profile_picture_exists($value)
	{
		if($this->user_model->profile_picture_from_id($value) == true) { return true; }
		else { $this->form_validation->set_message('profile_picture_exists', 'The entered user role does not exist or is not valid'); return false; }
	}
	
	public function validatePhoneNumber($number, $field = "") {

		if($this->user_model->validatePhoneNumber($number)) { return true; }
		else {
			$this->form_validation->set_message('validatePhoneNumber', "The entered $field number is not valid");
			return false;
		}
	}

	public function upload_file() {
		$storeFolder = '/usr/share/nginx/html/ALEX/uploads/';

		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];

			$hash = hash_file('sha512', $tempFile);
			$filename = $hash . '.' . end((explode(".", $_FILES["file"]["name"])));

			$targetPath = $storeFolder . $filename;
			move_uploaded_file($tempFile, $targetPath);

			$id = $this->user_model->add_uploaded_file($filename);
			echo $id;

			return $id;
		}

		return false;
	}

	public function logout()
	{
		$this->user_model->logout();
		$this->index();
	}
}	
?>