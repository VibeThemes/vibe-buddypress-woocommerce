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
        add_action('xprofile_updated_profile',array($this,'bp_xprofile_sync_with_woo_account'),999);
        add_action('bp_core_signup_user',array($this,'bp_xprofile_sync_with_woo_account'),999);
        add_action('bp_core_activated_user',array($this,'bp_xprofile_sync_with_woo_account'),999);

        //Sync Woocommerce account with buddypress profile when woo account is updated
        add_action('personal_options_update',array($this,'woo_account_sync_with_bp_xprofile'),999);
        add_action('edit_user_profile_update',array($this,'woo_account_sync_with_bp_xprofile'),999);
        add_action('woocommerce_checkout_update_user_meta',array($this,'woo_account_sync_with_bp_xprofile'),999);
    }

    function enqueue_admin_scripts($hook){
		if ( 'settings_page_vibe-bp-woo-sync' != $hook ) {
        	return;
    	}
    	wp_enqueue_style( 'vibe_bp_woo_admin_style', plugin_dir_url( __FILE__ ) . '../assets/css/admin.css' );
    	wp_enqueue_script( 'vibe_bp_woo_admin_style', plugin_dir_url( __FILE__ ) . '../assets/js/admin.js',array('jquery'),'1.0',true);
	}

    function bp_xprofile_sync_with_woo_account( $user_id ){
        if( empty($user_id) ){
            $user_id = get_current_user_id();
        }
        if( empty($user_id) ){
            return;
        }

        //Update User Meta for Woo Account.
        $woo_bp_sync_settings = get_option('vibe_bp_woo_sync_settings');

        if( !empty($woo_bp_sync_settings['bp_woo_fields_map']['woofield']) && function_exists('bp_get_profile_field_data') ){
            foreach ($woo_bp_sync_settings['bp_woo_fields_map']['woofield'] as $key => $value) {

                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $data = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, $value, $data );

            }
        }

    }

    function woo_account_sync_with_bp_xprofile( $user_id ){
        if( empty($user_id) ){
            $user_id = get_current_user_id();
        }
        if( empty($user_id) ){
            return;
        }

        //Update User Meta for BP Profile.
        $woo_bp_sync_settings = get_option('vibe_bp_woo_sync_settings');

        if( !empty($woo_bp_sync_settings['bp_woo_fields_map']['woofield']) && function_exists('xprofile_set_field_data') ){
            foreach ($woo_bp_sync_settings['bp_woo_fields_map']['woofield'] as $key => $value) {

                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $data = get_user_meta( $user_id, $value, true );
                if(strlen($data) === 2){
                    if(!empty(WC()->countries->countries[$data])){
                        $this->country_code = $data;
                        $data = WC()->countries->countries[$data];
                    }

                    if(!empty(WC()->countries->states[$this->country_code][$data])){
                        $data = WC()->countries->states[ $this->country_code ][ $data ];
                    }
                }
                xprofile_set_field_data( $field_id, $user_id, $data );

            }
        }
    }
}

Vibe_BP_Woo_Init::init();
