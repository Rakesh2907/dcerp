/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */

$(document).ready(function () {

	setTimeout(function(){
		var tab = $('input[name="active_tab"]').val();
		$('.nav-tabs a[href="#'+tab+'"]').tab('show');
	}, 900);
	
	$('[data-toggle="collapse"]').on('click', function() {
  		$(this).toggleClass('collapsed');
	});

	$('#pop_up_access_permission').on('submit', function(e){
			e.preventDefault();	
	}).validate({
		submitHandler: function(form) {
			var form_data = new FormData(form);
     	    var page_url = $(form).attr('action');
     	    $.ajax({
     	    	url: baseURL +""+page_url,
     	        headers: { 'Authorization': user_token },
     	        method: "POST",
     	        data: form_data,
     	        contentType:false,
     	        cache:false,
     	        processData:false,
     	        beforeSend: function () {
     	        	$("#user_access_permission").modal('hide');
     	        },
     	        success: function(result, status, xhr) {
     	        		 var res = JSON.parse(result);
     	        		  if(res.status == 'success')
     	        		  {
	     	        		  	swal({
	  										title: "",
	  										text: res.message,
	  										type: "success",
	  										timer:2000,
	  										showConfirmButton: false
								},function(){
										swal.close();
				               			load_page(res.redirect);
				               	});
     	        		  }else if(res.status == 'warning'){
	     					   		swal({
				               				title: "",
	  										text: res.message,
	  										type: "warning",
				               	    });
     					  }else if(res.status == 'error'){
	     					   		swal({
				               				title: "",
	  										text: res.message,
	  										type: "error",
				               	    });
     					  }
     	        }
     	    });
		}
	});


	$('#pop_up_parent_menu_edit').on('submit',function(e){
			e.preventDefault();
	}).validate({
		rules: {
			menu_name: {
				required: true,
	            minlength: 3,
	            lettersonly: false
			}
		},
		messages: {
			menu_name: {
	           required: "Please enter menu name"
	        }
		},
		submitHandler: function(form) {
			var form_data = new FormData(form);
     	    var page_url = $(form).attr('action');
     	    $.ajax({
     	    	url: baseURL +""+page_url,
     	        headers: { 'Authorization': user_token },
     	        method: "POST",
     	        data: form_data,
     	        contentType:false,
     	        cache:false,
     	        processData:false,
     	        beforeSend: function () {
     	        	 $("#edit_parent_menu").modal('hide');
     	        },
     	        success: function(result, status, xhr) {

     	        		  var res = JSON.parse(result);
     	        		  if(res.status == 'success')
     	        		  {
	     	        		  	swal({
	  										title: "",
	  										text: res.message,
	  										type: "success",
	  										timer:2000,
	  										showConfirmButton: false
								},function(){
										swal.close();
				               			load_page(res.redirect);
				               	});
     	        		  }else if(res.status == 'warning'){
	     					   		swal({
				               				title: "",
	  										text: res.message,
	  										type: "warning",
				               	    });
     					  }else if(res.status == 'error'){
	     					   		swal({
				               				title: "",
	  										text: res.message,
	  										type: "error",
				               	    });
     					  }
     	        }
     	    });
		}
	});

	$('#pop_up_parent_menu').on('submit',function(e){
			e.preventDefault();
	}).validate({
		rules: {
			menu_name: {
				required: true,
	            minlength: 3,
	            lettersonly: false
			}
		},
		messages: {
			menu_name: {
	           required: "Please enter menu name"
	        }
		},
		submitHandler: function(form) {
			var form_data = new FormData(form);
     	    var page_url = $(form).attr('action');
     	    $.ajax({
     	    	url: baseURL +""+page_url,
     	        headers: { 'Authorization': user_token },
     	        method: "POST",
     	        data: form_data,
     	        contentType:false,
     	        cache:false,
     	        processData:false,
     	        beforeSend: function () {
     	        	 $("#add_parent_menu").modal('hide');
     	        },
     	        success: function(result, status, xhr) {

     	        		  var res = JSON.parse(result);
     	        		  if(res.status == 'success')
     	        		  {
	     	        		  	swal({
	  										title: "",
	  										text: res.message,
	  										type: "success",
	  										timer:2000,
	  										showConfirmButton: false
								},function(){
										swal.close();
				               			load_page(res.redirect);
				               	});
     	        		  }else if(res.status == 'warning'){
	     					   		swal({
				               				title: "",
	  										text: res.message,
	  										type: "warning",
				               	    });
     					  }else if(res.status == 'error'){
	     					   		swal({
				               				title: "",
	  										text: res.message,
	  										type: "error",
				               	    });
     					  }
     	        }
     	    });
		}
	});


});

function sub_menu_details(menu_id){
	$.ajax({
		url: baseURL + "settings/sub_menu/"+menu_id,
		headers: { 'Authorization': user_token },
		contentType: "application/html",
	 	dataType: "html",
	 	beforeSend: function () {
	 		$("#collapse_"+menu_id+" .box-body").html('LOADNING...');
	 	},
	 	success: function (result, status, xhr) {
	 		
	 		$("#collapse_"+menu_id+" .box-body").html('');
	 		$("#collapse_"+menu_id+" .box-body").html(result);
	 	}
	});
}

