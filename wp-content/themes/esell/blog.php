<?php get_header(); ?>
<!-- BEGIN PAGE -->
	<div id="page">
		<div id="page-inner" class="clearfix">
							<div id="content">
						<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
				query_posts( "post_type=post&paged=$paged" ); ?>

				<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>	
						<?php get_template_part('/includes/post'); ?>
					<?php endwhile; ?>
					<?php else : ?>
							<div class="post">
								<div class="posttitle">
									<h2><?php _e('404 Error&#58; Not Found', 'esell' ); ?></h2>
									<span class="posttime"></span>
								</div>
							</div>
						<?php endif; ?>
<?php get_template_part('/includes/pagenav'); ?>	
				</div> <!-- end div #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>