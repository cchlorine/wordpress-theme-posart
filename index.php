<?php get_header(); ?>
	<?php if (have_posts()) : ?>
		<div class="posts-list">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('content'); ?>
			<?php endwhile; ?>
		</div>
		<?php posart_paging(); ?>
	<?php else : ?>
		<article class="post">
			<header class="post-head">
				<h2 class="post-title">
					<a><?php _e('没有找到内容'); ?></a>
				</h2>
			</header>
		</article>
	<?php endif; ?>
<?php get_footer(); ?>
