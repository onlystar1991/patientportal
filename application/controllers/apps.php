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

	public function ehr() {

		$data = $this->data;

		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array(	'practicefusion' => Practicefusion_model::init($user_id)->credentials) !== false);

		$data['title'] = 'EHR Software';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array(	'practicefusion',
								'healthfusion',
								'cloudcare',
								'allscripts',
								'pronogcsi',
								'curemd');

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function office() {

		$data = $this->data;

		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array(	'thinkfree' => Thinkfree_model::init($user_id)->credentials !== false,
										'wheniwork' => Wheniwork_model::init($user_id)->credentials !== false,
										'grasshopper' => Grasshopper_model::init($user_id)->credentials !== false,
										'pandadoc' => Pandadoc_model::init($user_id)->credentials !== false,
										'sherpacrm' => Sherpacrm_model::init($user_id)->credentials !== false,
										'hatchbuckoffice' => Hatchbuckoffice_model::init($user_id)->credentials !== false,
										'ooma' => Ooma_model::init($user_id)->credentials !== false,
										'enquire' => Enquire_model::init($user_id)->credentials !== false));

		$data['title'] = 'Office Productivity';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array(	'thinkfree',
								'wheniwork',
								'webex',
								'grasshopper',
								'pandadoc',
								'sherpacrm',
								'hatchbuckoffice',
								'ooma',
								'enquire');

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function admin() {

		$data = $this->data;

		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array(	'wordpress' => Wordpress_model::init($user_id)->credentials !== false,
										'aerohive' => Aerohive_model::init($user_id)->credentials !== false,
										'hatchbuck' => Hatchbuck_model::init($user_id)->credentials !== false,
										'tableau' => Tableau_model::init($user_id)->credentials !== false,
										'bluestep_admin_1' => Bluestep_admin_1_model::init($user_id)->credentials !== false,
										'bluestep_admin_2' => Bluestep_admin_2_model::init($user_id)->credentials !== false));

		$data['title'] = 'Admin Software';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array(	'wordpress',
								'aerohive',
								'hatchbuck',
								'tableau',
								'bluestep_admin_1',
								'bluestep_admin_2',);

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function financial() {

		$data = $this->data;

		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array(	'intacct' => Intacct_model::init($user_id)->credentials !== false,
										'paysimple' => Paysimple_model::init($user_id)->credentials !== false,
										'xero' => Xero_model::init($user_id)->credentials !== false));

		$data['title'] = 'Financial Software';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array(	'intacct',
								'paysimple',
								'xero');

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function communications() {

		$data = $this->data;

		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array(	'sendinc' => Sendinc_model::init($user_id)->credentials !== false,
										'lua' => Lua_model::init($user_id)->credentials !== false,
										'securepem' => Securepem_model::init($user_id)->credentials !== false,
										'neocertified' => Neocertified_model::init($user_id)->credentials !== false));

		$data['title'] = 'HIPAA Secure Communications';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array(	'sendinc',
								'lua',
								'securepem',
								'neocertified');

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function lgcns() {

		$data = $this->data;

		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array(	'eldermark' => Eldermark_model::init($user_id)->credentials !== false,
										'bluestep_lgcns_1' => Bluestep_lgcns_1_model::init($user_id)->credentials !== false,
										'bluestep_lgcns_2' => Bluestep_lgcns_2_model::init($user_id)->credentials !== false,
										'pointclickcare' => Pointclickcare_model::init($user_id)->credentials !== false));

		$data['title'] = 'Assisted Living Care Suite';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array(	'caremerge',
								'pointclickcare',
								'eldermark',
								'bluestep_lgcns_1',
								'bluestep_lgcns_2');

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function telehealth() {
		$data = $this->data;
		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array(	'sentrian' => Sentrian_model::init($user_id)->credentials !== false,
										'healthtap' => Healthtap_model::init($user_id)->credentials !== false,
										'insight' => Insight_model::init($user_id)->credentials !== false,
										'clearcare' => Clearcare_model::init($user_id)->credentials !== false));

		$data['title'] = 'Telehealth';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array(	'sentrian',
								'healthtap',
								'insight',
								'clearcare');

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function pharma() {

		$data = $this->data;
		
		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array('aidarex' => Aidarex_model::init($user_id)->credentials !== false));

		$data['title'] = 'Pharma Dispensary';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array('aidarex');

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}

	public function storage() {

		$data = $this->data;
		
		$user_id = $this->session->userdata['user_id'];
		$user_data = $this->user_model->get_user_data($user_id);
		$appsArray = json_encode(array(	'box' => Box_model::init($user_id)->credentials !== false,
										'insightly' => Insightly_model::init($user_id)->credentials !== false,
										'yammer' => Yammer_model::init($user_id)->credentials !== false,
										'uberconference' => Uberconference_model::init($user_id)->credentials !== false,
										'grovo' => Grovo_model::init($user_id)->credentials !== false,
										'absorblms' => Absorblms_model::init($user_id)->credentials !== false));

		$data['title'] = 'Collaboration &amp; Storage';
		$data['appsCredsAvailable'] = $appsArray;
		$data['gears'] = $user_data->show_gears;

		$data['apps'] = array(	'box',
								'insightly',
								'yammer',
								'uberconference',
								'grovo',
								'absorblms');

		$this->load->view('header_view',$data);
		$this->load->view('apps/creds_check_script', $data);
		$this->load->view('apps/apps_view', $data);
		$this->load->view('footer_view', $data);
	}
}

?>