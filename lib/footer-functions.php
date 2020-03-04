<?php  
/*
 *   Custom footer functions
*/

// Remove site footer.
// remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
// remove_action( 'genesis_footer', 'genesis_do_footer' );
// remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// add in new footer markup - prefix function name fi_
// add_action( 'genesis_before_footer', 'fi_flexible_widgets_markup_open' );
// add_action( 'genesis_before_footer', 'fi_flexible_widgets_markup_close' );

// Open footer markup
function fi_footer_widgets_markup_open() {
	
    genesis_markup(
		[
			'open'    => '<div %s>' . genesis_sidebar_title( 'Footer' ),
			'context' => 'footer-widgets',
		]
	);
	
}

// Close footer markup
function fi_footer_widgets_markup_close() {
	
    genesis_markup(
		[
			'close'    => '</div>',
			'context' => 'footer-widgets',
		]
	);
	
}


add_action( 'genesis_before_footer', 'fi_footer_widget_areas' );
function fi_footer_widget_areas() {

	$footer_widgets = get_theme_support( 'genesis-footer-widgets' );

	if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) || genesis_footer_widgets_hidden_on_current_page() ) {
		return;
	}

	$footer_widgets = (int) $footer_widgets[0];

	// Check to see if first widget area has widgets. If not, do nothing. No need to check all footer widget areas.
	if ( ! is_active_sidebar( 'footer-1' ) ) {
		return;
	}

	$inside  = '';
	$output  = '';
	$counter = 1;

	while ( $counter <= $footer_widgets ) {

		// Darn you, WordPress! Gotta output buffer.
		ob_start();
		dynamic_sidebar( 'footer-' . $counter );
		$widgets = ob_get_clean();

		if ( $widgets ) {

			$inside .= genesis_markup(
				[
					'open'    => '<div %s>',
					'close'   => '</div>',
					'context' => 'footer-widget-area',
					'content' => $widgets,
					'echo'    => false,
					'params'  => [
						'column' => $counter,
						'count'  => $footer_widgets,
					],
				]
			);

		}

		$counter++;

	}

	// this wraps the footer-widgets
	if ( $inside ) {

		// $_inside = genesis_get_structural_wrap( 'footer-widgets', 'open' );

		$_inside .= $inside;

		// $_inside .= genesis_get_structural_wrap( 'footer-widgets', 'close' );

		$output .= genesis_markup(
			[
				'open'    => '<div %s>',
				'close'   => '</div>',
				'content' => $_inside,
				'context' => 'flex-widgets',
				'echo'    => false,
			]
		);

	}

	// Output buffer for footer left
	ob_start();
	dynamic_sidebar( 'footer-left' );
	
	// set footer left
	$left_widget = ob_get_clean();

	$left_output = genesis_markup(
		[
			'open'		=>	'<div %s>',
			'close'		=>	'</div>',
			'context'	=>	'footer-left',
			'content'	=>	$left_widget,
			'echo'		=> false,
		]
	);
	
	$footer_left = apply_filters( 'fi_footer_widget_areas', $left_output, $footer_left );

	$footer_widgets = apply_filters( 'fi_footer_widget_areas', $output, $footer_widgets );

	// open flexible widgets div
	fi_footer_widgets_markup_open();

	echo $footer_left;
	echo $footer_widgets; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attempting to escape here will strip tags or attributes output by widgets.

	// close flexible widgets div
	fi_footer_widgets_markup_close();

}