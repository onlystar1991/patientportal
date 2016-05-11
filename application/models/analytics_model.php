<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function apps_usage() {
		$analytics = $this->getService();
		$profile = $this->getFirstProfileId($analytics);

		$dimensions = array('ga:pagePath');
		$metrics = array('ga:pageviews');
		$filters = array('ga:pagePath=~/app/ *', 'ga:customVarValue1==H6n7RPhXDbaG');

		$dimensions = implode(",", $dimensions);
		$metrics = implode(",", $metrics);
		$filters = implode(";", $filters);
	
		$options = [];

		$options['dimensions'] = $dimensions;
		$options['filters'] = $filters;

		$results = $analytics->data_ga->get('ga:' . $profile,
											'7daysAgo',
											'today',
											$metrics,
											$options);

		if (count($results->getRows()) > 0) {
			// Get the entry for the first entry in the first row.
			$rows = $results->getRows();
			return($rows);
		} else { return false; }

		return $results;
	}

	public function users_usage() {
		$analytics = $this->getService();
		$profile = $this->getFirstProfileId($analytics);

		// Calls the Core Reporting API and queries for the number of sessions
		// for the last seven days.

		$dimensions = array('ga:date', 'ga:dayOfWeekName');
		$metrics = array('ga:sessions');
		$filters = array('ga:customVarValue1==H6n7RPhXDbaG');

		$dimensions = implode(",", $dimensions);
		$metrics = implode(",", $metrics);
		$filters = implode(";", $filters);
	
		$options = [];

		$options['dimensions'] = $dimensions;
		$options['filters'] = $filters;

		$results = $analytics->data_ga->get('ga:' . $profile,
											'7daysAgo',
											'today',
											$metrics,
											$options);

		if (count($results->getRows()) > 0) {
			// Get the entry for the first entry in the first row.
			$rows = $results->getRows();
			return($rows);
		} else { return false; }

		return $results;
	}

	private function getService()
	{
		// Creates and returns the Analytics service object.

		$this->load->library('google');

		// Use the developers console and replace the values with your
		// service account email, and relative location of your key file.
		$service_account_email = '211066342088-9omou506rqovguniikoijh7m442d3tom@developer.gserviceaccount.com';
		$key_file_location = '/usr/share/nginx/html/ALEX/application/config/ALEX.p12';

		// Create and configure a new client object.
		$client = new Google_Client();
		$client->setApplicationName("ALEX");
		$analytics = new Google_Service_Analytics($client);

		// Read the generated client_secrets.p12 key.
		$key = file_get_contents($key_file_location);
		$cred = new Google_Auth_AssertionCredentials(
			$service_account_email,
			array(Google_Service_Analytics::ANALYTICS_READONLY),
			$key
		);
		$client->setAssertionCredentials($cred);
		if($client->getAuth()->isAccessTokenExpired()) {
		$client->getAuth()->refreshTokenWithAssertion($cred);
		}

		return $analytics;
	}

	private function getFirstprofileId(&$analytics) {
		// Get the user's first view (profile) ID.

		// Get the list of accounts for the authorized user.
		$accounts = $analytics->management_accounts->listManagementAccounts();

		if (count($accounts->getItems()) > 0) {
		$items = $accounts->getItems();
		$firstAccountId = $items[0]->getId();

		// Get the list of properties for the authorized user.
		$properties = $analytics->management_webproperties
			->listManagementWebproperties($firstAccountId);

		if (count($properties->getItems()) > 0) {
			$items = $properties->getItems();
			$firstPropertyId = $items[0]->getId();

			// Get the list of views (profiles) for the authorized user.
			$profiles = $analytics->management_profiles
				->listManagementProfiles($firstAccountId, $firstPropertyId);

			if (count($profiles->getItems()) > 0) {
			$items = $profiles->getItems();

			// Return the first view (profile) ID.
			return $items[0]->getId();

			} else {
			throw new Exception('No views (profiles) found for this user.');
			}
		} else {
			throw new Exception('No properties found for this user.');
		}
		} else {
		throw new Exception('No accounts found for this user.');
		}
	}
}

?>