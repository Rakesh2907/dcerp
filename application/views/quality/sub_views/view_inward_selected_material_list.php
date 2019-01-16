<?php
  if(!empty($inward_material_details)){
?>
<table id="inward_material_list" class="table table-bordered nowrap" role="grid" aria-describedby="quo_material_list">
		 	<thead>
		 		 <th class="col1">Action(s)</th>
			 	 <th class="col2">Material code</th>
			 	 <th class="col3">Material name</th>
			 	 <th style="display: none;">HSN code</th>
			 	 <th>Unit</th>
			 	 <th style="display: none;">PO Qty</th>
			 	 <th style="display: none;">Pre.Rec.Qty</th>
			 	 <th>Received/Challan Qty</th>
			 	 <th>Accepted Qty</th>
			 	 <th>Remarks</th>
			 	 <th style="display: none;">Rate</th>
			 	 <th style="display: none;">Discount(%)</th>
			 	 <th style="display: none;">Discount(Amt)</th>
			 	 <th style="display: none;">Amount</th>
			 	 <th style="display: none;">CGST(%)</th>
			 	 <th style="display: none;">CGST(Amt)</th>
			 	 <th style="display: none;">SGST(%)</th>
			 	 <th style="display: none;">SGST(Amt)</th>
			 	 <th style="display: none;">IGST(%)</th>
			 	 <th style="display: none;">IGST(Amt)</th>
			 	 <th>Debit Amt <br>((qty x rate) + cgst + sgst + igst)</th>
		 	</thead> 
		 	<tbody>
		 		<?php
		 		    
		 			foreach($inward_material_details as $key => $material){
		 				//echo "<pre>"; print_r($material); echo "<pre>";

		 				$material['mat_amount'] = ($material['qc_accepted_qty'] * $material['rate']);

		 				if(isset($material['discount_per']) && !empty($material['discount_per'])){
		 					$minus_amt[$key] = (($material['discount_per']/100) * $material['mat_amount']);
			 				$material['mat_amount'] = (float)$material['mat_amount'] - (float)$minus_amt[$key];
		 				}

		 				if(!isset($material['discount']) && empty($material['discount'])){
		 					$material['mat_amount']  = (float)$material['mat_amount'] - (float)$material['discount'];
		 				}

		 				$material['cgst_amt'] = (($material['cgst_per']/100) * $material['mat_amount']);
		 				$material['sgst_amt'] = (($material['sgst_per']/100) * $material['mat_amount']);
		 				$material['igst_amt'] = (($material['igst_per']/100) * $material['mat_amount']);
		 			?>	
		 			<tr id="mat_id_<?php echo $material['mat_id']?>">
		 				<th>    
		 					<img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/icons8-quality.png" style="width: 35px; cursor: pointer;" onclick="add_batch_number(<?php echo $material['inward_id']?>,<?php echo $material['po_id']?>,<?php echo $material['mat_id']?>)" class="qc_certificate" rel="tooltip" title="Set Accepted Quantity">
		 				</th>
		 				<th class="col2">
		 					<?php echo $material['mat_code']?>
		 					 <input type="hidden" name="mat_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_code']?>" />
		 					 <input type="hidden" name="mat_id[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_id']?>" />		
		 				</th>
		 				<th class="col3"><?php echo $material['mat_name']?></th>
		 				<td style="display: none;"><input class="form-control" type="text" value="<?php echo $material['hsn_code']?>" name="hsn_code[<?php echo $material['mat_id']?>]" autocomplete="off"></td>
		 				<td>
		 					<select class="form-control" name="unit_id[<?php echo $material['mat_id']?>]" >
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
		 				<td style="display: none;">
		 						<?php echo $material['po_qty']?>
		 						<input type="hidden" name="po_qty[<?php echo $material['mat_id']?>]" value="<?php echo $material['po_qty']?>" />			
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="pre_rec_qty[<?php echo $material['mat_id']?>]" value="<?php echo $material['pre_rec_qty']?>" readonly>
		 				</td>
		 				<td>
		 					<input class="form-control" type="text" name="received_qty[<?php echo $material['mat_id']?>]" value="<?php echo $material['received_qty']?>" autocomplete="off" readonly>
		 				</td> <!--onkeyup="mypo_qty(this.value,<?php //echo $material['mat_id']?>)"-->
		 				<td>
		 					<input class="form-control" type="text" name="qc_accepted_qty[<?php echo $material['mat_id']?>]" value="<?php echo $material['qc_accepted_qty']?>" autocomplete="off" readonly>
		 				</td>
		 				<td>
		 					<input class="form-control" type="text" name="qc_remarks[<?php echo $material['mat_id']?>]" value="<?php echo $material['qc_remarks']?>" autocomplete="off">
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="rate[<?php echo $material['mat_id']?>]" value="<?php echo $material['rate']?>" onkeyup="mypo_rate(this.value,<?php echo $material['mat_id']?>)" autocomplete="off">
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="discount_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['discount_per']?>" onkeyup="mypo_discount_per(this.value,<?php echo $material['mat_id']?>)" autocomplete="off">
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="discount[<?php echo $material['mat_id']?>]" value="<?php echo $material['discount']?>" onkeyup="mypo_discount_amt(this.value,<?php echo $material['mat_id']?>)" autocomplete="off">
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="mat_amount[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_amount']?>" autocomplete="off" readonly>
		 				</td>
		 				<!-- <td><input type="text" name="expire_date[<?php //echo $material['mat_id']?>]" value="" class="form-control expire_date"></td> -->
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="cgst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['cgst_per']?>" onkeyup="mypo_cgst_per(this.value,<?php echo $material['mat_id']?>)"/>
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="cgst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['cgst_amt']?>" readonly>
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="sgst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['sgst_per']?>" onkeyup="mypo_sgst_per(this.value,<?php echo $material['mat_id']?>)"/>
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="sgst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['sgst_amt']?>" readonly>
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="igst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['igst_per']?>" onkeyup="mypo_igst_per(this.value,<?php echo $material['mat_id']?>)"/>
		 				</td>
		 				<td style="display: none;">
		 					<input class="form-control" type="text" name="igst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['igst_amt']?>" readonly>
		 				</td>
		 				<td>
		 					<?php 
		 						$total_material_debit_amount = ((float)$material['mat_amount'] + (float)$material['cgst_amt'] + (float)$material['sgst_amt'] + (float)$material['igst_amt']); 
		 					?>
		 					<input class="form-control" type="text" name="qc_debit_amt[<?php echo $material['mat_id']?>]" value="<?php echo $total_material_debit_amount;?>" readonly>
		 				</td>
		 				<input type="hidden" name="current_stock[<?php echo $material['mat_id']?>]" value="<?php echo $material['current_stock']?>"/>
		 			</tr>		
		 		  <?php } ?>	
		 	</tbody>
		 </table>	 	
<?php  	 
  } 
?>