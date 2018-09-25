/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */

 $(document).ready(function () {

 		var table_department = $('#department_list').DataTable({
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

 		$('#dep_list-select-all').on('click', function(){
        	var rows = table_department.rows({ 'search': 'applied' }).nodes();
        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
  		});

	  $('#department_list tbody').on('change', 'input[type="checkbox"]', function(){
	        if(!this.checked){
	           var el = $('#dep_list-select-all').get(0);
	           if(el && el.checked && ('indeterminate' in el)){
	              el.indeterminate = true;
	           }
	        }
	   });

 		$("#department_form").on('submit',function(e){
 			e.preventDefault();
 		}).validate({
 			rules: {
 				dep_name: {
 					required: true,
	                minlength: 3,
	                lettersonly: false
 				}
 			},
 			messages: {
 				dep_name: {
 					required: "Please enter department name"
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
	                	$(".content-wrapper").LoadingOverlay("hide");
	                	if(result > 0){
	                		swal({
  										title: "",
  										text: "Record Added Successfully",
  										type: "success",
  										timer:1000,
  										showConfirmButton: false
								},function(){
									swal.close();
			               			load_page('department/edit_department_form/'+result);
			               	});
	                	}else if(result == 'updated'){
	                		swal({
  										title: "",
  										text: "Record Updated Successfully",
  										type: "success",
  										timer:1000,
  										showConfirmButton: false
								},function(){
									    swal.close();
										load_page('department/index');
							});
	                	}
	                }
     	        });

 			}
 		});

 		$("#export_department").on('click',function(){
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
		              url: baseURL +"department/export_department",
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
		                  window.open(baseURL +'department/export_department/?ids='+join_selected_values,'_blank' );
		                   }, 5000);    
		              }
		        });
 			}
 		});
 });

 function remove_department(dep_id){
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
	      					url: baseURL +"department/delete_department",  
	      					cache:false,  
	      					data: 'ids='+dep_id,  
	      					beforeSend:function(){
	      							swal.close();
	      					},
						    success: function(response)  { 
						    	swal.close();
						    	var res = JSON.parse(response);
						    	if(res.status == 'success'){
						    		$('table tr').filter("[data-row-id='" + dep_id + "']").remove();
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