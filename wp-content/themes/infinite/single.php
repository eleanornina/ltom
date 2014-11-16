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
					<h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					
					<div class="post-meta">
						<span class="post-date">
							<i class="icon-calendar"></i> <?php the_time(get_option('date_format')) ?>
						</span>
						<span class="seperator">/</span>
						<span class="post-author">
						<i class="icon-user"></i> <?php the_author_posts_link(); ?>
						</span>
						<?php
							if(comments_open() && !post_password_required()) {
						?>
								<span class="seperator">/</span>
								<i class="icon-comments"></i>
						<?php
								comments_popup_link(
									__('No Comments', 'infinite-framework'), 
									__('1 Comment', 'infinite-framework'), 
									__('% Comments', 'infinite-framework'));
							}
						?>
					</div>

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
									if(of_get_option('post_slideshows', 'yes') == 'yes' && get_post_meta($post->ID,'infinite_meta_show_flex_slideshow','Yes') == 'Yes')
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

					<?php $posttags = get_the_tags();
					if ($posttags) : ?>
						<div class="tags action">
							<i class="icon-tags"></i>
							<?php  foreach($posttags as $tag) {
							    	echo '<a class="tag" alt="' . $tag->name . '" href="'.site_url("/").'?tag='.$tag->slug.'">'.$tag->name.'</a>'; 
							  	} ?>
						</div>
					<?php endif; ?>
					
					
					<!-- <div class="row"> -->
						<div class="pagination post-pagination clearfix">
							<div class="row">
								<?php previous_post_link( '%link',  __('<div class="previous span6"><i class="icon-chevron-left"></i><div class="text">Previous Article</div> <h4>%title</h4></div>', 'infinite-framework') ); ?>
								<?php next_post_link( '%link',  __('<div class="next span6"><i class="icon-chevron-right"></i><div class="text">Next Article</div> <h4>%title</h4></div>', 'infinite-framework') ); ?>
							</div>

						</div>
					<!-- </div> -->

					<?php 
					$auth_info = get_the_author_meta('description');
					if(of_get_option('author_info','yes') == 'yes' && $auth_info != '') : ?>
					<div id="about-author" class="clearfix">
						<h2><?php _e('About the Author - ', 'infinite-framework') ?><?php the_author_posts_link(); ?></h2>
						<div class="avatar">
							 <?php  echo get_avatar(get_the_author_ID(), 70);    ?>
						</div>
						<div class="author-content">
							<?php echo $auth_info ?>
						</div>
					</div>
					<?php endif; ?>

					<?php if(of_get_option('related_posts','yes') == 'yes') : ?>

						<?php global $post;
							$orig_post = $post;
							$tags = wp_get_post_tags($post->ID);			
							if ($tags) :
								$tag_ids = array();
								foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
								$args=array(
									'tag__in' => $tag_ids,
									'post__not_in' => array($post->ID),
									'posts_per_page'=>of_get_option('related_posts_num',10), // Number of related posts to display.
									'caller_get_posts'=>1
								);
								
								$infinite_related_slides_query = new wp_query( $args );
								if($infinite_related_slides_query->post_count > 0):
							 ?>

						<div class="clearfix flexslider" id="related-posts">
							<h2 class="section-head"><?php _e('Related Posts', 'infinite-framework') ?></h2>
								
							
							<ul class="slides">
							<?php

									while( $infinite_related_slides_query->have_posts() ) :
										$infinite_related_slides_query->the_post();
										?>
											<li>
												<a href="<?php the_permalink();?>"> <?php has_post_thumbnail() ? the_post_thumbnail('related-post') : print '<i class="icon-pencil icon-4"></i>'; ?><div class="related-post-title"><?php the_title(); ?></div></a>
											</li>
										
									<?php endwhile;
							?>
							</ul>
						</div>
				
						<?php 	endif;endif;
								$post = $orig_post;
								wp_reset_postdata(); ?>
						
							
					
					<?php endif; ?>
					
					<?php endwhile; else: ?>
					
					<article>
						<h1><?php _e('No Posts were found!','infinite-framework') ?></h1>
					</article>
					
					<?php endif; ?>

					<?php if(comments_open()): ?>
					<div id="comments" class="clearfix">
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