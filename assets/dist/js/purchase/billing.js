/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */

 $(document).ready(function () {

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

function set_billing_date(inward_id,vendor_id){

	if(inward_id > 0){
		
		$.ajax({
			 type: "POST",
		 	 url: baseURL+'purchase/get_payments_plan_details',
		 	 headers: {'Authorization': user_token},
		 	 cache: false,
		 	 data: JSON.stringify({inward_id:inward_id,vendor_id:vendor_id}),
		 	 beforeSend: function () {

		 	 },
		 	 success: function(result){
		 	 	$('#payment_plan_form').html('');
		 	 	$('#payment_plan_form').html(result);
		 	 	$('#billing_plan').modal('show');
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