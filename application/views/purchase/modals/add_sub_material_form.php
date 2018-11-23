<div class="modal fade" id="add_sub_material_form">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="material_name"></h4>
			</div> 
			<form id="pop_up_sub_material" action="purchase/save_sub_material">           
	            <div class="modal-body">
		            	<div class="row">
		            		<div class="form-group"> 
			            		<div class="col-sm-6">
					                <label for="sub_material">Sub Material:</label>    
			                    </div>
			                    <div class="col-sm-6">
					               <input class="form-control" id="sub_material" name="sub_material" placeholder="Enter Sub Material" type="text" value="" required>     
			                    </div>
			                </div>    
		                </div> 	
	            </div>
	            <div class="modal-footer">
	            	 <input type="hidden" name="pop_up_mat_id" id="pop_up_mat_id" value="">
	            	 <button type="submit" class="btn btn-primary">Save</button>
	            </div> 	
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
</div>