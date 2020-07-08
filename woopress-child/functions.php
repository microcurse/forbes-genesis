<?php

/** Dequeue font awesome style from revslider */
function remove_revfontawesome() {
	wp_dequeue_style( 'font-awesome');
}
add_action( 'load_icon_fonts', 'remove_revfontawesome', 200 );

/** Requeue Parent Theme CSS before custom.css  */
remove_action( 'wp_enqueue_scripts', 'etheme_enqueue_styles', 130);
add_action( 'wp_enqueue_scripts', 'etheme_enqueue_styles',  10);

/** Add Custom Styles and scripts */
function enqueue_child_scripts() {
	wp_enqueue_style( 'child_style', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), 1.2);
	wp_enqueue_script( 'child_script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array ( 'jquery' ), 1.1, true);
	wp_enqueue_style( 'print_style', get_stylesheet_directory_uri() . '/assets/css/print.css', array(), '1', 'print' );
	wp_enqueue_style( 'front_end', get_stylesheet_directory_uri() . '/assets/css/front-end.css', '1' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_child_scripts', 99 );

function add_google_font() {
	wp_enqueue_style( 'google_font_lobster_two', 'https://fonts.googleapis.com/css?family=Lobster+Two:700i&display=swap' );
}
//add_action( 'wp_enqueue_scripts', 'add_google_font', 1 );

/** Remove auto p tags */
// remove_filter( 'the_content', 'wpautop' );
// remove_filter( 'the_excerpt', 'wpautop' );

/** Remove duplicate title tags */
add_theme_support( 'title-tag' );
add_filter( 'the_seo_framework_force_title_fix', '__return_true' );

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

add_action( 'wp_head', 'add_gtm_head', 1);

function add_gtm_body() { ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PWFMLKK"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php
}

add_action( 'et_after_body', 'add_gtm_body');


add_action('wp_footer', 'etheme_right_click_html');
if(!function_exists('etheme_right_click_html')) {
	function etheme_right_click_html() {
		echo "<div class='credentials-html'>";
			echo "<div class='credentials-content'>";
				echo etheme_get_option('right_click_html');
			echo "</div>";
			echo "<div class='close-credentials'>close</div>";
		echo "</div>";
	}
}

function rocket_lazy_load_exclude_class( $attributes ) {
	$attributes[] = 'class="cq-beforeafter-img"';

	return $attributes;
}
add_filter( 'rocket_lazyload_excluded_attributes', 'rocket_lazy_load_exclude_class', 200 );

// Add search by variation sku to search index 
// Resave the products so they get reindex
add_filter('relevanssi_content_to_index', 'rlv_index_variation_skus', 10, 2);
function rlv_index_variation_skus($content, $post) {
	if ($post->post_type == "product") {
		$args = array('post_parent' => $post->ID, 'post_type' => 'product_variation', 'posts_per_page' => -1);
		$variations = get_posts($args);
		if (!empty($variations)) {
			foreach ($variations as $variation) {
				$sku = get_post_meta($variation->ID, '_sku', true);
				$content .= " $sku";
			}
		}
	}
 
	return $content;
}

// Add extra align
add_theme_support( 'align-wide' );
add_theme_support( 'align-full' );

// Editor styles
add_theme_support('editor-styles');

// Dark background for editor
add_theme_support( 'editor-styles' );
add_theme_support( 'dark-editor-style' );

// Load Inline SVGs
function fi_load_inline_svg( $filename ) {
	$svg_path = '/assets/images/';
	if ( file_exists( get_stylesheet_directory() . $svg_path . $filename ) ) {
		return file_get_contents( get_stylesheet_directory() . $svg_path . $filename );
	}
	return 'Nope';
}