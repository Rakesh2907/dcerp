$(document).ready(function(){
	 $('#supplier_list_pop_up').DataTable();
	 $('.select2').select2(); 

	 $("#quotation_number").on('change',function(){
	 	 var quo_id = $(this).val();
	 	 if($.isNumeric(quo_id)){

	 	 	$.ajax({
	 	 		url: baseURL +"purchase/get_vendor_approved_quotation_details",
	 	 		headers: { 'Authorization': user_token },
	 	 		method: "POST",
	 	 		data: JSON.stringify({quo_id:quo_id}),
	 	 		contentType:false,
	    		cache:false,
	    		processData:false,
	    		beforeSend: function () {
	    			$(".content-wrapper").LoadingOverlay("show");
	    		},
	    		success: function(result, status, xhr) {
	    			$("#po_material_details").html('');
	    			$("#po_material_details").html(result);
	    			$(".content-wrapper").LoadingOverlay("hide");
	    		}
	 	 	});
	 	 }
	 });

	 $("#po_form_requisition").on('submit',function(e){
	 		e.preventDefault();
	 }).validate({
	 	  rules: {
	 	  	  po_type: {
	 	  	  	 required: true
	 	  	  },
	 	  	  po_date: {
	 	  	  	 required: true
	 	  	  },
	 	  	  vendor_name: {
	 	  	  	 required: true
	 	  	  },
	 	  	  dep_id: {
	 	  	  	 required: true 
	 	  	  },
	 	  	  requisition_number: {
	 	  	  	 required: true 
	 	  	  }  
	 	  },
	 	  messages: {
	 			po_type : {
	 				required : 'Please select Purchase Order Type'
	 			},
	 			dep_id: {
	 				required : 'Please select department'
	 			},
	 			vendor_name: {
	 				required : 'Browse vender name'
	 			},
	 			requisition_number: {
	 				required : 'Browse requisition'
	 			},
	 			po_date: {
	 				required : 'Please select purchase order date'
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


	 $('[name^="qty"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

     $('[name^="rate"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

     $('[name^="expire_date"]').each(function() {
        $(this).rules('add', {
            required: true
        })
     });

      $('[name^="cgst_per"]').each(function() {
        $(this).rules('add', {
            required: true,
            number: true,
        })
     });

     $('[name^="cgst_amt"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

     $('[name^="sgst_per"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

      $('[name^="sgst_amt"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

      $('[name^="igst_per"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

     $('[name^="igst_amt"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

     $('[name^="mat_amount"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });

     $('[name^="discount"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });
});

function browse_vendor(){
	 $("#supplier_listing").modal('show');	
}

function get_vendor(vendor_id,poform){
	 var supplier_name = $("#vendor_id_"+vendor_id+" .supplier_name_cls_"+vendor_id).html();
	 $("#supplier_id").val(vendor_id);
	 $("#vendor_name").val(supplier_name);
	 $("#supplier_listing").modal('hide');

    if(poform == 'quotation'){	 
		$.ajax({
		  		url: baseURL +"purchase/get_vendor_approved_quotations",
		  		headers: { 'Authorization': user_token },
		  		method: "POST",
		  		data: JSON.stringify({vendor_id:vendor_id}),
		  		contentType:false,
		    	cache:false,
		    	processData:false,
		    	beforeSend: function () {

		    	},
		    	success: function(result, status, xhr) {
		    		 $("#quotation_number").html('');
		    		 $("#quotation_number").html(result);
		    	}
	   });
    }	
}

function get_material_requisation(req_id){
	 var req_number = $("#req_id_"+req_id+" .req_number_cls_"+req_id).html();
	 $("#req_id").val(req_id);
	 $("#requisition_number").val(req_number);
	 var supplier_id = $("#supplier_id").val();
	 var po_type = $("#po_type").val();

	  $.ajax({
	  	 	url: baseURL +"purchase/get_requisation_material_details",
	  	 	headers: { 'Authorization': user_token },
	  	 	method: "POST",
	  	 	data: JSON.stringify({req_id:req_id,supplier_id:supplier_id,po_type:po_type}),
		  	contentType:false,
		    cache:false,
		    processData:false,
		    beforeSend: function () {
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

	 $("#approved_material_requisition").modal('hide');
}

function browse_requisition(){
	 var dep_id = $("#dep_id").val();
	 if(dep_id!=''){
	 	$.ajax({
	 		url: baseURL +"purchase/department_material_requisition",
	 		headers: { 'Authorization': user_token },
	  		method: "POST",
	  		data: JSON.stringify({dep_id:dep_id}),
	  		contentType:false,
	    	cache:false,
	    	processData:false,
	    	beforeSend: function () {

	    	},
	    	success: function(result, status, xhr) {
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

function total_mat_amount(mat_id){
		var qty = $("input[name='qty["+mat_id+"]']").val();
	 	var mrate = $("input[name='rate["+mat_id+"]']").val();
	 	var mat_amount = qty * mrate;
	 	return mat_amount;
}

function mypo_rate(rate,req_id,mat_id){
	//var qty = $("input[name='qty["+mat_id+"]']").val();
	//var mrate = rate;
	var amount = total_mat_amount(mat_id);
	//console.log(amount);
	$("input[name='mat_amount["+mat_id+"]']").val(amount);
	$("#total_amt").val(0);
	total_amount();
	total_bill_amount();
}

function mypo_discount_per(discount_per,req_id,mat_id){

	 var discount_amt = $("input[name='discount["+mat_id+"]']").val();

	 if(discount_amt.length > 1){
	 			swal({
						title: "",
		  				text: 'You are already set discount amount',
		  				type: "warning",
			    });
	    var discount_per = $("input[name='discount_per["+mat_id+"]']").val(0);		    
	 }else{
	 		var discount_per = $("input[name='discount_per["+mat_id+"]']").val();
	 		var qty = $("input[name='qty["+mat_id+"]']").val();
	 		var mrate = $("input[name='rate["+mat_id+"]']").val();
	 		var mat_amount = total_mat_amount(mat_id);
	 		var minus_amt = ((discount_per/100) * mat_amount);

			 var new_mat_amout = parseFloat(mat_amount) - parseFloat(minus_amt);
			 $("input[name='mat_amount["+mat_id+"]']").val(0);
			 $("input[name='mat_amount["+mat_id+"]']").val(parseFloat(new_mat_amout));
			 $("#total_amt").val(0);
			 total_amount();
			 total_bill_amount();
	 }
	 
}

function mypo_discount_amt(discount_amt,req_id,mat_id){
		var discount_per = $("input[name='discount_per["+mat_id+"]']").val();

		if(discount_per.length > 1){
			swal({
						title: "",
		  				text: 'You are already set discount percentage',
		  				type: "warning",
			});
		    $("input[name='discount["+mat_id+"]']").val(0);  
		}else{
			var discount_amt = $("input[name='discount["+mat_id+"]']").val();  
	 		var mat_amount = total_mat_amount(mat_id);

	 		if(discount_amt > mat_amount){
	 			swal({
						title: "",
		  				text: 'Discount amount must be less than material amount',
		  				type: "warning",
			    });
			    $("input[name='mat_amount["+mat_id+"]']").val(mat_amount);
			    $("input[name='discount["+mat_id+"]']").val(0);  
	 		}else{
	 			var new_mat_amout = parseFloat(mat_amount) - parseFloat(discount_amt);
	 			$("input[name='mat_amount["+mat_id+"]']").val(0);
				$("input[name='mat_amount["+mat_id+"]']").val(parseFloat(new_mat_amout));
				$("#total_amt").val(0);
				total_amount();
				total_bill_amount();
	 		}
	 		
		}

}
function total_amount(){
	var total_amnt = 0;
	$('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();
          total_amnt = total_amnt + parseFloat(mat_amount);
    });
    $("#total_amt").val(parseFloat(total_amnt));
}

function mypo_cgst_per(cgst_per,req_id,mat_id){
		var cgst_per = $("input[name='cgst_per["+mat_id+"]']").val();
	 	var mat_amount = total_mat_amount(mat_id);

	 	var cgst_amt = ((cgst_per/100) * mat_amount);
	 	$("input[name='cgst_amt["+mat_id+"]']").val(cgst_amt);
	 	total_cgst();
	 	total_bill_amount();
}

function total_cgst(){
	var total_cgst = 0;
	$('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var cgst_amt = $("input[name='cgst_amt["+mat_id+"]']").val();
          total_cgst = total_cgst + parseFloat(cgst_amt);
    });
    $("#total_cgst").val(parseFloat(total_cgst));
}


function mypo_sgst_per(sgst_per,req_id,mat_id){
		var sgst_per = $("input[name='sgst_per["+mat_id+"]']").val();
	 	var mat_amount = total_mat_amount(mat_id);

	 	var sgst_amt = ((sgst_per/100) * mat_amount);
	 	$("input[name='sgst_amt["+mat_id+"]']").val(sgst_amt);
	 	total_sgst();
	 	total_bill_amount();
}

function total_sgst(){
	var total_sgst = 0;
	$('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var sgst_amt = $("input[name='sgst_amt["+mat_id+"]']").val();
          total_sgst = total_sgst + parseFloat(sgst_amt);
    });

    $("#total_sgst").val(parseFloat(total_sgst));
}


function mypo_igst_per(igst_per,req_id,mat_id){
	 	var igst_per = $("input[name='igst_per["+mat_id+"]']").val();
	 	var mat_amount = total_mat_amount(mat_id);

	 	var igst_amt = ((igst_per/100) * mat_amount);
	 	$("input[name='igst_amt["+mat_id+"]']").val(igst_amt);
	 	total_igst();
	 	total_bill_amount();
}

function total_igst(){
	var total_igst = 0;
	$('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var igst_amt = $("input[name='igst_amt["+mat_id+"]']").val();
          total_igst = total_igst + parseFloat(igst_amt);
    });

    $("#total_igst").val(parseFloat(total_igst));
}


function freight_amount(amt){
		total_bill_amount(); 
}

function other_charges(amt){
	 total_bill_amount(); 
}

function total_bill_amount(){
var total_bill_amt = parseFloat($("#total_amt").val()) + parseFloat($("#total_cgst").val()) + parseFloat($("#total_sgst").val()) + parseFloat($("#total_igst").val()) + parseFloat($("#freight_amt").val()) + parseFloat($("#other_amt").val());
	
	$("#total_bill_amt").val(total_bill_amt.toFixed(2));
}
