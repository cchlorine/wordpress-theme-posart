if($.browser.msie&&($.browser.version < "9.0")){
	$('html').addClass('ie');
}
$(document).ready(function(){
	$('.sidebar').masonry({ singleMode: true });
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
});