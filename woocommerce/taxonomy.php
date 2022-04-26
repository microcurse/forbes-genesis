<?php
/**
 * This template displays the Product Category and Tag taxonomy term archives.
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
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
// remove archive.php default genesis archive heading open
remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_open', 5);
// remove archive.php default genesis archive heading close
remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_close', 15);

add_action( 'genesis_loop', 'genesiswooc_product_taxonomy_loop' );
add_action( 'genesis_archive_title_descriptions', 'fi_genesis_do_archive_headings_open', 6, 3 );
add_action( 'genesis_archive_title_descriptions', 'fi_genesis_do_archive_headings_wrap_open', 7, 3 );
add_action( 'genesis_archive_title_descriptions', 'fi_genesis_do_archive_background', 8 );
add_action( 'genesis_archive_title_descriptions', 'fi_genesis_do_archive_headings_wrap_close', 16, 3 );
add_action( 'genesis_archive_title_descriptions', 'fi_genesis_do_archive_headings_close', 17, 3 );

// add sub categories
add_action( 'genesis_before_content', 'add_subcategories' );

add_filter( 'woocommerce_show_page_title', '__return_false' );
add_filter( 'genesis_term_intro_text_output', 'genesiswooc_term_intro_text_output' );
/**
 * Fall back to the archive description if no intro text is set.
 *
 * @since 1.0.0
 *
 * @param string $intro_text The default Genesis archive intro text.
 *
 * @return string Archive intro text, or archive description if no intro text set.
 */
function genesiswooc_term_intro_text_output( $intro_text ) {

	$wp_archive_description = get_the_archive_description();

	if ( ! $intro_text && $wp_archive_description ) {
		return $wp_archive_description;
	}

	return $intro_text;

}

/**
 * Displays shop items for the queried taxonomy term.
 *
 * This function has been refactored in 0.9.4 to provide compatibility with
 * both WooCommerce 1.6.0 and backwards compatibility with older versions.
 * This is needed thanks to substantial changes to WooCommerce template contents
 * introduced in WooCommerce 1.6.0.
 *
 * @global $woocommerce $woocommerce The WooCommerce instance.
 *
 * @uses genesiswooc_content_product() if WooCommerce is version 1.6.0+
 * @uses genesiswooc_product_taxonomy() for earlier WooCommerce versions
 *
 * @since 0.9.0
 */
function genesiswooc_product_taxonomy_loop() {

	global $woocommerce;

	$new = version_compare( $woocommerce->version, '1.6.0', '>=' );

	if ( $new ) {
		genesiswooc_content_product();
	} else {
		genesiswooc_product_taxonomy();
	}

}

/**
 *  Customized functions to wrap archive description in a wrapper.
 * 
 */

/**
 * Add open markup for archive headings to archive pages.
 *
 * @since 2.5.0
 *
 * @param string $heading    Optional. Archive heading, default is empty string.
 * @param string $intro_text Optional. Archive intro text, default is empty string.
 * @param string $context    Optional. Archive context, default is empty string.
 */
function fi_genesis_do_archive_headings_open( $heading = '', $intro_text = '', $context = '' ) {
  
  if ( $heading || $intro_text ) {
    
    genesis_markup(
      [
        'open'    => '<div %s>',
        'context' => $context,
      ]
    );
        
  }
}

function fi_genesis_do_archive_headings_wrap_open( $heading = '', $intro_text = '', $context = '' ) {
  
  if ( $heading || $intro_text ) {
    
    genesis_markup(
      [
        'open'    => '<div %s>',
        'context' => 'wrap'
      ]
    );
        
  }
}
    
/**
 * Add close markup for archive headings to archive pages.
 *
 * @since 2.5.0
 *
 * @param string $heading    Optional. Archive heading, default is empty string.
 * @param string $intro_text Optional. Archive intro text, default is empty string.
 * @param string $context    Optional. Archive context, default is empty string.
 */
function fi_genesis_do_archive_headings_wrap_close( $heading = '', $intro_text = '', $context = '' ) {

	if ( $heading || $intro_text ) {

    // add wrapper open
    genesis_markup(
      [
        'close'    => '</div>',
        'context' => 'wrap'
      ]
    );

	}
}

function fi_genesis_do_archive_headings_close( $heading = '', $intro_text = '', $context = '' ) {

	if ( $heading || $intro_text ) {

		genesis_markup(
			[
				'close'   => '</div>',
				'context' => $context,
			]
		);

	}
}

// ACF Add background image to archive header
function fi_genesis_do_archive_background() {
  $term = get_queried_object();
  $image = get_field('category_header_background', $term);
  
    if( $image ) : ?>
      <div class="archive-bg-container"><img class="archive-bg-image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"></img></div>
    <?php endif;
}

function fi_genesis_do_archive_copy() {

}


/**
 * PEDAC
 * 
 * INPUT
 * PHP call to get Product Category
 * 
 * OUTPUT
 * Subcategories of that product category styled accordingly in HTML
 * 
 * ALGORITHM
 * Get current product category
 * Get sub/child categories for that product
 *  - term_taxonomy_id
 * return/echo to HTML for each sub category 
 * 
 */

function add_subcategories() {
  if ( is_product_category() ) {

      $term_id  = get_queried_object_id();
      $taxonomy = 'product_cat';

      // Get subcategories of the current category
      $terms    = get_terms([
          'taxonomy'    => $taxonomy,
          'hide_empty'  => true,
          'parent'      => get_queried_object_id()
      ]);

      $output = '<div class="subcategories"><h2 class="subcat_title">Browse by category</h2><div class="subcat_grid">';

      // Loop through product subcategories WP_Term Objects
      foreach ( $terms as $term ) {
          $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
          $image = wp_get_attachment_url( $thumbnail_id ); 
          $term_link = get_term_link( $term, $taxonomy );

          $output .= '<div class="subcat_item light-shadow"><a href="'. $term_link .'">' . '<img src="' .$image. '" width="160"/>' . '<h3 class="category_title">' . $term->name . '</h3></a></div>';
      }
      if ($term) {
        echo $output . '</div></div>';
      }
  }
}

genesis();
