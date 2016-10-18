<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conversation extends CI_Controller {
	
	public function __construct($testmode = false) {
		parent::__construct();

		$this->testmode = $testmode;

		$this->load->helper('url');
		$this->load->model('user_model');
		$this->load->model('conversation_model');	//Loads the user_model.php file and adds it as a property ($this->user_model)

		if($this->session->userdata('user_id')) {
			$this->load->model('tokbox_model');
			$this->data['tokbox_api_key'] = TOKBOX_API_KEY; // API KEY
			$this->data['notifications_session'] = TOKBOX_NOTIFICATIONS_SESSION;
			$this->data['notifications_token'] = $this->tokbox_model->generateToken(TOKBOX_NOTIFICATIONS_SESSION, $this->session->userdata['user_name']);
		}
	}

	public function index() {
		
		if(!$this->session->userdata('user_id')) {
			redirect(base_url());
		} else {
			$this->data['controls_view'] = array();
			$this->load->view('header_view', $this->data);
			$this->load->view('conversation/index', $this->data);
			$this->load->view('footer_view', $this->data);
		}
	}

	public function saveChatHistory() {

		$from = $this->session->userdata['user_id'];
		$to = $this->input->post('to');
		$content = $this->input->post('content');
		$time = new DateTime('now');
		
		$result = $this->conversation_model->saveConversation($from, $to, $content, $time->getTimeStamp());
		$response['from'] = $from;
		$response['to'] = $to;
		$response['content'] = $content;
		$response['time'] = $time->getTimeStamp();
		$response['status'] = ($result ? "success":"fail");
		echo json_encode($response);
		exit;
	}
	
	public function getRecentConversation() {
		
		$result = $this->conversation_model->getRecentConversation($this->session->userdata['user_id']);

		$recentChatArray = array();
		foreach($result as $row) {
			$flag = false;
			for ($i = 0; $i < count($recentChatArray); $i++) {
				if(($recentChatArray[$i]['receiver'] == $row['receiver'] && $recentChatArray[$i]['sender'] == $row['sender']) ||  ($recentChatArray[$i]['receiver'] == $row['sender'] && $recentChatArray[$i]['sender'] == $row['receiver'])) {
					$recentChatArray[$i] = $row;
					$flag = true;
					break;
				}
			}

			if(!$flag) $recentChatArray[] = $row;
		}

		echo json_encode($recentChatArray);
		exit;
	}

	public function getRecentConversationForUser() {
		$me = $this->session->userdata['user_id'];
		$with = $this->input->post("with");

		$resultArray = array();

		$result = $this->conversation_model->getRecentConversationForUser($me, $with);
		foreach ($result as $row) {
			if ($row['deleted_by'] == $me) continue;
			$resultArray[] = $row;
		}

		echo json_encode($resultArray);
		exit;
	}
	
	public function markAsReadForUser() {
		$me = $this->session->userdata['user_id'];
		$from = $this->input->post("from");
		$result = $this->conversation_model->markAsReadForUser($me, $from);
		
		echo json_encode($result);
		exit;
	}
	
	public function markAsRead() {
		$from = $this->input->post("from");
		$to = $this->input->post("to");
		$content = $this->input->post("content");

		$result = $this->conversation_model->markAsRead($from, $to, $content);

		$response['from'] = $from;
		$response['to'] = $to;
		$response['content'] = $content;
		$response['status'] = ($result ? "success":"fail");

		echo json_encode($result);
		exit;
	}

	public function getAllUsers() {
		$result = $this->conversation_model->getAllUsers();
		$resultArray = array();
		
		foreach($result as $row) {
			$data = array();
			$data['username'] = $row['username'];
			$data['user_id'] = $row['id'];
			$data['first_name'] = $row['first_name'];
			$data['last_name'] = $row['last_name'];
			$data['filename'] = $row['file'];
			$resultArray[] = $data;
		}

		echo json_encode($resultArray);
		exit;
	}

	public function getUnReadMessageForUser() {

		$from  = $this->input->post('from');
		$to = $this->input->post('to');
		$result = $this->conversation_model->getUnReadMessageForUser($from, $to);
		$response['from'] = $from;
		$response['to'] = $to;
		$response['count'] = ($result ? $result:0);

		echo json_encode($response);
		exit;
	}

	public function getUserPhotoFromUsername() {
		$username = $this->input->post('username');
		$result = $this->conversation_model->getUserPhotoFromUsername($username);
		echo json_encode($result);
		exit;
	}

	public function markAsDelete() {
		$me = $this->session->userdata['user_id'];
		$with = $this->input->post('with');
		$result = $this->conversation_model->markAsDelete($me, $with);
		$response['me'] = $me;
		$response['with'] = $with;
		$response['result'] = $result;
		echo json_encode($response);
		exit;
	}

	public function videoCall() {
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$session_id = $this->tokbox_model->generateSession();
		$token = $this->tokbox_model->generateToken($session_id, $to);

		$res = array();
		$res['from'] = $from;
		$res['to'] = $to;
		$res['status'] = 'success';
		$res['session_id'] = $session_id;
		$res['token'] = $token;

		echo json_encode($res);
		exit;
	}
}