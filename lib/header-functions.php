<?php  
/*
 *   Custom header functions
*/

// remove initial header functions
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_header' );

// add in new header markup - prefix function name fi_
add_action( 'genesis_header', 'fi_header_markup_open', 5 );
add_action( 'genesis_header', 'fi_header_inner_wrap_open', 6 );
add_action( 'genesis_header', 'fi_add_title', 7 );
add_action( 'genesis_header', 'fi_add_right_block', 12 );
add_action( 'genesis_header', 'fi_header_inner_wrap_close', 18 );
add_action( 'genesis_header', 'fi_header_markup_close', 20 );

// new header functions
function fi_header_markup_open() {
    
    genesis_markup( 
        [
            'html5'     => '<header %s>',
            'context'   => 'site-header',
        ]
    );

    // Open container div
    genesis_markup(
        [
            'open'      => '<div %s>',
            'context'   => 'header-inner',
        ]
    );

}

function fi_header_markup_close() {

    // Close site-header
    genesis_markup(
        [
            'close'     => '</header>',
            'context'   => 'site-header',
        ]
    );

}

function fi_header_inner_wrap_open() {
    genesis_markup(
        [
            'open'      => '<div %s>',
            "context"   => 'wrap',
        ]
        );
}

function fi_header_inner_wrap_close() {
    genesis_markup(
        [
            'open'      => '</div>',
            "context"   => 'wrap',
        ]
        );
}

function fi_add_title() {
    
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
    
}

// This block contains my account, my quote list, and search box
function fi_add_right_block() {

    genesis_markup(
        [
            'open'      => '<div %s>',
            'context'   => 'right-block',
        ]
    );

    require_once('customer-links.php');
    my_links();

    if ( function_exists( 'get_product_search_form' ) ) {

        get_product_search_form();

    } else {

        get_search_form();
        
    }

    genesis_markup(
        [
            'close'     => '</div>',
            'context'   => 'right-block',
        ]
    );
}