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

// Adds sidebars
require_once get_stylesheet_directory() . '/lib/sidebar.php';

// Adds custom footer functions
require_once get_stylesheet_directory() . '/lib/footer-functions.php';

//* Enable the block-based widget editor
add_filter( 'use_widgets_block_editor', '__return_true' );


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

// Repositions primary navigation menu from outside the header tags to inside the header tags.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 8 );

// Disables "sub-nav" for footer
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

// Load scripts from old site
// add_action( 'wp_enqueue_scripts', 'enqueue_child_scripts', 99 );

// Enqueue custom admin styles
add_action( 'init', 'add_editor_styles' );


// Editor color pallette
add_action( 'after_setup_theme', 'mytheme_setup_theme_supported_features' );


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

/**
 * Functions from old site
 * 
 */

function add_editor_styles() {
	add_editor_style( 'style-editor.css' );
}

function enqueue_child_scripts() {
	wp_enqueue_style( 'child_style', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), 1.1);
	wp_enqueue_script( 'child_script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array ( 'jquery' ), 1.1, true);
	wp_enqueue_style( 'print_style', get_stylesheet_directory_uri() . '/assets/css/print.css', array(), '1', 'print' );
}

add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-secondary',
	'footer-widgets',
	'footer',
	'simple-social-icons',
));

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
function add_defer_attributes( $tag, $handle ) {
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


/**
 * Font Awesome CDN Setup Webfont
 * 
 * This will load Font Awesome from the Font Awesome Free or Pro CDN.
 */
if (! function_exists('fa_custom_setup_cdn_webfont') ) {
  function fa_custom_setup_cdn_webfont($cdn_url = '', $integrity = null) {
    $matches = [];
    $match_result = preg_match('|/([^/]+?)\.css$|', $cdn_url, $matches);
    $resource_handle_uniqueness = ($match_result === 1) ? $matches[1] : md5($cdn_url);
    $resource_handle = "font-awesome-cdn-webfont-$resource_handle_uniqueness";

    foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
      add_action(
        $action,
        function () use ( $cdn_url, $resource_handle ) {
          wp_enqueue_style( $resource_handle, $cdn_url, [], null );
        }
      );
    }

    if($integrity) {
      add_filter(
        'style_loader_tag',
        function( $html, $handle ) use ( $resource_handle, $integrity ) {
          if ( in_array( $handle, [ $resource_handle ], true ) ) {
            return preg_replace(
              '/\/>$/',
              'integrity="' . $integrity .
              '" crossorigin="anonymous" />',
              $html,
              1
            );
          } else {
            return $html;
          }
        },
        10,
        2
      );
    }
  }
}

fa_custom_setup_cdn_webfont(
  'https://use.fontawesome.com/releases/v5.15.4/css/all.css',
  'sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm'
);


// Remove Edit Post Link
function wpse_remove_edit_post_link( $link ) {
	return '';
}
add_filter('edit_post_link', 'wpse_remove_edit_post_link');


/**
 * Change number of products that are displayed per page (shop page)
*/
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options –> Reading
  // Return the number of products you wanna show per page.
  $cols = 24;
  return $cols;
}

/**
 *  Force full-width on pages
 */

function force_full_width_layout($classes) {

	if( is_page() ) {
		remove_action('genesis_sidebar', 'genesis_do_sidebar');
		$classes[] = 'full-width-content';
	}

	return $classes;

}

add_filter('body_class', 'force_full_width_layout');