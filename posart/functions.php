<?php
	/*---------------- [分页]------------------*/
	function paging() {
		$p = 4;
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; 
		echo '<div class="pagination"><ul>';
		if ( empty( $paged ) ) $paged = 1;
		// echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
		echo '<li>'; previous_posts_link('上一页'); echo '</li>';

		if ( $paged > $p + 1 ) p_link( 1, '<li>第一页</li>' );
		if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
		//if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
		echo '<li>'; next_posts_link('下一页'); echo '</li>';
		// echo '<li><span>共 '.$max_page.' 页</span></li>';
		echo '</ul></div>';
	}
	function p_link( $i, $title = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
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
    function get_breadcrumbs(){
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
	/*---------------- [ 获取缩略图 ]------------------*/
    add_theme_support( 'post-thumbnails' );
    function post_thumbnail( $width = 100,$height = 80 , $extraClass="" ,$moreInfo = "" ){
        global $post;
        if( has_post_thumbnail() ) {    //如果有缩略图，则显示缩略图
            $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
             $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb.php?src='.$timthumb_src[0].'&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1" alt="'.$post->post_title.'" class="' . $extraClass.'"  height="'.$height.'" width="'.$width.'" '.$moreInfo.' />';
            echo $post_timthumb;
        } else  {
            $post_timthumb = '';
            ob_start();
            ob_end_clean();
            $output = preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $index_matches);    //获取日志中第一张图
            $first_img_src = $index_matches [1];    //获取该图src
            if( !empty($first_img_src) ){    //如果日志中有图片
                $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb.php?src='.$first_img_src.'&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1" alt="'.$post->post_title.'" class="' . $extraClass.'"   height="'.$height.'" width="'.$width.'" '.$moreInfo.' />';
            } else {    //如果日志中没有图片，则显示默认
                 $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb.php?src='.get_bloginfo("template_url").'/images/thumbnail.png&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1" alt="'.$post->post_title.'" class="' . $extraClass.'"   height="'.$height.'" width="'.$width.'" '.$moreInfo.' />';
            }
            echo $post_timthumb;
        }
    };
?>