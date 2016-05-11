<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class App extends CI_Controller {

	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->model('user_model');

		if(!$this->session->userdata('user_id')) {
			redirect(base_url());
		} else {
			$userObject = User_model::init(array('id' => $this->session->userdata('user_id')));

			$this->data['controls_view'] = array();
			$this->data['user_apps'] = $userObject->apps;

			if($userObject->user_role == 2) { $this->data['controls_view']['admin'] = true; }

			$this->load->model('tokbox_model');

			$this->data['tokbox_api_key'] = TOKBOX_API_KEY;
			$this->data['notifications_session'] = TOKBOX_NOTIFICATIONS_SESSION;
			$this->data['notifications_token'] = $this->tokbox_model->generateToken(TOKBOX_NOTIFICATIONS_SESSION, $this->session->userdata['user_name']);
		}
	}

	public function index($appName = false, $wordPressName = null)
	{
		$data = $this->data;
		$userObject = User_model::init(array('id' => $this->session->userdata('user_id')));

		if(property_exists($userObject->apps, $appName) && strtolower($appName) != "main") {

			$app = $userObject->apps->$appName;
			$modelName = get_class($app);

			$this->load->view('header_view', $data);

			$data['url'] = $app->url;
			$data['blockTopNavigation'] = $modelName::$blockTopNavigation;
			$data['cookiesToRemove'] = json_encode($app->cookiesToRemove);

			if($modelName::$loginType == 'client') {

				if($appName == "wordpress" && is_null($wordPressName)) {
					$data['wordpress'] = $app->credentials;
					$this->load->view('apps/wordpress_load_view', $data);
				} else {
					$data['appLoginType'] = 'clientside';
					$data['app'] = $modelName::$name;

					if($appName == "wordpress") {
						$data['credsJSONArray'] = json_encode(array("ALEX", $app->credentials->$wordPressName));
						$data['url'] = $app->credentials->$wordPressName->url;
					} else {
						$data['credsJSONArray'] = json_encode(array("ALEX", $app->credentials));
					}

					$this->load->view('app_view', $data);
				}
			} else if($modelName::$loginType == 'server') {
				$cookie = $app->getCookie();

				$data['url'] = $app->url;
				$data['redirection_url'] = $app->redirectionURL;
				$data['cookie_name'] = $cookie['name'];
				$data['cookie_value'] = $cookie['value'];

				$this->load->view('app_view', $data);
			}
		}

		else if($appName == 35) {
			$this->load->view('header_view', $data);
			$this->load->view('tokbox_view', $data);
		}

		else { die('Application not found'); }

		$this->load->view('footer_view', $data);
	}

}
	
?>