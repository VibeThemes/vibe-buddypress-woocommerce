=== Vibe BuddyPress WooCommerce ===
Contributors: vibethemes
Tags: buddypress woocommerce sync, bp2wc, wc2bp, woosyncbp, bpsyncwoo,bpwoosync
Requires at least: 3.6
Tested up to: 5.3.2
Stable tag: 1.1
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Vibe BuddyPress WooCommerce helps users to Sync the Buddypress Profile Fields with Woocommerce billing and shipping fields.

== Description ==
Vibe BuddyPress WooCommerce plugin is a free plugin developed to help users to Sync the Buddypress Profile Fields with Woocommerce billing and shipping fields and vice versa. The users do not have to worry a lot and perform various steps to sync the data, they simply needs to map the fields in the wordpress settings -> vibe bp woo sync. The rest of the work will be done by the plugin automatically whenever the buddypress profile fields are updated or woocommerce fields are updated.

Tutorial On how to setup and get started : <a href="https://wplms.io/support/knowledge-base/vibe-bp-woo-sync/">link</a>

= More Information =

Visit the <a href="https://wplms.io/">WPLMS Education WordPress LMS</a> for documentation, support, and information on getting involved in the project.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'Vibe BuddyPress WooCommerce'
3. Activate Vibe BuddyPress WooCommerce from your Plugins page. 

= From WordPress.org =

1. Download Vibe BuddyPress WooCommerce.
2. Upload the 'vibe-buddypress-woocommerce' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
3. Activate Vibe BuddyPress WooCommerce from your Plugins page.


== Frequently Asked Questions ==

= Does it require both woocommerce and buddypress plugin to be activated? =

Yes, the plugin requires both the plugins to be activated then only it will sync the profiles with each other

= Does it require a specific theme to be activated? =

No, You do need any specific theme for this plugin, you can use it with any theme on wordpress, it only requires woocommerce and buddypress plugins to be activated in your website.


= I want to sync a Custom WooCommerce field =

Get the WooCommerce custom field id. Assume : billing_field_369 , then add this code in your child theme :
<pre>
add_filter('vibe_bp_woo_sync_fields',function($fields){
$fields['billing']['billing_field_369']= ' WooCommerce Profession';
return $fields;
});
</pre>

== Screenshots ==

1. BP WOO Sync Setting.


== Upgrade Notice ==
No updates

== Changelog ==

= 1.0 =
Initialise 1.0