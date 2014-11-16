<div class="myaccpro">		
<?php if ( is_user_logged_in() ) { ?>
<a class="myacc" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','esell'); ?>"><?php _e('My Account','esell'); ?></a>
<?php }
else { ?>
<a class="myacc" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','esell'); ?>"><?php _e('Login / Register','esell'); ?></a>
<?php } ?>
	<?php global $woocommerce; ?> 
<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'esell'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'esell'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
</div>