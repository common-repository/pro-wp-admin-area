<?php
// Admin css insertion
add_action( 'admin_enqueue_scripts', 'fn_ga_admin_reference' );
function fn_ga_admin_reference(){
    wp_enqueue_style( 'ganalytics-admin-style', PLUGIN_URL.'/assets/css/ganalytics-admin.css', array(),FXD_PRO_WP_ADMIN_CONTROL);
    wp_enqueue_style( 'ganalytics-tooltip-style', PLUGIN_URL.'/assets/inc/tooltipster/tooltipster.css');
    wp_enqueue_style( 'ganalytics-tooltip-style-light', PLUGIN_URL.'/assets/inc/tooltipster/themes/tooltipster-light.css');
    wp_enqueue_script('google-visualization-chart', 'https://www.google.com/jsapi');
    wp_enqueue_script('ganalytics-tooltip-script', PLUGIN_URL.'/assets/inc/tooltipster/jquery.tooltipster.min.js', array('jquery'));
    wp_enqueue_script('ganalytics-admin-script', PLUGIN_URL.'/assets/js/ganalytics-admin.js', array('ganalytics-tooltip-script'));
}
?>