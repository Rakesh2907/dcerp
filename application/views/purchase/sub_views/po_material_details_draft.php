<?php
  if(!empty($po_drafts_details)){
?>
<style type="text/css">
  th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
 
    div.container {
        width: 50%;
   }
</style>
<div class="col-sm-12"> 
		 <table id="quo_material_list" class="table" role="grid" aria-describedby="quo_material_list" style="width:100%">
		 	<thead>
			 	 <th>Material code</th>
			 	 <th>Material name</th>
			 	 <th>HSN code</th>
			 	 <th>Unit</th>
			 	 <th>Qty</th>
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
			 	 <th>Action(s)</th>
		 	</thead> 
		 	<tbody>
		 		<?php
		 			$total = 0;
		 			foreach($po_drafts_details as $key => $material){?>
		 			<tr>
		 				<td>
		 					<?php echo $material['mat_code']?>
		 					 <input type="hidden" name="mat_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_code']?>" />
		 					 <input type="hidden" name="mat_id[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_id']?>" />		
		 				</td>
		 				<td><?php echo $material['mat_name']?></td>
		 				<td><input type="text" name="hsn_code[<?php echo $material['mat_id']?>]" value="<?php echo $material['hsn_code']?>" class="form-control"></td>
		 				<td>
		 					<select class="form-control valid select2" name="unit_id[<?php echo $material['mat_id']?>]">
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
		 				<td><input type="text" name="qty[<?php echo $material['mat_id']?>]" value="<?php echo $material['qty']?>" class="form-control"></td>
		 				<td><input type="text" name="rate[<?php echo $material['mat_id']?>]" value="<?php echo $material['rate']?>" class="form-control"  autocomplete="off" onkeyup="mypo_rate(this.value,<?php echo $material['mat_id']?>)"></td>
		 				<td><input type="text" name="discount_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['discount_per']?>" class="form-control"  autocomplete="off" onkeyup="mypo_discount_per(this.value,<?php echo $material['mat_id']?>)"></td>
		 				<td><input type="text" name="discount[<?php echo $material['mat_id']?>]" value="<?php echo $material['discount']?>" class="form-control"  autocomplete="off" onkeyup="mypo_discount_amt(this.value,<?php echo $material['mat_id']?>)"></td>
		 				<td><input type="text" name="mat_amount[<?php echo $material['mat_id']?>]" value="<?php echo $material['mat_amount']?>" class="form-control"  autocomplete="off" readonly></td>
		 				<!-- <td><input type="text" name="expire_date[<?php //echo $material['mat_id']?>]" value="" class="form-control expire_date"></td> -->
		 				<td><input type="text" name="cgst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['cgst_per']?>" class="form-control"  autocomplete="off" onkeyup="mypo_cgst_per(this.value,<?php echo $material['mat_id']?>)"></td>
		 				<td><input type="text" name="cgst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['cgst_amt']?>" class="form-control" autocomplete="off" readonly></td>
		 				<td><input type="text" name="sgst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['sgst_per']?>" class="form-control" autocomplete="off" onkeyup="mypo_sgst_per(this.value,<?php echo $material['mat_id']?>)"></td>
		 				<td><input type="text" name="sgst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['sgst_amt']?>" class="form-control" autocomplete="off" readonly></td>
		 				<td><input type="text" name="igst_per[<?php echo $material['mat_id']?>]" value="<?php echo $material['igst_per']?>" class="form-control" autocomplete="off" onkeyup="mypo_igst_per(this.value,<?php echo $material['mat_id']?>)"></td>
		 				<td><input type="text" name="igst_amt[<?php echo $material['mat_id']?>]" value="<?php echo $material['igst_amt']?>" class="form-control" autocomplete="off" readonly></td>
		 				<td></td>
		 			</tr>
		 		<?php
		 			 $total = $total + $material['mat_amount'];
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