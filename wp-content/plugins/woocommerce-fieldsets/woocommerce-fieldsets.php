<?php
/*
Plugin Name: WooCommerce Forms & Fields
Plugin URI: http://wordpress.geev.nl/product/woocommerce-fieldsets/
Description: Receive additional order info after purchase has been made. - PRO version
Version: 1.0.8
Author: Bart Pluijms
Author URI: http://www.geev.nl/
*/
/*  Copyright 2012  Geev  (email : info@geev.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Defines
 * @since 0.1
 */
define("PLUGIN_SLUG",'woocommerce-fieldsets');
define("PLUGIN_DIR",dirname( plugin_basename( __FILE__ ) ));
define("PLUGIN_PATH",plugin_dir_url(__FILE__));
define("PLUGIN_URL",'http://wordpress.geev.nl/product/woocommerce-fieldsets/');

ob_start();

/**
* Load WooCommerce required functions
* @since 0.1
*/
require_once('inc/funct-basic.php');

/**
* Check if WooCommerce is active
* @since 0.1
*/
$option=get_option('wooaoi_set');
$woo_active=false;
$active=get_option('active_plugins');
if(is_multisite()) {

	$active=get_site_option('active_sitewide_plugins');


	if (array_key_exists('woocommerce/woocommerce.php', $active)) {
		$woo_active=true;
	}
} else {
	if(in_array('woocommerce/woocommerce.php',$active)) {
		$woo_active=true;
	}
}