function add_new_menu(){
	 $('#user_id > option').each(function() {
    	 $(this).prop("selected", false);
	 });
	 $("#add_parent_menu").modal('show');	
}

function add_new_sub_menu(menu_name,parent_id){
	 $('#user_id > option').each(function() {
    	 $(this).prop("selected", false);
	 });
	 $("#add_menu").html(menu_name);
	 $("input[name=parent_id]").val(parent_id);
	 $("#add_parent_menu").modal('show');
}

function edit_parent_menu(menu_id){
	  $.ajax({
		  	 	type: "POST",
		 		url: baseURL + "settings/get_menu_details",
		 		headers: { 'Authorization': user_token }, 
		 		data: 'menu_id='+menu_id,
		 		beforeSend: function () {
		 				swal.close();
		 		},
		 		success: function(result){
		 				var res = JSON.parse(result);
		 				//alert(res[0].menu_name);
		 				$("input[name=menu_name]").val(res[0].menu_name);
		 				$("input[name=menu_description]").val(res[0].menu_description);
		 				$("input[name=menu_links]").val(res[0].menu_links);
		 				$("input[name=menu_icon]").val(res[0].menu_icon);
		 				$("input[name=menu_id]").val(res[0].menu_id);
		 				$("select[name=sub_menu]").val(res[0].sub_menu);

		 				var selected_user = res[0].user_id;
		 				
		 				var usersArray = selected_user.split(',');

		 				$('#user_id > option').each(function() {
    							$(this).prop("selected", false);
						});
		 				$.each(usersArray, function(index, value) { 
  							$("#user_id option[value='" + value + "']").prop("selected", true);
						});

		  				$("#edit_parent_menu").modal('show');		
		 		}
	 });
}
function edit_sub_menu(menu_id){
	var menu_edit = edit_parent_menu(menu_id);
}
function remove_parent_menu(menu_id){

	swal({
	  		title: "Are you sure?",
	  		text: "You want to delete this parent menu?",
	  		type: "warning",
	  		showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true
	  },function(isConfirm){
	  	  if(isConfirm){
		  	 $.ajax({
		  	 	 	type: "POST",
		 			url: baseURL + "settings/remove_memu",
		 			headers: { 'Authorization': user_token }, 
		 			data: 'menu_id='+menu_id,
		 			beforeSend: function () {
		 				swal.close();
		 			},
		 			success: function(result){
		 				var res = JSON.parse(result);
		  					if(res.status == 'success'){
		  						 setTimeout(function(){
				                         swal({
				                                title: "",
				                                text: res.message,
				                                type: "success",
				                          },function(){
				                              load_page(res.redirect);
				                          });
				                  }, 300);
		  					}else if(res.status == 'warning'){
		  						 setTimeout(function(){
		                             swal({
					               				title: "",
		  										text: res.message,
		  										type: "warning",
					               	 });
	                     		 }, 300);
		  					}else if(res.status == 'error'){
		  						setTimeout(function(){
		                             swal({
					               				title: "",
		  										text: res.message,
		  										type: "error",
					               	 });
	                     		 }, 300);
		  					}
		 			}
		 	 });
		  }	 
	  });
 
}

function remove_sub_menu(menu_id){
	swal({
	  		title: "Are you sure?",
	  		text: "You want to delete this sub menu?",
	  		type: "warning",
	  		showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true
	  },function(isConfirm){
		  	if(isConfirm){
			  	 $.ajax({
			  	 	 	type: "POST",
			 			url: baseURL + "settings/remove_sub_memu",
			 			headers: { 'Authorization': user_token }, 
			 			data: 'menu_id='+menu_id,
			 			beforeSend: function () {
			 				swal.close();
			 			},
			 			success: function(result){
			 				var res = JSON.parse(result);
			  					if(res.status == 'success'){
			  						 setTimeout(function(){
					                         swal({
					                                title: "",
					                                text: res.message,
					                                type: "success",
					                          },function(){
					                              load_page(res.redirect);
					                          });
					                  }, 300);
			  					}else if(res.status == 'warning'){
			  						 setTimeout(function(){
			                             swal({
						               				title: "",
			  										text: res.message,
			  										type: "warning",
						               	 });
		                     		 }, 300);
			  					}else if(res.status == 'error'){
			  						setTimeout(function(){
			                             swal({
						               				title: "",
			  										text: res.message,
			  										type: "error",
						               	 });
		                     		 }, 300);
			  					}
			 			}
			 	 });
			} 	 
	  });
}

function access_permission(user_id,name){
	$('#access_keys > option').each(function() {
    		$(this).prop("selected", false);
	});
	$('.ms-options ul li input').each(function() {
    		$(this).prop("checked", false);
	});
	 $.ajax({
	 		type: "POST",
			url: baseURL + "user/get_user_details",
			headers: { 'Authorization': user_token }, 
			data: 'user_id='+user_id,
			beforeSend: function () {
			},
			success: function(result){
				$("#user_name").html(name);
				$("#emp_user_id").val(user_id);
				$("#user_access_permission").modal('show');	

				var res = JSON.parse(result);
				if(res.length > 0){
						$.each(res, function(index, value) { 
  							$("#access_keys > option[value='" + value + "']").prop("selected",true);
  							$(".ms-options ul li input[value='" + value + "']").trigger('click');
						});
				}
			}
	 });
}