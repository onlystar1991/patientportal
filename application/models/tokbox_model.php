<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(__DIR__ . '/../libraries/opentok.phar');

use OpenTok\OpenTok;
use OpenTok\Role;

class Tokbox_model extends CI_Model {
	
	private static $opentok;

	public function __construct() {
		parent::__construct();
		self::$opentok = new OpenTok(TOKBOX_API_KEY, TOKBOX_API_SECRET);
	}

	public static function generateSession() {
		// Create a session that attempts to use peer-to-peer streaming:
		$session = self::$opentok->createSession();

		// Store this sessionId in the database for later use
		$sessionId = $session->getSessionId();
		return $sessionId;
	}

	public static function generateToken($sessionId, $username) {

		// Generate a Token from just a sessionId (fetched from a database)
		$token = self::$opentok->generateToken($sessionId, array(
			'role'			=> Role::PUBLISHER,
			'expireTime'	=> time()+(7 * 24 * 60 * 60), // in one week
			'data'			=> $username,
		));
		return $token;
	}
}
?>