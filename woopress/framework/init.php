<?php 
define('PARENT_DIR', get_template_directory());
define('ETHEME_CODE_DIR', trailingslashit(PARENT_DIR).'framework');

define('PARENT_URL', get_template_directory_uri());
define('ETHEME_CODE_URL', trailingslashit(PARENT_URL).'framework');
define('ETHEME_CODE_IMAGES_URL', trailingslashit(ETHEME_CODE_URL).'css/images');
define('ETHEME_THEME_ASSETS', trailingslashit(PARENT_URL).'theme-assets');
define('ETHEME_CODE_JS_URL', trailingslashit(ETHEME_CODE_URL).'js');
define('ETHEME_CODE_CSS_URL', trailingslashit(ETHEME_CODE_URL).'css');
define('CHILD_URL', get_stylesheet_directory_uri());
define('ETHEME_API', 'https://www.8theme.com/themes/api/');
define('ET_CODE_3D_URI', ETHEME_CODE_URL .'/inc/');
define('ETHEME_BASE_URI', PARENT_URL .'/');

require_once( trailingslashit(ETHEME_CODE_DIR). 'theme.php' );


add_action('after_setup_theme', 'etheme_theme_setup');
function etheme_theme_setup(){
	load_theme_textdomain( 'woopress', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
}

    
require_once( trailingslashit(ETHEME_CODE_DIR). 'options.php' );
require_once( trailingslashit(ETHEME_CODE_DIR). 'inc/taxonomy-metadata.php' );
require_once( trailingslashit(ETHEME_CODE_DIR). 'theme-functions.php' );
require_once( trailingslashit(ETHEME_CODE_DIR). 'images.php' );
require_once( trailingslashit(ETHEME_CODE_DIR). 'walkers.php' );
if(class_exists('WooCommerce'))
	require_once( trailingslashit(ETHEME_CODE_DIR). 'woo.php' );
	
require_once( trailingslashit(ETHEME_CODE_DIR). 'vc.php' );
require_once( trailingslashit(ETHEME_CODE_DIR). 'theme-options.php');
require_once( trailingslashit(ETHEME_CODE_DIR). 'custom-metaboxes.php');
require_once( trailingslashit(ETHEME_CODE_DIR) . 'options-framework/loader.php' );
require_once( trailingslashit(ETHEME_CODE_DIR). 'inc/envato_setup/envato_setup.php' );
require_once( trailingslashit(ETHEME_CODE_DIR). 'custom-styles.php' );

if ( is_admin() ) {
	require_once( trailingslashit(ETHEME_CODE_DIR) . 'inc/menu-images/nav-menu-images.php');
    require_once( trailingslashit(ETHEME_CODE_DIR) . 'plugins.php' );
	require_once( trailingslashit(ETHEME_CODE_DIR). 'version-check.php');

	require_once( trailingslashit( ETHEME_CODE_DIR) . 'system-requirements.php' );
	require_once( trailingslashit(ETHEME_CODE_DIR). 'panel/panel.php');

	if ( get_option( 'option_tree' ) && ! get_option( 'woopess_option_migrated', false ) || isset( $_GET['woopess_migrate_options'] ) ) {
		require_once( trailingslashit(ETHEME_CODE_DIR). 'migrator.php' );
		new Etheme_Royal_Option_Migrator();
	}
}