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
		$this->main_link = trailingslashit( bp_loggedin_user_domain() . $main_slug );

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
			'parent_url'      => $this->main_link,
			'screen_function' => array($this,'vbc_shop'),
			'position' 	  		=> 30,
			'user_has_access' => $access // Only the logged in user can access this on his/her profile
		) );

		bp_core_new_subnav_item( array(
			'name' 		      => _x( 'My Products','My products sub nav item in profile','vbc' ),
			'slug' 		  	  => _x( 'my-products','my products sub nav slug in profile', 'vbc' ),
			'parent_slug'     => $main_slug,
			'parent_url'      => $this->main_link,
			'screen_function' => array($this,'myproducts'),
			'position' 	  		=> 30,
			'user_has_access' => $access // Only the logged in user can access this on his/her profile
		) );

		bp_core_new_subnav_item( array(
			'name' 		      => _x( 'Add/Edit Product','My products sub nav item in profile','vbc' ),
			'slug' 		  	  => _x( 'add-edit-product','my products sub nav slug in profile', 'vbc' ),
			'parent_slug'     => $main_slug,
			'parent_url'      => $this->main_link,
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
    	echo '<h2>'.__('My Dashboard','vbc').'</h2>';
    }

    function set_content(){
    	//dashboard graphs
    }


    function myproducts(){
    	add_action('bp_template_title',array($this,'set_myproducts_title'));
    	add_action('bp_template_content',array($this,'set_myproducts_content'));
    	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
    	exit();
    }

    function set_myproducts_title(){
    	echo '<h2>'.__('My Products','vbc').'</h2>';
    }

    function set_myproducts_content(){

    	$args = apply_filters('vibe_bp_woo_my_products',array(
    		'post_type'=>'product',
    		'post_author'=>bp_displayed_user_id(),
    		'paged'=>1,
    		'posts_per_page'=>20,
    	));

    	$query = new WP_Query($args);
    	if($query->have_posts()){
    		echo '<ul class="myproducts">';
    		while($query->have_posts()){
    			$query->the_post();
    			echo '<li>';
    			echo '<div class="vbc_myproduct"><div class="vbc_product_image">';
    			the_post_thumbnail(array('size'=>'medium'));
    			echo '</div><div class="vbc_product_content">';
    			echo '<h3>'.get_the_title().'</h3>';
				$product_cats = get_the_terms(get_the_ID(),'product_cat');
				if(!empty($product_cats)){
					echo '<div class="product_cats">';
					foreach($product_cats as $cat){
						echo '<a href="'.get_term_link($cat).'">'.$cat->name.'</a>';
					}
					echo '</div>';
				}
    			echo '<p>'.get_the_excerpt().'</p>';
    			echo '</div></div>';
    			echo '</li>';
    		}
    		echo '</ul>';
    	}else{
    		echo '<div class="message"><p>'.sprintf(__('No products found. %s Create your first product %s','vbc'),'<a href="'.$this->main_link.'/'._x( 'add-edit-product','my products sub nav slug in profile', 'vbc' ).'">','</a>').'</p></div>';
    	}

    	?>
    	<style>
    	ul.myproducts {
    		display: grid;
    		grid-gap:10px;
    		grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
    		font-size: 14px;
		}
    	</style>
    	<?php
    }

    function add_product(){
    	add_action('bp_template_title',array($this,'set_title'));
    	add_action('bp_template_content',array($this,'set_content'));
    	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
    	exit();
    }

}

Vibe_BP_Profile_Shop::init();