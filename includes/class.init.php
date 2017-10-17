<?php
/**
 *
 * @author      VibeThemes
 * @category    Admin
 * @package     Vibe BuddyPres WooCommerce Sync
 * @version     1.0
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

class Vibe_BP_Woo_Init{

    public static $instance;
    public static function init(){
    if ( is_null( self::$instance ) )
        self::$instance = new Vibe_BP_Woo_Init();

        return self::$instance;
    }

    private function __construct(){
    	add_action('admin_enqueue_scripts',array($this,'enqueue_admin_scripts'));
    }

    function enqueue_admin_scripts($hook){
		if ( 'settings_page_vibe-bp-woo-sync' != $hook ) {
        	return;
    	}
    	wp_enqueue_style( 'vibe_bp_woo_admin_style', plugin_dir_url( __FILE__ ) . '../assets/css/admin.css' );
    	wp_enqueue_script( 'vibe_bp_woo_admin_style', plugin_dir_url( __FILE__ ) . '../assets/js/admin.js',array('jquery'),'1.0',true);
	}
}


Vibe_BP_Woo_Init::init();