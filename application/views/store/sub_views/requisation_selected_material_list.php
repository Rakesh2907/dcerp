<div class="col-sm-12"> 
	<table id="selected_material_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="material_list_info">
			<thead>
			   <th>Material Notes</th>
			   <th>Material Code</th>
			   <th>Material Name</th>
			   <th>Unit</th>
			   <th>Material Require Date</th>
			   <th>Require Qty</th>
			   <th>Material Require Users</th>
			   <th>Action(s)</th>
		    </thead>
		    <tbody>
		    	<?php 
				     if(!empty($selected_materials)){?>
				     	<?php foreach($selected_materials as $key => $material) {
				     	?>
						    <tr id="material_id_<?php echo $material['mat_id']?>" data-row-id="<?php echo $material['mat_id']?>">
						    	<td>
						    		<button type="button" class="btn btn-primary" onclick="add_material_note(<?php echo $material['mat_id']?>,<?php echo $dep_id;?>,'draft')"><i class="fa fa-pencil-square-o"></i></button>
						    		<textarea style="display: none" name="mat_note[<?php echo $material['mat_id']?>]"><?php echo $material['material_note']?></textarea>
						    	</td>
						        <td class="mat_code_cls_<?php echo $material['mat_id']?>">
						        	<?php echo $material['mat_code']?>
						        <input type="hidden" name="mat_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_code']?>" />
						        </td>
						        <td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
						        <td class="unitid_cls_<?php echo $material['mat_id']?>" width="100">
						        	 <select class="form-control valid select2" name="unit_id[<?php echo $material['mat_id']?>]" id="unit_id" onchange="update_units_requisation(this.value,<?php echo $material['mat_id']?>,<?php echo $dep_id;?>,'erp_material_requisation_draft')">
							        	 <?php 
							        	  	if(!empty($unit_list)){
							        	  		foreach ($unit_list as $key => $val) {
							        	  			$selected = '';
							        	  			if($val['unit_id'] == $material['unit_id']){
							        	  				$selected = 'selected="selected"';
							        	  			}
							        	 ?>
							        	 	<option value="<?php echo $val['unit_id']?>" <?php echo $selected;?>><?php echo $val['unit']?></option>	
							        	 <?php 		
							        	 		}
							        	  	}
							        	 ?>	
                                    </select>
						      	
						        </td>
						        <td class="require_date_cls_<?php echo $material['mat_id']?>">
						        	  <div class="input-group date">
							        		<div class="input-group-addon">
			                                          <i class="fa fa-calendar"></i>
			                                </div>

			                                <?php
			                                  if(empty($material['require_date'])){
			                                  	$requireDate = '';
			                                  }else{
			                                  	$requireDate = date("d-m-Y",strtotime($material['require_date']));
			                                  } 
			                                ?>
							        		<input class="require_date" name="require_date[<?php echo $material['mat_id']?>]" id="require_date[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $requireDate;?>" type="text" onchange="set_require_date(this.value,<?php echo $material['mat_id']?>,<?php echo $dep_id;?>,'erp_material_requisation_draft')"/>	
						        	   </div>	
						        </td>
						        
						        <td class="require_qty_cls_<?php echo $material['mat_id']?>">
						        	<input name="require_qty[<?php echo $material['mat_id']?>]" id="require_qty[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['require_qty']?>" type="text" onblur="set_quantity_requisation(this.value,<?php echo $material['mat_id']?>,<?php echo $dep_id;?>,'erp_material_requisation_draft')"/>	
						        </td>
						        <td class="require_users_cls_<?php echo $material['mat_id']?>">
						        	<select class="form-control select2" multiple="multiple" data-placeholder="Select Employee"
                        style="width: 100%;" name="user_mgm_user[<?php echo $material['mat_id']?>][]">
                        				<?php foreach($require_users as $key => $user_mgm){?>
						                  	<option value="<?php echo $user_mgm['id']?>"><?php echo $user_mgm['name']?></option>
						                <?php } ?>  
						             </select>
						        </td>
						        <td><span style="cursor: pointer;" onclick="remove_selected_material(<?php echo $material['mat_id']?>,<?php echo $material['dep_id']?>)"><i class="fa fa-close"></i></span></td>
						    </tr> 
						<?php } ?> 
				    <?php } ?>		
		    </tbody>	 			  
	</table>	
</div>