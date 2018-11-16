<table id="material_list_pop_up" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_cat_list_info">
			                      <thead>
			                      	  <th></th>
			                          <th>Material id</th>
			                          <th>Material code</th>
			                          <th>Material Name</th>
			                          <th>Unit</th>
			                          <th>Material Rate</th>
			                          <th>PO Qty</th>
			                          <th>Pre.Rec.Qty</th>
			                      </thead>
			                      <tbody>
				                      	<?php 
				                      	 if(!empty($purchase_order_details)){?>
				                      	 	<?php foreach($purchase_order_details as $key => $material) {?>
						                     <tr id="material_id_<?php echo $material['mat_id']?>">
						                       	    <td><input name="" class="sub_chk" data-id="<?php echo $material['mat_id']?>" type="checkbox"></td>
						                            <td><?php echo $material['mat_id']?></td>
						                            <td class="mat_code_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_code']?></td>
						                            <td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
						                            <td><?php echo $material['unit_description']?></td>
						                            <td><?php echo $material['rate']?></td>
						                            <td><?php echo $material['qty']?></td>
						                            <td><?php echo $material['received_qty']?></td>
						                        </tr>  
						                     <?php } ?>   
				                    	<?php } ?>
			                      </tbody>
</table>
<script type="text/javascript">
	$('#material_list_pop_up').DataTable();
</script>