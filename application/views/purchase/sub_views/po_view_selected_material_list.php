<?php
  if(!empty($purchase_order_details)){
?>
	<div class="col-sm-12" style="overflow-x: auto;"> 
		 <table id="quo_material_list" class="table" role="grid" aria-describedby="quo_material_list">
		 	<thead>
			 	 <th style="width: 8%">Material code</th>
			 	 <th style="width: 8%">Material name</th>
			 	 <th style="width: 2%">Unit</th>
			 	 <th style="width: 5%">Qty</th>
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
		 	</thead> 
		 	<tbody>
		 		<?php
		 			$total = 0;
		 			foreach($purchase_order_details as $key => $material){?>
		 			<tr>
		 				<td><?php echo $material['mat_code']?></td>
		 				<td><?php echo $material['mat_name']?></td>
		 				<td>
		 					<select class="form-control valid select2" name="unit_id[<?php echo $material['mat_id']?>]" disabled>
		 						<?php 
									if(!empty($unit_list)){
										    foreach ($unit_list as $key => $val) {
										        	  			$selected = '';
										    
								 ?>
										        	 	<option value="<?php echo $val['unit_id']?>" <?php echo $selected;?>><?php echo $val['unit']?></option>	
							    <?php 		
										}
									}
							     ?>
		 					</select>
		 				</td>
		 				<td><?php echo $material['qty']?></td>
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
		 			</tr>
		 		<?php
		 			 $total = $total + $material['mat_amount'];
		 	    }?>
		 		<tr>
		 				<td colspan="12"></td>
		 				<td>Total Amt</td>
		 				<td><?php echo $purchase_order[0]['total_amt']?></td>
		 			</tr>
		 			<tr>
		 				<td colspan="12"></td>
		 				<td>Total cgst</td>
		 				<td><?php echo $purchase_order[0]['total_cgst']?></td>
		 			</tr>
		 			<tr>
		 				<td colspan="12"></td>
		 				<td>Total sgst</td>
		 				<td><?php echo $purchase_order[0]['total_sgst']?></td>
		 			</tr>
		 			<tr>
		 				<td colspan="12"></td>
		 				<td>Total igst</td>
		 				<td><?php echo $purchase_order[0]['total_igst']?></td>
		 			</tr>
		 			<tr>
		 				<td colspan="12"></td>
		 				<td>Freight Amt</td>
		 				<td><?php echo $purchase_order[0]['freight_amt']?></td>
		 			</tr>
		 			<tr>
		 				<td colspan="12"></td>
		 				<td>Other Amt</td>
		 				<td><?php echo $purchase_order[0]['other_amt']?></td>
		 			</tr>
		 			<tr>
		 				<td colspan="12"></td>
		 				<td>Total Bill Amt</td>
		 				<td><?php echo $purchase_order[0]['total_bill_amt']?></td>
		 			</tr>
		 			<tr>
		 				<td colspan="12"></td>
		 				<td>Rounded Amt</td>
		 				<td><?php echo $purchase_order[0]['rounded_amt']?></td>
		 			</tr>
		 	</tbody>
		 </table>
	  </div>	 	
<?php  	 
  } 
?>
<script type="text/javascript">
	$(document).ready(function(){
		 $('.select2').select2();

		 $('.expire_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
        }).datepicker("setDate", new Date());
	});
</script>