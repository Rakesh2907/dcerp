<div class="modal fade" id="user_access_permission">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="user_name">Access Permissions</h4>
			</div>            
            <div class="modal-body">
              	<form id="pop_up_access_permission" action="settings/save_access_permission">
              		<div class="row">
	            		<div class="col-sm-12">
			               <div class="box-body">
			               		<div class="row">
			               			<div class="col-md-12">
			               				<div class="form-group">
			               					<label for="menu_name">Access Keys:</label>	
			               			    </div>		
			               			</div>
			               		</div>
			               		<div class="row">
			               			<div class="col-md-12">
			               				<div class="form-group">
			               					 <select name="access_keys[]" multiple="multiple" class="" id="access_keys">
			               					 	<?php if(!empty($access_keys)){?>
			               					 		<?php foreach($access_keys as $key => $val){?>
			               					 			<option value="<?php echo $val['permission_keys']?>"><?php echo $val['permission_keys']?></option>
			               					 		<?php }?>
			               					 	<?php }?>
              	    						 </select>
			               				</div>
			               			</div>
			               		</div>			
			               </div>
			            </div>
			         </div> 
			          <div class="row">		
		               	 <div class="col-sm-12">
		               	 	 <input type="hidden" name="emp_user_id" value="" id="emp_user_id" />
		               	 	 <button type="submit" class="btn btn-primary pull-right">Save & Close</button>
		               	 </div>
		              </div>  	      					
              	</form>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
</div>