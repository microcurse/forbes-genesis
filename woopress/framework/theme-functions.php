<?php
// **********************************************************************//
// ! Set Content Width
// **********************************************************************//
if (!isset( $content_width )) $content_width = 1170;

// **********************************************************************//
// ! Include CSS and JS
// **********************************************************************//
if(!function_exists('etheme_enqueue_styles')) {
    function etheme_enqueue_styles() {
       global $etheme_responsive;

        $force_ultimate_styles = etheme_get_option('force_addons_css');

        if ( !is_admin() ) {
            wp_enqueue_style("fa",get_template_directory_uri().'/css/font-awesome.min.css');
            wp_enqueue_style("bootstrap",get_template_directory_uri().'/css/bootstrap.min.css');
            wp_enqueue_style("parent-style",get_template_directory_uri().'/style.css');
            wp_enqueue_style("parent-plugins",get_template_directory_uri().'/css/plugins.css');
            if($etheme_responsive)
                wp_enqueue_style("responsive",get_template_directory_uri().'/css/responsive.css');
            wp_enqueue_style('js_composer_front');

            $script_depends = array();

            if(class_exists('WooCommerce')) {
                $script_depends = array('wc-add-to-cart-variation');
            }

            wp_enqueue_script('jquery');
            wp_enqueue_script('modernizr', get_template_directory_uri().'/js/modernizr.js');
            wp_enqueue_script('head', get_template_directory_uri().'/js/head.js');
            // HEAD wp_enqueue_script('classie', get_template_directory_uri().'/js/classie.js');
            // HEAD wp_enqueue_script('progressButton', get_template_directory_uri().'/js/progressButton.js');
            // HEAD wp_enqueue_script('jpreloader', get_template_directory_uri().'/js/jpreloader.min.js',array());
            wp_enqueue_script('plugins', get_template_directory_uri().'/js/plugins.js',array(),false,true);
            // PLUGINS wp_enqueue_script('jquery-cookie', get_template_directory_uri().'/js/cookie.js',array(),false,true);
            wp_enqueue_script('hoverIntent', get_template_directory_uri().'/js/jquery.hoverIntent.js',array(),false,true);
            //wp_enqueue_script('nanoscroll', get_template_directory_uri().'/js/nanoscroll.js',array(),false,true);
            // HEAD wp_enqueue_script('owlcarousel', get_template_directory_uri().'/js/owl.carousel.min.js');
            // PLUGINS wp_enqueue_script('magnific-popup', get_template_directory_uri().'/js/jquery.magnific-popup.min.js',array(),false,true);
            // PLUGINS wp_enqueue_script('et_masonry', get_template_directory_uri().'/js/jquery.masonry.min.js',array(),false,true);
            // PLUGINS wp_enqueue_script('mediaelement-and-player', get_template_directory_uri().'/js/mediaelement-and-player.min.js',array(),false,true);
            // PLUGINS wp_enqueue_script('favico', get_template_directory_uri().'/js/favico-0.3.0.min.js',array(),false,true);
            // PLUGINS wp_enqueue_script('emodal', get_template_directory_uri().'/js/emodal.js',array(),false,true);
            // PLUGINS wp_enqueue_script('waypoint', get_template_directory_uri().'/js/waypoints.min.js',array(),false,true);
            // PLUGINS wp_enqueue_script('mousewheel', get_template_directory_uri().'/js/jquery.mousewheel.js',array(),false,true);
            // PLUGINS wp_enqueue_script('tooltipster', get_template_directory_uri().'/js/jquery.tooltipster.min.js',array(),false,true);
            if(class_exists('WooCommerce') && is_product())
                wp_enqueue_script('et-zoom', get_template_directory_uri().'/js/zoom.js',array(),false,true);
            // HEAD wp_enqueue_script('swiper', get_template_directory_uri().'/js/swiper.min.js');

            $gcaptcha = etheme_get_option('google_captcha_site');

            if ( $gcaptcha ) {
                wp_enqueue_script('et_g-recaptcha', 'https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit',$script_depends,false,true );
            }

            wp_enqueue_script('etheme', get_template_directory_uri().'/js/etheme.js',$script_depends,false,true);
            wp_localize_script( 'etheme', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'noresults' => esc_html__('No results were found!', 'woopress')));

            if($force_ultimate_styles) {
                wp_enqueue_script('ultimate-modernizr');
                wp_enqueue_script('jquery_ui');
                wp_enqueue_script('masonry');
                wp_enqueue_script('ultimate-script');
                wp_enqueue_script('ultimate-modal-all');
                wp_enqueue_style('ultimate-style-min');
                wp_enqueue_style("ult-icons");
            }

            if (etheme_get_option('loader')) {
                wp_register_script( 'etheme-preloader', '' );
                wp_enqueue_script( 'etheme-preloader', array('etheme', 'head') );
                wp_add_inline_script( 'etheme-preloader', 'jQuery(document).ready(function() {if(jQuery(window).width() > 1200 ) {
                    jQuery("body").queryLoader2({
                        barColor: "#111",
                        backgroundColor: "#fff",
                        percentage: true,
                        barHeight: 2,
                        completeAnimation: "grow",
                        minimumTime: 500,
                        onLoadComplete: function() {
                            jQuery(\'body\').addClass(\'page-loaded\');
                        }
                    });
                } });' );
            }

        }
    }
}

add_action( 'wp_enqueue_scripts', 'etheme_enqueue_styles', 130);


// **********************************************************************//
// ! Function for disabling Responsive layout
// **********************************************************************//
if(!function_exists('etheme_set_responsive')) {
    function etheme_set_responsive() {
        global $etheme_responsive;
        $etheme_responsive = etheme_get_option('responsive');
        if(isset($_COOKIE['responsive'])) {
            $etheme_responsive = false;
        }
        if(isset($_GET['responsive']) && $_GET['responsive'] == 'off') {
            if (!isset($_COOKIE['responsive'])) {
                setcookie('responsive', 1, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
            }
            wp_redirect(get_home_url()); exit();
        }elseif(isset($_GET['responsive']) && $_GET['responsive'] == 'on') {
            if (isset($_COOKIE['responsive'])) {
                setcookie('responsive', 1, time()-1209600, COOKIEPATH, COOKIE_DOMAIN, false);
            }
            wp_redirect(get_home_url()); exit();
        }
    }
}

add_action( 'init', 'etheme_set_responsive');

// **********************************************************************//
// ! BBPress add user role
// **********************************************************************//
if(!function_exists('etheme_bb_user_role')) {
    function etheme_bb_user_role() {
        if(!function_exists('bbp_is_deactivation')) return;

        // Bail if deactivating bbPress

        if ( bbp_is_deactivation() )
            return;

        // Catch all, to prevent premature user initialization
        if ( ! did_action( 'set_current_user' ) )
            return;

        // Bail if not logged in or already a member of this site
        if ( ! is_user_logged_in() )
            return;

        // Get the current user ID
        $user_id = get_current_user_id();

        // Bail if user already has a forums role
        if ( bbp_get_user_role( $user_id ) )
            return;

        // Bail if user is marked as spam or is deleted
        if ( bbp_is_user_inactive( $user_id ) )
            return;

        /** Ready *****************************************************************/

        // Load up bbPress once
        $bbp         = bbpress();

        // Get whether or not to add a role to the user account
        $add_to_site = bbp_allow_global_access();

        // Get the current user's WordPress role. Set to empty string if none found.
        $user_role   = bbp_get_user_blog_role( $user_id );

        // Get the role map
        $role_map    = bbp_get_user_role_map();

        /** Forum Role ************************************************************/

        // Use a mapped role
        if ( isset( $role_map[$user_role] ) ) {
            $new_role = $role_map[$user_role];

        // Use the default role
        } else {
            $new_role = bbp_get_default_role();
        }

        /** Add or Map ************************************************************/

        // Add the user to the site
        if ( true === $add_to_site ) {

            // Make sure bbPress roles are added
            bbp_add_forums_roles();

            $bbp->current_user->add_role( $new_role );

        // Don't add the user, but still give them the correct caps dynamically
        } else {
            $bbp->current_user->caps[$new_role] = true;
            $bbp->current_user->get_role_caps();
        }

        $new_role = bbp_get_default_role();

        bbp_set_user_role( $user_id, $new_role );
    }
}

add_action( 'init', 'etheme_bb_user_role');



// **********************************************************************//
// ! Exclude some css from minifier
// **********************************************************************//


add_filter('bwp_minify_style_ignore', 'et_exclude_css');

if(!function_exists('et_exclude_css')) {
    function et_exclude_css($excluded) {
        $excluded = array('font-awesome');
        return $excluded;
    }
}


// **********************************************************************//
// ! Add classes to body
// **********************************************************************//
add_filter('body_class','et_add_body_classes');
if(!function_exists('et_add_body_classes')) {
    function et_add_body_classes($classes) {
        $l = et_page_config();
        if(etheme_get_option('top_panel')) $classes[] = 'topPanel-enabled ';
        if(etheme_get_option('right_panel')) $classes[] = 'rightPanel-enabled ';
        if(is_woopress_migrated() && etheme_get_option('fixed_nav_sw') || etheme_get_option('fixed_nav_sw') == 'on') $classes[] = 'fixNav-enabled ';
        if(etheme_get_option('fade_animation')) $classes[] = 'fadeIn-enabled ';
        if(get_header_type() == 'vertical' || get_header_type() == 'vertical2') $classes[] = 'header-vertical-enable ';
        if(!class_exists('Woocommerce') || etheme_get_option('just_catalog') || ( is_woopress_migrated() && ! etheme_get_option('cart_widget_sw') || etheme_get_option('cart_widget_sw') == 'off' ) ) $classes[] = 'top-cart-disabled ';
        $classes[] = 'banner-mask-'.etheme_get_option('banner_mask');

        $classes[] = etheme_get_option('main_layout');
        if(etheme_get_option('loader')) $classes[] = 'js-preloader';
        if(etheme_get_option('disable_right_click')) $classes[] = 'disabled-right';
        if(etheme_get_option('promo_auto_open')) $classes[] = 'open-popup';
        if(etheme_get_option('transparent_container')) $classes[] = 'container-transparent';
        if(etheme_get_custom_field('full_page')) $classes[] = 'full-page-on';
        $classes[] = 'breadcrumbs-type-'.$l['breadcrumb'];
        if ( etheme_get_option('google_captcha_site') ) {       
            $classes[] = 'et_g-recaptcha';      
        }
        return $classes;
    }
}


if(!function_exists('et_bordered_layout')) {
    function et_bordered_layout() {
        if(etheme_get_option('main_layout') != 'bordered') return;
        ?>
            <div class="body-border-left"></div>
            <div class="body-border-top"></div>
            <div class="body-border-right"></div>
            <div class="body-border-bottom"></div>
        <?php
    }
}
add_action('et_after_body', 'et_bordered_layout');


add_action('wp_head', 'core_plugin_exist_notice');

function core_plugin_exist_notice(){
    // if ( ! function_exists( 'woopress_core_load_textdomain' ) ) {
    //     echo '<div class="woocommerce-error">' . esc_html__( 'Install WooPress Core plugin to continue using WooPress theme', 'woopress' ) . '</div>';
    // }
}

if(!function_exists('etheme_get_chosen_google_font')) {
    function etheme_get_chosen_google_font() {

        $gfonts = get_theme_mod( 'ot_google_fonts', array() );

        $chosenFonts = array();
        $fontOptions = array(
            etheme_get_option('pade_heading-google'),
            etheme_get_option('menufont-google'),
            etheme_get_option('menufont_2-google'),
            etheme_get_option('menufont_3-google'),
            etheme_get_option('mainfont-google'),
            etheme_get_option('h1-google'),
            etheme_get_option('h2-google'),
            etheme_get_option('h3-google'),
            etheme_get_option('h4-google'),
            etheme_get_option('h5-google'),
            etheme_get_option('h6-google'),
            etheme_get_option('sfont-google')
        );

        $families = $subsets = '';

        foreach($fontOptions as $value){
            $value = isset( $value[0] ) ? $value[0] : false;

            if($value && !empty($value['family']) && $value['family'] != 'Open+Sans') {
                $families .= str_replace(' ', '+', $gfonts[$value['family']]['family']);
                if(!empty($value['variants']) && is_array($value['variants'])) {
                    $count = count($value['variants']);
                    $_i = 0;
                    $families .= ':';
                    foreach ($value['variants'] as $variant) {
                        $_i++;
                        $families .= $variant;
                        if($_i != $count) {
                            $families .= ',';
                        }
                    }
                }

                $families .= '|';

                if(!empty($value['subsets']) && is_array($value['subsets'])) {
                    foreach ($value['subsets'] as $subset) {
                        $subsets .= $subset . ',';
                    }
                }
            }


        }

        if($subsets != '') {
            $subsets = substr( $subsets, 0, -1);
            $subsets = '&subset=' . $subsets;
        }

        $families = substr( $families, 0, -1);

        if($families != '') {
            ?>
                <link href='//fonts.googleapis.com/css?family=<?php echo esc_html( $families . $subsets ); ?>' rel='stylesheet' type='text/css'>
            <?php
        }
    }
}


if(!function_exists('et_load_bg_option')) {
    function et_load_bg_option( $value, $selector, $external = '' ) {
          $bg = array();
          $size = '';
          $padding ='';
          $in = array( 'px', 'em', 'rem', 'vw', 'vh', 'vmin', 'vmax', '%' );

          if ( ! empty( $value['background-color'] ) )
            $bg[] = $value['background-color'];

          if ( ! empty( $value['background-image'] ) )
            $bg[] = 'url("' . $value['background-image'] . '")';

          if ( ! empty( $value['background-repeat'] ) )
            $bg[] = $value['background-repeat'];

          if ( ! empty( $value['background-attachment'] ) )
            $bg[] = $value['background-attachment'];

          if ( ! empty( $value['background-position'] ) )
            $bg[] = $value['background-position'];

          if ( ! empty( $value['background-size'] ) )
            $size = 'background-size: ' . $value['background-size'] . ';';

          if ( ! empty( $external ) ) {

                foreach ( $external as $key => $var ) {

                    if ( $key == 'units' ) {
                        continue;
                    }

                    if ( ! empty( $var ) ) {
                        $padding .= et_check_units( $in, $var ) ? $key . ': ' . $var . ';' : $key . ': ' . $var . 'px;';
                    }
                }
          }

          /* set $value with background properties or empty string */
          $value = ! empty( $bg ) ? 'background: ' . implode( " ", $bg ) . ';' : '';

          printf ( '%1$s {%2$s %3$s %4$s}', $selector, $value, $size, $padding );
    }
}

if(!function_exists('et_load_typography_option')) {
    function et_load_typography_option($id, $selector) {
        $font = array();

        $value = etheme_get_option( $id );

        if ( ! is_woopress_migrated() ) {
            $google_font = etheme_get_option( $id . '-google' );

            $gfonts = get_theme_mod( 'ot_google_fonts', array() );

            if ( ! empty( $value['font-color'] ) ){
                $font[] = "color: " . $value['font-color'] . ";";
            }

            if( ! empty( $google_font[0]['family'] ) ) {
                $font[] = "font-family: " . $gfonts[$google_font[0]['family']]['family'] . ";";
            } else if ( ! empty( $value['font-family'] ) ) {
                foreach ( et_recognized_font_families( '' ) as $key => $key ) {
                    if ( $key == $value['font-family'] ) {
                        $font[] = "font-family: " . $key . ";";
                    }
                }
            }

            if ( ! empty( $value['google-font'] ) ){
                $font[] = "font-family: \"" . $value['google-font'] . "\";";
            }

        } else {
            if ( ! empty( $value['font-family'] ) ){
                $font[] = "font-family: " . $value['font-family'] . ";";
            }

            if ( ! empty( $value['color'] ) ){
                $font[] = "color: " . $value['color'] . ";";
            }
        }
	
	    if ( ! empty( $value['font-size'] ) ){
		    $font[] = "font-size: " . $value['font-size'] . ";";
		    if ( ! empty( $value['line-height'] ) ){
			    $font[] = "line-height: " . ((int) $value['line-height'] / (int) $value['font-size']) . ";";
		    }
	    }
	    
        if ( ! empty( $value['font-style'] ) ){
            $font[] = "font-style: " . $value['font-style'] . ";";
        }
        if ( ! empty( $value['font-variant'] ) ){
            $font[] = "font-variant: " . $value['font-variant'] . ";";
        }

        if ( ! empty( $value['font-weight'] ) ){
            $font[] = "font-weight: " . $value['font-weight'] . ";";
        }

        if ( ! empty( $value['letter-spacing'] ) ){
            $font[] = "letter-spacing: " . $value['letter-spacing'] . ";";
        }

        if ( ! empty( $value['text-transform'] ) ){
            $font[] = "text-transform: " . $value['text-transform'] . ";";
        }

        $value = ! empty( $font ) ? implode( "\n", $font ) : '';

        printf( '%s {%s}', $selector, $value );
    }
}

if(!function_exists('et_load_font_family_option')) {
    function et_load_font_family_option($id, $selector) {
          $font = array();

          $value = etheme_get_option( $id );

          if ( ! is_woopress_migrated() ) {
              $google_font = etheme_get_option( $id . '-google' );

              $gfonts = get_theme_mod( 'ot_google_fonts', array() );

              if( ! empty( $google_font[0]['family'] ) ) {
                $font[] = "font-family: " . $gfonts[$google_font[0]['family']]['family'] . ";";
              } else if ( ! empty( $value['font-family'] ) ) {
                foreach ( et_recognized_font_families( '' ) as $key => $key ) {
                  if ( $key == $value['font-family'] ) {
                    $font[] = "font-family: " . $key . ";";
                  }
                }
              }

              if ( ! empty( $value['google-font'] ) )
                $font[] = "font-family: \"" . $value['google-font'] . "\";";
          } else {
                if ( isset( $value['font-family'] ) && ! empty( $value['font-family'] ) ) {
                    $font[] = "font-family: " . $value['font-family'] . ";";
                }
          }


        $value = ! empty( $font ) ? implode( "\n", $font ) : '';

        printf( '%s {%s}', $selector, $value );
    }
}

if(!function_exists('et_recognized_font_families')) {
  function et_recognized_font_families( $field_id = '' ) {

    return apply_filters( 'ot_recognized_font_families', array(
      'arial'     => 'Arial, sans-serif',
      'georgia'   => 'Georgia',
      'helvetica' => 'Helvetica',
      'palatino'  => 'Palatino',
      'tahoma'    => 'Tahoma',
      'times'     => 'Times New Roman',
      'trebuchet' => 'Trebuchet',
      'verdana'   => 'Verdana'
    ), $field_id );

  }
}
// **********************************************************************//
// ! Screet chat fix
// **********************************************************************//

define('SC_CHAT_LICENSE_KEY', '69e13e4c-3dfd-4a70-83c8-3753507f5ae8');
if(!function_exists('etheme_chat_init')) {
    function etheme_chat_init () {
        update_option('sc_chat_validate_license', 1);
    }
}

add_action( 'after_setup_theme', 'etheme_chat_init');


// **********************************************************************//
// ! Theme 3d plugins
// **********************************************************************//
add_action( 'init', 'etheme_3d_plugins' );
if(!function_exists('etheme_3d_plugins')) {
    function etheme_3d_plugins() {
        if(function_exists( 'set_revslider_as_theme' )){
            set_revslider_as_theme();
        }
        if(function_exists( 'set_ess_grid_as_theme' )){
            set_ess_grid_as_theme();
        }
    }
}

add_action( 'vc_before_init', 'etheme_vcSetAsTheme' );
if(!function_exists('etheme_vcSetAsTheme')) {
    function etheme_vcSetAsTheme() {
        if(function_exists( 'vc_set_as_theme' )){
            vc_set_as_theme();
        }
    }
}


if(!defined('YITH_REFER_ID')) {
    define('YITH_REFER_ID', '1028760');
}

if ( !defined('BSF_6892199_NOTICES') ) {
    define('BSF_6892199_NOTICES', false);
}


// **********************************************************************//
// ! Add theme support
// **********************************************************************//



add_action( 'after_setup_theme', 'et_theme_init', 11 );
if(!function_exists('et_theme_init')) {
    function et_theme_init(){

        add_theme_support( 'post-formats', array( 'video', 'quote', 'gallery' ) );
        add_theme_support( 'post-thumbnails', array('post'));
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'woocommerce' );
        add_theme_support( 'title-tag' );
    }
}

add_action( 'after_setup_theme', 'et_config_init', 5 );
if(!function_exists('et_config_init')) {
    function et_config_init(){
        global $options;
        /* get the saved options */
        if(empty($options))
            $options = get_option( 'option_tree' );
    }
}



// **********************************************************************//
// ! Add admin styles and scripts
// **********************************************************************//

add_action('admin_init', 'etheme_load_admin_styles');
if ( !function_exists('etheme_load_admin_styles') ) {
    function etheme_load_admin_styles() {
        global $pagenow;
        wp_enqueue_style('farbtastic');
        $depends = array();

        if (in_array('admin-bar',get_body_class())) {
            wp_enqueue_style('etheme_admin_css', ETHEME_CODE_CSS_URL.'/admin.css', $depends );
            wp_enqueue_style('etheme_redux_css', ETHEME_CODE_CSS_URL.'/redux-options.css', array( 'redux-admin-css' ) );
        }
    }
}
add_action('admin_init','etheme_add_admin_script', 1130);

if ( !function_exists('etheme_add_admin_script') ) {
    function etheme_add_admin_script(){
        add_thickbox();
        wp_enqueue_script('theme-preview');
        wp_enqueue_script('common');
        wp_enqueue_script('wp-lists');
        wp_enqueue_script('postbox');
        wp_enqueue_script('farbtastic');
        wp_enqueue_script('et_masonry', get_template_directory_uri().'/js/jquery.masonry.min.js',array(),false,true);
        wp_enqueue_script('etheme_admin_js', ETHEME_CODE_JS_URL.'/admin.js',array(),false,true);
        wp_enqueue_style("font-awesome",get_template_directory_uri().'/css/font-awesome.min.css');
    }
}


// **********************************************************************//
// ! Use http or https
// **********************************************************************//
if ( ! function_exists( 'etheme_http' ) ) {
    function etheme_http() {
        return (is_ssl())?"https://":"http://";
    }
}

// **********************************************************************//
// ! Menus
// **********************************************************************//
if(!function_exists('etheme_register_menus')) {
    function etheme_register_menus() {
        register_nav_menus(array(
            'main-menu' => esc_html__('Main menu (left, default)', 'woopress'),
            'main-menu-right' => esc_html__('Main menu (right)', 'woopress'),
            'mobile-menu' => esc_html__('Mobile menu', 'woopress'),
        ));
    }
}

add_action('init', 'etheme_register_menus');

