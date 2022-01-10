<?php
/*
 *   Links for My Account and for My Quote List
*/

function header_upper() {

  $cart_url = wc_get_cart_url();
  ?>
  <div class="contact-info">
    <a href="mailto:solutions@forbesindustries.com">
      <i class="fas fa-envelope"></i>  
      <span>solutions@forbesindustries.com</span>
    </a>
    <a href="tel:+18008325427">
      <i class="fas fa-phone-alt"></i>  
      <span>(800) 832-5427</span>
    </a>
  </div>

  <div class="my-links">
    <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">
      <i class="fas fa-user"></i>
      <span>My Account</span>
    </a>
    <a href="<?php echo $cart_url; ?>">
      <i class="fas fa-luggage-cart"></i>
      <span>My Quote List</span>
    </a>
  </div>

  <?php
}