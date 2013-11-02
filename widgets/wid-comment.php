<?php  
add_action( 'widgets_init', 'comments' );

function comments() {
	register_widget( 'comment' );
}

class comment extends WP_Widget {
	function comment() {
		$widget_ops = array( 'classname' => 'comment', 'description' => '显示网友最新评论（头像+名称+评论）' );
		$this->WP_Widget( 'comment', '最新评论', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = $instance['title'] ? apply_filters('widget_name', $instance['title']) : '最新评论';
		$limit = $instance['limit'];

		echo $before_widget;
		echo $before_title.$mo.$title.$after_title; 
		echo '<ul>';
		echo newcomments($limit);
		echo '</ul>';
		echo $after_widget;
	}

	function form($instance) {
?>
		<p>
			<label>
				标题：
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
			</label>
		</p>
<?php
	}
}

function newcomments( $limit ){
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, comment_content AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND comment_author != 'zwwooooo' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit" ;
	$comments = $wpdb->get_results($sql);
	foreach ( $comments as $comment ) {
		$output .= '<li><a href="'.get_permalink($comment->ID).'#comment-'.$comment->comment_ID.'" title="'.$comment->post_title.'上的评论">'.get_avatar( $comment->comment_author_email, $size = '36' , avatar_default() ).'<strong>'.strip_tags($comment->comment_author).'：</strong>'.strip_tags($comment->com_excerpt).'</a></li>';
	}
	$output = convert_smilies($output);
	return $output;
};

?>