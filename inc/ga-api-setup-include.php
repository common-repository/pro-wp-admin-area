<?php
set_time_limit(0);
//plugin page urls
$settings_url = get_bloginfo('wpurl').'/wp-admin/admin.php?page=fxd_settings';

/********** Setting Google Analytics API SDK ************/
// Including Google Analytics SDK
require_once PLUGINPATH.'ga-sdk/Google_Client.php';
require_once PLUGINPATH.'ga-sdk/contrib/Google_AnalyticsService.php';
$client = new Google_Client();
$client->setApplicationName('FX Digital');
$client->setAccessType('offline');
$client->setUseObjects(true);
// Reading plugin settings from option variable
$ganalytics_settings = get_option('ganalytics_settings');
if(!$ganalytics_settings['use_own_api']){
    $client->setClientId('76132870952-crrv4ap1tr6puq5hsmft6n1svaqfc6nv.apps.googleusercontent.com');
    $client->setClientSecret('Y_jQ1ZN_AT-SW3zWz2hmTPuM');
    $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
}
else{
    $client->setClientId($ganalytics_settings['google_client_id']);
    $client->setClientSecret($ganalytics_settings['google_client_secret']);
    $client->setDeveloperKey($ganalytics_settings['google_api_key']);
}
$analytics = new Google_AnalyticsService($client);
// Setting Access Token
$access_token = $ganalytics_settings['google_access_token'];
if($access_token){
    $client->setAccessToken($access_token);
}
/******* End of setting google analytics api sdk ********/
/******** Reading Google Analytics setup date *********/
$created_time = $ganalytics_settings['ga_active_web_property']->created;
$created_time_display = date('d M, Y',strtotime($created_time));
$created_time_api = date('Y-m-d',strtotime($created_time));
/****** End of reading Google Analytics Setup date *******/
?>