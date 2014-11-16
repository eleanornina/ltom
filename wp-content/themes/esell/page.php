<?php 
//Load page template for product and non product site
//include from eSell version 1.2.3

if(is_page(array ('cart','checkout','my-account','shop','products') )):?>
			<?php get_template_part('contproduct'); ?>
			<?php else : ?>
			<?php get_template_part('contpage'); ?>	
    <?php endif; ?>