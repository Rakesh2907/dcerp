<div class="modal fade" id="assign_parent_material">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="Material_name">Materials</h4>
			</div>            
            <div class="modal-body">
	            	<div class="row">
	            		<div class="col-sm-12">
			               <table id="material_list_pop_up" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_cat_list_info">
			                      <thead>
			                          <th>Material id</th>
			                          <th>Material code</th>
			                          <th>Material Name</th>
			                      </thead>
			                      <tbody>
				                      	<?php 
				                      	 if(!empty($material_list)){?>
				                      	 	<?php foreach($material_list as $key => $material) {?>
						                        <tr id="material_id_<?php echo $material['mat_id']?>" ondblclick="get_parent_material(<?php echo $material['mat_id'];?>)">
						                            <td><?php echo $material['mat_id']?></td>
						                            <td class="mat_code_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_code']?></td>
						                            <td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
						                        </tr>
						                     <?php } ?>   
				                    	<?php }else{ ?>
				                    		<tr><td colspan="3">No Material found</td></tr>
				                    	<?php } ?>
			                      </tbody>
			                </table>  
	                    </div>
	                </div> 
	                <div class="row">		
	               			
	                </div>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
</div>