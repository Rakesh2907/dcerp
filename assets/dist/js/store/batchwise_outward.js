/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, November 2018
 */

$(document).ready(function(){
	$('.select2').select2();

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


	 $("#outward_form").on('submit',function(e){
	 		e.preventDefault();
	 }).validate({
	 	 rules: {
	 	 	dep_id:{
	 	 		required: true
	 	 	},
	 	 	req_id:{
	 	 		required: true
	 	 	},
	 	 	receive_by:{
	 	 		required:true
	 	 	}
	 	 },
         messages: {
         	dep_id:{
         		required : 'Please select department.'
         	},
         	req_id:{
         		required: 'Please select requisation number'
         	},
         	receive_by:{
         		required: 'Please select receive by person'
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

		 	 	 	 },
		 	 	 	 success: function(result, status, xhr) {
		 	 	 	 	var res = JSON.parse(result);
		 	 	 	 	if(res.status == 'success'){
			 	 	 	 		swal({
	                             	title: "",
	                                text: res.message,
	                                type: "success",
	                                showConfirmButton: true
	                            },function(isConfirm){ 
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
});

function outward_browse_requisition(){
	 var dep_id = $("#dep_id").val();
	 if(dep_id!=''){
		 	$.ajax({
		 		url: baseURL +"store/department_material_requisition",
		 		headers: { 'Authorization': user_token },
		  		method: "POST",
		  		data: JSON.stringify({dep_id:dep_id}),
		  		contentType:false,
		    	cache:false,
		    	processData:false,
		    	beforeSend: function () {
		    		 $(".content-wrapper").LoadingOverlay("show");
		    	},
		    	success: function(result, status, xhr) {
		    		 $(".content-wrapper").LoadingOverlay("hide");
		    		 $("#requision_pop_up").html('');
		    		 $("#requision_pop_up").html(result);
		    		 $("#approved_material_requisition").modal('show');
		    	}
		 	});
	 }else{
	 	swal({
  			title: "",
  			text: "Please select department.",
  			type: "warning",
	    });
	 }
}

function get_material_requisation(req_id){
	 var req_number = $("#req_id_"+req_id+" .req_number_cls_"+req_id).html();
	 $("#req_id").val(req_id);
	 $("#requisition_number").val(req_number);
	 $("#req_material_details").html('');
	 $("#approved_material_requisition").modal('hide');
}

function browse_material(submit_type,outward_id){
	 var req_id = $("#req_id").val();

	 if(req_id != '') 
	 {  
           $.ajax({
            type: "POST",
            url: baseURL+'store/get_outward_requisation_materials_list',
            headers: { 'Authorization': user_token },
            cache: false,
            data: 'req_id='+req_id+'&form_type='+submit_type+'&outward_id='+outward_id,
            beforeSend: function () {
                $(".content-wrapper").LoadingOverlay("show");
              },
            success: function(result){
                $(".content-wrapper").LoadingOverlay("hide");
                $("#requision_material_list_pop_up").html('');
                $("#requision_material_list_pop_up").html(result);
                $("#requisition_material_list").modal({backdrop: 'static', keyboard: false});
            }
           });
    }else{
    	swal({
  			title: "",
  			text: "Please select requisation.",
  			type: "warning",
	    });
    }
}
function material_select(form_type){
	var req_id = $("#req_id").val();
	var allMat = [];

	$(".sub_chk:checked").each(function() {  
	       allMat.push($(this).attr('data-id'));
	});

	var outward_id = $("#button_material_select").attr('data-outward');

	if(allMat.length <=0){
	     swal({
  			title: "",
  			text: "Please select material(s) for outward.",
  			type: "warning",
	     });
 	}else{
 		var join_selected_values = allMat.join(","); 
 	 	if(form_type=='edit'){
 	 		$.ajax({
 	 			type: "POST", 
 	 			url: baseURL +"store/add_requisation_material_details",
 	 			headers: { 'Authorization': user_token },
 	 			cache: false,
 	 			data: JSON.stringify({mat_ids:join_selected_values,req_id:req_id,for_material:'outward',outward_id:outward_id}),
 	 			beforeSend: function(){
		     		$("#requisition_material_list").modal('hide');
		     	},
		     	success: function(result){
		     		var res = JSON.parse(result);
		     		if(res.status == 'success'){
		     			load_page(res.redirect);
                    }else if(res.status == 'error'){
                        swal({
                           title: "",
                           text: res.message,
                           type: "error",
                        });
                    }
		     	}
 	 		});
 	 	}else{	
	 		$.ajax({
	 			type: "POST", 
	 			url: baseURL +"store/get_requisation_material_details",
		     	headers: { 'Authorization': user_token },
		     	cache: false,
		     	data: JSON.stringify({mat_ids:join_selected_values,req_id:req_id,for_material:'outward'}),
		     	beforeSend: function(){
		     		$("#requisition_material_list").modal('hide');
		     	},
		     	success: function(result){
		     			$("#req_material_details").html('');
		     			$("#req_material_details").html(result);
		     	     	
		     	}
	 		});
 	    }	
 	}
}

function generate_purchase_requisation(){
	 var req_id = $("#req_id").val();

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
				    	data: JSON.stringify({mat_ids:join_selected_values,req_id:req_id,for_material:'purchase'}),
				    	beforeSend: function(){
				    		    swal.close();
								$("#requisition_material_list").modal('hide');
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

function reload_requisation_page(){
	$("#material_purchase_rquisation").modal('hide');
	$("#requisition_material_list").modal({backdrop: 'static', keyboard: false});
}

function scan_barcode(bar_code,mat_id,row_id){
	//alert(bar_code+'  '+mat_id);

	var mbar_code = bar_code;
	if(mbar_code)
	{
		$.ajax({
			type: "POST",
			url: baseURL +"store/get_batch_material_details",
			headers: { 'Authorization': user_token },
			data: JSON.stringify({bar_code:mbar_code,mat_id:mat_id}),
			beforeSend: function(){

			},
			success: function(result){
					var res = JSON.parse(result);
					if(res.status == 'success'){
						if(res.batch_data.length > 0){
							for(var i = 0; i < res.batch_data.length; i++){
								var mat_id = res.batch_data[i].mat_id;
								 $("#mat_batch_no_"+row_id+"_"+mat_id).val(res.batch_data[i].batch_number);
								 $("#mat_lot_no_"+row_id+"_"+mat_id).val(res.batch_data[i].lot_number);
								 $("#mat_expire_date_"+row_id+"_"+mat_id).val(res.batch_data[i].expire_date);
								 $("#mat_stock_qty_"+row_id+"_"+mat_id).val(res.batch_data[i].accepted_qty);
								 $("#mat_inward_qty_"+row_id+"_"+mat_id).val(res.batch_data[i].accepted_qty);

								 if(res.batch_data[i].expired_material == 'true'){
								 	$("#mat_expire_date_"+row_id+"_"+mat_id).css("background-color", "#ff1100");
								 }else{
								 	$("#mat_expire_date_"+row_id+"_"+mat_id).css('background-color','');
								 }

								 $("#mat_batch_id_"+row_id+"_"+mat_id).val(res.batch_data[i].batch_id);
								 $("#sub_mat_id_"+row_id+"_"+mat_id).val(res.batch_data[i].sub_mat_id);
								 $("#mat_inward_id_"+row_id+"_"+mat_id).val(res.batch_data[i].inward_id);
								 $("#mat_po_id_"+row_id+"_"+mat_id).val(res.batch_data[i].po_id);
							}
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
	}else{
		console.log('Bar Code not found');	
	}
}

function mat_batch_number(batch_number,mat_id,row_id){
	if(batch_number)
	{

		$.ajax({
			type: "POST",
			url: baseURL +"store/get_batch_material_details",
			headers: { 'Authorization': user_token },
			data: JSON.stringify({batch_number:batch_number,mat_id:mat_id}),
			beforeSend: function(){

			},
			success: function(result){
					var res = JSON.parse(result);
					if(res.status == 'success'){
						 if(res.batch_data.length > 0){
								for(var i = 0; i < res.batch_data.length; i++){	
							 			var mat_id = res.batch_data[i].mat_id;
										 $("#mat_bar_code_"+row_id+"_"+mat_id).val(res.batch_data[i].bar_code);
										 $("#mat_lot_no_"+row_id+"_"+mat_id).val(res.batch_data[i].lot_number);
										 $("#mat_expire_date_"+row_id+"_"+mat_id).val(res.batch_data[i].expire_date);
										 $("#mat_stock_qty_"+row_id+"_"+mat_id).val(res.batch_data[i].accepted_qty);
										 $("#mat_inward_qty_"+row_id+"_"+mat_id).val(res.batch_data[i].accepted_qty);

										 if(res.batch_data[i].expired_material == 'true'){
								 				$("#mat_expire_date_"+row_id+"_"+mat_id).css("background-color", "#ff1100");
								 		 }else{
								 				$("#mat_expire_date_"+row_id+"_"+mat_id).css('background-color','');
								 		 }

								 		 $("#mat_batch_id_"+row_id+"_"+mat_id).val(res.batch_data[i].batch_id);
								 		 $("#sub_mat_id_"+row_id+"_"+mat_id).val(res.batch_data[i].sub_mat_id);
								 		 $("#mat_inward_id_"+row_id+"_"+mat_id).val(res.batch_data[i].inward_id);
								 		 $("#mat_po_id_"+row_id+"_"+mat_id).val(res.batch_data[i].po_id);
							    }
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
	}else{
		console.log('Batch Number not found');	
	}
}

function mat_lot_number(lot_number,mat_id,row_id){
	if(lot_number)
	{
		$.ajax({
			type: "POST",
			url: baseURL +"store/get_batch_material_details",
			headers: { 'Authorization': user_token },
			data: JSON.stringify({lot_number:lot_number,mat_id:mat_id}),
			beforeSend: function(){

			},
			success: function(result){
				var res = JSON.parse(result);
					if(res.status == 'success')
					{
						 if(res.batch_data.length > 0){
								for(var i = 0; i < res.batch_data.length; i++){	
							 			var mat_id = res.batch_data[i].mat_id;
										 $("#mat_bar_code_"+row_id+"_"+mat_id).val(res.batch_data[i].bar_code);
										 $("#mat_batch_no_"+row_id+"_"+mat_id).val(res.batch_data[i].batch_number);
										 $("#mat_expire_date_"+row_id+"_"+mat_id).val(res.batch_data[i].expire_date);
										 $("#mat_stock_qty_"+row_id+"_"+mat_id).val(res.batch_data[i].accepted_qty);
										 $("#mat_inward_qty_"+row_id+"_"+mat_id).val(res.batch_data[i].accepted_qty);

										 if(res.batch_data[i].expired_material == 'true'){
								 				$("#mat_expire_date_"+row_id+"_"+mat_id).css("background-color", "#ff1100");
								 		 }else{
								 				$("#mat_expire_date_"+row_id+"_"+mat_id).css('background-color','');
								 		 }

								 		 $("#mat_batch_id_"+row_id+"_"+mat_id).val(res.batch_data[i].batch_id);
								 		 $("#sub_mat_id_"+row_id+"_"+mat_id).val(res.batch_data[i].sub_mat_id);
								 		 $("#mat_inward_id_"+row_id+"_"+mat_id).val(res.batch_data[i].inward_id);
								 		 $("#mat_po_id_"+row_id+"_"+mat_id).val(res.batch_data[i].po_id);

							    }
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
	}else{
		console.log('Lot Number not found');
	}
}

function change_stock(require_qty,mat_id,row_id){
	
	  if($.isNumeric(require_qty) && require_qty!='0'){
			var current_stock = $("#mat_stock_qty_"+row_id+"_"+mat_id).val();

			if(require_qty > current_stock){
				swal({
	                                title: "",
	                                text: 'This quantity not available in store/stock',
	                                type: "error",
	            });
	            $("#mat_outward_qty_"+row_id+"_"+mat_id).val('0'); 
			}else{
				var available_qty = (current_stock - require_qty);
				$("#mat_stock_qty_"+row_id+"_"+mat_id).val(available_qty); 	
			}
     }else{
     	
     	//$("input[name='mat_outward_qty[]["+mat_id+"]']").val('0');
        var inward_qty = $("#mat_inward_qty_"+row_id+"_"+mat_id).val();
		$("#mat_stock_qty_"+row_id+"_"+mat_id).val(inward_qty); 
     }		
}

function remove_outward_items(mat_id,outward_id){
	 swal({
          title: "Are you sure?",
          text: "Remove this material?",
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
          	   			 url: baseURL +'store/remove_outward_material',
                         headers: { 'Authorization': user_token },
                         method: "POST",
                         data: JSON.stringify({mat_id:mat_id,outward_id:outward_id}),
                         contentType:false,
                         cache:false,
                         processData:false,
                         beforeSend: function (){
                                       swal.close();
                         },
                         success: function(result, status, xhr) {
                                     var res = JSON.parse(result);
                                     if(res.status == 'success'){
                                           load_page(res.redirect);
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