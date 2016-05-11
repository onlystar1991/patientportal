<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conversation_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function saveConversation($from = null, $to = null, $content = "", $time = null) {
		$result = $this->db->insert("chat_history", array("sender" => $from, "receiver" => $to, 'content' => $content, 'time' => $time, 'status' => 0));
		if ($result) return true;
		return false;
	}

	public function getRecentConversation($who = null) {
		$this->db->where(array("sender" => $who));
		$this->db->or_where(array("receiver" => $who));
		$this->db->order_by('time', 'asc');
		$result = $this->db->get("chat_history")->result_array();
		$resultArray = array();
		foreach ($result as $row) {
			if ($row['deleted_by'] == $who) continue;
			$resultArray[] = $row;
		}
		return $resultArray;
	}

	public function getRecentConversationForUser($me, $with) {
		$this->db->where(array("sender" => $me, 'receiver' => $with));
		$this->db->or_where('sender = "'.$with.'" and receiver = "'.$me.'"');
		$this->db->order_by('time', 'asc');
		$result = $this->db->get("chat_history");
		return $result->result_array();
	}

	public function markAsRead($from, $to, $content) {
		$this->db->where(array("sender" => $from, 'receiver' => $to, "content" => $content));
		$this->db->update("chat_history", array("status" => 1));
		if($this->db->affected_rows()) return true;
		else return false;
	}

	public function getAllUsers() {
		$query = "SELECT u.*, (SELECT uploads.filename FROM uploads WHERE uploads.id = u.profile_picture) file FROM user AS u";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function markAsReadForUser($me, $from) {
		$this->db->where(array("sender" => $from, 'receiver' => $me));
		$this->db->update("chat_history", array("status" => 1));
		if($this->db->affected_rows()) return true;
		else return false;
	}
	
	public function getUnReadMessageForUser($from, $to) {
		$this->db->where(array("sender" => $from, 'receiver' => $to, 'status' => 0));
		return count($this->db->get('chat_history')->result_array());
	}
	
	public function getUserPhotoFromUsername($username) {
		$user = $this->db->get_where('user', array("username" => $username))->result_array()[0];
		$photo_id = $user['profile_picture'];
		$result = $this->db->get_where('uploads',array("id" => $photo_id))->result_array()[0];
		return $result;
	}

	public function markAsDelete($me, $with) {
		$query = "(`sender`='".$me."' AND `receiver`='".$with."' OR `sender`='".$with."' and `receiver`='".$me."') and `deleted_by`='".$with."' ";
		$this->db->where($query);
		$flag = $this->db->delete('chat_history');
		$query = "(`sender`='".$me."' AND `receiver`='".$with."' OR `sender`='".$with."' and `receiver`='".$me."') and `deleted_by`=''";
		$this->db->where($query);
		$flag = $this->db->update('chat_history', array('deleted_by' => $me));
		return $flag;
	}
	
}
/*
In the Video Chatting Table:
Status field:
1:-> Initial Call
2:-> Accepted Call
3:-> Rejected Call
*/
