<?php
/*
 *   Links for My Account and for My Quote List
*/

function my_links() {

  $cart_url = wc_get_cart_url();
  ?>
  <div class="my-links">
    <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">
      <i class="fas fa-user"></i>
      My Account
    </a>
    <a href="<?php echo $cart_url; ?>">
      <i class="fas fa-luggage-cart"></i>
      My Quote List
    </a>
  </div>

  <?php
}