<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "woopress_redux_options";

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    if ( is_child_theme() ) {

      $version = wp_get_theme( 'woopress' )->version . ' (child  ' . $theme->get( 'Version' ) . ')';
    
    } else {

      $version = $theme->get( 'Version' );

    }

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => 'v.' . $version,
        // Version that appears at the top of your panel
        'menu_type'            => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => false,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'WooPress Options', 'woopress' ),
        'page_title'           => esc_html__( 'WooPress Options', 'woopress' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyAQfU06oWILM-BWrP3pLFc6Pu9dcXASkTU',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => 59,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => ETHEME_CODE_IMAGES_URL . '/etheme.png',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '_options',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,

        'show_options_object' => false,

        'templates_path' => trailingslashit(ETHEME_CODE_DIR) . 'options-framework/templates/',

        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // **************************************************************************************************** //
    // ! Custom fonts
    // **************************************************************************************************** //

    // ! Get standard redux font list
    $std_fonts = array(
        "Arial, Helvetica, sans-serif"                         => "Arial, Helvetica, sans-serif",
        "'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
        "'Bookman Old Style', serif"                           => "'Bookman Old Style', serif",
        "'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive",
        "Courier, monospace"                                   => "Courier, monospace",
        "Garamond, serif"                                      => "Garamond, serif",
        "Georgia, serif"                                       => "Georgia, serif",
        "Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
        "'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace",
        "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
        "'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif",
        "'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif",
        "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
        "Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif",
        "'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif",
        "'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
        "Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif",
    );

    // ! Get custom fonts list
    $fonts = get_option( 'etheme-fonts', false );

    if ( $fonts ) {
        $valid_fonts = array();
        foreach ( $fonts as $value ) {
            $valid_fonts[$value['name']] = $value['name'];
        }
        $fonts_list = array_merge( $std_fonts, $valid_fonts );
    } else {
        $fonts_list = '';
    }

    Redux::setArgs( $opt_name, $args );
    

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // general
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('General', 'woopress'),
        'id'               => 'general',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-admin-multisite',
        'fields' => array(
            array (
                'id'       => 'main_layout',
                'type'     => 'select',
                'title'    => esc_html__( 'Site Layout', 'woopress' ),
                'subtitle' => esc_html__( 'Choose the type of layout you want your site to display.', 'woopress' ),
                'options'  => array (
                    'wide'     => esc_html__( 'Wide', 'woopress' ),
                    'boxed'    => esc_html__( 'Boxed', 'woopress' ),
                    'bordered' => esc_html__( 'Bordered', 'woopress' ),
                ),
                'default'  => 'wide'
            ),
            array(
                'id'            => 'site_width',
                'type'          => 'slider',
                'title'         => esc_html__( 'Site Width', 'woopress' ),
                'subtitle'      => esc_html__( 'Site Width.', 'woopress' ),
                'default'       => 1170,
                'min'           => 970,
                'step'          => 1,
                'max'           => 3000,
                'display_value' => 'text'
            ),
            array(
                'id'       => 'loader',
                'type'     => 'switch',
                'title'    => esc_html__( 'Loader', 'woopress' ),
                'subtitle' => esc_html__( 'Show loader icon until site loading.', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'to_top',
                'type'     => 'switch',
                'title'    => esc_html__( '"Back To Top" button', 'woopress' ),
                'subtitle' => esc_html__( 'Show "Back To Top" button.', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'to_top_mobile',
                'type'     => 'switch',
                'title'    => esc_html__( '"Back To Top" button on mobile', 'woopress' ),
                'subtitle' => esc_html__( 'Show "Back To Top" button on mobile.', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'disable_right_click',
                'type'     => 'switch',
                'title'    => esc_html__( 'Disable right mouse click', 'woopress' ),
                'subtitle' => esc_html__( 'Disable right mouse click on the site.', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'right_click_html',
                'type'     => 'textarea',
                'title'    => esc_html__( 'Mouse right button click html', 'woopress' ),
                'subtitle' => esc_html__( 'HTML code that shows when you click mouse right button on the site.', 'woopress' ),
                'default'  => '',
            ),
            array(
                'id'       => 'google_code',
                'type'     => 'textarea',
                'title'    => esc_html__( 'Google Analytics Code', 'woopress' ),
                'default'  => '',
            ),
            array(
                'id'       => 'disable_og_tags',
                'type'     => 'switch',
                'title'    => esc_html__( 'Disable default Open Graph meta tags', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'enable_hatom_meta',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hatom meta in post content', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'force_addons_css',
                'type'     => 'switch',
                'title'    => esc_html__( 'Include styles from "Ultimate Addons for WPBakery page builder" on every page', 'woopress' ),
                'default'  => false,
            ),
        )
    ) );
    //! general
    
    

    // styling
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Styling', 'woopress'),
        'id'               => 'styling',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-admin-customizer',
        'fields' => array(
            array(
                'id'       => 'activecol',
                'type'     => 'color',
                'transparent' => false,
                // 'output'   => array( '.site-title' ),
                'title'    => esc_html__( 'Main Color', 'woopress' ),
                'default'  => '#e5534c',
            ),
            array(
                'id'       => 'background_img',
                'type'     => 'background',
                // 'output'   => array( 'body' ),
                'title'    => esc_html__( 'Site Background', 'woopress' ),
                'default'   => '',
            ),
            array(
                'id'       => 'transparent_container',
                'type'     => 'switch',
                'title'    => esc_html__( 'Transparent container', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'header_bg',
                'type'     => 'background',
                // 'output'   => array( 'body' ),
                'title'    => esc_html__( 'Header background', 'woopress' ),
                'default'   => '',
            ),
            array(
                'id'       => 'fixed_header_bg',
                'type'     => 'background',
                // 'output'   => array( 'body' ),
                'title'    => esc_html__( 'Fixed header background', 'woopress' ),
                'default'   => '',
            ),
            array(
                'id'       => 'header_transparent',
                'type'     => 'switch',
                'title'    => esc_html__( 'Header transparent', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'menu_bg',
                'type'     => 'background',
                // 'output'   => array( 'body' ),
                'title'    => esc_html__( 'Menu background (Only for 6,7,8,10 header types)', 'woopress' ),
                'default'   => '',
            ),

        )
    ) );
    //! styling


    // typography
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Typography', 'woopress'),
        'id'               => 'typography',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-editor-spellcheck'
    ) );


    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Page content', 'woopress'),
        'id'               => 'setting_page_content',
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields' => array(
            array(
                'id'     => 'mainfont',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'Main Font', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
                // 'output' => array('h1, h2, h3, h4'),
            ),
            array(
                'id'     => 'sfont',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'Body Font', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
            ),
            array(
                'id'     => 'sfont',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'text-transform' => true,
                'letter-spacing' => true,
                'title'  => esc_html__( 'Body Font', 'woopress' ),
                'google' => true,
            ),
            array(
                'id'     => 'h1',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'H1', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
            ),
            array(
                'id'     => 'h2',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'H2', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
            ),
            array(
                'id'     => 'h3',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'H3', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
            ),
            array(
                'id'     => 'h4',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'H4', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
            ),
            array(
                'id'     => 'h5',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'H5', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
            ),
            array(
                'id'     => 'h6',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'H6', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
            ),
            array (
                'id'       => 'default_fonts',
                'type'     => 'select',
                'title'    => esc_html__( 'Default fonts', 'woopress' ),
                'options'  => array (
                    'enable'  => esc_html__( 'Enable', 'woopress' ),
                    'disable' => esc_html__( 'Disable', 'woopress' ),
                ),
                'default'  => 'enable'
            ),
            
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Menu', 'woopress'),
        'id'               => 'setting_menu_content',
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields' => array(
            array(
                'id'     => 'menufont',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'Menu 1 level', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
                // 'output' => array('h1, h2, h3, h4'),
            ),
            array(
                'id'       => 'menufont_link_color',
                'type'     => 'link_color',
                'title'    => esc_html__( 'Header Menu Colors', 'woopress' ),
                // 'subtitle' => __( 'Only color validation can be done on this field type', 'redux-framework-demo' ),
                // 'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                'regular'   => false, // Disable Regular Color
                //'hover'     => false, // Disable Hover Color
                //'active'    => false, // Disable Active Color
                //'visited'   => true,  // Enable Visited Color
            ),
            array(
                'id'       => 'fixed_menufont_link_color',
                'type'     => 'link_color',
                'title'    => esc_html__( 'Fixed Header Menu 1 level Colors', 'woopress' ),
            ),
            array(
                'id'     => 'menufont_2',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'Menu 2 level (mega menu column titles)', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
                // 'output' => array('h1, h2, h3, h4'),
            ),
            array(
                'id'       => 'menufont_2_link_color',
                'type'     => 'link_color',
                'title'    => esc_html__( 'Fixed Header Menu 2 level Colors', 'woopress' ),
                'regular'   => false, // Disable Regular Color
            ),
            array(
                'id'       => 'fixed_menufont_2',
                'type'     => 'link_color',
                'title'    => esc_html__( 'Fixed Header Menu 2 level (mega menu column titles)', 'woopress' ),
            ),
            array(
                'id'     => 'menufont_3',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'Menu 3 level and dropdowns', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
                // 'output' => array('h1, h2, h3, h4'),
            ),
            array(
                'id'       => 'menufont_3_link_color',
                'type'     => 'link_color',
                'title'    => esc_html__( 'Fixed Header Menu 3 level Colors', 'woopress' ),
                'regular'   => false, // Disable Regular Color
            ),
            array(
                'id'       => 'fixed_menufont_3',
                'type'     => 'link_color',
                'title'    => esc_html__( 'Fixed Header Menu 3 level', 'woopress' ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Breadcrumbs', 'woopress'),
        'id'               => 'setting_breadcrumbs_content',
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields' => array(
            array(
                'id'     => 'pade_heading',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'Page heading title', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
                // 'output' => array('h1, h2, h3, h4'),
            ),
            array(
                'id'     => 'breadcrumbs',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( 'Breadcrumbs font', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
                // 'output' => array('h1, h2, h3, h4'),
            ),
            array(
                'id'     => 'breadcrumbs_return',
                'type'   => 'typography',
                'fonts'  => $fonts_list,
                'title'  => esc_html__( '"Return to previous page"', 'woopress' ),
                'google' => true,
                'text-transform' => true,
                'letter-spacing' => true,
                // 'output' => array('h1, h2, h3, h4'),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Custom fonts', 'woopress'),
        'id'               => 'setting_custom_fonts',
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields' => array(
            array(
                'id'       => 'custom_fonts',
                'type'     => 'fonts_uploader',
                'title'    => esc_html__( 'Custom Fonts', 'woopress' ),
            ),
        )
    ) );

    //! typography

    // header_types
    $statick_blocks = array( '' => '--choose--' );
    $statick_blocks = array_merge($statick_blocks, et_get_redux_static_blocks());

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Header Types', 'woopress'),
        'id'               => 'header_types',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-excerpt-view',
        'fields'     => array(
            array(
                'id'       => 'header_type',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Header Type', 'woopress' ),
                'options'  => array(
                    '1' => array(
                        'alt' => 'Default',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/1.jpg'
                    ),
                    '2' => array(
                        'alt' => 'Variant 2',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/2.jpg'
                    ),
                    '3' => array(
                        'alt' => 'Variant 3',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/3.jpg'
                    ),
                    '4' => array(
                        'alt' => 'Variant 4',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/4.jpg'
                    ),
                    '5' => array(
                        'alt' => 'Variant 5',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/5.jpg'
                    ),
                    '6' => array(
                        'alt' => 'Variant 6',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/6.jpg'
                    ),
                    '7' => array(
                        'alt' => 'Variant 7',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/7.jpg'
                    ),
                    '8' => array(
                        'alt' => 'Variant 8',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/8.jpg'
                    ),
                    '9' => array(
                        'alt' => 'Variant 9',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/9.jpg'
                    ),
                    '10' => array(
                        'alt' => 'Variant 10',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/10.jpg'
                    ),
                    '11' => array(
                        'alt' => 'Variant 11',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/11.jpg'
                    ),
                    '12' => array(
                        'alt' => 'Variant 12',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/12.jpg'
                    ),
                    'vertical' => array(
                        'alt' => 'Variant 13',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/13.jpg'
                    ),
                    'vertical2' => array(
                        'alt' => 'Variant 14',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/14.jpg'
                    ),
                    '15' => array(
                        'alt' => 'Variant 15',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/15.jpg'
                    ),
                    '16' => array(
                        'alt' => 'Variant 16',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/16.jpg'
                    ),
                    '17' => array(
                        'alt' => 'Variant 17',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/17.jpg'
                    ),
                    '18' => array(
                        'alt' => 'Variant 18',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/18.jpg'
                    ),
                    '19' => array(
                        'alt' => 'Variant 19',
                        'img'     => ETHEME_THEME_ASSETS . '/images/headers/19.jpg'
                    ),
                ),
                'default'  => '1'
            ),
            array (
                'id'       => 'custom_header',
                'type'     => 'select',
                'title'    => esc_html__( 'Custom Header', 'woopress' ),
                'subtitle' => esc_html__('Use the static block to create custom header layout.', 'woopress'),
                'options'  => $statick_blocks,
            ),
        )
    ) );
    //! header_types


    // header_Settings
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Header Settings', 'woopress'),
        'id'               => 'header_settings',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-welcome-widgets-menus'
    ) );
    //! header_Settings

    // header_Settings
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Main header area', 'woopress'),
        'id'               => 'main_header_area',
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields' => array(
            array(
                'id'       => 'logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Logo image', 'woopress' ),
                'compiler' => 'true',
                'subtitle' => esc_html__('Upload image: png, jpg or gif file.', 'woopress'),
            ),
            array(
                'id'       => 'logo_fixed',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Logo image for fixed header', 'woopress' ),
                'compiler' => 'true',
                'subtitle' => esc_html__('Upload image: png, jpg or gif file.', 'woopress'),
            ),
            array(
                'id'       => 'favicon',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Favicon', 'woopress' ),
                'compiler' => 'true',
                'subtitle' => esc_html__('Upload image: png, jpg or gif file.', 'woopress'),
            ),
            array(
                'id'       => 'header_overlap',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable header overlap', 'woopress' ),
                'default'  => false,
            ),
            array (
                'id'       => 'header_colors',
                'type'     => 'select',
                'title'    => esc_html__( 'Header color scheme', 'woopress' ),
                'options'  => array (
                    'light' => esc_html__( 'Light', 'woopress' ),
                    'dark'  => esc_html__( 'Dark', 'woopress' ),
                ),
                'default'  => 'dark'
            ),
            array(
                'id'       => 'fixed_nav_sw',
                'type'     => 'switch',
                'title'    => esc_html__( 'Fixed navigation', 'woopress' ),
                'default'  => false,
            ),
            array (
                'id'       => 'fixed_header_colors',
                'type'     => 'select',
                'title'    => esc_html__( 'Fixed header color scheme', 'woopress' ),
                'options'  => array (
                    'light' => esc_html__( 'Light', 'woopress' ),
                    'dark'  => esc_html__( 'Dark', 'woopress' ),
                ),
                'default'  => 'dark',
                'required' => array( 'fixed_nav_sw', '=', true )
            ),
            array(
                'id'       => 'cart_widget_sw',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable cart widget', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'top_cart_item',
                'type'     => 'text',
                'title'    => 'Number of items in top cart drop-down',
                'default'  => 3,
                'required' => array( 'cart_widget_sw', '=', true )
            ),
            array(
                'id'       => 'top_cart_icon',
                'type'     => 'text',
                'title'    => 'Top cart icon',
                'subtitle' => esc_html__('Only from "Font Awesome". For example "shopping-bag".', 'woopress'),
                'default'  => '',
                'required' => array( 'cart_widget_sw', '=', true )
            ),
            array(
                'id'       => 'top_cart_icon_size',
                'type'     => 'text',
                'title'    => 'Top cart icon size',
                'subtitle' => esc_html__('Only for custom icon. For example "25px".', 'woopress'),
                'default'  => '',
                'required' => array( 'cart_widget_sw', '=', true )
            ),
            array(
                'id'       => 'favicon_badge',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show products in cart count on the favicon', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'search_form_sw',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable search form in header', 'woopress' ),
                'default'  => false,
            ),
            array (
                'id'       => 'search_view',
                'type'     => 'select',
                'title'    => esc_html__( 'Search view', 'woopress' ),
                'options'  => array (
                    'modal' => esc_html__( 'Popup window', 'woopress' ),
                    'form'  => esc_html__( 'Form on hover', 'woopress' ),
                ),
                'default'  => 'modal',
                'required' => array( 'search_form_sw', '=', true )
            ),
            array (
                'id'       => 'search_post_type',
                'type'     => 'select',
                'title'    => esc_html__( 'Search post type', 'woopress' ),
                'options'  => array (
                    'product' => esc_html__( 'Product', 'woopress' ),
                    'post'    => esc_html__( 'Post and page', 'woopress' ),
                ),
                'default'  => 'product',
                'required' => array( 'search_form_sw', '=', true )
            ),
            array(
                'id'       => 'header_custom_block',
                'type'     => 'editor',
                'title'    => esc_html__( 'Header custom HTML (for 6, 7, 13, 14, 18 headers)', 'woopress' ),
                'default'  => '[share]',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Top bar', 'woopress'),
        'id'               => 'top_bar_area',
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields' => array(
            array(
                'id'       => 'top_bar_sw',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable top bar', 'woopress' ),
                'default'  => true,
            ),
            array (
                'id'       => 'top_bar_colors',
                'type'     => 'select',
                'title'    => esc_html__( 'Tob bar color scheme', 'woopress' ),
                'options'  => array (
                    'default' => esc_html__( 'Default', 'woopress' ),
                    'light'   => esc_html__( 'Light', 'woopress' ),
                    'dark'    => esc_html__( 'Dark', 'woopress' ),
                ),
                'default'  => 'default',
                'required' => array( 'top_bar_sw', '=', true )
            ),
            array(
                'id'       => 'top_bar_bg',
                'type'     => 'background',
                'title'    => esc_html__( 'Top bar background', 'woopress' ),
                'default'   => '',
                'required' => array( 'top_bar_sw', '=', true )
            ),
            array(
                'id'       => 'top_links',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable top links (Register | Sign In)', 'woopress' ),
                'default'  => true,
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Breadcrumbs', 'woopress'),
        'id'               => 'breadcrumbs_area',
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields'           => array(
            array (
                'id'       => 'breadcrumb_type',
                'type'     => 'select',
                'title'    => esc_html__( 'Breadcrumbs Style', 'woopress' ),
                'options'  => array (
                    '1' => esc_html__( 'Default', 'woopress' ),
                    '2' => esc_html__( 'Default left', 'woopress' ),
                    '3' => esc_html__( 'With background', 'woopress' ),
                    '4' => esc_html__( 'With background left', 'woopress' ),
                    '5' => esc_html__( 'Parallax', 'woopress' ),
                    '6' => esc_html__( 'Parallax left', 'woopress' ),
                    '7' => esc_html__( 'With animation', 'woopress' ),
                    '8' => esc_html__( 'Background large', 'woopress' ),
                    '9' => esc_html__( 'Disable', 'woopress' ),
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'breadcrumb_bg',
                'type'     => 'background',
                'title'    => esc_html__( 'Breadcrumbs background', 'woopress' ),
                'default'   => '',
            ),
            array(
                'id'       => 'breadcrumb_padding',
                'type'     => 'spacing',
                // 'output'   => array( '.site-header' ),
                'mode'     => 'padding',
                'all'      => false,
                'units'          => array( 'em', 'px', '%' ),
                'units_extended' => 'true',
                'title'    => esc_html__( 'Breadcrumbs Padding', 'woopress' ),
                'default'  => array(
                    'padding-top'    => '',
                    'padding-right'  => '',
                    'padding-bottom' => '',
                    'padding-left'   => ''
                )
            ),
        )
    ) );
    //! header_Settings


    // Footer
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Footer', 'woopress'),
        'id'               => 'footer',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-tagcloud',
        'fields'           => array(
            array(
                'id'       => 'footer_demo',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show footer demo blocks', 'woopress' ),
                'subtitle' => esc_html__('Will be shown if footer sidebars are empty.', 'woopress'),
                'default'  => true,
            ),
            array(
                'id'       => 'prefooter_bg',
                'type'     => 'color',
                // 'output'   => array( '.site-title' ),
                'title'    => esc_html__( 'Footer 1 Background Color', 'woopress' ),
                'default'  => '',
            ),
            array (
                'id'       => 'footer_text_color',
                'type'     => 'select',
                'title'    => esc_html__( 'Footer text color', 'woopress' ),
                // 'class'=> 'prodcuts_per_row'
                'options'  => array (
                    'default' => esc_html__( 'Default', 'woopress' ),
                    'dark'    => esc_html__( 'Dark', 'woopress' ),
                    'light'   => esc_html__( 'Light', 'woopress' ),
                ),
                'default'  => 'default'
            ),
            array(
                'id'       => 'footer1_padding',
                'type'     => 'spacing',
                // 'output'   => array( '.site-header' ),
                'mode'     => 'padding',
                'all'      => false,
                'units'          => array( 'em', 'px', '%' ),
                'units_extended' => 'true',
                'title'    => esc_html__( 'Footer 1 Padding', 'woopress' ),
                'default'  => array(
                    'padding-top'    => '',
                    'padding-right'  => '',
                    'padding-bottom' => '',
                    'padding-left'   => ''
                )
            ),
            array (
                'id'       => 'footer_text_color',
                'type'     => 'select',
                'title'    => esc_html__( 'Footer text color', 'woopress' ),
                // 'class'=> 'prodcuts_per_row'
                'options'  => array (
                    'default' => esc_html__( 'Default', 'woopress' ),
                    'dark'    => esc_html__( 'Dark', 'woopress' ),
                    'light'   => esc_html__( 'Light', 'woopress' ),
                ),
                'default'  => 'default'
            ),
            array(
                'id'       => 'footer_bg',
                'type'     => 'color',
                // 'output'   => array( '.site-title' ),
                'title'    => esc_html__( 'Footer 2 Background Color', 'woopress' ),
                'default'  => '',
            ),
            array(
                'id'       => 'footer_padding',
                'type'     => 'spacing',
                // 'output'   => array( '.site-header' ),
                'mode'     => 'padding',
                'all'      => false,
                'units'          => array( 'em', 'px', '%' ),
                'units_extended' => 'true',
                'title'    => esc_html__( 'Footer 2 Padding', 'woopress' ),
                'default'  => array(
                    'padding-top'    => '',
                    'padding-right'  => '',
                    'padding-bottom' => '',
                    'padding-left'   => ''
                )
            ),
            array(
                'id'       => 'copyright_bg',
                'type'     => 'color',
                // 'output'   => array( '.site-title' ),
                'title'    => esc_html__( 'Copyright Background Color', 'woopress' ),
                'default'  => '',
            ),
            array(
                'id'       => 'copyrights_padding',
                'type'     => 'spacing',
                // 'output'   => array( '.site-header' ),
                'mode'     => 'padding',
                'all'      => false,
                'units'          => array( 'em', 'px', '%' ),
                'units_extended' => 'true',
                'title'    => esc_html__( 'Copyrights Padding', 'woopress' ),
                'default'  => array(
                    'padding-top'    => '',
                    'padding-right'  => '',
                    'padding-bottom' => '',
                    'padding-left'   => ''
                )
            ),
            array(
                'id'       => 'footer_type',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Footer Type', 'woopress' ),
                'options'  => array(
                    '3' => array(
                        'alt' => 'Variant 3',
                        'img'     => ETHEME_THEME_ASSETS . '/images/footer_v3.jpg'
                    ),
                    '2' => array(
                        'alt' => 'Variant 2',
                        'img'     => ETHEME_THEME_ASSETS . '/images/footer_v2.jpg'
                    ),
                    '1' => array(
                        'alt' => 'Default',
                        'img'     => ETHEME_THEME_ASSETS . '/images/footer_v1.jpg'
                    ),
                ),
                'default'  => '3'
            ),
        )
    ) );
    //! Footer


    // shop
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Shop', 'woopress'),
        'id'               => 'shop',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-cart',
        'fields'           => array(
            array(
                'id'       => 'shop_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full width', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'just_catalog',
                'type'     => 'switch',
                'title'    => esc_html__( 'Just Catalog', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'cats_accordion',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Navigation Accordion', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'new_icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable "NEW" icon', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'out_of_icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable "Out of stock" icon', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'sale_icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable "Sale" icon" icon', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'first_category_item',
                'type'     => 'switch',
                'title'    => esc_html__( 'Open first category item by default', 'woopress' ),
                'default'  => false,
            ),
            array (
                'id'       => 'product_banner_position',
                'type'     => 'select',
                'title'    => esc_html__( 'Product banner position', 'woopress' ),
                'options'  => array (
                    'top'    => esc_html__( 'Top', 'woopress' ),
                    'bottom' => esc_html__( 'Bottom', 'woopress' ),
                ),
                'default'  => 'top'
            ),
            array(
                'id'       => 'product_bage_banner',
                'type'     => 'editor',
                'title'    => esc_html__( 'Product Page Banner', 'woopress' ),
                'default'  => '<p><img src="' . get_template_directory_uri() . '/images/assets/shop-banner.jpg" /></p>',
            ),
            array(
                'id'       => 'empty_cart_content',
                'type'     => 'editor',
                'title'    => esc_html__( 'Text for empty cart', 'woopress' ),
                'default'  => '<h2>Your cart is currently empty</h2><p>You have not added any items in your shopping cart</p>',
            ),
        )
    ) );
    //! shop


    // product_archive
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Products Page Layout', 'woopress'),
        'id'               => 'product_archive',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-screenoptions',
        'fields'           => array(
            array (
                'id'       => 'view_mode',
                'type'     => 'select',
                'title'    => esc_html__( 'Products view mode', 'woopress' ),
                'options'  => array (
                    'grid_list' => esc_html__( 'Grid/List', 'woopress' ),
                    'list_grid' => esc_html__( 'List/Grid', 'woopress' ),
                    'grid'      => esc_html__( 'Only Grid', 'woopress' ),
                    'list'      => esc_html__( 'Only List', 'woopress' ),
                ),
                'default'  => 'grid_list'
            ),
            array(
                'id'       => 'products_per_page',
                'type'     => 'text',
                'title'    => esc_html__( 'Products per page', 'woopress' ),
                'default'  => 12,
            ),
            array(
                'id'       => 'sidebar_hidden',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hidden sidebar', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'grid_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Layout', 'woopress' ),
                'subtitle' => esc_html__( 'Sidebar position.', 'woopress' ),
                'options'  => array(
                    'without' => array(
                        'alt' => 'without',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/full-width.png'
                    ),
                    'left' => array(
                        'alt' => 'left',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/left-sidebar.png'
                    ),
                    'right' => array(
                        'alt' => 'right',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/right-sidebar.png'
                    ),
                ),
                'default'  => 'left'
            ),
            array (
                'id'       => 'product_img_hover',
                'type'     => 'select',
                'title'    => esc_html__( 'Product Image Hover', 'woopress' ),
                'options'  => array (
                    'disable' => esc_html__( 'Disable', 'woopress' ),
                    'swap'    => esc_html__( 'Swap', 'woopress' ),
                    'slider'  => esc_html__( 'Images Slider', 'woopress' ),
                    'mask'    => esc_html__( 'Mask with information', 'woopress' ),
                ),
                'default'  => 'slider'
            ),
            array(
                'id'       => 'product_page_productname',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show product name', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product_page_cats',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show product categories', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product_page_price',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Price', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product_page_addtocart',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show "Add to cart" button', 'woopress' ),
                'default'  => true,
            ),
            array (
                'id'       => 'shop_sidebar_responsive',
                'type'     => 'select',
                'title'    => esc_html__( 'Sidebar position for responsive layout', 'woopress' ),
                'options'  => array (
                    'top'    => esc_html__( 'Top', 'woopress' ),
                    'bottom' => esc_html__( 'Bottom', 'woopress' ),
                ),
                'default'  => 'bottom'
            ),
            array (
                'id'       => 'category_archive_desc_position',
                'type'     => 'select',
                'title'    => esc_html__( 'Category description position', 'woopress' ),
                'options'  => array (
                    'top'    => esc_html__( 'Top', 'woopress' ),
                    'bottom' => esc_html__( 'Bottom', 'woopress' ),
                ),
                'default'  => 'top'
            ),
            array(
                'id'       => 'shop_sidebar_responsive_display',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sidebar by click on mobile', 'woopress' ),
                'default'  => false,
            ),
        )
    ) );
    //! product_archive


    // single_product
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Single Product', 'woopress'),
        'id'               => 'single_product',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-id',
        'fields'           => array(
            array(
                'id'       => 'single_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar position', 'woopress' ),
                'options'  => array(
                    'without' => array(
                        'alt' => 'without',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/full-width.png'
                    ),
                    'left' => array(
                        'alt' => 'left',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/left-sidebar.png'
                    ),
                    'right' => array(
                        'alt' => 'right',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/right-sidebar.png'
                    ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'single_product_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Single product layout', 'woopress' ),
                'options'  => array(
                    'small' => array(
                        'alt' => 'small',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/product-small.png'
                    ),
                    'default' => array(
                        'alt' => 'default',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/product-medium.png'
                    ),
                    'large' => array(
                        'alt' => 'large',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/product-large.png'
                    ),
                    'fixed' => array(
                        'alt' => 'fixed',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/product-fixed.png'
                    ),
                ),
                'default'  => 'default'
            ),
            array(
                'id'       => 'images_sliders',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable slider for gallery images', 'woopress' ),
                'default'  => true,
            ),
            array (
                'id'       => 'carousel_direction',
                'type'     => 'select',
                'title'    => esc_html__( 'Gallery Images', 'woopress' ),
                'options'  => array (
                    'horizontal' => esc_html__( 'Horizontal', 'woopress' ),
                    'vertical'   => esc_html__( 'Vertical', 'woopress' )
                ),
                'default'  => 'horizontal'
            ),
            array(
                'id'       => 'carousel_items',
                'type'     => 'text',
                'title'    => esc_html__( 'Slides per view', 'woopress' ),
                'subtitle' => esc_html__( 'Example: 3 (min 1, max 10).', 'woopress'),
                'default'  => 3,
            ),
            array (
                'id'       => 'tabs_location',
                'type'     => 'select',
                'title'    => esc_html__( 'Location of product tabs', 'woopress' ),
                'options'  => array (
                    'after_image'   => esc_html__( 'Next to image', 'woopress' ),
                    'after_content' => esc_html__( 'Under content', 'woopress' )
                ),
                'default'  => 'after_content'
            ),
            array (
                'id'       => 'upsell_location',
                'type'     => 'select',
                'title'    => esc_html__( 'Location of upsell products', 'woopress' ),
                'options'  => array (
                    'sidebar'       => esc_html__( 'Sidebar', 'woopress' ),
                    'after_content' => esc_html__( 'After content', 'woopress' )
                ),
                'default'  => 'sidebar'
            ),
            array(
                'id'       => 'show_product_title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Product Title', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'show_related',
                'type'     => 'switch',
                'title'    => esc_html__( 'Display related products', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'related_posts_per_page',
                'type'     => 'text',
                'title'    => esc_html__( 'Related products per page', 'woopress' ),
                'subtitle' => esc_html__( 'Example: 15.', 'woopress'),
                'default'  => 15,
            ),
            array(
                'id'       => 'ajax_addtocart',
                'type'     => 'switch',
                'title'    => esc_html__( 'Ajax "Add To Cart"', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'gallery_lightbox',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Lightbox for Product Images', 'woopress' ),
                'default'  => true,
            ),
            array (
                'id'       => 'zoom_effect',
                'type'     => 'select',
                'title'    => esc_html__( 'Zoom effect', 'woopress' ),
                'options'  => array (
                    'disable' => esc_html__( 'Disable', 'woopress' ),
                    'lens'    => esc_html__( 'Lens', 'woopress' ),
                    'window'  => esc_html__( 'Window', 'woopress' )
                ),
                'default'  => 'window'
            ),
            array (
                'id'       => 'tabs_type',
                'type'     => 'select',
                'title'    => esc_html__( 'Tabs type', 'woopress' ),
                'options'  => array (
                    'tabs-default' => esc_html__( 'Default', 'woopress' ),
                    'left-bar'     => esc_html__( 'Left bar', 'woopress' ),
                    'right-bar'    => esc_html__( 'Right bar', 'woopress' ),
                    'accordion'    => esc_html__( 'Accordion', 'woopress' ),
                    'disable'      => esc_html__( 'Disable', 'woopress' )
                ),
                'default'  => 'tabs-default'
            ),
            array(
                'id'       => 'first_tab',
                'type'     => 'switch',
                'title'    => esc_html__( 'Close first tab by default', 'woopress' ),
                'default'  => false,
            ),
            array (
                'id'       => 'reviews_position',
                'type'     => 'select',
                'title'    => esc_html__( 'Reviews position', 'woopress' ),
                'options'  => array (
                    'tabs'    => esc_html__( 'Tabs', 'woopress' ),
                    'outside' => esc_html__( 'Next to tabs', 'woopress' )
                ),
                'default'  => 'tabs'
            ),
            array(
                'id'       => 'single_sidebar_responsive_display',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sidebar by click on mobile', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'share_icons',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show share buttons', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'custom_tab_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Tab Title', 'woopress' ),
                'default'  => 'Returns & Delivery',
            ),
            array(
                'id'       => 'custom_tab',
                'type'     => 'editor',
                'title'    => esc_html__( 'Return', 'woopress' ),
                'subtitle' => esc_html__( 'Enter custom content you would like to output to the product custom tab (for all products).', 'woopress'),
                'default'  => '[row][column size="one-half"]<h5>Returns and Exchanges</h5><p>There are a few important things to keep in mind when returning a product you purchased.You can return unwanted items by post within 7 working days of receipt of your goods.</p>[checklist style="arrow"]<ul><li>You have 14 calendar days to return an item from the date you received it. </li><li>Only items that have been purchased directly from Us.</li><li>Please ensure that the item you are returning is repackaged with all elements.</li></ul>[/checklist] [/column][column size="one-half"]<h5>Ship your item back to Us</h5>Firstly Print and return this Returns Form to:<br /> <p>30 South Park Avenue, San Francisco, CA 94108, USA<br /> Please remember to ensure that the item you are returning is repackaged with all elements.</p><br /> <span class="underline">For more information, view our full Returns and Exchanges information.</span>[/column][/row]',
            ),
        )
    ) );
    //! single_product


    // quick_view
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Quick View', 'woopress'),
        'id'               => 'quick_view',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-visibility',
        'fields'           => array(
            array(
                'id'       => 'quick_view',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable quick view', 'woopress' ),
                'default'  => true,
            ),
            array (
                'id'       => 'quick_images',
                'type'     => 'select',
                'title'    => esc_html__( 'Product images', 'woopress' ),
                'options'  => array (
                    'none'   => esc_html__( 'None', 'woopress' ),
                    'slider' => esc_html__( 'Slider', 'woopress' ),
                    'single' => esc_html__( 'Single', 'woopress' ),
                ),
                'default'  => 'slider'
            ),
            array(
                'id'       => 'quick_product_name',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product name', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'quick_price',
                'type'     => 'switch',
                'title'    => esc_html__( 'Price', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'quick_rating',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product star rating', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'quick_descr',
                'type'     => 'switch',
                'title'    => esc_html__( 'Short description', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'quick_add_to_cart',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add to cart', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'quick_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Share icons', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'product_link',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show link to full product details', 'woopress' ),
                'default'  => false,
            ),
        )
    ) );
    //! quick_view

    // promo_popup
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Promo Popup', 'woopress'),
        'id'               => 'promo_popup',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-editor-expand',
        'fields'           => array(
            array(
                'id'       => 'promo_popup',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable promo popup', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'promo_auto_open',
                'type'     => 'switch',
                'title'    => esc_html__( 'Open popup on enter', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'promo_link',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show link in the top bar', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'pp_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Promo link text', 'woopress' ),
                'default'  => 'Newsletter',
            ),
            array(
                'id'       => 'pp_content',
                'type'     => 'editor',
                'title'    => esc_html__( 'Popup content', 'woopress' ),
                'default'  => 'You can add any HTML here (admin -> Theme Options -> Promo Popup).<br> We suggest you create a static block and put it here using shortcode',
            ),
            array(
                'id'       => 'fixed_ppopup',
                'type'     => 'switch',
                'title'    => esc_html__( 'Fixed promo popup', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'pp_button_bg',
                'type'     => 'color',
                // 'output'   => array( '.site-title' ),
                'title'    => esc_html__( 'Popup button background', 'woopress' ),
                'subtitle' => esc_html__('only if enabled fixed promo popup.', 'woopress'),
                'default'  => '',
            ),
            array(
                'id'       => 'pp_width',
                'type'     => 'text',
                'title'    => esc_html__( 'Popup width', 'woopress' ),
                'default'  => 700,
            ),
            array(
                'id'       => 'pp_height',
                'type'     => 'text',
                'title'    => esc_html__( 'Popup height', 'woopress' ),
                'default'  => 350,
            ),
            array(
                'id'       => 'pp_bg',
                'type'     => 'background',
                'title'    => esc_html__( 'Popup background', 'woopress' ),
                'default'   => '',
            ),

        )
    ) );
    //! promo_popup



    // blog_page
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Blog Layout', 'woopress'),
        'id'               => 'blog_page',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-feedback',
        'fields'           => array(
            array (
                'id'       => 'blog_layout',
                'type'     => 'select',
                'title'    => esc_html__( 'Blog Layout', 'woopress' ),
                'options'  => array (
                    'default'  => esc_html__( 'Default', 'woopress' ),
                    'grid'     => esc_html__( 'Grid', 'woopress' ),
                    'timeline' => esc_html__( 'Timeline', 'woopress' ),
                    'small'    => esc_html__( 'Small', 'woopress' ),
                    'mosaic'   => esc_html__( 'Mosaic', 'woopress' ),
                ),
                'default'  => 'default'
            ),
            array(
                'id'       => 'blog_page_masonry',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable masonry', 'woopress' ),
                'default'  => true,
                'required' => array( 'blog_layout', '=', array( 'grid', 'mosaic' ) )
            ),
            array(
                'id'       => 'blog_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full width (only for mosaic layout)', 'woopress' ),
                'default'  => false,
            ),
            array (
                'id'       => 'blog_columns',
                'type'     => 'select',
                'title'    => esc_html__( 'Columns (for mosaic and grid layouts)', 'woopress' ),
                'options'  => array (
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'blog_byline',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show "byline" on the blog', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'posts_links',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Previous and Next posts links', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'post_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Share buttons', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'about_author',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show About Author block', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'post_related',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Related posts', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'post_tags',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Tags', 'woopress' ),
                'default'  => false,
            ),
            array(
                'id'       => 'excerpt_length',
                'type'     => 'text',
                'title'    => esc_html__( 'Excerpt length(words)', 'woopress' ),
                'default'  => 25,
            ),
            array(
                'id'       => 'blog_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar position', 'woopress' ),
                'options'  => array(
                    'without' => array(
                        'alt' => 'without',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/full-width.png'
                    ),
                    'left' => array(
                        'alt' => 'left',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/left-sidebar.png'
                    ),
                    'right' => array(
                        'alt' => 'right',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/right-sidebar.png'
                    ),
                ),
                'default'  => 'left'
            ),
            array (
                'id'       => 'blog_sidebar_responsive',
                'type'     => 'select',
                'title'    => esc_html__( 'Sidebar position for responsive layout', 'woopress' ),
                'options'  => array (
                    'top'    => esc_html__( 'Top', 'woopress' ),
                    'bottom' => esc_html__( 'Bottom', 'woopress' ),
                ),
                'default'  => 'bottom'
            ),
        )
    ) );
    //! blog_page


    // forum_page
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Forum Layout', 'woopress'),
        'id'               => 'forum_page',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-format-status',
        'fields'           => array(
            array(
                'id'       => 'forum_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar position', 'woopress' ),
                'options'  => array(
                    'without' => array(
                        'alt' => 'without',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/full-width.png'
                    ),
                    'left' => array(
                        'alt' => 'left',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/left-sidebar.png'
                    ),
                    'right' => array(
                        'alt' => 'right',
                        'img' => ETHEME_THEME_ASSETS . '/images/layout/right-sidebar.png'
                    ),
                ),
                'default'  => 'left'
            )
        )
    ) );
    //! forum_page


    // portfolio
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Portfolio', 'woopress'),
        'id'               => 'portfolio',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-schedule',
        'fields'           => array(
            array(
                'id'       => 'portfolio_page',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => esc_html__( 'Portfolio page', 'woopress' ),
            ),
            array(
                'id'       => 'portfolio_count',
                'type'     => 'text',
                'title'    => esc_html__( 'Items per page', 'woopress' ),
                'subtitle' => esc_html__('Use -1 to show all items.', 'woopress'),
                'default'  => -1,
            ),
            array (
                'id'       => 'portfolio_columns',
                'type'     => 'select',
                'title'    => esc_html__( 'Columns', 'woopress' ),
                'options'  => array (
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'project_name',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Project names', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'project_byline',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show ByLine', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'project_excerpt',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Excerpt', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'recent_projects',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show recent projects', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'portfolio_comments',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Comments For Projects', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'portfolio_lightbox',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Lightbox For Projects', 'woopress' ),
                'default'  => true,
            ),
            array(
                'id'       => 'portfolio_image_width',
                'type'     => 'text',
                'title'    => esc_html__( 'Project Images Width', 'woopress' ),
                'default'  => 720,
            ),
            array(
                'id'       => 'portfolio_image_height',
                'type'     => 'text',
                'title'    => esc_html__( 'Project Images Height', 'woopress' ),
                'default'  => 550,
            ),
            array(
                'id'       => 'portfolio_image_cropping',
                'type'     => 'switch',
                'title'    => esc_html__( 'Image Cropping', 'woopress' ),
                'default'  => true,
            ),
            array (
                'id'       => 'portfolio_content_side',
                'type'     => 'select',
                'title'    => esc_html__( 'Custom content position', 'woopress' ),
                'options'  => array (
                    'top'   => esc_html__( 'Top', 'woopress' ),
                    'bottom' => esc_html__( 'Bottom', 'woopress' ),
                ),
                'default'  => 'top'
            ),
        )
    ) );
    //! portfolio



    // contact_form
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Contact Form & Registration', 'woopress'),
        'id'               => 'contact_form',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-lock',
        'fields'           => array(
            array(
                'id'       => 'contacts_email',
                'type'     => 'text',
                'title'    => esc_html__( 'Your email for contact form', 'woopress' ),
                'default'  => 'example@gmail.com',
            ),
            array(
                'id'       => 'privacy_contact',
                'type'     => 'editor',
                'title'    => esc_html__( 'Privacy policy for contact form', 'woopress' ),
                'default'  => 'Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="privacy policy page">privacy policy</a>',
            ),
            array(
                'id'       => 'privacy_registration',
                'type'     => 'editor',
                'title'    => esc_html__( 'Privacy policy for registration forms', 'woopress' ),
                'default'  => 'Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="privacy policy page">privacy policy</a>',
            ),
            array(
                'id'       => 'google_captcha_title',
                'type'     => 'raw',
                'title'    => esc_html__( 'Google captcha', 'woopress' ),
                'content'  => '<b>To start using reCAPTCHA v2, you need to <a target="blank" href="http://www.google.com/recaptcha/admin">sign up for an
            API key pair</a> for your site.</b>',
            ),
            array(
                'id'       => 'google_captcha_site',
                'type'     => 'text',
                'title'    => esc_html__( 'Site key', 'woopress' ),
                'default'  => '',
            ),
            array(
                'id'       => 'google_captcha_secret',
                'type'     => 'text',
                'title'    => esc_html__( 'Secret key', 'woopress' ),
                'default'  => '',
            ),
        )
    ) );
    //! contact_form



    // responsive
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Responsive', 'woopress'),
        'id'               => 'responsive',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-smartphone',
        'fields'           => array(
            array(
                'id'       => 'responsive',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Responsive Design', 'woopress' ),
                'default'  => true,
            ),
        )
    ) );
    //! responsive



    // custom_css
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Custom CSS', 'woopress'),
        'id'               => 'custom_css',
        'customizer_width' => '400px',
        'icon'             => 'dashicons dashicons-media-code',
        'fields'           => array(
            array(
                'id'       => 'global_custom_css',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Global Custom CSS', 'woopress' ),
                'mode'     => 'css',
                'theme'    => 'monokai',
                'default'  => ''
            ),
            array(
                'id'       => 'custom_css_desktop',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom CSS for desktop', 'woopress' ),
                'subtitle' => '992px +',
                'mode'     => 'css',
                'theme'    => 'monokai',
                'default'  => ''
            ),
            array(
                'id'       => 'custom_css_tablet',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom CSS for tablet', 'woopress' ),
                'subtitle' => '768px - 991px',
                'mode'     => 'css',
                'theme'    => 'monokai',
                'default'  => ''
            ),
            array(
                'id'       => 'custom_css_wide_mobile',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom CSS for mobile landscape', 'woopress' ),
                'subtitle' => '481px - 767px',
                'mode'     => 'css',
                'theme'    => 'monokai',
                'default'  => ''
            ),
            array(
                'id'       => 'custom_css_mobile',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom CSS for mobile', 'woopress' ),
                'subtitle' => '0 - 480px',
                'mode'     => 'css',
                'theme'    => 'monokai',
                'default'  => ''
            ),
        )
    ) );
    //! custom_css

    // Import / Export
    

    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Import / Export', 'woopress' ),
        'id' => 'import',
        'icon'   => 'dashicons dashicons-images-alt2',
        'fields' => array(
            array(
                'id'         => 'opt-import-export',
                'type'       => 'import_export',
                'title'      => esc_html__( 'Import Export', 'woopress' ),
                'subtitle'   => esc_html__( 'Save and restore your theme options.', 'woopress' ),
                'full_width' => false,
            ),
        )
    ));

    //! Import / Export

   
    /*
     * <--- END SECTIONS
     */


    // If Redux is running as a plugin, this will remove the demo notice and links
    add_action( 'redux/loaded', 'remove_demo' );

    // Remove the demo link and the notice of integrated demo from the redux-framework plugin

    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }