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
add_image_size( 'wide-variation-swatch', 150, 90, true );
add_image_size( 'tall-variation-swatch', 76, 126, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Repositions primary navigation menu from outside the header tags to inside the header tags.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 8 );

// Disables "sub-nav" for footer
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

// Load scripts from old site
add_action( 'wp_enqueue_scripts', 'enqueue_child_scripts', 99 );

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

// Slick Carousel
function fi_slick_carousel() {
	wp_enqueue_style( 'slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
	wp_enqueue_style( 'slick-theme', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
	wp_enqueue_script( 'slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js' );
	wp_enqueue_script( 'slick-variables' , get_stylesheet_directory_uri() . '/js/slick-variables.js' );
}

fi_slick_carousel();

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
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css',
  'sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w'
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

// Remove sidebar hook on pages
add_action( 'genesis_before_loop', 'remove_sidebar_hook_on_pages' );
function remove_sidebar_hook_on_pages() {
   if ( is_page() ) {
       remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
   }
}

//cleaned product table shortcode with html tags - bp 01 2022
add_shortcode( 'cleantags', 'cleantags_func' );
function cleantags_func( ) {
	$html = do_shortcode( '[quotelisttable]' );
	$comma = str_replace("</tr>", ";", $html);
	$nohtml = wp_strip_all_tags($comma, TRUE);
	$cleaned = str_replace("SKU", "", $nohtml);
	$cleaned2 = str_replace("Quantity", "", $cleaned);
	$cleaned3 = str_replace("Product   ;" ,"", $cleaned2);
	$cleaned4 = str_replace(";",";\r\n",$cleaned3);
	return $cleaned4;	
}

// Add widget for Visit A Showroom page
genesis_register_sidebar( array(
	'id' => 'visit-showroom',
	'name' => __( 'Visit a Showroom', 'genesis' ),
	'description' => __( 'Widget area for Visit a Showroom', 'childtheme' ),
	) );

add_action( 'genesis_after_entry', 'add_genesis_widget_area' );
function add_genesis_widget_area() {
		genesis_widget_area( 'custom-widget', array(
			'before' => '<div class="custom-widget widget-area">',
			'after'  => '</div>',
    ) );

}

// Add Length x Width x Height labels on product dimensions
//add_filter('woocommerce_format_dimensions', 'custom_formated_product_dimensions', 10, 2);
function custom_formated_product_dimensions( $dimension_string, $dimensions) {
	if ( empty( $dimension_string ) ) 
		return __( 'N/A', 'woocommerce' ); 

	$dimensions = array_filter( array_map( 'wc_format_localized_decimal', $dimensions ) );
	$label_with_dimensions = []; // Initializing

	// Loop through dimensions array
	foreach( $dimensions as $key => $dimension )
		$label_with_dimensions[$key] = ucfirst($key) . ': ' . $dimension . '"';

	return implode( ', ', $label_with_dimensions);
}

// Set MOQ for Banquet Chairs product category
// On single product pages
add_filter( 'woocommerce_quantity_input_args', 'min_qty_filter_callback', 20, 2 );
function min_qty_filter_callback( $args, $product ) {
    $categories = array('Banquet Chairs'); // The targeted product category(ies)
    $min_qty    = 320; // The minimum product quantity

    $product_id = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();

    if( has_term( $categories, 'product_cat', $product_id ) ){
        $args['min_value'] = $min_qty;
    }
    return $args;
}

add_action( 'woocommerce_check_cart_items', 'wc_min_item_required_qty' );
function wc_min_item_required_qty() {
    $categories    = array('Banquet Chairs'); // The targeted product category
    $min_item_qty  = 320; // Minimum Qty required (for each item)
    $display_error = false; // Initializing

    // Loop through cart items
    foreach(WC()->cart->get_cart() as $cart_item ) {
        $item_quantity = $cart_item['quantity']; // Cart item quantity
        $product_id    = $cart_item['product_id']; // The product ID

        // For cart items remaining to "Noten" producct category
        if( has_term( $categories, 'product_cat', $product_id ) && $item_quantity < $min_item_qty ) {
            wc_clear_notices(); // Clear all other notices

            // Add an error notice (and avoid checkout).
            wc_add_notice( sprintf( 'Banquet chairs have a minimum order quantity of %s. Please update your quantity.', $min_item_qty , $item_quantity ), 'error' );
            break; // Stop the loop
        }
    }
}

/**	Add Google Tag Manager */
function add_gtm_head() { ?>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PWFMLKK');</script>
<!-- End Google Tag Manager -->
	<?php 
}
