$(document).ready(function(){

	$('.slideDownIcons').attr("data-state", 0);
	
	$('.slideDownIcons').mouseover(function () {
		
		var someelement = this;
		
		//if the icon will start to close soon, we wil cancel it
		clearTimeout($(this).data('data-timeoutId'));
		$(this).data('data-timeoutId', -1);
		
		
		//if it is currently closing we will stop it
		//if($(this).data('data-state') == 1){
			$(this).stop();
		//}
		
		//And we will make it open
		$(someelement).data('data-state', 2);
		$(this).animate({ top: -14 }, 500 , function(){ $(someelement).data('data-state', 3);});
	
	}).mouseout(function () {
		//if it is currently opening we will close id directyl without waiting.
		if($(this).data('data-state') == 2){
			$(this).stop();
			$(this).animate({ top: -45 });
		
		//if it has opened completely
		}else if($(this).data('data-state') == 3){		
			var someelement = this;
			
			//We wait a litle before starting to close
			if($(this).data('data-timeoutId') == -1){
				var timeoutId = setTimeout(function(){ 
													$(someelement).animate({ top: -45 });
												}, 1200);
				$(someelement).data('data-timeoutId', timeoutId);
			}
		}
		$(someelement).data('data-state', 1);

	})
	
	$('.slideRightIcons').attr("data-state", 0);
	
	$('.slideRightIcons').mouseover(function () {
		
		var someelement = this;
		
		//if the icon will start to close soon, we wil cancel it
		clearTimeout($(this).data('data-timeoutId'));
		$(this).data('data-timeoutId', -1);
		
		
		//if it is currently closing we will stop it
		//if($(this).data('data-state') == 1){
			$(this).stop();
		//}
		
		//And we will make it open
		$(someelement).data('data-state', 2);
		$(this).animate({ left : -35 }, 500 , function(){ $(someelement).data('data-state', 3);});
	
	}).mouseout(function () {
		//if it is currently opening we will close id directyl without waiting.
		if($(this).data('data-state') == 2){
			$(this).stop();
			$(this).animate({ left : -2 });
		
		//if it has opened completely
		}else if($(this).data('data-state') == 3){		
			var someelement = this;
			
			//We wait a litle before starting to close
			if($(this).data('data-timeoutId') == -1){
				var timeoutId = setTimeout(function(){ 
													$(someelement).animate({ left : -2 });
												}, 1200);
				$(someelement).data('data-timeoutId', timeoutId);
			}
		}
		$(someelement).data('data-state', 1);

	});
})
