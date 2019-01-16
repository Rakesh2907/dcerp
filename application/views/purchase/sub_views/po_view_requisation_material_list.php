<div class="col-sm-12">	
	<div class="row">
		<div class="col-sm-12">
			<table id="selected_material_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="material_list_info">
						<thead>	
						   <th>Material Code</th>
						   <th>Material Name</th>
						   <th>Unit</th>
						   <th>Material Require Date</th>
						   <th>Require Qty</th>
						   <th>Material Require Users</th>
						   <th>Stock Qty</th>
						   <th>PO Qty</th>
					    </thead>
					    <tbody>
					    	<?php 
							     if(!empty($selected_materials)){?>
							     	<?php foreach($selected_materials as $key => $material) { //echo "<pre>"; print_r($material); echo "</pre>";
							     	?>
									    <tr id="material_id_<?php echo $material['mat_id']?>" data-row-id="<?php echo $material['id']?>">
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
														<input  name="require_date[<?php echo $material['mat_id']?>]" id="require_date[<?php echo $material['mat_id']?>]" size="10" class="form-control view_require_date" value="<?php echo $require_date;?>" type="text" disabled/>	
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
						        			<td class="po_qty_cls_<?php echo $material['mat_id']?>">

						        				<?php 
						        					if($material['require_qty'] > $material['current_stock']){
						        						$po_qty = (float)$material['require_qty'] - (float)$material['current_stock'];
						        					}else{
						        						$po_qty = (float)$material['require_qty'];
						        					}
						        				?>

						        				<input name="po_qty[<?php echo $material['mat_id']?>]" id="po_qty[<?php echo $material['mat_id']?>]" size="10" class="form-control" value="<?php echo $po_qty;?>" type="text" disabled/>
						        			</td>
									    </tr> 
									<?php } ?> 
							    <?php } ?>		
					    </tbody>	 			  
			</table>
		</div>
	</div>			
</div>
<script type="text/javascript">
	 $('.select2').select2();

     $(document).ready(function(){
		  var table_selected = $('#selected_material_list').DataTable({
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