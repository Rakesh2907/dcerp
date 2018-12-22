<div class="col-sm-12"> 
	<table id="selected_material_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="material_list_info">
			<thead>
			   <th>Material Notes</th>
			   <th>Material Code</th>
			   <th>Material Name</th>
			   <th>Unit</th>
			   <th>Material Require Date</th>
			   <th>Material Require Qty</th>
			   <th>Material Require Users</th>
			   <th>Action(s)</th>
		    </thead>
		    <tbody>
		    	<?php 
				     if(!empty($selected_materials)){
				     ?>
				     	<?php foreach($selected_materials as $key => $material) {
				     			//echo "<pre>"; print_r($material); echo "</pre>";
				     	?>
						    <tr id="material_id_<?php echo $material['mat_id']?>" data-row-id="<?php echo $material['id']?>">
						    	<td>
						    		<button type="button" class="btn btn-primary" onclick="add_material_note(<?php echo $material['id']?>,'details')"><i class="fa fa-pencil-square-o"></i></button>
						    		<textarea style="display: none" name="mat_note[<?php echo $material['mat_id']?>]"><?php echo $material['material_note']?></textarea>
						        </td>
						        <td class="mat_code_cls_<?php echo $material['mat_id']?>">
						        	<?php echo $material['mat_code']?>
						        <input type="hidden" name="mat_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_code']?>" />
						        </td>
						        <td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
						        <td class="unitid_cls_<?php echo $material['mat_id']?>" width="100">
						        	 <select class="form-control valid select2" name="unit_id[<?php echo $material['mat_id']?>]" id="unit_id">
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
							        <?php 
							            if(!empty($material['require_date'])){
							        		$require_date = date("d-m-Y",strtotime($material['require_date']));
							        	}else{
							        		$require_date = '';
							        	} 
						        	?>	
						        	  <div class="input-group date">
							        		<div class="input-group-addon">
			                                          <i class="fa fa-calendar"></i>
			                                </div>
											<input class="require_date" name="require_date[<?php echo $material['mat_id']?>]" id="require_date[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $require_date;?>" type="text" />	
						        	   </div>	
						        </td>
						        
						        <td class="require_qty_cls_<?php echo $material['mat_id']?>">
						        	<input name="require_qty[<?php echo $material['mat_id']?>]" id="require_qty[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['require_qty'];?>" type="text" />	
						        </td>
						        <td class="require_users_cls_<?php echo $material['mat_id']?>">
						        	<select class="form-control select2" multiple="multiple" data-placeholder="Select Employee"
                        style="width: 100%;" name="user_mgm_user[<?php echo $material['mat_id']?>][]">
                        				<?php foreach($require_users as $key => $user_mgm){
                        					$users_id = explode(',',$material['require_users']);
											if (in_array($user_mgm['id'], $users_id)) {
											    $selected = "selected='selected'";
											} else {
											    $selected = "";
											}
                        				?>
						                  	<option value="<?php echo $user_mgm['id']?>" <?php echo $selected;?>><?php echo $user_mgm['name']?></option>
						                <?php } ?>  
						             </select>
						        </td>
						        <td><button type="button" style="cursor: pointer;" onclick="remove_selected_material_details(<?php echo $material['id']?>,<?php echo $material['req_id']?>)"><i class="fa fa-close"></i></button></td>
						    </tr> 
						<?php } ?> 
				    <?php } ?>		
		    </tbody>	 			  
	</table>	
</div>