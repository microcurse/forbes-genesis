<?php  
/*
 *   Custom header functions
*/

//remove initial header functions
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_header' );

// add in new header markup - prefix function name fi_
add_action( 'genesis_header', 'fi_header_markup_open', 5 );
add_action( 'genesis_header', 'fi_header_markup_close', 20 );
add_action( 'genesis_header', 'fi_do_upper_header');

// new header functions
function fi_header_markup_open() {

    genesis_markup( 
        [
            'html5'     => '<header %s>',
            'context'   => 'site-header',
        ]
    );

}

function fi_header_markup_close() {

    genesis_markup(
        [
            'close'     => '</header>',
            'context'   => 'site-header',
        ]
    );

}

// Add logo with search next to it.
function fi_do_upper_header() {
    
    // Open container div
    genesis_markup(
        [
            'open'      => '<div %s>',
            'context'   => 'flex-container',
        ]
    );

    // Open title area container
    genesis_markup( 
        [
            'open'      => '<div %s>',
            'context'   => 'title-area',
        ] 
    );

    // Add site logo title
    do_action( 'genesis_site_title' );
    
    // Add site description
    do_action( 'genesis_site_description' );

    // Close container div
    genesis_markup(
        [
            'close'     => '</div>',
            'context'   => 'title-area',
        ]
    );

    fi_add_search();

    genesis_markup(
        [
            'close'      => '</div>',
            'context'   => 'container',
        ]
    );

}

// Add search box. This will add default search if woocommerce isn't installed
function fi_add_search() {
    
    if ( function_exists( 'get_product_search_form' ) ) {

        get_product_search_form();

    } else {

        get_search_form();
        
    }

}