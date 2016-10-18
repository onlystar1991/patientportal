<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
	
	public $id;
	public $first_name;
	public $last_name;
	public $username;
	public $email;
	public $office;
	public $office_phone;
	public $cell_phone;
	public $user_role;
	public $profile_picture;
	public $apps;

	private $office_id;

	public function __construct()
	{
		parent::__construct();

		$this->load->library('encrypt');
	}

	public static function init($data) {

		if(empty($data)) { return false; }

		$keysArray = array('id', 'username', 'password', 'email', 'cell_phone');
		$dbArray = array('id', 'first_name', 'last_name', 'username', 'email', 'office_id', 'office_phone', 'cell_phone', 'user_role', 'profile_picture');

		if(array_values(array_intersect($keysArray, array_keys($data))) != array_values(array_keys($data))) { return false; }

		if(!empty($data['password'])) { $data['password'] = md5($data['password']); }

		$CI =& get_instance();
		$CI->db->where($data);
		$query = $CI->db->get("user");

		if($query->num_rows() <= 0) { return false; }

		$userDB = $query->result(); $userDB = $userDB[0];

		$user = new User_model();

		foreach ($dbArray as $key) {
			$user->$key = $userDB->$key;
		}

		$CI->load->model('officebrands_model');

		$user->office = Officebrands_model::init('id', $user->office_id);

		$apps = App_base_model::availableApps();

		$user->apps = new StdClass;

		foreach ($apps as $value) {
			$modelName = ucfirst($value) . "_model";
			require_once("apps/" . $value . "_model.php");
			$appModel = $modelName::init($user->id);
			$user->apps->$value = $appModel;
		}

		return $user;
	}

	public static function all() {
		$CI =& get_instance();

		$query = $CI->db->get('user');
		$returned_value = $query->result();
		if(!$returned_value) return false;

		$usersArray = array();

		foreach ($returned_value as $value) {
			$user = User_model::init(array('id' => $value->id));
			array_push($usersArray, $user);
		}

		return($usersArray);
	}

	public static function create($data) {

		$whitelist = array('first_name',
							'last_name',
							'username',
							'email',
							'password',
							'office_phone',
							'cell_phone',
							'user_role',
							'profile_picture',
							'office_id');

		$data = array_intersect_key($data, array_flip($whitelist));

		$CI =& get_instance();
		
		if($CI->db->insert('user', $data)) { return $CI->db->insert_id(); }
		return false;
	}

	public function update($data = false) {
		if(empty($data)) { return false; }
		if(empty(array_keys($data))) { return false; }

		$columns = $this->db->list_fields('user');
		if(array_values(array_intersect($columns, array_keys($data))) != array_values(array_keys($data))) { return false; }

		$this->db->where('id', $this->id);
		$this->db->update('user', $data);

		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

	public function profile_picture_from_id($id) {
		$this->db->where("id", $id);
		$query = $this->db->get("uploads");

		if($query->num_rows() > 0) {
			$row = $query->result();
			$row = $row[0];

			return $row ->filename;
		}
		else { return false; }
	}

	public function generate_password_token($user_id, $user_ip) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		$length = 50;

		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}

		$data = array(	'user_id' 	=> $user_id,
						'user_ip' 	=> $user_ip,
						'token' 	=> $randomString);

		$this->db->insert('password_tokens', $data);

		return $randomString;
	}

	public function verify_token($user_id, $token) {
		$this->db->where("user_id", $user_id);
		$this->db->where("token", $token);
			
		$query = $this->db->get("password_tokens");

		if($query->num_rows() > 0)
		{
			$row = $query->result(); $row = $row[0];
			return true;
		}

		return false;
	}

	public function send_email($email, $subject, $message) {
		$this->load->library('email');

		$this->email->from('noreply@' . DOMAIN, 'ALEX');
		$this->email->to($email); 

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();

	}

	public function logout() {

		$newdata = array(
			'user_id'   =>'',
			'user_name'  =>'',
			'user_email'     => '',
			'logged_in' => FALSE,
		);
		
		$this->session->unset_userdata($newdata);
		$this->session->sess_destroy();
	}

	public function add_user()
	{
		$data = array(
			'first_name'	=> $this->input->post('first_name'),
			'last_name'		=> $this->input->post('last_name'),
			'username'		=> $this->input->post('user_name'),
			'email'			=> $this->input->post('email_address'),
			'password'		=> md5($this->input->post('password')),
			'office_phone'	=> preg_replace("/[^0-9]/", "", $this->input->post('office_phone')),
			'cell_phone'	=> preg_replace("/[^0-9]/", "", $this->input->post('cell_phone')),
			'user_role'		=> $this->input->post('user_role'),
			'profile_picture'		=> $this->input->post('profile_picture'),
			'office_id'		=> $this->input->post('office_id')
		);

		return $this->db->insert('user', $data);
	}

	public function officeid_exists($value) {
		$this->db->where("office_id", $value);
		$query = $this->db->get("brands");

		if($query->num_rows() > 0) { return true; }
		else { return false; }
	}

	public function user_role_exists($value) {
		$this->db->where("id", $value);
		$query = $this->db->get("user_roles");

		if($query->num_rows() > 0) { return true; }
		else { return false; }
	}

	public function get_user_data($user_id) {
		$this->db->where("id", $user_id);
		$query=$this->db->get("user");

		$returned_value = $query->result();
		return $returned_value[0];
	}

	public function update_user_data($user_id, $post_data) {

		$update_data = array();

		if(is_array($post_data)) {
			foreach ($post_data as $key => $value) {
				if($this->db->field_exists($key, 'user')) {
					if($key == 'password') {
						if(empty($value)) { continue; }
						$value = md5($value);
					}

					$update_data[$key] = $value;
				}
			}
		} else { return false; }

		$this->db->where('id', $user_id);
		$this->db->update('user', $update_data);

		return 2;
	}

	public function validatePhoneNumber($number) {

		$formats = array(
			'###-###-####', '####-###-###',
			'(###) ###-###','####-####-####',
			'##-###-####-####','####-####','###-###-###',
			'#####-###-###', '##########', '#########',
			'# ### #####', '#-### #####'
		);

		$format = trim(preg_replace('/[0-9]/', '#', $number));

		if(in_array($format, $formats)) {
			return true;
		} else {
			return false;
		}
	}

	private function encrypt_database_row($row) {
		foreach ($row as $key => &$value) {
			if($key != 'user_id' && $key != 'id') {
				$value = $this->encrypt->encode($value);
			}
		}

		return $row;
	}

	private function decrypt_database_row($row) {
		foreach ($row as $key => &$value) {
			if($key != 'user_id' && $key != 'id') {
				$value = $this->encrypt->decode($value);
			}
		}

		return $row;
	}

	public function get_healthfusion_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_healthfusion');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_healthfusion_data($user_id, $post_data) {

		if(isset($post_data['username']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'username'	=> $post_data['username'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_healthfusion');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_healthfusion', $database_array);
			} else {
				$this->db->insert('app_healthfusion', $database_array);
			}

			return true;
		} else { return false; }
	}

	public function get_box_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_box');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_box_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password']) && isset($post_data['subdomain'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password'],
									'subdomain' => $post_data['subdomain']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_box');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_box', $database_array);
			} else {
				$this->db->insert('app_box', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_practicefusion_data($user_id) {
		
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_practicefusion');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_practicefusion_data($user_id, $post_data) {

		if(isset($post_data['LoginType']) && isset($post_data['password'])) {
			$post_data['user_id'] = $user_id;

			$loginValue = "";

			if($post_data['LoginType'] == 'email') { $loginValue = $post_data['email']; }
			else if($post_data['LoginType'] == 'id') { $loginValue = $post_data['username']; }

			if(!isset($post_data['practicefusion_id'])) { $post_data['practicefusion_id'] = ""; }

			$database_array = array('user_id' => $user_id,
									'login' => $loginValue,
									'password' => $post_data['password'],
									'usesEmailForLogin' => ($post_data['LoginType'] == 'email'),
									'practicefusion_id' => $post_data['practicefusion_id']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_practicefusion');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_practicefusion', $database_array);
			} else {
				$this->db->insert('app_practicefusion', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_insightly_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_insightly');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_insightly_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_insightly');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_insightly', $database_array);
			} else {
				$this->db->insert('app_insightly', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_thinkfree_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_thinkfree');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_thinkfree_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$post_data['user_id'] = $user_id;

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_thinkfree');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_thinkfree', $database_array);
			} else {
				$this->db->insert('app_thinkfree', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_intacct_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_intacct');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_intacct_data($user_id, $post_data) {

		if(isset($post_data['companyid']) && isset($post_data['userid']) && isset($post_data['password'])) {

			$database_array = array('user_id'				=> $user_id,
									'intacct_company_id'	=> $post_data['companyid'],
									'intacct_user_id'		=> $post_data['userid'],
									'intacct_password'				=> $post_data['password'],
									'trial'					=> ($post_data['trial'] == 'yes'));

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_intacct');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_intacct', $database_array);
			} else {
				$this->db->insert('app_intacct', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_wheniwork_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_wheniwork');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_wheniwork_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'				=> $user_id,
									'email'					=> $post_data['email'],
									'password'				=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_wheniwork');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_wheniwork', $database_array);
			} else {
				$this->db->insert('app_wheniwork', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_wordpress_data($user_id, $conditionsArray = false) {

		$whereClause = array('user_id' => $user_id);

		$this->db->where($whereClause);
		$query = $this->db->get('app_wordpress');

		$returned_value = $query->result();

		foreach ($returned_value as &$value) {
			$value = $this->decrypt_database_row($value);
			if($conditionsArray) {
				if($value->name == $conditionsArray['name']) {
					return $value;
				}
			}
		}

		if($conditionsArray) { return false; }

		return($returned_value ? $returned_value : false);
	}

	public function update_wordpress_data($user_id, $post_data) {

		$resultsArray = array();

		if(isset($post_data['apps'])) {

			$this->db->delete('app_wordpress', array('user_id' => $user_id));

			foreach ($post_data['apps'] as $value) {
				if(!(empty($value['name']) || empty($value['link']) || empty($value['username']) || empty($value['password']))) {
					$database_array = array('user_id' 	=> $user_id,
											'name'		=> $value['name'],
											'link'		=> $value['link'],
											'username'	=> $value['username'],
											'password'	=> $value['password']);

					if(!empty($value['login'])) { $database_array['login_url'] = $value['login']; }
					else { $database_array['login_url'] = 'wp-login.php'; }

					$database_array = $this->encrypt_database_row($database_array);

					$this->db->insert('app_wordpress', $database_array);
				}
			}

			return true;
		}
	}

	public function get_aerohive_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_aerohive');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_aerohive_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'				=> $user_id,
									'email'					=> $post_data['email'],
									'password'				=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_aerohive');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_aerohive', $database_array);
			} else {
				$this->db->insert('app_aerohive', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_grasshopper_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_grasshopper');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_grasshopper_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_grasshopper');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_grasshopper', $database_array);
			} else {
				$this->db->insert('app_grasshopper', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_yammer_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_yammer');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_yammer_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password']) && isset($post_data['domain'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password'],
									'domain'	=> $post_data['domain']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_yammer');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_yammer', $database_array);
			} else {
				$this->db->insert('app_yammer', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_pandadoc_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_pandadoc');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_pandadoc_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_pandadoc');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_pandadoc', $database_array);
			} else {
				$this->db->insert('app_pandadoc', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_paysimple_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_paysimple');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_paysimple_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_paysimple');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_paysimple', $database_array);
			} else {
				$this->db->insert('app_paysimple', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_sendinc_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_sendinc');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_sendinc_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_sendinc');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_sendinc', $database_array);
			} else {
				$this->db->insert('app_sendinc', $database_array);
			}

			return true;
		}

		return false;
	}
	
	
	public function get_hatchbuck_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_hatchbuck');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_hatchbuck_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_hatchbuck');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_hatchbuck', $database_array);
			} else {
				$this->db->insert('app_hatchbuck', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_hatchbuckoffice_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_hatchbuckoffice');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_hatchbuckoffice_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_hatchbuckoffice');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_hatchbuckoffice', $database_array);
			} else {
				$this->db->insert('app_hatchbuckoffice', $database_array);
			}

			return true;
		}

		return false;
	}


	public function get_xero_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_xero');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_xero_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_xero');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_xero', $database_array);
			} else {
				$this->db->insert('app_xero', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_lua_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_lua');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_lua_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_lua');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_lua', $database_array);
			} else {
				$this->db->insert('app_lua', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_sherpacrm_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_sherpacrm');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_sherpacrm_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_sherpacrm');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_sherpacrm', $database_array);
			} else {
				$this->db->insert('app_sherpacrm', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_sentrian_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_sentrian');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_sentrian_data($user_id, $post_data) {

		if(isset($post_data['username']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'username'		=> $post_data['username'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_sentrian');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_sentrian', $database_array);
			} else {
				$this->db->insert('app_sentrian', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_healthtap_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_healthtap');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_healthtap_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_healthtap');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_healthtap', $database_array);
			} else {
				$this->db->insert('app_healthtap', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_securepem_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_securepem');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_securepem_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password']) && isset($post_data['organization'])) {

			$database_array = array('user_id'		=> $user_id,
									'email'			=> $post_data['email'],
									'password'		=> $post_data['password'],
									'organization'	=> $post_data['organization']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_securepem');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_securepem', $database_array);
			} else {
				$this->db->insert('app_securepem', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_insight_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_insight');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_insight_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_insight');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_insight', $database_array);
			} else {
				$this->db->insert('app_insight', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_eldermark_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_eldermark');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_eldermark_data($user_id, $post_data) {

		if(isset($post_data['username']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'username'		=> $post_data['username'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_eldermark');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_eldermark', $database_array);
			} else {
				$this->db->insert('app_eldermark', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_tableau_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_tableau');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_tableau_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_tableau');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_tableau', $database_array);
			} else {
				$this->db->insert('app_tableau', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_clearcare_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_clearcare');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_clearcare_data($user_id, $post_data) {

		if(isset($post_data['email']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'email'		=> $post_data['email'],
									'password'	=> $post_data['password'],
									'subdomain'	=> $post_data['subdomain']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_clearcare');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_clearcare', $database_array);
			} else {
				$this->db->insert('app_clearcare', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_ooma_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_ooma');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_ooma_data($user_id, $post_data) {

		if(isset($post_data['phone']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'phone'		=> $post_data['phone'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_ooma');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_ooma', $database_array);
			} else {
				$this->db->insert('app_ooma', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_bluestep_admin_1_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_bluestep_admin_1');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_bluestep_admin_1_data($user_id, $post_data) {

		if(isset($post_data['username']) && isset($post_data['password']) && isset($post_data['subdomain'])) {

			$database_array = array('user_id'	=> $user_id,
									'subdomain'	=> $post_data['subdomain'],
									'username'	=> $post_data['username'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_bluestep_admin_1');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_bluestep_admin_1', $database_array);
			} else {
				$this->db->insert('app_bluestep_admin_1', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_bluestep_admin_2_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_bluestep_admin_2');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_bluestep_admin_2_data($user_id, $post_data) {

		if(isset($post_data['username']) && isset($post_data['password']) && isset($post_data['subdomain'])) {

			$database_array = array('user_id'	=> $user_id,
									'subdomain'	=> $post_data['subdomain'],
									'username'	=> $post_data['username'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_bluestep_admin_2');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_bluestep_admin_2', $database_array);
			} else {
				$this->db->insert('app_bluestep_admin_2', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_bluestep_lgcns_1_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_bluestep_lgcns_1');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_bluestep_lgcns_1_data($user_id, $post_data) {

		if(isset($post_data['username']) && isset($post_data['password']) && isset($post_data['subdomain'])) {

			$database_array = array('user_id'	=> $user_id,
									'subdomain'	=> $post_data['subdomain'],
									'username'	=> $post_data['username'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_bluestep_lgcns_1');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_bluestep_lgcns_1', $database_array);
			} else {
				$this->db->insert('app_bluestep_lgcns_1', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_bluestep_lgcns_2_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_bluestep_lgcns_2');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_bluestep_lgcns_2_data($user_id, $post_data) {

		if(isset($post_data['username']) && isset($post_data['password']) && isset($post_data['subdomain'])) {

			$database_array = array('user_id'	=> $user_id,
									'subdomain'	=> $post_data['subdomain'],
									'username'	=> $post_data['username'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_bluestep_lgcns_2');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_bluestep_lgcns_2', $database_array);
			} else {
				$this->db->insert('app_bluestep_lgcns_2', $database_array);
			}

			return true;
		}

		return false;
	}

	public function get_pointclickcare_data($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('app_pointclickcare');

		$returned_value = $query->result();

		if(!$returned_value) return false;

		$returned_value = $returned_value[0];
		$returned_value = $this->decrypt_database_row($returned_value);
		return($returned_value);
	}

	public function update_pointclickcare_data($user_id, $post_data) {

		if(isset($post_data['username']) && isset($post_data['password'])) {

			$database_array = array('user_id'	=> $user_id,
									'username'	=> $post_data['username'],
									'password'	=> $post_data['password']);

			$database_array = $this->encrypt_database_row($database_array);

			$this->db->where('user_id', $user_id);
			$query = $this->db->get('app_pointclickcare');

			if($query->num_rows() > 0) {
				$this->db->where('user_id', $user_id);
				$this->db->update('app_pointclickcare', $database_array);
			} else {
				$this->db->insert('app_pointclickcare', $database_array);
			}

			return true;
		}

		return false;
	}

	public function add_uploaded_file($filename) {
		$database_array = array('filename' => $filename);

		$this->db->where('filename', $filename);
		$query = $this->db->get('uploads');

		if($query->num_rows() > 0) {
			$result = $query->result();
			$result = $result[0];
			return $result->id;
		} else {
			$this->db->insert('uploads', $database_array);
			return $this->db->insert_id();
		}
	}

	public function get_users() {
		$query = $this->db->get('user');
		$returned_value = $query->result();
		$returned_value = $this->user_roles_to_text($returned_value);

		return $returned_value;
	}

	private function user_roles_to_text($array) {
		$query = $this->db->get('user_roles');
		$returned_value = $query->result();

		$user_roles_array = array();
		foreach ($returned_value as $value) {
			$user_roles_array[$value->id] = $value->name;
		}

		foreach ($array as &$value) {
			$value->user_role = $user_roles_array[$value->user_role];
		}

		return $array;
	}

}
?>