// **********************************************************************//
// ! Page heading
// **********************************************************************//
if(!function_exists('et_page_heading')) {

    add_action('et_page_heading', 'et_page_heading', 10);

    function et_page_heading() {

        $l = et_page_config();

        if ($l['heading'] !== 'disable' && !$l['slider'] && $l['breadcrumb'] != 9): ?>

            <div class="page-heading bc-type-<?php echo esc_attr( $l['breadcrumb'] ); ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 a-center">
                            <h1 class="title"><span><?php echo et_get_the_title(); ?></span></h1>
                            <?php etheme_breadcrumbs(); ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif;

        if($l['breadcrumb_image'] != '') {
            ?>
                <style type="text/css">
                    .page-heading {
                        background-image: url(<?php echo esc_url( $l['breadcrumb_image'] ); ?>);
                    }
                </style>
            <?php
        }

        if($l['slider']): ?>
            <div class="page-heading-slider">
                <?php  echo do_shortcode('[rev_slider_vc alias="'.$l['slider'].'"]'); ?>
            </div>
        <?php endif;
    }
}

if(!function_exists('et_get_the_title')) {
    function et_get_the_title() {

        $post_page = get_option( 'page_for_posts' );


        if(is_home()) {
            return get_the_title( $post_page );
        }

        // Homepage and Single Page
        if ( is_home() || is_single() || is_404() ) {
            return get_the_title();
        }

        // Search Page
        if ( is_search() ) {
            return esc_html__( 'Search Results for: ', 'woopress' ) . get_search_query();
        }

        // Archive Pages
        if ( is_archive() ) {
            if ( is_author() ) {
                return esc_html__( 'All posts by ', 'woopress' ) . get_the_author();
            }
            elseif ( is_day() ) {
                return esc_html__( 'Daily Archives: ', 'woopress' ) . get_the_date();
            }
            elseif ( is_month() ) {
                return esc_html__( 'Monthly Archives: ', 'woopress') . get_the_date( _x( 'F Y', 'monthly archives date format', 'woopress' ) );
            }
            elseif ( is_year() ) {
                return esc_html__( 'Yearly Archives: ', 'woopress' ) . get_the_date( _x( 'Y', 'yearly archives date format', 'woopress' ) );
            }
            elseif ( is_tag() ) {
                return esc_html__( 'Tag Archives: ', 'woopress' ) . single_tag_title( '', false );
            }
            elseif ( is_category() ) {
                return esc_html__( 'Category Archives: ', 'woopress' ) . single_cat_title( '', false );
            }
            elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
                return esc_html__( 'Asides', 'woopress' );
            }
            elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
                return esc_html__( 'Videos', 'woopress' );
            }
            elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
                return esc_html__( 'Audio', 'woopress' );
            }
            elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
                return esc_html__( 'Quotes', 'woopress' );
            }
            elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
                return esc_html__( 'Galleries', 'woopress' );
            }
            else {
                return esc_html__( 'Archives', 'woopress' );
            }
        }

        return get_the_title();
    }
}


// **********************************************************************//
// ! Get logo
// **********************************************************************//
if (!function_exists('etheme_logo')) {
    function etheme_logo($fixed_header = false) {
        $logoimg = '';
        if($logoimg == '') {
            $logoimg = etheme_get_option('logo');
        }

        $custom_logo = etheme_get_custom_field('custom_logo', et_get_page_id());

        if($custom_logo != '') {
           $logoimg       = $custom_logo;
           $attachment_id = attachment_url_to_postid($custom_logo);
           $attachment    = get_post( $attachment_id );

           $logoimg = array(
                'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                'caption'     => $attachment->post_excerpt,
                'description' => $attachment->post_content,
                'url'         => $logoimg,
                'title'       => $attachment->post_title
            );
        }

        if($fixed_header) {
            $logoimg = etheme_get_option('logo_fixed');
        }

        if ( ! $logoimg || ! $logoimg['url'] ) {
           $logoimg = etheme_get_option('logo');
        }
        $new_logoimg = array();
        $new_logoimg['url']         = isset( $logoimg['url'] ) ? $logoimg['url'] : $logoimg;
        $new_logoimg['alt']         = isset( $logoimg['alt'] ) ? $logoimg['alt'] : '';
        $new_logoimg['title']       = isset( $logoimg['title'] ) ? $logoimg['title'] : '';
        $new_logoimg['description'] = isset( $logoimg['description'] ) ? $logoimg['description'] : '';

        $new_logoimg['url'] = (!empty($new_logoimg['url'])) ? $new_logoimg['url'] : ETHEME_BASE_URI.'images/logo.png';
        $new_logoimg['alt'] = (!empty($new_logoimg['alt'])) ? $new_logoimg['alt'] : esc_html__('Site logo', 'woopress');
        
        ?>
        <?php if($new_logoimg): ?>
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo esc_url( $new_logoimg['url'] ); ?>"  alt="<?php echo esc_html($new_logoimg['alt']); ?>" title="<?php echo esc_html( $new_logoimg['title'] ); ?>" description="<?php echo esc_html( $new_logoimg['description'] ); ?>"/>
            </a>
        <?php else: ?>
            <a href="<?php echo home_url(); ?>"><img src="<?php echo PARENT_URL.'/images/logo.png'; ?>" alt="<?php bloginfo('name'); ?>"></a>
        <?php endif ;
        do_action('etheme_after_logo');
    }
}

if(!function_exists('etheme_top_links')) {
    function etheme_top_links($args = array()) {
    extract(shortcode_atts(array(
        'popups'  => true
    ), $args));
        ?>
            <ul class="links<?php echo ( isset( $args['newsletter'] ) && $args['class'] ) ? ' ' . $args['class'] : '' ; ?>">
                <?php if( (! isset( $args['newsletter'] ) && etheme_get_option( 'promo_popup' ) ) || ( isset( $args['newsletter'] ) && $args['newsletter'] == true ) ): ?>
                    <li class="popup_link <?php if(!etheme_get_option('promo_link')): ?>hidden<?php endif; if(etheme_get_option('fixed_ppopup')): ?>laptop-visible<?php endif;?>"><a class="etheme-popup <?php echo (etheme_get_option('promo_auto_open')) ? 'open-click': '' ; ?>" href="#etheme-popup"><?php if ( etheme_get_option('pp_title') == '' ) { esc_html_e('Newsletter', 'woopress'); } else { echo etheme_get_option('pp_title'); } ?></a></li>
                <?php endif; ?>

                <?php if(etheme_get_option('top_links')): ?>
                    <?php if ( is_user_logged_in() ) : ?>
                        <?php if(class_exists('Woocommerce')): ?>
                            <li class="my-account-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php esc_html_e( 'My Account', 'woopress' ); ?></a></li>
                        <?php endif; ?>
                        <li class="logout-link"><a href="<?php echo wp_logout_url(home_url()); ?>"><?php esc_html_e( 'Logout', 'woopress' ); ?></a></li>
                    <?php else : ?>
                        <?php
                            $reg_id = etheme_tpl2id('et-registration.php');
                            $reg_url = get_permalink($reg_id);
                        ?>
                        <?php if(class_exists('Woocommerce')): ?>
                            <li class="login-link">
                                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php esc_html_e( 'Sign In', 'woopress' ); ?></a>
                                <?php if($popups) : ?>
                                    <div class="login-popup">
                                        <div class="popup-title">
                                            <span><?php esc_html_e( 'Login Form', 'woopress' ); ?></span>
                                        </div>

                                            <form method="post" class="form-login" action="<?php echo get_the_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>">

                                                <?php do_action( 'woocommerce_login_form_start' ); ?>

                                                <p class="form-row form-row-first">
                                                    <label for="username"><?php esc_html_e( 'Username or email', 'woopress' ); ?> <span class="required">*</span></label>
                                                    <input type="text" class="input-text" name="username" id="username" />
                                                </p>
                                                <p class="form-row form-row-last">
                                                    <label for="password"><?php esc_html_e( 'Password', 'woopress' ); ?> <span class="required">*</span></label>
                                                    <input class="input-text" type="password" name="password" id="password" />
                                                </p>
                                                <div class="clear"></div>

                                                <?php do_action( 'woocommerce_login_form' ); ?>

                                                <p class="form-row">
                                                    <?php wp_nonce_field( 'woocommerce-login' ); ?>
                                                    <input type="submit" class="button" name="login" value="<?php esc_html_e( 'Login', 'woopress' ); ?>" />
                                                </p>

                                                <div class="clear"></div>

                                                <?php do_action( 'woocommerce_login_form_end' ); ?>

                                            </form>

                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                        <?php if( get_option('users_can_register') && ( ! empty( $reg_id ) || ( isset( $args['register'] ) && $args['register'] == true ) ) ): ?>
                            <li class="register-link">
                                <a href="<?php echo esc_url( $reg_url ); ?>"><?php esc_html_e( 'Register', 'woopress' ); ?></a>
                                <?php if($popups) : ?>
                                    <div class="register-popup">
                                        <div class="popup-title">
                                            <span><?php esc_html_e( 'Register Form', 'woopress' ); ?></span>
                                        </div>
                                        <?php et_register_form(); ?>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        <?php
    }
}

if(!function_exists('et_get_main_menu')) {
    function et_get_main_menu( $menu_id = 'main-menu', $class = '' ) {

        $custom_menu_slug = 'custom_nav';
        $cache_slug = 'et_get_' . $menu_id;
        if($menu_id == 'main-menu-right') $custom_menu_slug = 'custom_nav_right';
        $custom_menu = etheme_get_custom_field( $custom_menu_slug );
        $one_page_menu = '';
        if(etheme_get_custom_field('one_page')) $one_page_menu = ' one-page-menu';
        if(!empty($custom_menu) && $custom_menu != '') {
            $output = false;
            $output = wp_cache_get( $class, $custom_menu, $cache_slug );
            if ( !$output ) {
                ob_start();

                wp_nav_menu(array(
                    'menu' => $custom_menu,
                    'before' => '',
                    'container_class' => 'menu-main-container' . $one_page_menu . $class,
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'depth' => 10,
                    'fallback_cb' => false,
                    'walker' => new Et_Navigation
                ));

                $output = ob_get_contents();
                ob_end_clean();

                wp_cache_add( $class, $custom_menu, $output, $cache_slug );
            }

            echo $output; // All data escaped
            return;
        }

        if ( has_nav_menu( $menu_id ) ) {
            $output = false;
            $output = wp_cache_get( $class, $menu_id, $cache_slug );
            if ( !$output ) {
                ob_start();

                wp_nav_menu(array(
                    'theme_location' => $menu_id,
                    'before' => '',
                    'container_class' => 'menu-main-container' . $class,
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'depth' => 10,
                    'fallback_cb' => false,
                    'walker' => new Et_Navigation
                ));

                $output = ob_get_contents();
                ob_end_clean();

                wp_cache_add( $class, $menu_id, $output, $cache_slug );
            }

            echo $output; // All data escaped
        } else {
            ?>
                <br>
                <h4 class="a-center"><?php esc_html_e('Set your main menu in', 'woopress');?> <em><?php esc_html_e( 'Appearance &gt; Menus', 'woopress'); ?></em></h4>
            <?php
        }
    }
}

if(!function_exists('et_get_mobile_menu')) {
    function et_get_mobile_menu($menu_id = 'mobile-menu') {

        $custom_menu = etheme_get_custom_field('custom_nav_mobile');

        $one_page_menu = '';

        if(etheme_get_custom_field('one_page')) $one_page_menu = ' one-page-menu';

        if(!empty($custom_menu) && $custom_menu != '') {
            $output = false;
            $output = wp_cache_get( $custom_menu, 'et_get_mobile_menu' );
            if ( !$output ) {
                ob_start();

                wp_nav_menu(array(
                    'menu' => $custom_menu,
                    'before' => '',
                    'container_class' => 'menu-mobile-container'.$one_page_menu,
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'depth' => 5,
                    'fallback_cb' => false,
                    'walker' => new Et_Navigation_Mobile
                ));

                $output = ob_get_contents();
                ob_end_clean();

                wp_cache_add( $custom_menu, $output, 'et_get_mobile_menu' );
            }

            echo $output; // All data escaped
            return;
        }

        if ( has_nav_menu( $menu_id ) ) {
            $output = false;
            $output = wp_cache_get( $menu_id, 'et_get_mobile_menu' );

            if ( !$output ) {
                ob_start();

                wp_nav_menu(array(
                    'container_class' => $one_page_menu,
                    'theme_location' => 'mobile-menu',
                    'walker' => new Et_Navigation_Mobile
                ));

                $output = ob_get_contents();
                ob_end_clean();

                wp_cache_add( $menu_id, $output, 'et_get_mobile_menu' );
            }

            echo $output; // All data escaped
        } else {
            ?>
                <br>
                <h4 class="a-center"><?php esc_html_e('Set your main menu in ', 'woopress'); ?> <em><?php esc_html_e('Appearance &gt; Menus', 'woopress'); ?></em></h4>
            <?php
        }
    }
}


if(!function_exists('et_get_favicon')) {
    function et_get_favicon() {
        $icon = etheme_get_option('favicon');

        if ( is_woopress_migrated() ) {
            $icon = isset( $icon['url'] ) ? $icon['url'] : $icon;
        }

        if($icon == '') {
            $icon = get_template_directory_uri().'/images/favicon.ico';
        }
        return $icon;
    }
}


if(!function_exists('et_get_menus_options')) {
    function et_get_menus_options() {
        $menus = array();
        $menus[] = array("label"=>"Default","value"=>"");
        $nav_terms = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
        foreach ( $nav_terms as $obj ) {
            $menus[] = array("label" => $obj->name ,"value" => $obj->slug);
        }
        return $menus;
    }
}
// **********************************************************************//
// ! Search form
// **********************************************************************//

if(!function_exists('etheme_search_form')) {
    function etheme_search_form( $search_view = '', $class = '') {

        if ( empty( $search_view ) ) {
            $search_view = etheme_get_option('search_view');
        }

        ?>
            <div class="header-search <?php echo esc_attr( $class ); ?>">
                <?php if($search_view == 'modal'): ?>
                    <div class="et-search-trigger">
                        <a class="popup-with-form" href="#searchModal"><i class="fa fa-search"></i> <span><?php esc_html_e('Search', 'woopress'); ?></span></a>
                    </div>
                <?php else : ?>
                    <div class="<?php echo ( $search_view == 'default' ) ? 'default-search' : 'et-search-trigger search-dropdown' ?>">
                        <div><i class="fa fa-search"></i></div>
                        <?php
                            if(!class_exists('WooCommerce')) {
                                get_search_form();
                            } else {
                                get_template_part('woosearchform');
                            }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php
    }
}

// **********************************************************************//
// ! Search form popup
// **********************************************************************//

add_action('after_page_wrapper', 'etheme_search_form_modal');
if(!function_exists('etheme_search_form_modal')) {
    function etheme_search_form_modal() {
        ?>
            <div id="searchModal" class="mfp-hide modal-type-1 zoom-anim-dialog" role="search">
                <div class="modal-dialog text-center">
                    <h3 class="large-h"><?php esc_html_e('Search engine', 'woopress'); ?></h3>
                    <small class="mini-text"><?php esc_html_e('Use this form to find things you need on this site', 'woopress'); ?></small>

                    <?php
                        if(!class_exists('WooCommerce')) {
                            get_search_form();
                        } else {
                            get_template_part('woosearchform');
                        }
                    ?>

                </div>
            </div>
        <?php
    }
}

add_action('wp_footer', 'etheme_right_click_html');
if(!function_exists('etheme_right_click_html')) {
    function etheme_right_click_html() {
        if ( ! etheme_get_option('disable_right_click') ) {
            return;
        }
        echo "<div class='credentials-html'>";
            echo "<div class='credentials-content'>";
                echo etheme_get_option('right_click_html');
            echo "</div>";
            echo "<div class='close-credentials'>close</div>";
        echo "</div>";
    }
}


// **********************************************************************//
// ! Add Facebook Open Graph Meta Data
// **********************************************************************//

//Adding the Open Graph in the Language Attributes
if(!function_exists('et_add_opengraph_doctype')) {
    function et_add_opengraph_doctype( $output ) {
        return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
    }
}
add_filter('language_attributes', 'et_add_opengraph_doctype');

//Lets add Open Graph Meta Info

if(!function_exists('et_insert_fb_in_head')) {
    function et_insert_fb_in_head() {
        global $post;
        $og_tags = etheme_get_option('disable_og_tags');

        if ( is_woopress_migrated() ) {
            if ( $og_tags  ) {
                $og_tags = array();
                $og_tags[0] = 1;
            } else {
                $og_tags = array();
                $og_tags[0] = 0;
            }
        }

        if ( !is_singular() || $og_tags[0] == 1) //if it is not a post or a page
            return;

            $description = et_excerpt( $post->post_content, $post->post_excerpt );
            $description = strip_tags($description);
            $description = str_replace("\"", "'", $description);

            echo '<meta property="og:title" content="' . get_the_title() . '"/>';
            echo '<meta property="og:type" content="article"/>';
            echo '<meta property="og:description" content="' . $description . '"/>';
            echo '<meta property="og:url" content="' . get_permalink() . '"/>';
            echo '<meta property="og:site_name" content="'. get_bloginfo('name') .'"/>';

            if(!has_post_thumbnail( $post->ID )) {
                $default_image = PARENT_URL . '/images/staticks/facebook-default.jpg';
                echo '<meta property="og:image" content="' . $default_image . '"/>';
            } else {
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
                echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
            }
            echo "";
    }
}
add_action( 'wp_head', 'et_insert_fb_in_head', 5 );

if(!function_exists('et_excerpt')) {
    function et_excerpt($text, $excerpt){
        if ($excerpt) return $excerpt;

        $text = strip_shortcodes( $text );

        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);
        $text = strip_tags($text);
        $excerpt_length = apply_filters('excerpt_length', 55);
        $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
        $words = preg_split("/[\n]+/", $text, intval($excerpt_length) + 1, PREG_SPLIT_NO_EMPTY);
        if ( count($words) > $excerpt_length ) {
                array_pop($words);
                $text = implode(' ', $words);
                $text = $text . $excerpt_more;
        } else {
                $text = implode(' ', $words);
        }

        return apply_filters('wp_trim_excerpt', $text, $excerpt);
        }
}

if ( !function_exists('et_check_captcha') ) {
    function et_check_captcha($greresponse = false){
        if ( $greresponse ) {
            $secret = etheme_get_option('google_captcha_secret');
            if ( function_exists( 'wp_remote_get' ) ) {
                $response = wp_remote_get( "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$greresponse}" );
                $response = wp_remote_retrieve_body( $response );
                $verify   = json_decode( $response );
                if ( $verify->success == true ) {
                    return true;
                }
            }
        }
        return false;
    }
}

if ( !function_exists('et_display_captcha') ) {
    function et_display_captcha(){

        $gcaptcha = etheme_get_option('google_captcha_site');

        if ( ! $gcaptcha ) {
            return;
        }
        $rand = rand(100,1000);
        ?>
            <div id="recaptcha-<?php echo esc_attr( $rand ); ?>" class="g-recaptcha" data-sitekey="<?php echo esc_attr( $gcaptcha ); ?>"></div>
            <span class="et_reset hidden"></span>
            <script type="text/javascript">
                CaptchaCallback = function() {
                    var grecaptcha_id = {};

                    jQuery('.et-register-form, .contact-form ').each(function(){
                        var id = jQuery(this).find( '.g-recaptcha' ).attr( 'id' );

                        grecaptcha_id[id] = grecaptcha.render( id, { 'sitekey' : '<?php echo esc_attr( $gcaptcha ); ?>' });

                        jQuery(this).find( '.et_reset' ).bind( 'click', function(){
                            grecaptcha.reset(grecaptcha_id[id]);
                        });
                    });
                };
            </script>
        <?php
    }
}
// **********************************************************************//
// ! Registration Form
// **********************************************************************//

if(!function_exists('et_register_form')) {
    function et_register_form($args = array()) {
        $rand = rand(100,1000);
        ?>
            <form class="et-register-form form-<?php echo esc_attr( $rand ); ?>" action="" method="get">
                <div id="register-popup-result">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" class="loader hidden" />
                </div>
                <div class="login-fields">
                    <p class="form-row">
                        <label class=""><?php esc_html_e( "Enter your username", 'woopress' ) ?> <span class="required">*</span></label>
                        <input type="text" name="username" class="text input-text" />
                    </p>
                    <p class="form-row">
                        <label class=""><?php esc_html_e( "Enter your E-mail address", 'woopress' ) ?> <span class="required">*</span></label>
                        <input type="text" name="email" class="text input-text" />
                    </p>
                    <p class="form-row">
                        <label class=""><?php esc_html_e( "Enter your password", 'woopress' ) ?> <span class="required">*</span></label>
                        <input type="password" name="et_pass" class="text input-text" />
                    </p>
                    <p class="form-row">
                        <label class=""><?php esc_html_e( "Re-enter your password", 'woopress' ) ?> <span class="required">*</span></label>
                        <input type="password" name="et_pass2" class="text input-text" />
                    </p>
                    
                    <?php if ( etheme_get_option( 'privacy_registration' ) ): ?>
                        <p class="form-row privacy-policy">
                            <?php echo etheme_get_option( 'privacy_registration' ); ?>
                        </p>
                    <?php endif ?>

                </div>
                
                <p class="form-row">
                    <input type="hidden" name="et_register" value="1">
                    <button class="btn btn-black big text-center submitbtn" type="submit"><span><?php esc_html_e( "Register", 'woopress' ) ?></span></button>
                </p>

                <?php et_display_captcha(); ?>
            </form>
        <?php
    }
}


// **********************************************************************//
// ! Send message from contact form
// **********************************************************************//

