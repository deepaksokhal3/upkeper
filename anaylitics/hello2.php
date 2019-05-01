<?php
$google_client_id       = '64708822544-n5m0ekob16hffskck2f3d7dfbafh5gqm.apps.googleusercontent.com';
$google_client_secret   = 'Yt9c7BE6etQgJ3KaV5rJV-Dc';
$google_redirect_url    = 'http://localhost/anaylitics/hello2.php'; 
//path to your script
$google_developer_key   = 'AIzaSyBW7J6TgNrmxXEfgc9-wIp2u2-J8p2PXsE';

########## MySql details (Replace with yours) #############
$db_username = "root"; //Database Username
$db_password = ""; //Database Password
$hostname = "localhost"; //Mysql Hostname
$db_name = 'google'; //Database Name
###################################################################

//include google api files
require_once 'src/Google_Client.php';

//start session
session_start();

$gClient = new Google_Client();
$gClient->setApplicationName('Test API');
$gClient->addService('analytics');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);

$google_oauthV2 = new Google_Oauth2Service($gClient);

//If user wish to log out, we just unset Session variable
if (isset($_REQUEST['reset'])) 
{
  unset($_SESSION['token']);
  $gClient->revokeToken();
  header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
}


if (isset($_GET['refreshToken']))
{
    try {
        $gClient->refreshToken($refreshToken);
        $newtoken = $gClient->getAccessToken();
        $_SESSION['token'] = $newtoken;
        header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
    } catch (Exception $e) {
        echo '<h1>Exception</h1>';
        echo '<p style="color:red">'.$e->getMessage()."</p>\n";
        print_r($e);
        exit;
    }
}
/*
$gClient->refreshToken($refreshToken);
$newtoken = $gClient->getAccessToken();
$_SESSION['token'] = $newtoken;

*/

if (isset($_GET['code'])) 
{ 
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
    return;
}

if (isset($_SESSION['token'])) 
{ 
    $gClient->setAccessToken($_SESSION['token']);
}

if(isset($authUrl)) //user is not logged in, show login button  
{
    echo '<a class="login" href="'.$authUrl.'"><img src="images/google-login-button.png" /></a>';
} 
else // user logged in 
{

    $arrayToken=json_decode($gClient->getAccessToken());
    $refreshToken=$arrayToken->refresh_token;
    $accessToken=$arrayToken->access_token;

    $_SESSION['access_token']=$refreshToken;

    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        // Set the access token on the client.
        $gClient->setAccessToken($_SESSION['access_token']);

        // Create an authorized analytics service object.
        $analytics = new Google_Service_Analytics($gClient);

        // Get the first view (profile) id for the authorized user.
        $profile = getFirstProfileId($analytics);

        // Get the results from the Core Reporting API and print the results.
        $results = getResults($analytics, $profile);
        printResults($results);
    } 


    function getFirstprofileId(&$analytics) {
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

    function getResults(&$analytics, $profileId) {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
        'ga:' . $profileId,
        '7daysAgo',
        'today',
        'ga:sessions');
    }

    function printResults(&$results) {
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

}