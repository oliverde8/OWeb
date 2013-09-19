
$(document).ready(function(){

	var headerAdded = new Array();
	
	var loadHeaderFile = function (filename){
		//First check if file already loaded
		for(var i=0; i<headerAdded.length; i++){
			if(headerAdded[i] == filename)
				return;
		}
		//Adding the file to the added Header files
		headerAdded[headerAdded.length] = filename;
		headerAdded.lenght++;

		//Checking header type
		var spl = filename.split('.');
		var filetype = spl[spl.length-1];

		//Adding header
		if (filetype=="js"){
			var fileref=document.createElement('script')
			fileref.setAttribute("type","text/javascript")
			fileref.setAttribute("src", filename)
		}
		else if (filetype=="css"){
			var fileref=document.createElement("link")
			fileref.setAttribute("rel", "stylesheet")
			fileref.setAttribute("type", "text/css")
			fileref.setAttribute("href", filename)
		}
		if (typeof fileref!="undefined")
			document.getElementsByTagName("head")[0].appendChild(fileref)
	}

	var unLoadHeaderFile = function (filename){
		$('link[href='+filename+']').remove();
	}

	var unLoadAllHeaderFiles = function(){
		for(var i=0; i<headerAdded.length; i++){
			unLoadHeaderFile(headerAdded[i]);
		}
		headerAdded.length = 0;
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

	var changePage = function (link, tete){
		//checking if link is internal or external
		if(checkIfInternal(link)){
			$.ajax({
				type: "GET",
				url: link + "&mode=API&plugin=Javascript\\ajaxPageLoader",
				dataType: "json",
				success: function(data) {
					var entetes = data;
					var title = "test";
					$.ajax({
						type: "GET",
						url: link + "&mode=Page",
						dataType: "txt",
						success: function(data) {
							$('#contenuFull').fadeOut('normal', function() {
								//On gere les entetes
								if(tete){
									unLoadAllHeaderFiles();
									$.each(entetes.entetes,function(key, val) {
										loadHeaderFile(val.url);
									});
								}
								$('#contenuFullJS').remove();
								$('#contenuFull').html('<div id="contenuFullJS">' + data + '</div>');
								//Changing link :
								if (typeof history.pushState === 'undefined') {

								}else if(tete){
									var state = {'url' : link};
									history.pushState(state, title, link);
								}

								$('#contenuFull').fadeIn('normal');
							});
						}
					})
				}
			})
			return false;
		}
	}

	$('a').click(function(){
		return changePage($(this).attr('href'), true);
	});

	window.onpopstate = function(e) {
		if (e.state != null && e.state.url){
			changePage(e.state.url, false);
		}
	}
})