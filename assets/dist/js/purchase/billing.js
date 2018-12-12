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
		$('#pop_up_add_payments_plan')[0].reset();
		$("#pop_up_add_payments_plan #pop_up_inward_id").val(inward_id);
        
		$.ajax({
			 type: "POST",
		 	 url: baseURL+'purchase/get_payments_plan_details',
		 	 headers: {'Authorization': user_token},
		 	 cache: false,
		 	 data: JSON.stringify({inward_id:inward_id}),
		 	 beforeSend: function () {

		 	 },
		 	 success: function(result){
		 	 	
		 	 }
		});

		/*$.ajax({
			 type: "POST",
		 	 url: baseURL+'purchase/get_invoice_details',
		 	 headers: {'Authorization': user_token},
		 	 cache: false,
		 	 data: JSON.stringify({inward_id:inward_id,vendor_id:vendor_id}),
		 	 beforeSend: function () {

		 	 },
		 	 success: function(result){
		 	 	 var res = JSON.parse(result);
     			 if(res.status == 'success'){

     			 	if(res.inward_details.length > 0){
     			 		$("#pop_up_add_payments_plan #invoice_number").html(res.inward_details[0].invoice_number);
		 	 			$("#pop_up_add_payments_plan #invoice_amount").html('(Rs) '+res.inward_details[0].total_bill_amt);
		 	 			$("#pop_up_add_payments_plan #total_bill_amount").val(res.inward_details[0].total_bill_amt);
		 	 			$("#add_new_billing_date").modal('show');
     			 	}	

		 	     }if(res.status == 'error'){
		 	     	swal({
								            title: "",
					  						text: res.message,
					  						type: "error",
					});
		 	     }		
		 	 }
		});*/
	}
}

function total_installment_amout(row_id){
	var total_installment_amout = 0;
	$('[name^="rows"]').each(function() {
          var row_id = $(this).val();
          var installment_amount = $("input[name='amount["+row_id+"]']").val();
          total_installment_amout = total_installment_amout + parseFloat(installment_amount);
    });
	$("#total_installment_amount").val(parseFloat(total_installment_amout).toFixed(2));
}

function set_balance_amount(installment_amount,row_id){
	var total_bill_amount = $("#total_bill_amount").val();

	if(total_bill_amount >= installment_amount){
		if(row_id == '1'){
			var balance_amount = (total_bill_amount - installment_amount);
	    }else{
	    	var previous_bal_amout =  $("input[name='balance_amount["+(row_id-1)+"]']").val();
	    	if(previous_bal_amout >= installment_amount){
	    		var balance_amount = (previous_bal_amout - installment_amount);
	    	}else{
	    		$("input[name='amount["+row_id+"]']").val(0);
				$("input[name='balance_amount["+row_id+"]']").val(0); 
	    		swal({
					title: "",
					text: 'Installment amout less then total amount',
					type: "error",
				});
	    	}	
	    }		
		$("input[name='balance_amount["+row_id+"]']").val(parseFloat(balance_amount).toFixed(2));
		total_installment_amout(row_id);
	}else{
	  if(row_id == '1'){
	  		$("input[name='amount["+row_id+"]']").val(0);
			$("input[name='balance_amount["+row_id+"]']").val(0);
	  }
		swal({
			title: "",
			text: 'Installment amout less then total amount',
			type: "error",
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