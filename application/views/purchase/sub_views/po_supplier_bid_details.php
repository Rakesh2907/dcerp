<?php
  if(!empty($quotation_details)){
?>
	<div class="col-sm-12" style="overflow-x: auto;"> 
		 <table id="quo_material_list" class="table" role="grid" aria-describedby="quo_material_list">
		 	<thead>
			 	 <th style="width: 8%">Material code</th>
			 	 <th style="width: 8%">Material name</th>
			 	 <th style="width: 7%">Unit</th>
			 	 <th style="width: 5%">Qty</th>
			 	 <th>Rate</th>
			 	 <th>Expire Date</th>
			 	 <th>CGST(%)</th>
			 	 <th>CGST(Amt)</th>
			 	 <th>SGST(%)</th>
			 	 <th>SGST(Amt)</th>
			 	 <th>IGST(%)</th>
			 	 <th>IGST(Amt)</th>
			 	 <th style="width: 5%">Amount</th>
		 	</thead> 
		 	<tbody>
		 		<?php
		 			$total = 0;
		 			foreach($quotation_details as $key => $details){?>
		 			<tr>
		 				<td><?php echo $details['mat_code']?></td>
		 				<td><?php echo $details['mat_name']?></td>
		 				<td>
		 					<select class="form-control valid select2">
		 						<?php 
									if(!empty($unit_listing)){
										    foreach ($unit_listing as $key => $val) {
										        	  			$selected = '';
										    
								 ?>
										        	 	<option value="<?php echo $val['unit_id']?>" <?php echo $selected;?>><?php echo $val['unit']?></option>	
							    <?php 		
										}
									}
							     ?>
		 					</select>
		 				</td>
		 				<td><input type="text" name="" value="<?php echo $details['quo_qty']?>" class="form-control"></td>
		 				<td><input type="text" name="" value="<?php echo $details['quo_rate']?>" class="form-control"></td>
		 				<td><input type="text" name="" value="" class="form-control expire_date"></td>
		 				<td><input type="text" name="" value="" class="form-control"></td>
		 				<td><input type="text" name="" value="" class="form-control"></td>
		 				<td><input type="text" name="" value="" class="form-control"></td>
		 				<td><input type="text" name="" value="" class="form-control"></td>
		 				<td><input type="text" name="" value="" class="form-control"></td>
		 				<td><input type="text" name="" value="" class="form-control"></td>
		 				<td><input type="text" name="" value="<?php echo $details['quo_price']?>" class="form-control"></td>
		 			</tr>
		 		<?php
		 			 $total = $total + $details['quo_price'];
		 	    }?>
		 		<!-- <tr>
		 			<td colspan="3"></td>
		 			<th>Total Price</th>
		 			<th><?php //echo $total;?></th>
		 		</tr> -->
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