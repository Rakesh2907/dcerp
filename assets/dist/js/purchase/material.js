/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */

 $(document).ready(function () {
 	     $('#material_list_pop_up').DataTable();
 	     $('.select2').select2();

	 	  var table_material = $('#material_list').DataTable({
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
	            'order': [1, 'asc'],
            	'pageLength': 50
	      });

	 	   $('#material_list-select-all').on('click', function(){
	        	var rows = table_material.rows({ 'search': 'applied' }).nodes();
	        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	  	   });

		   $('#material_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#material_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
		        }
		    });


		 $('#material_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_material.row( tr );
             var mat_id = tr.attr('data-row-id');

             if (row.child.isShown()) {
             	row.child.hide();
            	tr.removeClass('shown');
            	$(".details-control-"+mat_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
             }else{
                materials_detail(mat_id,row);   
	            tr.addClass('shown');
	            $(".shown .details-control-"+mat_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
             }
	      });


 	 $("#cat_id").on('change',function(){
 	 	var cat_id = $(this).val();
 	 	$.ajax({
 	 		url: baseURL +"commonrequesthandler_ui/get_sub_categories",
 	 		headers: { 'Authorization': user_token },
	        method: "POST",
	        data: JSON.stringify({cat_id:cat_id}),
	        contentType:false,
	        cache:false,
	        processData:false,
	        beforeSend: function () {
	        	$("#sub_cat_id").html('Loading...!');
	        },
	        success: function(result, status, xhr) {
	        	$("#sub_cat_id").html('');
	        	$("#sub_cat_id").html(result);
	        }
 	 	});
 	 });

	  $("#add_subcategories").on('click',function(){
	  		var form = $("#pop_up_sub_category");
	  		var page_url = $(form).attr('action');
	  		var cat_for = $("input[name=cat_for]").val();
            var cat_stockable = $("input[name=cat_stockable]").val();
            var cat_id = $("#pop_up_cat_id").val();

	  		var sub_cat_code = [];
            $('input[name^="sub_cat_code"]').each(function() {
    					sub_cat_code.push($(this).val());
			});

			var sub_cat_name = [];
			$('input[name^="sub_cat_name"]').each(function(){
						sub_cat_name.push($(this).val());
			});

			$.ajax({
				url: baseURL +""+page_url,
	     	   	headers: { 'Authorization': user_token },
	            method: "POST",
	            data: JSON.stringify({cat_id:cat_id, sub_cat_code:sub_cat_code, sub_cat_name: sub_cat_name, cat_for:cat_for, cat_stockable:cat_stockable}),
	            contentType:false,
	            cache:false,
	            processData:false,
	            beforeSend: function () {

	            },
	            success: function(result, status, xhr) {
	            	var res = JSON.parse(result);	
	            	if(res.status == 'success'){
	            		$('#add_new_subcategories').modal('hide'); 
	            		$('#cat_id').val(cat_id).trigger('change');
		            		swal({
					               	title: "",
		  							text: res.message,
		  							type: "success",
					        });
				        setTimeout(function(){
	            			$('#sub_cat_id').val(res.sub_category_id); 
	            		}, 3000);
	            	}else if(res.status == 'error'){
		            		swal({
					            title: "",
		  						text: res.message,
		  						type: "error",
					        });
	            	}
	            }
			});


	  });

	  $("#sub_cat_id").on('change',function(){
	  		var cat_id = $('option:selected', this).attr('data-id');
	  		if(cat_id > 0){
	  			$.ajax({
 						url: baseURL +"commonrequesthandler_ui/get_category",
 						headers: { 'Authorization': user_token },
	    				method: "POST",
	    				data: JSON.stringify({cat_id:cat_id}),
	    				contentType:false,
	    				cache:false,
	    				processData:false,
					    beforeSend: function () {

					    },
					    success: function(result, status, xhr) {
					    	var category = JSON.parse(result);
					    	//alert(category['cat_id']);
					    	var html = category['cat_name']+' (<i>Code: '+category['cat_code']+'</i>)';
					    	$("#category_name").html(html);
					    	$("#cat_for").val(category['cat_for']);
					    	$("#cat_stockable").val(category['cat_stockable']);
					    	$("#pop_up_cat_id").val(category['cat_id']);
					    	$("#sub_cat_code_1").val('');
					    	$("#sub_cat_name_1").val('');
				 			$('#add_new_subcategories').modal('show'); 
					    }
 					});
	  		}
	  });

	  $("#material_form").on('submit',function(e){
     		e.preventDefault();
      }).validate({
      		rules: {
      			 mat_code: {
	                required: true,
	                minlength: 3,
	                lettersonly: false
	             },
	             mat_name: {
	                required: true,
	                minlength: 3,
	                lettersonly: false
	             },
	             mat_details: {
	                required: true,
	                minlength: 3,
	                lettersonly: false
	             },
	             dep_id: {
	             	required: true,
	             },
	             cat_id: {
	             	 required: true,
	             },
	             mat_rate: {
	             	  number: true
	             },
	             tolerance: {
	            	  number: true	
	             },
	             opening_stock: {
	             	  number: true	
	             },
	             rejected_opening_qty: {
	             	  number: true	
	             },
	             scrape_opening_stock: {
	             	  number: true
	             },
	             current_stock: {
	             	  number: true
	             },
	             rejected_current_qty: {
	             	  number: true
	             },
	             scrape_current_qty: {
	             	  number: true
	             },
	             free_stock: {
	             	  number: true
	             },
	             minimum_level: {
	             	  number: true	
	             },
	             reorder_qty: {
	             	  number: true
	             },
	             mat_length: {
	             	  number: true  
	             },
	             mat_width: {
	             	  number: true 
	             },
	             mat_thickness: {
	             	  number: true 
	             },
	             mat_weight : {
	             	  number: true	
	             }
      		},
      		messages: {
      			 mat_code: {
	                required: "Please enter material code"
	             },
	             mat_name: {
	             	required: "Please enter material name"
	             },
	             mat_details: {
	             	required: "Please enter material details"
	             },
	             cat_id: {
	             	required: "Please select material category"
	             },
	             dep_id: {
	             	required: "Please select department"
	             }
      		},
      		submitHandler: function(form) {
      			var form_data = new FormData(form);
      			form_data.append('dep_id', $("#dep_id").val());
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
     	        })
      		}
      });

      $("#get_material").on('click',function(e){
      		 $("#assign_parent_material").modal('show');
      });


      $("#export_material").on('click',function(){
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
		              url: baseURL +"purchase/export_material",
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
		                  window.open(baseURL +'purchase/export_material/?ids='+join_selected_values,'_blank' );
		                   }, 5000);    
		              }
		        });
 			}
      });

 });

