<?php
/*
 Plugin Name: User (meru) Instagram
 Version: 0.1
 Description: User instagram elements
 Author: Pierre Lange and Florian Mopin
 Author URI: http://www.webschoolfactory.fr/
 Domain Path: languages
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'USER_INSTA_VER', '0.1' );

// Plugin URL and PATH
define( 'USER_INSTA_URL', plugin_dir_url( __FILE__ ) );
define( 'USER_INSTA_DIR', plugin_dir_path( __FILE__ ) );

// Function for easy load files
function _user_insta_load_files( $dir, $files, $prefix = '' ) {
	foreach ( $files as $file ) {
		if ( is_file( $dir . $prefix . $file . ".php" ) ) {
			require_once( $dir . $prefix . $file . ".php" );
		}
	}
}

// Plugin libraries
_user_insta_load_files( USER_INSTA_DIR . 'inc/libs/', array(
		'hm-rewrites'
	)
);

// Plugin client classes
_user_insta_load_files( USER_INSTA_DIR . 'inc/', array(
	'publication',
	'edit',
	'routes',
	'image',
	'functions.tpl'
) );


add_action( 'plugins_loaded', 'init_bea_pb_plugin' );
function init_bea_pb_plugin() {

}