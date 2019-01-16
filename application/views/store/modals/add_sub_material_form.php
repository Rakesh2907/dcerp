<div class="modal fade" id="add_sub_material_form">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
				<h4 class="modal-title" id="material_name"></h4>
			</div> 
			<form id="pop_up_sub_material" action="purchase/save_sub_material">           
	            <div class="modal-body">
	            		<div class="row" style="margin-top: 10px;">
		            		<div class="form-group"> 
			            		<div class="col-sm-6">
					                <label for="sub_material">Unit:</label>    
			                    </div>
			                    <div class="col-sm-6">
					               <select name="unit_id" id="unit_id" class="form-control select2">
					               	  <?php foreach($sub_units as $key => $units) { ?>
					               	  	 	<option value="<?php echo $units['unit_id']?>"><?php echo $units['unit']?></option>	
					               	  <?php	} ?>
					               </select>    
			                    </div>
			                </div>    
		                </div>
		            	<div class="row" style="margin-top: 10px;">
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
		        	 <button type="button" class="btn btn-default" onclick="open_batch_number()">Cancal</button>
	            </div> 	
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
</div>