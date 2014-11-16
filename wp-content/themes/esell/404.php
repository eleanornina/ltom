<?php get_header(); ?>
	<!-- BEGIN PAGE -->
	<div id="page">
		<div id="page-inner" class="clearfix">
						<div id="content">
					<div class="post clearfix">
						<h2><?php _e('404 Error&#58; Not Found', 'esell'); ?>
						</h2>
						<div class="entry">
						<p><?php _e('Sorry, but the page you are trying to reach is unavailable or does not exist.', 'esell'); ?></p>
							<h3><?php _e('You may interested with this', 'esell'); ?></h3>
							<?php get_template_part('/includes/random-posts'); ?>
						</div>
					</div><!-- end div .post -->
				</div><!-- end div #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