add_action( 'wp_ajax_et_send_msg_action', 'et_send_msg_action' );
add_action( 'wp_ajax_nopriv_et_send_msg_action', 'et_send_msg_action' );
if(!function_exists('et_send_msg_action')) {
    function et_send_msg_action() {


        if(isset($_GET['contact-submit'])) {
            header("Content-type: application/json");
            $name = '';
            $email = '';
            $website = '';
            $message = '';
            $reciever_email = '';
            $return = array();

            if ( etheme_get_option('google_captcha_site') && etheme_get_option('google_captcha_secret') ) {
                if ( et_check_captcha($_GET['greresponse']) != true ) {
                    $return['status'] = 'error';
                    $return['msg'][] = esc_html__('The security code you entered did not match. Please try again.', 'woopress');
                    echo json_encode($return);
                    die();
                }
            }

            if( trim( $_GET['contact-name'] ) === '') $return['msg'][] = esc_html__( 'fill in the "Name and Surname" field.', 'woopress' );

            if( trim( $_GET['contact-email'] ) === '' || !isValidMail( $_GET['contact-email'] ) ) $return['msg'][] = esc_html__( 'Please enter a valid email.', 'woopress' );

            if( trim( $_GET['contact-msg'] ) === '') $return['msg'][] = esc_html__( 'fill in the "Message" field.', 'woopress' );

            // Check if we have errors

            if( ! isset( $return['msg'] ) ) {
                $name = trim($_GET['contact-name']);
                $email = trim($_GET['contact-email']);
                $message = trim($_GET['contact-msg']);
                $website = stripslashes(trim($_GET['contact-website']));

                // Get the received email
                $reciever_email = etheme_get_option('contacts_email');

                $subject = 'You have been contacted by ' . $name;

                $body = "You have been contacted by $name. Their message is: " . PHP_EOL . PHP_EOL;
                $body .= $message . PHP_EOL . PHP_EOL;
                $body .= "You can contact $name via email at $email";
                if ($website != '') {
                    $body .= " and visit their website at $website" . PHP_EOL . PHP_EOL;
                }
                $body .= PHP_EOL . PHP_EOL;

                $headers = "From $email ". PHP_EOL;
                $headers .= "Reply-To: $email". PHP_EOL;
                $headers .= "MIME-Version: 1.0". PHP_EOL;
                $headers .= "Content-type: text/plain; charset=utf-8". PHP_EOL;
                $headers .= "Content-Transfer-Encoding: quoted-printable". PHP_EOL;

                if( ! woopress_plugin_notice() && etheme_mail($reciever_email, $subject, $body, $headers) ) {
                    $return['status'] = 'success';
                    $return['msg'][] = esc_html__('All is well, your email has been sent.', 'woopress');
                } else{
                    $return['status'] = 'error';
                    $return['msg'][] = esc_html__('Error while sending a message!', 'woopress');
                }

            }else{
                // Return errors
                $return['status'] = 'error';
            }

            echo json_encode($return);
            die();
        }
    }
}
// **********************************************************************//
// ! Registration
// **********************************************************************//
add_action( 'wp_ajax_et_register_action', 'et_register_action' );
add_action( 'wp_ajax_nopriv_et_register_action', 'et_register_action' );
if(!function_exists('et_register_action')) {
    function et_register_action() {
        global $wpdb, $user_ID;

        if( ! empty( $_POST['input_data'] ) ){

            // Get post data
            parse_str( $_POST['input_data'] );

            //Setup the values
            $username = esc_sql( $username );
            $email = esc_sql( $email );
            $pass = esc_sql( $et_pass );
            $pass2 = esc_sql( $et_pass2 );

            if ( etheme_get_option('google_captcha_site') && etheme_get_option('google_captcha_secret') ) {
                if ( et_check_captcha($greresponse) != true ) {
                    $return['status'] = 'error';
                    $return['msg'][] = esc_html__('The security code you entered did not match. Please try again.', 'woopress');
                    echo json_encode($return);
                    die();
                }
            }

            if( empty( $username ) ) $return['msg'][] = esc_html__( "User name should not be empty.", 'woopress' );

            if( ! preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email ) )  $return['msg'][] = esc_html__( "Please enter a valid email.", 'woopress' );

            if( empty( $pass ) || strlen( $pass ) < 5 ) $return['msg'][] = esc_html__( "Password should have more than 5 symbols", 'woopress' );

            if( empty( $pass2 ) || strlen( $pass2 ) < 5 ) $return['msg'][] = esc_html__( "Re-enter password should have more than 5 symbols", 'woopress' );

            if( $pass != $pass2 ) $return['msg'][] = esc_html__( "The passwords do not match", 'woopress' );

            if ( email_exists( $email ) ) $return['msg'][] = esc_html__( "That email already exists. Please try another one.", 'woopress' );

            if ( username_exists( $username ) ) $return['msg'][] = esc_html__( "Username already exists. Please try another one.", 'woopress' );

            if ( isset( $return['msg'] ) ) {
                $return['status'] = 'error';
                echo json_encode( $return );
                die();
            } else {

                wp_create_user( $username, $pass, $email );

                $from = get_bloginfo( 'name' );
                $from_email = get_bloginfo( 'admin_email' );
                $headers = 'From: '.$from . " <". $from_email .">\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8". PHP_EOL;
                $headers .= "Content-Transfer-Encoding: quoted-printable". PHP_EOL;

                $subject = esc_html__( "Registration successful", 'woopress' );
                $subject2admin = esc_html__( "New user registration", 'woopress' );
                $message = et_registration_email( $username );
                $message2admin = et_registration_admin_email( $username );

                if ( ! woopress_plugin_notice() ) {
                    etheme_mail( $email, $subject, $message, $headers );
                    etheme_mail( get_option('admin_email'), $subject2admin, $message2admin, $headers );
                    $return['status'] = 'success';
                    $return['msg'] = esc_html__( "Please check your email for login details.", 'woopress' );
                } else {
                    $return['status'] = 'error';
                    $return['msg'] = esc_html__( "To use this element install/activate or update woopress Core plugin", 'woopress' );
                }

                echo json_encode( $return );
            }
            die();
        }
    }
}


if(!function_exists('et_registration_email')) {
    function et_registration_email($username = '') {
        global $woocommerce;
        $logoimg = etheme_get_option('logo');
        ob_start(); ?>
            <div style="background-color: #f5f5f5;width: 100%;-webkit-text-size-adjust: none;margin: 0;padding: 70px 0 70px 0;">
                <div style="-webkit-box-shadow: 0 0 0 3px rgba(0,0,0,0.025) ;box-shadow: 0 0 0 3px rgba(0,0,0,0.025);-webkit-border-radius: 6px;border-radius: 6px ;background-color: #fdfdfd;border: 1px solid #dcdcdc; padding:20px; margin:0 auto; width:500px; max-width:100%; color: #737373; font-family:Arial; font-size:14px; line-height:150%; text-align:left;">
                    <?php if($logoimg): ?>
                        <a href="<?php echo home_url(); ?>" style="display:block; text-align:center;"><img style="max-width:100%;" src="<?php echo apply_filters( 'etheme_logo_src', $logoimg ); ?>" alt="<?php bloginfo( 'description' ); ?>" /></a>
                    <?php else: ?>
                        <a href="<?php echo home_url(); ?>" style="display:block; text-align:center;"><img style="max-width:100%;" src="<?php echo PARENT_URL.'/images/logo.png'; ?>" alt="<?php bloginfo('name'); ?>"></a>
                    <?php endif ; ?>
                    <p><?php printf(__('Thanks for creating an account on %s. Your username is %s.', 'woopress'), get_bloginfo( 'name' ), $username);?></p>
                    <?php if (class_exists('Woocommerce')): ?>

                        <p><?php printf(__('You can access your account area to view your orders and change your password here: <a href="%s">%s</a>.', 'woopress'), get_permalink( get_option('woocommerce_myaccount_page_id') ), get_permalink( get_option('woocommerce_myaccount_page_id') ));?></p>

                    <?php endif; ?>

                </div>
            </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

if(!function_exists('et_registration_admin_email')) {
    function et_registration_admin_email($username = '') {
        global $woocommerce;
        $logoimg = etheme_get_option('logo');
        ob_start(); ?>
            <div style="background-color: #f5f5f5;width: 100%;-webkit-text-size-adjust: none;margin: 0;padding: 70px 0 70px 0;">
                <div style="-webkit-box-shadow: 0 0 0 3px rgba(0,0,0,0.025) ;box-shadow: 0 0 0 3px rgba(0,0,0,0.025);-webkit-border-radius: 6px;border-radius: 6px ;background-color: #fdfdfd;border: 1px solid #dcdcdc; padding:20px; margin:0 auto; width:500px; max-width:100%; color: #737373; font-family:Arial; font-size:14px; line-height:150%; text-align:left;">
                    <?php if($logoimg): ?>
                        <a href="<?php echo home_url(); ?>" style="display:block; text-align:center;"><img style="max-width:100%;" src="<?php echo apply_filters( 'etheme_logo_src', $logoimg ); ?>" alt="<?php bloginfo( 'description' ); ?>" /></a>
                    <?php else: ?>
                        <a href="<?php echo home_url(); ?>" style="display:block; text-align:center;"><img style="max-width:100%;" src="<?php echo PARENT_URL.'/images/logo.png'; ?>" alt="<?php bloginfo('name'); ?>"></a>
                    <?php endif ; ?>
                    <p><?php printf(__('New user registration on %s. Username: %s.', 'woopress'), get_bloginfo( 'name' ), $username);?></p>

                </div>
            </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

// **********************************************************************//
// ! Add page to search results
// **********************************************************************//
add_filter( 'pre_get_posts', 'et_search_filter' );
if ( !function_exists('et_search_filter') ) {
    function et_search_filter( $query ) {
        if ( ! is_admin() ) {
            if ( isset($query->query['post_type']) ) {
                if ( $query->is_search && $query->query['post_type'] == 'post') {
                    $query->set( 'post_type', array( 'post', 'page' ) );
                }
            }
            return $query;
        }
    }
}

// **********************************************************************//
// ! Header Type
// **********************************************************************//
function get_header_type() {

    $ht = etheme_get_custom_field( 'current_header_type', et_get_page_id() ) ? etheme_get_custom_field( 'current_header_type', et_get_page_id() ) : etheme_get_option('header_type');

    $layout = etheme_get_option('main_layout');
    if($layout == 'boxed' && ($ht == 'vertical' || $ht == 'vertical2')) {
        $ht = 1;
    }
    return $ht;
}

add_filter('custom_header_filter', 'get_header_type',10);

function etheme_get_header_structure($ht) {
    switch ($ht) {
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
        case 9:
            return 1;
            break;
        case 6:
        case 7:
        case 18:
            return 2;
            break;
        case 8:
        case 10:
            return 3;
            break;
        case 11:
        case 12:
            return 4;
            break;

        case 14:
        case 'vertical':
        case 'vertical2':
            return 5;
            break;
        case 17:
            return 6;
            break;
        case 19:
            return 7;
            break;
        case 6:
        default:
            return 1;
            break;
    }
}


// **********************************************************************//
// ! Footer Type
// **********************************************************************//
function get_footer_type() {
    return etheme_get_option('footer_type');
}

add_filter('custom_footer_filter', 'get_footer_type',10);


// **********************************************************************//
// ! Function to display comments
// **********************************************************************//


if(!function_exists('etheme_comments')) {
    function etheme_comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        $comment_type = get_comment_type();
        if(in_array($comment_type, array('pingback', 'trackback') ) ) :
            ?>

            <li id="comment-<?php comment_ID(); ?>" class="pingback">
                <div class="comment-block row">
                    <div class="col-md-12">
                        <div class="author-link"><?php esc_html_e('Pingback:', 'woopress') ?></div>
                        <div class="comment-reply"> <?php edit_comment_link(); ?></div>
                        <?php comment_author_link(); ?>

                    </div>
                </div>
                <div class="media">
                    <h4 class="media-heading"><?php esc_html_e('Pingback:', 'woopress') ?></h4>

                    <?php comment_author_link(); ?>
                    <?php edit_comment_link(); ?>
                </div>
            <?php

        elseif(in_array($comment_type, array('comment', 'review'))) :
        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ); ?>



            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                <div class="media">
                    <div class="pull-left">
                        <?php
                            $avatar_size = 80;
                            echo get_avatar($comment, $avatar_size);
                         ?>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><?php comment_author_link(); ?></h4>
                        <div class="meta-comm">
                            <?php comment_date(); ?> - <?php comment_time(); ?>
                        </div>

                    </div>

                    <?php if ($comment->comment_approved == '0'): ?>
                        <p class="awaiting-moderation"><?php esc_html__('Your comment is awaiting moderation.', 'woopress') ?></p>
                    <?php endif ?>

                    <?php comment_text(); ?>
                    <?php comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply to comment', 'woopress'),'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>

                    <?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

                        <div class="star-rating" title="<?php echo sprintf( esc_html__( 'Rated %d out of 5', 'woopress' ), $rating ) ?>">
                            <span style="width:<?php echo ( esc_attr( $rating ) / 5 ) * 100; ?>%"><strong><?php echo esc_html( $rating ); ?></strong> <?php esc_html_e( 'out of 5', 'woopress' ); ?></span>
                        </div>

                    <?php endif; ?>


                </div>

        <?php endif;
    }
}

// **********************************************************************//
// ! Custom Comment Form
// **********************************************************************//

if(!function_exists('etheme_custom_comment_form')) {
    function etheme_custom_comment_form($defaults) {
        $defaults['comment_notes_before'] = '
            <p class="comment-notes">
                <span id="email-notes">
                ' . esc_html__( 'Your email address will not be published. Required fields are marked', 'woopress' ) . '
                </span>
            </p>
            ';
        $defaults['comment_notes_after'] = '';
        $dafaults['id_form'] = 'comments_form';

        $defaults['comment_field'] = '
            <div class="form-group">
                <label for="comment" class="control-label">'.esc_html__('Comment', 'woopress').'</label>
                <textarea placeholder="' . esc_html__('Comment', 'woopress') . '" class="form-control required-field"  id="comment" name="comment" cols="45" rows="12" aria-required="true"></textarea>
            </div>
        ';

        return $defaults;
    }
}

add_filter('comment_form_defaults', 'etheme_custom_comment_form');

if(!function_exists('etheme_custom_comment_form_fields')) {
    function etheme_custom_comment_form_fields() {
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $reqT = '<span class="required">*</span>';
        $aria_req = ($req ? " aria-required='true'" : ' ');
        $consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
        $fields = array(
            'author' => '<div class="form-group comment-form-author">'.
                            '<label for="author" class="control-label">'.__('Name', 'woopress').' '.($req ? $reqT : '').'</label>'.
                            '<input id="author" name="author" type="text" class="form-control ' . ($req ? ' required-field' : '') . '" value="' . esc_attr($commenter['comment_author']) . '" size="30" ' . $aria_req . '>'.
                        '</div>',
            'email' => '<div class="form-group comment-form-email">'.
                            '<label for="email" class="control-label">'.__('Email', 'woopress').' '.($req ? $reqT : '').'</label>'.
                            '<input id="email" name="email" type="text" class="form-control ' . ($req ? ' required-field' : '') . '" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" ' . $aria_req . '>'.
                        '</div>',
            'url' => '<div class="form-group comment-form-url">'.
                            '<label for="url" class="control-label">'.__('Website', 'woopress').'</label>'.
                            '<input id="url" name="url" type="text" class="form-control" value="' . esc_attr($commenter['comment_author_url']) . '" size="30">'.
                        '</div>',
            'cookies' => '
                <p class="comment-form-cookies-consent">
                    <label for="wp-comment-cookies-consent">
                        <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' . '
                        <span>' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'woopress' ) . '</span>
                    </label>
                </p>'
        );

        return $fields;
    }
}

add_filter('comment_form_default_fields', 'etheme_custom_comment_form_fields');
// **********************************************************************//
// ! Register Sidebars
// **********************************************************************//

if(function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => esc_html__('Main Sidebar', 'woopress'),
        'id' => 'main-sidebar',
        'description' => esc_html__('Sidebar that appears on the pages and posts.', 'woopress'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Shop Sidebar', 'woopress'),
        'id' => 'shop-sidebar',
        'description' => esc_html__('Sidebar that appears on Shop page.', 'woopress'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Additional Shop Widget area', 'woopress'),
        'id' => 'shop-widgets-area',
        'description' => esc_html__('Widget area that appears above the products on Shop page', 'woopress'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Single product page Sidebar', 'woopress'),
        'id' => 'single-sidebar',
        'description' => esc_html__('Sidebar that appears on the single product page.', 'woopress'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));

    if(function_exists('is_bbpress')){
        register_sidebar(array(
            'name' => esc_html__('Forum Sidebar', 'woopress'),
            'id' => 'forum-sidebar',
            'description' => esc_html__('Sidebar for bbPress forum', 'woopress'),
            'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
            'after_widget' => '</div><!-- //sidebar-widget -->',
            'before_title' => '<h4 class="widget-title"><span>',
            'after_title' => '</span></h4>',
        ));
    }

    register_sidebar(array(
        'name' => esc_html__('Left side top bar area', 'woopress'),
        'id' => 'languages-sidebar',
        'description' => esc_html__('Can be used for placing languages switcher of some contacts information.', 'woopress'),
        'before_widget' => '<div id="%1$s" class="topbar-widget %2$s">',
        'after_widget' => '</div><!-- //topbar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Right side top bar area', 'woopress'),
        'id' => 'top-bar-right',
        'before_widget' => '<div id="%1$s" class="topbar-widget %2$s">',
        'after_widget' => '</div><!-- //topbar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Mobile navigation sidebar', 'woopress'),
        'id' => 'mobile-sidebar',
        'description' => esc_html__('Area in a hidden sidebar on mobile devices, after navigation.', 'woopress'),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 1', 'woopress'),
        'id' => 'footer1',
        'description' => 'Appears in the footer section of the site',
        'before_widget' => '<div id="%1$s" class="footer-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //footer-sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 2', 'woopress'),
        'id' => 'footer2',
        'description' => 'Appears in the footer section of the site',
        'before_widget' => '<div id="%1$s" class="footer-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Footer Copyright', 'woopress'),
        'id' => 'footer9',
        'description' => 'Appears at left side of the footer section of the site.',
        'before_widget' => '<div id="%1$s" class="footer-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //footer-sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Links', 'woopress'),
        'id' => 'footer10',
        'description' => 'Appears at right side of the footer section of the site.',
        'before_widget' => '<div id="%1$s" class="footer-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //footer-sidebar-widget -->',
        'before_title' => '<h4 class="widget-title"><span>',
        'after_title' => '</span></h4>',
    ));
}

// **********************************************************************//
// ! Set exerpt
// **********************************************************************//
if ( !function_exists('etheme_excerpt_length') ) {
    function etheme_excerpt_length( $length ) {
        return 15;
    }
}

add_filter( 'excerpt_length', 'etheme_excerpt_length', 999 );

if ( !function_exists('etheme_excerpt_more') ) {
    function etheme_excerpt_more( $more ) {
        return '...';
    }
}

add_filter('excerpt_more', 'etheme_excerpt_more');

// **********************************************************************//
// ! Contact page functions
// **********************************************************************//
if(!function_exists('isValidMail')){
    function isValidMail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

add_action("wp_ajax_et_close_promo", "et_close_promo");
add_action("wp_ajax_nopriv_et_close_promo", "et_close_promo");
if(!function_exists('et_close_promo')) {
    function et_close_promo() {
        $versionsUrl = 'http://8theme.com/import/';
        $ver = 'promo';
        $folder = $versionsUrl.''.$ver;

        $txtFile = $folder.'/woopress.txt';
        $file_headers = @get_headers($txtFile);

        $etag = $file_headers[4];
        update_option('et_close_promo_etag', $etag);
        die();
    }
}

/***************************************************************/
/* Etheme Global Search */
/***************************************************************/

add_action("wp_ajax_et_get_search_result", "et_get_search_result");
add_action("wp_ajax_nopriv_et_get_search_result", "et_get_search_result");
if(!function_exists('et_get_search_result')) {
    function et_get_search_result() {
        $word = esc_attr(stripslashes($_REQUEST['s']));
        if(isset($word) && $word != '') {
            $response = array(
                'results' => false,
                'html' => ''
            );

            if(isset($_GET['count'])) {
                $count = $_GET['count'];
            } else {
                $count = 3;
            }


            if($_GET['products'] && class_exists('WooCommerce')) {
                $products_args = array(
                    'args' => array(
                        'post_type' => 'product',
                        'posts_per_page' => $count,
                        's' => $word
                    ),
                    'image' => $_GET['images'],
                    'link' => true,
                    'title' => esc_html__('View Products', 'woopress'),
                    'class' => 'et-result-products'
                );
                $products = et_search_get_result($products_args);
                if($products) {
                    $response['results'] = true;
                    $response['html'] .= $products;
                }
            }

            if($_GET['posts']) {
                $posts_args = array(
                    'args' => array(
                        'post_type' => 'post',
                        'posts_per_page' => $count,
                        's' => $word
                    ),
                    'title' => esc_html__('From the blog', 'woopress'),
                    'image' => $_GET['images'],
                    'link' => true,
                    'class' => 'et-result-post'
                );
                $posts = et_search_get_result($posts_args);
                if($posts) {
                    $response['results'] = true;
                    $response['html'] .= $posts;
                }
            }


            if($_GET['portfolio']) {
                $portfolio_args = array(
                    'args' => array(
                        'post_type' => 'etheme_portfolio',
                        'posts_per_page' => $count,
                        's' => $word
                    ),
                    'image' => $_GET['images'],
                    'link' => false,
                    'title' => esc_html__('Portfolio', 'woopress'),
                    'class' => 'et-result-portfolio'
                );
                $portfolio = et_search_get_result($portfolio_args);
                if($portfolio) {
                    $response['results'] = true;
                    $response['html'] .= $portfolio;
                }
            }

            if($_GET['pages']) {
                $pages_args = array(
                    'args' => array(
                        'post_type' => 'page',
                        'posts_per_page' => $count,
                        's' => $word
                    ),
                    'image' => $_GET['images'],
                    'link' => false,
                    'title' => esc_html__('Pages', 'woopress'),
                    'class' => 'et-result-pages'
                );
                $pages = et_search_get_result($pages_args);
                if($pages) {
                    $response['results'] = true;
                    $response['html'] .= $pages;
                }
            }

            if($_GET['testimonial']) {
                $testimonial_args = array(
                    'args' => array(
                        'post_type' => 'testimonial',
                        'posts_per_page' => $count,
                        's' => $word
                    ),
                    'image' => $_GET['images'],
                    'link' => false,
                    'title' => esc_html__('Testimonial', 'woopress'),
                    'class' => 'et-result-testimonial'
                );
                $testimonial = et_search_get_result($testimonial_args);
                if($testimonial) {
                    $response['results'] = true;
                    $response['html'] .= $testimonial;
                }
            }

            echo json_encode($response);

            die();
        } else {
            die();
        }
    }
}


if(!function_exists('et_search_get_result')) {
    function et_search_get_result($args) {
        extract($args);
        $query = new WP_Query( $args );

        // The Loop
        if ( $query->have_posts() ) {

            ob_start();
            if($title != '') {
                ?>

                    <h5 class="title"><span><?php if($link): ?><a href="<?php echo esc_url( get_home_url().'/?s='.$args['s'].'&post_type='.$args['post_type'] ); ?>" title="<?php echo esc_attr(__('Show all', 'woopress')); ?>"><?php endif; ?>
                        <?php echo esc_html( $title ); ?>
                    <?php if($link): ?>&rarr;</a><?php endif; ?></span></h5>

                <?php
            }
            ?>
                <ul class="<?php echo esc_attr($class); ?>">
                    <?php
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            ?>
                                <li>
                                    <?php if($image && has_post_thumbnail( get_the_ID() )): ?>
                                        <?php $src = etheme_get_image(get_post_thumbnail_id( get_the_ID() ),30,30,false); ?>
                                        <img src="<?php echo esc_url( $src ); ?>" />
                                    <?php endif; ?>


                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo get_the_title(); ?>
                                    </a>

                                </li>
                            <?php
                        }
                    ?>
                </ul>
            <?php
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        } else {
            return false;
        }
        /* Restore original Post Data */
        wp_reset_postdata();
        return;
    }
}



