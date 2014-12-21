<article class="post<?php if (has_post_thumbnail()) { echo ' thumbnail-on'; }?>">
	<header class="post-head">
		<h2 class="post-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title_attribute(); ?></a>
		</h2>
		<time datetime="<?php the_time(); ?>" class="post-time"><?php the_time('Y-m-d'); ?></time>
	</header>
	<?php if (has_post_thumbnail()) {?>
		<section class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<img src="<?php the_post_thumbnail('stumblr-large-image'); ?>" alt="<?php the_title_attribute(); ?>" />
			</a>
		</section>
	<?php } ?>
	<section class="post-entry">
			<?php echo posart_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 300, '...'); ?>
	</section>
	<footer class="post-footer clear">
		<span class="post-tags clear">
			<?php $category = get_the_category(); if($category[0]){ echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; }?>
			<?php the_tags((''), ''); ?>
		</span>
		<a class="post-readmore" href="<?php the_permalink() ?>">阅读更多...</a>
	</footer>
</article>
