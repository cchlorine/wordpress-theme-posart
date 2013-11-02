<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if(is_home()) : { ?><title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title><?php ;} else : ?><title><?php wp_title(' - ', true, 'right'); ?> <?php bloginfo('name'); ?></title><?php endif; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
	<script src="http://libs.baidu.com/jquery/1.7.2/jquery.js"></script>
	<script type="text/javascript">!window.jQuery && document.write('<script src="<?php bloginfo('template_url'); ?>/images/jquery.min.js"><\/script>');</script>
	<script src="<?php bloginfo('template_url'); ?>/images/themes.js"></script>
	<?php wp_head(); ?>
</head>

<body>
	<div id="wrapper">
	<li class="menu_submain"><a class="ic ic-menu"></a></li>
	<nav class="menu_submenu">
		<ul>
        	<li class="nav nav-search">
            	<div class="search_container cl">
                <div class="ic z ic-search"></div>
				<form id="searchform" method="get" action="<?php bloginfo('url');?>">
                   	<input type="text" class="search" name="s" placeholder="Search" autocomplete="off">
					<input type="submit" id="searchsubmit" value="Search" style="display:none;">
                </form>
            </li>
			<li class="nav nav-about cl">
            	<div class="ic z ic-about"></div>
            	<a href="javascript:;" class="z">About</a>
            </li>
			<li class="nav nav-links cl">
            	<div class="ic z ic-links"></div>
            	<a href="javascript:;" class="z">Links</a>
			</li>
			<li class="nav nav-works cl">
				<div class="ic z ic-works"></div>
				<a href="javascript:;" class="z">Works</a>
			</li>
			<li class="nav nav-pixiv cl">
				<div class="ic z ic-pixiv"></div>
               	<a href="javascript:;" class="z">Pixiv</a>
			</li>
			<li class="nav nav-login cl">
				<div class="ic z ic-login"></div>
            	<a href="<?php bloginfo('url');?>/wp-admin" class="z">Login</a>
            </li>
        </ul>
	</nav>
	<div id="container" class="cl">