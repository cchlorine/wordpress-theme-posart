<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if(is_home()) : { ?><title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title><?php ;} else : ?><title><?php wp_title(' - ', true, 'right'); ?> <?php bloginfo('name'); ?></title><?php endif; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
	<script src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">!window.jQuery && document.write('<script src="<?php bloginfo('template_url'); ?>/images/jquery.min.js"><\/script>');</script>
	<script src="<?php bloginfo('template_url'); ?>/images/jquery.masonry.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/images/themes.js"></script>
	<?php wp_head(); ?>
</head>

<body>
	<div id="wrapper">

	<div id="container" class="cl">