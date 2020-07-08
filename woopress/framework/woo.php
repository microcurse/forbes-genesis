<?php
// **********************************************************************//
// ! Add brand description
// **********************************************************************//

if( !function_exists( 'et_brand_description' ) ) {
	function et_brand_description() {
		if(is_tax('brand') && term_description() != '') {
			echo '<div class="term-description">';
				echo do_shortcode(term_description());
			echo '</div>';
		}
	}
	//add_filter('woocommerce_archive_description', 'et_brand_description');
}

// **********************************************************************//
// ! Remove Default STYLES
// **********************************************************************//

add_filter( 'woocommerce_enqueue_styles', '__return_false' );
add_filter( 'pre_option_woocommerce_enable_lightbox', 'return_no'); // Remove woocommerce prettyphoto

function return_no($option) {
	return 'no';
}

// **********************************************************************//
// ! Template hooks
// **********************************************************************//

add_action('wp', 'et_template_hooks');
if(!function_exists('et_template_hooks')) {
	function et_template_hooks() {
		add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 40 ); // add pagination above the products
		add_action( 'woocommerce_single_product_summary', 'et_size_guide', 26 );
		add_action( 'woocommerce_single_product_summary', 'et_email_btn', 36 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_cart_totals_after_shipping', 'woocommerce_shipping_calculator', 15 );
		remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
		remove_action( 'woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10 );
		add_action( 'woocommerce_widget_shopping_cart_total', 'et_woocommerce_widget_shopping_cart_subtotal', 10 );

		// ! Change single product main gallery image size
		add_filter( 'woocommerce_gallery_image_size', function( $size ) {
			return 'woocommerce_single';
		} );
		
		if ( etheme_get_option('category_archive_desc_position') == 'bottom' ) {
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
			add_action( 'woocommerce_after_main_content', 'woocommerce_taxonomy_archive_description', 40 );
			add_action( 'woocommerce_after_main_content', 'woocommerce_product_archive_description', 40 );
		}

		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

		if(etheme_get_option('reviews_position') == 'outside' ) {
			add_filter( 'woocommerce_product_tabs', 'et_remove_reviews_from_tabs', 98 );
			add_action( 'woocommerce_after_single_product_summary', 'comments_template', 30 );
			add_action('show_product_reviews', 'comments_template', 10);
		}

		if ( ! function_exists( 'et_hidden_title' ) ) {
			function et_hidden_title(){
				if(etheme_get_option('show_product_title')) {
					the_title( '<h3 itemprop="name" class="product_title entry-title">', '</h3>' );
				}
			}
		}
   		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    	add_action( 'woocommerce_single_product_summary', 'et_hidden_title', 5 );

    	$layout = ( etheme_get_custom_field( 'et_single_layout' ) != '' && etheme_get_custom_field('et_single_layout') != 'inherit' ) ? etheme_get_custom_field( 'et_single_layout' ) : etheme_get_option( 'single_product_layout' ) ;
		if( $layout == 'fixed' ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		}
	}
}

if(!function_exists('et_remove_reviews_from_tabs')) {
	function et_remove_reviews_from_tabs( $tabs ) {
	    unset( $tabs['reviews'] ); 			// Remove the reviews tab
	    return $tabs;

	}
}

if ( !function_exists('et_woocommerce_widget_shopping_cart_subtotal') ) {
	function et_woocommerce_widget_shopping_cart_subtotal () {
		echo '<p class="small-h pull-left">' . esc_html__('Cart Subtotal', 'woopress') . '</p><span class="big-coast pull-right">' . WC()->cart->get_cart_subtotal() . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}


// **********************************************************************//
// ! Define image sizes
// **********************************************************************//
if(!function_exists('etheme_woocommerce_image_dimensions')) {
	function etheme_woocommerce_image_dimensions() {
	  	$catalog = array(
			'width' 	=> '450',	// px
			'height'	=> '600',	// px
			'crop'		=> 0 		// true
		);

		$single = array(
			'width' 	=> '555',	// px
			'height'	=> '741',	// px
			'crop'		=> 0 		// true
		);

		$thumbnail = array(
			'width' 	=> '149',	// px
			'height'	=> '198',	// px
			'crop'		=> 0 		// false
		);

		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
}

add_action('et_before_data_import', 'etheme_woocommerce_image_dimensions');

// **********************************************************************//
// ! Hidden sidebar functionality
// **********************************************************************//

add_action('after_setup_theme', 'et_hidden_sidebar', 20);

if(!function_exists('et_hidden_sidebar')) {
	function et_hidden_sidebar() {
		global $options;

		if ( !class_exists('WooCommerce') ) return;

		if(etheme_get_option('sidebar_hidden')) {
			add_action( 'woocommerce_before_shop_loop', 'et_hidden_sidebar_btn', 1 ); // add pagination above the products
			add_action( 'after_page_wrapper', 'et_hidden_sidebar_html', 35 ); // add pagination above the products

		}
	}
}


if(!function_exists('et_hidden_sidebar_html')) {
	function et_hidden_sidebar_html() {
		if ( !is_shop() && !is_product_taxonomy() ) return;
		?>
			<div class="st-menu hide-filters-block">
				<div class="nav-wrapper">
					<div class="st-menu-content">
						<?php etheme_get_sidebar('shop'); ?>
					</div>
				</div>
			</div>
		<?php
	}
}

if(!function_exists('et_hidden_sidebar_btn')) {
	function et_hidden_sidebar_btn() {
		if ( !is_shop() && !is_product_taxonomy() ) return;
		?>
			<div id="st-trigger-effects" class="column pull-left">
				<button data-effect="hide-filters-block" class="btn filled medium"><?php esc_html_e('Show Filter', 'woopress'); ?></button>
			</div>
		<?php
	}
}
// visible product woo 3.0v

if ( ! function_exists('et_visible_product') ) :
    function et_visible_product( $id, $valid ){
        $product = wc_get_product( $id );

        // updated for woocommerce v3.0
        $visibility = $product->get_catalog_visibility();
        $stock = $product->is_in_stock();

        if (  $visibility  != 'hidden' &&  $visibility  != 'search' && $stock ) {
            return get_post( $id );
        }

        $the_query = new WP_Query( array( 'post_type' => 'product', 'p' => $id ) );

        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $valid_post = ( $valid == 'next' ) ? get_adjacent_post( 1, '', 0, 'product_cat' ) : get_adjacent_post( 1, '', 1, 'product_cat' );
                if ( empty( $valid_post ) ) return;
                $next_post_id = $valid_post->ID;
                $visibility = wc_get_product( $next_post_id );
                $stock = $visibility->is_in_stock();
                $visibility = $visibility->get_catalog_visibility();

            }
            // Restore original Post Data
            wp_reset_postdata();
        }

        if ( $visibility == 'visible' || $visibility == 'catalog' && $stock ) {
            return $valid_post;
        } else {
            return et_visible_product( $next_post_id, $valid );
        }
            
    }
endif;

// **********************************************************************//
// ! Next and previous product links
// **********************************************************************//

if ( ! function_exists('etheme_products_links') ) :
    function etheme_products_links( $atts, $content = null ) {

        global $post;
        $is_product = false;

        if ( $post->post_type == 'product' ) {
            $is_product = true;

            $next_post = get_adjacent_post( 1, '', 0, 'product_cat' );
            $prev_post = get_adjacent_post( 1, '', 1, 'product_cat' );

            if ( ! empty( $next_post ) && $next_post->post_type == 'product' ) {
                $next_post = et_visible_product( $next_post->ID, 'next' );
            }

            if ( ! empty( $prev_post ) && $prev_post->post_type == 'product' ) {
                $prev_post = et_visible_product( $prev_post->ID, 'prev' );
            }

        } else {
            $next_post = get_next_post();
            $prev_post = get_previous_post();
        }
        ?>
        <div class="product-arrows pull-right">
        <?php if(!empty($prev_post)) : 
            if ( function_exists('mb_strlen') ) {
                $prev_symbols = (mb_strlen(get_the_title($prev_post->ID)) > 30) ? '...' : ''; 
                $title = mb_substr(get_the_title($prev_post->ID),0,30) . $prev_symbols;
            } 
            else {
                $prev_symbols = (strlen(get_the_title($prev_post->ID)) > 30) ? '...' : ''; 
                $title = substr(get_the_title($prev_post->ID),0,30) . $prev_symbols;
            }?>
                <div class="prev-product" onclick="window.location='<?php echo get_permalink( $prev_post->ID ); ?>'">
                    <div class="hide-info">
                        <a href="<?php echo get_permalink($prev_post->ID); ?>">
                            <?php $img = get_the_post_thumbnail( $prev_post->ID, array(90, 90));
                            echo (!empty($img) ) ? $img : '<img src="'.ETHEME_BASE_URI.'images/placeholder.jpg">';  ?>
                        </a>
                        <div>
                    		<span><?php echo esc_html($title); ?></span>
                        	<?php if ( $is_product ) {
                            	$p = wc_get_product($prev_post);
                                echo '<span class="price">'.$p->get_price_html().'</span>';
                            } ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(!empty($next_post)) : 
             if ( function_exists('mb_strlen') ) {
                $next_symbols = (mb_strlen(get_the_title($next_post->ID)) > 30) ? '...' : ''; 
                $title = mb_substr(get_the_title($next_post->ID),0,30) . $next_symbols;
            } 
            else {
                $next_symbols = (strlen(get_the_title($next_post->ID)) > 30) ? '...' : ''; 
                $title = substr(get_the_title($next_post->ID),0,30) . $next_symbols;
                } ?>
                <div class="next-product" onclick="window.location='<?php echo get_permalink( $next_post->ID ); ?>'">
                    <div class="hide-info">
                        <a href="<?php echo get_permalink($next_post->ID); ?>">
                            <?php $img = get_the_post_thumbnail( $next_post->ID, array(90, 90));
                            echo (!empty($img) ) ? $img : '<img src="'.ETHEME_BASE_URI.'images/placeholder.jpg">';  ?>
                        </a>
                        <div>
                    		<span><?php echo esc_html($title); ?></span>
                        	<?php if ( $is_product ) {
                            	$p = wc_get_product($next_post);
                                echo '<span class="price">'.$p->get_price_html().'</span>';
                            } ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php wp_reset_query();
    }
endif;

// **********************************************************************//
// ! Product Video
// **********************************************************************//

if(!function_exists('et_get_external_video')) {
	function et_get_external_video($post_id) {
		if(!$post_id) return false;
		$product_video_code = get_post_meta( $post_id, '_product_video_code', true );

		return $product_video_code;
	}
}

if(!function_exists('et_get_attach_video')) {
	function et_get_attach_video($post_id) {
		if(!$post_id) return false;
		$product_video_code = get_post_meta( $post_id, '_product_video_gallery', false );

		return $product_video_code;
	}
}

// **********************************************************************//
// ! AJAX Quick View
// **********************************************************************//

add_action('wp_ajax_et_product_quick_view', 'et_product_quick_view');
add_action('wp_ajax_nopriv_et_product_quick_view', 'et_product_quick_view');
if(!function_exists('et_product_quick_view')) {
	function et_product_quick_view() {
		if(empty($_POST['prodid'])) {
			echo 'Error: Absent product id';
			die();
		}

		$args = array(
			'p'=>$_POST['prodid'],
			'post_type' => array('product', 'product_variation')
		);

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) : $the_query->the_post();
				wc_get_template('product-quick-view.php');
			endwhile;
			wp_reset_query();
			wp_reset_postdata();
		} else {
			echo 'No posts were found!';
		}
		die();
	}
}

