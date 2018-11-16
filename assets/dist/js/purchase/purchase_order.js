$(document).ready(function(){
	 $('#supplier_list_pop_up').DataTable();
	 $('.select2').select2(); 

	 var po_general_material_list = $('#quo_material_list').DataTable({
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        columnDefs: [
            { width: '10%', targets: 0 }
        ],
        fixedColumns: true
    });

	 
	 po_general_material_list.columns.adjust().draw();

	 var table_pending_po = $('#pending_po_list').DataTable({
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

	 $('#pending_po_list-select-all').on('click', function(){
	        	var rows = table_pending_po.rows({ 'search': 'applied' }).nodes();
	        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	 });

	 $('#pending_po_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#pending_po_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
		        }
	  });


	 $('#pending_po_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_pending_po.row( tr );
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


	 var table_approved_po = $('#approved_po_list').DataTable({
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

	 $('#approved_po_list-select-all').on('click', function(){
	        	var rows = table_approved_po.rows({ 'search': 'applied' }).nodes();
	        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	 });

	 $('#approved_po_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#approved_po_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
		        }
	  });


	 $('#approved_po_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_approved_po.row( tr );
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

	 var table_completed_po = $('#completed_po_list').DataTable({
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

	 $('#completed_po_list-select-all').on('click', function(){
	        	var rows = table_completed_po.rows({ 'search': 'applied' }).nodes();
	        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	 });

	 $('#completed_po_list tbody').on('change', 'input[type="checkbox"]', function(){
		        	if(!this.checked){
		           		var el = $('#completed_po_list-select-all').get(0);
		           if(el && el.checked && ('indeterminate' in el)){
		              el.indeterminate = true;
		           }
		        }
	  });


	 $('#completed_po_list tbody').on('click', '.dt-body-center', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_completed_po.row( tr );
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


	 $("#quotation_number").on('change',function(){
	 	 var quo_id = $(this).val();
	 	 if($.isNumeric(quo_id)){

	 	 	var supplier_id = $("#supplier_id").val();
	 		var po_type = $("#po_type").val();
	 		var dep_id = $("#dep_id").val();

	 	 	$.ajax({
	 	 		url: baseURL +"purchase/get_vendor_approved_quotation_details",
	 	 		headers: { 'Authorization': user_token },
	 	 		method: "POST",
	 	 		data: JSON.stringify({quo_id:quo_id,supplier_id:supplier_id,po_type:po_type,dep_id:dep_id}),
	 	 		contentType:false,
	    		cache:false,
	    		processData:false,
	    		beforeSend: function () {
	    			//$(".content-wrapper").LoadingOverlay("show");
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

	 $("#po_form").on('submit',function(e){
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
	 			po_date: {
	 				required : 'Please select purchase order date'
	 			}
	 	  },
	 	  submitHandler: function(form) {
	 	  	    var form_data = new FormData(form);
	 	  	    form_data.append('cat_id', $("#cat_id").val());

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

     $("#approval_flag").on('change',function(){
     	var flag = $(this).val();
	     	if(flag == 'approved'){
	     		 swal({
					     title: "",
		  				 text: 'After Approved status, Purchase Order is not editable.',
		  				 type: "warning",
			     });
	     	}
     });

     $("#dep_id").on('change',function(){
     		if($(this).val().length > 0)
     		{
     			$("#supplier_id").val(0);
     			$("#vendor_name").val('');
     			$("#requisition_number").val('');
     			$("#req_id").val(0);
     		}
     });
});

function check_department(cat_id,submit_type){
		var dep_id = $("#dep_id").val();
		if(dep_id.length > 0){
			$.ajax({
		 		url: baseURL +"purchase/general_materials",
		 		headers: { 'Authorization': user_token },
		  		method: "POST",
		  		data: JSON.stringify({cat_id:cat_id,submit_type:submit_type}),
		  		contentType:false,
		    	cache:false,
		    	processData:false,
		    	beforeSend: function () {

		    	},
		    	success: function(result, status, xhr) {
		    		 $("#general_pop_up").html('');
		    		 $("#general_pop_up").html(result);
		    		 $("#gereral_materials").modal('show');
		    	}
	 		});
		}else{
			 swal({
					     title: "",
		  				 text: 'Please select department',
		  				 type: "warning",
			 });
			 $("#cat_id").val("");
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

function browse_vendor(){
	 $("#supplier_listing").modal('show');	
}

function get_vendor(vendor_id,poform,form_type){
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
		    		 $(".content-wrapper").LoadingOverlay("show");
		    	},
		    	success: function(result, status, xhr) {
		    		  $(".content-wrapper").LoadingOverlay("hide");
		    		 $("#quotation_number").html('');
		    		 $("#quotation_number").html(result);
		    	}
	   });
    }else{
       if(form_type == 'insert'){
       		$("#req_id").val(0);
    	 	$("#requisition_number").val('');
       }
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

function total_mat_amount(mat_id){
		var qty = $("input[name='qty["+mat_id+"]']").val();
	 	var mrate = $("input[name='rate["+mat_id+"]']").val();
	 	var mat_amount = qty * mrate;
	 	return mat_amount;
}
function reset_val(mat_id){
			 $("input[name='cgst_per["+mat_id+"]']").val(0);
			 $("input[name='cgst_amt["+mat_id+"]']").val(0);
			 $("input[name='sgst_per["+mat_id+"]']").val(0);
			 $("input[name='sgst_amt["+mat_id+"]']").val(0);
			 $("input[name='igst_per["+mat_id+"]']").val(0);
			 $("input[name='igst_amt["+mat_id+"]']").val(0);
			 $("#total_cgst").val(0);
			 $("#total_sgst").val(0);
			 $("#total_igst").val(0);
			 $("#total_amt").val(0);
}

function mypo_qty(qty,mat_id){
	var amount = total_mat_amount(mat_id);
	//console.log(amount);
	$("input[name='mat_amount["+mat_id+"]']").val(amount);
	$("input[name='discount_per["+mat_id+"]']").val(0);
	$("input[name='discount["+mat_id+"]']").val(0);
	reset_val(mat_id);
	total_amount();
	total_bill_amount();	
}

function mypo_rate(rate,mat_id){
	//var qty = $("input[name='qty["+mat_id+"]']").val();
	//var mrate = rate;
	var amount = total_mat_amount(mat_id);
	//console.log(amount);
	$("input[name='mat_amount["+mat_id+"]']").val(amount);
	$("input[name='discount_per["+mat_id+"]']").val(0);
	$("input[name='discount["+mat_id+"]']").val(0);
	reset_val(mat_id);
	total_amount();
	total_bill_amount();
}

function mypo_discount_per(discount_per,mat_id){

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
			 reset_val(mat_id);
			 total_amount();
			 total_cgst();
			 total_sgst();
			 total_igst();
			 total_bill_amount();
	 }
	 
}

function mypo_discount_amt(discount_amt,mat_id){
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
				reset_val(mat_id); 
				total_amount();
				total_cgst();
				total_sgst();
				total_igst();
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

function mypo_cgst_per(cgst_per,mat_id){
		var cgst_per = $("input[name='cgst_per["+mat_id+"]']").val();
	 	var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();


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
    $("#total_cgst").val(parseFloat(total_cgst).toFixed(2));
}


function mypo_sgst_per(sgst_per,mat_id){
		var sgst_per = $("input[name='sgst_per["+mat_id+"]']").val();
	 	var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();

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

    $("#total_sgst").val(parseFloat(total_sgst).toFixed(2));
}


function mypo_igst_per(igst_per,mat_id){
	 	var igst_per = $("input[name='igst_per["+mat_id+"]']").val();
	 	var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();
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

    $("#total_igst").val(parseFloat(total_igst).toFixed(2));
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

function terms_condition_prompt(mytable,headers,coloumn){
	bootbox.prompt(headers, function(result){
	 if (result != null){	
			$.ajax({
		 		url: baseURL +"purchase/insert_terms_conditions",
		 		headers: { 'Authorization': user_token },
		  		method: "POST",
		  		data: JSON.stringify({new_terms:result, table:mytable, coloumn:coloumn}),
		  		contentType:false,
		    	cache:false,
		    	processData:false,
		    	beforeSend: function () {
		    		 $(".content-wrapper").LoadingOverlay("show");
		    	},
		    	success: function(myresult, status, xhr) {
		    		  $(".content-wrapper").LoadingOverlay("hide");
		    		 $("#"+coloumn).html('');
		    		 $("#"+coloumn).html(myresult);
		    		 $('#'+coloumn).val(result).trigger('change');
		    	}
		 	});	
	   }
	});
}

function remove_purchase_order(po_id){

	swal({
	  		title: "Are you sure?",
	  		text: "You want to delete this purchase order?",
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
						url: baseURL +"purchase/remove_purchase_order",
						headers: { 'Authorization': user_token },
						method: "POST",
						data:JSON.stringify({po_id:po_id}),
						contentType:false,
						cache:false,
						processData:false,
						beforeSend: function () {
							 swal.close();
						},
						success: function(result, status, xhr){
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
}

function send_po_quotation(po_id,vender_id,quo_id){
		swal({
	  		title: "Are you sure?",
	  		text: "This purchase order send to vendor?",
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
	  					url: baseURL +"purchase/send_purchase_order_quotation",
						headers: { 'Authorization': user_token },
						method: "POST",
						data:JSON.stringify({po_id:po_id,vendor_id:vender_id,quo_id:quo_id}),
						contentType:false,
						cache:false,
						processData:false,
						beforeSend: function () {
							 $(".content-wrapper").LoadingOverlay("show");
						},
						success: function(result, status, xhr){
							 $(".content-wrapper").LoadingOverlay("hide");
							var res = JSON.parse(result);
							if(res.status == 'success'){
								swal({
					  										title: "",
					  										text: res.message,
					  										type: "success",
					  										timer:3000,
					  										showConfirmButton: false
								})
							}else if(res.status == 'error'){
									load_page(res.redirect);
							}
						}	
	  			});
	  		}
	  })
}
function po_amend(po_id){

   		swal({
	  		title: "Are you sure?",
	  		text: "Need to approval, after amend purchase order ?",
	  		type: "warning",
	  		showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true
	  },function(isConfirm){
	  		if(isConfirm){
	  			load_page('purchase/edit_purchase_order_form/po_id/'+po_id+'/yes');
	  		}
	  });
   
}

function change_po_status(status,po_id){
		if(status == 'approved')
		{
		      swal({
				title: "Are you sure?",
	  			text: "After Approved status, Purchase Order is not editable.",
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
	  					url: baseURL +"purchase/change_purchase_order_status",
						headers: { 'Authorization': user_token },
						method: "POST",
						data:JSON.stringify({po_id:po_id,status:status}),
						contentType:false,
						cache:false,
						processData:false,
						beforeSend: function () {
							 $(".content-wrapper").LoadingOverlay("show");
						},
						success: function(result, status, xhr){
							 $(".content-wrapper").LoadingOverlay("hide");
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
				 	$("#approval_flag_"+po_id).val('pending');
				 }    		
			  });
	    }
}

function remove_po_material_details_draft(mat_id,dep_id){

		var cat_id = $("#cat_id").val();
		var supplier_id = $("#supplier_id").val();

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
	  					url: baseURL +"purchase/remove_po_material_details_draft",
						headers: { 'Authorization': user_token },
						method: "POST",
						data:JSON.stringify({mat_id:mat_id,dep_id:dep_id,cat_id:cat_id,supplier_id:supplier_id}),
						contentType:false,
						cache:false,
						processData:false,
						beforeSend: function () {
							swal.close();
						},
						success: function(result, status, xhr){
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
                            	})
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