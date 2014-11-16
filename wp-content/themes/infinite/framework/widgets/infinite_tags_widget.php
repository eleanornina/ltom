<?php

class infinite_Tags_Widget extends WP_Widget {
	
	function infinite_Tags_Widget()
	{
		$widget_ops = array('classname' => 'infinite-tags', 'description' => '');

		$control_ops = array('id_base' => 'infinite_tags-widget');

		$this->WP_Widget('infinite_tags-widget', 'Infinite Tag Cloud', $widget_ops, $control_ops);
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
		
		$tags = wp_tag_cloud('number='.$count.'&format=array');

		if(empty($tags)) return;

		foreach ($tags as $tag) {
			$class = "#(.*tag-link[-])(.*)(' title.*)#e";
			$style = "/style=[\"\']?[\w-:\s0-9\w\;]+[\"\']?/";
			echo preg_replace($style, "",  preg_replace($class, "('$1$2 tag$3')", $tag ) );
		}
		
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
		$defaults = array('title' => 'Tags','count' => 3);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		</p>

			<label for="<?php echo $this->get_field_id('count'); ?>">Tag Count:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
		</p>

	<?php
	}
}
?>