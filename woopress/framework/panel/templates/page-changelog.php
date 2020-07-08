<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' );

$out = '';
$out .= '<h3 class="et-title">' . esc_html__( 'Changelog', 'woopress' ) . '</h3>';
$out .= '<p class="et-message et-error">' . esc_html__( 'woopress changelog data', 'woopress' ) . '</p>';

echo '<div class="etheme-div etheme-changelog et-col-12">' . $out . '</div>';
