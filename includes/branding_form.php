<?php
/*
	Page Name :-- Branding Form
	Task :-- Design to make the form for branding 
	Author :-- Bhaskar Dhote
	Company :-- FX Digital
*/
global $wp_version , $submenu ;
$fxd_label = "fxd_pwpa_";
$fxdOptions = array (
	array("name" => "FX Digital WP PRO ADMIN","type" => 'title')
);
if(version_compare($wp_version ,'3.6.0', '>=')){
	$fxdOptions[] = array(
		"id" => $fxd_label.'hide_logo' ,
		"name" => 'Hide Wordpress Logo',
		"description" => 'Hide the wordpress logo',
		"option_value" => array("1","0"),
		"option_text" => array("YES" , "NO"),
		"type" => "radio",
		"std"   => 0 );
	$fxdOptions[] = array(
		"id" => $fxd_label.'hide_wp_version' ,
		"name" => 'Hide Wordpress Version',
		"description" => 'Hide the wordpress current version',
		"option_value" => array("1","0"),
		"option_text" => array("YES" , "NO"),
		"type" => "radio",
		"std"   => 0 );			
	$fxdOptions[] = array(
		"id" => $fxd_label.'add_new_logo' ,
		"name" => 'New WP Logo',
		"description" => 'Upload your own logo (Recommended size 16x16 in pixel) ',
		"type" => 'file',
		"class" => 'upload_image btn btn-info btn-sm',
		"std"   => "" );	
	$fxdOptions[] = array(
		"id" => $fxd_label.'add_new_dashboard_logo' ,
		"name" => 'New Logo Dashboard Logo',
		"description" => 'Upload your own logo to dashboard (Recommended size 300x80 in pixel)',
		"type" => 'file',
		"class" => 'upload_image btn btn-info btn-sm',
		"std"   => "" );
	$fxdOptions[] = array(
		"id" => $fxd_label.'add_new_footer_logo' ,
		"name" => 'New Logo Footer Logo',
		"description" => 'Upload your own logo to Footer (Recommended size 80x25 in pixel)',
		"type" => 'file',
		"class" => 'upload_image btn btn-info btn-sm',
		"std"   => "" );
	$fxdOptions[] = array(
		"id" => $fxd_label.'change_admin_login_logo' ,
		"name" => 'Change Login Logo',
		"description" => 'Upload your own logo to Wordpress Login Area (Recommended size 300x80 in pixel)',
		"type" => 'file',
		"class" => 'upload_image btn btn-info btn-sm',
		"std"   => "" );				
	$fxdOptions[] = array(
		"id" => $fxd_label.'change_deashobard_heading' ,
		"name" => 'Change the Dashboard Heading',
		"description" => 'You can chnage your dashboard heading form there',
		"type" => 'text',
		"title" => '',
		"std"   => __('Dashboard'));
     $fxdOptions[] = array(
		"id" => $fxd_label.'developer_name' ,
		"name" => 'Put your developer name here',
		"description" => 'You can add your developer name in the footer',
		"type" => 'text',
		"title" => '',
		"std"   => '');
	$fxdOptions[] = array(
		"id" => $fxd_label.'developer_website_url' ,
		"name" => 'Put your developer Website name  here',
		"description" => 'You can add your website name in the footer',
		"type" => 'text',
		"title" => '',
		"std"   => __(''));			
}else{
	echo "This plugin is not compatiable with your wordpress version Please Update your wordpress version Chick here" ;
		echo "<a href='http://wordpress.org/download/'>UPDATE NOW </a> " ;
}
$fxdOptions = array_merge( $fxdOptions);
?>