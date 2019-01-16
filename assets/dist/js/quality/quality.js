/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, December 2018
 */

 $(document).ready(function(){
 		$("#quality_status_switch").tooltip({'placement':'top'}); 
 		$(".qc_certificate").tooltip({'placement': 'right'});

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

		 $("#batch_form_qc").on('submit',function(e){ 
       			e.preventDefault();
     	 }).validate({
         	rules: {},
         	messages: {},
         	submitHandler: function(form) {
          		var form_data = new FormData(form);
          		var page_url = $(form).attr('action');

              	$.ajax({
                  url: baseURL+'quality/compare_batch_po_qty',
                  headers: { 'Authorization': user_token },
                  method: "POST",
                  data: form_data,
                  contentType:false,
                  cache:false,
                  processData:false,
                  beforeSend: function (){

                  },
                  success:  function(result, status, xhr) {
                      var res = JSON.parse(result);
                      if(res.status == 'success')
                      {
                              $.ajax({
                                    url: baseURL +""+page_url,
                                    headers: { 'Authorization': user_token },
                                    method: "POST",
                                    data: form_data,
                                    contentType:false,
                                    cache:false,
                                    processData:false,
                                    beforeSend: function (){
                                          $("#inward_batchwise_items").modal('hide');
                                    },
                                    success: function(result, status, xhr) {
                                     var res = JSON.parse(result);
                                     if(res.status == 'success'){
                                           swal({
                                              title: "",
                                              text: res.message,
                                              type: "success",
                                              showConfirmButton: true
                                           },function(isConfirm){ 
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
                      }else if(res.status == 'error'){
                        swal({
                           title: "",
                           text: res.message,
                           type: "error",
                        });
                      }
                  }
              	});          
              	return false; 
         }
       });
    
       $('#batch_form_qc #bar_code_1').rules('add', {
            required: true
       });
      
       $('#batch_form_qc #batch_no_1').rules('add', {
            required: true
       });

       $('#batch_form_qc #lot_no_1').rules('add', {
            required: true
       });

       $('#batch_form_qc #batch_received_qty_1').rules('add', {
            number: true,
            required: true
       });

       $('#batch_form_qc #accepted_qty_1').rules('add', {
            number: true,
            required: true
       });

       $('#batch_form_qc #expire_date_1').rules('add', {
            required: true
       });


       $("#qc_inward_form").on('submit',function(e){
		 	    e.preventDefault();
		 }).validate({
		 	 rules: {
		 	 },
		 	 messages: {
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
		 	 	 	 	 }else if(res.status == 'warning'){
 							swal({
								            title: "",
					  						text: res.message,
					  						type: "warning",
					     	 });
		 	 	 	 	 }
		 	 	 	 }
		 	 	 });
		 	 }
		 });

 });

function reload_page_qc(inward_id,form_type){
	  $("#inward_batchwise_items").modal('hide');
      load_page('quality/view_inward_material_form/inward_id/'+inward_id);
}

function add_batch_number(inward_id,po_id,mat_id){
		 $("#inward_batchwise_items").modal({backdrop: 'static', keyboard: false});

		 $("#myinward_id").val(inward_id);
		 $("#mymat_id").val(mat_id);
		 $("#mypo_id").val(po_id);

		 if(mat_id > 0)
		 {
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
		 		url: baseURL+'quality/get_batch_number',
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
		 		url: baseURL+'quality/get_sub_materials',
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

function search_material_inward(){
	var from_grn_date = $('#from_grn_date').val();
	var to_grn_date = $('#to_grn_date').val();
	var vandor_id = $('#filter_vendor_id').val();

	$.ajax({
	 	 	type: "POST",
	 	 	url: baseURL +"Commonrequesthandler_ui/check_date_differance",
	 	 	headers: { 'Authorization': user_token },
	 	 	cache: false,
			data: JSON.stringify({from_date:from_grn_date,to_date:to_grn_date,vandor_id:vandor_id}),
			beforeSend: function(){
			},
			success: function(result){
				var res = JSON.parse(result);

				 if(res.status == 'success'){
				 		load_page('quality/grr_passing/'+from_grn_date+'/'+to_grn_date+'/'+vandor_id);
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

 function inward_materials_details(inward_id,row){
	if(typeof inward_id !== "undefined") {
		$.ajax({
			type: "POST",
		 	url: baseURL+'quality/get_inward_material_details',
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
		var qty = $("input[name='qc_accepted_qty["+mat_id+"]']").val();
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
		  				text: 'You are already set discount in amount',
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
		  				text: 'You are already set discount in percentage',
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

function set_accepted_qty(batch_status,batch_id){
			if(batch_status == 'regretted'){
				$("#accepted_qty_"+batch_id).val(0);
			}else{
				var received_qty = $("#batch_received_qty_"+batch_id).val();
				$("#accepted_qty_"+batch_id).val(received_qty);
			}
}

function sub_set_accepted_qty(batch_status,sub_mat_id,batch_id){
		if(batch_status == 'regretted'){
				$("#sub_mat_accepted_qty_"+sub_mat_id+"_"+batch_id).val(0);
		}else{
				var received_qty = $("#sub_mat_received_qty_"+sub_mat_id+"_"+batch_id).val();
				$("#sub_mat_accepted_qty_"+sub_mat_id+"_"+batch_id).val(received_qty);
		}
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