<?php
/*
 *   Links for My Account and for My Quote List
*/

function header_upper() {
  /** Wrapper is generated automatically */
  
  $cart_url = wc_get_cart_url();
  ?>
  <a href="mailto:solutions@forbesindustries.com">
    <i class="fas fa-envelope"></i>  
    <span>solutions@forbesindustries.com</span>
  </a>
  <a href="tel:+18008325427">
    <i class="fas fa-phone"></i>  
    <span>(800) 832-5427</span>
  </a>
  <a href="<?php echo $cart_url; ?>">
    <i class="fas fa-luggage-cart"></i>
    <span>My Quote List</span>
  </a>

  <?php
}