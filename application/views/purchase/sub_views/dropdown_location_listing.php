<?php 
	foreach ($locations as $key => $value) {
?>
	<option value="<?php echo $value['location_id']?>"><?php echo $value['location_name']?></option>
<?php		
	}
?>