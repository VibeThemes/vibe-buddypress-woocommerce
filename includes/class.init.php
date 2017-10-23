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

        //Sync Woocommerce account with buddypress profile when woo account is updated
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

        // Get the customer
        $customer = WC_API_Customers::update_customer_data( $user_id );

        //Set data
        $first_name = '';
        $last_name = '';
        $billing_address = array();
        $shipping_address = array();
        $woo_bp_sync_settings = get_option('vibe_bp_woo_sync_settings');

        foreach ($woo_bp_sync_settings['bp_woo_fields_map']['woofield'] as $key => $value) {
            if( $value == 'first_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $first_name = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'last_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $last_name = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_first_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['first_name'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_last_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['last_name'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_email' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['email'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_company' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['company'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_phone' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['phone'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_address_1' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['address_1'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_address_2' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['address_2'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_city' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['city'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_postcode' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['postcode'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_state' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['state'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'billing_country' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $billing_address['country'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_first_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['first_name'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_last_name' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['last_name'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_company' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['company'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_address_1' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['address_1'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_address_2' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['address_2'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_city' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['city'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_postcode' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['postcode'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_state' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['state'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            if( $value == 'shipping_country' ){
                $field_id = $woo_bp_sync_settings['bp_woo_fields_map']['bpfield'][$key];
                $shipping_address['country'] = bp_get_profile_field_data( array( 'field' => $field_id, 'user_id' => $user_id ) );
            }
            
        }

        $data['first_name'] = $first_name;
        $data['last_name'] = $last_name;
        $data['billing_address'] = $billing_address;
        $data['shipping_address'] = $shipping_address;

        //Update woocommerce customer data
        WC_API_Customers::update_customer_data( $user_id, $data, $customer );
    }
}

Vibe_BP_Woo_Init::init();
