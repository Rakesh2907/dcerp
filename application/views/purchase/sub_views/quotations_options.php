<option>Select Quotation(s)</option>
<?php
 if(!empty($quotations)){ 
	foreach($quotations as $key => $quotation){?>
		<option value="<?php echo $quotation['quotation_id']?>"><?php echo $quotation['quotation_number']?></option>	
<?php }
   }
?>