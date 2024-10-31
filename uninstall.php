<?php
if( WP_UNINSTALL_PLUGIN ){
    global $wpdb;
    $delete_query = "DELETE FROM $wpdb->options WHERE option_name LIKE 'fxd_pwpa_%' ";
    $wpdb->query($delete_query);
    $role = get_role( 'editor' );
    $role->remove_cap( 'switch_themes' ); // Legacy
    $role->remove_cap( 'edit_themes' ); // Legacy
    $role->remove_cap( 'edit_theme_options' );
	$role = get_role( 'super_admin');
	$caps = array('activate_plugins','delete_plugins','create_users','delete_users','edit_plugins','edit_theme_options','edit_themes','edit_users','manage_options','switch_themes','update_core');
//	$role->remove_cap($cap);
	remove_role( 'super_admin' );
}
?>