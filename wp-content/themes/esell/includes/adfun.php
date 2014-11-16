<div id="bottom-menu">
<div id="bottom-menu-inner" class="clearfix">
<div id="bottom-menu-1">
<?php if (!dynamic_sidebar('Bottom Menu 1') ) : ?>
	<?php endif; ?>
</div>
<div id="bottom-menu-2">
	<?php if (!dynamic_sidebar('Bottom Menu 2') ) : ?>
	<?php endif; ?>
</div>
<div id="bottom-menu-4">
	<?php if ( !dynamic_sidebar('Bottom Menu 4') ) : ?>
	<?php endif; ?>
</div> 
</div> 
</div>
<div id="footer">
	<div id="footer-inner" class="clearfix">
<a href="<?php echo esc_url( home_url( ));?>/" title="<?php bloginfo('name');?>" ><?php bloginfo('name');?></a> <?php _e('Copyright &#169;', 'esell'); ?> <?php echo date('Y');?> <a href="<?php echo esc_url( __( 'http://www.wrock.org/esell-woocommerce-theme/', 'esell' ) ); ?>" title="<?php esc_attr_e( 'wrock.org', 'esell' ); ?>"><?php printf( __( '| Theme: eSell %s', 'esell' ),''); ?></a>

	</div> <!-- end div #footer-inner -->
	</div> <!-- end div #footer -->
	<!-- END FOOTER -->
</div> 