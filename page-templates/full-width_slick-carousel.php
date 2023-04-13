<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme. This also comes with support for the slick carousel
 *
 * Template Name: Full-Width Hero w/ Slick Carousel
 * 
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_filter( 'body_class', 'genesis_full_width_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function genesis_full_width_class( $classes ) {

	$classes[] = 'full-width-content' . ' with-hero' . ' background-white';
	return $classes;

}

?>
<script type="text/javascript" src="https://www.forbesindustries.com/wp-content/themes/woopress-child/assets/slick/slick.min.js"></script>

<script>
		$('.center-carousel').slick({
			fade: true,
			arrows: true,
			infinite: true,
			dots: true,
		});
	</script>

<?php
// Runs the Genesis loop
genesis();