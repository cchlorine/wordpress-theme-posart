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
	/*---------------- [ 主题更新检查 ]------------------*/
	require_once(TEMPLATEPATH . '/posart/theme-update-checker.php'); 
	$wpdaxue_update_checker = new ThemeUpdateChecker(
		'PosArt',
		'http://lab.dsu.pw/works/posart/info.json'
	);
	/*---------------- [ AJAX评论 ]------------------*/
	add_action('init', 'ajax_comment');
	function ajax_comment(){
		if($_POST['action'] == 'ajax_comment' && 'POST' == $_SERVER['REQUEST_METHOD']){
			global $wpdb;
			nocache_headers();
			$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;

			$post = get_post($comment_post_ID);

			if ( empty($post->comment_status) ) {
				do_action('comment_id_not_found', $comment_post_ID);
				ajax_comment_err(__('Invalid comment status.')); // 將 exit 改為錯誤提示
			}

			// get_post_status() will get the parent status for attachments.
			$status = get_post_status($post);

			$status_obj = get_post_status_object($status);

			if ( !comments_open($comment_post_ID) ) {
				do_action('comment_closed', $comment_post_ID);
				ajax_comment_err(__('Sorry, comments are closed for this item.')); // 將 wp_die 改為錯誤提示
			} elseif ( 'trash' == $status ) {
				do_action('comment_on_trash', $comment_post_ID);
				ajax_comment_err(__('Invalid comment status.')); // 將 exit 改為錯誤提示
			} elseif ( !$status_obj->public && !$status_obj->private ) {
				do_action('comment_on_draft', $comment_post_ID);
				ajax_comment_err(__('Invalid comment status.')); // 將 exit 改為錯誤提示
			} elseif ( post_password_required($comment_post_ID) ) {
				do_action('comment_on_password_protected', $comment_post_ID);
				ajax_comment_err(__('Password Protected')); // 將 exit 改為錯誤提示
			} else {
				do_action('pre_comment_on_post', $comment_post_ID);
			}

			$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
			$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
			$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
			$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
			$edit_id              = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取 edit_id

			// If the user is logged in
			$user = wp_get_current_user();
			if ( $user->exists() ) {
				if ( empty( $user->display_name ) )
					$user->display_name=$user->user_login;
				$comment_author       = $wpdb->escape($user->display_name);
				$comment_author_email = $wpdb->escape($user->user_email);
				$comment_author_url   = $wpdb->escape($user->user_url);
				if ( current_user_can('unfiltered_html') ) {
					if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
						kses_remove_filters(); // start with a clean slate
						kses_init_filters(); // set up the filters
					}
				}
			} else {
				if ( get_option('comment_registration') || 'private' == $status )
					ajax_comment_err(__('Sorry, you must be logged in to post a comment.')); // 將 wp_die 改為錯誤提示
			}

			$comment_type = '';

			if ( get_option('require_name_email') && !$user->exists() ) {
				if ( 6 > strlen($comment_author_email) || '' == $comment_author )
					ajax_comment_err( __('Error: please fill the required fields (name, email).') ); // 將 wp_die 改為錯誤提示
				elseif ( !is_email($comment_author_email))
					ajax_comment_err( __('Error: please enter a valid email address.') ); // 將 wp_die 改為錯誤提示
			}

			if ( '' == $comment_content )
				ajax_comment_err( __('Error: please type a comment.') ); // 將 wp_die 改為錯誤提示


			// 增加: 檢查重覆評論功能
			$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
			if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
			$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
			if ( $wpdb->get_var($dupe) ) {
				ajax_comment_err(__('Duplicate comment detected; it looks as though you&#8217;ve already said that!'));
			}

			// 增加: 檢查評論太快功能
			if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) { 
			$time_lastcomment = mysql2date('U', $lasttime, false);
			$time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
			$flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
			if ( $flood_die ) {
				ajax_comment_err(__('You are posting comments too quickly.  Slow down.'));
				}
			}

			$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;

			$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

			// 增加: 檢查評論是否正被編輯, 更新或新建評論
			if ( $edit_id ){
				$comment_id = $commentdata['comment_ID'] = $edit_id;
				wp_update_comment( $commentdata );
			} else {
				$comment_id = wp_new_comment( $commentdata );
			}

			$comment = get_comment($comment_id);
			do_action('set_comment_cookies', $comment, $user);

			$comment_depth = 1;   //为评论的 class 属性准备的
			$tmp_c = $comment;
			while($tmp_c->comment_parent != 0){
				$comment_depth++;
				$tmp_c = get_comment($tmp_c->comment_parent);
			}
			
			//此处非常必要，无此处下面的评论无法输出 by mufeng
			$GLOBALS['comment'] = $comment;
			
			//以下是評論式樣, 不含 "回覆". 要用你模板的式樣 copy 覆蓋.
			?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="cl comment">
					<header class="comment_meta_head comment-meta comment-author vcard">
						<?php
							echo get_avatar( $comment, 44 );
							printf( '<cite class="fn"><em class="authorname">%1$s</em>',
								get_comment_author_link() );
							printf( '<time datetime="%2$s">%3$s</time>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								sprintf( '%1$s at %2$s' , get_comment_date('Y/m/d'), get_comment_time('H:m') )
							);
						?></cite>
					</header>

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e('你的评论正在等待和谐审查','clrs'); ?></p>
					<?php endif; ?>

					<section class="comment-content comment">
						<?php comment_text(); ?>
					</section>

				</article>

			<?php die(); //以上是評論式樣, 不含 "回覆". 要用你模板的式樣 copy 覆蓋.
		}else{return;}
	}
	function ajax_comment_err($a) { 
		header('HTTP/1.0 500 Internal Server Error');
		header('Content-Type: text/plain;charset=UTF-8');
		echo $a;
		exit;
	}
	/*---------------- [ 禁止日文英文评论 ]------------------*/
	function comment_post_ad_get_out( $incoming_comment ) {
		$pattern = '/[一-龥]/u';
		$jpattern ='/[ぁ-ん]+|[ァ-ヴ]+/u';
		if(!preg_match($pattern, $incoming_comment['comment_content'])) {
			ajax_comment_err( "写点汉字吧，博主外语很捉急！ Please write some chinese words！" );
		}
		if(preg_match($jpattern, $incoming_comment['comment_content'])){
			ajax_comment_err( "日文滚粗！Japanese Get out！日本語出て行け！" );
		}
		return( $incoming_comment );
	}
	add_filter('preprocess_comment', 'comment_post_ad_get_out');
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
		echo '<div id="posts-nav" class="pagination">';
		if ( empty( $paged ) ) $paged = 1;
		previous_posts_link('上一页');

		if ( $paged > $p + 2 ) echo "<span>···</span>";
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class=\"current\">{$i}</span>" : p_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo "<span> ... </span>";
		next_posts_link('下一页');
		echo '</div>';
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
        global $wp_query;
        if ( !is_home() ){
            echo '<ul class="breadcrumb">';
            echo '<li><a href="'. get_settings('home') .'">'. 首页 .'</a> <span class="divider">/</span></li>';
            if ( is_category() ){
                $catTitle = single_cat_title( "", false );
                $cat = get_cat_ID( $catTitle );
                echo "<li class='active'> ". get_category_parents( $cat, TRUE, " <span class='divider'>/</span>  " ) ."</li>";
            }
            elseif ( is_archive() && !is_category() ){
                echo "<li class='active'> Archives</li>";
            }
            elseif ( is_search() ){
                echo "<li class='active'> Search Results</li>";
            }
            elseif ( is_404() ){
                echo "<li class='active'> 404 Not Found</li>";
            }
            elseif ( is_single() ){
                $category = get_the_category();
                $category_id = get_cat_ID( $category[0]->cat_name );
                echo '<li> '. get_category_parents( $category_id, TRUE, " <span class='divider'>/</span> " );
                echo "<li class='active'>".the_title('','', FALSE) ."</li>";
            }
            elseif ( is_page() ){
                $post = $wp_query->get_queried_object();
                if ( $post->post_parent == 0 ){
                    echo "<li> ".the_title('','', FALSE)."</li>";
                } else {
                    $title = the_title('','', FALSE);
                    $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
                    array_push($ancestors, $post->ID);
      
                    foreach ( $ancestors as $ancestor ){
                        if( $ancestor != end($ancestors) ){
                            echo '<li> <a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a> <span class="divider">/</span></li>';
                        } else {
                            echo '<li> '. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</li>';
                        }
                    }
                }
            }
            echo "</ul>";
        }
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
						printf( '<time datetime="%2$s">%3$s</time>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							sprintf( '%1$s at %2$s' , get_comment_date('Y/m/d'), get_comment_time('H:m') )
						);
						edit_comment_link('Edit', '<span class="edit-link">', '</span>' );
						comment_reply_link( array_merge( $args, array( 'reply_text' =>'Reply', 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
					?></cite>
					<span class="y comment-floor">
						<?php 
							++$commentcount;
							switch($commentcount){
								case 1:
									print_r("沙发");
									break;
								case 2:	
									print_r("板凳");
									break;	
								case 3:	
									print_r("地板");
									break;		
								default:
									printf(__('%s楼'), $commentcount);
							}
						?>
					</span>
				</header>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e('你的评论正在等待和谐审查','clrs'); ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
					<?php comment_text(); ?>
				</section>

			</article>
		</li>
		<?php
	}
	endif;
?>