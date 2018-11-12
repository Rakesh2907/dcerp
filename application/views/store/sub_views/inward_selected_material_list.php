<?php
  if(!empty($purchase_order_details)){
?>
<table id="inward_material_list" class="table table-bordered nowrap" role="grid" aria-describedby="quo_material_list">
		 	<thead>
		 		 <th class="col1">Action(s)</th>
			 	 <th class="col2">Material code</th>
			 	 <th class="col3">Material name</th>
			 	 <th>HSN code</th>
			 	 <th>Unit</th>
			 	 <th>PO Qty</th>
			 	 <th>Rec Qty</th>
			 	 <!-- <th>Rejected Qty</th> -->
			 	 <th>Rate</th>
			 	 <th>Discount(%)</th>
			 	 <th>Discount(Amt)</th>
			 	 <th>Amount</th>
			 	<!--  <th>Expire Date</th> -->
			 	 <th>CGST(%)</th>
			 	 <th>CGST(Amt)</th>
			 	 <th>SGST(%)</th>
			 	 <th>SGST(Amt)</th>
			 	 <th>IGST(%)</th>
			 	 <th>IGST(Amt)</th>
		 	</thead> 
		 	<tbody>
		 		<?php
		 			foreach($purchase_order_details as $key => $material){?>
		 			<tr id="mat_id_<?php echo $material['mat_id']?>">
		 				<th >
		 					<button style="cursor: pointer;" onclick="remove_purchase_order_material(<?php echo $material['mat_id']?>,<?php echo $po_id;?>)" type="button"><i class="fa fa-close"></i></button>
		 					<!-- <button style="cursor: pointer;" type="button"><img src="<?php //echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode-reader.png" style="width: 15px;"></button> -->
		 				</th>
		 				<th class="col2">
		 					<?php echo $material['mat_code']?>
		 					 <input type="hidden" name="mat_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_code']?>" />
		 					 <input type="hidden" name="mat_id[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_id']?>" />		
		 				</th>
		 				<th class="col3"><?php echo $material['mat_name']?></th>
		 				<td><input class="form-control" type="text" value="<?php echo $material['hsn_code']?>" name="hsn_code[<?php echo $material['mat_id']?>]" autocomplete="off"></td>
		 				<td>
		 					<select class="form-control valid select2" name="unit_id[<?php echo $material['mat_id']?>]" >
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
		 				<td>
		 						<?php echo $material['po_qty']?>
		 						<input type="hidden" name="po_qty[<?php echo $material['mat_id']?>]" value="<?php echo $material['po_qty']?>" />			
		 				</td>
		 				<td><input class="form-control" type="text" name="received_qty[<?php echo $material['mat_id']?>]" value="<?php echo $material['received_qty']?>" onkeyup="mypo_qty(this.value,<?php echo $material['mat_id']?>)" autocomplete="off"></td>
		 				<!-- <td><input class="form-control" type="text" name="rejected_qty[<?php //echo $material['mat_id']?>]" value="<?php //echo $material['rejected_qty']?>"></td> -->
		 				<td><input class="form-control" type="text" name="rate[<?php echo $material['mat_id']?>]" value="<?php echo $material['rate']?>" onkeyup="mypo_rate(this.value,<?php echo $material['mat_id']?>)" autocomplete="off"></td>
		 				<td><input class="form-control" type="text" name="discount_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['discount_per']?>" onkeyup="mypo_discount_per(this.value,<?php echo $material['mat_id']?>)" autocomplete="off"></td>
		 				<td><input class="form-control" type="text" name="discount[<?php echo $material['mat_id']?>]" value="<?php echo $material['discount']?>" onkeyup="mypo_discount_amt(this.value,<?php echo $material['mat_id']?>)" autocomplete="off"></td>
		 				<td><input class="form-control" type="text" name="mat_amount[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_amount']?>" autocomplete="off" readonly></td>
		 				<!-- <td><input type="text" name="expire_date[<?php //echo $material['mat_id']?>]" value="" class="form-control expire_date"></td> -->
		 				<td><input class="form-control" type="text" name="cgst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['cgst_per']?>" onkeyup="mypo_cgst_per(this.value,<?php echo $material['mat_id']?>)"/></td>
		 				<td><input class="form-control" type="text" name="cgst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['cgst_amt']?>" readonly></td>
		 				<td><input class="form-control" type="text" name="sgst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['sgst_per']?>" onkeyup="mypo_sgst_per(this.value,<?php echo $material['mat_id']?>)"/></td>
		 				<td><input class="form-control" type="text" name="sgst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['sgst_amt']?>" readonly></td>
		 				<td><input class="form-control" type="text" name="igst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['igst_per']?>" onkeyup="mypo_igst_per(this.value,<?php echo $material['mat_id']?>)"/></td>
		 				<td><input class="form-control" type="text" name="igst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['igst_amt']?>" readonly></td>
		 			</tr>
		 		  <?php } ?>	
		 	</tbody>
		 </table>	 	
<?php  	 
  } 
?>