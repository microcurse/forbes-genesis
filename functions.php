<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Adds custom header functions
require_once get_stylesheet_directory() . '/lib/header-functions.php';

// Adds custom footer functions
require_once get_stylesheet_directory() . '/lib/footer-functions.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}


add_action( 'after_setup_theme', 'genesis_sample_theme_support', 9 );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}

}

add_action( 'after_setup_theme', 'genesis_sample_post_type_support', 9 );
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support() {

	$post_type_supports = genesis_get_config( 'post-type-supports' );

	foreach ( $post_type_supports as $post_type => $args ) {
		add_post_type_support( $post_type, $args );
	}

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'genesis-singular-images', 702, 526, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Disables "sub-nav" for footer
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}


// Custom stuff

// Enqueue custom admin styles
add_action( 'init', 'add_editor_styles' );
function add_editor_styles() {
	add_editor_style( 'style-editor.css' );
}

function enqueue_child_scripts() {
	wp_enqueue_style( 'child_style', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), 1.1);
	wp_enqueue_script( 'child_script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array ( 'jquery' ), 1.1, true);
	wp_enqueue_style( 'print_style', get_stylesheet_directory_uri() . '/assets/css/print.css', array(), '1', 'print' );

}
// add_action( 'wp_enqueue_scripts', 'enqueue_child_scripts', 99 );

add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-secondary',
	'footer-widgets',
	'footer',
	'simple-social-icons',
));

// Editor color pallette
function mytheme_setup_theme_supported_features() {
	add_theme_support( 'editor-color-pallette', array(
		array(
			'name' => __( 'forbes-blue', 'themeLangDomain' ),
			'slug' => 'forbes-blue',
			'color' =>  '#28317E',
		),
		array(
			'name' => __( 'link-blue', 'themeLangDomain' ),
			'slug' => 'link-blue',
			'color' =>  '#2C3CC9',
		),
		array(
            'name' => __( 'very light gray', 'themeLangDomain' ),
            'slug' => 'very-light-gray',
            'color' => '#eee',
        ),
        array(
            'name' => __( 'very dark gray', 'themeLangDomain' ),
            'slug' => 'very-dark-gray',
            'color' => '#444',
        ),
	));
}
add_action( 'after_setup_theme', 'mytheme_setup_theme_supported_features' );

// add top bar with social media links
function fi_add_top_bar() {
	$top_bar = dynamic_sidebar('top-bar');
}
add_action( 'genesis_before_header', 'fi_add_top_bar', 10 );

// async scripts
function add_async_attributes( $tag, $handle ) {
	// add script handles to array below
	$scripts_to_async = array(
		'genesis_enqueue_main_stylesheet', 
		''
);

	foreach( $scripts_to_async as $async_script ) {
		if ( $async_script === $handle ) {
			return str_replace( ' str', ' async="async" src', $tag);
		}
	}
	return $tag;
}
apply_filters( 'script_loader_tag', 'add_async_attributes', 10, 2 );


// defer
function add_defer_attributes( $tag, $hande ) {
	// add script handles to array below
	$scripts_to_defer = array( 
		'dashicons', 
		'' 
	);

	foreach( $scripts_to_defer as $defer_scripts ) {
		if ( $defer_script === $handle ) {
			return str_replace( ' str', ' defer="defer" src', $tag );
		}
	}
	return $tag;
}

// ACF Register A Block
function register_acf_block_types() {
	acf_register_block_type(
		array(
			'name' 				=>	'hero-banner',
			'title'				=>	__('Hero Banner'),
			'description'		=>	__('A hero banner block with space for an image and caption'),
			'render_template'	=>	'hero-banner',
			'icon'				=>	'format-image',
			'keywords'			=>	array('hero', 'banner'),
		)
	);
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'register_acf_block_types');
}

// Load Inline SVGs
function fi_load_inline_svg( $filename ) {
	$svg_path = '/images/';
	if ( file_exists( get_stylesheet_directory() . $svg_path . $filename ) ) {
		return file_get_contents( get_stylesheet_directory() . $svg_path . $filename );
	}
	return 'Nope';
}


// Custom Sidebars
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
		'before_title'	=>	'',
		'after_title'	=>	'',
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
// Move breadcrumbs to after page title
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_archive_title_descriptions', 'genesis_do_breadcrumbs', 15 );

// ACF
add_action( 'acf/init', 'my_acf_init_block_type');
function my_acf_init_block_type() {

	// Check function exists.
	if( function_exists('acf_register_block_type')) {

		// register a category block
		acf_register_block_type(array(
			'name'				=> 'image-link',
			'title'				=>	__('Image with link'),
			'description'		=>	__('Display an image with a link'),
			'render_template'	=>	'template-parts/blocks/image-link/image-link.php',
			'category'			=>	'formatting',
			'icon'				=>	'dashicons-format-image',
			'keywords'			=>	array('image','link'),
		));
	}
}

// Move Category Title Description
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_taxonomy_title_description', 15 );

// Slick Carousel
function fi_slick_carousel() {
	wp_enqueue_style( 'slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
	wp_enqueue_style( 'slick-theme', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
	wp_enqueue_script( 'slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js' );
	wp_enqueue_script( 'slick-variables' , get_stylesheet_directory_uri() . '/js/slick-variables.js' );
}
