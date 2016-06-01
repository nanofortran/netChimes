<?php
/**
 * Plugin Name: 	Javascript Html and Text Adder
 * Description: 	A widget plugin for adding Javascripts, HTML, Shortcodes, advertisements and even simple texts in the sidebar with advanced targeting on posts and pages.
 * Author: 			Intelligent Technology
 * Version: 		1.0.0
 * Author URI:		intelligenttechnology123@gmail.com
 * Text Domain:     hja
 * License: GPLv2
 */

/**
 * Basic plugin definitions 
 * 
 * @package Javascript Html and Text Adder
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if( !defined( 'HJA_VERSION' ) ) {
	define( 'HJA_VERSION', '1.0.0' );	
}
if( !defined( 'HJA_AUTHOR' ) ) {
	define( 'HJA_AUTHOR', 'Intelligent Technology' );	
}
if( !defined( 'HJA_DIR' ) ) {
	define( 'HJA_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'HJA_TEXT_DOMAIN' )) {
	define( 'HJA_TEXT_DOMAIN', 'hja' ); // text domain for languages
}
if( !defined( 'HJA_ADMIN' ) ) {
	define( 'HJA_ADMIN', HJA_DIR . '/includes/admin' ); // plugin admin dir
}
if( !defined( 'HJA_PLUGIN_URL' ) ) {
	define( 'HJA_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'HJA_IMG_URL' ) ) {
	define( 'HJA_IMG_URL', HJA_PLUGIN_URL . 'includes/images' ); // plugin images url
}
if( !defined( 'wpdwslevel' ) ) {
	define( 'wpdwslevel', 'manage_options' ); // this is capability in plugin
}

/**
 * Load Text Domain
 * 
 * This gets the plugin ready for translation.
 * 
 * @package Javascript Html and Text Adder
 * @since 1.0.0
 */
load_plugin_textdomain( 'hja', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Initialize all global variables
 * 
 * @package Javascript Html and Text Adder
 * @since 1.0.0
 */
global $hja_admin;

/**
 * Includes all required files for plugins
 * 
 * @package Javascript Html and Text Adder
 * @since 1.0.0
 */

require_once ( HJA_ADMIN . '/class-hja-admin.php');
$hja_admin = new Hja_Admin_Pages();
$hja_admin->add_hooks();

//includes widget file
require_once ( HJA_DIR . '/includes/widgets/class-hja-widget.php');

?>