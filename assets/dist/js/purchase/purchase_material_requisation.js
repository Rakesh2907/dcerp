function purchase_change_status(status,req_id){
	if(status == 'approved')
	 {
			 swal({
			  		title: "Are you sure?",
			  		text: "Before approval, please confirmed by related department/management",
			  		type: "warning",
			  		showCancelButton: true,
		            confirmButtonClass: "btn-danger",
		            confirmButtonText: "Approved",
		            cancelButtonText: "Ok",
		            closeOnConfirm: true,
		            closeOnCancel: true
			  },function(isConfirm){
			  		if(isConfirm){
			  			 $.ajax({
							 	type: "POST",
							 	url: baseURL +"purchase/purchase_change_approval_status", 
							  	headers: { 'Authorization': user_token },
							  	cache:false, 
							  	data: 'req_id='+req_id+'&approval_status='+status,
							  	beforeSend: function () {
				     					swal.close();
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
			  		}else{
			  			$("#purchase_approval_flag").val('pending');
			  		}
			  })
	 }else{
	 	 $("#purchase_approval_flag").val('pending');
	 }
}

function generate_quotation_request(req_id){

	  var allVals = []; 
	  $(".sub_chk:checked").each(function() {  
          allVals.push($(this).attr('data-id'));
      }); 

	   if(allVals.length <=0)  { 
	   		swal({
  					title: "",
  					text: "Please select material row(s).",
  					type: "warning",
			});
	   }else{
	   		swal({
	 		title: "Are you sure?",
	  		text: "These material send for quotation?",
	  		type: "warning",
	  		showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true	
	 	  },function(isConfirm){
	 		 if(isConfirm)
	 		 {
	 		 		var join_selected_values = allVals.join(",");  

		 			$.ajax({
		 				type: "POST",
		 				url: baseURL+'store/generate_quotation_request',
		 				headers: { 'Authorization': user_token },
		 				cache: false,
		 				data: 'req_id='+req_id+'&mat_id='+join_selected_values,
		 				beforeSend: function () {
		 					swal.close();
		 				},
		 				success: function(result){
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
	 }
}

function send_quotation_request(req_id) {
	 var allVals = []; 
	  $(".sub_chk:checked").each(function() {  
          allVals.push($(this).attr('data-id'));
      }); 

       if(allVals.length <=0){
       		 swal({
  					title: "",
  					text: "Please select material row(s).",
  					type: "warning",
			 });
       }else{
       		swal({
	 		title: "Are you sure?",
	  		text: "Send quotation request to assign vendor?",
	  		type: "warning",
	  		showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true	
	 	  },function(isConfirm){
	 	  		if(isConfirm){
	 	  			var join_selected_values = allVals.join(","); 

	 	  			$.ajax({
		 				type: "POST",
		 				url: baseURL+'store/send_quotation_request',
		 				headers: { 'Authorization': user_token },
		 				cache: false,
		 				data: 'req_id='+req_id+'&mat_id='+join_selected_values,
		 				beforeSend: function () {
		 					swal.close();
		 				},
		 				success: function(result){
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
	 	  })
       }
}