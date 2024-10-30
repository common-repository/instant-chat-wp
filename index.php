<?php
/*
Plugin Name: Instant Chat WP
Description: This plugin helps you to build & maintain your customer relationshipsby by adding a floating chat on your website.
Tested up to: 6.1
Version: 1.0.5
Author: Istmo Plugins
Domain Path: /languages
Text Domain: instant-chat-wp
*/
define('instantchatwp_url',plugin_dir_url(__FILE__ ));
define('instantchatwp_path',plugin_dir_path(__FILE__ ));
define('INSTANTCHATWP_SETTINGS_URL',"?page=instantchatwp&tab=pro");

$plugin = plugin_basename(__FILE__);
define('instantchatwp_pro_url','https://instantchatwp.com/');

function instantchatwp_load_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'instant-chat-wp' );	   
    $mofile = instantchatwp_path . "languages/instant-chat-wp-$locale.mo";		
	load_textdomain( 'instant-chat-wp', $mofile );
	load_plugin_textdomain( 'instant-chat-wp', false, dirname(plugin_basename(__FILE__)).'/languages/' );
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'instantchatwp_settings_link' );
add_action('init', 'instantchatwp_load_textdomain');			
add_action('init', 'instantchatwp_output_buffer');

function instantchatwp_output_buffer() {
	ob_start();
}

function instantchatwp_settings_link( array $links ) {	
	$url = "https://instantchatwp.com/#pricing";
	$settings_link = '<a href="' . $url . '" target="_blank" class="instantchatwp-plugins-gopro">' . __('Go Pro', 'instant-chat-wp') . '</a>';
	$links[] = $settings_link;
	return $links;
}
require_once (instantchatwp_path . 'classes/instantchatwp.php');
register_activation_hook( __FILE__, 'instantchatwp_activation'); 
function  instantchatwp_activation( $network_wide ) {
	$plugin_path = '';
	$plugin = "instant-chat-wp/index.php";	
	if ( is_multisite() && $network_wide ){ 
		activate_plugin($plugin_path,NULL,true);			
	}else{ 	
		activate_plugin($plugin_path,NULL,false);	
	}
}

$instantchatwp = new InstantChatWP();
$instantchatwp->plugin_init();
register_activation_hook(__FILE__, 'instantchatwp_my_plugin_activate');
add_action('admin_init', 'instantchatwp_my_plugin_redirect');

function instantchatwp_my_plugin_activate(){
    add_option('instantchatwp_plugin_do_activation_redirect', true);
}
function instantchatwp_my_plugin_redirect() {
    if (get_option('instantchatwp_plugin_do_activation_redirect', false)) {
        delete_option('instantchatwp_plugin_do_activation_redirect');
        wp_redirect(INSTANTCHATWP_SETTINGS_URL);
    }
}