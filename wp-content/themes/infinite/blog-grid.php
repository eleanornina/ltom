<?php
/************************************
Template Name: Blog Grid
************************************/
get_header() 
?>

<div class="container-wrapper clearfix" id="main-content-container">
	<div class="container">
		<div class="row">
			<div class="span9 clearfix">
				<div id="article-container" class="clearfix">
				<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
				<?php $infinite_blog_query = new WP_Query(array('posts_per_page'=> get_option('posts_per_page'),'paged' => $paged )); ?>
				<ul id="full-grid">
				<?php while($infinite_blog_query->have_posts()): $infinite_blog_query->the_post(); ?>

					<li <?php post_class('post-grid post-grid-third'); ?> id="post-<?php the_ID(); ?>">
						<div class="content-wrapper">
						<?php if(has_post_thumbnail()) : ?>
							<div class="post-image">
								<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('blog-grid'); ?><i class="icon-search"></i></a>
							</div>
						<?php else: ?>
							<div class="post-image">
								<a href="<?php the_permalink() ?>"><div class="grid-dummy-image"><img src="<?php echo get_template_directory_uri()?>/images/grid-dummy-image.jpg"><i class="icon-pencil"></i></div><i class="icon-search dummy"></i></a>				
							</div>							
						<?php endif; ?>


						<h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
						
							<div class="post-meta">
								<span class="post-date">
									<i class="icon-calendar"></i>
									<?php the_time(get_option('date_format')) ?>
								</span>
										<span class="seperator">/</span>
										<i class="icon-comments"></i>
								<?php
									comments_popup_link(
										__('No Comments', 'infinite-framework'), 
										__('1 Comment', 'infinite-framework'), 
										__('% Comments', 'infinite-framework'));
								?>

								<?php if( get_the_title() == '' ) : ?>
				                	<span class="seperator">/</span> <a href="<?php the_permalink(); ?>" title="<?php _e( 'Permalink', 'infinite-framework' ); ?>"><?php _e( 'Permalink', 'infinite-framework' ); ?></a>
				                <?php endif; ?>
								
							</div>
						</div>

					</li>

				<?php endwhile; wp_reset_postdata();?>
				</ul>
				</div>
			
				<?php infinite_pagination($infinite_blog_query->max_num_pages); ?>
				
			</div> <!--end left column -->

			<?php get_sidebar(); ?>

		</div>
	</div>
</div> <!-- end container-wrapper -->

<?php get_footer() ?>