/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, November 2018
 */

$(document).ready(function(){
	$('.select2').select2();
	$("#quality_status_switch").tooltip({'placement':'top'}); 
	 var inward_material_list = $('#inward_material_list').DataTable({
		 	    scrollY:        "300px",
			    scrollX:        true,
			    scrollCollapse: true,
			    paging:         false
	 });

	 var table_inward = $("#material_inward_list").DataTable({
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
            	'pageLength': 50
	     });

		 $('#material_inward_list tbody').on('click', '.dt-body-center', function () {
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

	 $("#inward_form").on('submit',function(e){
		 	    e.preventDefault();
	 }).validate({
		 	 rules: {
		 	 	vendor_name: {
		 	 		required: true
		 	 	},
		 	 	po_id: {
		 	 		required: true
		 	 	},
		 	 	state_code: {
		 	 		required: true
		 	 	},
		 	 	invoice_date: {
		 	 		required: true	
		 	 	},
		 	 	invoice_number: {
		 	 		required: true
		 	 	}
		 	 },
		 	 messages: {
		 	 	vendor_name : {
		 	 		required : 'Please select Vendor'
		 	 	},
		 	 	po_id: {
		 	 		required : 'Please Purchase Order'
		 	 	},
		 	 	state_code: {
		 	 		required : 'Please enter state code'
		 	 	},
		 	 	invoice_date: {
		 	 		required: 'Please select invoice date'
		 	 	},
		 	 	invoice_number: {
		 	 		required: 'Please enter invoice number'
		 	 	}
		 	 },
		 	 submitHandler: function(form) {
		 	 	 var form_data = new FormData(form);
		 	 	 var page_url = $(form).attr('action');	

		 	 	 var quality_status = $("#quality_status").is(':checked') ? 'check' : 'uncheck';

     	         form_data.append('quality_status',quality_status);

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


     	 $('[name^="received_qty"]').each(function() {
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

        $('[name^="cgst_per"]').each(function() {
		        $(this).rules('add', {
		            required: true,
		            number: true,
		        })
     	});

     	$('[name^="sgst_per"]').each(function() {
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

function material_select()
{
				var allMat = [];

		  		$(".sub_chk:checked").each(function() {  
	          		allMat.push($(this).attr('data-id'));
	     		});

	     		 var action_form = $("#button_select").attr('data-action');
	     		 var inward_id = $("#button_select").attr('data-inward');
	     		 var po_id = $("#po_id").val();
	     		 var invoice_date = $("#invoice_date").val();
	     		 var invoice_number = $("#invoice_number").val();
	     		 var chalan_date = $("#chalan_date").val();
	     		 var chalan_number = $("#chalan_number").val();
	     		 var gate_entry_date = $("#gate_entry_date").val();
	     		 var gate_entry_no = $("#gate_entry_no").val();
	     		 var grn_date = $("#grn_date").val();
	     		 var grn_number = $("#grn_number").val();
	     		 var vendor_name = $("#vendor_name").val();
	     		 var po_vendor_id = $("#po_vendor_id").val();
	     		 var state_code = $("#state_code").val();
	     		 var category_name = $("#category_name").val();
	     		 var po_cat_id = $("#po_cat_id").val();

	     		 if(allMat.length <=0){
	     		 	swal({
  						title: "",
  						text: "Please select materials.",
  						type: "warning",
			    	});
	     		 }else{
	     		 	var join_selected_values = allMat.join(","); 
	     		 	 $.ajax({
	     		 	 	type: "POST",  
	     		 	 	url: baseURL +"store/selected_purchase_order_details",
	     		 	 	headers: { 'Authorization': user_token },
	     		 	 	cache: false,
				    	data: JSON.stringify({mat_ids:join_selected_values,inward_id:inward_id,po_id:po_id,action:action_form,invoice_date:invoice_date,invoice_number:invoice_number,chalan_date:chalan_date,chalan_number:chalan_number,gate_entry_date:gate_entry_date,gate_entry_no:gate_entry_no,grn_date:grn_date,grn_number:grn_number,vendor_name:vendor_name,po_vendor_id:po_vendor_id,state_code:state_code,po_type:'general_po',category_name:category_name,po_cat_id:po_cat_id}),
				    	beforeSend: function(){
								$(".content-wrapper").LoadingOverlay("show");
						},
						success: function(result){
								$(".content-wrapper").LoadingOverlay("hide");
								$("#purchase_order_materials").modal('hide');
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
}

function browse_material(form_type,inward_id){
	var po_vendor_id = $("#po_vendor_id").val();
		 		var po_id = $("#po_id").val(); 

	if(po_vendor_id > 0 && po_id > 0){
		 			$.ajax({
		 					type: "POST",
		 					url: baseURL+'store/get_purchase_order',
		 					headers: { 'Authorization': user_token },
		 					cache: false,
		 					data: 'inward_id='+inward_id+'&vendor_id='+po_vendor_id+'&po_id='+po_id+'&form_type='+form_type+'&po_type=general_po',
		 					beforeSend: function(){
								$(".content-wrapper").LoadingOverlay("show");
							},
							success: function(result){
								$(".content-wrapper").LoadingOverlay("hide");

								$("#purchase_order_material_list").html('');
								$("#purchase_order_material_list").html(result);
								$("#purchase_order_materials").modal('show');
							}
		 			});
    }else{
		 			swal({
					     title: "",
		  				 text: 'Please select Vendor and Purchase Order',
		  				 type: "warning",
			 		});
    }
}	

function get_po_details(po_id,form_type){

				 var po_id = po_id;
	     		 var invoice_date = $("#invoice_date").val();
	     		 var invoice_number = $("#invoice_number").val();
	     		 var chalan_date = $("#chalan_date").val();
	     		 var chalan_number = $("#chalan_number").val();
	     		 var gate_entry_date = $("#gate_entry_date").val();
	     		 var gate_entry_no = $("#gate_entry_no").val();
	     		 var grn_date = $("#grn_date").val();
	     		 var grn_number = $("#grn_number").val();
	     		 var po_vendor_id = $("#po_vendor_id").val();
	     		 var state_code = $("#state_code").val();
	     		 var po_cat_id = $("#po_cat_id").val();

	     		 if(form_type == 'add_form'){
	     		 	 $.ajax({
	     		 	 	type: "POST",  
	     		 	 	url: baseURL +"store/load_purchase_order_details",
	     		 	 	headers: { 'Authorization': user_token },
	     		 	 	cache: false,
				    	data: JSON.stringify({po_id:po_id,invoice_date:invoice_date,invoice_number:invoice_number,chalan_date:chalan_date,chalan_number:chalan_number,gate_entry_date:gate_entry_date,gate_entry_no:gate_entry_no,grn_date:grn_date,grn_number:grn_number,po_vendor_id:po_vendor_id,state_code:state_code,po_cat_id:po_cat_id,po_type:'general_po'}),
				    	beforeSend: function(){
								//$(".content-wrapper").LoadingOverlay("show");
						},
						success: function(result){
								//$(".content-wrapper").LoadingOverlay("hide");
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

	     		 } 		 
}

function get_vendor(po_id,po_type){

  if(po_id > 0)
  {
	  		$.ajax({
				type: "POST",
				url: baseURL+'store/general_inward_vendor_details',
				headers: { 'Authorization': user_token },
				cache: false,
				data: 'po_id='+po_id+'&po_type='+po_type,
				beforeSend: function(){

				},
				success: function(result){
					var res = JSON.parse(result);
					if(res.status == 'success'){
						$("#vendor_name").val(res.supp_firm_name);
						$("#po_vendor_id").val(res.supplier_id);
						$("#category_name").val(res.cat_name);
						$("#po_cat_id").val(res.cat_id);
						get_po_details(po_id,'add_form');
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

function total_cgst(){
	var total_cgst = 0;
	$('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var cgst_amt = $("input[name='cgst_amt["+mat_id+"]']").val();
          total_cgst = total_cgst + parseFloat(cgst_amt);
    });
    $("#total_cgst").val(parseFloat(total_cgst).toFixed(2));
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

function total_igst(){
	var total_igst = 0;
	$('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var igst_amt = $("input[name='igst_amt["+mat_id+"]']").val();
          total_igst = total_igst + parseFloat(igst_amt);
    });

    $("#total_igst").val(parseFloat(total_igst).toFixed(2));
}


function mypo_cgst_per(cgst_per,mat_id){
		var cgst_per = $("input[name='cgst_per["+mat_id+"]']").val();
	 	var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();


	 	var cgst_amt = ((cgst_per/100) * mat_amount);
	 	$("input[name='cgst_amt["+mat_id+"]']").val(cgst_amt.toFixed(2));
	 	total_cgst();
	 	total_bill_amount();
}

function mypo_sgst_per(sgst_per,mat_id){
		var sgst_per = $("input[name='sgst_per["+mat_id+"]']").val();
	 	var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();

	 	var sgst_amt = ((sgst_per/100) * mat_amount);
	 	$("input[name='sgst_amt["+mat_id+"]']").val(sgst_amt.toFixed(2));
	 	total_sgst();
	 	total_bill_amount();
}

function mypo_igst_per(igst_per,mat_id){
	 	var igst_per = $("input[name='igst_per["+mat_id+"]']").val();
	 	var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();
	 	var igst_amt = ((igst_per/100) * mat_amount);
	 	$("input[name='igst_amt["+mat_id+"]']").val(igst_amt.toFixed(2));
	 	total_igst();
	 	total_bill_amount();
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

function total_mat_amount(mat_id){
		var qty = $("input[name='received_qty["+mat_id+"]']").val();
	 	var mrate = $("input[name='rate["+mat_id+"]']").val();
	 	var mat_amount = qty * mrate;
	 	return mat_amount;
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

function remove_purchase_order_material(mat_id,po_id){

		var invoice_date = $("#invoice_date").val();
		var invoice_number = $("#invoice_number").val();
		var chalan_date = $("#chalan_date").val();
	 	var chalan_number = $("#chalan_number").val();
	    var gate_entry_date = $("#gate_entry_date").val();
	    var gate_entry_no = $("#gate_entry_no").val();
	    var grn_date = $("#grn_date").val();
	    var grn_number = $("#grn_number").val();
	    var po_vendor_id = $("#po_vendor_id").val();
	    var state_code = $("#state_code").val();	
	    var po_cat_id = $("#po_cat_id").val();

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
						type: "POST",
						url: baseURL+'store/remove_purchase_order_material',
						headers: { 'Authorization': user_token },
						cache: false,
						data: JSON.stringify({mat_id:mat_id,po_id:po_id,invoice_date:invoice_date,invoice_number:invoice_number,chalan_date:chalan_date,chalan_number:chalan_number,gate_entry_date:gate_entry_date,gate_entry_no:gate_entry_no,grn_date:grn_date,grn_number:grn_number,po_vendor_id:po_vendor_id,state_code:state_code,po_cat_id:po_cat_id,po_type:'general_po'}),
						beforeSend: function(){
							$(".content-wrapper").LoadingOverlay("show");
						},
						success: function(result){
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
	 	  		}
	 });

}

function add_batch_number(inward_id,po_id,mat_id){
	$("#inward_batchwise_items").modal({backdrop: 'static', keyboard: false});
	
	$("#myinward_id").val(inward_id);
    $("#mymat_id").val(mat_id);
    $("#mypo_id").val(po_id);

    if(mat_id > 0){
		 	 $.ajax({
            		type: "POST",
            		url: baseURL+'purchase/get_material',
            		headers: { 'Authorization': user_token },
            		cache: false,
            		data: JSON.stringify({mat_id:mat_id}),
		            beforeSend: function () {
		            },
		            success: function(result){
		                var res = JSON.parse(result);
		                if(res.status == 'success'){
		                	//console.log(res);
		                   $("#poup_material_code").val(res.material_code);
		                   $("#popup_material_name").val(res.material_name);

		                   get_batch_number(inward_id,mat_id,po_id);
		                   get_sub_materials(inward_id,mat_id,po_id);
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
}

function get_batch_number(inward_id,mat_id,po_id){
	$.ajax({
		 		type: "POST",
		 		url: baseURL+'commonrequesthandler_ui/get_batch_number',
				headers: { 'Authorization': user_token },
				cache: false,
				data: JSON.stringify({mat_id:mat_id,inward_id:inward_id,po_id:po_id}),
				beforeSend: function(){
				},
				success: function(result){
					$("#material_batch_number_list").html("");
					$("#material_batch_number_list").html(result);
				}
   });
}

function get_sub_materials(inward_id,mat_id,po_id){
	$.ajax({
		 		type: "POST",
		 		url: baseURL+'commonrequesthandler_ui/get_sub_materials',
				headers: { 'Authorization': user_token },
				cache: false,
				data: JSON.stringify({mat_id:mat_id}),
				beforeSend: function(){
				},
				success: function(result){
					$("#sub_material_list").html("");
					$("#sub_material_list").html(result);
				}
   });
}

function search_general_inward(){
	var from_grn_date = $('#from_grn_date').val();
	var to_grn_date = $('#to_grn_date').val();
	var vandor_id = $('#filter_vendor_id').val();

	$.ajax({
	 	 	type: "POST",
	 	 	url: baseURL +"Commonrequesthandler_ui/check_date_differance",
	 	 	headers: { 'Authorization': user_token },
	 	 	cache: false,
			data: JSON.stringify({from_date:from_grn_date,to_date:to_grn_date}),
			beforeSend: function(){
			},
			success: function(result){
				var res = JSON.parse(result);

				 if(res.status == 'success'){
				 		load_page('store/general_inward/'+from_grn_date+'/'+to_grn_date+'/'+vandor_id);
				 }else{
				 	swal({
							title: "",
						  	text: res.message,
						  	type: "error",
					});
				 }
			}
	 });
}

function update_inward_val(state_code_val,inward_id,field_name){
		$.ajax({
						type: "POST",
						url: baseURL+'store/update_inward_field',
						headers: { 'Authorization': user_token },
						cache: false,
						data: JSON.stringify({field_val:state_code_val,inward_id:inward_id,field_name:field_name}),
						beforeSend: function(){
							$(".content-wrapper").LoadingOverlay("show");
						},
						success: function(result){
							$(".content-wrapper").LoadingOverlay("hide");
							var res = JSON.parse(result);
							if(res.status == 'success'){
									
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