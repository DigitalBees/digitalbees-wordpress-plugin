<?php

/**
 *  Plugin Name: DigitalBees Wordpress Video
 *  Plugin URI: http://digitalbees.it
 *  Description: Manage DigitalBees videos into Wordpress blog
 *  Author: DigitalBees s.r.l
 *  Author URI: http://www.digitalbees.it
 *  version: 0.0.1
 */

require_once __DIR__."/src/DigitalBeesWPVideo/Embed.php";

if ( !function_exists( 'add_action' ) )
    wp_die( 'You are trying to access this file in a manner not allowed.', 'Direct Access Forbidden', array( 'response' => '403' ) );

if ( ! defined( 'POSTSPAGE_DIR' ) )
    define( 'POSTSPAGE_DIR', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'POSTPAGE_URL' ) )
    define( 'DigitalBeesWpVideo_URL', plugin_dir_url( __FILE__ ) );

register_activation_hook(__FILE__, 'init_digitalbees_options');

define(DIGITALBEES_API_KEY, 'digitalbees_apikey');
define(DIGITALBEES_API_SECRET, 'digitalbees_apisecret');
define(DIGITALBEES_PLAYER_WIDTH, 'digitalbees_video_width');
define(DIGITALBEES_PLAYER_HEIGHT, 'digitalbees_video_height');

/**
 * Start options for this plugin
 */
function init_digitalbees_options()
{
	add_option(DIGITALBEES_API_KEY, DIGITALBEES_API_KEY, "", "yes");
	add_option(DIGITALBEES_API_SECRET, DIGITALBEES_API_SECRET, "", "yes");
	add_option(DIGITALBEES_PLAYER_WIDTH, "600", "", "yes");
	add_option(DIGITALBEES_PLAYER_HEIGHT, "400", "", "yes");
}

/**
 * Authentication
 */
function authentication(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
}

/**
 * Instantiate the Plugin - called using the plugins_loaded action hook.
 */
function init_digitalbees_in_page( ) 
{
    $init = new \DigitalBeesWPVideo\Embed();
    $init->addShortLink();
}

/**
 * call plugin functions
 */
function init_digitalbees_jsSDJ( ) 
{
    $init = new \DigitalBeesWPVideo\Embed();
    $init->init();
}


/**
 * Add menu into Dashboard
 */
function digitalbees_video_menu() 
{
	add_menu_page( 'Digitalbees Video - Plugin', 'DigitalbeesVideo', 'manage_options', 'my-unique-identifier', 'digitalbees_options' );
}

function digitalbees_options() {
	authentication();
	include realpath(dirname(__FILE__)) . "/options/config.php";
}

add_action('admin_menu', 'digitalbees_video_menu');
add_action('wp_enqueue_scripts', 'init_digitalbees_jsSDJ');
add_action('plugins_loaded', 'init_digitalbees_in_page');


