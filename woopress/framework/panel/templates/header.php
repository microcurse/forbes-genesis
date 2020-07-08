<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' );

$theme   = wp_get_theme();
$version = $theme->get('Version');
$out     = '';

if ( etheme_is_activated() ) {
		$activated = '<span class="activate-note activated">' . esc_html__('Activated', 'woopress') . '</span>';
	} else {
		$activated = '<span class="activate-note">' . esc_html__('Not activated', 'woopress') . '</span>';
	}

	if ( is_child_theme() ) {
  $parent = wp_get_theme( 'woopress' );
  $parent = $parent->version;
  $out .= '<span class="theme-version">' . $parent . ' (child  ' . $version . ')</span>';
	} else {
	  $out .= '<span class="theme-version">' . $version . '</span>';
	}

echo '
<div class="etheme-page-wrapper">
	<div class="etheme-page-header">
		<div class="fright text-center">
			<span class="theme-logo"><img src="' . PARENT_URL. '/images/admin-logo.png" alt="logo"></span>
			'. $out .'
			' . $activated . '
		</div>
		<h2 class="etheme-page-title">Welcome to WooPress!</h2>
		<p>Thank you for choosing WooPress. We hope you’ll like it!<br/> To enjoy the full experience we strongly recommend to activate a theme with your purchase code.</p>
	</div>
';