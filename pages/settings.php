<?php
try{
    set_time_limit(0);
    // Including Google Analytics SDK
    require_once PLUGINPATH.'ga-sdk/Google_Client.php';
    require_once PLUGINPATH.'ga-sdk/contrib/Google_AnalyticsService.php';
    $client = new Google_Client();
    $client->setApplicationName('FX DIGITAL');
    $client->setAccessType('offline');
    $client->setUseObjects(true);
    // Reading plugin settings from option variable
    $ganalytics_settings = get_option('ganalytics_settings');
    $redirect_url = get_bloginfo('wpurl').'/wp-admin/admin.php?page=fxd_settings';
    //Analysing data from different forms in the page
    if(isset($_POST['settings-action'])){
        $settings_action = $_POST['settings-action'];
        switch($settings_action){
            case 'auth-options':
                if(isset($_POST['authType'])){
                    // reading auth type selected by user from formAuthOption
                    $formtype = $_POST['authType'];
                }
                // updating ga settings variable to check for own api or access code            
				if($formtype == 'code')
                    $ganalytics_settings['use_own_api'] = false;
                else if($formtype == 'api')
                    $ganalytics_settings['use_own_api'] = true;
                update_option('ganalytics_settings', $ganalytics_settings);
                break;
            case 'save-access-code':
                if(isset($_POST['authType'])){
                    // reading auth type selected by user from formAuthOption
                    $formtype = $_POST['authType'];
                }
                $ganalytics_settings['google_auth_code'] = $_POST['access-code'];
                update_option('ganalytics_settings', $ganalytics_settings);
                break;
            case 'save-api-credentials':
                if(isset($_POST['authType'])){
                    // reading auth type selected by user from formAuthOption
                    $formtype = $_POST['authType'];
                }
                $ganalytics_settings['google_api_key'] = $_POST['api-key'];
                $ganalytics_settings['google_client_id'] = $_POST['client-id'];
                $ganalytics_settings['google_client_secret'] = $_POST['client-secret'];
                update_option('ganalytics_settings', $ganalytics_settings);
                break;
            case 'form-reset-api-settings':
                $ganalytics_settings = array(
                    'use_own_api' => false,
                    'google_auth_code' => '',
                    'google_api_key' => '',
                    'google_client_id' => '',
                    'google_client_secret' => '',
                    'google_access_token' => '',
                    'ga_active_web_property' => '',
                    'ga_profile_id' => ''
                );
                update_option('ganalytics_settings', $ganalytics_settings);
                break;
            default:
                break;
        }
    }
  $ganalytics_settings = get_option('ganalytics_settings');
  $formtype = '';
    // Setting form type for initial page load
    if(!$ganalytics_settings['use_own_api']){
        $formtype = 'code';
		$client->setClientId('76132870952-crrv4ap1tr6puq5hsmft6n1svaqfc6nv.apps.googleusercontent.com');
        $client->setClientSecret('Y_jQ1ZN_AT-SW3zWz2hmTPuM');
        $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
    }
    else{
        $formtype = 'api';
        $client->setClientId($ganalytics_settings['google_client_id']);
        $client->setClientSecret($ganalytics_settings['google_client_secret']);
        $client->setDeveloperKey($ganalytics_settings['google_api_key']);
        $client->setRedirectUri($redirect_url);
}
$analytics = new Google_AnalyticsService($client);
// Setting Access Token
$access_token = $ganalytics_settings['google_access_token'];
if($access_token){
	$client->setAccessToken($access_token);
}else{
	if($formtype == 'code'){
            if($ganalytics_settings['google_auth_code']){
                $client->authenticate($ganalytics_settings['google_auth_code']);
                $ganalytics_settings['google_access_token'] = $client->getAccessToken();
                update_option('ganalytics_settings', $ganalytics_settings);
            }
        }
        else if($formtype == 'api') {
            if (isset($_GET['code'])) {
                $client->authenticate();
                $ganalytics_settings['google_access_token'] = $client->getAccessToken();
                update_option('ganalytics_settings', $ganalytics_settings);
                if(headers_sent())
                { ?>
<script>
window.location.href="<?php echo $redirect_url; ?>";
</script>
<?php
 exit;
} else{
	header('Location:'.$redirect_url);
    exit;
	}}
        }
    }
    if(isset($_POST['settings-action'])){
        if($_POST['settings-action'] == 'save-api-credentials'){
            $client->setClientId($ganalytics_settings['google_client_id']);
            $client->setClientSecret($ganalytics_settings['google_client_secret']);
            $client->setDeveloperKey($ganalytics_settings['google_api_key']);
            $client->setRedirectUri($redirect_url);
            if(headers_sent()){
?>
 <script>
window.location.href="<?php echo $client->createAuthUrl(); ?>";
</script>  <?php
                exit;
}else{ header('Location:'.$client->createAuthUrl());
   exit;
            }
        }
    }
    ?><div class="wrap ganalytics settings">
<div id="icon-options-general" class="icon32 ga-header-app-icon"><br></div>
<h2>Settings</h2>
 <?php
 if(!$client->getAccessToken()){
 $authUrl = $client->createAuthUrl();
 ?>
<!-- Google API Settings >> Options Form -->
    <form method="post" name="formAuthOption">
        <input type="hidden" name="settings-action" value="auth-options"/>
        <table class="form-table">
            <tbody>
            <tr>
                <td>
                    How do you prefer to connect with your Google Analytics account?
                </td>
            </tr>
            <tr><td><label>
<input type="radio" name="authType" value="code" onclick="this.form.submit()"
<?php if($formtype == 'code') echo 'checked'; ?>/>
                         Access Code
                    </label>
                    <p class="description">
                        This method is quick. But since this method uses our api credentials, the daily rate limit is shared by all users.
</p>
</td>
</tr>
<tr><td><label>
<input type="radio" name="authType" value="api" onclick="this.form.submit()"
<?php if($formtype == 'api') echo 'checked'; ?>/>
 Own API Credentials </label> <p class="description">
 We suggest to use your own API credentials. </p>
</td>
</tr></tbody></table>
</form>
<?php
        if($formtype == 'code'){
?>
 <!-- Google Access Code -->
 <form method="post" name="formAccessCode">
 <input type="hidden" name="settings-action" value="save-access-code"/>
 <input type="hidden" name="authType" value="<?php echo $formtype; ?>"/>
 <table class="form-table">
<tbody> <tr><td colspan="2"><hr class="hr-thin"/></td>
 </tr><tr><td colspan="2"><h2>Google Access Code</h2></td>
</tr> <tr><td colspan="2"><a href="<?php echo $authUrl; ?>" target="_blank">Click here</a> to obtain your Google Access Code</td> </tr><tr><th>Paste Access Code Here:
</th><td><input type="text" name="access-code" class="regular-text" value="<?php echo $ganalytics_settings['google_auth_code'] ?>" autocomplete="off"/> </td> </tr>
<tr><td><input type="submit" name="access-code-submit" class="button button-primary" value="Save and Connect"/>
</td> </tr> </tbody>
</table>
</form>
<?php } ?>
 <?php
if($formtype == 'api'){ ?>
<!-- Google Access Code -->
<form method="post" name="formOwnCredentials">
<input type="hidden" name="settings-action" value="save-api-credentials"/>
<input type="hidden" name="authType" value="<?php echo $formtype; ?>"/>
<table class="form-table">
<tbody>
 <tr>
 <td colspan="2"><hr class="hr-thin"/></td>
</tr>
 <tr><td colspan="2"><h2>API Credentials</h2></td>
</tr><tr><th> API Key: </th><td>
<input type="text" name="api-key" class="regular-text" style="width: 70%;" value="<?php echo $ganalytics_settings['google_api_key'] ?>" autocomplete="off"/></td>
</tr>
<tr>
<th> Client ID:</th> <td><input type="text" name="client-id" class="regular-text" style="width: 70%;" value="<?php echo $ganalytics_settings['google_client_id'] ?>" autocomplete="off"/></td>
</tr><tr><th>Client Secret:</th><td><input type="text" name="client-secret" class="regular-text" style="width: 70%;" value="<?php echo $ganalytics_settings['google_client_secret'] ?>" autocomplete="off"/>
</td>
</tr>
<tr><tr><th>Redirect URL:</th><td><input type="text" name="api-redirect-url" class="regular-text" style="width: 70%;"  value="<?php echo $redirect_url; ?>"/>
<script type="text/javascript">
 jQuery(function ($) {
 $(document).ready(function(){
 $("input[name='api-redirect-url']").click(function(){
 this.select();
 });
 });
 });
 </script>
</td></tr> <tr><td><input type="submit" name="access-code-submit" class="button button-primary" value="Save and Connect"/> </td></tr></tbody></table>
</form>
<?php
} //end if formtype==api
}else{?>
<table class="form-table"><?php
$blog_url = get_bloginfo( 'url' );
$parsed_url = parse_url($blog_url);
$blog_domain = $parsed_url["host"];
$blog_domain = str_ireplace("www.","",$blog_domain);
?><tbody><tr><td colspan="2"><strong> You are now connected to Google Analytics Of <?php echo $blog_domain ?></strong></td>
</tr><?php
$props = $analytics->management_webproperties->listManagementWebproperties("~all");
$items = $props->getItems();
if(isset($_POST['settings-action']) && $_POST['settings-action'] == 'form-select-profile'){
$blog_domain_property = '';
foreach($items as $key => $property){
if($property->websiteUrl == $_POST['ga-select-web-property']){
$blog_domain_property = $property;
$ganalytics_settings['ga_active_web_property'] = $blog_domain_property;
update_option('ganalytics_settings', $ganalytics_settings);
break;}
}
}else{
if($ganalytics_settings['ga_active_web_property']){
$blog_domain_property =  $ganalytics_settings['ga_active_web_property'];
}else{
$blog_domain_property = '';
foreach($items as $key => $property){
if(strpos($property->websiteUrl, $blog_domain)){
$blog_domain_property = $property;
$ganalytics_settings['ga_active_web_property'] = $blog_domain_property;
update_option('ganalytics_settings', $ganalytics_settings);
break;}else{$blog_domain_property = $property;
$ganalytics_settings['ga_active_web_property'] = $blog_domain_property;
update_option('ganalytics_settings', $ganalytics_settings);
}
}
}
}
?><tr><th>Website URL:</th>
<td><strong><?php echo $blog_domain_property->websiteUrl ?></strong></td>
</tr><tr><th>Analytics ID:</th><td><strong><?php echo $blog_domain_property->id ?></strong></td>
</tr></tbody></table>
<form method="post">
<input type="hidden" name="settings-action" value="form-select-profile"/>
<table class="form-table ga-web-property-wrapper">
<tbody><tr><td colspan="2">
<hr class="hr-thin"/></td>
</tr><tr><td colspan="2">If above profile does not corresponds to this site, please select another profile.</td></tr><tr><th>Select Your Analytics Profile</th><td><?php
	echo '<select name="ga-select-web-property">';
	foreach($items as $key => $property){
    $url = $property->websiteUrl;
	 echo '<option value="'.$url.'"';
	 if($property->websiteUrl == $blog_domain_property->websiteUrl)
		 echo 'selected';
			echo'>'.$url.'</option>';}
				echo '</select>';?>
</td>
</tr>
<tr>
<th></th><td><input type="submit" value="Save Analytics Profile" class="button button-primary"/>
</td></tr> </tbody></table></form>
<?php
$blog_domain_property = $ganalytics_settings['ga_active_web_property'];
$profile_details = $analytics->management_profiles->listManagementProfiles($blog_domain_property->accountId, $blog_domain_property->id)->getItems();
$profile_id = $profile_details[0]->id;
$ganalytics_settings['ga_profile_id'] = $profile_id;
update_option('ganalytics_settings', $ganalytics_settings);
?><form method="post">
<input type="hidden" name="settings-action" value="form-reset-api-settings"/>
<table class="form-table ga-reset-settings-wrapper">
<tbody><tr><td><hr class="hr-thin"/></td></tr><tr><td><input style="position:relative; top:-95px;" type="submit" value="Reset API Settings" class="button button-danger"/></td></tr></tbody>
</table>
</form>
<?php } ?></div>
<?php }
catch(Exception $e){ ?>
<div class="updated below-h2" style="margin-left: 0px;">
<p>Plugin could not setup the settings page. Please reactivate the plugin.</p>
</div>
<?php
}
?>