<?php
/*
	Page Name :-- Branding Form
	Task :-- Design to make the form for branding 
	Author :-- Bhaskar Dhote
	Company :-- FX Digital
*/
 if(get_option('fxd_footer_logo')){
	add_filter('admin_footer_text', 'fxd_pwpa_footer_logo');
 }
 if(get_option('fxd_pwpa_hide_wp_version') == 1){
	 add_filter('update_footer','remove_footer_version',99999);
	 add_action('admin_head','');
 }
?>