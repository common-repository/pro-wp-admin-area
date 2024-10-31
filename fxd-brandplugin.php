<?php
/*
Plugin Name: PRO WP ADMIN Free
Plugin URI:  https://website-designs.com
Description: This Plugin allow you to customize your admin area .
Version: 1.0.5
Author: Steve Cartwright
Author URI: https://website-designs.com
*/
ob_start();
define('FXD_PRO_WP_ADMIN_CONTROL','1.0.0') ;
$plugin_dir = plugin_dir_url( __FILE__ ).'images/';
$fxd_label = "fxd_pwpa_";
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
if(get_option('fxd_pwpa_hide_wp_version') == 1){
	 add_filter('update_footer','hide_footer_version',99999);
	 add_action('admin_head','fxd_pwpa_hide_wp_version');
}
if(get_option('fxd_pwpa_add_new_footer_logo')){
	add_filter('admin_footer_text', 'fxd_pwpa_footer_logo');
}
global $wpdbb_content_dir;
if(!function_exists('wp_get_current_user')){
	include(ABSPATH."wp-includes/pluggable.php") ; // Include pluggable.php for current user	
}
/*
 * Perform vairous action of wordpress
 */
add_action('admin_init', 'fxd_pwpa_addoption');
add_action('admin_menu', 'fxd_pwpa_addAdmin'); 
add_action('wp_before_admin_bar_render', 'fxd_pwpa_Adminbar', 0);
add_action('admin_head', 'fxd_pwpa_customdashboard');
include 'config.php';
include 'inc/functions.php';
include('includes/extraaction.php');  
// Plugin activation
function fxd_analyitcs_activate() {
	global $wpdb;	
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $table_name = $wpdb->prefix . "custom_menu_hide";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
            id int(9) NOT NULL AUTO_INCREMENT,
            name text,
            value text,
            date datetime,
            PRIMARY KEY  (id));";
            dbDelta($sql);
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
    add_option( 'ganalytics_settings', $ganalytics_settings );
}
register_activation_hook( __FILE__, 'fxd_analyitcs_activate' );
// Plugin deactivation
// Plugin deactivation
function fxd_analyitcs_deactivate() {
    delete_option( 'ganalytics_settings' );
	global $wpdb;
    $table_name = $wpdb->prefix . "custom_menu_hide";
    $wpdb->query("DROP TABLE IF EXISTS $table");
	include('uninstall.php');
}
register_deactivation_hook( __FILE__, 'fxd_analyitcs_deactivate' );
/*
 * Method :-- fxd_pwpa_add_menu
 * Task   :-- Create a new menu for our plugin
*/
function fxd_pwpa_add_menu() {
   $hook_name = add_menu_page('PRO WP ADMIN','PWPA Setting','manage_options','fxd-brandplugin.php','fxd_pwpa_admin',plugin_dir_url( __FILE__ ).'images/fxd.png');
    add_submenu_page( 'fxd-brandplugin.php','Active Google Analytic', 'Active Google Analytic', 'manage_options', 'fxd_setting', 'fxd_settings_page' ); 
    add_action( "admin_print_scripts-$hook_name", 'fxd_pwpa_scripts' );
}
add_action('admin_menu', 'fxd_pwpa_add_menu');
/*
 * Method :-- fxd_pwpa_admin
 * Task   :-- Create a new menu for our plugin
 */
function fxd_pwpa_admin() {
    global $menu, $submenu;
    require('includes/adminview.php');
}
/*
 * Method :-- fxd_settings_page
 * Task   :-- Include the setting page .
 */
