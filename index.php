<?php get_header(); ?>
		<div class="body">
			<?php posart_breadcrumbs(); ?>
			<div id="loading-posts" style="display:none;"></div>
			<?php if (have_posts()) : ?> 
				<div class="posts-list">
					<?php while (have_posts()) : the_post(); ?> 
						<?php get_template_part('content'); ?>
					<?php endwhile; ?> 
				</div>
				<?php posart_paging(); ?> 
			<?php else : ?>
				<h1>404</h1>
			<?php endif; ?>	
		</div>
<?php get_footer(); ?>