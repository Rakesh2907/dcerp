<?php foreach($mysuppliers as $key => $suppliers){
	$selected = '';
	if(!empty($vendor_id)) {
	if(in_array($suppliers['supplier_id'], $vendor_id)){
		$selected = 'selected="selected"';
	}
}
?>
	<option value="<?php echo $suppliers['supplier_id']?>" <?php echo $selected;?>><?php echo $suppliers['supp_firm_name']?></option>
<?php }?>