
jQuery(function($){
	$('#didyouknow-slidingbox').delay(10000).animate({left:0});
	
	$('#didyouknow-slidingbox .close').click(function(){
		$('#didyouknow-slidingbox').animate({left:-225});
	});
});