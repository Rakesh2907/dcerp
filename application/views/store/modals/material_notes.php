<div class="modal fade" id="add_material_notes">
	 <div class="modal-dialog modal-lg">
	 	 <div class="modal-content">
	 	 	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Materials Notes:</span></h4>
				<h6><span><i id="material_name_note"></i></h6>
			</div>
			<div class="modal-body">
				<form action="store/save_notes" id="material_note_form">
            	    <div class="row">
            	    	<div class="col-sm-12">
            	    		 <div class="form-group">
            	    		 	<textarea class="form-control" rows="5" cols="50" name="material_note" id="material_note" required=""></textarea>
            	    		 </div>
            	        </div>		
            	    </div>
            	    <div id="footer_content">
		            	<div class="box-footer">
		            	    	 <div class="col-sm-12">
		            	    		 <button class="btn btn-primary pull-right" type="submit">Add Note</button>
		            	    	 </div>	
		                 </div> 

	            	    	<input type="hidden" name="note_mat_id" value="" />
	            	    	<input type="hidden" name="detail_id" value="0" />
	            	    	<input type="hidden" name="dep_id" value="<?php echo $dep_id?>" />
            	    </div>
            	 </form>    
            </div> 	     	
	 	 </div>	
	 </div>	
</div>	