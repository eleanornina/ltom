<?php
get_header() 
?>

<div class="container-wrapper clearfix" id="main-content-container">
	<div class="container">

		<div class="row">
			<div class="span12">
				<?php 
				$categories = get_categories('taxonomy=portfolio_category&post_type=portfolio'); ?>
				<ul id="portfolio_filter" class="clearfix">
					<li><a class="active" href="#portfolio_filter" data-filter="portfolio-grid-alt-item">All</a></li>
				<?php foreach ($categories as $category) {
					echo '<li><a href="#portfolio_filter" data-filter="'.$category->slug.'">'.$category->name.'</a></li>';
				} ?>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="span12 clearfix">
				<div id="article-container" class="clearfix">
				<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
				<?php $query = new WP_Query($args = array(
					'post_type' => 'portfolio',
					'paged' => $paged,
					'posts_per_page' => 10,
				)); ?>

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