<?php  
/*
 *   Custom footer functions
*/

// Remove site footer.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// add in new footer markup - prefix function name fi_
add_action( 'genesis_footer', 'fi_footer_markup_open' );
add_action( 'genesis_footer', 'fi_footer_markup_close' );

// Open footer markup
function fi_footer_markup_open() {
	
    genesis_markup(
		[
			'open'    => '<footer %s>',
			'context' => 'site-footer',
		]
	);
	genesis_structural_wrap( 'footer', 'open' );
	
}

// Close footer markup
function fi_footer_markup_close() {
	
    genesis_markup(
		[
			'close'    => '</footer>',
			'context' => 'site-footer',
		]
	);
	genesis_structural_wrap( 'footer', 'close' );
	
}


// Widgetized sections for footer
function fi_footer_section() {
	genesis_register_sidebar( array(

	));
}