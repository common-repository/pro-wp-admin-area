<?php
/*
	Page Name :-- RSS Form Field
	Task :-- Design to make the form for rss feed 
	Author :-- Bhaskar Dhote
	Company :-- FX Digital
*/
global $wp_version , $submenu ;
$fxd_label = "fxd_pwpa";
	$fxdOptionsRss[] = array(
		"id" => $fxd_label."_show_rss_widget",
		"name" => "Add an RSS Dashboard Panel",
        "std" => "1" );
	$fxdOptionsRss[] = array(
		"id" => $fxd_label.'rss_title' ,
		"name" => 'RSS Title',
		"description" => 'The title of your RSS dashboard panel',
		"id" => $fxd_label."_rss_title",
		"type" => "text",
		"std"   => "FX Digital News" );
	$fxdOptionsRss[] = array(
		"id" => $fxd_label."_rss_logo",
		"name" => 'Add Your Company Logo (16px x 16px)',
		"description" => 'Adds a 16px logo before the title',
		"type" => 'file',
		"class" => 'upload_image btn btn-info btn-sm',
		"std"   => ""  );
	$fxdOptionsRss[] = array(
    	"id" => $fxd_label."_rss_value",	
		"name" => 'RSS Feed',
		"description" => 'Enter your RSS Feed Address',
		"type" => 'text',
		"std" => "http://website-designs.com/feed/atom/" );
	$fxdOptionsRss[] = array(
		"id" => $fxd_label."_rss_num_items",
		"name" => 'Number Items',
		"description" => 'Number of RSS items to show',
		"type" => 'selectbox',
		"options"=> array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10),
		"std" => '4' );
	$fxdOptionsRss[] = array(
		"id" => $fxd_label."_rss_show_intro",
		"name" => "Show Post Contents",
        "desc" => "Show the content of the RSS item. This will display what is in your RSS feed, if this is not what you want, please modify your RSS feed.",
        "type" => "selectbox",
        "options"=> array('yes'=>'Yes','no'=>'No'),
        "std" => 'yes');
	$fxdOptionsRss[] = array (
		 "id"    => $fxd_label."_rss_intro_html",
		 "name"  => "RSS Intro",
         "desc"  => "If you would like to have some text above the RSS items explaining it. Please add the text in html format here.",
         "type"  => "textarea",
         "std"   => '');	
$fxdOptionsRss = array_merge( $fxdOptionsRss);		 	
?>