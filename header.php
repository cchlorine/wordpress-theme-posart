<!DOCTYPE HTML>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php if(is_home()) : { ?><title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title><?php ;} else : ?><title><?php wp_title(' - ', true, 'right'); ?> <?php bloginfo('name'); ?></title><?php endif; ?>
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
	<?php wp_head(); ?>
</head>
<body>
	<!--[if lt IE 8]>
		<div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.</div>
	<![endif]-->
	<header id="header">
		<div class="nav-wrap">
			<nav id="navbar">
				<a class="main" href="<?php bloginfo('siteurl'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
				<?php
					$header_menu = array(
					'theme_location' => 'header_menu',
					'container' => false,
					'items_wrap' => '%3$s',
					'fallback_cb' => 'posart_no_nav',
					);
					wp_nav_menu($header_menu);
				?>
				<form action="./" method="post" role="search">
					<input id="s" type="text" class="search-input" name="s" placeholder="Keyword..." autocomplete="off"/>
				</form>
			</nav>
		</div>
		<hgroup id="logo">
			<h1><a class="main" href="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
			<h2><?php bloginfo('description'); ?></h2>
			<div class="background"></div>
		</hgroup>
	</header>

	<div id="wrapper">
		<div id="container">
