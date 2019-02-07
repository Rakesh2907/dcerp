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
            'pageLength': 50
  });

	var table_supplier = $('#supplier_list').DataTable({
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
            'pageLength': 50
  });
  	
	var table_quotation = $('#quotation_list').DataTable({
            'columnDefs': [{
               'targets': 0,
               'searchable':false,
               'orderable':false,
               'className': 'dt-body-center',
               'render': function (data, type, full, meta){
                   return data;
               }
            }],
            'pageLength': 50
     });

	$('#quotation_list tbody').on('click', '.dt-body-center', function () {
        var tr = $(this).closest('tr');
        var row = table_quotation.row( tr );
        var quotation_id = tr.attr('data-row-id');
       
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
            $(".details-control-"+quotation_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
        }
        else {
            // Open this row
            format(quotation_id,row);   
            tr.addClass('shown');
            $(".shown .details-control-"+quotation_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
        }
    } );



  $('.select2').select2();	

  $('#supplier_list-select-all').on('click', function(){
        var rows = table_supplier.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });

  $('#supplier_list tbody').on('change', 'input[type="checkbox"]', function(){
        if(!this.checked){
           var el = $('#supplier_list-select-all').get(0);
           if(el && el.checked && ('indeterminate' in el)){
              el.indeterminate = true;
           }
        }
   });	
    
  	$("#pop_up_add_payments_plan").on('submit',function(e){
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
                            	$("#add_new_billing_date").modal('hide');			
                            });
     					 }
	            	}
     	    	});
  			}
  	});

  	$('[name^="bill_due_date"]').each(function() {
		        $(this).rules('add', {
		            required: true,
		        })
    });

  	$('[name^="amount"]').each(function() {
		        $(this).rules('add', {
		            required: true,
		            number: true,
		        })
    });


  	$("#assign_material_form").on('submit',function(e){
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

     					 }else if(res.status == 'error'){

     					 }
     			}	  
     	    });		
        }
  	});

  	$('[name^="mat_discount"]').each(function() {
        $(this).rules('add', {
            number: true
        })
    });

  	$('[name^="mat_rate"]').each(function() {
        $(this).rules('add', {
            number: true
        })
    });

  	$('[name^="credit_day"]').each(function() {
        $(this).rules('add', {
            number: true
        })
    });

  	$('[name^="lead_time"]').each(function() {
        $(this).rules('add', {
            number: true
        })
    });

    $("#supplier_form").on('submit',function(e){
     		e.preventDefault();
     }).validate({
	        rules: {
	            supp_firm_name: {
	                required: true,
	                minlength: 3,
	                lettersonly: false
	            },
	            supp_contact_person: {
	                required: true,
	                minlength: 3,
	                lettersonly: false
	            },
	            supp_address: {
	                required: true,
	                minlength: 3
	            },
	            supp_mobile: {
	            	required: true,
	            	minlength: 10,
	                number: true
	            },
	            supp_email: {
	            	required: true,
	                minlength: 3,
	                email: true
	            }
	        },
	        messages: {
	            supp_firm_name: {
	                required: "Please enter supplier name"
	            },
	            supp_contact_person: {
	                required: "Please enter contact person name up to 3 characters"
	            },
	            supp_address: {
	                required: "Enter your message 3-20 characters"
	            },
	            supp_mobile: {
	            	required: "Enter only valid mobile number"
	            },
	            supp_email: {
	            	required: "Enter valid email"
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
	     				//$(".content-wrapper").LoadingOverlay("show");
     				},
			        success: function(result, status, xhr) {
			        	   $(".content-wrapper").LoadingOverlay("hide");
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

     /*$.validator.addMethod('supp_mobile', function(value, element) {
			return value.match(/^\+(?:[0-9] ?){6,14}[0-9]$/);
	 },'Enter Valid  phone number');*/

	 $('#reset_supplier').on('click',function(){
	 		$('#supplier_form')[0].reset();
	 });
     	

	 $("#supplier_verified").on('submit',function(e){
	 		e.preventDefault();
	 }).validate({
	 		rules: {},
	 		messages: {},
	 		submitHandler: function(form) {
	 			var form_data = new FormData(form);
     	        var page_url = $(form).attr('action');

     	        var qc_verified_val = $("#qc_verified").is(':checked') ? 'yes' : 'no';

     	        form_data.append('qc_verified',qc_verified_val);

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

	 $("#supplier_others_form").on('submit',function(e){
	 		e.preventDefault();
	 }).validate({
	 		rules: {},
	 		messages: {},
	 		submitHandler: function(form) {
	 			var form_data = new FormData(form);
     	        var page_url = $(form).attr('action');	

     	        var nda_sign_val = $("#nda_sign").is(':checked') ? 'yes' : 'no';

     	        form_data.append('nda_sign',nda_sign_val);
     	       
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



	 $("#supplier_bank_detail_form").on('submit',function(e){
	 		e.preventDefault();
	 }).validate({
			rules: {
				customer_name: {
	                required: true
	            },
	            account_num: {
	            	 required: true,
	            	 number: true
	            },
	            bank_name: {
	            	required: true
	            },
	            bank_ifsc: {
	            	required: true
	            }
			},
	 		messages: {
	 			customer_name: {
	                required: 'Please enter Account Name'
	            },
	            account_num: {
	            	 required: 'Please enter Account Number'
	            },
	            bank_name: {
	            	required: 'Please enter Bank Name'
	            },
	            bank_ifsc: {
	            	required: 'Please enter Bank IFSC Code'
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


	 $("#supplier_documents_form").on('submit',function(e){
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
	     				//$(".content-wrapper").LoadingOverlay("show");
	     				 $("#supplier_documents").modal('hide');
     				},
			        success: function(result, status, xhr) {
			        	var res = JSON.parse(result);
			        	if(res.status == 'success'){
			        	    	swal({
                                	title: "",
                                	text: res.message,
                                	type: "success",
  									showConfirmButton: true
                            	},function(){
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

	 $('#assign_material').on('click',function(e){
	 	  var allMat = [];
	 	  $(".sub_chk:checked").each(function() {  
          		allMat.push($(this).attr('data-id'));
          });

	 	  var supplier_id = $('input[name="supplier_id"]').val();
	 	  if(allMat.length <=0){
	 	  		swal({
  					title: "",
  					text: "Please select rows.",
  					type: "warning",
			    });
	 	  }else{
	 	  		 var join_selected_values = allMat.join(","); 
	 	  		 $.ajax({
	 	  		 	type: "POST",  
				    url: baseURL +"purchase/assign_material",
				    headers: { 'Authorization': user_token },
				    cache: false,  
				    data: 'mat_ids='+join_selected_values+"&supplier_id="+supplier_id,
				    success: function(response){
				    	if(response == 'false'){
				    	}else{
				    		$("#assign_material_supplier").modal('hide');
				    		//reload_material_list(supplier_id);
				    		load_page('purchase/edit_supplier_form/'+supplier_id+'/tab_2');
				    	}
				    }
	 	  		 }); 

	 	  }
         
	 });

	 $('#delete_all_supplier').on('click', function(e) { 
        var allVals = [];  
        $(".sub_chk:checked").each(function() {  
          allVals.push($(this).attr('data-id'));
        });  
        //alert(allVals.length); return false;  
        if(allVals.length <=0)  {  
              swal({
  					title: "",
  					text: "Please select rows.",
  					type: "warning",
			   });
        }  
        else { 
        	  swal({
              title: "Are you sure?",
              text: "You want to delete this records?",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes",
              cancelButtonText: "No",
              closeOnConfirm: true,
              closeOnCancel: true
          },
          function(isConfirm) {
	          	if (isConfirm){
	          			 //for server side
				  var join_selected_values = allVals.join(","); 
				  $.ajax({   
				              type: "POST",  
				              url: baseURL +"purchase/delete_supplier",  
				              headers: { 'Authorization': user_token },
				              cache: false,  
				              data: 'ids='+join_selected_values,  
				              success: function(response)  { 
				                 $.each(allVals, function( index, value ) {
				                    $('table tr').filter("[data-row-id='" + value + "']").remove();
				                   });  
				                 load_page('purchase/supplier');
				              }   
				  });
	          	}	
	      });    	 
        }  
    });

	$('#export_supplier').on('click',function(){
		var allVals = [];
		$(".sub_chk:checked").each(function(){
            allVals.push($(this).attr('data-id'))
        });

		 if(allVals.length <=0){
		 		swal({
  					title: "",
  					text: "Please select rows.",
  					type: "warning",
				});
		 }else{
                var join_selected_values = allVals.join(","); 
		        $.ajax({
		              type: "REQUEST",
		              url: baseURL +"purchase/export_supplier",
		              headers: { 'Authorization': user_token },
		              cache: false,
		              data: 'ids='+join_selected_values,
		              beforeSend: function () {
		                $(".content-wrapper").LoadingOverlay("show",{
		                   image       : "",
		                   fontawesome : "fa fa-cog fa-spin"
		                });
		              },
		              success: function(){
		                setTimeout(function(){
		                  $(".content-wrapper").LoadingOverlay("hide");
		                  window.open(baseURL +'purchase/export_supplier/?ids='+join_selected_values,'_blank' );
		                   }, 5000);    
		              }
		        });
		 } 

	});

	$("#tab_material").on('click', function(){
		  $('.nav-tabs a[href="#tab_2"]').tab('show');
	});

	$("#get_material").on('click', function(){
			$(".vendor-name").html($('input[name="supp_firm_name"]').val());
		    $("#assign_material_supplier").modal('show');
	});


	var table_po_list = $('#po_list').DataTable({
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

	 $('#po_list-select-all').on('click', function(){
	        	var rows = table_po_list.rows({ 'search': 'applied' }).nodes();
	        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	 });

	 $('#po_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#po_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
		        }
	  });


	 $('#po_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_po_list.row( tr );
             var po_id = tr.attr('data-row-id');

             if (row.child.isShown()) {
             	row.child.hide();
            	tr.removeClass('shown');
            	$(".details-control-"+po_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
             }else{
                materials_purchase_order(po_id,row);   
	            tr.addClass('shown');
	            $(".shown .details-control-"+po_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
             }
	  });

	 var table_inward = $("#invoice_list").DataTable({
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

	  $('#invoice_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_inward.row( tr );
             var inward_id = tr.attr('data-row-id');

             if (row.child.isShown()) {
             	row.child.hide();
            	tr.removeClass('shown');
            	$(".details-control-"+inward_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
             }else{
                inward_materials_details(inward_id,row);   
	            tr.addClass('shown');
	            $(".shown .details-control-"+inward_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
             }
	  });
});	

function generate_reg_number(vendor_id){

     var mylength = 8;
     var timestamp = +new Date();
    
     var ts = timestamp.toString();
     var parts = ts.split( "" ).reverse();
     var id = "";

     var _getRandomInt = function( min, max ) {
        return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
     }

    for( var i = 0; i < mylength; ++i ) {
          var index = _getRandomInt(0, parts.length - 1);
          id += parts[index];  
    }

    $("#permanent_regi_number").val('DCGL/REG/VENDOR/'+id);
}

function view_payments_plan(inward_id,vendor_id){
	if(inward_id > 0){
		
		$.ajax({
			 type: "POST",
		 	 url: baseURL+'purchase/view_payments_plan_details',
		 	 headers: {'Authorization': user_token},
		 	 cache: false,
		 	 data: JSON.stringify({inward_id:inward_id,vendor_id:vendor_id}),
		 	 beforeSend: function () {

		 	 },
		 	 success: function(result){
		 	 	$('#view_payments_plan_details').html('');
		 	 	$('#view_payments_plan_details').html(result);
		 	 	$('#view_payments_plan').modal('show');
		 	 }
		});
	}
}	

function inward_materials_details(inward_id,row){
	if(typeof inward_id !== "undefined") {
		$.ajax({
			type: "POST",
		 	url: baseURL+'store/get_inward_material_details',
		 	headers: { 'Authorization': user_token },
		 	cache: false,
		 	data: JSON.stringify({inward_id:inward_id}),
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

function materials_purchase_order(po_id,row){
	if(typeof po_id !== "undefined") {	
		 $.ajax({
		 	type: "POST",
		 	url: baseURL+'purchase/get_purchase_order_materials_list',
		 	headers: { 'Authorization': user_token },
		 	cache: false,
		 	data: 'po_id='+po_id,
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

function format(quotation_id,row){
	$.ajax({
              type: "POST",
              url: baseURL +"purchase/get_vendor_bid_details", 
              headers: { 'Authorization': user_token },
              cache:false, 
              data: 'quotation_id='+quotation_id,
              beforeSend: function () {
                  $(".content-wrapper").LoadingOverlay("show");
              },
              success: function(result){
                  $(".content-wrapper").LoadingOverlay("hide");
                  row.child(result).show();
              }
    });
}

function reload_material_list(supplier_id){
		$.ajax({
			 type: "POST",
			 url: baseURL +"purchase/load_supplier_assign_material",
			 headers: { 'Authorization': user_token },
			 cache: false,
			 data: 'supplier_id='+supplier_id,
			 beforeSend: function(){
			 	 $(".content-wrapper").LoadingOverlay("show",{
		                   image       : "",
		                   fontawesome : "fa fa-cog fa-spin"
		         });
			 },
			 success: function($result){
			 	    $(".content-wrapper").LoadingOverlay("hide");
			 		$("#vendor_assign_material").html('');
			 		$("#vendor_assign_material").html($result);
			 }
		});
}

function remove_assign_material(mat_id,supplier_id){
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
	  				url: baseURL +"purchase/remove_supplier_assign_material", 
	  				headers: { 'Authorization': user_token },
	  				cache:false, 
	  				data: 'supplier_id='+supplier_id+'&mat_id='+mat_id,
	  				success: function(result){
	  					 var res = JSON.parse(result);
	  					 if(res.status == 'success'){
							 $('table tr').filter("[data-row-id='" + mat_id + "']").remove();	
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

function remove_supplier(supplier_id){
	 swal({
              title: "Are you sure?",
              text: "You want to delete this records?",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes",
              cancelButtonText: "No",
              closeOnConfirm: true,
              closeOnCancel: true
          },
          function(isConfirm) {
	          	if (isConfirm){
	          		$.ajax({   
	      					type: "POST",  
	      					url: baseURL +"purchase/delete_supplier",  
	      					headers: { 'Authorization': user_token },
	      					cache:false,  
	      					data: 'ids='+supplier_id, 
	      					beforeSend:function(){
	      						swal.close();
	      					}, 
						    success: function(response)  { 
						    	  swal.close(); 

						    	  var res = JSON.parse(response);

						    	  if(res.status == 'success'){
						    	  	$('table tr').filter("[data-row-id='" + supplier_id + "']").remove();
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

function nda_change_status(){
	var current_status = $('#nda_agree').html();
	if(current_status == 'No'){
		$('#nda_agree').html('Yes');
		$('#nda_agree').css({'margin-top': '7px','margin-left': '4px','color': 'white'});
	}else{
		$('#nda_agree').html('No');
		$('#nda_agree').css({'margin-top': '7px','margin-left': '34px','color': 'white'});
	}
}

function qc_change_status(){
	var current_status = $('#qc_verified_status').html();
	if(current_status == 'No'){
		$('#qc_verified_status').html('Yes');
		$('#qc_verified_status').css({'margin-top': '7px','margin-left': '4px','color': 'white'});
	}else{
		$('#qc_verified_status').html('No');
		$('#qc_verified_status').css({'margin-top': '7px','margin-left': '34px','color': 'white'});
	}
}

function vendor_new_doc(vendor_id){
	$('#supplier_documents_form')[0].reset();
	$("#supplier_documents").modal('show');
}

function new_field_vendor_doc(main_filed_id){
	var main_div = document.getElementById(main_filed_id);
	var count = main_div.childElementCount

	var row = document.createElement("div");
	row.setAttribute("class","row");
	row.setAttribute("style","border-bottom: 1px solid #ccc;margin-top: 15px;");

	var div1 = document.createElement("div");//document.getElementById("monitoring_mode_div");
	div1.setAttribute("class","col-md-6");
	var div2 = document.createElement("div");//document.getElementById("monitoring_name_div");
	div2.setAttribute("class","col-md-6");

	var params = {name: "vendor_file_name[]", id:"vendor_file_name"+count, class: "form-control", placeholder: "File Name"};
	var d1 = createAppendInputText(params);
	div1.appendChild(d1);

	var params = {name: "vender_doc_file[]", id:"vender_doc_file"+count, class: "form-control"};
	var d2 = createAppendInputFile(params);
	div2.appendChild(d2);

	row.appendChild(div1);
	row.appendChild(div2);

	main_div.appendChild(row);
}

function createAppendInputText(params){
	var div = document.createElement('div');
	div.setAttribute("class","form-group");

	var txt = document.createElement('input');
	txt.setAttribute("type","text");
	if(params != undefined){
		for(var key in params){
			if(txt[key] != undefined){
				txt[key] = params[key];
			}else{
				txt.setAttribute(key,params[key]);
			}
		}		
	}
	txt.setAttribute("class","form-control");
	div.appendChild(txt);

	return div;
}

function createAppendInputFile(params){
	var div = document.createElement('div');
	div.setAttribute("class","form-group");

	var txt = document.createElement('input');
	txt.setAttribute("type","file");
	if(params != undefined){
		for(var key in params){
			if(txt[key] != undefined){
				txt[key] = params[key];
			}else{
				txt.setAttribute(key,params[key]);
			}
		}		
	}	
	txt.setAttribute("class","form-control");

	div.appendChild(txt);

	return div;
}

function remove_vender_doc(supplier_id,doc_id){
		swal({
              title: "Are you sure?",
              text: "You want to delete this records?",
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
		      			url: baseURL +"purchase/remove_supplier_doc",  
		      		    headers: { 'Authorization': user_token },
		      		    data: 'supplier_id='+supplier_id+'&doc_id='+doc_id,
		      			cache:false,  
		      			beforeSend:function(){
		      			}, 
					    success: function(response)  { 
							    	  var res = JSON.parse(response);
							    	  if(res.status == 'success'){
							    	  	$("#vdoc_"+res.doc_id).remove();
								    	    swal({
		                                		title: "",
		                                		text: res.message,
		                                		type: "success",
		                                		timer:2000,
		  										showConfirmButton: false
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
}

function vendor_password(supplier_id){
		$.ajax({
          			type: "POST",  
	      			url: baseURL +"purchase/generate_vendor_password",  
	      		    headers: { 'Authorization': user_token },
	      		    data: 'supplier_id='+supplier_id,
	      			cache:false,  
	      			beforeSend:function(){
	      			}, 
				    success: function(response)  { 
						    	  var res = JSON.parse(response);
						    	  if(res.status == 'success'){
						    	  	 $("#supplier_form #password").val(res.vendor_password);
						    	  }else if(res.status == 'warning'){
					        	    	
					        	  }else if(res.status == 'error'){
					        	    	
					        	 }
					}		    	  
          		});
}