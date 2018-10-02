<div class="row">
		<div class="col-sm-12">
			<table id="request_material_list" class="table table-bordered dataTable" role="grid" aria-describedby="material_list_info">
				<thead>
					 <th>Material Code</th>
				     <th>Material Name</th>
				     <th>Unit</th>
				     <th>Require Qty</th>
				     <th>Requisation Number</th>
				</thead>
				<tbody>
					<?php if(!empty($request_materials_list)){?>
						<?php foreach($request_materials_list as $key => $material) {?>
							  <tr id="material_id_<?php echo $material['mat_id']?>" data-row-id="<?php echo $material['mat_id']?>">
							  		<td class="mat_code_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_code']?></td>
							  		<td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
							  		<td class="unitid_cls_<?php echo $material['mat_id']?>" width="100">
									    <select class="form-control valid select2" name="unit_id[<?php echo $material['mat_id']?>]" id="unit_id" disabled>
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
									<td class="require_qty_cls_<?php echo $material['mat_id']?>"><?php echo $material['require_qty'];?></td>
									<td>
										<?php
										  if(!empty($material['mat_req_id'])){
										 	$req_number = $this->store_model->material_requisation_details($material['mat_req_id']); 
											if(!empty($req_number)){ 
										?>
										 <a style="cursor: pointer;" onclick="load_page('store/edit_requisation_form/req_id/<?php echo $req_number[0]->req_id?>')"><?php echo $req_number[0]->req_number;?></a>
										<?php }
										    }
										?>
									</td>
							  </tr>
					    <?php } ?>		
					<?php } ?>
					<tr><td colspan="5" align="center">Currently not received any quotation from vendors.</td></tr>	
				</tbody>	
		    </table>		
	    </div>
</div>	    		