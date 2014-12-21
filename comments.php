<?php
if ( post_password_required() )
	return;
?>
<?php


$smile = '<p><a href="javascript:grin(\':?:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_question.gif" alt="" /></a>
	<a href="javascript:grin(\':razz:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_razz.gif" alt="" /></a>
	<a href="javascript:grin(\':sad:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_sad.gif" alt="" /></a>
	<a href="javascript:grin(\':evil:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_evil.gif" alt="" /></a>
	<a href="javascript:grin(\':!:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_exclaim.gif" alt="" /></a>
	<a href="javascript:grin(\':smile:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_smile.gif" alt="" /></a>
	<a href="javascript:grin(\':oops:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_redface.gif" alt="" /></a>
	<a href="javascript:grin(\':grin:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_biggrin.gif" alt="" /></a>
	<a href="javascript:grin(\':eek:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_surprised.gif" alt="" /></a>
	<a href="javascript:grin(\':shock:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_eek.gif" alt="" /></a>
	<a href="javascript:grin(\':???:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_confused.gif" alt="" /></a>
	<a href="javascript:grin(\':cool:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_cool.gif" alt="" /></a>
	<a href="javascript:grin(\':lol:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_lol.gif" alt="" /></a>
	<a href="javascript:grin(\':mad:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_mad.gif" alt="" /></a>
	<a href="javascript:grin(\':twisted:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_twisted.gif" alt="" /></a>
	<a href="javascript:grin(\':roll:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_rolleyes.gif" alt="" /></a>
	<a href="javascript:grin(\':wink:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_wink.gif" alt="" /></a>
	<a href="javascript:grin(\':idea:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_idea.gif" alt="" /></a>
	<a href="javascript:grin(\':arrow:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_arrow.gif" alt="" /></a>
	<a href="javascript:grin(\':neutral:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_neutral.gif" alt="" /></a>
	<a href="javascript:grin(\':cry:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_cry.gif" alt="" /></a>
	<a href="javascript:grin(\':mrgreen:\')"><img src="' . get_bloginfo('url') . '/wp-includes/images/smilies/icon_mrgreen.gif" alt="" /></a>
</p>';
?>
<div id="comments" class="comments-area">
	<div class="cl"><?php $comments_args = array(
	  'id_form'           => 'comments_form',
	  'id_submit'         => 'comments_submit',
	  'title_reply'       => '',
	  'title_reply_to'    => '回复',
	  'cancel_reply_link' => '放弃回复',
	  'label_submit'      => '发送',

	  'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" required aria-required="true">'.
		'</textarea></p>' . $smile,

	  'must_log_in' => '<p class="must-log-in">' .
		sprintf(
		  __( '你必须 <a href="%s">登录</a> 后吐槽。' , 'clrs' ),
		  wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		) . '</p>',

	  'logged_in_as' => '<p class="logged-in-as">' .
		sprintf(
		__('以 <a href="%1$s">%2$s</a> 登录。 <a href="%3$s" title="Log out of this account">退出</a>','clrs'),
		  admin_url( 'profile.php' ),
		  $user_identity,
		  wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
		) . '</p>',

	  'comment_notes_before' => '',

	  'comment_notes_after' => '',

	  'fields' => apply_filters( 'comment_form_default_fields', array(

		'author' =>
		  '<div id="comments_meta"><input placeholder="称呼" id="author" name="author" type="text" required="required" value="' . esc_attr( $commenter['comment_author'] ) .
		  '" />',

		'email' =>
		  '<input placeholder="邮箱" id="email" name="email" type="email" required="required" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		  '" />',

		'url' =>
		  '<input placeholder="站点" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		  '" /></div>'
		)
	  ),
	);  comment_form($comments_args); ?></div>
	<?php if ( have_comments() ) : ?>
		<ol class="comment-list">
			<?php wp_list_comments('callback=posart_comments&avatar_size=48&type=comment'); ?>
		</ol>
		<?php
		if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="nocomments">和谐，不要回复~</p>
		<?php endif; ?>
		<nav id="comments-nav" class="pagination" role="navigation">
			<?php if ( get_comment_pages_count() > 1 ): ?>
			<?php paginate_comments_links('prev_text=上一页&next_text=下一页');?>
			<?php endif; ?>
		</nav>

	<?php endif;?>
</div>
