<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' );

$out = '';
$out .= sprintf(
	'<li><a href="%s" class="et-nav%s et-nav-menu">%s</a></li>',
	admin_url( 'admin.php?page=et-panel-welcome' ),
	( ! isset( $_GET['page'] ) || $_GET['page'] == 'et-panel-welcome' ) ? ' active' : '',
	esc_html__( 'Welcome', 'woopress' )

);

if ( ! etheme_is_activated() ) {
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-portfolio">%s</a></li>',
		admin_url( 'admin.php?page=et-panel-welcome' ),
		( $_GET['page'] == 'et-panel-demos' ) ? ' active' : '',
		esc_html__( 'Demos', 'woopress' )
	);
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-speed">%s</a></li>',
		admin_url( 'admin.php?page=et-panel-welcome' ),
		( $_GET['page'] == 'et-panel-plugins' ) ? ' active' : '',
		esc_html__( 'Plugins', 'woopress' )
	);
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-general">%s</a></li>',
		admin_url( 'themes.php?page=_options' ),
		( $_GET['page'] == 'et-panel-options' ) ? ' active' : '',
		esc_html__( 'Theme Options', 'woopress' )
	);
} elseif( ! class_exists( 'Redux' ) ) {
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-portfolio">%s</a></li>',
		admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
		( $_GET['page'] == 'et-panel-demos' ) ? ' active' : '',
		esc_html__( 'Demos', 'woopress' )
	);
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-speed">%s</a></li>',
		admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
		( $_GET['page'] == 'et-panel-plugins' ) ? ' active' : '',
		esc_html__( 'Plugins', 'woopress' )
	);
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-general">%s</a></li>',
		admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
		( $_GET['page'] == 'et-panel-options' ) ? ' active' : '',
		esc_html__( 'Theme Options', 'woopress' )
	);
} else {
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-portfolio">%s</a></li>',
		admin_url( 'admin.php?page=et-panel-demos' ),
		( $_GET['page'] == 'et-panel-demos' ) ? ' active' : '',
		esc_html__( 'Demos', 'woopress' )
	);
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-speed">%s</a></li>',
		admin_url( 'themes.php?page=install-required-plugins&plugin_status=all' ),
		( $_GET['page'] == 'et-panel-plugins' ) ? ' active' : '',
		esc_html__( 'Plugins', 'woopress' )
	);
	$out .= sprintf(
		'<li><a href="%s" class="et-nav%s et-nav-general">%s</a></li>',
		admin_url( 'themes.php?page=_options' ),
		( $_GET['page'] == 'et-panel-options' ) ? ' active' : '',
		esc_html__( 'Theme Options', 'woopress' )
	);
}

$out .= sprintf(
	'<li><a href="%s" class="et-nav%s et-nav-social">%s</a></li>',
	admin_url( 'admin.php?page=et-panel-social' ),
	( $_GET['page'] == 'et-panel-social' ) ? ' active' : '',
	esc_html__( 'Instagram', 'woopress' )

);

$out .= sprintf(
	'<li><a href="%s" class="et-nav%s et-nav-support">%s</a></li>',
	admin_url( 'admin.php?page=et-panel-support' ),
	( $_GET['page'] == 'et-panel-support' ) ? ' active' : '',
	esc_html__( 'Tutorials & Support', 'woopress' )

);

echo '<div class="etheme-page-nav"><ul>' . $out . '</ul></div>';