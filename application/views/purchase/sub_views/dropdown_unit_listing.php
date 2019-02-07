<?php 
	foreach ($units as $key => $value) {
?>
	<option value="<?php echo $value['unit_id']?>"><?php echo $value['unit']?></option>
<?php		
	}
?>