if ( ! function_exists('et_wcml_multi_currency_quick_view') ) {
	function et_wcml_multi_currency_quick_view( $actions ){

	    $actions[] = 'et_product_quick_view';

	    return $actions;
	}
	add_filter( 'wcml_multi_currency_ajax_actions', 'et_wcml_multi_currency_quick_view' );
}

// **********************************************************************//
// ! Wishlist
// **********************************************************************//

//add_action('woocommerce_after_add_to_cart_button', 'etheme_wishlist_btn', 20);
//add_action('woocommerce_after_shop_loop_item', 'etheme_wishlist_btn', 20);

if(!function_exists('etheme_wishlist_btn')) {
    function etheme_wishlist_btn() {
        if(class_exists('YITH_WCWL'))
            echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    }
}


if(!function_exists('et_wishlist_btn')) {
    function et_wishlist_btn($label = '') {
        global $yith_wcwl, $product;
        if(!class_exists('YITH_WCWL') || !class_exists('YITH_WCWL_Shortcode')) return;

        return YITH_WCWL_Shortcode::add_to_wishlist(array());

        $exists = $yith_wcwl->is_product_in_wishlist( $product->get_id() );
        $url = $yith_wcwl->get_wishlist_url();

        ob_start(); ?>

        <div class="yith-wcwl-add-to-wishlist">
	        <div class="yith-wcwl-add-button 
	        	<?php if ($exists) { echo ' hide'; } 
	        	else { echo ' show'; } ?>" 
	        	<?php if ($exists) echo 'style="display:none;"'; ?>>
		       	<a href="<?php echo esc_url( $yith_wcwl->get_addtowishlist_url() ); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>" class="add_to_wishlist">
		       		<?php 
			       		if($label == '') {
				            esc_html_e('Add to Wishlist', 'woopress');
				        }
				        else {
				        	echo esc_html($label);
				        }
		        	?>
		       	</a>
		        <img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" id="add-items-ajax-loading" alt="ajax-loading" width="16" height="16" style="visibility:hidden" />';
	        </div>
	       	<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
	       		<a href="<?php echo esc_url( $url ); ?>"><?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', esc_html__( 'Browse Wishlist', 'woopress' ) ); ?></a>
	       	</div>
	        <div class="yith-wcwl-wishlistexistsbrowse 
	        	<?php if ( $exists ) { echo 'show'; } 
	        	else { echo 'hide'; } ?>" 
	        	style="display: <?php if ($exists) { echo 'block'; } else { echo 'none'; } ?>">
	        	<a href="<?php echo esc_url( $url ); ?>"><?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', esc_html__( 'Browse Wishlist', 'woopress' ) ); ?></a>
	        </div>
	        <div style="clear:both"></div>
	        <div class="yith-wcwl-wishlistaddresponse"></div>
        </div>
		
		<?php 
        return ob_get_clean();
    }
}

