<div id="post-<?php the_ID(); ?>" class="article cl">
	<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title_attribute(); ?></a></h2>
	<?php if( has_post_thumbnail()) {?>
		<div class="mhidden entry-thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('stumblr-large-image'); ?></a></div>
	<?php } ?>
	<p class="entry-content"><?php echo posart_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 125, '...'); ?></p>
	<p class="entry-meta">
		<?php the_time('Y-m-d'); ?> &nbsp;&nbsp;&nbsp;
		<?php if ( comments_open() ) echo '<a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').' Comments</a>'; ?> &nbsp;&nbsp;&nbsp;
		<?php  $category = get_the_category(); if($category[0]){ echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; }?>&nbsp;&nbsp;&nbsp;
		<?php if( !is_author() ){ ?>
		&nbsp;&nbsp;&nbsp;<?php echo get_the_author() ?>
		<?php } ?>
		<a class="y" href="<?php the_permalink() ?>">More...</a>
	</p>
</div>