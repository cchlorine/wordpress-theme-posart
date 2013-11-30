<?php
function clrs_menu_function(){   
	add_theme_page('Posart 设置','Posart 设置','administrator','posart','posart_config');
}
add_action('admin_menu', 'clrs_menu_function');

function posart_config(){ ?>

<style type="text/css">
input[type="text"] { max-width: 510px; }
textarea { font-size: 14px; font-family: Consolas, monospace, sans-serif, sans; }
</style>

<h1>Posart 设置</h1>

<form method="post" name="posart_form" id="posart_form">
	<div id="up-div"></div>
	<p>
		<img src="<?php echo get_option('posart_logo'); ?>" style="margin-right:15px;float:left;max-width: 160px; -webkit-border-radius: 500px; -moz-border-radius: 500px; border-radius: 500px;" />
		<h2>Logo头像</h2>
		<input type="text" size="80" name="posart_logo" id="posart_logo" placeholder="<?php _e('粘贴链接或点击上传','clrs'); ?>" value="<?php echo get_option('posart_logo'); ?>"/>
		<input type="button" name="upload_button" value="上传" class="button" id="upbottom"/>
	</p>
	<div style="clear:both"></div>

	<?php wp_enqueue_script('thickbox'); wp_enqueue_style('thickbox'); ?>
	<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#upbottom').click(function() {
		targetfield = jQuery(this).prev('#clrs_logo');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery(targetfield).val(imgurl);
		tb_remove();
	}	
});
	</script>

	<h3>社交图标</h3>
	记得添加http://<br/><?php
	$posart_sns = array("sina","qzone","tqq","qq","renren","baidu");
	$posart_snsn = array("新浪微博","腾讯空间","腾讯微博","QQ号码","人人网","度娘");
	for ($i=0; $i<6; $i++) {
		$posart_sopt = 'posart_c_' . $posart_sns[$i];
		echo '<input type="text" size="80" name="' . $posart_sopt . '" id="' . $posart_sopt . '" placeholder="' . $posart_snsn[$i] . '" value="' . get_option($posart_sopt) . '"/>';
	}
	?></p>
	
	<h3>第三方统计</h3>
	<textarea name="posart_footer" rows="10" cols="60" placeholder="输入网站统计代码"><?php echo get_option('posart_footer'); ?></textarea><br>
	<p><input type="submit" name="option_save" class="button button-primary" value="保存设置" /></p>
	<?php wp_nonce_field('update-options'); ?>
	<input type="hidden" name="action" value="update" />
</form>

<?php }

if(isset($_POST['option_save'])){
	$posart_logo = stripslashes($_POST['posart_logo']);
	update_option( 'posart_logo', $posart_logo );
	$posart_footer = stripslashes($_POST['posart_footer']);
	update_option( 'posart_footer', $posart_footer );
	
	$posart_sns = array("sina","qzone","tqq","qq","renren","baidu");
	for ($i=0; $i<7; $i++) {
		$posart_sopt = 'posart_c_' . $posart_sns[$i];
		update_option( $posart_sopt, stripslashes($_POST[$posart_sopt]) );
	}
}

?>