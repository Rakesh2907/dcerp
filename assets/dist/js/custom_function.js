// load dynamic menu
function get_sub_menu(menu_id){
	 	$.ajax({
	 		url: baseURL + "commonrequesthandler_ui/sub_menu/"+menu_id,
	 		headers: { 'Authorization': user_token },
	 		contentType: "application/html",
	 		dataType: "html",
	 		success: function (result, status, xhr) {
	 			$(".treeview").removeClass('active');
	 			if($("#parent_id_"+menu_id).hasClass("menu-open")){	
	 				$("#parent_id_"+menu_id).append('');
	 				$("#treeview_perent_id_"+menu_id).remove();
	 				$("#parent_id_"+menu_id).append(result);
	 				$(".menu-open").addClass('active');
	 		    }else{
	 		    	$("#treeview_perent_id_"+menu_id).remove('slow');
	 		    }		
	 		}
	 	});
}
// load page
function load_page(page_url){
	if(page_url!=''){
	   $(".content-wrapper").LoadingOverlay("hide");  
		$.ajax({
			url: baseURL+""+page_url,
			headers: { 'Authorization': user_token },
	 		contentType: "application/html",
	 		dataType: "html",
	 		beforeSend: function () {
	 		  		//$(".content-wrapper").html('<div>Loading...!</div>');
	 		  		$(".content-wrapper").LoadingOverlay("show",{
	 		  			 image       : "",
    					 fontawesome : "fa fa-cog fa-spin"
	 		  		});
	 		},
	 		success: function (result, status, xhr) {
	 		   setTimeout(function(){
	 		        $(".content-wrapper").html('');
	 		   		$(".content-wrapper").html(result); 	
	 				$(".content-wrapper").LoadingOverlay("hide");
	 		   }, 1500);	
	 		}
		});
	}else{
		console.log('404 page not found...!');
	}
}

/* Get into full screen */
function GoInFullscreen(element) {
	if(element.requestFullscreen)
		element.requestFullscreen();
	else if(element.mozRequestFullScreen)
		element.mozRequestFullScreen();
	else if(element.webkitRequestFullscreen)
		element.webkitRequestFullscreen();
	else if(element.msRequestFullscreen)
		element.msRequestFullscreen();
}

/* Get out of full screen */
function GoOutFullscreen() {
	if(document.exitFullscreen)
		document.exitFullscreen();
	else if(document.mozCancelFullScreen)
		document.mozCancelFullScreen();
	else if(document.webkitExitFullscreen)
		document.webkitExitFullscreen();
	else if(document.msExitFullscreen)
		document.msExitFullscreen();
}

/* Is currently in full screen or not */
function IsFullScreenCurrently() {
	var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;
	
	// If no element is in full-screen
	if(full_screen_element === null)
		return false;
	else
		return true;
}

// Full screem
function go_full_screen()
{
	if(IsFullScreenCurrently()){
		GoOutFullscreen();
	}
	else{
		GoInFullscreen($("#element").get(0));
	}
}

function clear_cache(){
	$.ajax({
			url: baseURL+"settings/clear_cache",
			headers: { 'Authorization': user_token },
	 		contentType: "application/html",
	 		dataType: "html",
	 		beforeSend: function () {
	 		  		//$(".content-wrapper").html('<div>Loading...!</div>');
	 		  		$(".content-wrapper").LoadingOverlay("show",{
	 		  			 image       : "",
    					 fontawesome : "fa fa-cog fa-spin"
	 		  		});
	 		},
	 		success: function (result, status, xhr) {
	 		   		$(".content-wrapper").LoadingOverlay("hide");
	 		   		location.reload();
	 		}
	});
}