if(!function_exists('et_email_btn')) {
    function et_email_btn($label = '') {
        global $post;
        $permalink = get_permalink($post->ID);
        $post_title = rawurlencode(get_the_title($post->ID));
        if($label == '') {
            $label = esc_html__('Email to a friend', 'woopress');
        }

        echo '<a href="mailto:enteryour@addresshere.com?subject='.$post_title.'&amp;body=Check%20this%20out:%20'.$permalink.'" target="_blank" class="email-link">'.$label.'</a>';
    }
}

if(!function_exists('et_size_guide')) {
    function et_size_guide() {
	    if ( etheme_get_custom_field('size_guide_img') ) : ?>
	        <div class="size_guide">
	    	 <a rel="<?php echo (get_option('woocommerce_enable_lightbox') == 'yes') ? 'prettyPhoto' : 'lightbox'; ?>" href="<?php etheme_custom_field('size_guide_img'); ?>"><?php esc_html_e('SIZING GUIDE', 'woopress'); ?></a>
	        </div>
	    <?php endif;
    }
}


// **********************************************************************//
// ! Product Labels
// **********************************************************************//

if(!function_exists('etheme_wc_product_labels')) {
	function etheme_wc_product_labels( $product_id = '' ) {
	    echo etheme_wc_get_product_labels($product_id);
	}
}


