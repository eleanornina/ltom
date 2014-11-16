<span class="auth"> <?php esell_post_meta_data(); ?></span>
<span itemprop="articleSection" class="postcateg"><?php the_category(', '); ?></span>
<?php if ( comments_open() ) : ?><span class="comp"><?php comments_popup_link('No Comment', '1 Comment', '% Comments'); ?></span><?php endif; ?>