<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-6">
			<div class="box-header">
				<h4><?php echo $requisation_details[0]->req_number;?></h4>
		    </div>
	    </div>
	    <div class="col-sm-6">
	    		<?php 
		    		if($sess_dep_id === '21' && $requisation_details[0]->approval_flag === 'approved'){
		        ?>  			
		    			 <div class="box-header">
		                      <div class="pull-right">
		                           <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="generate_quotation_request(<?php echo $requisation_details[0]->req_id?>)">Add Quotation Request</a>

		                           <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="send_quotation_request(<?php echo $requisation_details[0]->req_id?>)">Send Quotation Request</a>
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
					      <?php  
					        if($sess_dep_id === '21' && $requisation_details[0]->approval_flag === 'approved'){
		                   ?>   		
						   <th><!-- <input name="select_all" value="1" id="view_selected_material_list-all" type="checkbox" /> --></th>
						   <?php } ?>	
						   <th>Material Notes</th>
						   <th>Material Code</th>
						   <th>Material Name</th>
						   <th>Unit</th>
						   <th>Material Require Date</th>
						   <th>Require Qty</th>
						   <th>Material Require Users</th>
					    </thead>
					    <tbody>
					    	<?php 
							     if(!empty($selected_materials)){?>
							     	<?php foreach($selected_materials as $key => $material) {
							     	?>
									    <tr id="material_id_<?php echo $material['mat_id']?>" data-row-id="<?php echo $material['id']?>">
									       <?php  
					        					if($sess_dep_id === '21' && $requisation_details[0]->approval_flag === 'approved'){
		                                   ?> 	
									    	<td><input type="checkbox" class="sub_chk" data-id="<?php echo $material['mat_id']?>"/></td>
									    	<?php } ?>	
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
									        <td class="mat_code_cls_<?php echo $material['mat_id']?>">
									        	<?php echo $material['mat_code']?>
									        <input type="hidden" name="mat_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_code']?>" />
									        </td>
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
														<input class="view_require_date" name="require_date[<?php echo $material['mat_id']?>]" id="require_date[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $require_date;?>" type="text" disabled/>	
									        	   </div>	
									        </td>
									        
									        <td class="require_qty_cls_<?php echo $material['mat_id']?>">
									        	<input name="require_qty[<?php echo $material['mat_id']?>]" id="require_qty[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['require_qty'];?>" type="text" disabled/>	
									        </td>

									        <td class="require_users_cls_<?php echo $material['mat_id']?>">
			                        		<?php 
			                        				   $rq_users = array();
			                        				   foreach($require_users as $key => $user_mgm)
			                        				   {
				                        					$users_id = explode(',',$material['require_users']);
															if (in_array($user_mgm['id'], $users_id))
															{
															    array_push($rq_users, $user_mgm['name']);
															}
			                        				
									                   }
									            echo implode(', ', $rq_users);        
									        ?>  
						        			</td>
									    </tr> 
									<?php } ?> 
							    <?php } ?>		
					    </tbody>	 			  
			</table>
		</div>
	</div>			
</div>
<?php 
	 $this->load->view("store/modals/material_notes");
?>
<script type="text/javascript">
	 $('.select2').select2();

     /*$(document).ready(function(){
		  var table_selected1 = $('#view_selected_material_list_<?php //echo $status;?>').DataTable({
		            'columnDefs': [{
		               'targets': 0,
		               'searchable':false,
		               'orderable':false,
		               'className': 'dt-body-center',
		               'render': function (data, type, full, meta){
		                    return data;
		                   //return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
		               }
		            }],
		            'order': [1, 'asc'],
		            "pageLength": 50
		  });

		  $('#view_selected_material_list_<?php //echo $status;?>-all').on('click', function(){
		        	var rows = table_selected1.rows({ 'search': 'applied' }).nodes();
		        	$('input[type="checkbox"]', rows).prop('checked', this.checked);
		  });

		  $('#view_selected_material_list_<?php //echo $status;?> tbody').on('change', 'input[type="checkbox"]', function(){
			        	if(!this.checked){
			           		var el = $('#material_list-selected-all').get(0);
				           if(el && el.checked && ('indeterminate' in el)){
				              el.indeterminate = true;
				           }
			            }
		  });
	 });*/	
</script>