if(!function_exists('etheme_wc_get_product_labels')) {
	function etheme_wc_get_product_labels( $product_id = '' ) {
		global $post, $wpdb,$product;
	    $count_labels = 0;
	    $output = '';

	    if ( etheme_get_option('sale_icon') ) :
	        if ($product->is_on_sale()) {$count_labels++;
	            $output .= '<span class="label-icon sale-label">'.esc_html__( 'Sale!', 'woopress' ).'</span>';
	        }
	    endif;

	    if ( etheme_get_option('new_icon') ) : $count_labels++;
	        if(etheme_product_is_new($product_id)) :
	            $second_label = ($count_labels > 1) ? 'second_label' : '';
	            $output .= '<span class="label-icon new-label '.$second_label.'">'.esc_html__( 'New!', 'woopress' ).'</span>';
	        endif;
	    endif;
	    return $output;
	}
}

// **********************************************************************//
// ! Get list of all product images
// **********************************************************************//

if(!function_exists('get_images_list')) {
	function get_images_list() {
		global $post, $product, $woocommerce;
		$images_string = '';

		$attachment_ids = $product->get_gallery_image_ids();

		$_i = 0;
		if(count($attachment_ids) > 0) {
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'shop_catalog');
			$images_string .= $image[0];
			foreach($attachment_ids as $id) {
				$_i++;
				$image = wp_get_attachment_image_src($id, 'shop_catalog');
				if($image == '') continue;
				if($_i == 1 && $images_string != '')
					$images_string .= ',';


				$images_string .= $image[0];

				if($_i != count($attachment_ids))
					$images_string .= ',';
			}

		}

		return $images_string;
	}
}

// **********************************************************************//
// ! Is product New
// **********************************************************************//