function fxd_settings_page(){
    if ( isset( $_GET['page'] ) && 'fxd_setting' == $_GET['page'] )
        include(PLUGINPATH.'pages/settings.php');
}
/*
 * Method :-- fxd_pwpa_scripts
 * Task   :-- Include the script and Style Sheet in the plugin
*/
function fxd_pwpa_scripts() {
    wp_enqueue_script('fxd-script', plugins_url('js/bootstrap.js', __FILE__), array('media-upload'));
    wp_enqueue_script('fxd-script-2', plugins_url('js/bootstrap.min.js', __FILE__), array('media-upload'));
	wp_enqueue_script('fxd-script-3', plugins_url('js/custom.js', __FILE__), array('media-upload'));
    wp_enqueue_style('fxd-style-1', plugins_url('css/bootstrap-theme.css', __FILE__), false);
	wp_enqueue_style('fxd-style-2', plugins_url('css/bootstrap.css', __FILE__), false);
	wp_enqueue_style('fxd-style-3', plugins_url('css/custom.css', __FILE__), false);
	wp_enqueue_style('thickbox');
}
/*
 * Method :-- fxd_pwpa_Adminbar
 * Task   :-- Add Option in wp_option table 
 */
function fxd_pwpa_Adminbar (){
	global $wp_version;
	if( get_option('fxd_pwpa_hide_logo') ){
    echo " \n\n <style type=\"text/css\">#wp-admin-bar-wp-logo { display:none; } #wpadminbar #wp-admin-bar-site-name > .ab-item:before { content: normal;}</style> \n\n";
}
if( get_option('fxd_pwpa_add_new_logo') ){
        $background = get_option('fxd_pwpa_add_new_logo');
        if(!preg_match("@^https?://@", $background))
            $background = get_bloginfo('stylesheet_directory').'/images/'.$background;
        echo '<script type="text/javascript"> jQuery(document).ready(function(){ ';
        echo  'jQuery("#wp-admin-bar-root-default").prepend(" <li id=\"admin_logo\"> <span style=\"float:left;height:28px;line-height:28px;vertical-align:middle;text-align:center;width:28px\"><img src=\"'.$background.'\" width=\"16\" height=\"16\" alt=\"Login\" style=\"height:16px;width:16px;vertical-align:middle\" /> </span> </li> "); ';
		echo '  }); ';
        echo '</script> ';
		}
}
/*
 * Method :-- fxd_pwpa_addAdmin
 * Task   :-- Add Option in wp_option table 
*/
function fxd_pwpa_addAdmin(){
	global  $menu, $submenu;
	if(isset($_GET['page']) && $_GET['page'] == 'fxd-brandplugin.php'){
		if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ){
		  add_action('admin_init', 'fxd_pwpa_SaveDetail');
        }
	}
}
/*
 * Method :-- set_superAdmin_role
 * Task   :-- Create New User Role As a Super Admin
 */
