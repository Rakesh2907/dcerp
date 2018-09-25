<?php
  if(!empty($quotation_details)){
?>
		 <table id="quo_material_list" class="table" role="grid" aria-describedby="quo_material_list">
		 	<thead>
			 	 <th>Material code</th>
			 	 <th>Material name</th>
			 	 <th>Rate</th>
			 	 <th>Qty</th>
			 	 <th>Price</th>
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
		 				<td><?php echo $details['quo_price']?></td>
		 			</tr>
		 		<?php
		 			 $total = $total + $details['quo_price'];
		 	    }?>
		 		<tr>
		 			<td colspan="3"></td>
		 			<th>Total Price</th>
		 			<th><?php echo $total;?></th>
		 		</tr>
		 	</tbody>
		 </table>	
<?php  	 
  } 
?>