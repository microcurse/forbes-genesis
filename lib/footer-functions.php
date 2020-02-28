<?php  
/*
 *   Custom footer functions
*/

// Remove site footer.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Customize site footer
add_action( 'genesis_footer', 'fi_custom_footer' );

function fi_custom_footer() {
	
    genesis_markup( 
        [
            'html5'     => '<header %s>',
            'context'   => 'site-header',
        ]
    );

    // Open wrap
    // genesis_structural_wrap('header');

    // Open container div
    genesis_markup(
        [
            'open'      => '<div %s>',
            'context'   => 'flex-container',
        ]
	);
	
}