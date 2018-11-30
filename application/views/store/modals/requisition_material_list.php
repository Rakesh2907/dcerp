<div class="modal fade" id="requisition_material_list">
	<div class="modal-dialog modal-lg" style="width:1600px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="material_requision">Materials</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
            	    	 	<button type="button" class="btn btn-primary"style="margin-bottom: 11px;" id="button_select" data-action="<?php echo $submit_type;?>" data-inward="<?php echo $outward_id;?>" onclick="material_select()">Select Outward</button>
            	    	 	<!-- <button type="button" class="btn btn-primary" style="margin-bottom: 11px;" onclick="add_material()">Add Material</button> -->
            	    </div> 	
					<div class="col-sm-12" id="requision_material_list_pop_up">
							
					</div>
					<div class="col-sm-12">
            	    	 	<button type="button" class="btn btn-primary pull-right"style="margin-bottom: 11px;" id="button_select" data-action="<?php echo $submit_type;?>" data-inward="<?php echo $outward_id;?>" onclick="generate_purchase_requisation()">Select Requisation To Purchase</button>
            	    	 	<!-- <button type="button" class="btn btn-primary" style="margin-bottom: 11px;" onclick="add_material()">Add Material</button> -->
            	    </div>	
				</div>	
			</div>	
		</div>	
	</div>	
</div>	