<?php
/**
 * Custom Sidebars
 * 
*/

// Footer left 'sidebar'. Controlled through the widgets admin.
add_action( 'widgets_init', 'my_register_sidebars' );
function my_register_sidebars() {
	// Register footer copy sidebar
	register_sidebar(array(
		'id'			=>	'footer-left',
		'name'			=>	__( 'Footer left' ),
		'description'	=>	__('Add logo, address, and social media links here', 'genesis-sample' ),
		'before_widget'	=>	'<div class="%1$s">',
		'after_widget'	=>	'</div>',
		'before_title'	=>	'',
		'after_title'	=>	'',
	));

	// Register shop filter sidebar
	register_sidebar(array(
		'id'			=>	'shop-sidebar',
		'name'			=>	__( 'Shop Sidebar' ),
		'description'	=>	__( 'Add shop filters here.', 'genesis-sample' ),
		'before_widget'	=>	'<div class="%1$s">',
		'after_widget'	=>	'</div>',
		'before_title'	=>	'<div class="sidebar-title">',
		'after_title'	=>	'</div>',
	));
}

add_action( 'genesis_before', 'fi_add_woo_sidebar', 20 );
function fi_add_woo_sidebar() {

    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        if( is_woocommerce() ) {
            remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
            remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
            add_action( 'genesis_sidebar', 'fi_woo_sidebar' );
        }
    }
    
}
function fi_woo_sidebar() {
    if ( ! dynamic_sidebar( 'shop-sidebar' ) && current_user_can( 'edit_theme_options' )  ) {
        genesis_default_widget_area_content( __( 'WooCommerce Primary Sidebar', 'genesis' ) );
    }
}