function get_parent_material(mat_id){
	 var mat_code = $("#material_id_"+mat_id+" .mat_code_cls_"+mat_id).html();
	 var mat_name = $("#material_id_"+mat_id+" .mat_name_cls_"+mat_id).html();
	 $("#mat_parent_id").val(mat_id);
	 $("#parent_mat_code").val(mat_code);
	 $("#parent_mat_name").val(mat_name);
	 $("#assign_parent_material").modal('hide');
}


function get_mat_code(mat_code,mat_id){
	  $.ajax({
	  		url: baseURL +"purchase/check_mat_code",
	  		headers: { 'Authorization': user_token },
	  		method: "POST",
	  		data: JSON.stringify({mat_id:mat_id}),
	  		contentType:false,
	    	cache:false,
	    	processData:false,
	    	beforeSend: function () {

	    	},
	    	success: function(result, status, xhr) {
	    		if(result > 0){
	    			swal({
			          	 title: "",
  						 text: "This Material already created in master material",
  						 type: "warning",
			        });
			         $("#matcode-box, #matname-box").hide();
	    		}else{
	    			$("#mat_code").val(val);
				    $("#matcode-box, #matname-box").hide();
	    		}
	    	}

	  });
}

function remove_materials(mat_id){
		swal({
	  		title: "Are you sure?",
	  		text: "You want to delete this material?",
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
	  				url: baseURL +"purchase/delete_material",
	  				headers: { 'Authorization': user_token }, 
	  				data: 'mat_id='+mat_id,
	  				success: function(result){
	  					swal.close();
	  					var res = JSON.parse(result);
	  					if(res.status == 'success'){
	  						 $('table tr').filter("[data-row-id='" + mat_id + "']").remove();	
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

function materials_detail(mat_id,row){
	if(typeof mat_id !== "undefined") {
		$.ajax({
			type: "POST",
		 	url: baseURL+'purchase/get_material_detail',
		 	headers: { 'Authorization': user_token },
		 	cache: false,
		 	data: JSON.stringify({mat_id:mat_id}),
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

function add_sub_material(mat_id){
	//alert(mat_id)
	$("#pop_up_sub_material")[0].reset();
	$("#add_sub_material_form").modal('show');
	$("#pop_up_sub_material #pop_up_mat_id").val(mat_id);
}