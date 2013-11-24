<?php get_header(); ?>

		<div class="nopa body">
			<?php get_breadcrumbs(); ?>
			<div class="content">
				<?php while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="position: relative;z-index: 1;">
						<header class="entry-header">
								<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="entry-meta">
							</div>
							<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
								<div class="entry-thumbnail mhidden">
									<?php post_thumbnail( 641,237,'img-rounded' ); ?>
								</div>
							<?php endif; ?>
						</header>

						<?php if ( is_search() ) : ?>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div>
						<?php else : ?>
						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
						</div>
						<?php endif; ?>

						<footer>
						</footer>
					</div>
					<?php //comments_template(); ?>
				<?php endwhile; ?>
				<div class="background" style="background-image: url(<?php bloginfo('template_url'); echo '/images/content/'.rand(1,20);?>.jpg);"></div>
			</div>
			<div class="comments"><?php comments_template(); ?></div>
		</div>
		
	<div class="nopa sidebar z mhidden">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('文章右侧') ) : ?>
		<?php endif; ?>
	</div>

<?php get_footer(); ?>