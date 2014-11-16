<?php get_header(); ?>

<div class="container-wrapper clearfix" id="main-content-container">
	<div class="container">
		<div class="row">

			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>			
			
			<div class="span12">
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

					<?php
					if(of_get_option('post_slideshows', 'yes') == 'yes' && get_post_meta($post->ID,'infinite_meta_show_flex_slideshow','Yes') == 'Yes')
						$attachments = get_posts( array(
							'post_type' => 'attachment',
							'posts_per_page' => -1,
							'post_parent' => $post->ID,
							'exclude'     => get_post_thumbnail_id()
							)); 
							?>


							<?php if( has_post_thumbnail() || isset($attachments) )  : ?>

							<div class="post-image flexslider">
								<ul class="slides">
									<li>
										<?php $perma = get_permalink($post->ID); $imgSize = 'blog-normal';
										$thumbID = get_post_thumbnail_id( $post->ID );
										$thumbnail_image = get_posts(array('p' => $thumbID, 'post_type' => 'attachment'));
										$image = wp_get_attachment_image_src($thumbID , 'full' ); ?>
										<a class="gallery" title="<?php echo $thumbnail_image[0]->post_excerpt; ?>" href="<?php echo $image[0]  ?>"><?php the_post_thumbnail(array(810,325)); ?></a>
									</li>
									<?php
									if(of_get_option('post_slideshows', 'yes') == 'yes' && get_post_meta($post->ID,'infinite_meta_show_flex_slideshow','Yes') == 'Yes')
										foreach ( $attachments as $attachment ) {
											$thumbimg = wp_get_attachment_image( $attachment->ID, $imgSize, true );
											$full = wp_get_attachment_image_src($attachment->ID,'full', true);
											echo '<li><a class="gallery" href="'.$full[0].'" title="'.$attachment->post_excerpt.'">' . $thumbimg . '</a></li>';
										}
										?>

									</ul>						
								</div>

							<?php endif; ?>


							<?php $client = get_post_meta($post->ID,'infinite_meta_project_client',true);
							$task = get_post_meta($post->ID,'infinite_meta_project_task',true);
							$url = get_post_meta($post->ID,'infinite_meta_project_url',true);
							$urlText = get_post_meta($post->ID,'infinite_meta_project_url_text',true);
							if($url != ''){
								$text = $urlText == '' ? __('View Project', 'infinite-framework') : $urlText;
								$fullUrl = '<a class="button" href="'.$url.'">'. $text .'</a>';
							}else{
								$fullUrl = false;
							}
							?>

							<?php $tags = get_the_terms($post->ID, 'portfolio_tag');
							$categories = get_the_terms($post->ID, 'portfolio_category');
							if($tags && !empty($tags)){
								foreach ( $tags as $tag ) {
									$link = get_term_link( $tag, 'portfolio_tag' );
									$tag_links[] = '<a href="' . esc_url( $link ) . '" >' . $tag->name . '</a>';
								}
							}

							if($categories && !empty($categories)){
								foreach ( $categories as $category ) {
									$link = get_term_link( $category, 'portfolio_category' );
									$category__list[] = $category->term_id;
									$category_links[] = '<a href="' . esc_url( $link ) . '" >' . $category->name . '</a>';
								}
							}
							?>

							<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

							<div class="post-content clearfix">

								<div class="row">
									<div class="span9">
										<!-- <h2><?php _e('Description', 'infinite-framework'); ?></h2> -->
										<?php the_content() ?>

										<?php if($fullUrl != false) echo $fullUrl ?>
										<?php if( $client != ''): ?>
										<h4><?php _e('Client', 'infinite-framework') ?></h4>
										<?php echo $client ?>
									<?php endif; ?>
									<?php if($task != ''): ?>
									<h4><?php _e('Tasks', 'infinite-framework') ?></h4>
									<p><?php echo $task ?></p>
								<?php endif; ?>
							</div>


							<div class="span3">

								<?php if($categories && !empty($categories)): ?>
								<div class="portfolio-info">
									<h4><?php _e('Categories', 'infinite-framework'); ?>:</h4>
									<div class="portfolio-terms">
										<?php echo implode("<br />", $category_links); ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if($tags && !empty($tags)): ?>
							
							<div class="portfolio-info">
								<h4><?php _e('Tags', 'infinite-framework'); ?>:</h4>
								<div class="portfolio-terms">
									<?php echo implode("<br />", $tag_links); ?>
								</div>
							</div>
						<?php endif; ?>


					</div>
				</div>


			</div>

<?php endwhile; else: ?>

	<article>
		<h1><?php _e('No Posts were found!','infinite-framework') ?></h1>
	</article>

<?php endif; ?>


</article>
</div> <!--end left column -->

</div>
</div>
</div> <!-- end container-wrapper -->


<?php get_footer(); ?>