<h4><?php _e('Latest', 'esell'); ?></h4>
<div id="ltpost">
<?php 
$esell_args = array( 
 'ignore_sticky_posts' => true,
 'showposts' => 5,
'orderby' => 'date',  );
$the_query = new WP_Query( $esell_args );
 if ( $the_query->have_posts() ) :
while ( $the_query->have_posts() ) : $the_query->the_post();
			 ?>
							
							
								<div class="latest-post">
									<?php if ( has_post_thumbnail() ) {the_post_thumbnail('ltpostthumb');} else { ?><img src="<?php echo of_get_option( 'esell_default');?>" width="45px" height="45px"/>
<?php } ?> 
									 <a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><br />
									 <div class="clear"></div>
								</div>			
							<?php endwhile; ?><?php endif; ?>	<?php wp_reset_postdata(); ?>
									</div>		
	<div style="clear:both;"></div>