function set_superAdmin_role() {
global $wp_roles;
$caps = array('activate_plugins' => true,'create_users' => true,'delete_plugins' => true,'delete_themes' => true,'delete_users' => true,'edit_files' => true,'edit_plugins' => true,'edit_theme_options' => true,'edit_themes' => true,'edit_users' => true,'export' => true,'import' => true,'manage_options' => true,'switch_themes' => true,'update_core' => true,'update_plugins' => true,'edit_dashboard' => true,'manage_categories' => true,'manage_links' => true,'edit_others_posts' => true,'edit_pages' => true,'edit_others_pages' => true,'edit_published_pages' => true,'publish_pages' => true,'delete_pages' => true,'delete_others_pages' => true,'import' => true,'delete_published_pages' => true,'delete_others_posts' => true,'delete_private_posts' => true,'edit_private_posts' => true,'read_private_posts' => true,'delete_private_pages' => true,'edit_private_pages' => true,'read_private_pages' => true,'edit_published_posts' => true,'upload_files' => true,'publish_posts' => true,'edit_posts' => true,'delete_posts' => true,'read' => true,'delete_published_posts' => true );
  $wp_roles->add_role( 'super_admin', 'Web Admin', $caps );
}
add_action('admin_head', 'set_superAdmin_role');
/*
 * Method :-- superAdmin_caps
 * Task   :-- All the capabilities for the new Super Admin User 
*/
function superAdmin_caps() {
    $role = get_role( 'super_admin' );
	$caps = array('fxd_pwpa-activate_plugins','fxd_pwpa-update_plugins','fxd_pwpa-edit_plugins','fxd_pwpa-delete_plugins','fxd_pwpa-create_users','fxd_pwpa-edit_users','fxd_pwpa-delete_users','fxd_pwpa-edit_theme_options','fxd_pwpa-edit_themes','fxd_pwpa-manage_options','fxd_pwpa-switch_themes','fxd_pwpa-delete_themes','fxd_pwpa-update_core','fxd_pwpa-edit_pages','fxd_pwpa-edit_others_pages','fxd_pwpa-read_private_posts', 'fxd_pwpa-edit_posts', 'fxd_pwpa-edit_others_posts', 'fxd_pwpa-edit_published_posts', 'fxd_pwpa-edit_private_posts', 'fxd_pwpa-publish_posts', 'fxd_pwpa-delete_posts', 'fxd_pwpa-delete_others_posts', 'fxd_pwpa-delete_published_posts', 'fxd_pwpa-delete_private_posts',);
	foreach($caps as $cap){
		$new_cap = explode("-",$cap);
		$new_cap = $new_cap[1];
		if(get_option($cap)== 1){
		$role->add_cap($new_cap);
		}elseif(get_option($cap)== 0){
		 $role->remove_cap($new_cap);
		}
	}		
}
add_action( 'admin_head', 'superAdmin_caps');
/*
 * Method :-- fxd_pwpa_addoption
 * Task   :-- Add Option in wp_option table 
*/
function fxd_pwpa_addoption() {
	global $menu, $submenu; 
	if(! get_option('fxd_pwpa_welcome_title') ){
        include('includes/branding_form.php');
        foreach ($fxdOptions as $value){
                if ( isset($value['id']) && $value['id'] != '' && isset($value['std']) ){
                        add_option( $value['id'], $value['std']  );
				}
		}
		/*include('includes/menulistform.php');
		foreach($fxdOptionsCustomenu as $value){
			if ( isset($value['id']) && $value['id'] != '' && isset($value['std']) ){
                        add_option( $value['id'], $value['std']  );
				}
		}*/
		include('includes/rss_feedForm.php');
        foreach ($fxdOptionsRssPro as $value){
                if ( isset($value['id']) && $value['id'] != '' && isset($value['std']) ){
                        add_option( $value['id'], $value['std']  );
				}
		}
		include('includes/rssfeedformpro.php');
        foreach ($fxdOptionsRss as $value){
				//print_r($fxdOptionsRssPro);die();
                if ( isset($value['id']) && $value['id'] != '' && isset($value['std']) ){
                        add_option( $value['id'], $value['std']  );
				}
		}
		include('includes/dashboardForm.php');
		foreach($fxdOptionsDashboard as $value){
			if ( isset($value['id']) && $value['id'] != '' && isset($value['std']) ){
                        add_option( $value['id'], $value['std']  );
				}
		}
		include('includes/super_adminForm.php');
		foreach($fxdSuperAdminPermission as $value){
			if ( isset($value['id']) && $value['id'] != '' && isset($value['std']) ){
                        add_option( $value['id'], $value['std']  );
				}
		}
		include('includes/permission_Form.php');
		foreach($fxdOptionsPermission as $value){
			if ( isset($value['id']) && $value['id'] != '' && isset($value['std']) ){
                        add_option( $value['id'], $value['std']  );
				}
		}
		foreach($fxdOptionsMenu as $value){
			if ( isset($value['id']) && $value['id'] != '' && isset($value['std']) ){
                        add_option( $value['id'], $value['std']  );
				}
		}
	}
}
/*
 * Method :-- fxd_pwpa_SaveDetail
 * Task   :-- Save the option in wp_option table
*/
function fxd_pwpa_SaveDetail(){
	    check_admin_referer( 'security-setting' );
		include('includes/branding_form.php');
		foreach($fxdOptions as $rows){
			if(isset($rows['id']) && isset($_REQUEST[ $rows['id'] ])){
				update_option ($rows['id'] ,$_REQUEST[ $rows['id'] ]);
			}
		}
		include('includes/rss_feedForm.php');
		foreach($fxdOptionsRssPro as $rows){
			if(isset($rows['id']) && isset($_REQUEST[ $rows['id'] ])){
				update_option ($rows['id'] ,$_REQUEST[ $rows['id'] ]);
			}
		}
		include('includes/rssfeedformpro.php');
        foreach ($fxdOptionsRss as $rows){
                if(isset($rows['id']) && isset($_REQUEST[ $rows['id'] ])){
				update_option ($rows['id'] ,$_REQUEST[ $rows['id'] ]);
			}
		}
		/*include('includes/menulistform.php');
        foreach ($fxdOptionsCustomenu as $rows){
               if(isset($rows['id']) && isset($_REQUEST[ $rows['id'] ])){
				update_option ($rows['id'] ,$_REQUEST[ $rows['id'] ]);
			}
		}*/
		include('includes/dashboardForm.php');
		foreach($fxdOptionsDashboard as $rows){
			if(isset($rows['id']) && isset($_REQUEST[ $rows['id'] ])){
				update_option ($rows['id'] ,$_REQUEST[ $rows['id'] ]);
			}
		}
		include('includes/super_adminForm.php');
		foreach($fxdSuperAdminPermission as $rows){
			if(isset($rows['id']) && isset($_REQUEST[ $rows['id'] ])){
				update_option ($rows['id'] ,$_REQUEST[ $rows['id'] ]);
		}
		}
		include('includes/permission_Form.php');
		foreach($fxdOptionsPermission as $rows){
			if(isset($rows['id']) && isset($_REQUEST[ $rows['id'] ])){
				update_option ($rows['id'] ,$_REQUEST[ $rows['id'] ]);
			}
		}
		foreach($fxdOptionsMenu as $rows){
			if(isset($rows['id']) && isset($_REQUEST[ $rows['id'] ])){
				update_option ($rows['id'] ,$_REQUEST[ $rows['id'] ]);
			}
		}
}
	/*
	 * Method :-- fxd_pwpa_customdashboard
	 * Task   :-- Customize the Admin Dashboard
	*/
