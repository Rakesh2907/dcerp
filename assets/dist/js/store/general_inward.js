$(document).ready(function(){

	 var inward_material_list = $('#inward_material_list').DataTable({
		 	    scrollY:        "300px",
        		scrollX:        true,
        		scrollCollapse: true,
        		paging:         false,
        		fixedColumns:   true,
		        fixedColumns:   {
		            leftColumns: 1
		        }
	 }).destroy();

	 
	 inward_material_list.columns.adjust().draw();
});

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

function browse_material(){
	var po_vendor_id = $("#po_vendor_id").val();
		 		var po_id = $("#po_id").val(); 

	if(po_vendor_id > 0 && po_id > 0){
		 			$.ajax({
		 					type: "POST",
		 					url: baseURL+'store/get_purchase_order',
		 					headers: { 'Authorization': user_token },
		 					cache: false,
		 					data: 'vendor_id='+po_vendor_id+'&po_id='+po_id+'&po_type=general_po',
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
	 	$("input[name='cgst_amt["+mat_id+"]']").val(cgst_amt);
	 	total_cgst();
	 	total_bill_amount();
}

function mypo_sgst_per(sgst_per,mat_id){
		var sgst_per = $("input[name='sgst_per["+mat_id+"]']").val();
	 	var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();

	 	var sgst_amt = ((sgst_per/100) * mat_amount);
	 	$("input[name='sgst_amt["+mat_id+"]']").val(sgst_amt);
	 	total_sgst();
	 	total_bill_amount();
}

function mypo_igst_per(igst_per,mat_id){
	 	var igst_per = $("input[name='igst_per["+mat_id+"]']").val();
	 	var mat_amount = $("input[name='mat_amount["+mat_id+"]']").val();
	 	var igst_amt = ((igst_per/100) * mat_amount);
	 	$("input[name='igst_amt["+mat_id+"]']").val(igst_amt);
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