// **********************************************************************//
// ! Posted info
// **********************************************************************//
if(!function_exists('etheme_posted_info')) {
    function etheme_posted_info ($title = ''){
        $posted_by = '<div class="post-info">';
        $posted_by .= '<span class="posted-on">';
        $posted_by .= esc_html__('Posted on', 'woopress').' ';
        $posted_by .= get_the_time(get_option('date_format')).' ';
        $posted_by .= get_the_time(get_option('time_format')).' ';
        $posted_by .= '</span>';
        $posted_by .= '<span class="posted-by"> '.__('by', 'woopress').' '.get_the_author_link().'</span>';
        $posted_by .= '</div>';
        return $title.$posted_by;
    }
}

// **********************************************************************//
// ! Posts Teaser Grid
// **********************************************************************//
if(!function_exists('etheme_teaser')) {
    function etheme_teaser($atts, $content = null) {
        $title = $grid_columns_count = $grid_teasers_count = $grid_layout = $grid_link = $grid_link_target = $pagination = '';
        $grid_template = $grid_thumb_size = $grid_posttypes =  $grid_taxomonies = $grid_categories = $posts_in = $posts_not_in = '';
        $grid_content = $el_class = $width = $orderby = $order = $el_position = $isotope_item = $isotope_class = $posted_by = $posted_block = $hover_mask = $border = '';
        extract(shortcode_atts(array(
            'title' => '',
            'grid_columns_count' => 4,
            'grid_teasers_count' => 8,
            'grid_layout' => 'title_thumbnail_text', // title_thumbnail_text, thumbnail_title_text, thumbnail_text, thumbnail_title, thumbnail, title_text
            'grid_link' => 'link_post', // link_post, link_image, link_image_post, link_no
            'grid_link_target' => '_self',
            'grid_template' => 'grid', //grid, carousel
            'grid_thumb_size' => '500x300',
            'grid_posttypes' => '',
            'border' => 'on',
            'pagination' => 'show',
            'posted_block' => 'show',
            'hover_mask' => 'show',
            'grid_taxomonies' => '',
            'grid_categories' => '',
            'posts_in' => '',
            'posts_not_in' => '',
            'grid_content' => 'teaser', // teaser, content
            'el_class' => '',
            'width' => '1/1',
            'orderby' => NULL,
            'order' => 'DESC',
            'el_position' => ''
        ), $atts));

        if ( $grid_template == 'grid' || $grid_template == 'filtered_grid') {
            $isotope_item = 'et_isotope-item ';
        } else if ( $grid_template == 'carousel' ) {
            $isotope_item = '';
        }

        $output = '';

        $el_class = WPBakeryShortCode::getExtraClass( $el_class );
        $width = '';//wpb_translateColumnWidthToSpan( $width );
        $col = 12/$grid_columns_count;
        $li_span_class = 'col-lg-'.$col;


        $query_args = array();

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if(is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        }

        $query_args['paged'] = $paged;

        $not_in = array();
        if ( $posts_not_in != '' ) {
            $posts_not_in = str_ireplace(" ", "", $posts_not_in);
            $not_in = explode(",", $posts_not_in);
        }

        $link_target = $grid_link_target=='_blank' ? ' target="_blank"' : '';


        //exclude current post/page from query
        if ( $posts_in == '' ) {
            global $post;
            array_push($not_in, $post->ID);
        }
        else if ( $posts_in != '' ) {
            $posts_in = str_ireplace(" ", "", $posts_in);
            $query_args['post__in'] = explode(",", $posts_in);
        }
        if ( $posts_in == '' || $posts_not_in != '' ) {
            $query_args['post__not_in'] = $not_in;
        }

        // Post teasers count
        if ( $grid_teasers_count != '' && !is_numeric($grid_teasers_count) ) $grid_teasers_count = -1;
        if ( $grid_teasers_count != '' && is_numeric($grid_teasers_count) ) $query_args['posts_per_page'] = $grid_teasers_count;

        // Post types
        $pt = array();
        if ( $grid_posttypes != '' ) {
            $grid_posttypes = explode(",", $grid_posttypes);
            foreach ( $grid_posttypes as $post_type ) {
                array_push($pt, $post_type);
            }
            $query_args['post_type'] = $pt;
        }

        // Taxonomies

        $taxonomies = array();
        if ( $grid_taxomonies != '' ) {
            $grid_taxomonies = explode(",", $grid_taxomonies);
            foreach ( $grid_taxomonies as $taxom ) {
                array_push($taxonomies, $taxom);
            }
        }

        // Narrow by categories
        if ( $grid_categories != '' ) {
            $grid_categories = explode(",", $grid_categories);
            $gc = array();
            foreach ( $grid_categories as $grid_cat ) {
                array_push($gc, $grid_cat);
            }
            $gc = implode(",", $gc);
            ////http://snipplr.com/view/17434/wordpress-get-category-slug/
            $query_args['category_name'] = $gc;

            $taxonomies = get_taxonomies('', 'object');
            $query_args['tax_query'] = array('relation' => 'OR');
            foreach ( $taxonomies as $t ) {
                if ( in_array($t->object_type[0], $pt) ) {
                    $query_args['tax_query'][] = array(
                        'taxonomy' => $t->name,//$t->name,//'portfolio_category',
                        'terms' => $grid_categories,
                        'field' => 'slug',
                    );
                }
            }
        }

        // Order posts
        if ( $orderby != NULL ) {
            $query_args['orderby'] = $orderby;
        }
        $query_args['order'] = $order;

        // Run query
        $my_query = new WP_Query($query_args);
        //global $_wp_additional_image_sizes;

        $teasers = '';
        $teaser_categories = Array();
        if($grid_template == 'filtered_grid' && empty($grid_taxomonies)) {
            $taxonomies = get_object_taxonomies(!empty($query_args['post_type']) ? $query_args['post_type'] : get_post_types(array('public' => false, 'name' => 'attachment'), 'names', 'NOT'));
        }

        if($posted_block == 'show') {
            add_filter('vc_teaser_grid_title', 'etheme_posted_info');
        }

        $posts_Ids = array();

        while ( $my_query->have_posts() ) {
            $link_title_start = $link_image_start = $p_link = $link_image_end = $p_img_large = '';

            $my_query->the_post();

            $posts_Ids[] = $my_query->post->ID;


            $categories_css = '';
            if( $grid_template == 'filtered_grid' ) {
                /** @var $post_cate``gories get list of categories */
                // $post_categories = get_the_category($my_query->post->ID);
                $post_categories = wp_get_object_terms($my_query->post->ID, ($taxonomies));
                if(!is_wp_error($post_categories)) {
                    foreach($post_categories as $cat) {
                        if(!in_array($cat->term_id, $teaser_categories)) {
                            $teaser_categories[] = $cat->term_id;
                        }
                        $categories_css .= ' grid-cat-'.$cat->term_id;
                    }
                }

            }
            $post_title = the_title("", "", false);
            $post_id = $my_query->post->ID;

            $teaser_post_type = 'posts_grid_teaser_'.$my_query->post->post_type . ' ';
            if($grid_content == 'teaser') {
                $content = apply_filters('the_excerpt', get_the_excerpt());
            } else {
                $content = get_the_content();
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]&gt;', $content);
            }

            // $content = ( $grid_content == 'teaser' ) ? apply_filters('the_excerpt', get_the_excerpt()) : get_the_content(); //TODO: get_the_content() rewrite more WP native way.
            $content = wpautop($content);
            $link = '';
            $thumbnail = '';

            // Read more link
            if ( $grid_link != 'link_no' ) {
                $link = '<a class="more-link" href="'. get_permalink($post_id) .'"'.$link_target.' title="'. esc_attr__( 'Permalink to ', 'woopress' ) . the_title_attribute( 'echo=0' ) .'">'. esc_html__("Read more", "woopress") .'</a>';
            }

            // Thumbnail logic
            if ( in_array($grid_layout, array('title_thumbnail_text', 'thumbnail_title_text', 'thumbnail_text', 'thumbnail_title', 'thumbnail', 'title_text') ) ) {
                $post_thumbnail = $p_img_large = '';
                //$attach_id = get_post_thumbnail_id($post_id);

                $post_thumbnail = wpb_getImageBySize(array( 'post_id' => $post_id, 'thumb_size' => $grid_thumb_size ));
                $thumbnail = $post_thumbnail['thumbnail'];
                $p_img_large = $post_thumbnail['p_img_large'];
            }

            // Link logic
            if ( $grid_link != 'link_no' ) {
                $p_video = '';
                if ( $grid_link == 'link_image' || $grid_link == 'link_image_post' ) {
                    $p_video = get_post_meta($post_id, "_p_video", true);
                }

                if ( $grid_link == 'link_post' ) {
                    $link_image_start = '<a class="link_image" href="'.get_permalink($post_id).'"'.$link_target.' title="'. esc_attr__( 'Permalink to ', 'woopress' ) . the_title_attribute( 'echo=0' ).'">';
                    $link_title_start = '<a class="link_title" href="'.get_permalink($post_id).'"'.$link_target.' title="'.esc_attr__( 'Permalink to ', 'woopress' ) . the_title_attribute( 'echo=0' ) .'">';
                }
                else if ( $grid_link == 'link_image' ) {
                    if ( $p_video != "" ) {
                        $p_link = $p_video;
                    } else {
                        $p_link = $p_img_large[0];
                    }
                    $link_image_start = '<a class="link_image prettyphoto" href="'.$p_link.'"'.$link_target.' title="'.the_title_attribute('echo=0').'">';
                    $link_title_start = '<a class="link_title prettyphoto" href="'.$p_link.'"'.$link_target.' title="'.the_title_attribute('echo=0').'">';
                }
                else if ( $grid_link == 'link_image_post' ) {
                    if ( $p_video != "" ) {
                        $p_link = $p_video;
                    } else {
                        $p_link = $p_img_large[0];
                    }
                    $link_image_start = '<a class="link_image prettyphoto" href="'.$p_link.'"'.$link_target.' title="'.the_title_attribute('echo=0').'">';
                    $link_title_start = '<a class="link_title" href="'.get_permalink($post_id).'"'.$link_target.' title="'. esc_attr__( 'Permalink to ', 'woopress' ) .  the_title_attribute( 'echo=0' ) .'">';
                }
                $link_title_end = $link_image_end = '</a>';
            } else {
                $link_image_start = '';
                $link_title_start = '';
                $link_title_end = $link_image_end = '';
            }

            if($hover_mask == 'show') {
                $link_image_end .= '
                    <div class="zoom">
                        <div class="btn_group">
                            <a href="'.etheme_get_image(get_post_thumbnail_id($post_id)).'" rel="lightbox"><span>View large</span></a>
                            <a href="'.get_permalink($post_id).'"><span>More details</span></a>
                        </div>
                        <i class="bg"></i>
                    </div>
                ';
            }

            $teasers .= '<div class="'.$isotope_item.apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $li_span_class, 'vc_teaser_grid_li').$categories_css.'">';
            // If grid layout is: Title + Thumbnail + Text
            if ( $grid_layout == 'title_thumbnail_text' ) {
                if ( $post_title )  {
                    $to_filter = '<h4 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
                    $teasers .= apply_filters('vc_teaser_grid_title', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link) );
                }
                if ( $thumbnail ) {
                    $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
                    $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
                }
                if ( $content ) {
                    $to_filter = '<div class="entry-content">' . $content . '</div>';
                    $teasers .= apply_filters('vc_teaser_grid_content', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link) );
                }
            }
            // If grid layout is: Thumbnail + Title + Text
            else if ( $grid_layout == 'thumbnail_title_text' ) {
                if ( $thumbnail ) {
                    $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
                    $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
                }

                if ( $post_title && $content ) {
                    $teasers .= '<div class="teaser-post-info">';
                }

                if ( $post_title )  {
                    $to_filter = '<h4 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
                    $teasers .= apply_filters('vc_teaser_grid_title', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link) );
                }
                if ( $content ) {
                    $to_filter = '<div class="entry-content">' . $content . '</div>';
                    $teasers .= apply_filters('vc_teaser_grid_content', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link) );
                }

                if ( $post_title && $content ) {
                    $teasers .= '</div>';
                }
            }
            // If grid layout is: Thumbnail + Text
            else if ( $grid_layout == 'thumbnail_text' ) {
                if ( $thumbnail ) {
                    $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
                    $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
                }
                if ( $content ) {
                    $to_filter = '<div class="teaser-post-info entry-content">' . $content . '</div>';
                    $teasers .= apply_filters('vc_teaser_grid_content', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link) );
                }
            }
            // If grid layout is: Thumbnail + Title
            else if ( $grid_layout == 'thumbnail_title' ) {
                if ( $thumbnail ) {
                    $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
                    $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
                }
                if ( $post_title )  {
                    $to_filter = '<h4 class="teaser-post-info post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
                    $teasers .= apply_filters('vc_teaser_grid_title', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link) );
                }
            }
            // If grid layout is: Thumbnail
            else if ( $grid_layout == 'thumbnail' ) {
                if ( $thumbnail ) {
                    $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
                    $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
                }
            }
            // If grid layout is: Title + Text
            else if ( $grid_layout == 'title_text' ) {
                if ( $post_title )  {
                    $to_filter = '<h4 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
                    $teasers .= apply_filters('vc_teaser_grid_title', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link) );
                }
                if ( $content ) {
                    $to_filter = '<div class="entry-content">' . $content . '</div>';
                    $teasers .= apply_filters('vc_teaser_grid_content', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link) );
                }
            }

            $teasers .= '</div> ' . WPBakeryShortCode::endBlockComment('single teaser');
        } // endwhile loop
        wp_reset_query();

        if( $grid_template == 'filtered_grid' && $teasers && !empty($teaser_categories)) {

            $categories_array = get_terms(($taxonomies), array(
                'orderby' => 'name',
                'include' => implode(',', $teaser_categories)
            ));

            $categories_list_output = '<ul class="et_categories_filter clearfix">';
            $categories_list_output .= '<li class="active"><a href="#" data-filter="*" class="button active">' . esc_html__('All', 'woopress') . '</a></li>';
            if(!is_wp_error($categories_array)) {
                foreach($categories_array as $cat) {
                    $categories_list_output .= '<li><a href="#" data-filter=".grid-cat-'.$cat->term_id.'" class="button">' . esc_attr($cat->name) . '</a></li>';
                }
            }
            $categories_list_output.= '</ul><div class="clearfix"></div>';
        } else {
            $categories_list_output = '';
        }

        $box_id = rand(1000,10000);

        if($grid_template == 'grid' || $grid_template == 'filtered_grid') {
            $isotope_class = 'et_isotope';
        } else {
            $isotope_class = 'owl-carousel owl-theme teaser-carousel-'.$box_id;
        }

        if ( $teasers ) { $teasers = '<div class="teaser_grid_container isotope-container">'.$categories_list_output.'<div class="'.$isotope_class.' et_row clearfix">'. $teasers .'</div></div>'; }
        else { $teasers = esc_html__("Nothing found." , "woopress"); }

        $posttypes_teasers = '';



        if ( is_array($grid_posttypes) ) {
            //$posttypes_teasers_ar = explode(",", $grid_posttypes);
            $posttypes_teasers_ar = $grid_posttypes;
            foreach ( $posttypes_teasers_ar as $post_type ) {
                $posttypes_teasers .= 'wpb_teaser_grid_'.$post_type . ' ';
            }
        }

        $grid_class = 'wpb_'.$grid_template . ' columns_count_'.$grid_columns_count . ' grid_layout-'.$grid_layout . ' '  . $grid_layout.'_' . ' ' . 'columns_count_'.$grid_columns_count.'_'.$grid_layout . ' ' . $posttypes_teasers.' teaser-border-'.$border.' post-by-info-'.$posted_block;
        $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_teaser_grid wpb_content_element '.$grid_class.$width.$el_class);

        $output .= "\n\t".'<div class="'.$css_class.'">';
        $output .= "\n\t\t".'<div class="wpb_wrapper">';
        $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="title"><span>'.$title.'</span></h3>' : '';
        //$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_teaser_grid_heading'));
        $output .= $teasers;
        $output .= "\n\t\t".'</div> '.WPBakeryShortCode::endBlockComment('.wpb_wrapper');
        $output .= "\n\t".'</div> '.WPBakeryShortCode::endBlockComment('.wpb_teaser_grid');
        if($pagination == 'show') {
            $output .= etheme_pagination($my_query, $paged);
        }
        if ( $grid_template == 'carousel' ) {

            $output .=     "<script type='text/javascript'>";
            $output .=         'jQuery(".teaser-carousel-'.$box_id.'").owlCarousel({';
            $output .=             'items:4,';
            $output .=             'lazyLoad : true,';
            $output .=             'nav: true,';
            $output .=             'navText:["",""],';
            $output .=             'rewind: false,';
            $output .=             'responsive: {0:{items:1}, 479:{items:2}, 619:{items:2}, 768:{items:4},  1200:{items:4}, 1600:{items:4}}';
            $output .=         '});';

            $output .=     '</script>';
        }


        remove_all_filters('vc_teaser_grid_title');

        return $output;
    }

}

if(!function_exists('etheme_pagination')) {
    function etheme_pagination($wp_query, $paged, $pages = '', $range = 2) {
         $output = '';
         $showitems = ($range * 2)+1;

         if(empty($paged)) $paged = 1;

         if($pages == '')
         {
             $pages = $wp_query->max_num_pages;
             if(!$pages)
             {
                 $pages = 1;
             }
         }

         if(1 != $pages)
         {
             $output .= "<nav class='portfolio-pagination pagination-cubic'>";
                 $output .= '<ul class="page-numbers">';
                     if($paged > 2 && $paged > $range+1 && $showitems < $pages) $output .= "<li><a href='".get_pagenum_link(1)."' class='prev page-numbers'>prev</a></li>";

                     for ($i=1; $i <= $pages; $i++)
                     {
                         if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                         {
                             $output .= ($paged == $i)? "<li><span class='page-numbers current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
                         }
                     }

                     if ($paged < $pages && $showitems < $pages) $output .= "<li><a href='".get_pagenum_link($paged + 1)."' class='next page-numbers'>next</a></li>";
                 $output .= '</ul>';
             $output .= "</nav>\n";
         }

         return $output;
    }
}

// **********************************************************************//
// ! Create products grid by args
// **********************************************************************//
if(!function_exists('etheme_products')) {
    function etheme_products($args,$title = false, $columns = 4){
        global $wpdb, $woocommerce_loop;
        ob_start();

        $products = new WP_Query( $args );
        $class = '';
        $shop_url = get_permalink(wc_get_page_id('shop'));

        $woocommerce_loop['columns'] = $columns;

        if ( $products->have_posts() ) : ?>
            <?php 
                if ( $title != '' ) {
                    echo '<h2 class="title"><span>' . esc_html( $title ) . '</span></h2>';
                }
            ?>
            <?php woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

        <?php endif;

        wp_reset_postdata();

        return '<div class="woocommerce">' . ob_get_clean() . '</div>';

    }
}
// **********************************************************************//
// ! Create products slider by args
// **********************************************************************//
if(!function_exists('etheme_create_slider')) {
    function etheme_create_slider($args, $slider_args = array()){//, $title = false, $shop_link = true, $slider_type = false, $items = '[[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]', $style = 'default'
        global $wpdb, $woocommerce_loop;

        $product_per_row = wc_get_loop_prop( 'columns', wc_get_default_products_per_row() );
        extract(shortcode_atts(array(
            'title' => false,
            'shop_link' => false,
            'slider_type' => false,
            'items' => '{0:{items:1}, 479:{items:2}, 619:{items:2}, 768:{items:4},  1200:{items:4}, 1600:{items:4}}',
            'style' => 'default',
            'block_id' => false
        ), $slider_args));

        $box_id = rand(1000,10000);
        $multislides = new WP_Query( $args );
        $shop_url = get_permalink(wc_get_page_id('shop'));
        $class = $container_class = '';
        if(!$slider_type) {
            $woocommerce_loop['lazy-load'] = true;
            $woocommerce_loop['style'] = $style;
        }


        if(!$slider_type) {
            $container_class = '';
            $class .= 'owl-carousel';
        } elseif($slider_type == 'swiper') {
            $container_class = 'et-swiper-container';
            $class .= 'swiper-wrapper';
        }

        if ( $multislides->have_posts() ) :
              echo '<div class="carousel-area '.$container_class.' slider-'.$box_id.'">';
                  if ( $title ) {
                      echo '<h2 class="title"><span>' . esc_html( $title ) . '</span></h2>';
                  }
                  echo '<div class="'.$class.' productCarousel">';
                        $_i=0;
                        if($block_id && $block_id != '' && et_get_block($block_id) != '') {
                            echo '<div class="slide-item '.$slider_type.'-slide">';
                                echo et_get_block($block_id);
                            echo '</div><!-- slide-item -->';
                        }
                        while ($multislides->have_posts()) : $multislides->the_post();
                            $_i++;

                            if(class_exists('Woocommerce')) {
                                global $product;
                                if (!$product->is_visible()) continue;
                                echo '<div class="slide-item product-slide '.$slider_type.'-slide">';
                                    wc_get_template_part( 'content', 'product-slider' );
                                echo '</div><!-- slide-item -->';
                            }

                        endwhile;
                  echo '</div><!-- products-slider -->';
              echo '</div><!-- slider-container -->';
        endif;
        wp_reset_query();
        unset($woocommerce_loop['lazy-load']);
        unset($woocommerce_loop['style']);

        if($items != '{0:{items:1}, 479:{items:2}, 619:{items:2}, 768:{items:4},  1200:{items:4}, 1600:{items:4}}') {
            $items = '{0:{items:'.$items['phones'].'}, 479:{items:'.$items['tablet'].'}, 619:{items:'.$items['tablet'].'}, 768:{items:'.$items['tablet'].'}, 1200:{items:'.$items['notebook'].'}, 1600:{items:'.$items['desktop'].'}}';
        }
        if(!$slider_type) {
            echo '

                <script type="text/javascript">
                    jQuery(".slider-'.$box_id.' .productCarousel").owlCarousel({
                        items:4,
                        lazyLoad : true,
                        nav: true,
                        navText:["",""],
                        rewind: false,
                        responsive: '.$items.'
                    }).on(\'load.owl.lazy\', function(){
                        jQuery(this).removeClass(\'loaded\');
                    }).on(\'loaded.owl.lazy\', function(){
                        jQuery(this).addClass(\'loaded\');
                    });

                </script>
            ';
        } elseif($slider_type == 'swiper') {
            echo '
                <script type="text/javascript">
                  if(jQuery(window).width() > 767) {
                      jQuery(".slider-'.$box_id.'").etFullWidth();
                      var mySwiper'.$box_id.' = new Swiper(".slider-'.$box_id.'",{
                        keyboardControl: true,
                        centeredSlides: true,
                        calculateHeight : true,
                        slidesPerView: "auto",
                        mode: "horizontal"
                      })
                  } else {
                      var mySwiper'.$box_id.' = new Swiper(".slider-'.$box_id.'",{
                        calculateHeight : true
                      })
                  }

                    jQuery(function($){
                        $(".slider-'.$box_id.' .slide-item").click(function(){
                            mySwiper'.$box_id.'.swipeTo($(this).index());
                            $(".lookbook-index").removeClass("active");
                            $(this).addClass("active");
                        });

                        $(".slider-'.$box_id.' .slide-item a").click(function(e){
                            if($(this).parents(".swiper-slide-active").length < 1) {
                                e.preventDefault();
                            }
                        });
                    }, jQuery);
                </script>
            ';
        }

    }
}


