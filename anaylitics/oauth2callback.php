<?php

// // Load the Google API PHP Client Library.
// require_once __DIR__ . '/vendor/autoload.php';

// // Start a session to persist credentials.
// session_start();

// // Create the client object and set the authorization configuration
// // from the client_secrets.json you downloaded from the Developers Console.
// $client = new Google_Client();
// $client->setAuthConfig(__DIR__ . '/auth-c01f353790e9.json');
// $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/anaylitics/oauth2callback.php');
// $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

// // Handle authorization flow from the server.
// if (! isset($_GET['code'])) {
//   $auth_url = $client->createAuthUrl();
//   header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
// } else {
//   $client->authenticate($_GET['code']);
//   $_SESSION['access_token'] = $client->getAccessToken();
//   $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
//   header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
// }

require_once __DIR__.'/vendor/autoload.php';



// Fill CLIENT ID, CLIENT SECRET ID, REDIRECT URI from Google Developer Console
 $client_id = '64708822544-ummrcg5t37eu868pr74evvd6vq87c068.apps.googleusercontent.com';
 $client_secret = 'qZbBOwvBviDpa6WqwjZYbq2_';
 $redirect_uri = 'http://localhost/anaylitics/oauth2callback.php';
 $simple_api_key = 'AIzaSyCOxevGQjGeVlbeTJX-fofPP9Dsi_0mVyk';
 
//Create Client Request to access Google API
$client = new Google_Client();
$client->setApplicationName("PHP Google OAuth Login Example");
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setDeveloperKey($simple_api_key);
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
//Send Client Request
$objOAuthService = new Google_Service_Oauth2($client);

session_start();
print_r($_SESSION['access_token']);
//Logout
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
  $client->revokeToken();
 // header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); //redirect user back to page
}

//Authenticate code from Google OAuth Flow
//Add Access Token to Session
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: http://localhost/anaylitics');
}

//Set Access Token to make Request
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
}

//Get User Data from Google Plus
//If New, Insert to Database
if ($client->getAccessToken()) {
  $userData = $objOAuthService->userinfo->get();
 //  if(!empty($userData)) {
	// $objDBController = new DBController();
	// $existing_member = $objDBController->getUserByOAuthId($userData->id);
	// if(empty($existing_member)) {
	// 	$objDBController->insertOAuthUser($userData);
	// }
 //  }
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  echo '<a href="'.$authUrl.'">Login google</a>'; die;
}