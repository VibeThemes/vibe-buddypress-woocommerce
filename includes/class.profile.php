<?php
/**
 *
 * @author      VibeThemes
 * @category    Admin
 * @package     Vibe BuddyPres WooCommerce Sync
 * @version     1.0
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

class Vibe_BP_Profile_Shop{

    public static $instance;
    public static function init(){
    if ( is_null( self::$instance ) )
        self::$instance = new Vibe_BP_Profile_Shop();

        return self::$instance;
    }

    private function __construct(){
    	add_action( 'bp_setup_nav', array($this,'setup_nav' ));
    }

    function setup_nav(){
    	global $bp;
		$access= 0;
		if(function_exists('bp_is_my_profile'))
			$access = apply_filters('vibe_bp_shop_access',bp_is_my_profile());

		$main_slug = _x( 'shop','my products sub nav slug in profile', 'vbc' );
		$main_link = trailingslashit( bp_loggedin_user_domain() . $main_slug );

        bp_core_new_nav_item( array( 
            'name' => _x( 'Shop','My products sub nav item in profile','vbc' ), 
            'slug' => $main_slug, 
            'position' => 10,
            'default_subnav_slug' => _x( 'dashboard','my products sub nav slug in profile', 'vbc' ),
            'screen_function' => array($this,'vbc_shop'), 
            'show_for_displayed_user' => $access
      	) );

        bp_core_new_subnav_item( array(
			'name' 		      => _x( 'Dashboard','My products sub nav item in profile','vbc' ),
			'slug' 		  	  => _x( 'dashboard','my products sub nav slug in profile', 'vbc' ),
			'parent_slug'     => $main_slug,
			'parent_url'      => $main_link,
			'screen_function' => array($this,'vbc_shop'),
			'position' 	  		=> 30,
			'user_has_access' => $access // Only the logged in user can access this on his/her profile
		) );

		bp_core_new_subnav_item( array(
			'name' 		      => _x( 'My Products','My products sub nav item in profile','vbc' ),
			'slug' 		  	  => _x( 'my-products','my products sub nav slug in profile', 'vbc' ),
			'parent_slug'     => $main_slug,
			'parent_url'      => $main_link,
			'screen_function' => array($this,'myproducts'),
			'position' 	  		=> 30,
			'user_has_access' => $access // Only the logged in user can access this on his/her profile
		) );

		bp_core_new_subnav_item( array(
			'name' 		      => _x( 'Add/Edit Product','My products sub nav item in profile','vbc' ),
			'slug' 		  	  => _x( 'add-edit-product','my products sub nav slug in profile', 'vbc' ),
			'parent_slug'     => $main_slug,
			'parent_url'      => $main_link,
			'screen_function' => array($this,'add_product'),
			'position' 	  		=> 30,
			'user_has_access' => $access // Only the logged in user can access this on his/her profile
		) );

    }

    function vbc_shop(){
    	add_action('bp_template_title',array($this,'set_title'));
    	add_action('bp_template_content',array($this,'set_content'));
    	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
    	exit();
    }

    function set_title(){
    	echo '<h2>Ok</h2>';
    }

    function set_content(){
    	echo 'Ye h hai content';
    }


    function myproducts(){
    	add_action('bp_template_title',array($this,'set_title'));
    	add_action('bp_template_content',array($this,'set_content'));
    	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
    	exit();
    }


    function add_product(){
    	add_action('bp_template_title',array($this,'set_title'));
    	add_action('bp_template_content',array($this,'set_content'));
    	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
    	exit();
    }

}

Vibe_BP_Profile_Shop::init();