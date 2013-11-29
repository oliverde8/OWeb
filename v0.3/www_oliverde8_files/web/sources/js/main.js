

$(document).ready(function(){
	
	console.log( $(contenuFull).height() );
	
	ResizeAndPositionElements();
	
	 $(window).resize(function(){
		ResizeAndPositionElements();
	});

});

function ResizeAndPositionElements(){
	$('#contenuFull > div > div').attr(
		'style','min-height: '+ ($(window).height()-$('#header').height() - 90)+'px'
	);
}

