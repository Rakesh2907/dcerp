<div class="modal fade" id="inward_batchwise_items">
	<div class="modal-dialog modal-lg" style="width: 95%">
        <div class="modal-content">
           <form id="batch_form" action="store/save_batch_number" method="POST">	
		        <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Inward Batch Number</h4>
				</div>            
	            <div class="modal-body">
	            	    <div class="row">
	            	    	 	
	            	    </div>
		            	<div class="row">
		            		<div class="col-sm-12" style="overflow: auto;height: 556px;" id="sub_material_list">
		                    </div>
		                </div> 
		                <div class="row">		
		               			
		                </div>
	            </div>
	            <div class="modal-footer">
	            		<input type="hidden" name="myinward_id" id="myinward_id" value=""/>
		              	<input type="hidden" name="mymat_id" id="mymat_id" value=""/>
		                <input type="hidden" name="mypo_id" id="mypo_id" value=""/>  

	            	    <button type="submit" class="btn btn-default">Save</button>
	        			<button type="button" class="btn btn-default" data-dismiss="modal">Cancal</button>
	      		</div>
      	  </form>	
        </div>
    <!-- /.modal-content -->
    </div>
</div>
<script type="text/javascript">

	$("#batch_form").on('submit',function(e){ 
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
</script>