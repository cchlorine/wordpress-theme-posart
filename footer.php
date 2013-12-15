			<div class="body sidebar"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('底部通用') ) : ?>
			<?php endif; ?></div>
		</div>	
		<div class="site-footer" role="contentinfo">
			<p>Copyright © 2013 <?php bloginfo('name'); ?> | Theme Posart Design By <a href="http://www.dsu.pw">Goy</a> |
			Powered <a href="http://wordpress.org"> Wordpress!</a> <?php echo get_option('posart_footer'); ?></p>
		</div>
		<div id="rightmenu">
			<!-- Baidu Button BEGIN -->
			<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
			<a class="bds_more"></a>
			</div>
			<script type="text/javascript" id="bdshare_js" data="type=tools" ></script>
			<script type="text/javascript" id="bdshell_js"></script>
			<script type="text/javascript">document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);</script>
			<!-- Baidu Button END -->
			<?php if(is_single() || is_page()) { ?><a href="javascript:;" class="tocomments"></a> <?php } ?>
			<a href="javascript:;" class="totop"></a>
		</div>
	</div>
	<?php wp_footer(); ?>
	</div>
</body>
</html>