if(!function_exists('etheme_product_is_new')) {
	function etheme_product_is_new( $product_id = '' ) {
		global $post, $wpdb;
	    $key = 'product_new';
		if(!$product_id) $product_id = $post->ID;
		if(!$product_id) return false;
	    $_etheme_new_label = get_post_meta($product_id, $key);
	    if(isset($_etheme_new_label[0]) && $_etheme_new_label[0] == 'enable') {
	        return true;
	    }
	    return false;
	}
}

// **********************************************************************//
// ! Grid/List switcher
// **********************************************************************//

add_action('woocommerce_before_shop_loop', 'etheme_grid_list_switcher',35);
if(!function_exists('etheme_grid_list_switcher')) {
	function etheme_grid_list_switcher() {
		?>
		<?php $view_mode = etheme_get_option('view_mode'); ?>
		<?php if($view_mode == 'grid_list'): ?>
			<div class="view-switcher hidden-tablet hidden-phone">
				<label><?php esc_html_e('View as:', 'woopress'); ?></label>
				<div class="switchToGrid"><i class="icon-th-large"></i></div>
				<div class="switchToList"><i class="icon-th-list"></i></div>
			</div>
		<?php elseif($view_mode == 'list_grid'): ?>
			<div class="view-switcher hidden-tablet hidden-phone">
				<label><?php esc_html_e('View as:', 'woopress'); ?></label>
				<div class="switchToList"><i class="icon-th-list"></i></div>
				<div class="switchToGrid"><i class="icon-th-large"></i></div>
			</div>
		<?php endif ;?>


		<?php
	}
}

// **********************************************************************//
// ! Catalog Mode
// **********************************************************************//

add_action( 'after_setup_theme', 'et_catalog_setup', 18 );

if(!function_exists('et_catalog_setup')) {
	function et_catalog_setup() {
		$just_catalog = etheme_get_option('just_catalog');

		if($just_catalog) {
			#remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			//remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
			remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );

			add_filter( 'woocommerce_loop_add_to_cart_link', function($sprintf, $product, $args) {
				return sprintf( '<a rel="nofollow" href="%s" class="button show-product">%s</a>',
					esc_url(  $product->get_permalink() ),
					__('Show details', 'woopress')
				);
			}, 50, 3 );

		}
		// **********************************************************************//
		// ! Set number of products per page
		// **********************************************************************//
		add_filter( 'loop_shop_per_page', function ($cols) { return etheme_get_option('products_per_page'); }, 20 );
	}
}

// **********************************************************************//
// ! Category thumbnail
// **********************************************************************//
if(!function_exists('etheme_category_header')){
	function etheme_category_header() {
		if(function_exists('et_get_term_meta')){
			global $wp_query;
			$cat = $wp_query->get_queried_object();
			if(!property_exists($cat, "term_id") && !is_search()){
				echo '<div class="category-description">';
			    	echo do_shortcode(etheme_get_option('product_bage_banner'));
				echo '</div>';
			}else{
			    $image = etheme_get_option('product_bage_banner');
				$queried_object = get_queried_object();

				if (isset($queried_object->term_id)){

					$term_id = $queried_object->term_id;
					$content = et_get_term_meta($term_id, 'cat_meta');

					if(isset($content[0]['cat_header']) && !empty($content[0]['cat_header'])){
						echo '<div class="category-description">';
						echo do_shortcode($content[0]['cat_header']);
						echo '</div>';
					}
				}
			}
		}
	}
}

// **********************************************************************//
// ! Review form
// **********************************************************************//
//add_action('after_page_wrapper', 'etheme_review_form');
if(!function_exists('etheme_review_form')) {
	function etheme_review_form( $product_id = '' ) {
		global $woocommerce, $product,$post;
		$title_reply = '';

		if ( have_comments() ) :
			$title_reply = esc_html__( 'Add a review', 'woopress' );

		else :

			$title_reply = esc_html__( 'Be the first to review', 'woopress' ).' &ldquo;'.$post->post_title.'&rdquo;';
		endif;

		$commenter = wp_get_current_commenter();

		echo '<div id="review_form">';

		echo '<h4>'.esc_html__('Add your review', 'woopress').'</h4>';

		$comment_form = array(
			'title_reply' => '',
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'fields' => array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'woopress' ) . '</label> ' . '<span class="required">*</span>' .
				            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'woopress' ) . '</label> ' . '<span class="required">*</span>' .
				            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
			),
			'label_submit' => esc_html__( 'Submit Review', 'woopress' ),
			'logged_in_as' => '',
			'comment_field' => ''
		);

		if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {

			$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . esc_html__( 'Rating', 'woopress' ) .'</label><select name="rating" id="rating">
				<option value="">'.esc_html__( 'Rate&hellip;', 'woopress' ).'</option>
				<option value="5">'.esc_html__( 'Perfect', 'woopress' ).'</option>
				<option value="4">'.esc_html__( 'Good', 'woopress' ).'</option>
				<option value="3">'.esc_html__( 'Average', 'woopress' ).'</option>
				<option value="2">'.esc_html__( 'Not that bad', 'woopress' ).'</option>
				<option value="1">'.esc_html__( 'Very Poor', 'woopress' ).'</option>
			</select></p>';

		}

		$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your Review', 'woopress' ) . '</label><textarea id="comment" name="comment" cols="25" rows="8" aria-required="true"></textarea></p>' . WC()->nonce_field('comment_rating', true, false);


			comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );



		echo '</div>';
	}
}

