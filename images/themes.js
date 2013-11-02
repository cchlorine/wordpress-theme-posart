if($.browser.msie&&($.browser.version < "9.0")){
	$('html').addClass('ie');
}
$(document).ready(function(){
	$('.nopa').addClass('opa');
	$(window).scroll(function(){
		if($(window).scrollTop()>=200)
		{
			$('#totop').slideDown(200);
		}
		else
		{
			$('#totop').slideUp(200);
		}
	});

	$('#totop').click(function(){
		$('body,html').animate({scrollTop:0},300);
	});
	if($(window).width() > 480){
		$('.menu_submenu').addClass('menu_thin');
		$('.menu_submain').animate({'left':'61px'});
	}
	$('.menu_submain').click(
		function(event){
			event.stopPropagation();
			if ($('.menu_submenu').hasClass('menu_fat')) {
				$('.menu_submenu').removeClass('menu_fat');
				$('.menu_submain').animate({'left':'0'});
				$('.menu_submain .ic').removeClass('ic-menu-color');
			}
			else {
				if($(window).width() > 480){ $('.menu_submain').animate({'left':'250px'}); } else { $('.menu_submain').animate({'left':'150px'}); }
				$('.menu_submenu').addClass('menu_fat');
				$('.menu_submain .ic').addClass('ic-menu-color');	
			}
		}
	);
	$('.menu_submenu').mouseenter(
		function(event){
			event.stopPropagation();
			if($(window).width() > 480){ $('.menu_submain').animate({'left':'250px'}); } else { $('.menu_submain').animate({'left':'150px'}); }
			$(this).addClass('menu_fat');
			$('.menu_submain .ic').addClass('ic-menu-color');	
		}
	);
	$('.menu_submenu').click(
		function(event){
			event.stopPropagation();
		}
	);
	$(document).click(
		function(){
			$('.menu_submenu').removeClass('menu_fat');	
			if($(window).width() > 480){ $('.menu_submain').animate({'left':'61px'}); } else { $('.menu_submain').animate({'left':'0'}); }
			$('.menu_submain .ic').removeClass('ic-menu-color');
		}
	);
});