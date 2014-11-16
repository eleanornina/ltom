<?php $call_to_action = of_get_option('call_to_action', false);?>
<footer>

	<?php if($call_to_action != false) : ?>
		<div class="container-wrapper call-to-action">
			<div class="container">
				<?php echo do_shortcode($call_to_action) ?>
			</div>
		</div>
	<?php endif ?>

	<div class="container-wrapper main-footer">
		<div class="container">
			<section class="row">
				<?php dynamic_sidebar('footer-widget1'); ?>
			</section> <!-- end row -->
			<section class="row">
				<?php dynamic_sidebar('footer-widget2'); ?>
			</section> <!-- end row -->
		</div> <!-- end container -->
	</div> <!-- end container-wrapper -->

	<div class="container-wrapper copyright">
		<div class="container">
			<div class="row">
				<div class="span6">
					<p>
						Copyright &copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>. <?php _e('Powered by', 'infinite-framework'); ?> 
						<a href="//wordpress.org" title="WordPress"><?php _e('WordPress', 'infinite-framework'); ?></a> &amp; <a href="http://ravichandrach.com" title="<?php _e('Infinite Theme', 'infinite-framework'); ?>"><?php _e('Infinite Theme', 'infinite-framework'); ?></a>
					</p>
				</div>
				<div class="span6 social-icon-container clearfix">
					<ul>
						<li>
							<?php $social_icons = array('Facebook' => 'social_facebook',
														'Twitter' => 'social_twitter',
														'Google-plus' => 'social_googleplus',
														'LinkedIn' => 'social_linkedin'
														);
							foreach ($social_icons as $name => $icon) {
								if(of_get_option($icon)): ?>
									<a data-toggle="tooltip" title="" target="_blank" data-original-title="<?php echo str_replace('-',' ',$name) ?>" class="social-icon icon-<?php echo strtolower($name) ?>" href="<?php echo esc_url(of_get_option($icon))  ?>"></a>
								<?php endif; 
							}
							?>

						</li>
					</ul>
				</div>
			</div> <!-- end row -->
		</div> <!-- end container -->
	</div> <!-- end container-wrapper -->
</footer>
</div> <!-- end boxed-layout -->

<div id="back-to-top">
	<a id="back-to-top-icon" href="#"><i class="icon-chevron-up"></i></a>
</div>

<?php wp_footer(); ?>

</body>
</html>