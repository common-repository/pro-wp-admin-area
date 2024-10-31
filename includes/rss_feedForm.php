<?php
/*
	Page Name :-- RSS Pro Form Field
	Task :-- Design to make the form for rss feed 
	Author :-- Bhaskar Dhote
	Company :-- FX Digital
*/
global $wp_version , $submenu ;
$fxd_label = "fxd_pwpa";
	$fxdOptionsRssPro[] = array(
		"id" => $fxd_label."_show_rss_widget_pro",
		"name" => "Add an RSS Dashboard Panel",
        "std" => "1" );
	$fxdOptionsRssPro[] = array(
		"id" => $fxd_label.'_rss_title_pro' ,
		"name" => 'RSS Title',
		"description" => 'The title of your RSS dashboard panel',
		"type" => "text",
		"std"   => "" );
	$fxdOptionsRssPro[] = array(
		"id" => $fxd_label."_rss_logo_pro",
		"name" => 'Add Your Company Logo (16px x 16px)',
		"description" => 'Adds a 16px logo before the title',
		"type" => 'file',
		"class" => 'upload_image btn btn-info btn-sm',
		"std"   => ""  );
	$fxdOptionsRssPro[] = array(
		"id" => $fxd_label."_rss_value_pro",	
		"name" => 'RSS Feed',
		"description" => 'Enter your RSS Feed Address',
		"type" => 'text',
		"std" => "" );
	$fxdOptionsRssPro[] = array(
		"id" => $fxd_label."_rss_num_items_pro",
		"name" => 'Number Items',
		"description" => 'Number of RSS items to show',
		"type" => 'selectbox',
		"options"=> array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10),
		"std" => '2' );
	$fxdOptionsRssPro[] = array(
		"id" => $fxd_label."_rss_show_intro_pro",
		"name" => "Show Post Contents",
        "desc" => "Show the content of the RSS item. This will display what is in your RSS feed, if this is not what you want, please modify your RSS feed.",
        "type" => "selectbox",
        "options"=> array('yes'=>'Yes','no'=>'No'),
        "std" => 'yes');
	$fxdOptionsRssPro[] = array (
		 "id"    => $fxd_label."_rss_intro_html_pro",
		 "name"  => "RSS Intro",
         "desc"  => "If you would like to have some text above the RSS items explaining it. Please add the text in html format here.",
         "type"  => "textarea",
         "std"   => '');	
$fxdOptionsRssPro = array_merge( $fxdOptionsRssPro);		 	
?>