// **********************************************************************//
// ! User area in account page sidebar
// **********************************************************************//
add_action('etheme_before_account_sidebar', 'etheme_user_info',10);
if(!function_exists('etheme_user_info')) {
	function etheme_user_info() {
		$current_user = wp_get_current_user();
		if(is_user_logged_in()) {
			?>
				<div class="user-sidearea">
					<?php echo get_avatar( $current_user->ID, 50 ); ?>
					<?php echo '<strong>' . $current_user->user_login . "</strong>\n"; ?>
					<br>
					<a href="<?php echo wp_logout_url(home_url()); ?>"><?php esc_html_e('Logout', 'woopress') ?></a>
				</div>
			<?php
		}
	}
}

// **********************************************************************//
// ! Get account sidebar position
// **********************************************************************//

if(!function_exists('etheme_account_sidebar')) {
    function etheme_account_sidebar() {

        $result = array(
            'responsive' => '',
            'span' => 9,
            'sidebar' => etheme_get_option('account_sidebar')
        );

        $result['responsive'] = etheme_get_option('shop_sidebar_responsive');

        if(!$result['sidebar']) {
            $result['span'] = 12;
        }

        return $result;
    }
}


// **********************************************************************//
// ! Top Cart Widget
// **********************************************************************//

add_filter( 'woocommerce_widget_cart_is_hidden', '__return_false' );

if(!function_exists('etheme_cart_items')) {
	function etheme_cart_items ($limit = 3) {
global $woocommerce;
		?>

		<div class="shopping-cart-widget" id='basket'>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-summ" data-items-count="<?php echo WC()->cart->cart_contents_count; ?>">
			<div class="cart-bag">

				<i class="<?php echo etheme_get_option( 'top_cart_icon' ) ? 'fa fa-' . esc_html( etheme_get_option( 'top_cart_icon' ) ) : 'ico-sum'; ?>" aria-hidden="true" style="font-size: <?php echo etheme_get_option( 'top_cart_icon_size' ) ? esc_html( etheme_get_option( 'top_cart_icon_size' ) ) : '18px'; ?>; color:<?php echo etheme_get_option( 'activecol' ); ?>;"></i>
				<span class="badge-number"><?php echo WC()->cart->cart_contents_count; ?></span>
			</div>

				<span class='shop-text'><?php esc_html_e('Cart', 'woopress') ?>: <span class="total"><?php echo WC()->cart->get_cart_subtotal(); ?></span></span>

			</a>
		</div>

		<div class="cart-popup-container">

		<div class="et_block"></div>

		<?php

        if ( ! WC()->cart->is_empty() ) {
          ?>
			<p class="recently-added"><?php esc_html_e('Recently added item(s)', 'woopress'); ?></p>

			<ul class='order-list'>
          <?php
            $counter = 0;
            $cart = array_reverse((WC()->cart->get_cart()));
            foreach ( $cart as $cart_item_key => $cart_item ) {
                $counter++;
                if($counter > $limit) continue;
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( array( 70, 200), array( 'class' => 'media-object' ) ), $cart_item, $cart_item_key );
                if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) )
                    continue;

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) )

                	$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

                ?>
					<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php
                            echo apply_filters( 'woocommerce_cart_item_remove_link',
							sprintf('<a href="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"class="close-order-li remove remove_from_cart_button" title="%s"></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_attr( $product_id ),esc_attr ( $cart_item_key ), esc_attr( $_product->get_sku() ),esc_html__('Remove this item', 'woopress') ),
                            	$cart_item_key );
                        ?>
						<div class="media">
							<a class="pull-left" href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
							</a>
							<?php $product_title = $_product->get_title();
							if (is_a($_product, 'WC_Product_Variation')) {
		                		$variation = wc_get_product($_product->get_id());
								$product_title = $variation->get_name();
		                	} ?>
							<div class="media-body">
								<h4 class="media-heading"><a href="<?php echo esc_url ( $product_permalink ); ?>"><?php echo apply_filters( 'woocommerce_cart_item_name', $product_title, $cart_item, $cart_item_key ); ?></a></h4>
								<div class="descr-box">
									<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
									<span class="coast"><?php echo esc_attr($cart_item['quantity']); ?> x <span class='medium-coast'><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></span></span>
								</div>
							</div>
						</div>
					</li>
                <?php
                } ?>
				</ul>

        <?php
        } else {
            echo '<p class="woocommerce-mini-cart__empty-message empty a-center">' . esc_html__('No products in the cart.', 'woopress') . '</p>';
        }


        if ( sizeof( WC()->cart->get_cart() ) > 0 ) { ?>
			<?php
				/**
				 * Woocommerce_widget_shopping_cart_total hook.
				 *
				 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
				 */
				do_action( 'woocommerce_widget_shopping_cart_total' );
			?>
			<div class="clearfix"></div>
			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
			<div class='bottom-btn'>
				<a href="<?php echo wc_get_cart_url(); ?>" class='btn text-center border-grey'><?php echo esc_html__('View Cart', 'woopress'); ?></a>
				<a href="<?php echo wc_get_checkout_url(); ?>" class='btn text-center big filled'><?php echo esc_html__('Checkout', 'woopress'); ?></a>
			</div>
            <?php
            do_action( 'woocommerce_widget_shopping_cart_after_buttons' );

        }


