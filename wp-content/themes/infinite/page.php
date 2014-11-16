<?php get_header(); ?>

<div class="container-wrapper clearfix" id="main-content-container">
		<div class="container">
			<div class="row">

				<?php if(have_posts()) : while(have_posts()) : the_post(); ?>			
					<?php if(get_post_meta($post->ID,'infinite_meta_show_sidebar',true) == 'Yes'){
							$sidebar = true;
							$class = 'span9';
					  }else{
					  		$class= 'span12';
					  }
				 ?>

				<div class="<?php echo $class ?>" style="<?php if(of_get_option('sidebar_position') == 'left') echo 'float:right;'?>">
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<?php if(get_post_meta($post->ID,'infinite_meta_show_title','Yes') != 'No' && !(function_exists('is_cart') && is_cart()) && !(function_exists('is_checkout') && is_checkout())) : ?>
						<h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
						<?php if(current_user_can('edit_post', $post->ID)){
							edit_post_link(__('Edit','infinite-framework'),'<div class="post-meta"><i class="icon-edit"></i> ','</div>');
						} ?>
					<?php endif; ?>
				
					<?php
						if(of_get_option('post_slideshows', 'yes') == 'yes' && get_post_meta($post->ID,'infinite_meta_show_flex_slideshow','Yes') == 'Yes')
							$attachments = get_posts( array(
								'post_type' => 'attachment',
								'posts_per_page' => -1,
								'post_parent' => $post->ID,
								'exclude'     => get_post_thumbnail_id()
								)); 
					?>
					

					<?php if(has_post_thumbnail() || isset($attachments)) : ?>

						<div class="post-image flexslider">
							<ul class="slides">
								<li>
									<?php $perma = get_permalink($post->ID); $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' ); ?>
									<a class="gallery" href="<?php echo  $thumb[0] ?>"><?php the_post_thumbnail('blog-full'); ?></a>
								</li>
								<?php
									if(of_get_option('post_slideshows', 'yes') == 'yes')
										foreach ( $attachments as $attachment ) {
											$thumbimg = wp_get_attachment_image( $attachment->ID, 'blog-full', true );
											$full = wp_get_attachment_image_src($attachment->ID,'full', true);
											echo '<li><a class="gallery" href="'.$full[0].'">' . $thumbimg . '</a></li>';
										}
								?>

							</ul>						
						</div>
					
					<?php endif; ?>

					<div class="post-content clearfix">
						<?php the_content() ?>
					</div>

					<div>
						<?php wp_link_pages(); ?>
					</div>

					<?php endwhile; else: ?>
					
					<article>
						<h1><?php _e('No Posts were found!','infinite-framework') ?></h1>
					</article>
					
					<?php endif; ?>

					<?php if(comments_open()): ?>
					<div id="comments">
						<?php comments_template('', true) ?>
					</div>
					<?php endif; ?>

				</article>
			</div> <!--end left column -->

			<?php if(isset($sidebar) && $sidebar): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

		</div>
	</div>
</div> <!-- end container-wrapper -->

<?php get_footer(); ?>