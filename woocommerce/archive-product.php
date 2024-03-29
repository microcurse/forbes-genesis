<?php
/**
 * This template displays the archive for Products. Main Shop Page.
 * 
 * @package Genesis_Connect_WooCommerce
 * @version 0.9.8
 * @since 0.9.0
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_filter( 'genesis_pre_get_option_site_layout', 'genesiswooc_archive_layout' );
/**
 * Manage page layout for the Product archive (Shop) page.
 *
 * Set the layout in the Genesis layouts metabox in the Page Editor.
 *
 * @since 0.9.0
 *
 * @param string $layout Current Genesis page layout, such as 'content-sidebar'.
 *
 * @return string Page layout if set for the shop page, otherwise the default site layout.
 */
function genesiswooc_archive_layout( $layout ) {

	$post_layout = get_post_meta( wc_get_page_id( 'shop' ), '_genesis_layout', true );

	if ( ! $post_layout || 'default_layout' === $post_layout ) {
		return $layout;
	}

	return $post_layout;

}

add_action( 'genesis_before_loop', 'genesiswooc_archive_product_loop' );
/**
 * Display shop items (product custom post archive)
 *
 * This function has been refactored in 0.9.4 to provide compatibility with both WooCommerce 1.6.0
 * and backwards compatibility with older versions.
 *
 * This is needed thanks to substantial changes to WooCommerce template contents introduced in
 * WooCommerce 1.6.0.
 *
 * @uses genesiswooc_content_product() if WooCommerce is version 1.6.0+
 * @uses genesiswooc_product_archive() for earlier WooCommerce versions
 *
 * @since 0.9.0
 *
 * @global WooCommerce $woocommerce Current WooCommerce instance.
 */
function genesiswooc_archive_product_loop() {

	global $woocommerce;

	$new = version_compare( $woocommerce->version, '1.6.0', '>=' );

	if ( $new ) {
		genesiswooc_content_product();
	} else {
		genesiswooc_product_archive();
	}

}

genesis();
