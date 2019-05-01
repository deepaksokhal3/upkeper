<?php
// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';

// Start a session to persist credentials.
session_start();

// Create the client object and set the authorization configuration
// from the client_secretes.json you downloaded from the developer console.
$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/auth-c01f353790e9.json');
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
//$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

// If the user has already authorized this app then get an access token
// else redirect to ask the user to authorize access to Google Analytics.
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

  // Set the access token on the client.
  $client->setAccessToken($_SESSION['access_token']);
  // Create an authorized analytics service object.
  $analytics = new Google_Service_Analytics($client);
  //$analytics = new Google_Service_AnalyticsReporting($client);
  //getReport($analytics);
  // Get the first view (profile) id for the authorized user.
  get_device_reports();
  $profile = getFirstProfileId($analytics);
 // print_r($analytics);die('sdfdsf');
  // Get the results from the Core Reporting API and print the results.
  $results = getResults($analytics, $profile);
  printResults($results);
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/anaylitics/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
function get_device_reports(){
    $Url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=".$_SESSION['access_token']['access_token'];
        $params = '{
            reportRequests:[{
            viewId:"ga:150663587",
             dateRanges:[{
              startDate:"30daysAgo",
             endDate:"today"
            }],
             metrics:[{expression:"ga:sessions"},
             {expression: "ga:percentNewSessions"},
             {expression: "ga:newUsers"}],
             dimensions: [{ "name":"ga:medium"}]
            }]
            }';
         $res = sendPostData($Url,$params);
        $Rresult =  json_decode($res);
         echo '<pre>';
print_r($Rresult);die;
}
function getFirstProfileId($analytics) {

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

 function sendPostData($url, $post) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", 'Content-Length: ' . strlen($post)));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $result;
    }


function getResults($analytics, $profileId) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
  //$results = $analytics->metadata_columns->listMetadataColumns('ga');
 // printMetadataReport($results);


$dimensions = 'ga:sourceMedium';
  return $analytics->data_ga->get(
      'ga:'.$profileId,
      '30daysAgo',
      'yesterday',
      'ga:visits',
      array('metrics' => 'ga:sessions,ga:users'),
      array('dimensions' => $dimensions));
}

function printResults($results) {

  echo '<pre>';
  print_r($results);die;
  // Parses the response from the Core Reporting API and prints
  // the profile name and total sessions.
  if (count($results->getRows()) > 0) {

    // Get the profile name.
    $profileName = $results->getProfileInfo()->getProfileName();

    // Get the entry for the first entry in the first row.
    $rows = $results->getRows();
    $sessions = $rows[0][0];

    // Print the results.
    print "<p>First view (profile) found: $profileName</p>";
    print "<p>Total sessions: $sessions</p>";
  } else {
    print "<p>No results found.</p>";
  }
}




function printMetadataReport($results) {
  print '<h1>Metadata Report</h1>';
  printReportInfo($results);
  printAttributes($results);
  printColumns($results);
}




function printReportInfo(&$results) {
  $html = '<h2>Report Info</h2>';
  $html .= <<<HTML
<pre>
Kind                  = {$results->getKind()}
Etag                  = {$results->getEtag()}
Total Results         = {$results->getTotalResults()}
</pre>
HTML;
  print $html;
}


function printAttributes(&$results) {
  $html = '<h2>Attribute Names</h2><ul>';
  $attributes = $results->getAttributeNames();
  foreach ($attributes as $attribute) {
    $html .= '<li>'. $attribute . '</li>';
  }
  $html .= '</ul>';
  print $html;
}


function printColumns(&$results) {
  $columns = $results->getItems();
  if (count($columns) > 0) {
    $html = '<h2>Columns</h2>';
    foreach ($columns as $column) {
      $html .= '<h3>' . $column->getId() . '</h3>';
      $column_attributes = $column->getAttributes();
      foreach ($column_attributes as $name=>$value) {
        $html .= <<<HTML
<pre>
{$name}: {$value}
</pre>
HTML;
      }
    }
  } else {
    $html = '<p>No Results Found.</p>';
  }
  print $html;
}




?>
