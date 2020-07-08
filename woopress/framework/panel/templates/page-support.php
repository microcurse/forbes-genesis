<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' );
echo '
	<div class="et-col-7 etheme-support">
		<h3>' . esc_html__( 'Help and support', 'woopress' ) . '</h3>
		<p>' . esc_html__( 'If you encounter any difficulties with our product we are ready to assist you via:', 'woopress' ) . '</p>
		<ul class="support-blocks">
			<li>
				<a href="https://t.me/etheme" target="_blank">
					<img src="' . ETHEME_CODE_IMAGES_URL . '/telegram.png">
					<span>' . esc_html__( 'Telegram channel', 'woopress' ) . '</span>
				</a>
			</li>
			<li>
				<a href="https://www.8theme.com/forums/" target="_blank">
					<img src="' . ETHEME_CODE_IMAGES_URL . '/support-icon.png">
					<span>' . esc_html__( 'Support Forum', 'woopress' ) . '</span>
				</a>
			</li>
			<li>
				<a href="http://prntscr.com/d24xhu" target="_blank">
					<img src="' . ETHEME_CODE_IMAGES_URL . '/icon-envato.png">
					<span>' . esc_html__( 'ThemeForest profile', 'woopress' ) . '</span>
				</a>
			</li>
		</ul>
		<div class="support-includes">
			<div class="includes">
				<p>' . esc_html__( 'Item Support includes:', 'woopress' ) . '</p>
				<ul>
					<li>' . esc_html__( 'Answering technical questions', 'woopress' ) . '</li>
					<li>' . esc_html__( 'Assistance with reported bugs and issues', 'woopress' ) . '</li>
					<li>' . esc_html__( 'Help with bundled 3rd party plugins', 'woopress' ) . '</li>
				</ul>
			</div>
			<div class="excludes">
				<p>' . __( 'Item Support <span class="red-color">DOES NOT</span> Include:', 'woopress' ) . '</p>
				<ul>
					<li>' . esc_html__( 'Customization services', 'woopress' ) . '</li>
					<li>' . esc_html__( 'Installation services', 'woopress' ) . '</li>
					<li>' . esc_html__( 'Support for non-bundled 3rd party plugins.', 'woopress' ) . '</li>
				</ul>
			</div>
		</div>
	</div>
';

// echo '
// 	<div class="et-col-5 etheme-documentation et-sidebar">
// 		<h3>' . esc_html__( 'Documentation', 'woopress' ) . '</h3>
// 		<h4>' . esc_html__( 'Theme Installation', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/4-theme-package" target="_blank">' . esc_html__( 'woopress Theme Package', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/12-theme-installation" target="_blank">' . esc_html__( 'Theme Installation', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/32-child-theme" target="_blank">' . esc_html__( 'Child Theme', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/34-demo-content" target="_blank">' . esc_html__( 'Demo Content', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/45-8theme-page-post-layout-settings-8theme-post-options" target="_blank">' . esc_html__( '8theme Page/Post/Product Layout settings', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/42-portfolio-page" target="_blank">' . esc_html__( 'Portfolio Page', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/43-blank-page" target="_blank">' . esc_html__( 'Blank Page', 'woopress' ) . '</a></li>
// 		</ul>
// 		<h4>' . esc_html__( 'Theme Update', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/63-theme-update" target="_blank">' . esc_html__( 'Theme Update', 'woopress' ) . '</a></li>
// 		</ul>
// 		<h4>' . esc_html__( 'Menu Set Up', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/86-general-information" target="_blank">' . esc_html__( 'General Information', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/27-mega-menu" target="_blank">' . esc_html__( 'Mega Menu', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/88-one-page-menu" target="_blank">' . esc_html__( 'One Page menu', 'woopress' ) . '</a></li>
// 		</ul>
// 		<h4>' . esc_html__( 'Theme Translation', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/30-base-theme-translation" target="_blank">' . esc_html__( 'Base theme translation', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/31-translation-with-wpml" target="_blank">' . esc_html__( 'Translation with WPML', 'woopress' ) . '</a></li>
// 		</ul>
// 		<h4>' . esc_html__( 'Widgets/Static Blocks', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/48-widgets-custom-widget-areas" target="_blank">' . esc_html__( 'Widgets & Custom Widget Areas', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/47-static-blocks" target="_blank">' . esc_html__( 'Static Blocks', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/46-woopress-shortcodes" target="_blank">' . esc_html__( 'woopress Shortcodes', 'woopress' ) . '</a></li>
// 		</ul>
// 		<h4>' . esc_html__( 'WooCommerce', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/29-general-information" target="_blank">' . esc_html__( 'General Information', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/67-shop-page" target="_blank">' . esc_html__( 'Shop page', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/68-single-product-page" target="_blank">' . esc_html__( 'Single Product page', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/89-product-images" target="_blank">' . esc_html__( 'Product Images', 'woopress' ) . '</a></li>
// 		</ul>
// 		<h4>' . esc_html__( 'Plugins', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/35-general-info" target="_blank">' . esc_html__( 'General Info', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/36-included-plugins" target="_blank">' . esc_html__( 'Included plugins', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/37-plugins-update" target="_blank">' . esc_html__( 'Plugins Update', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/38-activation-and-purchase-codes" target="_blank">' . esc_html__( 'Activation and Purchase Codes', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/65-woocommerce-infinite-scroll-and-ajax-pagination-settings" target="_blank">' . esc_html__( 'WooCommerce Infinite Scroll and Ajax Pagination', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/91-mail-chimp-form-custom-styles" target="_blank">' . esc_html__( 'MailChimp form custom styles', 'woopress' ) . '</a></li>
// 		</ul>
// 		<h4>' . esc_html__( 'Troubleshooting', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/64-how-to-add-custom-favicon" target="_blank">' . esc_html__( 'How to add custom favicon', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/69-how-to-add-slider-banner-in-product-category-page" target="_blank">' . esc_html__( 'How to add slider/banner on Category page', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/87-facebook-login" target="_blank">' . esc_html__( 'FaceBook login', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/41-contact-page" target="_blank">' . esc_html__( 'How to create a contact page', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/44-blog-page" target="_blank">' . esc_html__( 'How to create a blog page', 'woopress' ) . '</a></li>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/90-how-to-find-your-themeforest-item-purchase-code" target="_blank">' . esc_html__( 'How to find your ThemeForest Item Purchase Code', 'woopress' ) . '</a></li>
// 		</ul>
// 		<h4>' . esc_html__( 'Support', 'woopress' ) . '</h4>
// 		<ul>
// 			<li><a href="https://woopress.helpscoutdocs.com/article/25-support" target="_blank">' . esc_html__( 'Support Policy', 'woopress' ) . '</a></li>
// 		</ul>
// 	</div>
// ';