<div class="col-sm-12"> 
	<table id="selected_material_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="material_list_info">
			<thead>
			   <th></th>
			   <th>Material code</th>
			   <th>Material Name</th>
			   <th>Units</th>
			   <th>Require Qty</th>
			   <th>Action(s)</th>
		    </thead>
		    <tbody>
		    	<?php 
				     if(!empty($selected_materials)){?>
				     	<?php foreach($selected_materials as $key => $material) {
				     	?>
						    <tr id="material_id_<?php echo $material['mat_id']?>" data-row-id="<?php echo $material['mat_id']?>"> 

						    	<td></td>
						        <td class="mat_code_cls_<?php echo $material['mat_id']?>">
						        	<?php echo $material['mat_code']?>
						        <input type="hidden" name="mat_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_code']?>" />
						        <input type="hidden" name="mat_req_id[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_req_id']?>" />
						        </td>
						        <td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
						        <td>
						        	<select class="form-control valid select2" name="unit_id[<?php echo $material['mat_id']?>]" id="unit_id" style="width:40%;" onchange="update_units(this.value,<?php echo $material['mat_id']?>,'erp_material_quotation_draft')">
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
						        <td class="require_qty_cls_<?php echo $material['mat_id']?>">
						        	<input name="require_qty[<?php echo $material['mat_id']?>]" id="require_qty[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['require_qty']?>" type="text" autocomplete="off" onblur="set_quantity(this.value,<?php echo $material['mat_id']?>,'erp_material_quotation_draft')"/>	
						        </td>
						        
						        <td><span style="cursor: pointer;" onclick="remove_selected_material(<?php echo $material['mat_id']?>,<?php echo $material['dep_id']?>)"><i class="fa fa-close"></i></span></td>
						    </tr> 
						<?php } ?> 
				    <?php } ?>		
		    </tbody>	 			  
	</table>	
</div>