if(!function_exists('etheme_create_slider_widget')) {
    function etheme_create_slider_widget($args,$title = false){
        global $wpdb;
        $box_id = rand(1000,10000);
        $multislides = new WP_Query( $args );

        if ( $multislides->have_posts() ) :
            echo '<div class="sidebar-slider">';
                if ($title) {
                    echo '<h4 class="widget-title"><span>' . esc_html( $title ) . '</span></h4>';
                }
                echo '<div class="owl-carousel sidebarCarousel slider-'.$box_id.'">';
                    $_i=0;
                    echo '<div class="slide-item product-slide"><ul class="product_list_widget">';
                        while ($multislides->have_posts()) : $multislides->the_post();
                            $_i++;

                            if(class_exists('Woocommerce')) {
                                global $product;
                                if (!$product->is_visible()) continue;
                                    wc_get_template_part( 'content', 'widget-product' );

                                    if($_i%3 == 0 && $_i != $multislides->post_count) {
                                        echo '</ul></div><!-- slide-item -->';
                                        echo '<div class="slide-item product-slide"><ul class="product_list_widget">';
                                    }
                            }

                        endwhile;
                    echo '</ul></div><!-- slide-item -->';
                echo '</div><!-- sidebarCarousel -->';
            echo '</div><!-- sidebar-slider -->';
        endif;
        wp_reset_query();

        echo '
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    jQuery(".slider-'.$box_id.'").owlCarousel({
                        items:1,
                        nav: true,
                        lazyLoad: true,
                        rewind: false,
                        addClassActive: true,
                        responsive: {
                            1600:{
                                items:1
                            }
                        }
                    });
                });
            </script>
        ';

    }
}


// **********************************************************************//
// ! Create posts slider by args
// **********************************************************************//
if(!function_exists('etheme_create_posts_slider')) {
    function etheme_create_posts_slider($args,$title = false, $more_link = true, $date = false, $excerpt = false, $width = 400, $height = 270, $crop = true, $layout = '', $items = '{0:{items:1}, 479:{items:2}, 619:{items:2}, 768:{items:2},  1200:{items:3}, 1600:{items:3}}', $el_class = ''){

        $box_id = rand(1000,10000);
        $multislides = new WP_Query( $args );
        $lightbox = etheme_get_option('blog_lightbox');
        $sliderHeight = etheme_get_option('default_blog_slider_height');
        $posts_url = get_permalink(get_option('page_for_posts'));
        $class = '';
        if($layout != '') {
            $class .= ' layout-'.$layout;
        }
        if ( $multislides->have_posts() ) :           
              echo '<div class="slider-container '.$class.$el_class.'">';
                    if ($title) {
                        echo '<h3 class="title"><span>' . esc_html( $title ) . '</span></h3>';
                    }
                  echo '<div class="carousel-area posts-slider slider-'.esc_attr($box_id).'">';
                        echo '<div class="owl-carousel owl-theme recentCarousel slider">';
                        $_i=0;
                        while ($multislides->have_posts()) : $multislides->the_post();
                            $_i++;

                                echo '<div class="slide-item thumbnails-x post-slide">';
                                    if(has_post_thumbnail()){
                                        echo '<div class="post-news">';
                                            echo '<img data-src="' . etheme_get_image(false, $width, $height, true) . '" class="post-slide-img owl-lazy">';

                                            echo '<div class="zoom">';
                                                echo '<div class="btn_group">';
                                                    if($lightbox):
                                                        echo '<a href="'.etheme_get_image(false).'" class="btn btn-black xmedium-btn" rel="lightbox"><span>'.__('View large', 'woopress').'</span></a>';
                                                    endif;
                                                    echo '<a href="'.get_permalink().'" class="btn btn-black xmedium-btn"><span>'.__('More details', 'woopress').'</span></a>';
                                                echo '</div>';
                                                echo '<i class="bg"></i>';
                                            echo '</div>';
                                        echo '</div>';
                                    }

                                    echo '<div class="caption">';
                                        echo '<h6 class="active">';
                                        the_category(',&nbsp;');
                                        echo '</h6>';
                                        echo '<h3><a href="'.get_permalink().'">' . get_the_title() . '</a></h3>';
                                        if($date){ ?>
                                            <div class="meta-post">
                                                    <?php the_time(get_option('date_format')); ?>
                                                    <?php esc_html_e('at', 'woopress'); ?>
                                                    <?php the_time(get_option('time_format')); ?>
                                                    <?php esc_html_e('by', 'woopress'); ?> <?php the_author_posts_link(); ?>
                                                    <?php // Display Comments

                                                            if(comments_open() && !post_password_required()) {
                                                                    echo ' / ';
                                                                    comments_popup_link('0', '1 Comment', '% Comments', 'post-comments-count');
                                                            }

                                                     ?>
                                            </div>
                                        <?php
                                        }
                                        if($excerpt) the_excerpt();
                                    echo '</div><!-- caption -->';
                                echo '</div><!-- slide-item -->';

                        endwhile;
                        echo '</div><!-- slider -->';
                  echo '</div><!-- items-slider -->';
              echo '</div><div class="clear"></div><!-- slider-container -->';

             if($items != '{0:{items:1}, 479:{items:2}, 619:{items:2}, 768:{items:2},  1200:{items:3}, 1600:{items:3}}') {
                 $items = '{0:{items:'.$items['phones'].'}, 479:{items:'.$items['phones'].'}, 619:{items:'.$items['tablet'].'}, 768:{items:'.$items['tablet'].'}, 1200:{items:'.$items['notebook'].'}, 1600:{items:'.$items['desktop'].'}}';
             }

            echo '
                <script type="text/javascript">
                        jQuery(".slider-'.$box_id.' .slider").owlCarousel({
                            items:4,
                            lazyLoad : true,
                            nav: true,
                            navText:["",""],
                            rewind: false,
                            responsive: '.$items.'
                        });
                </script>
            ';


        endif;
        wp_reset_query();

    }
}

/**
 * Enqueue inline Javascript. @see wp_enqueue_script().
 *
 * KNOWN BUG: Inline scripts cannot be enqueued before
 *  any inline scripts it depends on, (unless they are
 *  placed in header, and the dependant in footer).
 *
 * @param string      $handle    Identifying name for script
 * @param string      $src       The JavaScript code
 * @param array       $deps      (optional) Array of script names on which this script depends
 * @param bool        $in_footer (optional) Whether to enqueue the script before </head> or before </body>
 *
 * @return null
 */
function enqueue_inline_script( $handle, $js, $deps = array(), $in_footer = false ){
    // Callback for printing inline script.
    $cb = function()use( $handle, $js ){
        // Ensure script is only included once.
        if( wp_script_is( $handle, 'done' ) )
            return;
        // Print script & mark it as included.
        echo "<script type=\"text/javascript\" id=\"js-$handle\">\n$js\n</script>\n";
        global $wp_scripts;
        $wp_scripts->done[] = $handle;
    };
    // (`wp_print_scripts` is called in header and footer, but $cb has re-inclusion protection.)
    $hook = $in_footer ? 'wp_print_footer_scripts' : 'wp_print_scripts';

    // If no dependencies, simply hook into header or footer.
    if( empty($deps)){
        add_action( $hook, $cb );
        return;
    }

    // Delay printing script until all dependencies have been included.
    $cb_maybe = function()use( $deps, $in_footer, $cb, &$cb_maybe ){
        foreach( $deps as &$dep ){
            if( !wp_script_is( $dep, 'done' ) ){
                // Dependencies not included in head, try again in footer.
                if( ! $in_footer ){
                    add_action( 'wp_print_footer_scripts', $cb_maybe, 11 );
                }
                else{
                    // Dependencies were not included in `wp_head` or `wp_footer`.
                }
                return;
            }
        }
        call_user_func( $cb );
    };
    add_action( $hook, $cb_maybe, 0 );
}

// **********************************************************************//
// ! Custom sidebars
// **********************************************************************//

/**
*
*   Function for adding sidebar (AJAX action)
*/

function etheme_add_sidebar(){
    if (!wp_verify_nonce($_GET['_wpnonce_etheme_widgets'],'etheme-add-sidebar-widgets') ) die( 'Security check' );
    if($_GET['etheme_sidebar_name'] == '') die('Empty Name');
    $option_name = 'etheme_custom_sidebars';
    if(!get_option($option_name) || get_option($option_name) == '') delete_option($option_name);

    $new_sidebar = $_GET['etheme_sidebar_name'];


    if(get_option($option_name)) {
        $et_custom_sidebars = etheme_get_stored_sidebar();
        $et_custom_sidebars[] = trim($new_sidebar);
        $result = update_option($option_name, $et_custom_sidebars);
    }else{
        $et_custom_sidebars[] = $new_sidebar;
        $result2 = add_option($option_name, $et_custom_sidebars);
    }


    if($result) die('Updated');
    elseif($result2) die('added');
    else die('error');
}

/**
*
*   Function for deleting sidebar (AJAX action)
*/

function etheme_delete_sidebar(){
    $option_name = 'etheme_custom_sidebars';
    $del_sidebar = trim($_GET['etheme_sidebar_name']);

    if(get_option($option_name)) {
        $et_custom_sidebars = etheme_get_stored_sidebar();

        foreach($et_custom_sidebars as $key => $value){
            if($value == $del_sidebar)
                unset($et_custom_sidebars[$key]);
        }


        $result = update_option($option_name, $et_custom_sidebars);
    }

    if($result) die('Deleted');
    else die('error');
}

/**
*
*   Function for registering previously stored sidebars
*/
function etheme_register_stored_sidebar(){
    $et_custom_sidebars = etheme_get_stored_sidebar();
    if(is_array($et_custom_sidebars)) {
        foreach($et_custom_sidebars as $name){
            register_sidebar( array(
                'name' => ''.$name.'',
                'id' => str_replace( ' ', '-', $name ),
                'class' => 'etheme_custom_sidebar',
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title"><span>',
                'after_title' => '</span></h3>',
            ) );
        }
    }

}

/**
*
*   Function gets stored sidebar array
*/
function etheme_get_stored_sidebar(){
    $option_name = 'etheme_custom_sidebars';
    return get_option($option_name);
}


/**
*
*   Add form after all widgets
*/
function etheme_sidebar_form(){
    ?>

    <form action="<?php echo admin_url( 'widgets.php' ); ?>" method="post" id="etheme_add_sidebar_form">
        <h2><?php esc_html_e('Custom Sidebar', 'woopress'); ?></h2>
        <?php wp_nonce_field( 'etheme-add-sidebar-widgets', '_wpnonce_etheme_widgets', false ); ?>
        <input type="text" name="etheme_sidebar_name" id="etheme_sidebar_name" />
        <button type="submit" class="button-primary" value="add-sidebar"><?php esc_html_e('Add Sidebar', 'woopress'); ?></button>
    </form>
    <script type="text/javascript">
        var sidebarForm = jQuery('#etheme_add_sidebar_form');
        var sidebarFormNew = sidebarForm.clone();
        sidebarForm.remove();
        jQuery('#widgets-right').append('<div style="clear:both;"></div>');
        jQuery('#widgets-right').append(sidebarFormNew);

        sidebarFormNew.submit(function(e){
            e.preventDefault();
            var data =  {
                'action':'etheme_add_sidebar',
                '_wpnonce_etheme_widgets': jQuery('#_wpnonce_etheme_widgets').val(),
                'etheme_sidebar_name': jQuery('#etheme_sidebar_name').val(),
            };
            //console.log(data);
            jQuery.ajax({
                url: ajaxurl,
                data: data,
                success: function(response){
                    console.log(response);
                    window.location.reload(true);

                },
                error: function(data) {
                    console.log('error');

                }
            });
        });

    </script>
    <?php
}

add_action( 'sidebar_admin_page', 'etheme_sidebar_form', 30 );
add_action('wp_ajax_etheme_add_sidebar', 'etheme_add_sidebar');
add_action('wp_ajax_etheme_delete_sidebar', 'etheme_delete_sidebar');
add_action( 'widgets_init', 'etheme_register_stored_sidebar' );


// **********************************************************************//
// ! Get sidebar
// **********************************************************************//

if(!function_exists('etheme_get_sidebar')) {
    function etheme_get_sidebar ($name = false) {
        do_action( 'get_sidebar', $name );
        if($name) {
            include(TEMPLATEPATH . '/sidebar-'.$name.'.php');
        }else{
            include(TEMPLATEPATH . '/sidebar.php');
        }
    }
}

// **********************************************************************//
// ! Site breadcrumbs
// **********************************************************************//

if ( ! function_exists( 'etheme_crumb' ) ) {
    function etheme_crumb( $content, $before = '<span class="current">', $after = '</span>' ){
        return $before . $content . $after;
    }
}

if(!function_exists('etheme_breadcrumbs')) {
    function etheme_breadcrumbs() {

      $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
      $delimiter = '<span class="delimeter">/</span>'; // delimiter between crumbs
      $home = esc_html__('Home', 'woopress'); // text for the 'Home' link
      $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
      $before = '<span class="current">'; // tag before the current crumb
      $after = '</span>'; // tag after the current crumb

      global $post;
      $homeLink = home_url();
      if (is_front_page()) {

        if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';

          } else if (class_exists('bbPress') && is_bbpress()) {
        $bbp_args = array(
            'before' => '<div class="breadcrumbs" id="breadcrumb">',
            'after' => '</div>'
        );
        bbp_breadcrumb($bbp_args);
      } else {
        do_action('etheme_before_breadcrumbs');

        echo '<div class="breadcrumbs">';
        echo '<div id="breadcrumb">';
        echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

        if ( is_category() ) {
          $thisCat = get_category(get_query_var('cat'), false);
          if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
          echo etheme_crumb(esc_html__( 'Archive by category "', 'woopress' ) . single_cat_title('', false) . '"');
        } elseif ( is_search() ) {
          echo etheme_crumb( esc_html__( 'Search results for "', 'woopress' ) . get_search_query() . '"' );
        } elseif ( is_day() ) {
          echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
          echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
          echo etheme_crumb( get_the_time('d') );
        } elseif ( is_month() ) {
          echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
          echo etheme_crumb( get_the_time('F') );
        } elseif ( is_year() ) {
          echo etheme_crumb( get_the_time('Y') );
        } elseif ( is_single() && !is_attachment() ) {
          if ( get_post_type() == 'etheme_portfolio' ) {
            $portfolioId = etheme_tpl2id('portfolio.php');
            $portfolioLink = get_permalink($portfolioId);
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<a href="' . $portfolioLink . '/">' . esc_html($post_type->labels->name, ETHEME_DOMAIN) . '</a>';
            if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . etheme_crumb( get_the_title() );
          } elseif ( get_post_type() != 'post' ) {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
            if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . etheme_crumb( get_the_title() );
          } else {
            $cat = get_the_category();
            if(isset($cat[0])) {
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                if ($showCurrent == 0) {
                    echo preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                } else {
                    echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                }
            }
            if ($showCurrent == 1){
                echo etheme_crumb( get_the_title() );
            }
          }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
          $post_type = get_post_type_object(get_post_type());
          echo etheme_crumb( $post_type->labels->singular_name );
        } elseif ( is_attachment() ) {
          $parent = get_post($post->post_parent);

          if ($showCurrent == 1){
            echo etheme_crumb( get_the_title() );
          }

        } elseif ( is_page() && !$post->post_parent ) {
          if ($showCurrent == 1){
            echo etheme_crumb( get_the_title() );
          }

        } elseif ( is_page() && $post->post_parent ) {
          $parent_id  = $post->post_parent;
          $breadcrumbs = array();
          while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
            $parent_id  = $page->post_parent;
          }
          $breadcrumbs = array_reverse($breadcrumbs);
          for ($i = 0; $i < count($breadcrumbs); $i++) {
            echo ' ' . $breadcrumbs[$i];
            if ($i != count($breadcrumbs)-1){
             echo ' ' . $delimiter . ' ';
            }
          }
          if ($showCurrent == 1){
            echo ' ' . $delimiter . ' ' . etheme_crumb( get_the_title() );
          }

        } elseif ( is_tag() ) {
           echo etheme_crumb( esc_html__( 'Posts tagged "', 'woopress' ) . single_tag_title('', false) . '"' );
        } elseif ( is_author() ) {
           global $author;
          $userdata = get_userdata($author);

          echo etheme_crumb( esc_html__( 'Articles posted by ', 'woopress' ) . $userdata->display_name );

        } elseif ( is_404() ) {
            echo etheme_crumb( esc_html__( 'Error 404', 'woopress' ) );
        }else{
            esc_html_e('Blog', 'woopress');
        }

        if ( get_query_var('paged') ) {
          if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
          echo ' ('.__('Page', 'woopress') . ' ' . get_query_var('paged').')';
          if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

        echo '</div>';

        et_back_to_page();

        echo '</div>';

      }
    }
}

if(!function_exists('et_back_to_page')) {
    function et_back_to_page() {
        echo '<a class="back-history" href="javascript: history.go(-1)">'.__('Return to Previous Page', 'woopress').'</a>';
    }
}


if(!function_exists('et_show_more_posts')) {
    function et_show_more_posts() {
        return 'class="button big"';
    }
}


// **********************************************************************//
// ! Replace variation images
// **********************************************************************//

if(!function_exists('etheme_replace_variation_images')) {
    function etheme_replace_variation_images($variations, $width = 1000, $height = 1000, $crop = false) {

        $newVariations = $variations;

        foreach ($variations as $key => $value) {
            $attachment_id = get_post_thumbnail_id( $variations[$key]['variation_id'] );

            $newImage = etheme_get_image($attachment_id, $width, $height, $crop);

            $newVariations[$key]['image_src'] = $newImage;
        }

        return $newVariations;
    }
}

// **********************************************************************//
// ! Get page sidebar position
// **********************************************************************//

if(!function_exists('etheme_get_page_sidebar')) {
    function etheme_get_page_sidebar() {
        $result = array(
            'position' => '',
            'responsive' => '',
            'breadcrumb_type' => 'default',
            'sidebarname' => '',
            'page_heading' => 'enable',
            'page_slider' => 'no_slider',
            'sidebar_span' => 'col-md-3',
            'content_span' => 'col-md-9'
        );


        $result['breadcrumb_type'] = etheme_get_option('breadcrumb_type');
        $result['responsive'] = etheme_get_option('blog_sidebar_responsive');
        $result['position'] = etheme_get_option('blog_sidebar');
        $result['page_heading'] = etheme_get_custom_field('page_heading');
        $result['page_slider'] = etheme_get_custom_field('page_slider');
        $page_breadcrumb_type = etheme_get_custom_field('breadcrumb_type');
        $page_sidebar_state = etheme_get_custom_field('sidebar_state');
        $sidebar_width = etheme_get_custom_field('sidebar_width');
        $widgetarea = etheme_get_custom_field('widget_area');

        if(function_exists('is_bbpress') && is_bbpress()){
            $page_sidebar_state = etheme_get_option('forum_sidebar');
            $widgetarea = 'forum-sidebar';
        }

        if($sidebar_width != '') {
            $content_width = 12 - $sidebar_width;
            $result['sidebar_span'] = 'col-md-'.$sidebar_width;
            $result['content_span'] = 'col-md-'.$content_width;
        }
        if($widgetarea != '') {
            $result['sidebarname'] = 'custom';
        }
        if($page_sidebar_state != '') {
            $result['position'] = $page_sidebar_state;
        }

        if($page_breadcrumb_type != '') {
            $result['breadcrumb_type'] = $page_breadcrumb_type;
        }

        if($result['position'] == 'no_sidebar' || $result['position'] == 'without') {
            $result['position'] = 'without';
            $result['content_span'] = 'col-md-12';
        }

        return $result;

    }
}



// **********************************************************************//
// ! Function takes page layout
// **********************************************************************//


if(!function_exists('et_page_config')) {
    function et_page_config() {
        $layout = array(
            'sidebar' => 'left',
            'sidebar-mobile' => 'bottom',
            'sidebar-size' => 3,
            'content-size' => 9,
            'heading' => true,
            'slider' => false,
            'sidebar-name' => '',
            'breadcrumb' => 'default',
            'breadcrumb_image' => '',
            'widgetarea' => ''
        );

        $page_id = et_get_page_id();
        $is_redux = class_exists('Redux') ? true : false;

        if ( $is_redux ) {
            // Get settings from Theme Options
            $layout['sidebar'] = etheme_get_option('blog_sidebar');
            $layout['sidebar-mobile'] = etheme_get_option('blog_sidebar_responsive');
            $layout['shop-sidebar-mobile'] = etheme_get_option('shop_sidebar_responsive');
            $layout['breadcrumb'] = etheme_get_option('breadcrumb_type');

            if(class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag() || is_tax('brand'))) {
                $layout['sidebar'] = etheme_get_option('grid_sidebar');

                if(wc_get_loop_prop( 'columns', wc_get_default_products_per_row() ) == 6) {
                    $layout['sidebar'] = 'without';
                }
            }
        }


            // Get specific custom options from meta boxes for this $page_id

            $page_breadcrumb = etheme_get_custom_field('breadcrumb_type', $page_id);
            $page_breadcrumb_image = etheme_get_custom_field('custom_breadcrumbs_image', $page_id);
            $page_sidebar = etheme_get_custom_field('sidebar_state', $page_id);
            $sidebar_width = etheme_get_custom_field('sidebar_width', $page_id);
            $widgetarea = etheme_get_custom_field('widget_area', $page_id);
            $slider = etheme_get_custom_field('page_slider', $page_id);
            $heading = etheme_get_custom_field('page_heading', $page_id);

            if(!empty($page_sidebar) && $page_sidebar != 'default') {
                $layout['sidebar'] = $page_sidebar;
            }

            if(!empty($sidebar_width) && $sidebar_width != 'default') {
                $layout['sidebar-size'] = $sidebar_width;
            }

            if(!empty($page_breadcrumb) && $page_breadcrumb != 'default') {
                $layout['breadcrumb'] = $page_breadcrumb;
            }

            if(!empty($page_breadcrumb_image) && $page_breadcrumb_image != 'x') {
                $layout['breadcrumb_image'] = $page_breadcrumb_image;
            }

            if(!empty($widgetarea) && $widgetarea != 'default') {
                $layout['widgetarea'] = $widgetarea;
            }

            if(!empty($slider) && $slider != 'no_slider') {
                $layout['slider'] = $slider;
            }

            if(!empty($heading) && $heading != 'enable') {
                $layout['heading'] = $heading;
            }

            // Thats all about custom options for the particular page



        if(class_exists('WooCommerce') && is_singular( "product" ) && $is_redux ) {
            $layout['sidebar'] = etheme_get_option('single_sidebar');
        }

        if(function_exists('is_bbpress') && is_bbpress()){
            if ( $is_redux ) {
                $layout['sidebar'] = etheme_get_option('forum_sidebar');
            }
            $layout['widgetarea'] = 'forum-sidebar';
        }


        if(!$layout['sidebar'] || $layout['sidebar'] == 'without' || $layout['sidebar'] == 'no_sidebar') {
            $layout['sidebar-size'] = 0;
        }

        if($layout['sidebar-size'] == 0) {
            $layout['sidebar'] == 'without';
        }


        $layout['content-size'] = 12 - $layout['sidebar-size'];

        $layout['sidebar-class'] = 'col-md-' . $layout['sidebar-size'];
        $layout['content-class'] = 'col-md-' . $layout['content-size'];

        if($layout['sidebar'] == 'left') {
            $layout['sidebar-class'] .= ' col-md-pull-' . $layout['content-size'];
            $layout['content-class'] .= ' col-md-push-' . $layout['sidebar-size'];
        }

        return apply_filters( 'et_page_config', $layout );
    }
}

