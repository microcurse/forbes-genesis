<?php
	$ht = $class = '';
	$ht = apply_filters('custom_header_filter',$ht);
	$page_id = et_get_page_id();
	$hstrucutre = etheme_get_header_structure($ht);
	$page_slider = etheme_get_custom_field('page_slider', $page_id);

	if(etheme_get_option('header_transparent')) {
		$class .= ' header-transparent';
	}
	if ( etheme_get_option( 'header_overlap' ) && etheme_get_custom_field( 'current_header_overlap' ) != 'off' || etheme_get_custom_field( 'current_header_overlap' ) == 'on' ) {
		$class .= ' header-overlap';
	}
?>

<div class="header-wrapper header-type-<?php echo esc_attr( $ht.' '.$class ); ?> color-<?php echo etheme_get_option('header_colors'); ?>">
	<?php if(etheme_get_option('header_type') == 'vertical' || etheme_get_option('header_type') == 'vertical2'): ?>
		<div class="header-content nano-content">
	<?php endif; ?>

		<?php get_template_part('headers/parts/top-bar', $hstrucutre); ?>

		<header class="header main-header">
			<div class="header-top">
				<div class="container">
					<div class="header-custom-block">
						<?php echo etheme_get_option('header_custom_block'); ?>
					</div>
					<div class="navbar-right">
			            <?php if( is_woopress_migrated() && etheme_get_option('search_form_sw') || etheme_get_option('search_form_sw') == 'on'): ?>
							<?php etheme_search_form(); ?>
						<?php endif; ?>
			            <?php if(class_exists('Woocommerce') && !etheme_get_option('just_catalog') && ( is_woopress_migrated() && etheme_get_option('cart_widget_sw') || etheme_get_option('cart_widget_sw') == 'on')): ?>
		                    <?php echo do_shortcode( '[et_top_cart]' ); ?>
			            <?php endif ;?>
					</div>
				</div>
			</div>
			<div class="container">
					<div class="navbar" role="navigation">
						<div class="container-fluid">
							<div id="st-trigger-effects" class="column">
								<button data-effect="mobile-menu-block" class="menu-icon"></button>
							</div>

							<div class="tbs navmenu-left">
								<div class="collapse navbar-collapse">
									<?php et_get_main_menu(); ?>
								</div><!-- /.navbar-collapse -->
							</div>
							<div class="header-logo">
								<?php etheme_logo(); ?>
							</div>
							<div class="tbs navmenu-right">
								<div class="collapse navbar-collapse">
									<?php et_get_main_menu('main-menu-right'); ?>
								</div><!-- /.navbar-collapse -->
							</div>

						</div><!-- /.container-fluid -->
					</div>
			</div>
		</header>
	<?php if(etheme_get_option('header_type') == 'vertical' || etheme_get_option('header_type') == 'vertical2'): ?>
		</div>
	<?php endif; ?>
</div>
