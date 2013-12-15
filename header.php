<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if(is_home()) : { ?><title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title><?php ;} else : ?><title><?php wp_title(' - ', true, 'right'); ?> <?php bloginfo('name'); ?></title><?php endif; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
	<script src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">!window.jQuery && document.write('<script src="<?php bloginfo('template_url'); ?>/posart/jquery.min.js"><\/script>');</script>
	<script src="<?php bloginfo('template_url'); ?>/posart/jquery.masonry.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/posart/themes.js"></script>
	<?php wp_head(); ?>
</head>

<body>
	<div id="header">
		<ul class="z">
			<li><a class="main" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></li>
			<?php
				$header_menu = array(
					'theme_location' => 'header_menu',
					'container' => false,
					'items_wrap' => '%3$s',
					'fallback_cb' => 'posart_no_nav',
				);
				wp_nav_menu($header_menu);
			?>
		</ul>
		<ul class="y">
			<?php posart_sns(); ?>
			<form id="searchform" class="searchform" action="<?php bloginfo('url'); ?>" method="get" role="search">
				<input id="s" type="text" class="search-input" name="s" value="" placeholder="Search~" autocomplete="off">
			</form>
		</ul>
	</div>
	<div id="wrapper">
		<a href="<?php bloginfo('url'); ?>" class="header mhidden"><img src="<?php echo get_option('posart_logo'); ?>"></a>
		<div id="container" class="cl">