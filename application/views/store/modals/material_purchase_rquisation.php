<div class="modal fade" id="material_purchase_rquisation">
	<div class="modal-dialog modal-lg" style="width:1600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="material_requision">Need to Purchase Material(s)</h4>
			</div>
			<form id="purchase_req_form" method="POST" action="store/save_purchase_requisation">
				<div class="modal-body">
					<div class="row"> 	
						<div class="col-sm-12" id="purchase_material_list_pop_up">
								
						</div>	
					</div>	
				</div>	
				<div class="modal-footer">
					<input type="hidden" name="store_req_id" id="store_req_id" value="">
					<button type="submit" class="btn btn-primary">Send Requisation</button>
					<?php if($form_type == 'bachwise_outward_form'){ ?>
		        		 <button type="button" class="btn btn-default" onclick="reload_requisation_page()">Cancal</button>
		            <?php }else{ ?>
		            	 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		            <?php } ?>			
			    </div>
			</form>	
		</div>	
	</div>	
</div>	