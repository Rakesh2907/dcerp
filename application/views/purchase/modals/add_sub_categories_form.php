<div class="modal fade" id="add_new_subcategories">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="category_name"></h4>
			</div>            
            <div class="modal-body">
               <form id="pop_up_sub_category" action="purchase/save_sub_category">
	            	<div class="row">
	            		<div class="col-sm-12">
			                  <table id="sub_cat_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_cat_list_info">
			                      <thead>
			                          <th>Allow Stock PO</th>
			                          <th>Sub Category Code</th>
			                          <th>Sub Category Name</th>
			                      </thead>
			                      <tbody>
			                        <tr>
			                            <td><input type="checkbox" class="inputs" name="allow_po[]" id="allow_1" /></td>
			                            <td><input type="text" class="form-control inputs" name="sub_cat_code[]" id="sub_cat_code_1" /></td>
			                            <td><input type="text" class="form-control inputs lst" name="sub_cat_name[]" id="sub_cat_name_1" /></td>
			                        </tr>
			                      </tbody>
			                  </table>  
	                    </div>
	                </div> 
	                <div class="row">		
	               		<input type="hidden" name="cat_for" id="cat_for" value="" />
	               		<input type="hidden" name="cat_stockable" id="cat_stockable" value="" />
	               		<input type="hidden" name="pop_up_cat_id" id="pop_up_cat_id" value="" />
		               	 <div class="col-sm-12">	
		               		<button type="button" class="btn btn-primary pull-right" id="add_subcategories">Save & Close</button>
		                 </div> 		
	                </div>
               </form>		
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
</div>