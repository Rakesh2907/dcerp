/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

 $(document).ready(function () {

 	var table_category = $('#category_list').DataTable({
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

  $('#category_list-select-all').on('click', function(){
        var rows = table_category.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });

  $('#category_list tbody').on('change', 'input[type="checkbox"]', function(){
        if(!this.checked){
           var el = $('#category_list-select-all').get(0);
           if(el && el.checked && ('indeterminate' in el)){
              el.indeterminate = true;
           }
        }
   });


 	   var i = $('table tr').length;

		$("#sub_cat_list").on('keyup', '.lst', function(e) {
		  var code = (e.keyCode ? e.keyCode : e.which);
		  if (code == 13) {
		    html = '<tr>';
		    html += '<td><input type="checkbox" class="inputs" name="allow_po[]" id="allow_' + i + '" /></td>';
		    html += '<td><input type="text" class="form-control inputs" name="sub_cat_code[]" id="sub_cat_code_' + i + '" /></td>';
		    html += '<td><input type="text" class="form-control inputs lst" name="sub_cat_name[]" id="sub_cat_name_' + i + '" /></td>';
		    html += '</tr>';
		    $('#sub_cat_list').append(html);
		       $(this).focus().select();
		    i++;
		  }
		});

		$("#sub_cat_list").on('keydown', '.inputs', function(e) {
		  var code = (e.keyCode ? e.keyCode : e.which);
		  if (code == 13) {
		    var index = $('.inputs').index(this) + 1;
		    $('.inputs').eq(index).focus();
		  }
		});

		$("#category_form").validate({
				 	rules: {
			            cat_code: {
			                required: true,
			                minlength: 1,
			                lettersonly: false
			            },
			            cat_name: {
			                required: true,
			                minlength: 3,
			                lettersonly: false
			            }
	        		},
	        		messages: {
			            cat_code: {
			                required: "Please enter category code"
			            },
			            cat_name: {
			                required: "Please enter category name"
			            }
			        }
			 });

		$("#add_categories").on('click',function(){
			 if (!$("#category_form").valid()) { // Not Valid
                return false;
            } else {
                var form = $("#category_form");
                var page_url = $(form).attr('action');
                var cat_code = $("input[name=cat_code]").val();
                var cat_name = $("input[name=cat_name]").val();
                var cat_for = $("select[name=cat_for]").val();
                var cat_stockable = $("select[name=cat_stockable]").val();
                var submit_type = $("#submit_type").val();
                var cat_id = $("#cat_id").val();
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
	                		data: JSON.stringify({cat_id:cat_id, submit_type:submit_type, cat_code:cat_code, cat_name:cat_name, cat_for:cat_for, cat_stockable:cat_stockable, sub_cat_code:sub_cat_code, sub_cat_name: sub_cat_name}),
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
 });

function remove_sub_category(sub_cat_id){
	$("#sub_id_"+sub_cat_id).remove();
}

function remove_category(cat_id){
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
	      			url: baseURL +"purchase/delete_category",  
	      			cache:false,  
	      			data: 'ids='+cat_id, 
	      			beforeSend:function(){
	      				swal.close();
	      			},
				    success: function(response)  {
				        swal.close(); 
				    	var res = JSON.parse(response);
				    	if(res.status == 'success'){
				          	$('table tr').filter("[data-row-id='" + cat_id + "']").remove();
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