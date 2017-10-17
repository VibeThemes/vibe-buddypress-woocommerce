<?php
/*
Plugin Name: Vibe BuddyPress WooCommerce
Plugin URI: http://www.VibeThemes.com
Description: Synchronise BuddyPress xProfile fields and WooCommerce checkout fields.
Version: 1.0
Requires at least: WP 3.8, BuddyPress 1.9 
Tested up to: 4.8
License: GPL v 2
Author: Mr.Vibe 
Author URI: http://www.VibeThemes.com
Text Domain: vbc
Domain Path: /languages/
*/


if ( !defined( 'ABSPATH' ) ) exit;

include_once('includes/class.init.php');
include_once('includes/class.settings.php');

add_action('plugins_loaded','vibe_buddypress_woocommerce_translations');
function vibe_buddypress_woocommerce_translations(){

    $locale = apply_filters("plugin_locale", get_locale(), 'vbc');
    $lang_dir = dirname( __FILE__ ) . '/languages/';
    $mofile        = sprintf( '%1$s-%2$s.mo', 'vbc', $locale );
    $mofile_local  = $lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

    if ( file_exists( $mofile_global ) ) {
        load_textdomain( 'vbc', $mofile_global );
    } else {
        load_textdomain( 'vbc', $mofile_local );
    }  
}