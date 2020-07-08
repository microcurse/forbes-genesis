<?php
    /**
     * NOTES:
     * This file no longer uses the theme 
	 * options found in WooPress admin
     * 
     */

?>

<div class="upper-bar">
	<div class="container">
		<address class="container-flex">
			<a class="container-flex" href="tel:+18008325427"><?php echo fi_load_inline_svg( 'phone-circle-icon.svg' ); ?> (800)832-5427</a>
			<a class="container-flex" href="mailto:solutions@forbesindustries.com"><?php echo fi_load_inline_svg( 'mail-circle-icon.svg' ); ?> solutions@forbesindustries.com</a>
		</address>
	</div>
</div>
<div class="header-wrapper">
	<header class="header main-header">
		<div class="container">
			<div class="container-flex">
				
				<div class="header-logo">
					<?php etheme_logo(); ?>
				</div>

				<div id="st-trigger-effects" class="column">
					<button data-effect="mobile-menu-block">
						<?php echo fi_load_inline_svg( 'fi-menu-icon.svg' ); ?>
					</button>
				</div>

				<div class="search-wrapper">
					<div class="search-box">
						<i class="fa fa-search"></i>
						<?php get_product_search_form(); ?>
					</div> 
				</div><!-- /.search-wrapper -->
				
			</div><!-- /.container-grid -->
		</div> <!-- /.container -->
		<nav class="menu-wrapper">
			<div class="container">
				<div class="collapse navbar-collapse">
					<?php et_get_main_menu(); ?>
				</div>

			</div><!-- /.navbar-collapse -->
		</nav>
	</header>
</div>