?>
		</div>
<?php


	}
}

if(!function_exists('et_support_multilingual_ajax')) {
	add_filter('wcml_multi_currency_is_ajax', 'et_support_multilingual_ajax');
	function et_support_multilingual_ajax($functions) {
		$functions[] = 'et_woocommerce_add_to_cart';
		return $functions;
	}
}

// **********************************************************************//
// ! New AJAX add to cart action
// **********************************************************************//
add_action('wp_ajax_et_woocommerce_add_to_cart', 'et_woocommerce_add_to_cart');
add_action('wp_ajax_nopriv_et_woocommerce_add_to_cart', 'et_woocommerce_add_to_cart');

if(!function_exists('et_woocommerce_add_to_cart')) {
	function et_woocommerce_add_to_cart() {
		ob_start();

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity          = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		$variation_id = $variation = '';
		if(isset($_POST['variation_id']) && $_POST['variation_id'] != '') {
			$variation_id = $_POST['variation_id'];
		}
		if(isset($_POST['variation']) && is_array($_POST['variation'])) {
			$variation = $_POST['variation'];
		}

		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id );

			$data = array(
				'error' => false,
			);

		} else {

			header( 'Content-Type: application/json; charset=utf-8' );

			// If there was an error adding to the cart, redirect to the product page to show any errors
			$data = array(
				'error' => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
			);
		}

		echo json_encode( $data );

		die();
	}
}
apply_filters('woocommerce_product_subcategories_hide_empty', false);

if ( ! function_exists('et_set_user_visited_product_cookie') ) {
	function et_set_user_visited_product_cookie() {
	    global $post;

	    if ( is_product() ){
			if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
				$viewed_products = array();
			} else {
				$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
			}

			// Unset if already in viewed products list.
			$keys = array_flip( $viewed_products );

			if ( isset( $keys[ $post->ID ] ) ) {
				unset( $viewed_products[ $keys[ $post->ID ] ] );
			}

			$viewed_products[] = $post->ID;

			if ( count( $viewed_products ) > 30 ) {
				array_shift( $viewed_products );
			}

			// Store for session only.
			wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
	    }
	}

	add_action( 'template_redirect', 'et_set_user_visited_product_cookie', 30 );
}


