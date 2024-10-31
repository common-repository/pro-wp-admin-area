<?php
add_action('admin_head', 'fxd_custom_style');
function fxd_custom_style(){
$fxd_style = '';
	if(get_option('fxd_pwpa_custom_css')!=""){
		$fxd_style .= wp_specialchars_decode( stripslashes( get_option('fxd_pwpa_custom_css') ), 1, 0, 1 );
	}
	if (get_option('fxd_pwpa_dashboard_remove_help_box') == 1) {
		$fxd_style .= '#contextual-help-link-wrap { display: none; }';
		$fxd_style .= '#contextual-help-link { display: none; }';
	}
	if (get_option('fxd_pwpa_post_meta_box_slug')){
		$fxd_style .=  '#slugdiv, #edit-slug-box { display: none; } ';
	}
	if (get_option('fxd_pwpa_dashboard_remove_screen_options') == 1) {
		$fxd_style .=  '#screen-options-link-wrap { display: none; }';
	}
	if (!current_user_can('activate_plugins')){
		if (get_option('fxd_pwpa_hide_admin_bar_option') == 1){ 
			$fxd_style .= '.show-admin-bar { display: none; }';
		}
		if (get_option('fxd_pwpa_inherit_hide_menus') == 1){ 
			if (get_option('fxd_pwpa_hide_posts')){
				$fxd_style .= '#wp-admin-bar-new-post { display: none; }';
			}
			if (get_option('fxd_pwpa_hide_pages')){ 
				$fxd_style .= '#wp-admin-bar-new-page { display: none; }';
			}
			if (get_option('fxd_pwpa_hide_media')) {
				$fxd_style .= '#wp-admin-bar-new-media { display: none; }';
			}
			if (get_option('fxd_pwpa_hide_links')) {
				$fxd_style .= '#wp-admin-bar-new-link { display: none; }';
			}
			if (get_option('fxd_pwpa_hide_comments')) {
				$fxd_style .= '#wp-admin-bar-comments { display: none; }';
			}
			if (!get_option('fxd_pwpa_show_widgets')) {
				$fxd_style .= '#wp-admin-bar-widgets { display: none; }';
			}
			if (!get_option('fxd_pwpa_show_appearance')) {
				$fxd_style .='#wp-admin-bar-menus { display: none; }';
			}
			if (!get_option('fxd_pwpa_show_background')) {
				$fxd_style .= '#wp-admin-bar-background { display: none; }';
			}
			if (!get_option('fxd_pwpa_show_header')) {
				$fxd_style .= '#wp-admin-bar-header { display: none; }';
			}
		}
	}
    echo '<style type="text/css">'.$fxd_style.'</style>';
}   
?>