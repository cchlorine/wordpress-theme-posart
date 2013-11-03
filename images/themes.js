if($.browser.msie&&($.browser.version < "9.0")){
	$('html').addClass('ie');
}
$(document).ready(function(){
	$('.nopa').addClass('opa');
	arrivedAtBottom = $(window).scrollTop() >= $(document).height() - $(window).height() - 30;
	$(window).scroll(function(event){
		event.stopPropagation();
		arrivedAtBottom = $(window).scrollTop() >= $(document).height() - $(window).height() - 30;
		if (arrivedAtBottom) {
			$('.totop').removeClass("go_bottom");
			$('.totop').addClass("go_top");
		} 
		else {
			$('.totop').removeClass("go_top");
			$('.totop').addClass("go_bottom");
		}
	});
	$('.totop').click(function(){
		if (arrivedAtBottom) {
			$('html,body').animate({scrollTop: 0}, 500);
		} else {
			$('html,body').animate({scrollTop: $(document).height() - $(window).height()}, 500);	
		}
	});
	$('.tocomments').click(function(){
		$('html,body').animate({scrollTop: $(".comments").offset().top - 40}, 500);
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