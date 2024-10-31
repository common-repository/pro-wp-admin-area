<?php
/*
 * Method :-- fxd_get_bro_image
 * Task   :-- Function to get the browser image for google analytic
 * Note   :-- Created separate file becasue i dont need to find in the main code for browser              updates ;)
*/ 
function fxd_get_bro_image($browser_name){
    $browser_images = array(
        "Chrome" => "chrome.png",
        "Firefox" => "firefox.png",
        "Safari" => "safari.png",
        "Internet Explorer" => "ie.png",
    );
    if($browser_images[$browser_name]){
        return $browser_images[$browser_name];
    }
    else{
        return 'web.png';
    }
}
?>