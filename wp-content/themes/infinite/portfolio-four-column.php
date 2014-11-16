<?php
/************************************
Template Name: Portfolio Four Column
************************************/
get_header() 
?>
<div class="container-wrapper clearfix" id="main-content-container">
	<div class="container">

		<div class="row">
			<div class="span12">
				<?php 

					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

					$args = array('post_type' => 'portfolio', 'posts_per_page'=> of_get_option('portfolio_items_page', 10),'paged' => $paged );

					$cats = array();

					if(get_query_var('portfolio_category') && get_query_var('portfolio_category') != ''){
						$tax_query = array();

						$tax_query[] =	array(
									'taxonomy' => 'portfolio_category',
									'field' => 'slug',
									'terms' => get_query_var('portfolio_category')
								);

						$args['tax_query'] = $tax_query;

					}


					if(get_query_var('portfolio_tag') && get_query_var('portfolio_tag') != ''){
						$tax_query = array();

						$tax_query[] =	array(
									'taxonomy' => 'portfolio_tag',
									'field' => 'slug',
									'terms' => get_query_var('portfolio_tag')
								);

						$args['tax_query'] = $tax_query;

					}


					$categories = get_categories('taxonomy=portfolio_category&post_type=portfolio'); 

					$query = new WP_Query($args);

				?>
				<ul id="portfolio_filter" class="clearfix">
					<li><a class="active" href="#portfolio_filter" data-filter="portfolio-grid-alt-item"><?php _e('All','infinite-framework') ?></a></li>
				<?php foreach ($categories as $category) {
						if(in_array($category->slug, $cats) || empty($cats))
							echo '<li><a href="#portfolio_filter" data-filter="'.$category->slug.'">'.$category->name.'</a></li>';
					  } 
					?>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="span12 clearfix">
				<div id="article-container" class="clearfix">

				<ul class="portfolio-grid-alt four-column clearfix" id="portfolio-grid-container">
				<?php while($query->have_posts()): $query->the_post(); ?>
					<?php $terms = get_the_terms($post->ID, 'portfolio_category');
						$cssClass='';
						if($terms)
						foreach ($terms as $term) {
							$cssClass .= $term->slug." ";
						}
					 ?>
					 <?php if(has_post_thumbnail()) : ?>
					<li class="portfolio-grid-alt-item  <?php echo $cssClass ?>">
						<div class="portfolio-grid-alt-bg">
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('blog-two-column'); ?>
							<div class="portfolio-grid-alt-content">
								<h5><?php the_title(); ?></h5>
							</div>
						</a>
						</div>

					</li>
					<?php endif; ?>				

				<?php endwhile; ?>
				</ul>
			</div>
				<?php infinite_pagination($query->max_num_pages, $range = 3); ?>
				
			</div> <!--end left column -->

		</div>
	</div>
</div> <!-- end container-wrapper -->


<?php get_footer() ?>