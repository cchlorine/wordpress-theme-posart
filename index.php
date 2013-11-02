<?php get_header(); ?>
		<div class="unbody">
			<?php get_breadcrumbs(); ?>
		</div>
		<div class="body nopa lists z">
			<ul class="types cl"><li class="cat-item cat-item-1 <?php if(!$_GET['cat']) { echo 'current-cat'; }?>"><a href="<?php bloginfo('url'); ?>" title="查看所有文章">全部</a></li>
			<?php wp_list_cats("sort_column=ID&hide_empty=0&optioncount=1");?></ul>
			<?php if (have_posts()) : ?> 
				<?php while (have_posts()) : the_post(); ?> 
					<div id="article" class="cl">
						<div class="mhidden focus z"><a href="<?php the_permalink(); ?>" class="thumbnail"><?php post_thumbnail('220', '150'); ?></a></div>
							<div class="header">
								<?php  $category = get_the_category();
									if($category[0]){
										echo '<a class="z label" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';
									}?>
								<h2><a href="<?php the_permalink() ?>"><?php the_title_attribute(); ?></a></h2></div>
							<p>
							<?php if( !is_author() ){ ?>
								<span class="muted"><i class="icon-user icon12"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_the_author() ?></a></span>
							<?php } ?>
								<span class="muted"><i class="icon-time icon12"></i> <?php if(is_home()) the_time('m-d'); else the_time('Y-m-d'); ?></span>
								<span class="muted"><i class="icon-comment icon12"></i> <?php if ( comments_open() ) echo '<a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').'评论</a>'; ?></span>
							</p>
							<p class="note"><?php echo deel_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 125, '...'); ?></p>
						
					</div>
				<?php endwhile; ?> 
				<?php else : ?>
				<?php endif; paging(); ?> 
		</div>
		<div class="nopa sidebar z mhidden">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('首页右侧') ) : ?>
			<?php endif; ?>
		</div>
<?php get_footer(); ?>