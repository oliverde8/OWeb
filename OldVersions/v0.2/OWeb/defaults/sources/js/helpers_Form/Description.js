$(document).ready(function(){

	$('.OWebForm_description_icone').css('display', 'block');
	$('.OWebForm_description').css('display', 'block').hide();

	$('.OWebForm_description_icone').click(function(){
		if( $(this).parent().next().is(':visible') )
			$(this).parent().next().fadeOut();
		else {
			$('.OWebForm_description').hide();
			$(this).parent().next().fadeIn();
		}
	});

	 
});
