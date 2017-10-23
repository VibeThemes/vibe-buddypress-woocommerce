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

        foreach ($woo_bp_sync_settings['bp_woo_fields_map']['woofield'] as $key => $value) {
            if( $value == 'billing_first_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_first_name = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_first_name', $billing_first_name );
            }
            if( $value == 'billing_last_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_last_name = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_last_name', $billing_last_name );
            }
            if( $value == 'billing_email' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_email = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_email', $billing_email );
            }
            if( $value == 'billing_company' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_company = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_company', $billing_company );
            }
            if( $value == 'billing_phone' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_phone = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_phone', $billing_phone );
            }
            if( $value == 'billing_address_1' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address_1 = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_address_1', $billing_address_1 );
            }
            if( $value == 'billing_address_2' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address_2 = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_address_2', $billing_address_2 );
            }
            if( $value == 'billing_city' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_city = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_city', $billing_city );
            }
            if( $value == 'billing_postcode' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_postcode = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_postcode', $billing_postcode );
            }
            if( $value == 'billing_state' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_state = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_state', $billing_state );
            }
            if( $value == 'billing_country' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_country = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'billing_country', $billing_country );
            }
            if( $value == 'shipping_first_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_first_name = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_first_name', $shipping_first_name );
            }
            if( $value == 'shipping_last_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_last_name = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_last_name', $shipping_last_name );
            }
            if( $value == 'shipping_company' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_company = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_company', $shipping_company );
            }
            if( $value == 'shipping_address_1' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address_1 = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_address_1', $shipping_address_1 );
            }
            if( $value == 'shipping_address_2' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address_2 = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_address_2', $shipping_address_2 );
            }
            if( $value == 'shipping_city' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_city = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_city', $shipping_city );
            }
            if( $value == 'shipping_postcode' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_postcode = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_postcode', $shipping_postcode );
            }
            if( $value == 'shipping_state' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_state = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_state', $shipping_state );
            }
            if( $value == 'shipping_country' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_country = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
                update_user_meta( $user_id, 'shipping_country', $shipping_country );
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

        foreach ($woo_bp_sync_settings['bp_woo_fields_map']['woofield'] as $key => $value) {
            if( $value == 'billing_first_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_first_name = get_user_meta( $user_id, 'billing_first_name', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_first_name );
            }
            if( $value == 'billing_last_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_last_name = get_user_meta( $user_id, 'billing_last_name', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_last_name );
            }
            if( $value == 'billing_email' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_email = get_user_meta( $user_id, 'billing_email', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_email );
            }
            if( $value == 'billing_company' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_company = get_user_meta( $user_id, 'billing_company', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_company );
            }
            if( $value == 'billing_phone' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_phone = get_user_meta( $user_id, 'billing_phone', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_phone );
            }
            if( $value == 'billing_address_1' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address_1 = get_user_meta( $user_id, 'billing_address_1', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_address_1 );
            }
            if( $value == 'billing_address_2' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address_2 = get_user_meta( $user_id, 'billing_address_2', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_address_2 );
            }
            if( $value == 'billing_city' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_city = get_user_meta( $user_id, 'billing_city', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_city );
            }
            if( $value == 'billing_postcode' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_postcode = get_user_meta( $user_id, 'billing_postcode', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_postcode );
            }
            if( $value == 'billing_state' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_state = get_user_meta( $user_id, 'billing_state', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_state );
            }
            if( $value == 'billing_country' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_country = get_user_meta( $user_id, 'billing_country', true );
                xprofile_set_field_data( $field_id, $user_id, $billing_country );
            }
            if( $value == 'shipping_first_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_first_name = get_user_meta( $user_id, 'shipping_first_name', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_first_name );
            }
            if( $value == 'shipping_last_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_last_name = get_user_meta( $user_id, 'shipping_last_name', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_last_name );
            }
            if( $value == 'shipping_company' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_company = get_user_meta( $user_id, 'shipping_company', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_company );
            }
            if( $value == 'shipping_address_1' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address_1 = get_user_meta( $user_id, 'shipping_address_1', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_address_1 );
            }
            if( $value == 'shipping_address_2' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address_2 = get_user_meta( $user_id, 'shipping_address_2', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_address_2 );
            }
            if( $value == 'shipping_city' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_city = get_user_meta( $user_id, 'shipping_city', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_city );
            }
            if( $value == 'shipping_postcode' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_postcode = get_user_meta( $user_id, 'shipping_postcode', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_postcode );
            }
            if( $value == 'shipping_state' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_state = get_user_meta( $user_id, 'shipping_state', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_state );
            }
            if( $value == 'shipping_country' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_country = get_user_meta( $user_id, 'shipping_country', true );
                xprofile_set_field_data( $field_id, $user_id, $shipping_country );
            }
            
        }
    }
}

Vibe_BP_Woo_Init::init();