if ( ! function_exists('etheme_product_links') ) :
    function etheme_product_links( $atts, $content = null ) {

        global $post;
        $is_product = false;

        if ( $post->post_type == 'product' ) {
            $is_product = true;

            $next_post = get_adjacent_post( 1, '', 0, 'product_cat' );
            $prev_post = get_adjacent_post( 1, '', 1, 'product_cat' );

            if ( ! empty( $next_post ) && $next_post->post_type == 'product' ) {
                $next_post = et_visible_product( $next_post->ID, 'next' );
            }

            if ( ! empty( $prev_post ) && $prev_post->post_type == 'product' ) {
                $prev_post = et_visible_product( $prev_post->ID, 'prev' );
            }

        } else {
            $next_post = get_next_post();
            $prev_post = get_previous_post();
        }
        ?>
           
                <?php if(!empty($prev_post)) : 
                if ( function_exists('mb_strlen') ) {
                    $prev_symbols = (mb_strlen(get_the_title($prev_post->ID)) > 30) ? '...' : ''; 
                    $title = mb_substr(get_the_title($prev_post->ID),0,30) . $prev_symbols;
                } 
                else {
                    $prev_symbols = (strlen(get_the_title($prev_post->ID)) > 30) ? '...' : ''; 
                    $title = substr(get_the_title($prev_post->ID),0,30) . $prev_symbols;
                }?>
                    <div class="prev-product" onclick="window.location='<?php echo get_permalink($prev_post->ID); ?>'">
                        <div class="hide-info">
                            <div class="post-details">
                                 <a href="<?php echo get_permalink($prev_post->ID); ?>" class="post-title">
                                    <?php echo esc_html($title); ?>
                                </a>
                                <?php if ( $is_product ) {
                                    $p = wc_get_product($prev_post);
                                        echo '<p class="price">'.$p->get_price_html().'</p>';
                                    } ?>
                            </div>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>">
                                <?php $img = get_the_post_thumbnail( $prev_post->ID, array(90, 90));
                                echo (!empty($img) ) ? $img : '<img src="'.ETHEME_BASE_URI.'images/placeholder.jpg">';  ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(!empty($next_post)) : 
                 if ( function_exists('mb_strlen') ) {
                    $next_symbols = (mb_strlen(get_the_title($next_post->ID)) > 30) ? '...' : ''; 
                    $title = mb_substr(get_the_title($next_post->ID),0,30) . $next_symbols;
                } 
                else {
                    $next_symbols = (strlen(get_the_title($next_post->ID)) > 30) ? '...' : ''; 
                    $title = substr(get_the_title($next_post->ID),0,30) . $next_symbols;
                    } ?>
                    <div class="next-product" onclick="window.location='<?php echo get_permalink($next_post->ID); ?>'">
                            <div class="hide-info">
                                <a href="<?php echo get_permalink($next_post->ID); ?>">
                                    <?php $img = get_the_post_thumbnail( $next_post->ID, array(90, 90));
                                    echo (!empty($img) ) ? $img : '<img src="'.ETHEME_BASE_URI.'images/placeholder.jpg">';  ?>
                                </a>
                                <div class="post-details">
                                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="post-title">   
                                        <?php echo esc_html($title); ?>
                                    </a>
                                     <?php if ( $is_product ) {
                                        $p = wc_get_product($next_post);
                                       echo '<p class="price">'.$p->get_price_html().'</p>';
                                    } ?>
                                </div>
                            </div>
                    </div>
                <?php endif; ?>
           
        <?php wp_reset_query();
    }
endif;



// **********************************************************************// 
// ! Visibility of next/prev pruduct
// **********************************************************************//

if ( ! function_exists('et_visible_product') ) :
    function et_visible_product( $id, $valid ){
        $product = wc_get_product( $id );

        // updated for woocommerce v3.0
        $visibility = $product->get_catalog_visibility();
        $stock = $product->is_in_stock();

        if (  $visibility  != 'hidden' &&  $visibility  != 'search' && $stock ) {
            return get_post( $id );
        }

        $the_query = new WP_Query( array( 'post_type' => 'product', 'p' => $id ) );

        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $valid_post = ( $valid == 'next' ) ? get_adjacent_post( 1, '', 0, 'product_cat' ) : get_adjacent_post( 1, '', 1, 'product_cat' );
                if ( empty( $valid_post ) ){
                	wp_reset_postdata();
                	return;
                } 
                $next_post_id = $valid_post->ID;
                $visibility = wc_get_product( $next_post_id );
                $stock = $visibility->is_in_stock();
                $visibility = $visibility->get_catalog_visibility();

            }
            // Restore original Post Data
            wp_reset_postdata();
        }

        if ( ( $visibility == 'visible' || $visibility == 'catalog' ) && $stock ) {
            return $valid_post;
        } else {
            return et_visible_product( $next_post_id, $valid );
        }
            
    }
endif;