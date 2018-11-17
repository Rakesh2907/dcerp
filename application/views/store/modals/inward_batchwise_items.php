<div class="modal fade" id="inward_batchwise_items">
	<div class="modal-dialog modal-lg" style="width: 95%">
        <div class="modal-content">
           <form id="batch_form" action="store/save_batch_number" method="POST">	
		        <div class="modal-header">
				    <button type="button" class="btn btn-primary pull-right" onclick="add_sub_material()">Add Sub Material</button>
					<h4 class="modal-title">Inward Batch Number</h4>
				</div>            
	            <div class="modal-body">
	            	    <div class="row">
	            	    	  <div class="col-md-4">
				                    <div class="form-group">
				                       <label for="poup_material_code">Material Code</label>
				                       <input class="form-control" type="text" name="poup_material_code" id="poup_material_code" value="" required disabled="disabled">
				                    </div>  
				               </div>
				               <div class="col-md-4">
				                    <div class="form-group">
				                       <label for="popup_material_name">Material Name:</label>
				                       <input class="form-control" type="text" name="popup_material_name" id="popup_material_name" value="" required disabled="disabled">
				                    </div>   
				               </div>	
	            	    </div>
		            	<div class="row">
		            		<div class="col-sm-12" style="overflow: auto;" id="sub_material_list">
		                    </div>
		                </div> 
		                <div class="row">		
		               		 <?php //$this->load->view('store/modals/sub_views/material_batch_list'); ?>	
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