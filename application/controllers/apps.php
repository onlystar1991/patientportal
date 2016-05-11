<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apps extends CI_Controller {

	private $data;

	public function __construct() {
		parent::__construct();

		$this->load->helper('url');
		$this->load->model('user_model');
		$this->load->library('encrypt');

		if(!$this->session->userdata('user_name')) {
			redirect(base_url());
		} else {
			$this->data['controls_view'] = array();

			$userObject = User_model::init(array('id' => $this->session->userdata('user_id')));
			if($userObject->user_role == 2) { $this->data['controls_view']['admin'] = true; }

			$apps = App_base_model::availableApps();

			foreach ($apps as $value) {
				require_once(dirname(__FILE__) . "/../models/apps/" . $value . "_model.php");
			}

			$this->data['user_apps'] = $userObject->apps;

			$this->load->model('tokbox_model');

			$this->data['tokbox_api_key'] = TOKBOX_API_KEY;
			$this->data['notifications_session'] = TOKBOX_NOTIFICATIONS_SESSION;
			$this->data['notifications_token'] = $this->tokbox_model->generateToken(TOKBOX_NOTIFICATIONS_SESSION, $this->session->userdata['user_name']);
		}
	}

	public function index()
	{
		redirect(base_url());
	}

	private function run($title, $appsArray, $additionalApps = array()) {
		$data = $this->data;

		$user_id = $this->session->userdata['user_id'];
		$user = User_model::init(array("id" => $user_id));

		$data['title'] = $title;
		$data['gears'] = $user->show_gears;

		$appsCredsArray = array();

		$data["apps"] = array();

		$office_id = $user->office->id;

		foreach ($appsArray as $appStr) {
			$user_id = $this->session->userdata['user_id'];

			$app = ucfirst($appStr) . "_model";
			$app = $app::init($user_id);

			if(!isset($app->brandsWithPermission[$office_id]) || $app->brandsWithPermission[$office_id == true]) {
				array_push($data["apps"], $appStr);
				array_push($appsCredsArray, $app->credentials !== false);
			}
		}

		$appsCredsArray = json_encode($appsCredsArray);
		$data['appsCredsAvailable'] = $appsCredsArray;

		$data["apps"] = array_merge($data['apps'], $additionalApps);

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function ehr() {
		$appsArray = array('practicefusion');
		$additionalApps = array('healthfusion',
								'cloudcare',
								'allscripts',
								'pronogcsi',
								'curemd');

		$this->run("EHR Software", $appsArray, $additionalApps);
	}

	public function office() {
		$appsArray = array(	'thinkfree',
							'wheniwork',
							'grasshopper',
							'pandadoc',
							'sherpacrm',
							'hatchbuckoffice',
							'ooma',
							'enquire');

		$this->run("Office Productivity", $appsArray);
	}

	public function admin() {
		$appsArray = array(	'wordpress',
							'aerohive',
							'hatchbuck',
							'tableau',
							'bluestep_admin_1',
							'bluestep_admin_2');

		$this->run("Admin Software", $appsArray);
	}

	public function financial() {
		$appsArray = array(	'intacct',
							'paysimple',
							'xero');

		$this->run("Financial", $appsArray);
	}

	public function communications() {
		$appsArray = array(	'sendinc',
							'lua',
							'securepem',
							'neocertified');

		$this->run("HIPAA Secure Communications", $appsArray);
	}

	public function lgcns() {
		$appsArray = array(	'eldermark',
							'bluestep_lgcns_1',
							'bluestep_lgcns_2',
							'pointclickcare');
		$additionalApps = array('caremerge');

		$this->run("Assisted Living Care Suite", $appsArray, $additionalApps);
	}

	public function telehealth() {
		$appsArray = array(	'sentrian',
							'healthtap',
							'insight',
							'clearcare');

		$this->run("Telehealth", $appsArray);
	}

	public function pharma() {
		$appsArray = array('aidarex');

		$this->run("Pharma Dispensary", $appsArray);
	}

	public function storage() {
		$appsArray = array(	'box',
							'insightly',
							'yammer',
							'uberconference',
							'grovo',
							'absorblms');

		$this->run("Collaboration &amp; Storage", $appsArray);
	}
}

?>