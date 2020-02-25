<?php  
/*
 *   Custom header functions
*/

//remove initial header functions
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_header' );

// add in new header markup - prefix function name fi_
add_action( 'genesis_header', 'fi_genesis_header_markup_open', 5 );
add_action( 'genesis_header', 'fi_genesis_header_markup_close', 20 );
add_action( 'genesis_header', 'fi_genesis_do_header');

// new header functions
function fi_genesis_header_markup_open() {

    genesis_markup( 
        [
            'html5'     => '<header %s>',
            'context'   => 'site-header',
        ]
    );

    genesis_structural_wrap( 'header' );
}

function fi_genesis_header_markup_close() {

    genesis_structural_wrap( 'header', 'close' );

    genesis_markup(
        [
            'close'     => '</header>',
            'context'   => 'site-header',
        ]
    );

}

function quote_list_container_open() {

    genesis_markup( 
        [
            'open'      => '<div>',
            'context'   => 'quote-list-container',
        ]
    );

}

function quote_list_container_close() {

    genesis_markup(
        [
            'close'     => '</div>',
            'context'   => 'quote-list-container',
        ]
    );
    
}


function fi_genesis_do_header() {

    genesis_markup( 
        [
            'open'      => '<div %s>',
            'context'   => 'title-area',
        ] 
    );

    do_action( 'genesis_site_title' );
    do_action( 'genesis_site_description' );

    genesis_markup(
        [
            'close'     => '</div>',
            'context'   => 'title-area',
        ]
    );

    if ( ! function_exists('get_product_search_form') ) {
        get_product_search_form();
    } else {
        get_search_form();
    }
    

    echo '<div class="quote-list-container"><a href="#">My Account</a> <a href="#">My Quote List</a></div>';

}
