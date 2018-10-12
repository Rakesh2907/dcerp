<?php
  if(!empty($quotation_details)){
?>
		 <table id="quo_material_list" class="table" role="grid" aria-describedby="quo_material_list">
		 	<thead>
			 	 <th>Material code</th>
			 	 <th>Material name</th>
			 	 <th>Rate</th>
			 	 <th>Qty</th>
			 	 <th>Discount(%)</th>
			 	 <th>Discount(Amt)</th>
			 	 <th>Price</th>
			 	 <th>Expire Date</th>
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
		 			foreach($quotation_details as $key => $details){?>
		 			<tr>
		 				<td><?php echo $details['mat_code']?></td>
		 				<td><?php echo $details['mat_name']?></td>
		 				<td><?php echo $details['quo_rate']?></td>
		 				<td><?php echo $details['quo_qty']?></td>
		 				<td><?php echo $details['discount_per']?></td>
		 				<td><?php echo $details['discount']?></td>
		 				<td><?php echo $details['quo_price']?></td>
		 				<td><?php echo $details['expire_date']?></td>
		 				<td><?php echo $details['cgst_per']?></td>
		 				<td><?php echo $details['cgst_amt']?></td>
		 				<td><?php echo $details['sgst_per']?></td>
		 				<td><?php echo $details['sgst_amt']?></td>
		 				<td><?php echo $details['igst_per']?></td>
		 				<td><?php echo $details['igst_amt']?></td>
		 			</tr>
		 		<?php
		 			 $total = $total + $details['quo_price'];
		 	    }?>
		 		<tr>
		 			<td colspan="5"></td>
		 			<th>Total Price</th>
		 			<th><?php echo $total;?></th>
		 		</tr>
		 		<tr>
		 			<th colspan="13">Total CGST</th>
		 			<td><?php echo $quotations[0]['total_cgst'];?></td>
		 		</tr>
		 		<tr>
		 			<th colspan="13">Total CGST</th>
		 			<td><?php echo $quotations[0]['total_sgst'];?></td>
		 		</tr>
		 		<tr>
		 			<th colspan="13">Total CGST</th>
		 			<td><?php echo $quotations[0]['total_igst'];?></td>
		 		</tr>	
		 		<tr>
		 			<th colspan="13">Other Amt</th>
		 			<td><?php echo $quotations[0]['other_amt'];?></td>
		 		</tr>
		 		<tr>
		 			<th colspan="13">Total Bill Amt</th>
		 			<th><?php echo $quotations[0]['total_amt'];?></th>
		 		</tr>
		 	</tbody>
		 </table>	
<?php  	 
  } 
?>