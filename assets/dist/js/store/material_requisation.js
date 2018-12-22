$(document).ready(function(){
	 $('.select2').select2();
     // Pending list
	 var table_material_req = $('#material_req_list').DataTable({
	            'columnDefs': [{
	               'targets': 0,
	               'searchable':false,
	               'orderable':false,
	               'className': 'dt-body-center',
	               'render': function (data, type, full, meta){
	                    return data;
	                   //return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
	               }
	            }],
	            'order': [2, 'asc']
	 });

	  $('#material_req_list-select-all').on('click', function(){
	        	var rows = table_material_req.rows({ 'search': 'applied' }).nodes();
	        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	  });

	  $('#material_req_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#material_req_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
		        }
	  });

	  $('#material_req_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_material_req.row( tr );
             var req_id = tr.attr('data-row-id');

             if (row.child.isShown()) {
             	row.child.hide();
            	tr.removeClass('shown');
            	$(".details-control-"+req_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
             }else{
                material_requested(req_id,row,'pending');   
	            tr.addClass('shown');
	            $(".shown .details-control-"+req_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
             }
	  });

      // Approved list
	   var table_material_req_approved = $('#approved_material_req_list').DataTable({
	            'columnDefs': [{
	               'targets': 0,
	               'searchable':false,
	               'orderable':false,
	               'className': 'dt-body-center',
	               'render': function (data, type, full, meta){
	                    return data;
	                   //return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
	               }
	            }],
	            'order': [2, 'asc']
	   });

	  $('#approved_material_req_list-select-all').on('click', function(){
	        	var rows = table_material_req_approved.rows({ 'search': 'applied' }).nodes();
	        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	  });

	  $('#approved_material_req_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#approved_material_req_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
		        }
	  });

	  $('#approved_material_req_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_material_req_approved.row( tr );
             var req_id = tr.attr('data-row-id');

             if (row.child.isShown()) {
             	row.child.hide();
            	tr.removeClass('shown');
            	$(".details-control-"+req_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
             }else{
                material_requested(req_id,row,'approved');   
	            tr.addClass('shown');
	            $(".shown .details-control-"+req_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
             }
	  });

	  // Completed List 

	  var table_material_req_completed = $('#completed_material_req_list').DataTable({
	            'columnDefs': [{
	               'targets': 0,
	               'searchable':false,
	               'orderable':false,
	               'className': 'dt-body-center',
	               'render': function (data, type, full, meta){
	                    return data;
	                   //return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
	               }
	            }],
	            'order': [2, 'asc']
	   });

	  $('#completed_material_req_list-select-all').on('click', function(){
	        	var rows = table_material_req_completed.rows({ 'search': 'applied' }).nodes();
	        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	  });

	  $('#completed_material_req_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#completed_material_req_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
		        }
	  });

	  $('#completed_material_req_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_material_req_completed.row( tr );
             var req_id = tr.attr('data-row-id');

             if (row.child.isShown()) {
             	row.child.hide();
            	tr.removeClass('shown');
            	$(".details-control-"+req_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
             }else{
                material_requested(req_id,row,'completed');   
	            tr.addClass('shown');
	            $(".shown .details-control-"+req_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
             }
	  });

	 var table_material = $('#material_list_pop_up').DataTable({
            'columnDefs': [{
               'targets': 0,
               'searchable':false,
               'orderable':false,
               'className': 'dt-body-center',
               'render': function (data, type, full, meta){
                   return data;
               }
            }],
            'order': [1, 'asc'],
            "pageLength": 50
     });


	 $("#browse_material").on('click', function(){
	 	  $("#assign_material_requisation").modal('show');
	 });

	 $("#material_select").on('click',function(){
	 		 var allMat = [];
		 $(".sub_chk:checked").each(function() {  
	          		allMat.push($(this).attr('data-id'));
	     });

		 var action_form = $(this).attr('data-action');
		 var req_id = $(this).attr('data-req');


		 var req_given_by = $("#req_given_by").val();
		 var approval_assign_by = $("#approval_assign_by").val();
		 var req_date = $("#req_date").val();
		 var dep_id = $("#dep_id").val();

		 if(allMat.length <=0){
	 	  		swal({
  					title: "",
  					text: "Please select materials.",
  					type: "warning",
			    });
	 	  }else{
	 	  		 var join_selected_values = allMat.join(","); 
	 	  		 $.ajax({
	 	  		 	type: "POST",  
				    url: baseURL +"store/selected_material_requisation",
				    headers: { 'Authorization': user_token },
				    cache: false,
				    data: 'mat_ids='+join_selected_values+'&req_id='+req_id+'&action='+action_form+'&req_given_by='+req_given_by+'&approval_assign_by='+approval_assign_by+'&req_date='+req_date+'&dep_id='+dep_id, 
				    success: function(result, status, xhr){
				    	var res = JSON.parse(result);
				    	$("#assign_material_requisation").modal('hide');
     					if(res.status == 'success'){
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
				    	}else if(res.status == 'error'){
				    		swal({
				               				title: "",
	  										text: res.message,
	  										type: "error",
				            });
				    	}else if(res.status == 'warning'){
				    		swal({
				               				title: "",
	  										text: res.message,
	  										type: "warning",
				            });
				    	}
				    } 
	 	  		});
	 	  }		 
	 });

	 

	 $('#material_requisation_form').on('submit',function(e){
	 		e.preventDefault();
	 }).validate({
	 		rules: {
	 			req_date : {
	 				required: true
	 			},
	 			req_given_by: {
	 				required: true
	 			},
	 			approval_assign_by: {
	 				required: true
	 			},
	 			dep_id: {
	 				required: true
	 			}
	 		},
	 		messages: {
	 			req_date : {
	 				required : 'Please select requisation date'
	 			},
	 			dep_id: {
	 				required : 'Please select department'
	 			}
	 		},
	 		submitHandler: function(form) {
     			var form_data = new FormData(form);
     			form_data.append('dep_id', $("#dep_id").val());
     			form_data.append('req_given_by', $("#req_given_by").val());
     			form_data.append('approval_assign_by', $("#approval_assign_by").val());

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
		     					//$(".content-wrapper").LoadingOverlay("show");
	     			},
	     			success: function(result, status, xhr) {
     					var res = JSON.parse(result);
     					if(res.status == 'success'){
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

	 $('[name^="require_qty"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

	 $('[name^="require_date"]').each(function() {
        $(this).rules('add', {
            required: true
        })
     });

	 $('#material_note_form').on('submit',function(e){
	 		e.preventDefault();
	 }).validate({
	 	  	rules: {
	 	  		material_note:{
	 	  			required: true
	 	  		}
	 	  	},
	 	  	messages: {
	 	  		material_note:{
	 	  			required : 'Please enter material related note.'
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
		            	beforeSend: function (){
		            		$("#add_material_notes").modal('hide');
		     			},
		     			success: function(result, status, xhr) {
		     				var res = JSON.parse(result);
		     				if(res.status == 'success'){

		     					$("#selected_material_list textarea[name='mat_note["+res.mat_id+"]']").val(res.material_note);

		     					swal({
                                	title: "",
                                	text: res.message,
                                	type: "success",
                                	timer:2000,
  									showConfirmButton: false
                                },function(){
                            			swal.close();				
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

	 $("#purchase_req_form").on('submit',function(e){
	 	   e.preventDefault();
	 }).validate({
	  	  rules: {},
          messages: {},
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
		 	 	 	 		$("#material_purchase_rquisation").modal('hide');
		 	 	 	 },
		 	 	 	 success: function(result, status, xhr) {
		 	 	 	 	var res = JSON.parse(result);
		 	 	 	 	if(res.status == 'success'){
			 	 	 	 		swal({
	                             	title: "",
	                                text: res.message,
	                                type: "success",
	                                showConfirmButton: true
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

function add_material(req_id,action){
		swal({
	              title: "Are you sure?",
	              text: "Before add material. Search in material listing.",
	              type: "warning",
	              showCancelButton: true,
	              confirmButtonClass: "btn-danger",
	              confirmButtonText: "Add Material",
	              cancelButtonText: "Ok",
	              closeOnConfirm: true,
	              closeOnCancel: true
	    },function(isConfirm){
	          if(isConfirm){
	          		$("#assign_material_requisation").modal('hide');
	          	 	load_page('purchase/add_material_form/req_id/'+req_id+'/'+action);
	          }
	    });
}

function change_status(req_id){
	 var status = document.getElementById("approval_flag").value;

	 if(status == 'approved')
	 {
			 swal({
			  		title: "Are you sure?",
			  		text: "Before approval, please confirmed by related department",
			  		type: "warning",
			  		showCancelButton: true,
		            confirmButtonClass: "btn-danger",
		            confirmButtonText: "Approved",
		            cancelButtonText: "Ok",
		            closeOnConfirm: true,
		            closeOnCancel: true
			  },function(isConfirm){
			  		if(isConfirm){
			  			 $.ajax({
							 	type: "POST",
							 	url: baseURL +"store/change_approval_status", 
							  	headers: { 'Authorization': user_token },
							  	cache:false, 
							  	data: 'req_id='+req_id+'&approval_status='+status,
							  	beforeSend: function () {
				     					swal.close();
			     			    },
							  	success: function(result, status, xhr) {
							  		var res = JSON.parse(result);
							  		if(res.status == 'success'){
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
							  		}else if(res.status == 'error'){
							  				swal({
									               				title: "",
						  										text: res.message,
						  										type: "error",
									        });
							  		}else if(res.status == 'warning'){
		     							swal({
						               				title: "",
			  										text: res.message,
			  										type: "warning",
						               	});
		     						}
							  	}
			 			});
			  		}
			  })
	 }
	 
}

function remove_selected_material(mat_id,dep_id){

	 var req_given_by = $("#req_given_by").val();
     var approval_assign_by = $("#approval_assign_by").val();
     var req_date = $("#req_date").val();


	swal({
	  		title: "Are you sure?",
	  		text: "You want to remove this records?",
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
	  				url: baseURL +"store/remove_selected_material", 
	  				headers: { 'Authorization': user_token },
	  				cache:false, 
	  				data: 'dep_id='+dep_id+'&mat_id='+mat_id+'&req_given_by='+req_given_by+'&approval_assign_by='+approval_assign_by+'&req_date='+req_date,
	  				success: function(result){
	  					 var res = JSON.parse(result);
	  					 if(res.status == 'success'){
							 $('table tr').filter("[data-row-id='" + mat_id + "']").remove();	
							 load_page(res.redirect);
	  					 }
	  				}
	  			});
	  		}
	  });
}

function remove_selected_material_details(id,req_id){
		swal({
	  		title: "Are you sure?",
	  		text: "You want to remove this records?",
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
	  				url: baseURL +"store/remove_selected_material_details", 
	  				headers: { 'Authorization': user_token },
	  				cache:false, 
	  				data: 'id='+id+'&req_id='+req_id,
	  				success: function(result){
	  					 var res = JSON.parse(result);
	  					 if(res.status == 'success'){
							 $('table tr').filter("[data-row-id='" + id + "']").remove();	
							 load_page(res.redirect);
	  					 }
	  				}
	  			});
	  		}
	  });	
}

function material_requested(req_id,row,status){
   if(typeof req_id !== "undefined") {	
		 $.ajax({
		 	type: "POST",
		 	url: baseURL+'store/get_requisation_materials_list',
		 	headers: { 'Authorization': user_token },
		 	cache: false,
		 	data: 'req_id='+req_id+'&status='+status,
		 	beforeSend: function () {
			    $(".content-wrapper").LoadingOverlay("show");
		    },
			success: function(result){
			 		$(".content-wrapper").LoadingOverlay("hide");
			 		row.child(result).show();
			}
		 });
   }	 
}

function add_material_note(id,dep_id,table){
		$.ajax({
			type: "POST",
			url: baseURL+'store/get_materials_notes',
			headers: { 'Authorization': user_token },
			cache: false,
			data: 'id='+id+'&dep_id='+dep_id+'&table='+table,
			beforeSend: function(){

			},
			success: function(result){
				var res = JSON.parse(result);
					if(res.status == 'success')
					{
					   if(res.result_data.length > 0){
					   	    if(res.sess_dep_id != res.result_data[0].dep_id){
								 $("#footer_content").hide();
							}
							$("#material_name_note").html(res.result_data[0].mat_name);
							$("input[name='note_mat_id']").val(res.result_data[0].mat_id);
							
							if (typeof res.result_data[0].id !== "undefined"){
								 $("input[name='detail_id']").val(res.result_data[0].id);
							}

							$("#material_note").val(res.result_data[0].material_note);
					   }		
					}
				$("#add_material_notes").modal('show');	
			}
		}); 
}

function set_quantity_requisation(quantity,mat_id,dep_id,table){
	if($.isNumeric(quantity) && quantity.length > 0)
    {  
      $.ajax({
              type: "POST",
              url: baseURL +"store/set_quantity_requisation", 
              headers: { 'Authorization': user_token },
              cache:false, 
              data: 'qty='+quantity+'&mat_id='+mat_id+'&dep_id='+dep_id+'&table='+table,
              beforeSend: function () {
                    $(".content-wrapper").LoadingOverlay("show");
              },
              success: function(result){
                   var res = JSON.parse(result);
                   if(res.status == 'success'){
                      $(".content-wrapper").LoadingOverlay("hide");
                   }
                   $(".content-wrapper").LoadingOverlay("hide");  
              }
      });
   }
}

function update_units_requisation(unit_id,mat_id,dep_id,table_name){
		$.ajax({
               type: "POST",
               url: baseURL +"store/update_units_requisation", 
               headers: { 'Authorization': user_token },
               cache:false, 
               data: 'unit_id='+unit_id+'&mat_id='+mat_id+'&dep_id='+dep_id+'&table='+table_name,
               beforeSend: function () {
                       $(".content-wrapper").LoadingOverlay("show");
               },
               success: function(result){
                  $(".content-wrapper").LoadingOverlay("hide");
               }
          });
}

function generate_purchase_requisation(req_id){
	 var allMat = [];

 	 $(".req_chk:checked").each(function() {  
	  	allMat.push($(this).attr('data-id'));
	 });

	 if(allMat.length <=0){
	     		 	swal({
  						title: "",
  						text: "Please select material(s) for purchase.",
  						type: "warning",
			    	});
	 }else{
	 	 var join_selected_values = allMat.join(",");
	 	 $.ajax({
	 	 	type: "POST",
	 	 	url: baseURL +"store/get_requisation_material_details",
	 	 	headers: { 'Authorization': user_token },
	 	 	cache: false,
			data: JSON.stringify({mat_ids:join_selected_values,req_id:req_id,for_material:'purchase',form_type:'material_req_form'}),
			beforeSend: function(){
				swal.close();
			},
			success: function(result){
				$("#purchase_material_list_pop_up").html('');
                $("#purchase_material_list_pop_up").html(result);
                $("#store_req_id").val(req_id);
                $("#material_purchase_rquisation").modal({backdrop: 'static', keyboard: false});
			}
	 	 }); 
	 }
}

function material_indent(req_id){
	if(req_id > 0){
		$.ajax({
			type: "POST",
			url: baseURL +"store/generate_material_indent_form_pdf",
			headers: { 'Authorization': user_token },
			cache: false,
			data: JSON.stringify({req_id:req_id}),
			beforeSend: function(){
				 $(".content-wrapper").LoadingOverlay("show");
			},
			success: function(result){
				 var res = JSON.parse(result);
                   if(res.status == 'success'){
                   	    if(res.req_id){
                   	    	$(".content-wrapper").LoadingOverlay("hide");
                   	    	$.ajax({
							        url: baseURL + 'store/download_material_indent_pdf/'+res.pdf,
							        method: 'POST',
							        cache: false,
							        success: function (data) {
							           window.location =baseURL + 'store/download_material_indent_pdf/'+res.pdf
							        }
    						});
                   	    }
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
}	

function search_requisition(){
	var from_date = $("#from_requisition_date").val();
	var to_date = $("#to_requisition_date").val();
	var dep_id = $("#filter_dep_id").val();

	 $.ajax({
	 	 	type: "POST",
	 	 	url: baseURL +"Commonrequesthandler_ui/check_date_differance",
	 	 	headers: { 'Authorization': user_token },
	 	 	cache: false,
			data: JSON.stringify({from_date:from_date,to_date:to_date}),
			beforeSend: function(){
			},
			success: function(result){
				var res = JSON.parse(result);

				 if(res.status == 'success'){
				 	load_page('store/material_requisation/tab_2/0/'+from_date+'/'+to_date+'/'+dep_id);
				 }else{
				 	swal({
							title: "",
						  	text: res.message,
						  	type: "error",
					});
				 }
			}
	 });
}