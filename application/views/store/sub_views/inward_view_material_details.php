<?php
  if(!empty($inward_material_details)){
?>
	<div class="col-sm-12" style="overflow-x: auto;"> 
		 <table id="quo_material_list" class="table table-bordered nowrap" role="grid" aria-describedby="quo_material_list">
		 	<thead>
			 	 <th style="width: 8%">Material code</th>
			 	 <th style="width: 8%">Material name</th>
			 	 <th style="width: 2%">Unit</th>
			 	 <th style="width: 5%">PO Qty</th>
			 	 <th style="width: 5%">Pre.Rec. Qty</th>
			 	 <th style="width: 5%">Received Qty</th>
			 	 <th>Rate</th>
			 	 <th style="width: 3%">Discount(%)</th>
			 	 <th style="width: 5%">Discount(Amt)</th>
			 	 <th style="width: 8%">Amount</th>
			 	<!--  <th>Expire Date</th> -->
			 	 <th>CGST(%)</th>
			 	 <th>CGST(Amt)</th>
			 	 <th>SGST(%)</th>
			 	 <th>SGST(Amt)</th>
			 	 <th>IGST(%)</th>
			 	 <th>IGST(Amt)</th>
			 	 <th>Action(s)</th>
		 	</thead> 
		 	<tbody>
		 		<?php
		 			$total = 0;
		 			foreach($inward_material_details as $key => $material){?>
		 			<tr>
		 				<td><?php echo $material['mat_code']?></td>
		 				<td><?php echo $material['mat_name']?></td>
		 				<td>
		 					<select class="form-control" name="unit_id[<?php echo $material['mat_id']?>]" disabled>
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
		 				<td><?php echo $material['po_qty']?></td>
		 				<td><?php echo $material['pre_rec_qty']?></td>
		 				<td><?php echo $material['received_qty']?></td>
		 				<td><?php echo $material['rate']?></td>
		 				<td><?php echo $material['discount_per']?></td>
		 				<td><?php echo $material['discount']?></td>
		 				<td><?php echo $material['mat_amount']?></td>
		 				<!-- <td><input type="text" name="expire_date[<?php //echo $material['mat_id']?>]" value="" class="form-control expire_date"></td> -->
		 				<td><?php echo $material['cgst_per']?></td>
		 				<td><?php echo $material['cgst_amt']?></td>
		 				<td><?php echo $material['sgst_per']?></td>
		 				<td><?php echo $material['sgst_amt']?></td>
		 				<td><?php echo $material['igst_per']?></td>
		 				<td><?php echo $material['igst_amt']?></td>
		 				<td></td>
		 			</tr>
		 		<?php
		 			 $total = $total + $material['mat_amount'];
		 	    }?>
		 		<tr>
		 		   	<td colspan="8"></td>
		 		   	<td>Total Amt</td>
		 			<td><?php echo $inward_material[0]['total_amt']?></td>
		 			<td>Total cgst</td>
		 			<td><?php echo $inward_material[0]['total_cgst']?></td>
		 			<td>Total sgst</td>
		 			<td><?php echo $inward_material[0]['total_sgst']?></td>
		 			<td>Total igst</td>
		 			<td><?php echo $inward_material[0]['total_igst']?></td>
		 			<td></td>
		 		</tr>
		 		
		 		<tr>
		 				<td colspan="13"></td>
		 				<td colspan="2">Freight Amt</td>
		 				<td><?php echo $inward_material[0]['freight_amt']?></td>
		 				<td></td>
		 			</tr>
		 			<tr>
		 				<td colspan="13"></td>
		 				<td colspan="2">Other Amt</td>
		 				<td><?php echo $inward_material[0]['other_amt']?></td>
		 				<td></td>
		 			</tr>
		 			<tr>
		 				<td colspan="13"></td>
		 				<td colspan="2">Total Bill Amt</td>
		 				<td><?php echo $inward_material[0]['total_bill_amt']?></td>
		 				<td></td>
		 			</tr>
		 			<tr>
		 				<td colspan="13"></td>
		 				<td colspan="2">Rounded Amt</td>
		 				<td><?php echo $inward_material[0]['rounded_amt']?></td>
		 				<td></td>
		 			</tr>
		 	</tbody>
		 </table>
	  </div>	 	
<?php  	 
  } 
?>