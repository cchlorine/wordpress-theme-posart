<?php get_header(); ?>
		<div class="unbody">
			<div id="mkplayer-content">
				<span id="mkplayer-sectsel"></span>
				<div id="mkplayer-box" class="playerHolder"></div>
				<div class="placeHolder"></div>
				<span id="mkplayer-desc" class="parts text-center"></span>
			</div>
		</div>
		<div class="body">
			<?php posart_breadcrumbs(); ?>
			<div class="content">
				<?php while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="position: relative; z-index: 1;">
						<header class="entry-header">
							<h2 class="entry-title"><?php the_title(); ?></h2>
							<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
								<?php if( has_post_thumbnail()) {?>
									<div class="mhidden entry-thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('stumblr-large-image'); ?></a></div>
								<?php } ?>
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
					</div>
				<?php endwhile; ?>
				<footer>
					<p class="entry-meta"> <?php the_time('Y-n-j') ?> &nbsp;&nbsp;&nbsp;
					<?php the_category(', ') ?> &nbsp;&nbsp;&nbsp; <?php the_tags('Tags:',',','')?> &nbsp;&nbsp;&nbsp;</p>
				</footer>
				<div class="background" style="background-image: url(<?php bloginfo('template_url'); echo '/images/content/'.rand(1,20);?>.jpg);"></div>
			</div>
			<div class="comments"><?php comments_template(); ?></div>
		</div>
	<script src="<?php bloginfo('template_url'); ?>/posart/comments-ajax.js"></script>
<?php get_footer(); ?>