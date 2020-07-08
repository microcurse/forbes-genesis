<?php

/**
 * Add metabox for post/page/product and portfolio
 * @since   6.0.0
 * @version 1.0.0
 * @param  array $meta_boxes
 * @return array
 */

add_action( 'cmb2_admin_init', 'etheme_base_metaboxes');

if( ! function_exists( 'etheme_base_metaboxes' ) ) :
    function etheme_base_metaboxes(){
        // Page/post metaboxes
        $cmb = new_cmb2_box( array(
            'id'           => 'page_layout',
            'title'        => esc_html__( 'Page Layout', 'woopress' ),
            'object_types' => array( 'page', 'post' ),
            'context'      => 'normal',
            'priority'     => 'low',
            'show_names'   => true,
        ) );
        $cmb->add_field( 
            array(
                'id'      => 'current_header_type',
                'name'    => esc_html__( 'Header type', 'woopress' ),
                'type'    => 'select',
                'options' => array(
                    0   => esc_html__( 'Default', 'woopress' ),
                    1   => esc_html__( 'Type 1', 'woopress' ),
                    2   => esc_html__( 'Type 2', 'woopress' ),
                    3   => esc_html__( 'Type 3', 'woopress' ),
                    4   => esc_html__( 'Type 4', 'woopress' ),
                    5   => esc_html__( 'Type 5', 'woopress' ),
                    6   => esc_html__( 'Type 6', 'woopress' ),
                    7   => esc_html__( 'Type 7', 'woopress' ),
                    8   => esc_html__( 'Type 8', 'woopress' ),
                    9   => esc_html__( 'Type 9', 'woopress' ),
                    10  => esc_html__( 'Type 10', 'woopress' ),
                    11  => esc_html__( 'Type 11', 'woopress' ),
                    12  => esc_html__( 'Type 12', 'woopress' ),
                    'vertical'  => esc_html__( 'Type 13', 'woopress' ),
                    'vertical2'  => esc_html__( 'Type 14', 'woopress' ),
                    15  => esc_html__( 'Type 15', 'woopress' ),
                    16  => esc_html__( 'Type 16', 'woopress' ),
                    17  => esc_html__( 'Type 17', 'woopress' ),
                    18  => esc_html__( 'Type 18', 'woopress' ),
                    19  => esc_html__( 'Type 19', 'woopress' )
	            )
            )
        );
        $cmb->add_field( 
            array(
                'id'      => 'current_custom_header',
                'name'    => esc_html__( 'Custom header', 'woopress' ),
                'type'    => 'select',
                'options' => et_get_redux_static_blocks( array( '' => esc_html__( 'Default', 'woopress' ) ) )
            )
        );
        $cmb->add_field( 
            array(
                'id'      => 'current_header_overlap',
                'name'    => esc_html__( 'Enable header overlap', 'woopress' ),
                'type'    => 'select',
                'options' => array(
                    false => esc_html__( 'Default', 'woopress' ),
                    'on'  => esc_html__( 'On', 'woopress' ),
                    'off' => esc_html__( 'Off', 'woopress' )
                )
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'sidebar_state',
                'name'    => esc_html__( 'Sidebar Position', 'woopress' ),
                'type'    => 'select',
                'options' => array(
                    ''        => esc_html__( 'Default', 'woopress' ),
                    'without' => esc_html__( 'Without Sidebar', 'woopress' ),
                    'left'    => esc_html__( 'Left Sidebar', 'woopress' ),
                    'right'   => esc_html__( 'Right Sidebar', 'woopress' )
                )
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'widget_area',
                'name'    => esc_html__( 'Widget Area', 'woopress' ),
                'type'    => 'select',
                'options' => etheme_get_sidebars()
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'sidebar_width',
                'name'    => esc_html__( 'Sidebar width', 'woopress' ),
                'type'    => 'select',
                'options' => array(
                    '' => esc_html__( 'Default', 'woopress' ),
                    2  => esc_html__( '1/6', 'woopress' ),
                    3  => esc_html__( '1/4', 'woopress' ),
                    4  => esc_html__( '1/3', 'woopress' )
                )
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'custom_nav',
                'name'    => esc_html__( 'Custom navigation for this page', 'woopress' ),
                'type'    => 'select',
                'options' => etheme_get_menus_options()
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'custom_nav_right',
                'name'    => esc_html__( 'Custom navigation right', 'woopress' ),
                'type'    => 'select',
                'options' => etheme_get_menus_options()
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'custom_nav_mobile',
                'name'    => esc_html__( 'Custom mobile navigation for this page', 'woopress' ),
                'type'    => 'select',
                'options' => etheme_get_menus_options()
            )
        );
        $cmb->add_field( 
            array(
                'id'          => 'one_page',
                'name'        => esc_html__('One page navigation', 'woopress'),
                'default'     => false,
                'type'        => 'checkbox'
            )
        );
        $cmb->add_field( 
            array(
                'id'          => 'full_page',
                'name'        => esc_html__('Full page sections', 'woopress'),
                'default'     => false,
                'type'        => 'checkbox'
            )
        );
        $cmb->add_field( 
            array(
                'id'          => 'page_background',
                'name'        => esc_html__('Page background', 'woopress'),
                'type'        => 'etheme_background'
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'page_heading',
                'name'    => esc_html__( 'Show Page Heading', 'woopress' ),
                'type'    => 'select',
                'options' => array(
                    'enable'  => esc_html__( 'Enable', 'woopress' ),
                    'disable' => esc_html__( 'Disable', 'woopress' )
                )
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'breadcrumb_type',
                'name'    => esc_html__( 'Breadcrumbs Style', 'woopress' ),
                'type'    => 'select',
                'options' => array(
                    ''  => esc_html__( 'Default', 'woopress' ),
                    '2' => esc_html__( 'Default left', 'woopress' ),
                    '3' => esc_html__( 'With background', 'woopress' ),
                    '4' => esc_html__( 'With background left', 'woopress' ),
                    '5' => esc_html__( 'Parallax', 'woopress' ),
                    '6' => esc_html__( 'Parallax left', 'woopress' ),
                    '7' => esc_html__( 'With animation', 'woopress' ),
                    '8' => esc_html__( 'Background large', 'woopress' ),
                    '9' => esc_html__( 'Disable', 'woopress' )
                )
            )
        );
        $cmb->add_field( 
            array(
                'id'    => 'custom_breadcrumbs_image',
                'name'  => esc_html__('Background image for breadcrumbs', 'woopress'),
                'type'  => 'file',
                //'allow' => array( 'url', 'attachment' )
            )
        );
        $cmb->add_field( 
            array(
                'id'      => 'custom_footer',
                'name'    => esc_html__( 'Use custom footer for this page', 'woopress' ),
                'type'    => 'select',
                'options' => et_get_redux_static_blocks(
                    array(
                        '' => esc_html__( 'Default', 'woopress' ),
                        'without' => esc_html__( 'Without', 'woopress' ) 
                    )
                )
            )
        );
        $cmb->add_field( 
            array(
                'id'    => 'custom_logo',
                'name'  => esc_html__('Logo image for this page', 'woopress'),
                'type'  => 'file',
            )
        );

        if( class_exists( 'RevSliderAdmin' ) ) {
            global $wpdb;

            $rs = $wpdb->get_results( "SELECT id, title, alias FROM ".$wpdb->prefix."revslider_sliders ORDER BY id ASC LIMIT 100" );
            $revsliders = array( 'no_slider' => esc_html__( 'No Slider', 'woopress' ) );

            foreach ( $rs as $slider ) {
                $revsliders[$slider->alias] = $slider->title;
            }

            $cmb->add_field( 
                array(
                    'id'      => 'page_slider',
                    'name'    => esc_html__( 'Show revolution slider instead of breadcrumbs and page title', 'woopress' ),
                    'type'    => 'select',
                    'options' => $revsliders
                )
            );
        }
        // End of the page/post metaboxes

        // Post metaboxes
        $cmb = new_cmb2_box( array(
            'id'           => 'post_layout',
            'title'        => esc_html__( 'Post Layout', 'woopress' ),
            'object_types' => array( 'post' ),
            'context'      => 'normal',
            'priority'     => 'low',
            'show_names'   => true,
        ) );
        $cmb->add_field( 
            array(
                'id'          => 'disable_featured',
                'name'        => esc_html__('Hide featured image', 'woopress'),
                'default'     => false,
                'type'        => 'checkbox'
            )
        );
        // End of the post metaboxes

        // Products metaboxes
        $cmb = new_cmb2_box( array(
            'id'           => 'product_options',
            'title'        => esc_html__( 'Additional product options [8theme]', 'woopress' ),
            'object_types' => array( 'product' ),
            'context'      => 'normal',
            'priority'     => 'low',
            'show_names'   => true,
        ) );
        $cmb->add_field( 
            array(
                'id'      => 'additional_block',
                'name'    => esc_html__( 'Additional information block', 'woopress' ),
                'type'    => 'select',
                'options' => et_get_redux_static_blocks( array( '' => esc_html__( '--choose--', 'woopress' ) ) )
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'product_new',
                'name'    => esc_html__( 'Mark product as "New"', 'woopress' ),
                'type'    => 'select',
                'options' => array(
                    'disable' => esc_html__( 'Choose', 'woopress' ),
                    'disable' => esc_html__( 'No', 'woopress' ),
                    'enable'  => esc_html__( 'Yes', 'woopress' ),
                )
            )
        );
        $cmb->add_field(
            array(
                'id'      => 'et_single_layout',
                'name'    => esc_html__( 'Single product layout', 'woopress' ),
                'type'    => 'select',
                'options' => array(
                    'inherit'  => esc_html__( 'Inherit', 'woopress' ),
                    'small' => esc_html__( 'Small', 'woopress' ),
                    'default' => esc_html__( 'Default', 'woopress' ),
                    'large'  => esc_html__( 'Large', 'woopress' ),
                    'fixed'  => esc_html__( 'Fixed', 'woopress' ),
                )
            )
        );
        $cmb->add_field( 
            array(
                'id'    => 'size_guide_img',
                'name'  => esc_html__('Size Guide img', 'woopress'),
                'type'  => 'file',
            )
        );
        $cmb->add_field( 
            array(
                'id'    => 'hover_img',
                'name'  => esc_html__('Upload image for hover effect', 'woopress'),
                'type'  => 'file',
            )
        );
        $cmb->add_field( 
            array(
                'id'   => 'custom_tab1_title',
                'name' => esc_html__( 'Custom tab title', 'woopress' ),
                'type' => 'text',
            )
        );
        $cmb->add_field( 
            array(
                'id'   => 'custom_tab1',
                'name' => esc_html__( 'Text for custom tab', 'woopress' ),
                'type' => 'textarea',
            )
        );
        // End of the products metaboxes

        // Portfolio metaboxes
        $cmb = new_cmb2_box( array(
            'id'           => 'project_options',
            'title'        => esc_html__( 'Additional project information', 'woopress' ),
            'object_types' => array( 'etheme_portfolio' ),
            'context'      => 'normal',
            'priority'     => 'low',
            'show_names'   => true,
        ) );
        $cmb->add_field( 
            array(
                'id'   => 'project_url',
                'name' => esc_html__( 'Project Url', 'woopress' ),
                'type' => 'text',
            )
        );
        $cmb->add_field( 
            array(
                'id'   => 'client',
                'name' => esc_html__( 'Client', 'woopress' ),
                'type' => 'text',
            )
        );
        $cmb->add_field( 
            array(
                'id'   => 'client_url',
                'name' => esc_html__( 'Client Url', 'woopress' ),
                'type' => 'text',
            )
        );
        $cmb->add_field( 
            array(
                'id'   => 'copyright',
                'name' => esc_html__( 'Copyright', 'woopress' ),
                'type' => 'text',
            )
        );
        $cmb->add_field( 
            array(
                'id'   => 'copyright_url',
                'name' => esc_html__( 'Copyright Url', 'woopress' ),
                'type' => 'text',
            )
        );
        // End of the portfolio metaboxes
    }
endif;