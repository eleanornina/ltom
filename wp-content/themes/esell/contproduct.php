<?php get_header(); ?>
	<!-- BEGIN PAGE -->
	<div id="page">
    <div id="page-inner" class="clearfix">
		<div id="pagecontpro">	
		<?php if(have_posts()) : ?><?php while(have_posts())  : the_post(); ?>
					<article id="pagepost-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/Article">			
					<h1 class="entry-title" itemprop="name headline"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

				<?php if ( of_get_option('esell_pronaviinfo' ) =='on') { ?>	<?php if(is_page(array ('cart','checkout') )){
			echo '<ul id="navlist">
 <li id="s1">1: Add to cart</li>
 <li id="s2">2: View Cart</li>
 <li id="s3">3: proceed to checkout</li>
 <li id="s4">4: Detail & Payment</li>
 <li id="s5">5: Get Product ! </li>
</ul>';
}
?>				<?php } ?>
<div class="entry" class="clearfix">	
								<span itemprop="articleBody"><?php the_content(); ?></span>
								<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'esell' ), 'after' => '</div>' ) ); ?>
							</div> <!-- end div .entry -->
	<div class="gap"></div><?php if (of_get_option('esell_author' ) =='1' ) {load_template(get_template_directory() . '/includes/author.php'); } ?>
							<div class="comments">
								<?php comments_template(); ?>
							</div> <!-- end div .comments -->
			</article> 

			<?php endwhile; ?>
			<?php else : ?>
				<div class="post">
					<h3><?php _e('404 Error&#58; Not Found', 'esell'); ?></h3>
				</div>
			<?php endif; ?>
			      										
		</div><?php get_footer(); ?>