if(!function_exists('et_get_page_id')) {
    function et_get_page_id() {
        global $post;

        $id = 0;

        if(isset($post->ID) && is_singular('page')) {
            $id = $post->ID;
        } else if( is_home() ) {
            $id = get_option( 'page_for_posts' );
        } else if( get_post_type() == 'etheme_portfolio' || is_singular( 'etheme_portfolio' ) ) {
            $id = etheme_tpl2id( 'portfolio.php' );
        }

        if(class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag() || is_singular( "product" ))) {
            $id = get_option('woocommerce_shop_page_id');
        }

        return $id;
    }
}

// **********************************************************************//
// ! Get blog sidebar position
// **********************************************************************//

if(!function_exists('etheme_get_blog_sidebar')) {
    function etheme_get_blog_sidebar() {

        $page_sidebar_state = $sidebar_width = '';

        $page_for_posts = get_option( 'page_for_posts' );

        $result = array(
            'position' => '',
            'responsive' => '',
            'sidebarname' => '',
            'page_heading' => '',
            'page_slider' => '',
            'sidebar_width' => 3,
            'sidebar_span' => 'col-md-3',
            'content_span' => 'col-md-9',
            'blog_layout' => 'default',
        );

        $result['responsive'] = etheme_get_option('blog_sidebar_responsive');
        $result['position'] = etheme_get_option('blog_sidebar');
        $result['blog_layout'] = etheme_get_option('blog_layout');

        if(!empty($page_for_posts)) {
            $result['page_slider'] = etheme_get_custom_field('page_slider', $page_for_posts);
            $result['page_heading'] = etheme_get_custom_field('page_heading', $page_for_posts);
            $page_sidebar_state = etheme_get_custom_field('sidebar_state', $page_for_posts);
            $sidebar_width = etheme_get_custom_field('sidebar_width', $page_for_posts);
        }
        $content_width = 12 - $result['sidebar_width'];
        $result['sidebar_span'] = 'col-md-'.$result['sidebar_width'];
        $result['content_span'] = 'col-md-'.$content_width;


        if($sidebar_width != '') {
            $content_width = 12 - $sidebar_width;
            $result['sidebar_span'] = 'col-md-'.$sidebar_width;
            $result['content_span'] = 'col-md-'.$content_width;
        }

        if($page_sidebar_state != '') {
            $result['position'] = $page_sidebar_state;
        }

        if($result['position'] == 'no_sidebar' || $result['position'] == 'without' || $result['blog_layout'] == 'grid') {
            $result['position'] = 'without';
            $result['content_span'] = 'col-md-12';
        }

        return $result;

    }
}

// **********************************************************************//
// ! Get shop sidebar position
// **********************************************************************//

if(!function_exists('etheme_get_shop_sidebar')) {
    function etheme_get_shop_sidebar() {

        $page_for_shop = wc_get_page_id( 'shop' );

        $result = array(
            'position' => 'left',
            'responsive' => '',
            'product_per_row' => 3,
            'product_page_sidebar' => true,
            'sidebar_hidden' => false,
            'sidebar_width' => 3,
            'sidebar_span' => 'col-md-3',
            'content_span' => 'col-md-9'
        );

        $result['responsive'] = etheme_get_option('blog_sidebar_responsive');
        $result['position'] = etheme_get_option('grid_sidebar');
        $result['product_per_row'] = wc_get_loop_prop( 'columns', wc_get_default_products_per_row() );
        $result['sidebar_hidden'] = etheme_get_option('sidebar_hidden');

        $result['page_slider'] = etheme_get_custom_field('page_slider', $page_for_shop);
        $result['page_heading'] = etheme_get_custom_field('page_heading', $page_for_shop);
        $page_sidebar_state = etheme_get_custom_field('sidebar_state', $page_for_shop);
        $sidebar_width = etheme_get_custom_field('sidebar_width', $page_for_shop);



        $content_width = 12 - $result['sidebar_width'];
        $result['sidebar_span'] = 'col-md-'.$result['sidebar_width'];
        $result['content_span'] = 'col-md-'.$content_width;


        if($sidebar_width != '') {
            $content_width = 12 - $sidebar_width;
            $result['sidebar_span'] = 'col-md-'.$sidebar_width;
            $result['content_span'] = 'col-md-'.$content_width;
        }

        if($page_sidebar_state != '') {
            $result['position'] = $page_sidebar_state;
        }

        if($result['position'] == 'no_sidebar' || $result['position'] == 'without') {
            $result['position'] = 'without';
            $result['content_span'] = 'col-md-12';
        }


        if($result['product_per_row'] == 2 && $result['position'] == 'without'){
            $result['position'] = 'left';
            $result['content_span'] = 'col-md-9';
        }

        if($result['product_per_row'] == 6){
            $result['position'] = 'without';
            $result['content_span'] = 'col-md-12';
        }

        return $result;
    }
}

// **********************************************************************//
// ! Get single product page sidebar position
// **********************************************************************//

if(!function_exists('etheme_get_single_product_sidebar')) {
    function etheme_get_single_product_sidebar() {

        $result = array(
            'position' => 'left',
            'responsive' => '',
            'images_span' => '5',
            'meta_span' => '4'
        );

        $result['single_product_sidebar'] = is_active_sidebar('single-sidebar');
        $result['responsive'] = etheme_get_option('blog_sidebar_responsive');
        $result['position'] = etheme_get_option('single_sidebar');

        $result['single_product_sidebar'] = apply_filters('single_product_sidebar', $result['single_product_sidebar']);

        if(!$result['single_product_sidebar'] || $result['position'] == 'without' || $result['position'] == 'no_sidebar') {
            $result['position'] = 'without';
            $result['images_span'] = '6';
            $result['meta_span'] = '6';
        }

        return $result;
    }
}

// **********************************************************************//
// ! Enable shortcodes in text widgets
// **********************************************************************//
add_filter('widget_text', 'do_shortcode');

// ! Add custom fonts to typography field
add_filter( 'ot_recognized_font_families', 'etheme_custom_fonts' );

function etheme_custom_fonts(){
    $fonts = get_option( 'etheme-fonts', false );

    $ot_font_families = array(
      'arial'     => 'Arial',
      'georgia'   => 'Georgia',
      'helvetica' => 'Helvetica',
      'palatino'  => 'Palatino',
      'tahoma'    => 'Tahoma',
      'times'     => '"Times New Roman", sans-serif',
      'trebuchet' => 'Trebuchet',
      'verdana'   => 'Verdana'
    );

    if ( $fonts ) {
        foreach ( $fonts as $value ) {
            $ot_font_families[$value['name']] = $value['name'] . esc_html__(' (loaded)', 'woopress' );
        }
    }
    return $ot_font_families;
}

// **********************************************************************//
// ! Add GOOGLE fonts
// **********************************************************************//

