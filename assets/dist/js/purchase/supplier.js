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
            'order': [1, 'asc']
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
            'order': [1, 'asc']
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
            }]
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
});	

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