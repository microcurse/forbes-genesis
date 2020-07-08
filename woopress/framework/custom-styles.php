<?php 

// **********************************************************************//
// ! Ititialize theme confoguration and variables
// **********************************************************************//
add_action('wp_head', 'etheme_init');
if(!function_exists('etheme_init')) {
    function etheme_init() {
        global $etheme_responsive;
        etheme_get_chosen_google_font();
        ?>

            <style type="text/css">

            <?php
                // ! Use @font-face to load font on page
                $fonts = get_option( 'etheme-fonts', false );
                    if ( $fonts ) {
                        foreach ( $fonts as $value ) {
                            // ! Validate format
                            switch ( $value['file']['extension'] ) {
                                case 'ttf':
                                    $format = 'truetype';
                                    break;
                                case 'otf':
                                    $format = 'opentype';
                                    break;
                                case 'eot':
                                    $format = false;
                                    break;
                                case 'eot?#iefix':
                                    $format = 'embedded-opentype';
                                    break;
                                case 'woff2':
                                    $format = 'woff2';
                                    break;
                                case 'woff':
                                    $format = 'woff';
                                    break;
                                default:
                                    $format = false;
                                    break;
                            }

                            $format = ( $format ) ? 'format("' . $format . '")' : '';

                            // ! Set fonts
                            echo '
                                @font-face {
                                    font-family: ' . $value['name'] . ';
                                    src: url(' . $value['file']['url'] . ') ' . $format . ';
                                }
                            ';
                        }

                    }
                ?>

                <?php if ( etheme_get_option('default_fonts') != 'disable' ) : ?>

  
                    // Raleway
                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-Light.ttf') format('truetype');
                      font-weight: 300, 400, 300i, 400i, 500, 600, 700, 800 
                      font-style: normal;
                    }

                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-LightItalic.ttf') format('truetype');
                      font-weight: 300;
                      font-style: italic;
                    }

                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-Regular.ttf') format('truetype');
                      font-weight: 400;
                      font-style: normal;
                    }

                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-RegularItalic.ttf') format('truetype');
                      font-weight: 400;
                      font-style: italic;
                    }

                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-Medium.ttf') format('truetype');
                      font-weight: 500;
                      font-style: normal;
                    }

                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-MediumItalic.ttf') format('truetype');
                      font-weight: 500;
                      font-style: italic;
                    }

                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-SemiBold.ttf') format('truetype');
                      font-weight: 600;
                      font-style: normal;
                    }

                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-Bold.ttf') format('truetype');
                      font-weight: 700;
                      font-style: normal;
                    }

                    @font-face {
                      font-family: 'Raleway';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Raleway-ExtraBold.ttf') format('truetype');
                      font-weight: 800;
                      font-style: normal;
                    }

                    // Satisfy 
  
                    @font-face {
                      font-family: 'Satisfy';
                      src: url('<?php echo ETHEME_BASE_URI ?>fonts/raleway/Satisfy-Regular.ttf') format('truetype');
                      font-weight: 400;
                      font-style: normal;
                    }

                <?php endif; ?>

                <?php if ( etheme_get_option('site_width') && etheme_get_option('site_width') >= 970 && etheme_get_option('site_width') <= 3000 ): ?>

                    @media (min-width:1200px) {
                        .container {
                            width: <?php echo etheme_get_option('site_width'); ?>px;
                        }

                        .boxed .st-container {
                            width: calc(<?php echo etheme_get_option('site_width'); ?>px + 30px);
                        }
                    }

                <?php endif; ?>

                <?php if ( etheme_get_option('sale_icon') ) : ?>
                    .label-icon.sale-label {
                        width: <?php echo (etheme_get_option('sale_icon_width')) ? etheme_get_option('sale_icon_width') : 67 ?>px;
                        height: <?php echo (etheme_get_option('sale_icon_height')) ? etheme_get_option('sale_icon_height') : 67 ?>px;
                    }
                    .label-icon.sale-label { background-image: url(<?php echo (etheme_get_option('sale_icon_url')) ? etheme_get_option('sale_icon_url') : get_template_directory_uri() .'/images/label-sale.png' ?>); }
                <?php endif; ?>

                <?php if ( etheme_get_option('new_icon') ) : ?>
                    .label-icon.new-label {
                        width: <?php echo (etheme_get_option('new_icon_width')) ? etheme_get_option('new_icon_width') : 67 ?>px;
                        height: <?php echo (etheme_get_option('new_icon_height')) ? etheme_get_option('new_icon_height') : 67 ?>px;
                    }
                    .label-icon.new-label { background-image: url(<?php echo (etheme_get_option('new_icon_url')) ? etheme_get_option('new_icon_url') : get_template_directory_uri() .'/images/label-new.png' ?>); }

                <?php endif; ?>

                <?php
                    $bg = etheme_get_option('background_img');

                    $custom_bg = get_post_meta(get_the_ID(), 'page_background', true);

                    if( ! empty($custom_bg) ) {
                        $bg = $custom_bg;
                    }
                 ?>
                body {
                    <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo esc_attr( $bg['background-color'] ); ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-image'])): ?>  background-image: url(<?php echo esc_attr( $bg['background-image'] ); ?>) ; <?php endif; ?>
                    <?php if(!empty($bg['background-attachment'])): ?>  background-attachment: <?php echo esc_attr( $bg['background-attachment'] ); ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-repeat'])): ?>  background-repeat: <?php echo esc_attr( $bg['background-repeat'] ); ?>;<?php  endif; ?>
                    <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo esc_attr( $bg['background-color'] ); ?>;<?php  endif; ?>
                    <?php if(!empty($bg['background-position'])): ?>  background-position: <?php echo esc_attr( $bg['background-position'] ); ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-size'])): ?>  background-size: <?php echo esc_attr( $bg['background-size'] ); ?>;<?php endif; ?>
                }

                <?php

                    $selectors = et_get_color_selectors();
                    $mainfont_selectors = et_get_mainfont_selectors();

                    $activeColor = (etheme_get_option('activecol')) ? etheme_get_option('activecol') : et_get_active_color();
                    $priceColor = (etheme_get_option('pricecolor')) ? etheme_get_option('pricecolor') : et_get_active_color();

                    $rgb = hex2rgb($activeColor);

                    $darkenRgb = array();

                    $darkenRgb[0] = $rgb[0] - 30;
                    $darkenRgb[1] = $rgb[1] - 30;
                    $darkenRgb[2] = $rgb[2] - 30;

                    $darkenColor = 'rgb('.$darkenRgb[0].','.$darkenRgb[1].','.$darkenRgb[2].')';

                ?>

                <?php echo jsString($selectors['active_color']); ?>              { color: <?php echo esc_attr( $activeColor ); ?>; }

                <?php echo jsString($selectors['active_color_important']); ?>    { color: <?php echo esc_attr( $activeColor ); ?>!important; }

                <?php echo jsString($selectors['active_bg']); ?>                 { background-color: <?php echo esc_attr( $activeColor ); ?>; }

                <?php echo jsString($selectors['active_bg_important']); ?>       { background-color: <?php echo esc_attr( $activeColor ); ?>!important; }

                <?php echo jsString($selectors['active_border']); ?>             { border-color: <?php echo esc_attr( $activeColor ); ?>; }

                <?php echo jsString($selectors['pricecolor']); ?>              { color: <?php echo esc_attr( $priceColor ); ?>; }

                <?php echo jsString($selectors['darken_color']); ?>              { color: <?php echo esc_attr( $darkenColor ); ?>; }

                <?php echo jsString($selectors['darken_bg']); ?>                 { background-color: <?php echo esc_attr( $darkenColor ); ?>; }

                .woocommerce.widget_price_filter .ui-slider .ui-slider-range,
                .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range{
                  background: <?php echo 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.35)' ?>;
                }


                <?php et_load_typography_option( 'sfont', 'body' ); ?>

                <?php et_load_typography_option( 'mainfont', jsString($selectors['main_font']) ); ?>

                <?php et_load_font_family_option( 'mainfont', jsString($mainfont_selectors['font-family']) ); ?>

                <?php et_load_typography_option( 'pade_heading', '.page-heading .title' ); ?>
                <?php et_load_typography_option( 'breadcrumbs', '.page-heading .woocommerce-breadcrumb, .page-heading .woocommerce-breadcrumb a, .page-heading .breadcrumbs , .page-heading #breadcrumb , .page-heading #breadcrumb a, .page-heading .delimeter' ); ?>
                <?php et_load_typography_option( 'breadcrumbs_return', '.back-history, .page-heading .back-history' ); ?>

                <?php et_load_typography_option( 'menufont', '.header-wrapper .menu > li > a,.header-wrapper .header .menu-main-container .menu > li > a,.fixed-header .menu > li > a,.fixed-header-area.color-light .menu > li > a,.fixed-header-area.color-dark .menu > li > a ,.header-type-2.slider-overlap .header .menu > li > a, .header-type-3.slider-overlap .header .menu > li > a, .header-type-7 .menu-wrapper .menu > li > a, .header-type-10 .menu-wrapper .navbar-collapse .menu-main-container .menu > li > a, .header-vertical-enable .page-wrapper .header-type-vertical .container .menu > li > a, .header-vertical-enable .page-wrapper .header-type-vertical2 .container .menu > li > a,.fullscreen-menu .menu > li > a, .fullscreen-menu .menu > li > .inside > a' ); ?>

                <?php et_load_typography_option( 'menufont_3', '.menu li:not(.menu-full-width) .nav-sublist-dropdown ul > li > a,.menu .menu-full-width .nav-sublist-dropdown ul > li.menu-item-has-children .nav-sublist ul li a,.header-vertical-enable .page-wrapper .header-type-vertical .container .menu .nav-sublist-dropdown ul > li.menu-item-has-children .nav-sublist ul li a,.header-vertical-enable .page-wrapper .header-type-vertical2 .container .menu .nav-sublist-dropdown ul > li.menu-item-has-children .nav-sublist ul li a,.fullscreen-menu .menu li .nav-sublist-dropdown li a' ); ?>

                <?php et_load_typography_option( 'menufont_2', '.menu .menu-full-width .nav-sublist-dropdown > * > ul > li > a,.header-vertical-enable .page-wrapper .header-type-vertical .container .menu .menu-full-width .nav-sublist-dropdown > * > ul > li > a, .header-vertical-enable .page-wrapper .header-type-vertical2 .container .menu .menu-full-width .nav-sublist-dropdown > * > ul > li > a' ); ?>

                <?php et_load_typography_option( 'h1', 'h1, .product-information .product_title' ); ?>
                <?php et_load_typography_option( 'h2', 'h2, .post h2, .post h2 a' ); ?>
                <?php et_load_typography_option( 'h3', 'h3' ); ?>
                <?php et_load_typography_option( 'h4', 'h4' ); ?>
                <?php et_load_typography_option( 'h5', 'h5' ); ?>
                <?php et_load_typography_option( 'h6', 'h6' ); ?>


                <?php et_load_bg_option( etheme_get_option('breadcrumb_bg'), '.bc-type-1, .bc-type-2, .bc-type-3, .bc-type-4, .bc-type-5, .bc-type-6, .bc-type-7, .bc-type-8' , etheme_get_option( 'breadcrumb_padding' ) ); ?>
                <?php et_load_bg_option( etheme_get_option('footer_bg'), '.main-footer' , etheme_get_option( 'footer_padding' ) ); ?>

                <?php et_load_bg_option( array(), '.footer-top-2, .footer-top-1, .footer-top-3' , etheme_get_option( 'footer1_padding' ) ); ?>

                <?php et_load_bg_option( array(), '.copyright-1 .container .row-copyrights, .copyright-2 .container .row-copyrights, .copyright-3 .container .row-copyrights, .copyright .container .row-copyrights', etheme_get_option('copyrights_padding') ); ?>

                <?php et_load_bg_option( etheme_get_option('header_bg'), '.header-wrapper' ); ?>

                <?php et_load_bg_option( etheme_get_option('fixed_header_bg'), '.fixed-header, .fixed-header-area' ); ?>

                <?php et_load_bg_option( etheme_get_option('menu_bg'), 'header.header .menu-wrapper' ); ?>

                <?php et_load_bg_option( etheme_get_option('top_bar_bg'), 'div[class*="header-type-"] .top-bar,div[class*="header-type-"].slider-overlap .top-bar,div[class*="header-type-"].slider-overlap .top-bar > .container,div[class*="header-type-"] .top-bar > .container' ); ?>

                 <?php
                    $background_img = etheme_get_option('background_img');
                    $menu_states = ( is_array( etheme_get_option( 'menufont_link_color' ) ) ) ? etheme_get_option( 'menufont_link_color' ) : array( 'hover'=> '', 'active' => '' );
                    $menu_l2_states = ( is_array( etheme_get_option( 'menufont_2_link_color' ) ) ) ? etheme_get_option( 'menufont_2_link_color' ) : array( 'hover'=> '', 'active' => '' );
                    $menu_l3_states = ( is_array( etheme_get_option( 'menufont_3_link_color' ) ) ) ? etheme_get_option( 'menufont_3_link_color' ) : array( 'hover'=> '', 'active' => '' );
                    if ( is_woopress_migrated() ) {
                    	$fixed_menu_states   = etheme_get_option( 'fixed_menufont_link_color' );
                    	$fixed_menu_l2states = etheme_get_option( 'fixed_menufont_2' );
                    	$fixed_menu_l3states = etheme_get_option( 'fixed_menufont_3' );
                    } else {
                    	$fixed_menu_states = etheme_get_option( 'fixed_menufont_link_color_var' );
                    	$fixed_menu_states['regular'] = etheme_get_option( 'fixed_menufont_link_color' );
                    	$fixed_menu_l2states = etheme_get_option( 'fixed_menufont_2_var' );
                    	$fixed_menu_l2states['regular'] = etheme_get_option( 'fixed_menufont_2' );
                    	$fixed_menu_l2states = etheme_get_option( 'fixed_menufont_3_var' );
                    	$fixed_menu_l3states['regular'] = etheme_get_option( 'fixed_menufont_3' );
                    }

                  ?>

                 body.bordered .body-border-left,
                 body.bordered .body-border-top,
                 body.bordered .body-border-right,
                 body.bordered .body-border-bottom {
                    <?php if(!empty($background_img['background-color'])): ?>  background-color: <?php echo esc_html( $background_img['background-color'] ); ?>;<?php endif; ?>
                 }
                 <?php
                    $fixed_header_bg = etheme_get_option('fixed_header_bg');
                    $header_bg =  etheme_get_option('header_bg');
                 ?>
                 <?php if ( ! empty( $fixed_header_bg['background-color'] ) ) echo '.fixed-header-area{border-color:' . $fixed_header_bg['background-color'] . '}'; ?>

                 <?php if ( ! empty( $header_bg['background-color'] ) ): ?>
                     .header-type-6 .header .tbs span::before, .header-type-7 .header .tbs span::before, .header-type-8 .header .tbs span::before, .header-type-10 .header .tbs span::before, .header-type-12 .header .tbs span::before{
                         background-color: <?php echo esc_html( $header_bg['background-color'] ); ?>;
                     }
                 <?php endif; ?>

                 <?php if ( ! empty( $menu_states['hover'] ) ):
                  echo jsString($selectors['menu_font_hover']); ?> { color: <?php echo esc_attr( $menu_states['hover'] ); ?> !important; }
                 <?php endif; ?>
                <?php if ( ! empty( $menu_states['active'] ) ) :
                  echo jsString($selectors['menu_font_active']); ?> { color: <?php echo esc_attr( $menu_states['active'] ); ?> !important; }
                <?php endif; ?>
                  <?php if ( ! empty( $menu_l3_states['hover'] ) ) :
                      echo jsString($selectors['menu_font_l3_hover']); ?> { color: <?php echo esc_attr( $menu_l3_states['hover'] ); ?> !important; }
                  <?php endif; ?>
                 <?php if ( ! empty( $menu_l3_states['active'] ) ) :
                  echo jsString($selectors['menu_font_l3_active']); ?> { color: <?php echo esc_attr( $menu_l3_states['active'] ); ?> !important; }
                <?php endif; ?>
                 <?php if ( ! empty( $menu_l2_states['hover'] ) ) :
                  echo jsString($selectors['menu_font_l2_hover']); ?> { color: <?php echo esc_attr( $menu_l2_states['hover'] ); ?> !important; }
                <?php endif; ?>
                 <?php if ( ! empty( $menu_l2_states['active'] ) ):
                  echo jsString($selectors['menu_font_l2_active']); ?> { color: <?php echo esc_attr( $menu_l2_states['active'] ); ?> !important; }
                 <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_states['regular'] ) ) :
                  echo jsString($selectors['fixed_menu_font']); ?> { color: <?php echo esc_attr( $fixed_menu_states['regular'] ); ?> !important; }
                <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_states['hover'] ) ):
                  echo jsString($selectors['fixed_menu_font_hover']); ?> { color: <?php echo esc_attr( $fixed_menu_states['hover'] ); ?> !important; }
                <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_states['active'] ) ) :
                  echo jsString($selectors['fixed_menu_font_active']); ?> { color: <?php echo esc_attr( $fixed_menu_states['active'] ); ?> !important; }
                <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_l2states['regular'] ) ) :
                  echo jsString($selectors['fixed_menu_l2']); ?> { color: <?php echo esc_attr( $fixed_menu_l2states['regular'] ); ?> !important; }
                <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_l2states['hover'] ) ):
                  echo jsString($selectors['fixed_menu_l2_hover']); ?> { color: <?php echo esc_attr( $fixed_menu_l2states['hover'] ); ?> !important; }
                <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_l2states['active'] ) ):
                  echo jsString($selectors['fixed_menu_l2_active']); ?> { color: <?php echo esc_attr( $fixed_menu_l2states['active'] ); ?> !important; }
                <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_l3states['regular'] ) ):
                  echo jsString($selectors['fixed_menu_l3']); ?> { color: <?php echo esc_attr( $fixed_menu_l3states['regular'] ); ?> !important; }
                <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_l3states['hover'] ) ):
                  echo jsString($selectors['fixed_menu_l3_hover']); ?> { color: <?php echo esc_attr( $fixed_menu_l3states['hover'] ); ?> !important; }
                <?php endif; ?>
                <?php if ( ! empty( $fixed_menu_l3states['active'] ) ) :
                  echo jsString($selectors['fixed_menu_l3_active']); ?> { color: <?php echo esc_attr( $fixed_menu_l3states['active'] ); ?> !important; }
                <?php endif; ?>
                <?php
                  if( etheme_get_option( 'global_custom_css' ) != '') {
                      echo etheme_get_option( 'global_custom_css' );
                  }
                  if( etheme_get_option( 'custom_css_desktop' ) != '') {
                      echo '@media (min-width: 993px) { ' . etheme_get_option( 'custom_css_desktop' ) . ' }';
                  }
                  if( etheme_get_option( 'custom_css_tablet' ) != '' ) {
                      echo '@media (min-width: 768px) and (max-width: 992px) {' . etheme_get_option( 'custom_css_tablet' ) . ' }';
                  }
                  if( etheme_get_option( 'custom_css_wide_mobile' ) != '') {
                      echo '@media (min-width: 481px) and (max-width: 767px) { ' . etheme_get_option( 'custom_css_wide_mobile' ) . ' }';
                  }
                  if( etheme_get_option( 'custom_css_mobile' ) != '') {
                      echo '@media (max-width: 480px) { ' . etheme_get_option( 'custom_css_mobile' ) . ' }';
                  }
                ?>
            </style>
            <?php
                $first_category_item = etheme_get_option('first_category_item');
                $first_tab = etheme_get_option('first_tab');

                if ( is_woopress_migrated() ) {
                  if ( $first_category_item  ) {
                      $first_category_item = array(1);
                  } else {
                      $first_category_item = array(0);
                  }

                  if ( $first_tab  ) {
                      $first_tab = array(1);
                  } else {
                      $first_tab = array(0);
                  }
                }
            ?>
            <script type="text/javascript">
                var ajaxFilterEnabled   = <?php echo (etheme_get_option('ajax_filter')) ? 1 : 0; ?>;
                var successfullyAdded   = '<?php echo esc_js(__('successfully added to your shopping cart', 'woopress')); ?>';
                var errorAdded          = '<?php echo esc_js(__('sorry you can\'t add this product to your cart', 'woopress')); ?>';
                var view_mode_default   = '<?php echo esc_js(etheme_get_option('view_mode')); ?>';
                var first_category_item = '<?php echo esc_js($first_category_item[0]); ?>';
                var first_tab           = '<?php echo esc_js($first_tab[0]); ?>';
                var catsAccordion       = false;
                <?php if (etheme_get_option('cats_accordion')) {
                    ?>
                        catsAccordion = true;
                    <?php
                } ?>
                <?php if (class_exists('WooCommerce')) {
                    global $woocommerce;
                    ?>
                        var checkoutUrl = '<?php echo esc_url( wc_get_checkout_url() ); ?>';
                        var contBtn = '<?php echo esc_js(__('Continue shopping', 'woopress')); ?>';
                        var checkBtn = '<?php echo esc_js(__('Checkout', 'woopress')); ?>';
                    <?php
                } ?>
                <?php if(etheme_get_option('disable_right_click')): ?>
                    document.oncontextmenu = function() {return false;};
                <?php endif; ?>


            </script>
        <?php
    }
}