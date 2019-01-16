function search_export(){
	var from_date = $("#from_outward_date").val();
	var to_date = $("#to_outward_date").val();
	var dep_id = $("#filter_dep_id").val();

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
				 		export_outward_excel_sheet(from_date,to_date,dep_id);
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

function export_outward_excel_sheet(from_date,to_date,dep_id){
		$.ajax({
	 	 	type: "POST",
	 	 	url: baseURL +"Commonrequesthandler_ui/export_outward_excel_sheet",
	 	 	headers: { 'Authorization': user_token },
	 	 	cache: false,
			data: 'from_date='+from_date+'&to_date='+to_date+'&dep_id='+dep_id,
			beforeSend: function(){
				 $(".content-wrapper").LoadingOverlay("show",{
		                   image       : "",
		                   fontawesome : "fa fa-cog fa-spin"
		         });
			},
			success: function(result){
				setTimeout(function(){
		                  $(".content-wrapper").LoadingOverlay("hide");
		                  window.open(baseURL +'Commonrequesthandler_ui/export_outward_excel_sheet/?from_date='+from_date+'&to_date='+to_date+'&dep_id='+dep_id,'_blank' );
		        }, 5000); 
			}
	 });
}