<?php get_header(); ?>

<div class="container-wrapper clearfix" id="main-content-container">
	<div class="container">
		<div class="row">
			<div class="span9 404-page" style="<?php if(of_get_option('sidebar_position') == 'left') echo 'float:right;'?>">
				<article class="error404">
					<h2><?php _e('404 Error', 'infinite-framework'); ?></a></h2>
					<p><?php _e("The page you are looking for doesn't exist, please use the below search field to search the site.", 'infinite-framework'); ?></p>
					<?php get_search_form(); ?>
				</article>
			</div>

			<?php get_sidebar(); ?>
			
		</div>
	</div>
</div> <!-- end container-wrapper -->
<?php get_footer(); ?>