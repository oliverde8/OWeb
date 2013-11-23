
var oweb_dynamicJsLoader = function(){
	
	var headerAdded = new Array();
	
	var loadHeaderFile = function (key, code){
		//First check if file already loaded
		if(headerAdded[key] != "undefined"){
			unLoadHeaderFile(key);
		}

		//Adding the file to the added Header files
		headerAdded[key] = code;

		$('head').append(code);
	}

	var unLoadHeaderFile = function (id){
		$('#'+id).remove();
	}

	var unLoadAllHeaderFiles = function(){
		for(var i in headerAdded) {
			unLoadHeaderFile(i);
		}
		headerAdded = new Array();
	}

	var checkIfInternal = function (link){
		var toFind = new Array(new Array("www", "http://"), new Array("http://"));

		for(var i=0; i<toFind.length; i++){
			var ok = true;
			for(var j=0; j<toFind[i].length; j++){
				if(link.search(toFind[i][j])==-1){
					ok = false;
				}
			}
			if(ok){
				return false;
			}
		}
		return true;
	}

	var OWeb_ChangePage = function (link, tete){
		//checking if link is internal or external

		if(checkIfInternal(link)){
			var tlinkk;
			if(link.indexOf("?") == -1)
				tlink = link + "?mode=API&ext=contentDisplay\\dynamicJsLoader&action=get";
			else
				tlink = link + "&mode=API&ext=contentDisplay\\dynamicJsLoader&action=get";
			
			$.ajax({
				type: "GET",
				url: tlink,
				dataType: "json",
				success: function(data) {
					var header = data["headers"];
					var content = data["content"];
					
					 $("#contenuFullJS").hide('drop', function() {
						//On gere les entetes						
						if(tete){
							unLoadAllHeaderFiles();
							$.each(header,function(key, val) {

								loadHeaderFile(key, val);
							});
						}
						$('#contenuFullJS').remove();
						$('#contenuFull').html('<div id="contenuFullJS">' + content + '</div>');
						//Changing link :
						if (typeof history.pushState === 'undefined') {

						}else if(tete){
							var state = {'url' : link};
							title = "Test";
							history.pushState(state, title, link);
						}
						
						$('#contenuFull').show('drop');
						
						if ( typeof oweb_ready == 'function' ) {
							oweb_ready(); 
						}
						oweb_dynamicJsLoader();
						
					});
				}
			})

			return false;
		}
	}

	$('a').click(function(){
		$('a').unbind( "click" );
		return OWeb_ChangePage($(this).attr('href'), true);
	});

	window.onpopstate = function(e) {
		if (e.state != null && e.state.url){
			OWeb_ChangePage(e.state.url, false);
		}
	}
}

$(document).ready(function(){
	oweb_dynamicJsLoader();
})

