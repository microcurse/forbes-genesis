<?php  
/*
 *   Custom header functions
*/
require_once('header-upper.php');

// remove initial header functions
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_header' );

// add in upper bar
add_action( 'genesis_before_header', 'fi_header_upper_open', 0 );
add_action( 'genesis_before_header', 'header_upper', 2 );
add_action( 'genesis_before_header', 'fi_header_upper_close', 4 );

// add in new header markup - prefix function name fi_
add_action( 'genesis_header', 'fi_header_markup_open', 5 );
add_action( 'genesis_header', 'fi_add_title', 7 );
add_action( 'genesis_header', 'fi_add_search', 12 );
add_action( 'genesis_header', 'fi_header_markup_close', 20 );

// header upper bar functions
function fi_header_upper_open () {
    
    genesis_markup( 
        [
            'open'     => '<div %s>',
            'context'   => 'header-upper',
        ]
    );

    genesis_markup(
        [
            'open'      => '<div %s>',
            'context'   => 'wrap',
        ]
    );

}

function fi_header_upper_close () {

    genesis_markup(
        [
            'open'      => '</div>',
            'context'   => 'wrap',
        ]
    );

    genesis_markup(
        [
            'close'      => '</div>',
            'context'   => 'header-upper',
        ]
    );

}


// new header functions
function fi_header_markup_open() {
    
    genesis_markup( 
        [
            'html5'     => '<header %s>',
            'context'   => 'site-header',
        ]
    );

    // wrap open
    genesis_markup(
        [
            'open'      => '<div %s>',
            "context"   => 'wrap',
        ]
    );

}

function fi_header_markup_close() {

    // wrap close
    genesis_markup(
        [
            'open'      => '</div>',
            "context"   => 'wrap',
        ]
    );

    // Close site-header
    genesis_markup(
        [
            'close'     => '</header>',
            'context'   => 'site-header',
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

function fi_add_search() {
    
    if ( function_exists( 'get_product_search_form' ) ) {

        get_product_search_form();

    } else {

        get_search_form();
        
    }
}