<div id="author-bio">
	<h3><h4><?php _e('About', 'esell'); ?></h4><?php the_author_posts_link(); ?></h3>
<?php echo get_avatar( get_the_author_meta('ID'), 64 ); ?>
       <?php the_author_meta('description'); ?>                        
</div>