function fxd_pwpa_customdashboard(){
    global $current_screen, $wp_version;
    if( isset($current_screen) && ($current_screen->id == 'dashboard' ) ):
        if( get_option('fxd_pwpa_change_deashobard_heading') || get_option('fxd_pwpa_change_deashobard_heading') == '' ) :
            if ( get_option('fxd_pwpa_change_deashobard_heading') != __('Dashboard') ) :
                $val = (get_option('fxd_pwpa_change_deashobard_heading') == '' ? '&nbsp;' : get_option('fxd_pwpa_change_deashobard_heading') );
                echo '<style type="text/css">#wpbody-content .wrap h2 { visibility: hidden; }</style>
                        <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                        $("#wpbody-content .wrap h2:eq(0)").html("'.$val.'");
                                        $("#wpbody-content .wrap h2").css("visibility","visible");
                                });
                        </script>';
                endif;
        endif;
        if( get_option('fxd_pwpa_add_new_dashboard_logo') ):
            $background =  get_option('fxd_pwpa_add_new_dashboard_logo');
            if(!preg_match("@^https?://@", $background)){
       			 $background = get_bloginfo('stylesheet_directory').'/images/'.$background;
            }
            echo '<style type="text/css">
                            #icon-index {background:transparent;height:auto;width:auto;visibility: hidden;}
                            #dashboard-widgets-wrap {clear:both}
                    </style>';
            echo '<script type="text/javascript">
                            jQuery(document).ready(function($) {';
			if ( version_compare( $wp_version, '3.8-beta', '>=' ) ){
					echo '$(".index-php #wpbody-content .wrap h2:eq(0)").prepend("<span id=\"fxd_pwpa_add_new_dashboard_logo\"><img src=\"'.$background.'\" alt=\"\" /></span>");
						  $("#fxd_pwpa_add_new_dashboard_logo").css({"visibility":"visible", "display": "block", "float" : "left", "margin": "-2px 8px 0px 0px"});';
				}else{echo '$("#icon-index").html("<img src=\"'.$background.'\" alt=\"\" />");
							$("#icon-index").css({"visibility":"visible", "display": "block", "float" : "left", "margin": "7px 8px 0px 0px"});';
				}
				echo'});
</script>';
endif;
    endif;
}
/*
 * Method :-- fxd_pwpa_hide_wp_version
 * Task   :-- Hide the footer version
*/
function fxd_pwpa_hide_wp_version(){
    echo '<style type="text/css">#wp-version-message { display: none;}</style>';
}
/*
 * Method :-- hide_footer_version
 * Task   :-- Hide the footer version
*/
function hide_footer_version(){
	$text = "Plugin Powered by :-- <a href='http://website-designs.com/'><strong>FX Digital</strong></a>" ;
    return $text ;
}
/*
 * Method :-- fxd_pwpa_footer_logo
 * Task   :-- Change the Footer logo  and put the website link in that 
*/
function fxd_pwpa_footer_logo(){
    $footer_logo = get_option('fxd_pwpa_add_new_footer_logo');
    if($footer_logo)
        if(!preg_match("@^https?://@", $footer_logo))
                $footer_logo = get_bloginfo('stylesheet_directory').'/images/'.$footer_logo;
        echo '<span id="footer-thankyou">';
        if (get_option('fxd_pwpa_developer_website_url')) {
                echo '<a target="_blank" href="' . get_option('fxd_pwpa_developer_website_url') . '">';
           echo '<img src="'.$footer_logo. '" id="fxd-footer-logo"> </a> <span> <a target="_blank" href="' . get_option('fxd_pwpa_developer_website_url') . '">' . stripslashes(get_option('fxd_pwpa_developer_name')) . '</a> </span>';
        }else{
			echo '<img src="'.$footer_logo.'" id="fxd-footer-logo">';
}
echo '</span>';
}
/*
 * Method :-- fxd_pwpa_add_dashboard_widget
 * Task   :-- Add the widget for RSS Feed
*/
add_action('wp_dashboard_setup', 'fxd_pwpa_add_dashboard_widget' );
function fxd_pwpa_add_dashboard_widget() {
    if ( get_option('fxd_pwpa_show_rss_widget') ):
        $img = ( get_option('fxd_pwpa_rss_logo') ? get_option('fxd_pwpa_rss_logo') : '' );
        if($img)
            $img = '<img src="'.$img.'" height="16" width="16" alt="Logo" style="padding-right:5px;vertical-align:bottom;"/>';
		wp_add_dashboard_widget('fxd_pwpa_rss_box', $img . get_option('fxd_pwpa_rss_title'), 'fxd_pwpa_rss_box');
    endif;
    if ( get_option('fxd_pwpa_show_welcome') ):
        if ( get_option('fxd_pwpa_welcome_visible_to')):
            wp_add_dashboard_widget('custom_help_widget', get_option('fxd_pwpa_welcome_title'), 'fxd_pwpa_custom_dashboard_help');endif;
        if (get_option('fxd_pwpa_welcome_visible_to1') ):
            wp_add_dashboard_widget('my_dashboard_widget', get_option('fxd_pwpa_welcome_title1'), 'fxd_pwpa_custom_dashboard_help_new');
        endif;
    endif;
}
/*
 * Method :-- fxd_pwpa_pro_rss_widget
 * Task   :-- Add the widget for PRO RSS Feed
*/
add_action('wp_dashboard_setup', 'fxd_pwpa_pro_rss_widget' );
function fxd_pwpa_pro_rss_widget() {
    if ( get_option('fxd_pwpa_show_rss_widget_pro') ):
        $img = ( get_option('fxd_pwpa_rss_logo_pro') ? get_option('fxd_pwpa_rss_logo_pro') : '' );
        if($img)
            $img = '<img src="'.$img.'" height="16" width="16" alt="Logo" style="padding-right:5px;vertical-align:bottom;"/>';
        wp_add_dashboard_widget('fxd_pwpa_rss_box_pro', $img . get_option('fxd_pwpa_rss_title_pro'), 'fxd_pwpa_rss_box_pro');
    endif;
}
/*
 * Method :-- fxd_pwpa_rss_box
 * Task   :-- Add the widget for RSS Feed In the admin
*/

function fxd_pwpa_rss_box(){
    if(!get_option('fxd_pwpa_rss_value'))
        return;
    include_once(ABSPATH . WPINC . '/feed.php');
    $num_items = get_option('fxd_pwpa_rss_num_items');
    $rss = fetch_feed( get_option('fxd_pwpa_rss_value') );
    if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly
        $maxitems = $rss->get_item_quantity($num_items);
        $rss_items = $rss->get_items(0, $maxitems);
    endif;
    if( get_option('fxd_pwpa_rss_intro_html') ):
        echo wpautop ( stripslashes( get_option('fxd_pwpa_rss_intro_html') ) );
    endif; 
?>
<ul>
    <?php if ($maxitems == 0) echo '<li>No items.</li>';
    else
    // Loop through each feed item and display each item as a hyperlink.
    foreach ( $rss_items as $item ) : ?>
    <li><strong> <a href='<?php echo esc_url( $item->get_permalink() ); ?>'
        title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>' target='_blank'>
        <?php echo esc_html( $item->get_title() ); ?></a> </strong> <br />
        <?php if(get_option('fxd_pwpa_rss_show_intro') == 'yes'): 
            echo $item->get_content();
        endif; ?>
    </li>
    <?php endforeach; ?>
</ul>
<?php 
}
/*
 * Method :-- fxd_pwpa_rss_box_pro
 * Task   :-- Add the widget for PRO RSS Feed In the admin
*/
function fxd_pwpa_rss_box_pro(){
    if(!get_option('fxd_pwpa_rss_value_pro'))
        return;
    include_once(ABSPATH . WPINC . '/feed.php');
    $num_items = get_option('fxd_pwpa_rss_num_items_pro');
    $rss = fetch_feed( get_option('fxd_pwpa_rss_value_pro') );
    if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly
        $maxitems = $rss->get_item_quantity($num_items);
        $rss_items = $rss->get_items(0, $maxitems);
    endif;
    if( get_option('fxd_pwpa_rss_intro_html_pro') ):
        echo wpautop ( stripslashes( get_option('fxd_pwpa_rss_intro_html_pro') ) );
    endif; 
?>
<ul><?php if ($maxitems == 0) echo '<li>No items.</li>';
    else
    // Loop through each feed item and display each item as a hyperlink.
    foreach ( $rss_items as $item ) : ?>
    <li><strong><a href='<?php echo esc_url( $item->get_permalink() ); ?>'
        title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>' target='_blank'>
        <?php echo esc_html( $item->get_title() ); ?></a> </strong> <br />
        <?php if(get_option('fxd_pwpa_rss_show_intro_pro') == 'yes'): 
            echo $item->get_content();
        endif; ?>
    </li>
    <?php endforeach; ?>
</ul>
<?php 
}
/*
 * Method :-- fxd_roles_dropdown
 * Task   :-- Add the roles dropdown
*/
function fxd_roles_dropdown($params = array()){
    $wp_roles = new WP_Roles();
    if(!empty($params['remove_role']))
            unset($wp_roles->role_names[$params['remove_role']]);
    return $wp_roles->role_names;
}
/*
 * Method :-- fxdUserComp
 * Task   :-- Add the roles dropdown
*/
function fxdUserComp($needsToBe,$current){
    if($needsToBe == '0' || $needsToBe == '')
        return;
    $roles = array('administrator' => 25 , 'editor' => 20, 'author' => 15, 'contributor' => 10, 'subscriber' => 5 );
    $needsToBe = $roles[$needsToBe];
    $current = $roles[$current];
    if($current >= $needsToBe ):
        return true;
    else:
        return false;
    endif;
}
/*
 * Method :-- fxd_get_current_user_role
 * Task   :-- Add the roles dropdown
*/
function fxd_get_current_user_role() {
    global $wp_roles;
    $current_user = wp_get_current_user();
    $roles = $current_user->roles;
    $role = array_shift($roles);
    return isset($wp_roles->role_names[$role]) ? $wp_roles->role_names[$role] : false;
}
/*
 * Method :-- fxd_pwpa_custom_dashboard_help
 * Task   :-- Hide the menu in Admin
*/
function fxd_pwpa_custom_dashboard_help(){
    echo stripslashes(get_option('fxd_pwpa_welcome_text'));
}
/*
 * Method :-- fxd_pwpa_custom_dashboard_help_new
 * Task   :-- Hide the menu in Admin
*/
function fxd_pwpa_custom_dashboard_help_new(){
    echo stripslashes(get_option('fxd_pwpa_welcome_text1'));
}
/*
 * Method :-- fxd_admin_bar
 * Task   :-- Hide the menu in Admin
*/
add_action('wp_before_admin_bar_render', 'fxd_admin_bar', 0);
function fxd_admin_bar(){
    // Show all to admin
    if (current_user_can('activate_plugins'))
        return;
    global $wp_admin_bar;
    if (get_option('fxd_pwpa_hide_posts'))
        $wp_admin_bar->remove_menu('new-post', 'new-content');
    if (get_option('fxd_pwpa_hide_comments'))
        $wp_admin_bar->remove_menu('comments');
    if (get_option('fxd_pwpa_hide_media'))
        $wp_admin_bar->remove_menu('media');
    $wp_admin_bar->remove_menu('appearance');
}
/*
 * Method :-- fxd_remove_admin_menus
 * Task   :-- Hide the menu in Admin
*/
add_action('admin_init', 'fxd_remove_admin_menus');
function fxd_remove_admin_menus () {
    global $menu, $submenu;
    $exclude[0] = '';
    if (get_option('fxd_pwpa_hide_posts'))
        array_push($exclude,__('Posts','default'));
    if (get_option('fxd_pwpa_hide_media'))
        array_push($exclude,__('Media','default'));
    if (get_option('fxd_pwpa_hide_comments'))
        array_push($exclude,__('Comments','default'));
    if (get_option('fxd_pwpa_hide_tools'))
        array_push($exclude,__('Tools','default'));
    if (get_option('fxd_pwpa_hide_profile'))
        array_push($exclude,__('Profile','default'));
    unset($exclude[0]);
    if (sizeof($exclude) > 0):
        if (!current_user_can('activate_plugins')):
            if( isset($menu) && is_array($menu) ):
                foreach($menu as $mId=>$menuArray):
                    $tmp = explode(' ',$menuArray[0]);
                    if(in_array( $tmp[0] , $exclude )):
                            unset($menu[$mId]);
                    endif;
                endforeach;
            endif;
        endif;
   endif;
   if(isset($submenu['themes.php'])):
        if (!current_user_can('activate_plugins')):
            foreach( $submenu['themes.php'] as $k=>$v):
                if(get_option('fxd_pwpa_subtemplate_hide_'.$k) ):
                        unset($submenu['themes.php'][$k]);
                endif;
            endforeach;
        endif;
    endif;
}
/*
 * Method :-- fxd_custom_login_logo
 * Task   :-- Change the login logo
*/
add_action('login_head', 'fxd_custom_login_logo');
function fxd_custom_login_logo(){
	wp_print_scripts( array( 'jquery' ) );
    $custom_logo = get_option('fxd_pwpa_change_admin_login_logo');
    if(!preg_match("@^https?://@", $custom_logo))
            $custom_logo = get_bloginfo('stylesheet_directory').'/images/'.$custom_logo;
    echo '<style type="text/css">';
    if (get_option('fxd_pwpa_change_admin_login_logo')):
        echo ' .login h1 a { display:all; background: url('.$custom_logo . ') no-repeat bottom center !important; margin-bottom: 10px; background-size: auto; } ';
		echo '.login h1 a { width :auto!important;} ';
        echo '</style> ';
        echo '<script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery(\'#login h1 a\').attr(\'title\',\'' . get_bloginfo('name') . '\');
                    jQuery(\'#login h1 a\').attr(\'href\',\'' . get_bloginfo('url') . '\');
               });
        </script>';
    else:
        echo '</style> ';
    endif;
}
/*
 * Method :-- fxd_google_analytic_dashboard
 * Task   :-- Include Google Analytic page to dashboard
 * Note :--   Function that outputs the contents of the dashboard widget
*/
function fxd_google_analytic_dashboard() {
  include(PLUGINPATH.'pages/dashboard.php');	
}
/*
 * Method :-- fxd_add_ga_widgets
 * Task   :-- Include Google Analytic Widget
 * Note :-- Function used in the action hook
*/
function fxd_add_ga_widgets() {
		$img = ( get_option('fxd_pwpa_rss_logo') ? get_option('fxd_pwpa_rss_logo') : '' );
        if($img){
            $img = '<img src="'.$img.'" height="16" width="16" alt="Logo" style="padding-right:5px;vertical-align:bottom;"/>';
		}
	$googleanalytic_title = "Google Analytics Summary";
	wp_add_dashboard_widget('dashboard_widget', $img.' '.$googleanalytic_title, 'fxd_google_analytic_dashboard');
}
// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'fxd_add_ga_widgets' );
/*
 * Method :-- fxd_remove_dashboard_meta
 * Task   :-- Remove Dashboard Widget
*/
function fxd_remove_dashboard_meta() {
	global $wp_meta_boxes;
	if (get_option('fxd_pwpa_wp_news')){
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	}
	if (get_option('fxd_pwpa_hide_quickdraft')){
	   unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	}
	if (get_option('fxd_pwpa_meta_box_gan')){
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	}
	if (get_option('fxd_pwpa_recent_activity')){
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	}
	if(get_option('fxd_pwpa_welcome_panel')){
		remove_action('welcome_panel', 'wp_welcome_panel');
	}
}
add_action( 'admin_init', 'fxd_remove_dashboard_meta' );
add_action('wp_dashboard_setup', 'fxd_remove_dashboard_meta', 999);
/*
 * Method :-- fxd_remove_metaboxes
 * Task   :-- Add the widget for RSS Feed In the admin
*/
function fxd_remove_metaboxes() {
	if(get_option('fxd_pwpa_remove_custom_field')){
		remove_meta_box( 'postcustom' , 'page' , 'normal' ); //removes custom fields for page
	}
	if(get_option('fxd_pwpa_remove_comment_status')){
		remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' ); //removes comments status for page
	}
	if(get_option('fxd_pwpa_remove_remove_comment_pages')){
		remove_meta_box( 'commentsdiv' , 'page' , 'normal' ); //removes comments for page
	}
	if(get_option('fxd_pwpa_remove_author_pages')){
		remove_meta_box( 'authordiv' , 'page' , 'normal' ); //removes author for page
	}
}
add_action( 'admin_menu' , 'fxd_remove_metaboxes' );
/*
 * Method :-- fxd_remove_topmenu
 * Task   :-- Remove the Top New Menu from top Dashboard
*/
function fxd_remove_topmenu() {
	 global $wp_admin_bar;
	 global $menu;
	 global $wpdb;
	 global $current_user;
	 $user_roles = $current_user->roles;
	 $user_role = array_shift($user_roles);
	 if($user_role == 'super_admin'){
	if(get_option('fxd_pwpa-new-content')){
				$wp_admin_bar->remove_node('new-content'); //removes custom fields for page
		}
	}
}
add_action( 'admin_bar_menu' , 'fxd_remove_topmenu', 999 );
add_action( 'admin_init' , 'fxd_remove_topmenu' );
/*
 * Method :-- remove_menus
 * Task   :-- Remove the custom menu for web admin
 */
function remove_menus(){
    global $menu;
	global $wpdb; 
	global $current_user;
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);
    if($user_role == 'super_admin'){
	$table_name = $wpdb->prefix . "custom_menu_hide";
	$results = $wpdb->get_results("SELECT * FROM $table_name ",OBJECT);
	
	foreach($results as $result){
	if($result->value == '1' ){
//echo $result->name.'=>'.$result->value ; // Line to check which value is passing in the restricted array

 foreach($menu as $key => $value){
	 	//$myvalue = 'Test me more';
		$arr = explode(' ',trim($menu[$key][0]));
		$arr[0];
		
		
	 if($arr[0] == $result->name ){
		 	unset($menu[$key]);
	 }
 }
}
}
// end while

}

}
add_action('admin_head', 'remove_menus');
//Code for the licence and update the plugin //
// ******************************************************************************************************//
