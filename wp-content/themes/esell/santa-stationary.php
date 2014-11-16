<?php
/*
Template Name: santa-stationary
*/
?>
<?php get_header(); ?>
<div id="main">
<div id="content">
<p> I hope this works because I dont know what to do</p>


<?php
$args=array(
'post_type' => 'products',
'orderby' => "category",
'order' => ASC,
'caller_get_posts'=> 1
);
$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
echo '' . $type .'';
while ($my_query->have_posts()) : $my_query->the_post(); ?>

<ul>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
<li><?php the_excerpt() ?></li>
</ul>
<?php
endwhile;
} //if ($my_query)
wp_reset_query(); // Restore global post data stomped by the_post().
?>

</div>
</div>
<?php get_footer(); ?>