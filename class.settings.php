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

    private function __construct(){
    	add_options_page(__('Vibe Bp Woo Sync settings','vbc'),__('BVibe Bp Woo Sync','vbc'),'manage_options','vbc',array($this,'settings'));
		
    }

    function settings(){
    	echo '<h3>'.__('Google Social Connect Settings','bp-social-connect').'</h3>';
		$settings = array(
				array(
					'label' => __('Enable Google Login','vibe-customtypes'),
					'name' =>'google',
					'type' => 'select',
					'options'=>array(
						'0' => __('No','bp-social-connect'),
						'1' => __('Yes','bp-social-connect'),
					),
					'desc' => ''
				),
				array(
					'label' => __('Client ID','vibe-customtypes'),
					'name' => 'google_client_id',
					'type' => 'text',
					'desc' => sprintf(__('Set your Google client id, create a new project for web and grab the client id from %s','vibe-customtypes'),'<a href="https://console.developers.google.com">https://console.developers.google.com</a>'),
				),
				array(
					'label' => __('Client Secret','vibe-customtypes'),
					'name' => 'google_client_secret',
					'type' => 'text',
					'desc' => __('Enter Google client secret','vibe-customtypes')
				),
				array(
					'label' => __('Client Uri','vibe-customtypes'),
					'name' => 'google_redirect_uri',
					'type' => 'text',
					'desc' => __('Enter redirect uri','vibe-customtypes')
				),
			);
		$settings = apply_filters('bp_social_connect_google_fields',$settings);
		$this->generate_form('google',$settings);
    }

    function generate_form($tab,$settings=array()){
		echo '<form method="post">
				<table class="form-table">';
		wp_nonce_field('save_settings','_wpnonce');   
		echo '<ul class="save-settings">';

		foreach($settings as $setting ){
			echo '<tr valign="top">';
			global $wpdb,$bp;
			switch($setting['type']){
				case 'textarea': 
					echo '<th scope="row" class="titledesc">'.$setting['label'].'</th>';
					echo '<td class="forminp"><textarea name="'.$setting['name'].'">'.(isset($this->settings[$setting['name']])?$this->settings[$setting['name']]:(isset($setting['std'])?$setting['std']:'')).'</textarea>';
					echo '<span>'.$setting['desc'].'</span></td>';
				break;
				case 'select':
					echo '<th scope="row" class="titledesc">'.$setting['label'].'</th>';
					echo '<td class="forminp"><select name="'.$setting['name'].'" class="chzn-select">';
					foreach($setting['options'] as $key=>$option){
						echo '<option value="'.$key.'" '.(isset($this->settings[$setting['name']])?selected($key,$this->settings[$setting['name']]):'').'>'.$option.'</option>';
					}
					echo '</select>';
					echo '<span>'.$setting['desc'].'</span></td>';
				break;
				case 'checkbox':
					echo '<th scope="row" class="titledesc">'.$setting['label'].'</th>';
					echo '<td class="forminp"><input type="checkbox" name="'.$setting['name'].'" '.(isset($this->settings[$setting['name']])?'CHECKED':'').' />';
					echo '<span>'.$setting['desc'].'</span></td>';
				break;
				case 'number':
					echo '<th scope="row" class="titledesc">'.$setting['label'].'</th>';
					echo '<td class="forminp"><input type="number" name="'.$setting['name'].'" value="'.(isset($this->settings[$setting['name']])?$this->settings[$setting['name']]:'').'" />';
					echo '<span>'.$setting['desc'].'</span></td>';
				break;
				case 'hidden':
					echo '<input type="hidden" name="'.$setting['name'].'" value="1"/>';
				break;
				case 'bp_fields':
					echo '<th scope="row" class="titledesc">'.$setting['label'].'</th>';
					echo '<td class="forminp"><a class="add_new_map button">'.__('Add BuddyPress profile field map','bp-social-connect').'</a>';

					global $bp,$wpdb;;
					$table =  $bp->profile->table_name_fields;
					$bp_fields = $wpdb->get_results("SELECT DISTINCT name FROM {$table}");

					echo '<ul class="bp_fields">';
					if(is_array($this->settings[$setting['name']]['field']) && count($this->settings[$setting['name']]['field'])){
						foreach($this->settings[$setting['name']]['field'] as $key => $field){
							echo '<li><label><select name="'.$setting['name'].'[field][]">';
							foreach($setting['fields'] as $k=>$v){
								echo '<option value="'.$k.'" '.(($field == $k)?'selected=selected':'').'>'.$k.'</option>';
							}
							echo '</select></label><select name="'.$setting['name'].'[bpfield][]">';
							foreach($bp_fields as $f){
								echo '<option value="'.$f->name.'" '.(($this->settings[$setting['name']]['bpfield'][$key] == $f->name)?'selected=selected':'').'>'.$f->name.'</option>';
							}
							echo '</select><span class="dashicons dashicons-no remove_field_map"></span></li>';
						}
					}
					echo '<li class="hide">';
					echo '<label><select rel-name="'.$setting['name'].'[field][]">';
					foreach($setting['fields'] as $k=>$v){
						echo '<option value="'.$k.'">'.$k.'</option>';
					}
					echo '</select></label>';
					echo '<select rel-name="'.$setting['name'].'[bpfield][]">';
					
					foreach($bp_fields as $f){
						echo '<option value="'.$f->name.'">'.$f->name.'</option>';
					}
					echo '</select>';
					echo '<span class="dashicons dashicons-no remove_field_map"></span></li>';
					echo '</ul></td>';
				break;
				default:
					echo '<th scope="row" class="titledesc">'.$setting['label'].'</th>';
					echo '<td class="forminp"><input type="text" name="'.$setting['name'].'" value="'.(isset($this->settings[$setting['name']])?$this->settings[$setting['name']]:(isset($setting['std'])?$setting['std']:'')).'" />';
					echo '<span>'.$setting['desc'].'</span></td>';
				break;
			}
			
			echo '</tr>';
		}
		echo '</tbody>
		</table>';
		echo '<input type="submit" name="save" value="'.__('Save Settings','bp-social-connect').'" class="button button-primary" /></form>';
	}


	function save(){
		$none = $_POST['save_settings'];
		if ( !isset($_POST['save']) || !isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'],'save_settings') ){
		    _e('Security check Failed. Contact Administrator.','bp-social-connect');
		    die();
		}
		unset($_POST['_wpnonce']);
		unset($_POST['_wp_http_referer']);
		unset($_POST['save']);

		foreach($_POST as $key => $value){
			$this->settings[$key]=$value;
		}

		$this->put($this->settings);
	}
}


Vibe_BP_Woo_Settings::init();