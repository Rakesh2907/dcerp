/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, January 2019
 */
 $(document).ready(function () {

 });

 function search_export(){
	var from_date = $("#from_grn_date").val();
	var to_date = $("#to_grn_date").val();
	var vendor_id = $('#filter_vendor_id').val();

	$.ajax({
	 	 	type: "POST",
	 	 	url: baseURL +"Commonrequesthandler_ui/check_date_differance",
	 	 	headers: { 'Authorization': user_token },
	 	 	cache: false,
			data: JSON.stringify({from_date:from_date,to_date:to_date}),
			beforeSend: function(){
			},
			success: function(result){
				var res = JSON.parse(result);
				 if(res.status == 'success'){
				 		export_grr_excel_sheet(from_date,to_date,vendor_id);
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

function export_grr_excel_sheet(from_date,to_date,vendor_id){
		$.ajax({
	 	 	type: "POST",
	 	 	url: baseURL +"reports/export_grr_passing_excel_sheet",
	 	 	headers: { 'Authorization': user_token },
	 	 	cache: false,
			data: 'from_date='+from_date+'&to_date='+to_date+'&vendor_id='+vendor_id,
			beforeSend: function(){
				 $(".content-wrapper").LoadingOverlay("show",{
		                   image       : "",
		                   fontawesome : "fa fa-cog fa-spin"
		         });
			},
			success: function(result){
				setTimeout(function(){
		                  $(".content-wrapper").LoadingOverlay("hide");
		                  window.open(baseURL +'reports/export_grr_passing_excel_sheet/?from_date='+from_date+'&to_date='+to_date+'&vendor_id='+vendor_id,'_blank' );
		        }, 5000); 
			}
	 });
}