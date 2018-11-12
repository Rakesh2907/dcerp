<div class="modal fade" id="purchase_order_materials">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Materials</h4>
			</div>            
            <div class="modal-body">
            	    <div class="row">
            	    	<div class="col-sm-12">
            	    	 	<button type="button" class="btn btn-primary"style="margin-bottom: 11px;" id="button_select" data-action="<?php echo $submit_type;?>" data-inward="<?php echo $inward_id;?>" onclick="material_select()">Select</button>
            	    	 	<!-- <button type="button" class="btn btn-primary" style="margin-bottom: 11px;" onclick="add_material()">Add Material</button> -->
            	    	</div> 	
            	    </div>
	            	<div class="row">
	            		<div class="col-sm-12" style="overflow: auto;height: 556px;" id="purchase_order_material_list">
			                 
	                    </div>
	                </div> 
	                <div class="row">		
	               			
	                </div>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
</div>