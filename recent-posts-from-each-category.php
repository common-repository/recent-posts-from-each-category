<?php
/*
Plugin Name: Recent Posts From Each Category
Plugin URI: http://www.mindstien.com
Description: Display Recent Posts From Each Category on homepage or any other wordpress post / page using shortcode. You can include thumbnails (automatically generated), configure title length, excerpt length and much more...
Version: 1.4
Author: Chirag Gadara
Author URI: http://www.mindstien.com
License: GPL2
*/

// Include Sunrise Plugin Framework class
require_once 'classes/sunrise.class.php';

// Create plugin instance
$rpfc = new Rpfec_Sunrise_Plugin_Framework;

$rpfc->add_settings_page( array(
	'parent' => 'options-general.php',
	'page_title' => $rpfc->name,
	'menu_title' => $rpfc->name,
	'capability' => 'manage_options',
	'settings_link' => true
) );

// Include plugin actions
require_once 'inc/core.php';

// Make plugin meta translatable
__( 'Author Name', $rpfc->textdomain );
__( 'Vladimir Anokhin', $rpfc->textdomain );
__( 'Plugin description', $rpfc->textdomain );
?>