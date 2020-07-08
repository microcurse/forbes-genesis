<?php
/**
 * The template for displaying search forms.
 *
 */
?>

<?php if(class_exists('Woocommerce')) : ?>

    <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label class="screen-reader-text" for="woocommerce-product-search-field-0">What can we help you find?</label>
        <input type="search" placeholder="<?php esc_html_e( 'You can search by product type, sku, or use case', 'woopress' ) ?>" value="<?php if(get_search_query() != '') { the_search_query(); } ?>" class="search-field" name="s" />
        <button type="submit" value="Search">Search</button>
        <input type="hidden" name="post_type" value="product">
	</form>

<?php else: ?>
	<?php get_template_part('searchform'); ?>
<?php endif ?>