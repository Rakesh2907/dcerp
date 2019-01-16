<div class="modal fade" id="inward_batchwise_items">
	<div class="modal-dialog modal-lg" style="width: 95%">
        <div class="modal-content">
           <form id="batch_form_qc" action="quality/save_batch_number" method="POST">	
		        <div class="modal-header">
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
	            	       <div class="box box-default">
		            			<div class="box-header with-border" id="material_batch_number_list" style="overflow: auto; height: 220px">		
		               		 		<?php //$this->load->view('store/modals/sub_views/material_batch_list'); ?>	
		               		    </div>
		               		</div>    		
		                </div>   
		            	<div class="row">
		            		<div class="box box-default">
        						<div class="box-body">
        							 <div class="col-sm-12" style="overflow: auto; height: 300px" id="sub_material_list">
		                    		 </div>
        					    </div>		
		            	 	</div>	
		                </div> 
	            </div>
	            <div class="modal-footer">
	            		<input type="hidden" name="myinward_id" id="myinward_id" value=""/>
		              	<input type="hidden" name="mymat_id" id="mymat_id" value=""/>
		                <input type="hidden" name="mypo_id" id="mypo_id" value=""/> 
		                <input type="hidden" name="inward_form_type" id="inward_form_type" value="<?php echo $form_type?>"> 

	            	    <button type="submit" class="btn btn-primary">Save</button>
	        			<button type="button" class="btn btn-default" onclick="reload_page_qc(<?php echo $inward_id?>,'<?php echo $form_type?>')">Cancal</button>
	      		</div>
      	  </form>	
        </div>
    <!-- /.modal-content -->
    </div>
</div>