if ($woo_active=true) {
	require_once('inc/funct.php');
	require_once('inc/funct-fields.php');
	require_once('inc/funct-checkout.php');
	require_once('inc/funct-product.php');
	require_once('classes/WooFields.php');


	load_plugin_textdomain('woo-aoi', false,  PLUGIN_DIR. '/lang/');

	if(isset($option['ch_set']) && $option['ch_set']!="") {
	  add_action('woocommerce_checkout_after_customer_details','WooAOI_checkout');
	  add_action( 'woocommerce_checkout_process', 'WooAOI_checkout_data_process' );
	  add_action('woocommerce_checkout_update_order_meta', 'WooAOI_checkout_data_save');
	  if(isset($option['overwrite']['emails']) && $option['overwrite']['emails']==1) {
		add_action( 'woocommerce_email_after_order_table', 'WooAOI_checkout_email', 15, 2 );
	  }
	  if(isset($option['overwrite']['orderdetail']) && $option['overwrite']['orderdetail']==1) {
		add_action( 'woocommerce_order_details_after_order_table', 'WooAOI_checkout_orderdetails', 90 );
	  }
	}

	if(isset($option['ty_descr']['active']) && $option['ty_descr']['active']==1) {
	  add_action('woocommerce_thankyou','WooAOI_thankyou' );
	}
	if(isset($option['ty_set']) && $option['ty_set']!="") {
	  add_action('woocommerce_thankyou','WooAOI_orderdetail_fields');
	}

	if(isset($option['od_descr']['active']) && $option['od_descr']['active']==1) {
	  add_action('woocommerce_view_order','WooAOI_orderdetail',10);
	}

	if(isset($option['od_set']) && $option['od_set']!="") {
	  add_action('woocommerce_view_order','WooAOI_orderdetail_fields',10);
	}

	if(isset($option['ov_descr']['active']) && $option['ov_descr']['active']==1) {
		add_action('woocommerce_before_my_account','WooAOI_orderdetail');
	}

	if(isset($option['ov_set']) && $option['ov_set']!="") {
	  add_action('woocommerce_before_my_account','WooAOI_orderdetail_fields',10);
	  require_once('inc/funct-userprofile.php');
	}

	// admin specific functions
	if(is_admin()) {
		require_once('admin/settings.php');
		require_once('classes/wooaoi-fieldsets-table.php');

		add_action( 'admin_menu', 'WooAOI_admin_menu' );
		add_action('add_meta_boxes', 'WooAOI_add_metabox');
		add_action( 'woocommerce_process_product_meta', 'WooAOI_save_metabox' );
		add_action( 'save_post', 'WooAOI_metabox_save' );
		add_action( 'admin_enqueue_scripts', 'WooAOI_scripts' );
	} else {
		add_action('init','WooAOI_process_data');
	}

	// Override default checkout fields
	add_filter( 'woocommerce_checkout_fields' , 'WooAOI_checkout_fields' );

	if(isset($option['overwrite']['billing']) && $option['overwrite']['billing']==1) {
		$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
		if(isset($billing_post) && $billing_post!="") {
			add_filter( 'woocommerce_billing_fields', 'WooAOI_checkout_billing', 10, 1 );
			add_action( 'woocommerce_admin_order_data_after_billing_address', 'WooAOI_checkout_billing_show', 10, 1 );
		}
	}
	if(isset($option['overwrite']['shipping']) && $option['overwrite']['shipping']==1) {
		$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
		if(isset($shipping_post) && $shipping_post!="") {
			add_filter( 'woocommerce_shipping_fields', 'WooAOI_checkout_shipping', 10, 1 );
			add_action( 'woocommerce_admin_order_data_after_shipping_address', 'WooAOI_checkout_shipping_show', 10, 1 );
		}
	}
	if(isset($option['overwrite']['account']) && $option['overwrite']['account']==1) {
		$account_post=WooAOI_get_opt(array('overwrite','account_c'));
		if(isset($account_post) && $account_post!="") {
			add_action( 'woocommerce_admin_order_data_after_billing_address', 'WooAOI_checkout_account_show', 10, 1 );
		}
	}

	if(isset($option['overwrite']['order']) && $option['overwrite']['order']==1) {
		$order_post=WooAOI_get_opt(array('overwrite','order_c'));
		if(isset($order_post) && $order_post!="") {
			add_action( 'woocommerce_admin_order_data_after_billing_address', 'WooAOI_checkout_order_show', 10, 1 );
		}
	}

	if((isset($option['overwrite']['billing']) && $option['overwrite']['billing']==1) || (isset($option['overwrite']['shipping']) && $option['overwrite']['shipping']==1) || (isset($option['overwrite']['account']) && $option['overwrite']['account']==1) || (isset($option['overwrite']['order']) && $option['overwrite']['order']==1)) {
		add_action( 'woocommerce_checkout_process', 'WooAOI_checkout_process' );
		add_action('woocommerce_checkout_update_order_meta', 'WooAOI_checkout_save');
		if(isset($option['overwrite']['emails']) && $option['overwrite']['emails']==1) {
			add_action( 'woocommerce_email_after_order_table', 'WooAOI_checkout_email', 15, 2 );
		}
		if(isset($option['overwrite']['orderdetail']) && $option['overwrite']['orderdetail']==1) {
			add_action( 'woocommerce_order_details_after_order_table', 'WooAOI_checkout_orderdetails', 90 );
		}
	}

	// Product detail page custom fieldsets



} else {
	// if WooCommerce is not active show admin message
	function WooAOI_Message() {
		showMessage(__( 'WooCommerce is not active. Please activate WooCommerce before using WooCommerce Forms & Fields plugin.', 'woo-aoi'), true);
	}
	add_action('admin_notices', 'WooAOI_Message');
}

/**
* Check if settings are saved for new version
* @since 0.1
*/

if(!isset($option['version']) || $option['version'] != "1.0")  {
	function WooAOI_version_message() {showMessage( __('We made some important changes to our WooCommerce Forms & Fields. Please refresh your WooCommerce Forms & Fields settings.', 'woo-aoi'),false);}
	add_action('admin_notices', 'WooAOI_version_message');
}

if(!in_array('geev-updater/geev-updater.php',get_option('active_plugins')) )  {
	function WooAOI_update_message() {showMessage(sprintf(__( '%s to get updates for your Geev plugins. After activation, please refresh your WooCommerce Forms & Fields settings.', 'woo-aoi'),'<a href="http://wordpress.geev.nl/geev-updater.zip" title="'.__('Install the Geev Updater plugin','woo-aoi').'">'.__('Install the Geev Updater plugin','woo-aoi').'</a>'), false);}
	add_action('admin_notices', 'WooAOI_update_message');
}

/**
* Added help links to plugin page
* @since 0.1
*/
function WooAOI_plugin_links($links) {
  $settings_link = '<a href="admin.php?page=woo_aoi">Settings</a>';
  $premium_link = '<a href="'.PLUGIN_URL.'" title="Premium Support" target=_blank>Premium Support</a>';
  array_unshift($links, $settings_link,$premium_link);
  return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'WooAOI_plugin_links' );
?>