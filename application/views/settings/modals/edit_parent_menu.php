<div class="modal fade" id="edit_parent_menu">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="edit_menu">Edit Menu</h4>
			</div>            
            <div class="modal-body">
               <form id="pop_up_parent_menu_edit" action="settings/save_parent_menu">
	            	<div class="row">
	            		<div class="col-sm-12">
			               <div class="box-body">
			               		<div class="row">
			               			<div class="col-md-6">
			               				<div class="form-group">
			               					<label for="menu_name">Menu Name:</label>
			               					<input class="form-control" id="menu_name" placeholder="Enter Menu Name" name="menu_name" autocomplete="off" value="" type="text" required="">
			               			    </div>		
			               			</div>
			               			<div class="col-md-6">
			               				<div class="form-group">
			               					<label for="menu_description">Menu Description:</label>
			               					<input class="form-control" id="menu_description" placeholder="Enter Menu Description" name="menu_description" autocomplete="off" value="" type="text">
			               			    </div>		
			               			</div>	
			               		</div>	
			               		<div class="row">
			               			<div class="col-md-6">
			               				<div class="form-group">
			               					<label for="menu_links">Menu Link:</label>
			               					<input class="form-control" id="menu_links" placeholder="Enter Menu Link" name="menu_links" autocomplete="off" value="" type="text">
			               			    </div>		
			               			</div>
			               			<div class="col-md-6">
			               				<div class="form-group">
			               					<label for="menu_icon">Menu Icon:</label>
			               					<input class="form-control" id="menu_icon" placeholder="Enter Menu Icon" name="menu_icon" autocomplete="off" value="" type="text">
			               			    </div>
			               			</div>	
			               		</div>
			               		<div class="row">
			               			<div class="col-md-6">
			               				<div class="form-group">
			               					<label for="sub_menu">Sub Menu:</label>
			               					<select class="form-control" name="sub_menu">
			               						<option value="0">No</option>
			               						<option value="1">Yes</option>
			               					</select>
			               			    </div>	
			               			</div>    
			               			<div class="col-md-6">
			               			    	<div class="form-group">
			               			    		<label for="user_id">Access Users:</label>
			               			    		<select id="user_id" multiple="multiple"  class="form-control" name="user_id[]">
			               			    		<?php foreach($myusers as $key => $user){?>
												    <option value="<?php echo $user['id']?>"><?php echo $user['name'] ?></option>
												<?php } ?>
												</select>
			               			    	</div>	
			               			</div>	
			               		</div>	
			               </div>   
	                    </div>
	                </div> 
	                <div class="row">		
		               	 <div class="col-sm-12">
		               	 	<input type="hidden" name="menu_id" value="" />	
		               	    <input type="hidden" name="submit_type" value="edit" />	
		               		<button type="submit" class="btn btn-primary pull-right">Save & Close</button>
		                 </div> 		
	                </div>
               </form>		
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
</div>