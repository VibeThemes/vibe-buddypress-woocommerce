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
        //Add scripts
    	add_action('admin_enqueue_scripts',array($this,'enqueue_admin_scripts'));
        //Sync buddypress profile with woocommerce account when bp profile is updated
        add_action('xprofile_updated_profile',array($this,'bp_xprofile_sync_with_woo_account'));
        add_action('bp_core_signup_user',array($this,'bp_xprofile_sync_with_woo_account'));
        add_action('bp_core_activated_user',array($this,'bp_xprofile_sync_with_woo_account'));
    }

    function enqueue_admin_scripts($hook){
		if ( 'settings_page_vibe-bp-woo-sync' != $hook ) {
        	return;
    	}
    	wp_enqueue_style( 'vibe_bp_woo_admin_style', plugin_dir_url( __FILE__ ) . '../assets/css/admin.css' );
    	wp_enqueue_script( 'vibe_bp_woo_admin_style', plugin_dir_url( __FILE__ ) . '../assets/js/admin.js',array('jquery'),'1.0',true);
	}

    function bp_xprofile_sync_with_woo_account( $user_id = 0 ){
        if( empty($user_id) ){
            $user_id = get_current_user_id();
        }
        if( empty($user_id) ){
            return;
        }
    }
}


Vibe_BP_Woo_Init::init();