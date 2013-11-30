<?php get_header(); ?>
		<div class="body">
			<?php posart_breadcrumbs(); ?>
			<ul class="types cl">
				<li class="cat-item cat-item-1"><a href="<?php bloginfo('url'); ?>" title="查看所有文章">全部</a></li>
				<?php wp_list_cats("sort_column=ID&hide_empty=0&optioncount=1");?>
			</ul>
			<div class="lists">
				<div id="loading-posts" style="display:none;"></div>	
				<div class="posts-list"><?php if (have_posts()) : ?> 
					<?php while (have_posts()) : the_post(); ?> 
						<div id="article" class="cl">
							<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title_attribute(); ?></a></h2>
							<div class="mhidden entry-thumbnail"><a href="<?php the_permalink(); ?>"><?php posart_thumbnail('641', '250'); ?></a></div>
							<p class="note"><?php echo posart_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 125, '...'); ?></p>
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
					<?php endwhile; ?> 
					<?php else : ?></div>
					<?php endif; posart_paging(); ?> 
			</div>
		</div>
<?php get_footer(); ?>