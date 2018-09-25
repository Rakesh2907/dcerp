<div class="col-sm-12"> 
  <form id="assign_material_form" name="assign_material_form" action="purchase/save_assign_material">	
	<table id="assign_material_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="material_list_info">
			<thead>
			   <th></th>
			   <th>Material code</th>
			   <th>Material Name</th>
			   <th>Vendor Material code</th>
			   <th>Unit</th>
			   <th>Material Discounts(%)</th>
			   <th>Net Rate</th>
			   <th>Credit Days</th>
			   <th>Lead Time</th>
			   <th>Action(s)</th>
		    </thead>
		    <tbody>
		    	<?php 
				     if(!empty($assign_materials)){?>
				     	<?php foreach($assign_materials as $key => $material) {
				     			if(empty($material['sup_mat_code'])){
				     				 $material['sup_mat_code'] = 'supp_'.$material['mat_code']; 
				     			}
				     	?>
						    <tr id="material_id_<?php echo $material['mat_id']?>" data-row-id="<?php echo $material['mat_id']?>">
						    	<td></td>
						        <td class="mat_code_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_code']?></td>
						        <td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
						        <td class="sup_mat_code_cls_<?php echo $material['mat_id']?>" >
						        	<input name="sup_mat_code[<?php echo $material['mat_id']?>]" id="txt_sup_mat_code" size="20" class="form-control" value="<?php echo $material['sup_mat_code']?>" type="text" />
						        </td>
						        <td class="unitid_cls_<?php echo $material['mat_id']?>">
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
						        <td class="mat_discount_cls_<?php echo $material['mat_id']?>">
						        	<input name="mat_discount[<?php echo $material['mat_id']?>]" id="mat_discount[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['mat_discount']?>" type="text" />
						    	</td>
						        <td class="mat_rate_cls_<?php echo $material['mat_id']?>">
						        	<input name="mat_rate[<?php echo $material['mat_id']?>]" id="mat_rate[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['mat_rate']?>" type="text" />
						        </td>
						        <td class="credit_day_cls_<?php echo $material['mat_id']?>">
						        	<input name="credit_day[<?php echo $material['mat_id']?>]" id="credit_day[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['credit_days']?>" type="text" />	
						        </td>
						        <td class="lead_time_cls_<?php echo $material['mat_id']?>">
						        	 <input name="lead_time[<?php echo $material['mat_id']?>]" id="lead_time[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $material['lead_time']?>" type="text" />		
						        </td>
						        <td><span style="cursor: pointer;" onclick="remove_assign_material(<?php echo $material['mat_id']?>,<?php echo $supplier_id;?>)"><i class="fa fa-close"></i></span></td>
						    </tr> 
						<?php } ?> 
				    <?php } ?>		
		    </tbody>
		      <?php if(!empty($assign_materials)){ ?>
				    <div class="row" style="margin-bottom: 1px">
							<div class="col-sm-12">
										<input type="hidden" name="supplier_id" value="<?php echo $supplier_id;?>">
								     	<button type="submit" class="btn btn-primary pull-right">Save</button>
							</div> 	
					</div>
			 <?php } ?>		 			  
	</table>
  </form> 		
</div>	
<script type="text/javascript">
  $(document).ready(function () {	
		$('#assign_material_list').DataTable({
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
  });	
</script>