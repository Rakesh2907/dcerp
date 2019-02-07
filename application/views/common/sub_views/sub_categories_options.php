<?php  foreach($sub_cat as $key => $cat){ ?>
		<option data-id="0" value="<?php echo $cat['sub_cat_id'];?>"><?php echo strtoupper($cat['cat_name']);?></option>
<?php	} ?>