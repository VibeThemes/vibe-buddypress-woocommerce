<?php
/**
 *
 * @author      VibeThemes
 * @category    Admin
 * @package     Vibe BuddyPres WooCommerce Settings
 * @version     1.0
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

class Vibe_BP_Woo_Settings{

    public static $instance;
    public static function init(){
    if ( is_null( self::$instance ) )
        self::$instance = new Vibe_BP_Woo_Settings();

        return self::$instance;
    }

    public function __construct(){
    	add_action('admin_menu',array($this,'add_vibe_buddypress_woocommerce_option'));
    }

    function add_vibe_buddypress_woocommerce_option(){
    	add_options_page(__('Vibe Bp Woo Sync settings','vbc'),__('Vibe Bp Woo Sync','vbc'),'manage_options','vibe-bp-woo-sync',array($this,'add_settings'));
    }

    function add_settings(){
    	echo '<h3>'.__('Vibe Buddypress Woocommerce Settings','vbc').'</h3>';
		$settings = array(
				
				array(
					'label' => __('Map Fields','vbc'),
					'name' => 'bp_woo_fields_map',
					'type' => 'bp_woo_map',
					'desc' => __('Map WooCommerce and BuddyPress fields','vbc')
				),
			);
		$settings = apply_filters('vibe_bp_woo_sync_fields',$settings);
		if( isset($_POST['save_settings']) ){
			$this->save_form_fields();
		}
		$this->generate_form($settings);
    }

    function generate_form( $settings=array() ){

    	$woo_bp_sync_settings = get_option('vibe_bp_woo_sync_settings');
		echo '<form method="post">
				<table class="form-table">';
		wp_nonce_field('save_settings','_wpnonce');   
		echo '<ul class="save-settings">';

		foreach($settings as $setting ){
			echo '<tr valign="top">';
			switch($setting['type']){
				case 'bp_woo_map':
					echo '<th scope="row" class="titledesc">'.$setting['label'].'</th>';
					echo '<td class="forminp"><a class="add_new_map button">'.__('Add BuddyPress profile field map with WooCommerce profile fields','vbc').'</a>';

					global $wpdb,$bp;
					$table =  $bp->profile->table_name_fields;
					$bp_fields = $wpdb->get_results("SELECT DISTINCT name,id FROM {$table}");

					$woo_fields = array(
							'first_name' => __('First Name','vbc'),
							'last_name' => __('Last Name','vbc'),
							'email' => __('Email address','vbc'),
							'billing' => array( 
									'label' => __('Billing','vbc'),
									'billing_first_name' => __('First Name','vbc'),
									'billing_last_name' => __('Last Name','vbc'),
									'billing_email' => __('Email address','vbc'),
									'billing_company' => __('Company','vbc'),
									'billing_phone' => __('Phone','vbc'),
									'billing_address_1' => __('Address 1','vbc'),
									'billing_address_2' => __('Address 2','vbc'),
									'billing_city' => __('Town / City','vbc'),
									'billing_postcode' => __('Postcode / Zip','vbc'),
									'billing_state' => __('State / Country','vbc'),
									'billing_country' => __('Country','vbc'),
								),
							'shipping' => array(
									'label' => __('Shipping','vbc'),
									'shipping_first_name' => __('First Name','vbc'),
									'shipping_last_name' => __('Last Name','vbc'),
									'shipping_email' => __('Email address','vbc'),
									'shipping_company' => __('Company','vbc'),
									'shipping_phone' => __('Phone','vbc'),
									'shipping_address_1' => __('Address 1','vbc'),
									'shipping_address_2' => __('Address 2','vbc'),
									'shipping_city' => __('Town / City','vbc'),
									'shipping_postcode' => __('Postcode / Zip','vbc'),
									'shipping_state' => __('State / Country','vbc'),
									'shipping_country' => __('Country','vbc'),
								),
						);

					echo '<ul class="woo_bp_fields">';
					if( is_array($woo_bp_sync_settings[$setting['name']]) && count($woo_bp_sync_settings[$setting['name']]) ){
						foreach($woo_bp_sync_settings[$setting['name']]['woofield'] as $key => $field){
							echo '<li><label><select name="'.$setting['name'].'[woofield][]">';
							foreach($woo_fields as $k=>$v){
								if( is_array($v) ){
									echo '<optgroup label="'.$v['label'].'">';
									foreach ($v as $i => $j) {
										echo '<option value="'.$i.'" '.(($field == $i)?'selected=selected':'').'>'.$j.'</option>';
									}
									echo '</optgroup>';
								}else{
									echo '<option value="'.$k.'" '.(($field == $k)?'selected=selected':'').'>'.$v.'</option>';
								}
							}
							echo '</select></label><select name="'.$setting['name'].'[bpfield][]">';
							foreach($bp_fields as $f){
								echo '<option value="'.$f->id.'" '.(($woo_bp_sync_settings[$setting['name']]['bpfield'][$key] == $f->id)?'selected=selected':'').'>'.$f->name.'</option>';
							}
							echo '</select><span class="dashicons dashicons-no remove_field_map"></span></li>';
						}
					}
					echo '<li class="hide">';
					echo '<label><select rel-name="'.$setting['name'].'[woofield][]">';
					foreach($woo_fields as $k=>$v){
						if( is_array($v) ){
							echo '<optgroup label="'.$v['label'].'">';
							foreach ($v as $i => $j) {
								echo '<option value="'.$i.'">'.$j.'</option>';
							}
							echo '</optgroup>';
						}else{
							echo '<option value="'.$k.'">'.$v.'</option>';
						}
					}
					echo '</select></label>';
					echo '<select rel-name="'.$setting['name'].'[bpfield][]">';
					
					foreach($bp_fields as $f){
						echo '<option value="'.$f->id.'">'.$f->name.'</option>';
					}
					echo '</select>';
					echo '<span class="dashicons dashicons-no remove_field_map"></span></li>';
					echo '</ul></td>';
				break;

				default:
					$default = '';
					$default = apply_filters('vibe_woo_bp_sync_generate_form',$default,$setting,$woo_bp_sync_settings);
					echo $default;
				break;
			}
			
			echo '</tr>';
		}
		echo '</tbody>
		</table>';
		echo '<input type="submit" name="save_settings" value="'.__('Save Settings','vbc').'" class="button button-primary" /></form>';
	}

	function save_form_fields(){

		if ( !isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'],'save_settings') ){
		    _e('Security check Failed. Contact Administrator.','vbc');
		    die();
		}
		unset($_POST['_wpnonce']);
		unset($_POST['_wp_http_referer']);
		unset($_POST['save_settings']);
		update_option('vibe_bp_woo_sync_settings',$_POST);
	}

}

Vibe_BP_Woo_Settings::init();