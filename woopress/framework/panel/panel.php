<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' );

new EthemeAdmin;

class EthemeAdmin{

	function __construct(){
		add_action( 'admin_menu', array( $this, 'et_add_menu_page' ) );
	}

	public function et_add_menu_page(){
        add_menu_page( 
            esc_html__( 'WooPress', 'woopress' ), 
            esc_html__( 'WooPress', 'woopress' ), 
            'manage_options', 
            'et-panel-welcome',
            array( $this, 'etheme_panel_page' ),
            ETHEME_CODE_IMAGES_URL . '/etheme.png',
            59
        );
        add_submenu_page(
            'et-panel-welcome',
            esc_html__( 'Dashboard', 'woopress' ),
            esc_html__( 'Dashboard', 'woopress' ),
            'manage_options',
            'et-panel-welcome',
            array( $this, 'etheme_panel_page' )
        );

		if ( ! etheme_is_activated() && ! class_exists( 'Redux' ) ) {
            add_submenu_page(
                'et-panel-welcome',
                esc_html__( 'Setup Wizard', 'woopress' ),
                esc_html__( 'Setup Wizard', 'woopress' ),
                'manage_options',
                admin_url( 'themes.php?page=woopress-setup' ),
                ''
            );
		} elseif( ! etheme_is_activated() ){

		} elseif( ! class_exists( 'Redux' ) ){
            add_submenu_page(
                'et-panel-welcome',
                esc_html__( 'Install Plugins', 'woopress' ),
                esc_html__( 'Install Plugins', 'woopress' ),
                'manage_options',
                admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
                ''
            );
		} else {
            add_submenu_page(
                'et-panel-welcome',
                esc_html__( 'Import Demos', 'woopress' ),
                esc_html__( 'Import Demos', 'woopress' ),
                'manage_options',
                'et-panel-demos',
                array( $this, 'etheme_panel_page' )
            );
            add_submenu_page(
                'et-panel-welcome',
                esc_html__( 'Install Plugins', 'woopress' ),
                esc_html__( 'Install Plugins', 'woopress' ),
                'manage_options',
                admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
                ''
            );
		}

        add_submenu_page(
            'et-panel-welcome',
            'Theme Options',
            'Theme Options',
            'manage_options',
            admin_url( 'themes.php?page=_options' ),
            ''
        );

        add_submenu_page(
            'et-panel-welcome',
            esc_html__( 'Instagram', 'woopress' ),
            esc_html__( 'Instagram', 'woopress' ),
            'manage_options',
            'et-panel-social',
            array( $this, 'etheme_panel_page' )
        );

        add_submenu_page(
            'et-panel-welcome',
            esc_html__( 'Tutorials & Support', 'woopress' ),
            esc_html__( 'Tutorials & Support', 'woopress' ),
            'manage_options',
            'et-panel-support',
            array( $this, 'etheme_panel_page' )
        );
    }

	public function etheme_panel_page(){

        $out = get_template_part( 'framework/panel/templates/header' );

		$out .= get_template_part( 'framework/panel/templates/navigation' );

		$out .= '<div class="et-row etheme-page-content">';

			if( $_GET['page'] == 'et-panel-welcome' ){
				$out .= get_template_part( 'framework/panel/templates/page', 'welcome' );
			} elseif( $_GET['page'] == 'et-panel-support' ){
				$out .= get_template_part( 'framework/panel/templates/page', 'support' );
			} elseif ( $_GET['page'] == 'et-panel-demos' ){
				$out .= get_template_part( 'framework/panel/templates/page', 'demos' );
			} elseif( $_GET['page']  == 'et-panel-social' ){
                get_template_part( 'framework/panel/templates/page', 'instagram' );
            } elseif( $_GET['page']  == 'et-panel-options' ){
                // show nothing jast redirect
            } elseif( $_GET['page'] == 'et-panel-plugins' ){
                // show nothing jast redirect
			} else {
				$out .= get_template_part( 'framework/panel/templates/page', 'welcome' );
			}

		$out .= '</div>';

		$out .= get_template_part( 'framework/panel/templates/footer' );

		echo wp_specialchars_decode($out);
	}	
}