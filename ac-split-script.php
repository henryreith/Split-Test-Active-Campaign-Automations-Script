<?php

/*
Description: AC Split Test
Version: 1.0
Author: Henry Reith
Author URI: http://henryreith.co/
License: GPLv2 or later
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$api_url = ""; // << ---- Add your Active Campaign API URL should go in here
	$api_key = ""; // << ---- Add your Active Campaign API Key should go in here
	define("ACTIVECAMPAIGN_URL", $api_url);
	define("ACTIVECAMPAIGN_API_KEY", $api_key);
	require_once("includes/ActiveCampaign.class.php"); // << ---- path to the included Active Campaign API file: ActiveCampaign.class.php
	$ac = new ActiveCampaign(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);

	$webhook_data = $_POST;
  
	// basic validation check
	// if (!isset($webhook_data["contact"]["id"])) exit(); I'm not validating the data but you could if you wanted to

	// Just get the contact ID & email detail
	$contact_id = $webhook_data["contact"]["id"];
	$contact_email = $webhook_data["contact"]["email"];

	// Decide if id is Odd or even and do 
	if($contact_id % 2){ 
		// If odd add this tag
	    $contact = array(
			"email"		=> $contact_email,
			'tags' 		=> 'HR-Split-A', // << ---- Change this tag if you want
		);
		$contact_sync = $ac->api("contact/sync", $contact); // sync with AC
	}else{ 
		// If even add this tag
	    $contact = array(
			"email"		=> $contact_email,
			'tags' 		=> 'HR-Split-B', // << ---- Change this tag if you want
		);
		$contact_sync = $ac->api("contact/sync", $contact); // sync with AC
	}
}
?>