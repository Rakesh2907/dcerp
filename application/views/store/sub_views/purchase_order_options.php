<option value="">Select PO</option>
<?php if(!empty($purchase_order_list)){
	  foreach ($purchase_order_list as $key => $po) {
?>
			<option value="<?php echo $po['po_id']?>"><?php echo $po['po_number']?></option>
<?php
	  }
?>
<?php }?>