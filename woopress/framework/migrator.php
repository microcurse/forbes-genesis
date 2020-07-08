<?php
/**
 * Etheme Option Tree to Redux migrator.
 *
 * Migrate royal/woopress theme options from Option Tree to Redux
 *
 * @since   6.0.0
 * @version 1.0.0
 */
class Etheme_Royal_Option_Migrator {

    // ! Declare default variables
    private $options_ot = array();
    private $options    = array();
    private $options_keys = array(
        'range'             => array( 'site_width' ),
        'textarea'          => array( 'right_click_html', 'google_code' ),
        'colorpicker'       => array( 'activecol', 'fixed_menufont_link_color', 'prefooter_bg', 'pp_button_bg', 'footer_bg', 'copyright_bg' ),
        'background'        => array( 'top_bar_bg', 'breadcrumb_bg', 'pp_bg', 'background_img', 'header_bg', 'fixed_header_bg', 'menu_bg' ),
        'typography_gogle' => array(
            'mainfont'           => 'mainfont-google',
            'sfont'              => 'sfont-google',
            'menufont'           => 'menufont-google',
            'menufont_2'         => 'menufont_2-google',
            'menufont_3'         => 'menufont_3-google',
            'pade_heading'       => 'pade_heading-google',
            'breadcrumbs'        => 'breadcrumbs-google',
            'breadcrumbs_return' => 'breadcrumbs_return-google'
        ),
        'typography' => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ),
        'link_color' => array( 'menufont_link_color', 'menufont_2_link_color', 'menufont_3_link_color' ),
        'link_color_2_in_1' => array(
            'fixed_menufont_2' => 'fixed_menufont_2_var',
            'fixed_menufont_3' => 'fixed_menufont_3_var',
            'fixed_menufont_link_color' => 'fixed_menufont_link_color_var'
        ),
        'custom_header' => array('custom_header'),
        'upload' => array( 'logo', 'logo_fixed', 'favicon' ),
        'switch' => array( 'loader', 'to_top', 'force_addons_css', 'to_top_mobile', 'disable_right_click', 'disable_og_tags', 'force_addons_css', 'header_overlap', 'favicon_badge', 'top_links', 'footer_demo', 'shop_full_width', 'just_catalog', 'cats_accordion', 'new_icon', 'out_of_icon', 'sale_icon', 'first_category_item', 'sidebar_hidden', 'product_page_productname', 'product_page_cats', 'product_page_price', 'product_page_addtocart', 'shop_sidebar_responsive_display', 'images_sliders', 'show_product_title', 'show_related', 'ajax_addtocart', 'gallery_lightbox', 'first_tab', 'single_sidebar_responsive_display', 'share_icons', 'quick_view', 'quick_product_name', 'quick_price', 'quick_rating', 'quick_descr', 'quick_add_to_cart', 'quick_share', 'product_link', 'promo_popup', 'promo_auto_open', 'promo_link', 'fixed_ppopup', 'blog_full_width', 'blog_byline', 'posts_links', 'post_share', 'about_author', 'post_related', 'post_tags', 'project_name', 'project_byline', 'project_excerpt', 'recent_projects', 'portfolio_comments', 'portfolio_lightbox', 'portfolio_image_cropping', 'responsive', 'transparent_container', 'header_transparent' ),
        'on_of'  => array( 'fixed_nav_sw', 'search_form_sw', 'top_bar_sw', 'cart_widget_sw' ),
        'select' => array( 'default_fonts', 'header_colors', 'fixed_header_colors', 'search_view', 'search_post_type', 'top_bar_colors', 'breadcrumb_type', 'footer_text_color', 'product_banner_position', 'view_mode', 'product_img_hover', 'shop_sidebar_responsive', 'category_archive_desc_position', 'carousel_direction', 'tabs_location', 'upsell_location', 'zoom_effect', 'tabs_type', 'reviews_position', 'quick_images', 'blog_layout', 'blog_columns', 'blog_sidebar_responsive', 'portfolio_columns', 'portfolio_content_side' ),
        'text' => array( 'top_cart_item', 'top_cart_icon', 'top_cart_icon_size', 'products_per_page', 'carousel_items', 'related_posts_per_page', 'custom_tab_title', 'pp_title', 'pp_width', 'pp_height', 'excerpt_length', 'portfolio_count', 'portfolio_image_width', 'portfolio_image_height', 'contacts_email', 'google_captcha_site', 'google_captcha_secret' ),
        'edithor' => array( 'header_custom_block', 'product_bage_banner', 'empty_cart_content', 'custom_tab', 'pp_content', 'privacy_contact', 'privacy_registration' ),
        'et_padding' => array( 'breadcrumb_padding', 'footer1_padding', 'footer_padding', 'copyrights_padding' ),
        'image_select' => array( 'main_layout', 'grid_sidebar', 'single_sidebar', 'single_product_layout', 'blog_sidebar', 'forum_sidebar', 'header_type', 'footer_type' ),
        'custom_css' => array( 'global_custom_css', 'custom_css_desktop', 'custom_css_tablet', 'custom_css_wide_mobile', 'custom_css_mobile'
        ),
        'portfolio_page' => array('portfolio_page'),
    );

    // ! Main construct/ setup variables
    function __construct(){
        add_action( 'admin_notices', array( $this, 'royal_option_migration' ), 50 );
        $this->options_ot = get_option( 'option_tree' );
        $this->options    = get_option( 'woopress_redux_options' );
        $this->migrate();
    }

    /**
     * Add admin notice
     *
     * @since   6.0.0
     * @version 1.0.0
     */
    public function royal_option_migration(){
        echo '<div class="et-message updated notice" style="border-left: 4px solid rgba(0,162,227,1)!important;"><p><b>' . esc_html__( 'WooPress theme options update.', 'woopress' ) . '</b></p><p>' . esc_html__( 'WooPress theme options is updating in the background. The database update process may take a little while, so please be patient.', 'woopress' ) . '</p></div>';
    }

    /**
     * Migrate procces
     *
     * @since   6.0.0
     * @version 1.0.0
     */
    private function migrate(){
        foreach ($this->options_keys as $type => $options) {
            switch ($type) {
                case 'background':
                    foreach ($options as $value) {
                        if ( is_array( $this->options_ot[$value] ) ) {
                            $this->options[$value] = isset( $this->options_ot[$value] ) ? $this->options_ot[$value] : $this->options[$value];
                        }
                    }
                    break;
                case 'typography_gogle':
                    foreach ($options as $key => $value) {
                        if ( isset( $this->options_ot[$key] ) && is_array( $this->options_ot[$key] ) && count( $this->options_ot[$key] ) > 1) {
                            $this->options[$key]['color']          = $this->options_ot[$key]['font-color'];
                            $this->options[$key]['font-family']    = $this->fonts_conformity( $this->options_ot[$key]['font-family'] );
                            $this->options[$key]['font-size']      = $this->options_ot[$key]['font-size'];
                            $this->options[$key]['font-style']     = $this->options_ot[$key]['font-style'];
                            $this->options[$key]['font-weight']    = $this->options_ot[$key]['font-weight'];
                            $this->options[$key]['letter-spacing'] = preg_replace('/[^-.0-9]/', '', $this->options_ot[$key]['letter-spacing']);
                            $this->options[$key]['line-height']    = $this->options_ot[$key]['line-height'];
                            $this->options[$key]['text-transform'] = $this->options_ot[$key]['text-transform'];
                            if ( isset( $this->options_ot[$value][0] ) && is_array( $this->options_ot[$value][0] ) && count( $this->options_ot[$value][0] ) > 1 ) {
                                $this->options[$key]['font-family'] = $this->fonts_conformity( $this->options_ot[$value][0]['family'] );
                                $this->options[$key]['subsets']     = $this->options_ot[$value][0]['subsets'][0];
                                $this->options[$key]['font-weight'] = $this->options_ot[$value][0]['variants'][0];
                            }
                        }
                    }
                    break;

                    case 'typography':
                        foreach ($options as $key => $value) {
                            if ( is_array( $this->options_ot[$value] ) && count( $this->options_ot[$value] ) > 1) {
                                $this->options[$value]['color']          = $this->options_ot[$value]['font-color'];
                                $this->options[$value]['font-family']    = $this->fonts_conformity( $this->options_ot[$value]['font-family'] );
                                $this->options[$value]['font-size']      = $this->options_ot[$value]['font-size'];
                                $this->options[$value]['font-style']     = $this->options_ot[$value]['font-style'];
                                $this->options[$value]['font-weight']    = $this->options_ot[$value]['font-weight'];
                                $this->options[$value]['letter-spacing'] = preg_replace('/[^-.0-9]/', '', $this->options_ot[$value]['letter-spacing']);
                                $this->options[$value]['line-height']    = $this->options_ot[$value]['line-height'];
                                $this->options[$value]['text-transform'] = $this->options_ot[$value]['text-transform'];
                            }
                        }
                     break;

                    case 'link_color_2_in_1':
                        foreach ($options as $key => $value) {
                            $this->options[$key] = array(
                                'regular' => '',
                                'hover'   => '',
                                'active'  => ''
                            );
                            $this->options[$key]['regular'] = isset( $this->options_ot[$key] ) ? $this->options_ot[$key] : '';
                            $this->options[$key]['hover']   = isset( $this->options_ot[$value]['hover'] ) ? $this->options_ot[$value]['hover'] : '';
                            $this->options[$key]['active']  = isset( $this->options_ot[$value]['active'] ) ? $this->options_ot[$value]['active'] : '';
                        }
                        break;

                    case 'switch':
                        foreach ($options as $value) {
                            $this->options[$value] = isset( $this->options_ot[$value] ) ? true : '';
                        }
                        break;

                    case 'on_of':
                        foreach ($options as $value) {
                            $this->options[$value] = ( isset( $this->options_ot[$value] ) && $this->options_ot[$value] == 'on' ) ? true : '';
                        }
                        break;

                    case 'et_padding':
                        foreach ($options as $value) {
                            $in    = array( 'px', 'em', 'rem', 'vw', 'vh', 'vmin', 'vmax', '%' );
                            $units = false;
                            if ( isset( $this->options_ot[$value] ) && is_array( $this->options_ot[$value] ) ) {
                                foreach ($this->options_ot[$value] as $k => $v) {
                                    $units = et_check_units( $in, $v, true );

                                    if ( ! $units || ! in_array( $units, array('px', 'em', '%') ) ) {
                                        $units = 'px';
                                    }

                                    $this->options_ot[$value][$k] = preg_replace('/[^0-9]/', '', $v);
                                }
                                $this->options[$value] = $this->options_ot[$value];
                                $this->options[$value]['units'] = $units;
                            }
                        }
                        break;

                    case 'image_select':
                        foreach ($options as $value) {
                            if ( isset( $this->options_ot[$value] ) ) {
                                $this->options[$value] = $this->options_ot[$value];
                            }
                        } 
                        break;

                    case 'upload':
                        foreach ($options as $value) {
                            $this->options[$value]['url'] = $this->options_ot[$value];
                        } 
                        break;

                default:
                    foreach ($options as $value) {
                        $this->options[$value] = isset( $this->options_ot[$value] ) ? $this->options_ot[$value] : $this->options[$value];
                    }
                    break;
            }
        }

        update_option( 'woopress_redux_options', $this->options );
        update_option( 'woopess_option_migrated', true );

        if ( isset( $_GET['woopess_migrate_options'] ) ) {
            wp_safe_redirect( admin_url('?page=_options') );
        }
    }

    public function fonts_conformity($font){
        switch ($font) {
            case 'times':
                return "'Times New Roman', Times,serif";
            break;
            case 'arial':
                return 'Arial, Helvetica, sans-serif';
                break;
            case 'georgia':
                return 'Georgia, serif';
            break;
            case 'verdana':
                return 'Verdana, Geneva, sans-serif';
                break;
            default:
                return $font;
                break;
        }
    }
}