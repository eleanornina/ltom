<?php 
if(!empty($_SERVER['SCRIPT-FILENAME']) && basename($_SERVER['SCRIPT-FILENAME']) == 'comments.php'){
	die(__('You cannot access this file directly.','infinite-framework'));
}

if(post_password_required()) : ?>

	<p>
		<?php __('This post is password protected. Enter the password to view the comments.','infinite-framework') ?>
		<?php return; ?>
	</p>

<?php endif;?>

<?php if(have_comments()) :?>

	<div class="post-comments-heading">
		<h2><?php comments_number(__('No Comments', 'infinite-framework'), 
									__('One Comment', 'infinite-framework'), 
									__('% Comments', 'infinite-framework')) 
									?>
								</h2>
	</div>

	<div class="comments-container">
		<ul class="comment-list">
			<?php wp_list_comments('callback=infinite_comments'); ?>
		</ul>
	</div>


	<?php if(get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
		<div class="pagination post-pagination clearfix">
			<?php previous_comments_link(__('Older Comments', 'infinite-framework')); ?>
			<?php next_comments_link(__('Newer Comments', 'infinite-framework')); ?>
		</div>
	<?php endif;?>

<?php elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) :?>
	<p>
		<?php __('Comments are closed.','infinite-framework') ?>
	</p>
<?php endif;?>

<?php if ( comments_open() ) : ?>
<?php
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$fields =  array(
    'author' => '<div class="span4"><input type="text" placeholder="'.__('Name (required)','infinite-framework').'" name="author" id="author" '.$aria_req.'></div>',
    'email'  => '<div class="span4"><input type="text" placeholder="'.__('Email Address (required)','infinite-framework').'" name="email" id="email" '.$aria_req.'></div>',
    'website' => '<div class="span4"><input type="text" placeholder="Website (required)" name="url" id="url"></div>'
);
 
$comments_args = array(
    'fields' =>  $fields,
    'comment_field' => '<div class="row"><div class="span12"><textarea name="comment" id="comment" placeholder="'.__('Your Comment...','infinite-framework').'"></textarea></div></div>',
    'title_reply'=>'Leave A Comment',
    'label_submit' => 'Post Comment',
    'comment_notes_after' => '',
    'id_form' => 'post-comments-form'
);

function commentfields_rowtag( $comment_id ){
	echo '<div class="row">';
}

function commentfields_rowtag_end( $comment_id ){
	echo '</div>';
}

add_action( 'comment_form_before_fields', 'commentfields_rowtag', 10, 1 );
add_action( 'comment_form_after_fields', 'commentfields_rowtag_end', 10, 1 );

comment_form($comments_args); ?>

<?php endif; ?>