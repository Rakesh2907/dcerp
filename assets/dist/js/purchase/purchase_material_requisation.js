$(document).ready(function(){
	 $('.select2').select2();
	// Pending list
	 var table_material_req = $('#pending_material_req_list').DataTable({
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

	  $('#pending_material_req_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#material_req_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
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
});


function purchase_change_status(status,req_id){
	if(status == 'approved')
	 {
			 swal({
			  		title: "Are you sure?",
			  		text: "Before approval, please confirmed by related department/management",
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
							 	url: baseURL +"purchase/purchase_change_approval_status", 
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
			  		}else{
			  			$("#purchase_approval_flag").val('pending');
			  		}
			  })
	 }else{
	 	 $("#purchase_approval_flag").val('pending');
	 }
}

function generate_quotation_request(req_id){

	  var allVals = []; 
	  $(".sub_chk:checked").each(function() {  
          allVals.push($(this).attr('data-id'));
      }); 

	   if(allVals.length <=0)  { 
	   		swal({
  					title: "",
  					text: "Please select material row(s).",
  					type: "warning",
			});
	   }else{
	   		swal({
	 		title: "Are you sure?",
	  		text: "These material send for quotation?",
	  		type: "warning",
	  		showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true	
	 	  },function(isConfirm){
	 		 if(isConfirm)
	 		 {
	 		 		var join_selected_values = allVals.join(",");  

		 			$.ajax({
		 				type: "POST",
		 				url: baseURL+'store/generate_quotation_request',
		 				headers: { 'Authorization': user_token },
		 				cache: false,
		 				data: 'req_id='+req_id+'&mat_id='+join_selected_values,
		 				beforeSend: function () {
		 					swal.close();
		 				},
		 				success: function(result){
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
					  		}
		 				}
		 			});
	 		 }	
	 	});
	 }
}

function send_quotation_request(req_id) {
	 var allVals = []; 
	  $(".sub_chk:checked").each(function() {  
          allVals.push($(this).attr('data-id'));
      }); 

       if(allVals.length <=0){
       		 swal({
  					title: "",
  					text: "Please select material row(s).",
  					type: "warning",
			 });
       }else{
       		swal({
	 		title: "Are you sure?",
	  		text: "Send quotation request to assign vendor?",
	  		type: "warning",
	  		showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true	
	 	  },function(isConfirm){
	 	  		if(isConfirm){
	 	  			var join_selected_values = allVals.join(","); 

	 	  			$.ajax({
		 				type: "POST",
		 				url: baseURL+'store/send_quotation_request',
		 				headers: { 'Authorization': user_token },
		 				cache: false,
		 				data: 'req_id='+req_id+'&mat_id='+join_selected_values,
		 				beforeSend: function () {
		 					swal.close();
		 				},
		 				success: function(result){
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
					  		}
		 				}
		 			});
	 		    }
	 	  })
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
				 	load_page('purchase/purchase_material_requisition/tab_1/0/'+from_date+'/'+to_date+'/'+dep_id);
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