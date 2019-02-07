<div class="col-sm-12">

	<div class="row">
		<div class="col-sm-6">
		  <?php if($sess_dep_id == $dep_id && $requisation_details[0]->approval_flag === 'approved'){
		  ?>   			
			<div class="box-header">
				<div class="pull-left">
					<button type="button" class="btn btn-primary pull-right cancel_button_select" style="margin-bottom: 11px; background-color: #bc653c; border-color: #bc653c;" id="cancel_button_select" onclick="cancel_requisition(<?php echo $req_id;?>)" rel="tooltip" title="Checked checkbox for cancel requisition">Cancel Requisition</button>
			    </div>		
		    </div>
		<?php } ?>    
	    </div>
	    <div class="col-sm-6">
	    		<?php 
		    		if(validateAccess('material_requisition-send_requisition_to_purchase_button',$access) && $requisation_details[0]->approval_flag === 'approved'){
		        ?>  			
		    			 <div class="box-header">
		                      <div class="pull-right">
		                           <button type="button" class="btn btn-primary pull-right button_select"style="margin-bottom: 11px;" id="button_select" onclick="generate_purchase_requisation(<?php echo $req_id;?>)" rel="tooltip" title="Checked checkbox for Requisition send to purchase">Select Requisition Send To Purchase</button>
		                      </div>  
           				 </div>
                <?php
		    		}
	    		?>
	    </div> 		
    </div> 		
	<div class="row">
		<div class="col-sm-12">
			<table id="view_selected_material_list" class="table table-bordered dataTable" role="grid" aria-describedby="material_list_info">
						<thead>
					      <?php if($requisation_details[0]->approval_flag === 'approved'){?>   		
						   	   		<th>Cancel <br>Requisition</th>
						   <?php } ?>	
						   <?php if(!$list_view){ ?>
						   		<th>Material Notes</th>
						   <?php }?>
						   <th>Material Code</th>
						   <th>Material Name</th>
						   <th>Unit</th>
						   <th>Material Require Date</th>
						   <th>Require Qty</th>
						   <th>Material Require Users</th>
						   <th>Stock Qty</th>
						   <?php if(validateAccess('material_requisition-send_requisition_to_purchase_button',$access) && $requisation_details[0]->approval_flag === 'approved'){ ?>
						   <th>Requisition to <br>Purchase</th>
						<?php } ?>
					    </thead>
					    <tbody>
					    	<?php 
							     if(!empty($selected_materials)){?>
							     	<?php foreach($selected_materials as $key => $material) {

							     		//echo "<pre>"; print_r($material); echo "</pre>";
							     	?>
									    <tr id="material_id_<?php echo $material['mat_id']?>" data-row-id="<?php echo $material['id']?>">
									       <?php  
					        					if($requisation_details[0]->approval_flag === 'approved'){
					        						if($material['cancel_requisition'] == '1'){
					        							$checked = 'checked="checked"';
					        						}else{
					        							$checked = '';
					        						}
		                                   ?> 	
									    	<td><input type="checkbox" class="req_can_chk" data-id="<?php echo $material['mat_id']?>" <?php echo $checked;?>/></td>
									    	<?php } ?>
									    	<?php if(!$list_view){ ?>	
										    	<td>
										    	  <?php if(!empty($material['material_note'])){
										    	  	     if($sess_dep_id === $dep_id){
										    	  	     	 	$class = "fa fa-pencil-square-o";
										    	  	     }else{
	 														 	$class = "fa fa-eye";	
										    	  	     }
										    	  ?> 	
										    	     <?php if(validateAccess('material_requisition-material_notes_view_edit',$access)){?> 
										    				<button type="button" class="btn btn-primary" onclick="add_material_note(<?php echo $material['id']?>,'details')"><i class="<?php echo $class;?>"></i></button>
										    	     <?php } ?> 		
										    	  <?php }?> 
										    	   <textarea style="display: none" name="mat_note[<?php echo $material['mat_id']?>]"><?php echo $material['material_note']?></textarea>	
										    	</td>
										    <?php }?>	
									        <td class="mat_code_cls_<?php echo $material['mat_id']?>">
									        	<?php echo $material['mat_code']?>
									        <input type="hidden" name="mat_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_code']?>" />
									        </td>
									        <td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
									        <td class="unitid_cls_<?php echo $material['mat_id']?>" width="100">
									        	 <select class="form-control" name="unit_id[<?php echo $material['mat_id']?>]" id="unit_id" disabled>
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
														<input name="require_date[<?php echo $material['mat_id']?>]" id="require_date[<?php echo $material['mat_id']?>]" size="10" class="form-control view_require_date" value="<?php echo $require_date;?>" type="text" disabled/>	
									        	   </div>	
									        </td>
									        
									        <td class="require_qty_cls_<?php echo $material['mat_id']?>">
									        	<input name="require_qty[<?php echo $material['mat_id']?>]" id="require_qty[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['require_qty'];?>" type="text" disabled/>	
									        </td>

									        <td class="require_users_cls_<?php echo $material['mat_id']?>">
			                        		<?php 			
									            echo trim($material['require_users']);     
									        ?>  
						        			</td>
						        			<td class="stock_qty_cls_<?php echo $material['mat_id']?>">
						        				<input name="stock_qty[<?php echo $material['mat_id']?>]" id="stock_qty[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['current_stock'];?>" type="text" disabled/>
						        			</td>
						        		  <?php if(validateAccess('material_requisition-send_requisition_to_purchase_button',$access) && $requisation_details[0]->approval_flag === 'approved'){ ?> 	
							        			<td>
										    	  <?php if($material['require_qty'] > $material['current_stock']){ 
											    	  		if($material['requisation_send_purchase']=='yes' && $requisation_details[0]->approval_flag === 'approved'){
											    	  			echo '<small class="label" style="background:#3f90d3">Sent To Purchase</small>';
											    	  		}else{	
											    	  	      if($material['require_qty'] == $material['received_qty']){
											    	  	      	//echo '<div style="color:green">Completed</div>';
											    	  	      }else{		
										    	  ?>	          <input type="checkbox" name="" class="req_chk" data-id="<?php echo $material['mat_id']?>">
										    	  <?php
										    	  			   }
										    	     		} 
										    	  }?>	
										    	</td>
									      <?php } ?>	
									    </tr> 
									<?php } ?> 
							    <?php } ?>		
					    </tbody>	 			  
			</table>
		</div>
	</div>			
</div>
<?php 
	 //$this->load->view("store/modals/material_notes");
?>
<script type="text/javascript">
	 $('.select2').select2();
	 $(".cancel_button_select").tooltip({'placement': 'top'});
   	 $(".button_select").tooltip({'placement': 'top'});
</script>