if(!function_exists('etheme_recognized_google_font_families')) {
    function etheme_recognized_google_font_families( $array, $field_id ) {
        $array = array(
            'Open+Sans'           => '"Open Sans", sans-serif',
            'Droid+Sans'          => '"Droid Sans", sans-serif',
            'Lato'                => '"Lato"',
            'Cardo'               => '"Cardo"',
            'Roboto'              => '"Roboto"',
            'Fauna+One'           => '"Fauna One"',
            'Oswald'              => '"Oswald"',
            'Yanone+Kaffeesatz'   => '"Yanone Kaffeesatz"',
            'Muli'                => '"Muli"',
            'ABeeZee' => 'ABeeZee',
            'Abel' => 'Abel',
            'Abril+Fatface' => 'Abril Fatface',
            'Aclonica' => 'Aclonica',
            'Acme' => 'Acme',
            'Actor' => 'Actor',
            'Adamina' => 'Adamina',
            'Advent+Pro' => 'Advent Pro',
            'Aguafina+Script' => 'Aguafina Script',
            'Akronim' => 'Akronim',
            'Aladin' => 'Aladin',
            'Aldrich' => 'Aldrich',
            'Alef' => 'Alef',
            'Alegreya' => 'Alegreya',
            'Alegreya+SC' => 'Alegreya SC',
            'Alex+Brush' => 'Alex Brush',
            'Alfa+Slab+One' => 'Alfa Slab One',
            'Alice' => 'Alice',
            'Alike' => 'Alike',
            'Alike+Angular' => 'Alike Angular',
            'Allan' => 'Allan',
            'Allerta' => 'Allerta',
            'Allerta+Stencil' => 'Allerta Stencil',
            'Allura' => 'Allura',
            'Almendra' => 'Almendra',
            'Almendra+Display' => 'Almendra Display',
            'Almendra+SC' => 'Almendra SC',
            'Amarante' => 'Amarante',
            'Amaranth' => 'Amaranth',
            'Amatic+SC' => 'Amatic SC',
            'Amethysta' => 'Amethysta',
            'Anaheim' => 'Anaheim',
            'Andada' => 'Andada',
            'Andika' => 'Andika',
            'Angkor' => 'Angkor',
            'Annie+Use+Your+Telescope' => 'Annie Use Your Telescope',
            'Anonymous+Pro' => 'Anonymous Pro',
            'Antic' => 'Antic',
            'Antic+Didone' => 'Antic Didone',
            'Antic+Slab' => 'Antic Slab',
            'Anton' => 'Anton',
            'Arapey' => 'Arapey',
            'Arbutus' => 'Arbutus',
            'Arbutus+Slab' => 'Arbutus Slab',
            'Architects+Daughter' => 'Architects Daughter',
            'Archivo+Black' => 'Archivo Black',
            'Archivo+Narrow' => 'Archivo Narrow',
            'Arimo' => 'Arimo',
            'Arizonia' => 'Arizonia',
            'Armata' => 'Armata',
            'Artifika' => 'Artifika',
            'Arvo' => 'Arvo',
            'Asap' => 'Asap',
            'Asset' => 'Asset',
            'Astloch' => 'Astloch',
            'Asul' => 'Asul',
            'Atomic+Age' => 'Atomic Age',
            'Aubrey' => 'Aubrey',
            'Audiowide' => 'Audiowide',
            'Autour+One' => 'Autour One',
            'Average' => 'Average',
            'Average+Sans' => 'Average Sans',
            'Averia+Gruesa+Libre' => 'Averia Gruesa Libre',
            'Averia+Libre' => 'Averia Libre',
            'Averia+Sans+Libre' => 'Averia Sans Libre',
            'Averia+Serif+Libre' => 'Averia Serif Libre',
            'Bad+Script' => 'Bad Script',
            'Balthazar' => 'Balthazar',
            'Bangers' => 'Bangers',
            'Basic' => 'Basic',
            'Battambang' => 'Battambang',
            'Baumans' => 'Baumans',
            'Bayon' => 'Bayon',
            'Belgrano' => 'Belgrano',
            'Belleza' => 'Belleza',
            'BenchNine' => 'BenchNine',
            'Bentham' => 'Bentham',
            'Berkshire+Swash' => 'Berkshire Swash',
            'Bevan' => 'Bevan',
            'Bigelow+Rules' => 'Bigelow Rules',
            'Bigshot+One' => 'Bigshot One',
            'Bilbo' => 'Bilbo',
            'Bilbo+Swash+Caps' => 'Bilbo Swash Caps',
            'Bitter' => 'Bitter',
            'Black+Ops+One' => 'Black Ops One',
            'Bokor' => 'Bokor',
            'Bonbon' => 'Bonbon',
            'Boogaloo' => 'Boogaloo',
            'Bowlby+One' => 'Bowlby One',
            'Bowlby+One+SC' => 'Bowlby One SC',
            'Brawler' => 'Brawler',
            'Bree+Serif' => 'Bree Serif',
            'Bubblegum+Sans' => 'Bubblegum Sans',
            'Bubbler+One' => 'Bubbler One',
            'Buda' => 'Buda',
            'Buenard' => 'Buenard',
            'Butcherman' => 'Butcherman',
            'Butterfly+Kids' => 'Butterfly Kids',
            'Cabin' => 'Cabin',
            'Cabin+Condensed' => 'Cabin Condensed',
            'Cabin+Sketch' => 'Cabin Sketch',
            'Caesar+Dressing' => 'Caesar Dressing',
            'Cagliostro' => 'Cagliostro',
            'Calligraffitti' => 'Calligraffitti',
            'Cambo' => 'Cambo',
            'Candal' => 'Candal',
            'Cantarell' => 'Cantarell',
            'Cantata+One' => 'Cantata One',
            'Cantora+One' => 'Cantora One',
            'Capriola' => 'Capriola',
            'Cardo' => 'Cardo',
            'Carme' => 'Carme',
            'Carrois+Gothic' => 'Carrois Gothic',
            'Carrois+Gothic+SC' => 'Carrois Gothic SC',
            'Carter+One' => 'Carter One',
            'Caudex' => 'Caudex',
            'Cedarville+Cursive' => 'Cedarville Cursive',
            'Ceviche+One' => 'Ceviche One',
            'Changa+One' => 'Changa One',
            'Chango' => 'Chango',
            'Chau+Philomene+One' => 'Chau Philomene One',
            'Chela+One' => 'Chela One',
            'Chelsea+Market' => 'Chelsea Market',
            'Chenla' => 'Chenla',
            'Cherry+Cream+Soda' => 'Cherry Cream Soda',
            'Cherry+Swash' => 'Cherry Swash',
            'Chewy' => 'Chewy',
            'Chicle' => 'Chicle',
            'Chivo' => 'Chivo',
            'Cinzel' => 'Cinzel',
            'Cinzel+Decorative' => 'Cinzel Decorative',
            'Clicker+Script' => 'Clicker Script',
            'Coda' => 'Coda',
            'Coda+Caption' => 'Coda Caption',
            'Codystar' => 'Codystar',
            'Combo' => 'Combo',
            'Comfortaa' => 'Comfortaa',
            'Coming+Soon' => 'Coming Soon',
            'Concert+One' => 'Concert One',
            'Condiment' => 'Condiment',
            'Content' => 'Content',
            'Contrail+One' => 'Contrail One',
            'Convergence' => 'Convergence',
            'Cookie' => 'Cookie',
            'Copse' => 'Copse',
            'Corben' => 'Corben',
            'Courgette' => 'Courgette',
            'Cousine' => 'Cousine',
            'Coustard' => 'Coustard',
            'Covered+By+Your+Grace' => 'Covered By Your Grace',
            'Crafty+Girls' => 'Crafty Girls',
            'Creepster' => 'Creepster',
            'Crete+Round' => 'Crete Round',
            'Crimson+Text' => 'Crimson Text',
            'Croissant+One' => 'Croissant One',
            'Crushed' => 'Crushed',
            'Cuprum' => 'Cuprum',
            'Cutive' => 'Cutive',
            'Cutive+Mono' => 'Cutive Mono',
            'Damion' => 'Damion',
            'Dancing+Script' => 'Dancing Script',
            'Dangrek' => 'Dangrek',
            'Dawning+of+a+New+Day' => 'Dawning of a New Day',
            'Days+One' => 'Days One',
            'Delius' => 'Delius',
            'Delius+Swash+Caps' => 'Delius Swash Caps',
            'Delius+Unicase' => 'Delius Unicase',
            'Della+Respira' => 'Della Respira',
            'Denk+One' => 'Denk One',
            'Devonshire' => 'Devonshire',
            'Didact+Gothic' => 'Didact Gothic',
            'Diplomata' => 'Diplomata',
            'Diplomata+SC' => 'Diplomata SC',
            'Domine' => 'Domine',
            'Donegal+One' => 'Donegal One',
            'Doppio+One' => 'Doppio One',
            'Dorsa' => 'Dorsa',
            'Dosis' => 'Dosis',
            'Dr+Sugiyama' => 'Dr Sugiyama',
            'Droid+Sans' => 'Droid Sans',
            'Droid+Sans+Mono' => 'Droid Sans Mono',
            'Droid+Serif' => 'Droid Serif',
            'Duru+Sans' => 'Duru Sans',
            'Dynalight' => 'Dynalight',
            'EB+Garamond' => 'EB Garamond',
            'Eagle+Lake' => 'Eagle Lake',
            'Eater' => 'Eater',
            'Economica' => 'Economica',
            'Electrolize' => 'Electrolize',
            'Elsie' => 'Elsie',
            'Elsie+Swash+Caps' => 'Elsie Swash Caps',
            'Emblema+One' => 'Emblema One',
            'Emilys+Candy' => 'Emilys Candy',
            'Engagement' => 'Engagement',
            'Englebert' => 'Englebert',
            'Enriqueta' => 'Enriqueta',
            'Erica+One' => 'Erica One',
            'Esteban' => 'Esteban',
            'Euphoria+Script' => 'Euphoria Script',
            'Ewert' => 'Ewert',
            'Exo' => 'Exo',
            'Expletus+Sans' => 'Expletus Sans',
            'Fanwood+Text' => 'Fanwood Text',
            'Fascinate' => 'Fascinate',
            'Fascinate+Inline' => 'Fascinate Inline',
            'Faster+One' => 'Faster One',
            'Fasthand' => 'Fasthand',
            'Fauna+One' => 'Fauna One',
            'Federant' => 'Federant',
            'Federo' => 'Federo',
            'Felipa' => 'Felipa',
            'Fenix' => 'Fenix',
            'Finger+Paint' => 'Finger Paint',
            'Fjalla+One' => 'Fjalla One',
            'Fjord+One' => 'Fjord One',
            'Flamenco' => 'Flamenco',
            'Flavors' => 'Flavors',
            'Fondamento' => 'Fondamento',
            'Fontdiner+Swanky' => 'Fontdiner Swanky',
            'Forum' => 'Forum',
            'Francois+One' => 'Francois One',
            'Freckle+Face' => 'Freckle Face',
            'Fredericka+the+Great' => 'Fredericka the Great',
            'Fredoka+One' => 'Fredoka One',
            'Freehand' => 'Freehand',
            'Fresca' => 'Fresca',
            'Frijole' => 'Frijole',
            'Fruktur' => 'Fruktur',
            'Fugaz+One' => 'Fugaz One',
            'GFS+Didot' => 'GFS Didot',
            'GFS+Neohellenic' => 'GFS Neohellenic',
            'Gabriela' => 'Gabriela',
            'Gafata' => 'Gafata',
            'Galdeano' => 'Galdeano',
            'Galindo' => 'Galindo',
            'Gentium+Basic' => 'Gentium Basic',
            'Gentium+Book+Basic' => 'Gentium Book Basic',
            'Geo' => 'Geo',
            'Geostar' => 'Geostar',
            'Geostar+Fill' => 'Geostar Fill',
            'Germania+One' => 'Germania One',
            'Gilda+Display' => 'Gilda Display',
            'Give+You+Glory' => 'Give You Glory',
            'Glass+Antiqua' => 'Glass Antiqua',
            'Glegoo' => 'Glegoo',
            'Gloria+Hallelujah' => 'Gloria Hallelujah',
            'Goblin+One' => 'Goblin One',
            'Gochi+Hand' => 'Gochi Hand',
            'Gorditas' => 'Gorditas',
            'Goudy+Bookletter+1911' => 'Goudy Bookletter 1911',
            'Graduate' => 'Graduate',
            'Grand+Hotel' => 'Grand Hotel',
            'Gravitas+One' => 'Gravitas One',
            'Great+Vibes' => 'Great Vibes',
            'Griffy' => 'Griffy',
            'Gruppo' => 'Gruppo',
            'Gudea' => 'Gudea',
            'Habibi' => 'Habibi',
            'Hammersmith+One' => 'Hammersmith One',
            'Hanalei' => 'Hanalei',
            'Hanalei+Fill' => 'Hanalei Fill',
            'Handlee' => 'Handlee',
            'Hanuman' => 'Hanuman',
            'Happy+Monkey' => 'Happy Monkey',
            'Headland+One' => 'Headland One',
            'Henny+Penny' => 'Henny Penny',
            'Herr+Von+Muellerhoff' => 'Herr Von Muellerhoff',
            'Holtwood+One+SC' => 'Holtwood One SC',
            'Homemade+Apple' => 'Homemade Apple',
            'Homenaje' => 'Homenaje',
            'IM+Fell+DW+Pica' => 'IM Fell DW Pica',
            'IM+Fell+DW+Pica+SC' => 'IM Fell DW Pica SC',
            'IM+Fell+Double+Pica' => 'IM Fell Double Pica',
            'IM+Fell+Double+Pica+SC' => 'IM Fell Double Pica SC',
            'IM+Fell+English' => 'IM Fell English',
            'IM+Fell+English+SC' => 'IM Fell English SC',
            'IM+Fell+French+Canon' => 'IM Fell French Canon',
            'IM+Fell+French+Canon+SC' => 'IM Fell French Canon SC',
            'IM+Fell+Great+Primer' => 'IM Fell Great Primer',
            'IM+Fell+Great+Primer+SC' => 'IM Fell Great Primer SC',
            'Iceberg' => 'Iceberg',
            'Iceland' => 'Iceland',
            'Imprima' => 'Imprima',
            'Inconsolata' => 'Inconsolata',
            'Inder' => 'Inder',
            'Indie+Flower' => 'Indie Flower',
            'Inika' => 'Inika',
            'Irish+Grover' => 'Irish Grover',
            'Istok+Web' => 'Istok Web',
            'Italiana' => 'Italiana',
            'Italianno' => 'Italianno',
            'Jacques+Francois' => 'Jacques Francois',
            'Jacques+Francois+Shadow' => 'Jacques Francois Shadow',
            'Jim+Nightshade' => 'Jim Nightshade',
            'Jockey+One' => 'Jockey One',
            'Jolly+Lodger' => 'Jolly Lodger',
            'Josefin+Sans' => 'Josefin Sans',
            'Josefin+Slab' => 'Josefin Slab',
            'Joti+One' => 'Joti One',
            'Judson' => 'Judson',
            'Julee' => 'Julee',
            'Julius+Sans+One' => 'Julius Sans One',
            'Junge' => 'Junge',
            'Jura' => 'Jura',
            'Just+Another+Hand' => 'Just Another Hand',
            'Just+Me+Again+Down+Here' => 'Just Me Again Down Here',
            'Kameron' => 'Kameron',
            'Karla' => 'Karla',
            'Kaushan+Script' => 'Kaushan Script',
            'Kavoon' => 'Kavoon',
            'Keania+One' => 'Keania One',
            'Kelly+Slab' => 'Kelly Slab',
            'Kenia' => 'Kenia',
            'Khmer' => 'Khmer',
            'Kite+One' => 'Kite One',
            'Knewave' => 'Knewave',
            'Kotta+One' => 'Kotta One',
            'Koulen' => 'Koulen',
            'Kranky' => 'Kranky',
            'Kreon' => 'Kreon',
            'Kristi' => 'Kristi',
            'Krona+One' => 'Krona One',
            'La+Belle+Aurore' => 'La Belle Aurore',
            'Lancelot' => 'Lancelot',
            'Lato' => 'Lato',
            'League+Script' => 'League Script',
            'Leckerli+One' => 'Leckerli One',
            'Ledger' => 'Ledger',
            'Lekton' => 'Lekton',
            'Lemon' => 'Lemon',
            'Libre+Baskerville' => 'Libre Baskerville',
            'Life+Savers' => 'Life Savers',
            'Lilita+One' => 'Lilita One',
            'Lily+Script+One' => 'Lily Script One',
            'Limelight' => 'Limelight',
            'Linden+Hill' => 'Linden Hill',
            'Lobster' => 'Lobster',
            'Lobster+Two' => 'Lobster Two',
            'Londrina+Outline' => 'Londrina Outline',
            'Londrina+Shadow' => 'Londrina Shadow',
            'Londrina+Sketch' => 'Londrina Sketch',
            'Londrina+Solid' => 'Londrina Solid',
            'Lora' => 'Lora',
            'Love+Ya+Like+A+Sister' => 'Love Ya Like A Sister',
            'Loved+by+the+King' => 'Loved by the King',
            'Lovers+Quarrel' => 'Lovers Quarrel',
            'Luckiest+Guy' => 'Luckiest Guy',
            'Lusitana' => 'Lusitana',
            'Lustria' => 'Lustria',
            'Macondo' => 'Macondo',
            'Macondo+Swash+Caps' => 'Macondo Swash Caps',
            'Magra' => 'Magra',
            'Maiden+Orange' => 'Maiden Orange',
            'Mako' => 'Mako',
            'Marcellus' => 'Marcellus',
            'Marcellus+SC' => 'Marcellus SC',
            'Marck+Script' => 'Marck Script',
            'Margarine' => 'Margarine',
            'Marko+One' => 'Marko One',
            'Marmelad' => 'Marmelad',
            'Marvel' => 'Marvel',
            'Mate' => 'Mate',
            'Mate+SC' => 'Mate SC',
            'Maven+Pro' => 'Maven Pro',
            'McLaren' => 'McLaren',
            'Meddon' => 'Meddon',
            'MedievalSharp' => 'MedievalSharp',
            'Medula+One' => 'Medula One',
            'Megrim' => 'Megrim',
            'Meie+Script' => 'Meie Script',
            'Merienda' => 'Merienda',
            'Merienda+One' => 'Merienda One',
            'Merriweather' => 'Merriweather',
            'Merriweather+Sans' => 'Merriweather Sans',
            'Metal' => 'Metal',
            'Metal+Mania' => 'Metal Mania',
            'Metamorphous' => 'Metamorphous',
            'Metrophobic' => 'Metrophobic',
            'Michroma' => 'Michroma',
            'Milonga' => 'Milonga',
            'Miltonian' => 'Miltonian',
            'Miltonian+Tattoo' => 'Miltonian Tattoo',
            'Miniver' => 'Miniver',
            'Miss+Fajardose' => 'Miss Fajardose',
            'Modern+Antiqua' => 'Modern Antiqua',
            'Molengo' => 'Molengo',
            'Molle' => 'Molle',
            'Monda' => 'Monda',
            'Monofett' => 'Monofett',
            'Monoton' => 'Monoton',
            'Monsieur+La+Doulaise' => 'Monsieur La Doulaise',
            'Montaga' => 'Montaga',
            'Montez' => 'Montez',
            'Montserrat' => 'Montserrat',
            'Montserrat+Alternates' => 'Montserrat Alternates',
            'Montserrat+Subrayada' => 'Montserrat Subrayada',
            'Moul' => 'Moul',
            'Moulpali' => 'Moulpali',
            'Mountains+of+Christmas' => 'Mountains of Christmas',
            'Mouse+Memoirs' => 'Mouse Memoirs',
            'Mr+Bedfort' => 'Mr Bedfort',
            'Mr+Dafoe' => 'Mr Dafoe',
            'Mr+De+Haviland' => 'Mr De Haviland',
            'Mrs+Saint+Delafield' => 'Mrs Saint Delafield',
            'Mrs+Sheppards' => 'Mrs Sheppards',
            'Muli' => 'Muli',
            'Mystery+Quest' => 'Mystery Quest',
            'Neucha' => 'Neucha',
            'Neuton' => 'Neuton',
            'New+Rocker' => 'New Rocker',
            'News+Cycle' => 'News Cycle',
            'Niconne' => 'Niconne',
            'Nixie+One' => 'Nixie One',
            'Nobile' => 'Nobile',
            'Nokora' => 'Nokora',
            'Norican' => 'Norican',
            'Nosifer' => 'Nosifer',
            'Nothing+You+Could+Do' => 'Nothing You Could Do',
            'Noticia+Text' => 'Noticia Text',
            'Noto+Sans' => 'Noto Sans',
            'Noto+Serif' => 'Noto Serif',
            'Nova+Cut' => 'Nova Cut',
            'Nova+Flat' => 'Nova Flat',
            'Nova+Mono' => 'Nova Mono',
            'Nova+Oval' => 'Nova Oval',
            'Nova+Round' => 'Nova Round',
            'Nova+Script' => 'Nova Script',
            'Nova+Slim' => 'Nova Slim',
            'Nova+Square' => 'Nova Square',
            'Numans' => 'Numans',
            'Nunito' => 'Nunito',
            'Odor+Mean+Chey' => 'Odor Mean Chey',
            'Offside' => 'Offside',
            'Old+Standard+TT' => 'Old Standard TT',
            'Oldenburg' => 'Oldenburg',
            'Oleo+Script' => 'Oleo Script',
            'Oleo+Script+Swash+Caps' => 'Oleo Script Swash Caps',
            'Open+Sans' => 'Open Sans',
            'Open+Sans+Condensed' => 'Open Sans Condensed',
            'Oranienbaum' => 'Oranienbaum',
            'Orbitron' => 'Orbitron',
            'Oregano' => 'Oregano',
            'Orienta' => 'Orienta',
            'Original+Surfer' => 'Original Surfer',
            'Oswald' => 'Oswald',
            'Over+the+Rainbow' => 'Over the Rainbow',
            'Overlock' => 'Overlock',
            'Overlock+SC' => 'Overlock SC',
            'Ovo' => 'Ovo',
            'Oxygen' => 'Oxygen',
            'Oxygen+Mono' => 'Oxygen Mono',
            'PT+Mono' => 'PT Mono',
            'PT+Sans' => 'PT Sans',
            'PT+Sans+Caption' => 'PT Sans Caption',
            'PT+Sans+Narrow' => 'PT Sans Narrow',
            'PT+Serif' => 'PT Serif',
            'PT+Serif+Caption' => 'PT Serif Caption',
            'Pacifico' => 'Pacifico',
            'Paprika' => 'Paprika',
            'Parisienne' => 'Parisienne',
            'Passero+One' => 'Passero One',
            'Passion+One' => 'Passion One',
            'Pathway+Gothic+One' => 'Pathway Gothic One',
            'Patrick+Hand' => 'Patrick Hand',
            'Patrick+Hand+SC' => 'Patrick Hand SC',
            'Patua+One' => 'Patua One',
            'Paytone+One' => 'Paytone One',
            'Peralta' => 'Peralta',
            'Permanent+Marker' => 'Permanent Marker',
            'Petit+Formal+Script' => 'Petit Formal Script',
            'Petrona' => 'Petrona',
            'Philosopher' => 'Philosopher',
            'Piedra' => 'Piedra',
            'Pinyon+Script' => 'Pinyon Script',
            'Pirata+One' => 'Pirata One',
            'Plaster' => 'Plaster',
            'Play' => 'Play',
            'Playball' => 'Playball',
            'Playfair+Display' => 'Playfair Display',
            'Playfair+Display+SC' => 'Playfair Display SC',
            'Podkova' => 'Podkova',
            'Poiret+One' => 'Poiret One',
            'Poller+One' => 'Poller One',
            'Poly' => 'Poly',
            'Pompiere' => 'Pompiere',
            'Pontano+Sans' => 'Pontano Sans',
            'Port+Lligat+Sans' => 'Port Lligat Sans',
            'Port+Lligat+Slab' => 'Port Lligat Slab',
            'Prata' => 'Prata',
            'Preahvihear' => 'Preahvihear',
            'Press+Start+2P' => 'Press Start 2P',
            'Princess+Sofia' => 'Princess Sofia',
            'Prociono' => 'Prociono',
            'Prosto+One' => 'Prosto One',
            'Puritan' => 'Puritan',
            'Purple+Purse' => 'Purple Purse',
            'Quando' => 'Quando',
            'Quantico' => 'Quantico',
            'Quattrocento' => 'Quattrocento',
            'Quattrocento+Sans' => 'Quattrocento Sans',
            'Questrial' => 'Questrial',
            'Quicksand' => 'Quicksand',
            'Quintessential' => 'Quintessential',
            'Qwigley' => 'Qwigley',
            'Racing+Sans+One' => 'Racing Sans One',
            'Radley' => 'Radley',
            'Raleway' => 'Raleway',
            'Raleway+Dots' => 'Raleway Dots',
            'Rambla' => 'Rambla',
            'Rammetto+One' => 'Rammetto One',
            'Ranchers' => 'Ranchers',
            'Rancho' => 'Rancho',
            'Rationale' => 'Rationale',
            'Redressed' => 'Redressed',
            'Reenie+Beanie' => 'Reenie Beanie',
            'Revalia' => 'Revalia',
            'Ribeye' => 'Ribeye',
            'Ribeye+Marrow' => 'Ribeye Marrow',
            'Righteous' => 'Righteous',
            'Risque' => 'Risque',
            'Roboto' => 'Roboto',
            'Roboto+Condensed' => 'Roboto Condensed',
            'Roboto+Slab' => 'Roboto Slab',
            'Rochester' => 'Rochester',
            'Rock+Salt' => 'Rock Salt',
            'Rokkitt' => 'Rokkitt',
            'Romanesco' => 'Romanesco',
            'Ropa+Sans' => 'Ropa Sans',
            'Rosario' => 'Rosario',
            'Rosarivo' => 'Rosarivo',
            'Rouge+Script' => 'Rouge Script',
            'Ruda' => 'Ruda',
            'Rufina' => 'Rufina',
            'Ruge+Boogie' => 'Ruge Boogie',
            'Ruluko' => 'Ruluko',
            'Rum+Raisin' => 'Rum Raisin',
            'Ruslan+Display' => 'Ruslan Display',
            'Russo+One' => 'Russo One',
            'Ruthie' => 'Ruthie',
            'Rye' => 'Rye',
            'Sacramento' => 'Sacramento',
            'Sail' => 'Sail',
            'Salsa' => 'Salsa',
            'Sanchez' => 'Sanchez',
            'Sancreek' => 'Sancreek',
            'Sansita+One' => 'Sansita One',
            'Sarina' => 'Sarina',
            'Satisfy' => 'Satisfy',
            'Scada' => 'Scada',
            'Schoolbell' => 'Schoolbell',
            'Seaweed+Script' => 'Seaweed Script',
            'Sevillana' => 'Sevillana',
            'Seymour+One' => 'Seymour One',
            'Shadows+Into+Light' => 'Shadows Into Light',
            'Shadows+Into+Light+Two' => 'Shadows Into Light Two',
            'Shanti' => 'Shanti',
            'Share' => 'Share',
            'Share+Tech' => 'Share Tech',
            'Share+Tech+Mono' => 'Share Tech Mono',
            'Shojumaru' => 'Shojumaru',
            'Short+Stack' => 'Short Stack',
            'Siemreap' => 'Siemreap',
            'Sigmar+One' => 'Sigmar One',
            'Signika' => 'Signika',
            'Signika+Negative' => 'Signika Negative',
            'Simonetta' => 'Simonetta',
            'Sintony' => 'Sintony',
            'Sirin+Stencil' => 'Sirin Stencil',
            'Six+Caps' => 'Six Caps',
            'Skranji' => 'Skranji',
            'Slackey' => 'Slackey',
            'Smokum' => 'Smokum',
            'Smythe' => 'Smythe',
            'Sniglet' => 'Sniglet',
            'Snippet' => 'Snippet',
            'Snowburst+One' => 'Snowburst One',
            'Sofadi+One' => 'Sofadi One',
            'Sofia' => 'Sofia',
            'Sonsie+One' => 'Sonsie One',
            'Sorts+Mill+Goudy' => 'Sorts Mill Goudy',
            'Source+Code+Pro' => 'Source Code Pro',
            'Source+Sans+Pro' => 'Source Sans Pro',
            'Special+Elite' => 'Special Elite',
            'Spicy+Rice' => 'Spicy Rice',
            'Spinnaker' => 'Spinnaker',
            'Spirax' => 'Spirax',
            'Squada+One' => 'Squada One',
            'Stalemate' => 'Stalemate',
            'Stalinist+One' => 'Stalinist One',
            'Stardos+Stencil' => 'Stardos Stencil',
            'Stint+Ultra+Condensed' => 'Stint Ultra Condensed',
            'Stint+Ultra+Expanded' => 'Stint Ultra Expanded',
            'Stoke' => 'Stoke',
            'Strait' => 'Strait',
            'Sue+Ellen+Francisco' => 'Sue Ellen Francisco',
            'Sunshiney' => 'Sunshiney',
            'Supermercado+One' => 'Supermercado One',
            'Suwannaphum' => 'Suwannaphum',
            'Swanky+and+Moo+Moo' => 'Swanky and Moo Moo',
            'Syncopate' => 'Syncopate',
            'Tangerine' => 'Tangerine',
            'Taprom' => 'Taprom',
            'Tauri' => 'Tauri',
            'Telex' => 'Telex',
            'Tenor+Sans' => 'Tenor Sans',
            'Text+Me+One' => 'Text Me One',
            'The+Girl+Next+Door' => 'The Girl Next Door',
            'Tienne' => 'Tienne',
            'Tinos' => 'Tinos',
            'Titan+One' => 'Titan One',
            'Titillium+Web' => 'Titillium Web',
            'Trade+Winds' => 'Trade Winds',
            'Trocchi' => 'Trocchi',
            'Trochut' => 'Trochut',
            'Trykker' => 'Trykker',
            'Tulpen+One' => 'Tulpen One',
            'Ubuntu' => 'Ubuntu',
            'Ubuntu+Condensed' => 'Ubuntu Condensed',
            'Ubuntu+Mono' => 'Ubuntu Mono',
            'Ultra' => 'Ultra',
            'Uncial+Antiqua' => 'Uncial Antiqua',
            'Underdog' => 'Underdog',
            'Unica+One' => 'Unica One',
            'UnifrakturCook' => 'UnifrakturCook',
            'UnifrakturMaguntia' => 'UnifrakturMaguntia',
            'Unkempt' => 'Unkempt',
            'Unlock' => 'Unlock',
            'Unna' => 'Unna',
            'VT323' => 'VT323',
            'Vampiro+One' => 'Vampiro One',
            'Varela' => 'Varela',
            'Varela+Round' => 'Varela Round',
            'Vast+Shadow' => 'Vast Shadow',
            'Vibur' => 'Vibur',
            'Vidaloka' => 'Vidaloka',
            'Viga' => 'Viga',
            'Voces' => 'Voces',
            'Volkhov' => 'Volkhov',
            'Vollkorn' => 'Vollkorn',
            'Voltaire' => 'Voltaire',
            'Waiting+for+the+Sunrise' => 'Waiting for the Sunrise',
            'Wallpoet' => 'Wallpoet',
            'Walter+Turncoat' => 'Walter Turncoat',
            'Warnes' => 'Warnes',
            'Wellfleet' => 'Wellfleet',
            'Wendy+One' => 'Wendy One',
            'Wire+One' => 'Wire One',
            'Yanone+Kaffeesatz' => 'Yanone Kaffeesatz',
            'Yellowtail' => 'Yellowtail',
            'Yeseva+One' => 'Yeseva One',
            'Yesteryear' => 'Yesteryear',
            'Zeyada' => 'Zeyada'

        );

        return $array;

    }
}



// **********************************************************************//
// ! Custom meta fields to categories
// **********************************************************************//
if(function_exists('et_get_term_meta')){

function etheme_taxonomy_edit_meta_field($term, $taxonomy) {
    $id = $term->term_id;
    $term_meta = et_get_term_meta($id,'cat_meta');

    if(!$term_meta){$term_meta = et_add_term_meta($id, 'cat_meta', '');}
     ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[cat_header]"><?php esc_html_e( 'Category Header', 'woopress' ); ?></label></th>
        <td>
            <?php
                $content = esc_attr( $term_meta[0]['cat_header'] ) ? esc_attr( $term_meta[0]['cat_header'] ) : '';
                $editor_id = 'term_meta';
                $settings = array('media_buttons' => true, 'textarea_name' => 'term_meta[cat_header]');
                wp_editor($content, $editor_id, $settings);

            ?>
        </td>
    </tr>
<?php
}

add_action( 'product_cat_edit_form_fields', 'etheme_taxonomy_edit_meta_field', 20, 2 );

// **********************************************************************//
// ! Save meta fields
// **********************************************************************//
function save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $term_meta = et_get_term_meta($term_id,'cat_meta');
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        et_update_term_meta($term_id, 'cat_meta', $term_meta);

    }
}
add_action( 'edited_product_cat', 'save_taxonomy_custom_meta', 10, 2 );
}


// **********************************************************************//
// ! Add google analytics code
// **********************************************************************//
add_action('init', 'et_google_analytics');
if(!function_exists('et_google_analytics')) {
function et_google_analytics() {
    $googleCode = etheme_get_option('google_code');

    if(empty($googleCode)) return;

    if(strpos($googleCode,'UA-') === 0) {

        $googleCode = "

<script type='text/javascript'>

var _gaq = _gaq || [];
_gaq.push(['_setAccount', '".$googleCode."']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>

";
    }

    add_action('wp_head', 'et_print_google_code');
}

function et_print_google_code() {
    if( ! empty( etheme_get_option( 'google_code') ) ) {
        echo etheme_get_option('google_code');
    }
}

}

// **********************************************************************//
// ! Related posts
// **********************************************************************//

if(!function_exists('et_get_related_posts')) {
    function et_get_related_posts($postId = false, $limit = 5){
        global $post;
        if(!$postId) {
            $postId = $post->ID;
        }
        $categories = get_the_category($postId);
        if ($categories) {
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

            $args = array(
                'category__in' => $category_ids,
                'post__not_in' => array($postId),
                'showposts'=>$limit, // Number of related posts that will be shown.
                'ignore_sticky_posts'=>1
            );
            etheme_create_posts_slider($args, esc_html__('Related posts', 'woopress'), false, true, true);
        }
    }
}

// **********************************************************************//
// ! Get activated theme
// **********************************************************************//
if(!function_exists('etheme_activated_theme')) {
    function etheme_activated_theme() {
        return get_option( 'etheme_activated_theme', false );
    }

}
// **********************************************************************//
// ! Is theme activatd
// **********************************************************************//

if(!function_exists('etheme_is_activated')) {
    function etheme_is_activated() {
        if ( etheme_activated_theme() != ETHEME_DOMAIN ) return false;
        return get_option( 'etheme_is_activated', false );
    }
}

if ( !function_exists('et_staticblocks_columns') ) {
    function et_staticblocks_columns($defaults) {
        return array(
            'cb'               => '<input type="checkbox" />',
            'title'            => esc_html__( 'Title', 'woopress' ),
            'shortcode_column' => esc_html__( 'Shortcode', 'woopress' ),
            'date'             => esc_html__( 'Date', 'woopress' ),
        );
    }
}

if ( !function_exists('et_staticblocks_columns_val') ) {   
    function et_staticblocks_columns_val($column_name, $post_ID) {
       if ($column_name == 'shortcode_column') {
            echo '[block id="'.$post_ID.'"]';
       }
    }
}

if(!function_exists('et_get_static_blocks')) {
    function et_get_static_blocks () {
        $return_array = array();
        $args = array( 'post_type' => 'staticblocks', 'posts_per_page' => 50);
        $myposts = get_posts( $args );
        $i=0;
        foreach ( $myposts as $post ) {
            $i++;
            $return_array[$i]['label'] = get_the_title($post->ID);
            $return_array[$i]['value'] = $post->ID;
        }
        wp_reset_postdata();
        return $return_array;
    }
}


if(!function_exists('et_show_block')) {
    function et_show_block ($id = false) {
        echo et_get_block($id);
    }
}


if(!function_exists('et_get_block')) {
    function et_get_block($id = false) {
        if(!$id) return;
        global $post;

        $output = false;

        $output = wp_cache_get( $id, 'et_get_block' );


        if ( post_password_required( $id ) ) {

            echo get_the_password_form( $id );

            return;
        }

        $post_id = ( ! is_404() || ! is_search() ) ? '' : $post->ID;

        if ( $post_id == '' || post_password_required( $post_id ) || ! post_password_required( $post_id ) ) {

            if ( ! $output ) {

                $args = array( 'include' => $id,'post_type' => 'staticblocks', 'posts_per_page' => 1);
                $output = '';
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) {
                    setup_postdata($post);

                    $output = do_shortcode(get_the_content($post->ID));

                    $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
                    if ( ! empty( $shortcodes_custom_css ) ) {
                        $output .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
                        $output .= $shortcodes_custom_css;
                        $output .= '</style>';
                    }
                }
                wp_reset_postdata();

                wp_cache_add( $id, $output, 'et_get_block' );
            }
        }

        return $output;
   }
}


// **********************************************************************//
// ! Promo Popup
// **********************************************************************//
add_action('after_page_wrapper', 'et_promo_popup');
if(!function_exists('et_promo_popup')) {
    function et_promo_popup() {
        if(!etheme_get_option('promo_popup')) return;
        $bg = etheme_get_option('pp_bg');
        $padding = etheme_get_option('pp_padding');
        ?>
            <div id="etheme-popup" class="white-popup-block mfp-hide mfp-with-anim zoom-anim-dialog">
                <?php echo do_shortcode(etheme_get_option('pp_content')); ?>
                <p class="checkbox-label">
                    <input type="checkbox" value="do-not-show" name="showagain" id="showagain" class="showagain" />
                    <label for="showagain"><?php esc_html_e("Don't show this popup again", 'woopress'); ?></label>
                </p>
            </div>
            <style type="text/css">
                #etheme-popup {
                    width: <?php echo (etheme_get_option('pp_width') != '') ? etheme_get_option('pp_width') : 700 ; ?>px;
                    height: <?php echo (etheme_get_option('pp_height') != '') ? etheme_get_option('pp_height') : 350 ; ?>px;
                    <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo esc_attr( $bg['background-color'] ); ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-image'])): ?>  background-image: url("<?php echo esc_attr($bg['background-image']); ?> "); <?php endif; ?>
                    <?php if(!empty($bg['background-attachment'])): ?>  background-attachment: <?php echo esc_attr($bg['background-attachment']); ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-repeat'])): ?>  background-repeat: <?php echo esc_attr($bg['background-repeat']); ?>;<?php  endif; ?>
                    <?php if(!empty($bg['background-position'])): ?>  background-position: <?php echo esc_attr($bg['background-position']); ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-size'])): ?>  background-size: <?php echo esc_attr($bg['background-size']); ?>;<?php endif; ?>
                }
            </style>
        <?php
    }
}



