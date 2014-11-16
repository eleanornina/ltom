<?php
/************************************
Template Name: Front Page
************************************/
get_header() 
?>

<div class="container-wrapper clearfix" id="main-content-container">
		<div class="container">
			<div class="row">

				<div class="span12">
				<article <?php post_class('post-content clearfix'); ?> id="post-<?php the_ID(); ?>">
					<?php $post_meta = get_post_meta($post->ID) ?>

					<?php if(function_exists('camera_meta_slideshow') && isset($post_meta['camera_meta_slideshow']) && $post_meta['camera_meta_slideshow'][0] != 'none' && $post_meta['camera_meta_slideshow'][0] != '') : ?>
						<div class="row">
							<div class="span12">
								<?php echo camera_meta_slideshow($post_meta['camera_meta_slideshow'][0]); ?>
							</div>
						</div>
					<?php endif; ?>
				
					<?php if(isset($post_meta['infinite_meta_show_services']) && $post_meta['infinite_meta_show_services'][0] == 'Yes') : ?>
						<div class="row" style="margin-bottom:30px">
						<?php
							$service_info = unserialize($post_meta['infinite_meta_services_info'][0]); //print_r($service_info) ;
							$columns = $service_info['columns'];

							switch ($columns) {
								case 2:
									$span = 'span6';
									break;
								
								case 3:
									$span = 'span4';
									break;
								

								case 4:
									$span = 'span3';
									break;
								

								default:
									$span = 'span6';
									break;
							}

							for ($i=1; $i <= $columns ; $i++) : 

								$icon = isset($service_info['icon_'.$i]) ? $service_info['icon_'.$i] : '';
								$title = isset($service_info['title_'.$i]) ? $service_info['title_'.$i] : '';
								$text = isset($service_info['text_'.$i]) ? $service_info['text_'.$i] : '';

							?>
								
								<div class="<?php echo $span ?>">
									<div class="action-icon-container"><i class="<?php echo $icon ?> normal action-icon icon-2x" style=""></i></div>
									<h3 style="text-align: center;"><?php echo $title ?></h3>
									<p><?php echo $text ?></p>
								</div>

							<?php endfor; ?>

						</div>

					<?php endif; ?>

					<?php if(isset($post_meta['infinite_meta_show_call_to_action']) && esc_html($post_meta['infinite_meta_show_call_to_action'][0]) == 'Yes') : ?>

						<blockquote style="margin-bottom:50px;margin-top:50px;">
							<h3 style="text-align: center;"><?php echo (isset($post_meta['infinite_meta_call_to_action_text']) && $post_meta['infinite_meta_call_to_action_text'][0] != '') ? $post_meta['infinite_meta_call_to_action_text'][0] : '' ?></h3>
							<?php if(isset($post_meta['infinite_meta_call_to_action_url']) && esc_url($post_meta['infinite_meta_call_to_action_url'][0]) != '' && isset($post_meta['infinite_meta_call_to_action_url_text']) && $post_meta['infinite_meta_call_to_action_url_text'][0] != '') : ?>
								<p style="text-align: center;">
									<a href="<?php echo esc_url($post_meta['infinite_meta_call_to_action_url'][0]) ?>" target="_blank" class="button medium  fadeIn" data-animate="fadeIn"><?php echo esc_html($post_meta['infinite_meta_call_to_action_url_text'][0]) ?></a>
								</p>
							<?php endif; ?>
						</blockquote>

					<?php endif; ?>

						<?php

						if(class_exists('Portfolio_Post_Type')) :

						if(isset($post_meta['infinite_meta_show_recent_portfolio']) && $post_meta['infinite_meta_show_recent_portfolio'][0] == 'Yes') :


							if(isset($post_meta['infinite_meta_recent_portfolio_title']) && $post_meta['infinite_meta_recent_portfolio_title'][0] != '')
								echo '<h1 style="text-align: center;">'. $post_meta['infinite_meta_recent_portfolio_title'][0] .'</h1>';

							$count = (isset($post_meta['infinite_meta_recent_portfolio_count']) && is_numeric($post_meta['infinite_meta_recent_portfolio_count'][0])) ? $post_meta['infinite_meta_recent_portfolio_count'][0] : 8;

							$params = array('showposts' => $count, 'post_type' => 'portfolio',  'orderby' => 'post_date', 'order' => 'DESC', 'post__not_in' => get_option('sticky_posts'));

							$the_query = new WP_Query($params);
								
							echo '<div class="clearfix">';	
							$i = 0;
							while ($the_query -> have_posts()) : $the_query -> the_post();

								echo '<li class="post-grid post-grid-third recent-post">';
								echo	'<div class="post-image">';

								if(has_post_thumbnail()){
									echo '<a href="'.get_permalink().'">'. get_the_post_thumbnail(get_the_ID(),'blog-grid').'<i class="icon-search"></i></a>';
								}else{
									echo '<a href="'.get_permalink().'"><div class="grid-dummy-image"><img src="'.get_template_directory_uri().'/images/grid-dummy-image.jpg"><i class="icon-pencil"></i></div><i class="icon-search"></i></a>';
								}

								echo '</div>';
								echo '<div class="post-title">';
								the_title();
								echo '</div>';
								echo '</li>';

							$i++;

						    endwhile;
						    wp_reset_postdata();
						    echo '</div>';

					    endif;
					    endif;

					 ?>



					<?php 
						if(isset($post_meta['infinite_meta_show_recent_blog']) && $post_meta['infinite_meta_show_recent_blog'][0] == 'Yes') :


							if(isset($post_meta['infinite_meta_recent_blog_title']) && $post_meta['infinite_meta_recent_blog_title'][0] != '')
								echo '<h1 style="text-align: center;">'. $post_meta['infinite_meta_recent_blog_title'][0] .'</h1>';

							$count = (isset($post_meta['infinite_meta_recent_blog_count']) && is_numeric($post_meta['infinite_meta_recent_blog_count'][0])) ? $post_meta['infinite_meta_recent_blog_count'][0] : 8;

							$params = array('showposts' => $count,  'orderby' => 'post_date', 'order' => 'DESC', 'post__not_in' => get_option('sticky_posts'));

							$the_query = new WP_Query($params);
								
							echo '<div class="clearfix">';	
							$i = 0;
							while ($the_query -> have_posts()) : $the_query -> the_post();

								echo '<li class="post-grid post-grid-third recent-post">';
								echo	'<div class="post-image">';

								if(has_post_thumbnail()){
									echo '<a href="'.get_permalink().'">'. get_the_post_thumbnail(get_the_ID(),'blog-grid').'<i class="icon-search"></i></a>';
								}else{
									echo '<a href="'.get_permalink().'"><div class="grid-dummy-image"><img src="'.get_template_directory_uri().'/images/grid-dummy-image.jpg"><i class="icon-pencil"></i></div><i class="icon-search"></i></a>';
								}

								echo '</div>';
								echo '<div class="post-title">';
								the_title();
								echo '</div>';
								echo '</li>';

							$i++;

						    endwhile;
						    wp_reset_postdata();
						    echo '</div>';

					    endif;

					 ?>


					<div class="post-content clearfix">
						<?php the_content() ?>
					</div>
					

					<?php if(comments_open()): ?>
					<div id="comments clearfix">
						<?php comments_template('', true) ?>
					</div>
					<?php endif; ?>

				</article>
			</div> <!--end left column -->


		</div>
	</div>
</div> <!-- end container-wrapper -->

<?php get_footer(); ?>