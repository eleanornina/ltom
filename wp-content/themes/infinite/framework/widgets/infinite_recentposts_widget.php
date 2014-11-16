<?php

class infinite_RecentPosts_Widget extends WP_Widget {
	
	function infinite_RecentPosts_Widget()
	{
		$widget_ops = array('classname' => 'infinite-recent-posts', 'description' => '');

		$control_ops = array('id_base' => 'infinite-recent-posts-widget');

		$this->WP_Widget('infinite-recent-posts-widget', 'Infinite Recent Posts', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>

		<?php $the_query = new WP_Query( array('showposts' => $count,  'orderby' => 'post_date', 'order' => 'DESC')); ?>
	    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
			<div class="sidebar-posts clearfix">
				<a href="<?php the_permalink() ?>">
				<div class="sidebar-post-image fl">
					<?php has_post_thumbnail() ? the_post_thumbnail('post-thumb') : print '<i class="icon-minus-sign icon-4"></i> <img src="'.get_template_directory_uri().'/images/related-post-dummy.jpg">';?>
				</div>
				<div class="post-title">
					<h5><?php the_title(); ?></h5>
				</div>
				<!-- <div class="post-date"><i class="icon-calendar"></i><?php the_time(get_option('date_format')) ?></div> -->
				</a>
			</div>
	    <?php endwhile;wp_reset_postdata();?>
	    
	<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = $new_instance['count'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Posts');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo isset($instance['title']) ? $instance['title'] : ''; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>">Count:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo isset($instance['count']) ? $instance['count'] : ''; ?>" />
		</p>

	<?php
	}
}
?>