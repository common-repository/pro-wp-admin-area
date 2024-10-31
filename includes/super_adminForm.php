<?php
global $wp_version , $submenu ;
$fxd_label = "fxd_pwpa-";
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."activate_plugins",
		  "name" => "Activate Plugin",
          "description" => "Set Permission for activate the plugin",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."update_plugins",
		  "name" => "Update Plugin",
          "description" => "Set Permission to updae the plugin",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_plugins",
		  "name" => "Edit Plugin",
          "description" => "Set Permission for edit the plugin",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);		  		  
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."delete_plugins",
		  "name" => "Delete Plugin",
          "description" => "Set Permission for delete the plugin",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."create_users",
		  "name" => "Create User",
          "description" => "Set Permission to create a new user",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_users",
		  "name" => "Edit User",
          "description" => "Set Permission to edit the user",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);		  
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."delete_users",
		  "name" => "Delete User",
          "description" => "Set Permission to delete the user",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_theme_options",
		  "name" => "Edit Theme Option",
          "description" => "Set Permission to edit the theme",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_themes",
		  "name" => "Edit Theme",
          "description" => "Set Permission to edit the theme ",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."manage_options",
		  "name" => "Manage Options",
          "description" => "Set Permission to manage the option",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 0);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."switch_themes",
		  "name" => "Switch Theme",
          "description" => "Set Permission for User to Switch the theme",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."delete_themes",
		  "name" => "Delete Theme  ",
          "description" => "Set Permission to delete the Theme",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);		  		  
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."update_core",
		  "name" => "Update Core",
		  "type" => "radio",
          "description" => "Set Permission Update the core file",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_pages",
		  "name" => "Edit Pages",
          "description" => "Set Permission to Edit the pages",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_others_pages",
		  "name" => "Edit Other Pages ",
          "description" => "Set Permission for activate the plugin",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."manage_links",
		  "name" => "Manage Link ",
          "description" => "Set Permission to manage the link",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);

$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."delete_pages",
		  "name" => "Delete Pages ",
          "description" => "Set Permission to Delete the Pages",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_published_pages",
		  "name" => "Publish Pages ",
          "description" => "Set Permission to Delete the Pages",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);		  
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."upload_files",
		  "name" => "Uploads Files ",
          "description" => "Set Permission to Upload the Files",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."new-content",
		  "name" => "Top New Menu ",
          "description" => "Set Permission to Upload the Files",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_posts",
		  "name" => "Edit Posts  ",
          "description" => "Set Permission to Edit the Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_others_posts",
		  "name" => "Edit Other Posts  ",
          "description" => "Set Permission to Edit Other the Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."read_private_posts",
		  "name" => "Read Posts  ",
          "description" => "Set Permission to Read the Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."edit_published_posts",
		  "name" => "Edit Public Posts  ",
          "description" => "Set Permission to Edit Public the Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."publish_posts",
		  "name" => "Public Posts  ",
          "description" => "Set Permission to Public the Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."delete_posts",
		  "name" => "Delete Posts  ",
          "description" => "Set Permission to Delete the Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."delete_others_posts",
		  "name" => "Delete Other Posts  ",
          "description" => "Set Permission to Delete Other Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."delete_published_posts",
		  "name" => "Delete Published Posts  ",
          "description" => "Set Permission to Delete Published Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);
$fxdSuperAdminPermission[] = array(
		  "id" => $fxd_label."delete_private_posts",
		  "name" => "Delete Private Posts  ",
          "description" => "Set Permission to Delete Private Post",
		  "type" => "radio",
          "option_value" => array("1","0"),
		  "option_text" => array("YES" , "NO"),
		  "std" => 1);			  		  			  			  		  		  		  			  		  		  		$fxdSuperAdminPermission = array_merge($fxdSuperAdminPermission);		    		  		  		  		  		  			?>