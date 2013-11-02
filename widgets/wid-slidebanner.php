<?php  
add_action( 'widgets_init', 'd_slidebanners' );

function d_slidebanners() {
	register_widget( 'd_slidebanner' );
}

class d_slidebanner extends WP_Widget {
	function d_slidebanner() {
		$widget_ops = array( 'classname' => 'd_slidebanner', 'description' => '显示一组轮换广告' );
		$this->WP_Widget( 'd_slidebanner', 'D-轮换广告', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		
		$ctrl = $instance['ctrl'];
		$next = $instance['next'];
		$height = $instance['height'];
		$img1 = $instance['img1'];
		$img2 = $instance['img2'];
		$img3 = $instance['img3'];
		$img4 = $instance['img4'];
		$link1 = $instance['link1'];
		$link2 = $instance['link2'];
		$link3 = $instance['link3'];
		$link4 = $instance['link4'];

		echo $before_widget;
		echo '<div class="slider-wrap" style="height:'.$height.'px;"><ul class="slider-roll">';
				if($img1&&$link1) echo '<li class="item"><a href="'.$link1.'"><img src="'.$img1.'"></a></li>';
				if($img2&&$link2) echo '<li class="item"><a href="'.$link2.'"><img src="'.$img2.'"></a></li>';
				if($img3&&$link3) echo '<li class="item"><a href="'.$link3.'"><img src="'.$img3.'"></a></li>';
				if($img4&&$link4) echo '<li class="item"><a href="'.$link4.'"><img src="'.$img4.'"></a></li>';
		echo '</ul></div>';
		if($ctrl=='on'){
			echo '<ol class="slider-ctrl">';
				if($img1&&$link1) echo '<li>1</li>';
				if($img2&&$link2) echo '<li>2</li>';
				if($img3&&$link3) echo '<li>3</li>';
				if($img4&&$link4) echo '<li>4</li>';
			echo '</ol>';
		}
		if($next=='on') echo '<span class="slider-prev">&lt;</span><span class="slider-next">&gt;</span>';

		echo $after_widget;
	}

	function form($instance) {
	
?>
		<p>
			广告大小： 
			360px x 
			<input type="text"  id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" style="width:80px;"> px
			<br><br>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['ctrl'], 'on' ); ?> id="<?php echo $this->get_field_id('ctrl'); ?>" name="<?php echo $this->get_field_name('ctrl'); ?>">显示小标
			</label> &nbsp;&nbsp; 
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['next'], 'on' ); ?> id="<?php echo $this->get_field_id('next'); ?>" name="<?php echo $this->get_field_name('next'); ?>">启用左右切换
			</label>
		</p>
		<br>
		<p>
			<label>
				<b>01</b> 图片网址：
				<input id="<?php echo $this->get_field_id('img1'); ?>" name="<?php echo $this->get_field_name('img1'); ?>" type="text" value="<?php echo $instance['img1']; ?>" class="widefat" />
			</label>
			<label>
				<b>01</b> 链接地址：
				<input id="<?php echo $this->get_field_id('link1'); ?>" name="<?php echo $this->get_field_name('link1'); ?>" type="text" value="<?php echo $instance['link1']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				<b>02</b> 图片网址：
				<input id="<?php echo $this->get_field_id('img2'); ?>" name="<?php echo $this->get_field_name('img2'); ?>" type="text" value="<?php echo $instance['img2']; ?>" class="widefat" />
			</label>
			<label>
				<b>02</b> 链接地址：
				<input id="<?php echo $this->get_field_id('link2'); ?>" name="<?php echo $this->get_field_name('link2'); ?>" type="text" value="<?php echo $instance['link2']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				<b>03</b> 图片网址：
				<input id="<?php echo $this->get_field_id('img3'); ?>" name="<?php echo $this->get_field_name('img3'); ?>" type="text" value="<?php echo $instance['img3']; ?>" class="widefat" />
			</label>
			<label>
				<b>03</b> 链接地址：
				<input id="<?php echo $this->get_field_id('link3'); ?>" name="<?php echo $this->get_field_name('link3'); ?>" type="text" value="<?php echo $instance['link3']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				<b>04</b> 图片网址：
				<input id="<?php echo $this->get_field_id('img4'); ?>" name="<?php echo $this->get_field_name('img4'); ?>" type="text" value="<?php echo $instance['img4']; ?>" class="widefat" />
			</label>
			<label>
				<b>04</b> 链接地址：
				<input id="<?php echo $this->get_field_id('link4'); ?>" name="<?php echo $this->get_field_name('link4'); ?>" type="text" value="<?php echo $instance['link4']; ?>" class="widefat" />
			</label>
		</p>
		
<?php
	
	}
}

?>