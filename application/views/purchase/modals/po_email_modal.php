<div class="modal fade" id="po_email_modal">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="po_email_vendor_name"></h4>
			</div> 
			<form id="pop_send_purchase_order_email" action="purchase/send_purchase_order_email">           
	            <div class="modal-body">
		            	<div class="row">
		            		<div class="form-group"> 
			            		<div class="col-sm-3">
					                <label for="purchase_from_email">From:</label>    
			                    </div>
			                    <div class="col-sm-6">
					               <input class="form-control" id="purchase_from_email" name="purchase_from_email" placeholder="" type="text" value="" required readonly>     
			                    </div>
			                </div>
			            </div>
			            <div class="row" style="margin-top: 10px;">    
			                <div class="form-group"> 
			            		<div class="col-sm-3">
					                <label for="vendor_to_email">To:</label>    
			                    </div>
			                    <div class="col-sm-6">
					               <input class="form-control" id="vendor_to_email" name="vendor_to_email" placeholder="" type="text" value="" required readonly>     
			                    </div>
			                </div> 
			           </div>
			           <div class="row" style="margin-top: 10px;">    
			                <div class="form-group"> 
			            		<div class="col-sm-3">
					                <label for="subject">Subject:</label>    
			                    </div>
			                    <div class="col-sm-6">
					               <input class="form-control" id="subject" name="subject" placeholder="" type="text" value="" required>     
			                    </div>
			                </div> 
			           </div>
			            <div class="row" style="margin-top: 10px;">      
			                <div class="form-group"> 
			            		<div class="col-sm-3">
					                <label for="po_message">Message:</label>    
			                    </div>
			                    <div class="col-sm-9">
					               <textarea name="po_message" id="po_message" class="form-control" rows="10" cols="80"></textarea>     
			                    </div>
			                </div>
			          </div>
			          <div class="row" style="margin-top: 10px;">      
			                <div class="form-group"> 
			            		<div class="col-sm-3">
					                <label for="po_attachment">Attachment:</label>    
			                    </div>
			                    <div class="col-sm-6">
					               <a id="po_attachment_link" href="" target="_blank"><span id="po_file"></span></a>     
			                    </div>
			                </div>  
		              </div> 	
	            </div>
	            <div class="modal-footer">
	            	 <input type="hidden" name="attachement_path" id="attachement_path" value="">
	            	 <button type="submit" class="btn btn-primary">Send To Vendor</button>
	            </div> 	
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
</div>
<script>
  $(function () {
    CKEDITOR.replace('po_message')
  })
</script>