// **********************************************************************//
// ! Preloader HTML
// **********************************************************************//
//add_action('after_page_wrapper', 'et_preloader_html');
if(!function_exists('et_preloader_html')) {
    function et_preloader_html() {
        ?>
            <div id="preloader">
                <?php $logoimg = etheme_get_option('loader_logo'); ?>
                <?php if($logoimg): ?>
                    <a href="<?php echo home_url(); ?>"><img src="<?php echo esc_url( $logoimg ) ?>" alt="<?php bloginfo( 'description' ); ?>" /></a>
                <?php else: ?>
                    <a href="<?php echo home_url(); ?>"><img src="<?php echo PARENT_URL.'/images/loader-logo.png'; ?>" alt="<?php bloginfo('name'); ?>"></a>
                <?php endif ; ?>
            </div>
        <?php
    }
}


// **********************************************************************//
// ! Helper functions
// **********************************************************************//
if(!function_exists('pr')) {
    function pr($arr) {
        echo '<pre>';
            print_r($arr);
        echo '</pre>';
    }
}

if(!function_exists('actions_to_remove')) {
    function actions_to_remove($tag, $array) {
        foreach($array as $action) {
            remove_action($tag, $action[0], $action[1]);
        }
    }
}
if(!function_exists('et_get_actions')) {
    function et_get_actions($tag = '') {
        global $wp_filter;
        return $wp_filter[$tag];
    }
}


if(!function_exists('jsString')) {
    function jsString($str='') {
        return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
    }
}
if(!function_exists('hex2rgb')) {
    function hex2rgb($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       //return implode(",", $rgb); // returns the rgb values separated by commas
       return $rgb; // returns an array with the rgb values
    }
}

if(!function_exists('trunc')) {
    function trunc($phrase, $max_words) {
       $phrase_array = explode(' ',$phrase);
       if(count($phrase_array) > $max_words && $max_words > 0)
          $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).' ...';
       return $phrase;
    }
}


if(!function_exists('et_http')) {
    function et_http() {
        return (is_ssl())?"https://":"http://";
    }
}

if(!function_exists('et_get_icons')) {
    function et_get_icons() {
        $iconsArray = array("adjust","anchor","archive","arrows","arrows-h","arrows-v","asterisk","ban","bar-chart-o","barcode","bars","beer","bell","bell-o","bolt","book","bookmark","bookmark-o","briefcase","bug","building-o","bullhorn","bullseye","calendar","calendar-o","camera","camera-retro","caret-square-o-down","caret-square-o-left","caret-square-o-right","caret-square-o-up","certificate","check","check-circle","check-circle-o","check-square","check-square-o","circle","circle-o","clock-o","cloud","cloud-download","cloud-upload","code","code-fork","coffee","cog","cogs","comment","comment-o","comments","comments-o","compass","credit-card","crop","crosshairs","cutlery","dashboard","desktop","dot-circle-o","download","edit","ellipsis-h","ellipsis-v","envelope","envelope-o","eraser","exchange","exclamation","exclamation-circle","exclamation-triangle","external-link","external-link-square","eye","eye-slash","female","fighter-jet","film","filter","fire","fire-extinguisher","flag","flag-checkered","flag-o","flash","flask","folder","folder-o","folder-open","folder-open-o","frown-o","gamepad","gavel","gear","gears","gift","glass","globe","group","hdd-o","headphones","heart","heart-o","home","inbox","info","info-circle","key","keyboard-o","laptop","leaf","legal","lemon-o","level-down","level-up","lightbulb-o","location-arrow","lock","magic","magnet","mail-forward","mail-reply","mail-reply-all","male","map-marker","meh-o","microphone","microphone-slash","minus","minus-circle","minus-square","minus-square-o","mobile","mobile-phone","money","moon-o","music","pencil","pencil-square","pencil-square-o","phone","phone-square","picture-o","plane","plus","plus-circle","plus-square","plus-square-o","power-off","print","puzzle-piece","qrcode","question","question-circle","quote-left","quote-right","random","refresh","reply","reply-all","retweet","road","rocket","rss","rss-square","search","search-minus","search-plus","share","share-square","share-square-o","shield","shopping-cart","sign-in","sign-out","signal","sitemap","smile-o","sort","sort-alpha-asc","sort-alpha-desc","sort-amount-asc","sort-amount-desc","sort-asc","sort-desc","sort-down","sort-numeric-asc","sort-numeric-desc","sort-up","spinner","square","square-o","star","star-half","star-half-empty","star-half-full","star-half-o","star-o","subscript","suitcase","sun-o","superscript","tablet","tachometer","tag","tags","tasks","terminal","thumb-tack","thumbs-down","thumbs-o-down","thumbs-o-up","thumbs-up","ticket","times","times-circle","times-circle-o","tint","toggle-down","toggle-left","toggle-right","toggle-up","trash-o","trophy","truck","umbrella","unlock","unlock-alt","unsorted","upload","user","users","video-camera","volume-down","volume-off","volume-up","warning","wheelchair","wrench", "check-square","check-square-o","circle","circle-o","dot-circle-o","minus-square","minus-square-o","plus-square","plus-square-o","square","square-o","bitcoin","btc","cny","dollar","eur","euro","gbp","inr","jpy","krw","money","rmb","rouble","rub","ruble","rupee","try","turkish-lira","usd","won","yen","align-center","align-justify","align-left","align-right","bold","chain","chain-broken","clipboard","columns","copy","cut","dedent","eraser","file","file-o","file-text","file-text-o","files-o","floppy-o","font","indent","italic","link","list","list-alt","list-ol","list-ul","outdent","paperclip","paste","repeat","rotate-left","rotate-right","save","scissors","strikethrough","table","text-height","text-width","th","th-large","th-list","underline","undo","unlink","angle-double-down","angle-double-left","angle-double-right","angle-double-up","angle-down","angle-left","angle-right","angle-up","arrow-circle-down","arrow-circle-left","arrow-circle-o-down","arrow-circle-o-left","arrow-circle-o-right","arrow-circle-o-up","arrow-circle-right","arrow-circle-up","arrow-down","arrow-left","arrow-right","arrow-up","arrows","arrows-alt","arrows-h","arrows-v","caret-down","caret-left","caret-right","caret-square-o-down","caret-square-o-left","caret-square-o-right","caret-square-o-up","caret-up","chevron-circle-down","chevron-circle-left","chevron-circle-right","chevron-circle-up","chevron-down","chevron-left","chevron-right","chevron-up","hand-o-down","hand-o-left","hand-o-right","hand-o-up","long-arrow-down","long-arrow-left","long-arrow-right","long-arrow-up","toggle-down","toggle-left","toggle-right","toggle-up", "angle-double-down","angle-double-left","angle-double-right","angle-double-up","angle-down","angle-left","angle-right","angle-up","arrow-circle-down","arrow-circle-left","arrow-circle-o-down","arrow-circle-o-left","arrow-circle-o-right","arrow-circle-o-up","arrow-circle-right","arrow-circle-up","arrow-down","arrow-left","arrow-right","arrow-up","arrows","arrows-alt","arrows-h","arrows-v","caret-down","caret-left","caret-right","caret-square-o-down","caret-square-o-left","caret-square-o-right","caret-square-o-up","caret-up","chevron-circle-down","chevron-circle-left","chevron-circle-right","chevron-circle-up","chevron-down","chevron-left","chevron-right","chevron-up","hand-o-down","hand-o-left","hand-o-right","hand-o-up","long-arrow-down","long-arrow-left","long-arrow-right","long-arrow-up","toggle-down","toggle-left","toggle-right","toggle-up","adn","android","apple","bitbucket","bitbucket-square","bitcoin","btc","css3","dribbble","dropbox","facebook","facebook-square","flickr","foursquare","github","github-alt","github-square","gittip","google-plus","google-plus-square","html5","instagram","linkedin","linkedin-square","linux","maxcdn","pagelines","pinterest","pinterest-square","renren","skype","stack-exchange","stack-overflow","trello","tumblr","tumblr-square","twitter","twitter-square","vimeo-square","vk","weibo","windows","xing","xing-square","youtube","youtube-play","youtube-square","ambulance","h-square","hospital-o","medkit","plus-square","stethoscope","user-md","wheelchair");

        return array_unique($iconsArray);

    }
}



if(!function_exists('vc_icon_form_field')) {
    function vc_icon_form_field($settings, $value) {
        $settings_line = '';
        $selected = '';
        $array = et_get_icons();
        if($value != '') {
            $array = array_diff($array, array($value));
            array_unshift($array,$value);
        }

        $settings_line .= '<div class="et-icon-selector">';
        $settings_line .= '<input type="hidden" value="'.$value.'" name="'.$settings['param_name'].'" class="et-hidden-icon wpb_vc_param_value wpb-icon-select '.$settings['param_name'].' '.$settings['type'] . '">';
            foreach ($array as $icon) {
                if ($value == $icon) {
                    $selected = 'selected';
                }
                $settings_line .= '<span class="et-select-icon '.$selected.'" data-icon-name='.$icon.'><i class="fa fa-'.$icon.'"></i></span>';
                $selected = '';
            }

        $settings_line .= '<script>';
        $settings_line .= 'jQuery(".et-select-icon").click(function(){';
            $settings_line .= 'var iconName = jQuery(this).data("icon-name");';
            $settings_line .= 'console.log(iconName);';
            $settings_line .= 'if(!jQuery(this).hasClass("selected")) {';
                $settings_line .= 'jQuery(".et-select-icon").removeClass("selected");';
                $settings_line .= 'jQuery(this).addClass("selected");';
                $settings_line .= 'jQuery(this).parent().find(".et-hidden-icon").val(iconName);';
            $settings_line .= '}';

        $settings_line .= '});';
        $settings_line .= '</script>';

        $settings_line .= '</div>';
        return $settings_line;
    }
}

if ( ! function_exists( 'et_excerpt_length' ) ):
/**
 *
 * Change excerpt length.
 *
 */
function et_excerpt_length() {
    return intval(etheme_get_option('excerpt_length'));
}
add_filter( 'excerpt_length', 'et_excerpt_length', 999 );

endif;


if ( ! function_exists( 'et_check_units' ) ):
/**
 *
 * Сheck value.
 *
 */
function et_check_units( $array, $var ) {

    foreach ( $array as $value ) {

        if ( strpos( $var, $value ) ) {
            return true;
        }

    }

}

endif;

if( ! function_exists( 'etheme_get_slider_params' ) ) {
    function etheme_get_slider_params() {
        return array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Slider speed", 'woopress'),
                "param_name" => "slider_speed",
                "group" => esc_html__('Slider settings', 'woopress')
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Slider autoplay", 'woopress'),
                "param_name" => "slider_autoplay",
                "group" => esc_html__('Slider settings', 'woopress'),
                'value' => array( esc_html__( 'Yes, please', 'woopress' ) => 'yes' )

            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Hide prev/next buttons", 'woopress'),
                "param_name" => "hide_buttons",
                "group" => esc_html__('Slider settings', 'woopress'),
                'value' => array( esc_html__( 'Yes, please', 'woopress' ) => 'yes' )

            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Pagination type', 'woopress' ),
                'param_name' => 'pagination_type',
                'group' => esc_html__('Slider settings', 'woopress'),
                'value' => array(
                    __( 'Hide', 'woopress' ) => 'hide',
                    __( 'Bullets', 'woopress' ) => 'bullets',
                    __( 'Lines', 'woopress' ) => 'lines',
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Hide pagination only for', 'woopress' ),
                'param_name' => 'hide_fo',
                'dependency' => array(
                    'element' => 'pagination_type',
                    'value' => array( 'bullets', 'lines' ),
                ),
                'group' => esc_html__('Slider settings', 'woopress'),
                'value' => array(
                    '' => '',
                    __( 'Mobile', 'woopress' ) => 'mobile',
                    __( 'Desktop', 'woopress' ) => 'desktop',
                ),
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Pagination default color", "woopress" ),
                "param_name" => "default_color",
                'dependency' => array(
                    'element' => 'pagination_type',
                    'value' => array( 'bullets', 'lines' ),
                ),
                "group" => esc_html__('Slider settings', 'woopress'),
                "value" => '#e6e6e6',
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Pagination active color", "woopress" ),
                "param_name" => "active_color",
                'dependency' => array(
                    'element' => 'pagination_type',
                    'value' => array( 'bullets', 'lines' ),
                ),
                "group" => esc_html__('Slider settings', 'woopress'),
                "value" => '#b3a089',
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Number of slides on large screens", 'woopress'),
                "param_name" => "large",
                "group" => esc_html__('Slider settings', 'woopress')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("On notebooks", 'woopress'),
                "param_name" => "notebook",
                "group" => esc_html__('Slider settings', 'woopress')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("On tablet landscape", 'woopress'),
                "param_name" => "tablet_land",
                "group" => esc_html__('Slider settings', 'woopress')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("On tablet portrait", 'woopress'),
                "param_name" => "tablet_portrait",
                "group" => esc_html__('Slider settings', 'woopress')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("On mobile", 'woopress'),
                "param_name" => "mobile",
                "group" => esc_html__('Slider settings', 'woopress')
            ),
        );
    }
}

add_action('wp_ajax_etheme_deactivate_theme', 'etheme_deactivate_theme');
if( ! function_exists( 'etheme_deactivate_theme' ) ) {
    function etheme_deactivate_theme() {
        $data = array(
            'api_key' => 0,
            'theme' => 0,
            'purchase' => 0,
        );
        // if ( update_option( 'etheme_activated_data', maybe_unserialize( $data ) )) {
        //     update_option( 'etheme_activated_data', maybe_unserialize( $data ) );
        // }
        // else {
        //     update_option( 'woopress_api_key', 0 );
        //     update_option( 'woopress_purchase_code', 0 );
        // }

        update_option( 'etheme_api_key', 0 );
        update_option( 'etheme_is_activated', false );
        update_option( 'etheme_purchase_code', 0 );


    }
}

// **********************************************************************//
// ! Add hatom data
// **********************************************************************//

if ( ! function_exists( 'et_add_hatom_data' ) ) {
    function et_add_hatom_data($content) {
        $t = get_the_modified_time('F jS, Y');
        $author = get_the_author();
        if( is_home() || is_singular() || is_archive() ) {
            $content .= '<div class="hatom-extra" style="display:none;visibility:hidden;">was last modified: <span class="updated"> '.$t.'</span> by <span class="author vcard"><span class="fn">'.$author.'</span></span></div>';
        }
        return $content;
    }
    if ( etheme_get_option('enable_hatom_meta') ) {
        add_filter('the_content', 'et_add_hatom_data');
        add_filter('get_the_content', 'et_add_hatom_data');
        add_filter('get_the_excerpt', 'et_add_hatom_data');
    }
}

// **********************************************************************//
// ! Ult fixes
// **********************************************************************//
function et_dequeue_ult_styles() {
    $force_ultimate_styles = etheme_get_option('force_addons_css');
    if ($force_ultimate_styles ) {
        wp_dequeue_style( 'style_ultimate_expsection' );
        wp_deregister_style( 'style_ultimate_expsection' );
    }
}
add_action( 'wp_print_styles', 'et_dequeue_ult_styles' );

// **********************************************************************//
// ! Check file exists by url
// **********************************************************************//
if ( ! function_exists( 'etheme_file_exists' ) ) :
    function etheme_file_exists( $url ) {
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['basedir'];
        $url = explode( '/uploads', $url );

        $file = $upload_dir;

        if ( isset( $url[1] ) ) {
           $file .= $url[1];
        }

        return file_exists( $file );
    }
endif;

if(!function_exists('etheme_get_sidebars')) {
    function etheme_get_sidebars() {
        global $wp_registered_sidebars;
        $sidebars[] = '--Choose--';
        foreach( $wp_registered_sidebars as $id=>$sidebar ) {
            $sidebars[ $id ] = $sidebar[ 'name' ];
        }
        return $sidebars;
    }
}


if(!function_exists('etheme_get_menus_options')) {
    function etheme_get_menus_options() {
        $menus = array();
        $menus = array(""=>"Default");
        $nav_terms = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
        foreach ( $nav_terms as $obj ) {
            $menus[$obj->slug] = $obj->name;
        }
        return $menus;
    }
}

function et_get_redux_static_blocks( $before = array() ) {
    $return_array = array();
    $args = array( 'post_type' => 'staticblocks', 'posts_per_page' => 50);
    $myposts = get_posts( $args );
    $i=0;
    foreach ( $myposts as $post ) {
        $i++;
        $return_array[$post->ID] = get_the_title($post->ID);
    }
    wp_reset_postdata();

    $return_array = $before + $return_array;

    return $return_array;
}


function is_woopress_migrated(){
    if ( get_option( 'option_tree' ) ) {
        return get_option( 'woopess_option_migrated', false );
    } else{
        return true;
    }
}


// **********************************************************************// 
// ! Notice "Options migrate"
// **********************************************************************// 
add_action( 'admin_notices', 'etheme_woopress_migrate_notice', 50 );
function etheme_woopress_migrate_notice(){
    if ( ! is_woopress_migrated() ) {
        echo '<div class="wrap">
                <div class="et-message et-info notice">
                    '.sprintf(esc_html__('%1s %2s To finish migration from Option Tree (old Theme Options) to Redux Framework (new Theme Options) we have to update your database to the newest version. %3s %4s', 'woopress'), '<strong>'.esc_html__('WooPress database update required.', 'woopress').'</strong><br/>', '<p>', '</p>', '<a href="'. admin_url('themes.php?page=_options&woopess_migrate_options') . '" class="etheme-migrator et-button et-button-green">' . esc_html__('Please update now', 'woopress') . '</a>') . '
                </div>
            </div>
        ';
    }
}


add_action( 'admin_init', 'woopress_core_force_stop', 50 );
function woopress_core_force_stop(){
    $file = ABSPATH . 'wp-content/plugins/woopess-core/woopess-core.php';
    if ( ! file_exists($file) ) return;

    $plugin = get_plugin_data( $file, false, false );

    if ( version_compare( '1.1.5', $plugin['Version'], '>' ) ) {
        update_option( 'woopress_core_force_stop', true );
    } else {
        update_option( 'woopress_core_force_stop', false );
    }
}


// **********************************************************************// 
// ! Notice "Plugin version"
// **********************************************************************// 
add_action( 'admin_notices', 'etheme_required_core_notice', 50 );
function etheme_required_core_notice(){
    $file = ABSPATH . 'wp-content/plugins/woopress-core/woopress-core.php';
    if ( ! file_exists($file) ) return;

    $plugin = get_plugin_data( $file, false, false );

    if ( version_compare( '1.1.5', $plugin['Version'], '>' ) ) {
        echo '
        <div class="et-message et-error error">
            <p>Attention!</p>
            <p>This theme version requires the following plugin <strong>WooPress Core</strong> to be updated up to 1.1.5 version</p>
        </div>
    ';
    }
}


// **********************************************************************// 
// ! core plugin active notice
// **********************************************************************// 
if( ! function_exists('woopress_plugin_notice') ) {
    function woopress_plugin_notice($notice = '') {
        if ( ! function_exists( 'woopress_plugin_compatibility' ) ) {
            if ( $notice == '' ) $notice = esc_html__( 'To use this element install/activate or update WooPress Core plugin', 'woopress' );
            echo '<p>' . $notice . '</p>';
            return true;
        } else {
            return false;
        }
    }
}

// **********************************************************************// 
// ! Instagram feed
// **********************************************************************// 
// Instagram feed : remove user
add_action('wp_ajax_et_instagram_user_remove', 'et_instagram_user_remove');
if( ! function_exists( 'et_instagram_user_remove' ) ) {
    function et_instagram_user_remove() {
        if ( isset( $_POST['token'] ) && $_POST['token'] ) {
            $api_data = get_option( 'etheme_instagram_api_data' );
            $api_data = json_decode($api_data, true);

            if ( isset($api_data[$_POST['token']]) ) {
                unset($api_data[$_POST['token']]);
                update_option('etheme_instagram_api_data',json_encode($api_data));
                echo "success";
                die();
            }
            echo "this token is not exist";
            die();
        }
        echo "empty token";
        die();
    }
}

// Instagram feed : save settings
add_action('wp_ajax_et_instagram_save_settings', 'et_instagram_save_settings');
if( ! function_exists( 'et_instagram_save_settings' ) ) {
    function et_instagram_save_settings() {
        if ( isset( $_POST['time'] ) && isset( $_POST['time_type'] ) ) {
            $api_settings = get_option( 'etheme_instagram_api_settings' );
            $api_settings = json_decode($api_settings, true);

            $api_settings['time']      = ( $_POST['time'] && $_POST['time'] != 0 && $_POST['time'] !== '0' ) ? $_POST['time'] : 2;
            $api_settings['time_type'] = $_POST['time_type'];

            update_option('etheme_instagram_api_settings',json_encode($api_settings));
            echo "success";
            die();
        }
        echo "some data is not provided";
        die();
    }
}

// Instagram feed : add user
add_action('wp_ajax_et_instagram_user_add', 'et_instagram_user_add');
if( ! function_exists( 'et_instagram_user_add' ) ) {
    function et_instagram_user_add() {
        if ( isset( $_POST['token'] ) && $_POST['token'] ) {
            $user_url = 'https://api.instagram.com/v1/users/self/?access_token=' . $_POST['token'];
            $api_data = get_option( 'etheme_instagram_api_data' );
            $api_data = json_decode($api_data, true);

            if ( ! is_array( $api_data ) ) {
                $api_data = array();
            }

            $user_data = wp_remote_get($user_url);

            if ( ! $user_data ) {
                echo "Unable to communicate with Instagram";
                die();
            }

            if ( is_wp_error( $user_data ) ) {
                echo esc_html__( 'Unable to communicate with Instagram.', 'woopress' );
                die();
            }

            if ( 200 !== wp_remote_retrieve_response_code( $user_data ) ) {
                echo esc_html__( 'Instagram did not return a 200.', 'woopress' );
                die();
            }

            $user_data = wp_remote_retrieve_body( $user_data );

            if ( ! isset( $api_data[$_POST['token']] ) ) {
                $api_data[$_POST['token']] = $user_data;
            } else {
                echo "this token already exist";
                die();
            }

            update_option('etheme_instagram_api_data',json_encode($api_data));

            echo "success";
            die();
        }
        echo "empty token";
        die();
    }
}