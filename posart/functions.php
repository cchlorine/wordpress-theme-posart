<?php
	/*---------------- [ WP安全考虑 ]------------------*/
	remove_action( 'wp_head', 'wp_generator' ) ;
	remove_action( 'wp_head', 'wlwmanifest_link' ) ;
	remove_action( 'wp_head', 'rsd_link' );
	//移除多余rss
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	//添加评论NO html
	add_filter( 'pre_comment_content', 'wp_specialchars' );
	//Adminbar移除
	add_filter( 'show_admin_bar', '__return_false' );
	//添加登陆错误
	function login_erros_tips(){
		return '出现了很神奇的错误';
	}
	add_filter( 'login_errors', 'login_erros_tips' );

	/*---------------- [ 文章简介 ]------------------*/
	function posart_strimwidth($str ,$start , $width ,$trimmarker ){
		$output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
		return $output.$trimmarker;
	}
	/*---------------- [ 分页 ]------------------*/
	function posart_paging() {
		$p = 4;
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return;
		echo '<div id="pageNav"><div class="page-navigator">';
		if ( empty( $paged ) ) $paged = 1;
		echo '<li>'; previous_posts_link('上一页'); echo '</li>';

		if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li><span class=\"current\">{$i}</span><li>" : '<li>' . p_link( $i ) . '</li>';
		}
		if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
		echo '<li>'; next_posts_link('下一页'); echo '</li>';

		echo '</div></div>';
	}
	function p_link( $i, $title = '' ) {
		echo "<a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a>";
	}
	/*---------------- [ 取消WP默认jQuery ]------------------*/
	if ( !is_admin() ) {
		if ( $localhost == 0 ) {
			function my_init_method() {
				wp_deregister_script( 'jquery' );
			}
			add_action('init', 'my_init_method');
		}
	}
	/*---------------- [ 面包屑导航 ]------------------*/
    function posart_breadcrumbs(){
        return false;
    }

	/*---------------- [ 定义回复列表 ]------------------*/
	if ( ! function_exists( 'posart_comments' ) ) :
	function posart_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		global $commentcount;
		if(!$commentcount) {
		   $page = ( !empty($in_comment_loop) ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;
		   $cpp = get_option('comments_per_page');
		   $commentcount = $cpp * $page;
		}
	?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="cl comment">
				<header class="comment_meta_head comment-meta comment-author vcard">
					<?php
						echo get_avatar( $comment, 44 );
						printf( '<cite class="fn"><em class="authorname">%1$s</em>',
							get_comment_author_link() );
					?></cite>
				</header>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e('你的评论正在等待和谐审查','clrs'); ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
					<?php comment_text(); ?>
				</section>

				<footer>
					<?php
							printf( '<time datetime="%2$s">%3$s</time>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							sprintf( '%1$s at %2$s' , get_comment_date('Y/m/d'), get_comment_time('H:m') )
						);
						edit_comment_link('Edit', '<span class="edit-link">', '</span>' );
						comment_reply_link( array_merge( $args, array( 'reply_text' =>'Reply', 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
					?>
				</footer>

			</article>
		</li>
		<?php
	}
	endif;
