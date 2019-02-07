<ul id="mat-name-list_<?php echo $row_id?>" class="mat-code-list_cls" style="overflow: auto; height: 200px;">
	<?php if(!empty($mat_name)){?>
		<?php foreach($mat_name as $key => $code){?>
			<li onclick="set_material(<?php echo $code["mat_id"];?>,<?php echo $row_id?>,'mat_name');" style="cursor: pointer;"><?php echo $code["mat_name"];?></li> 
		<?php } ?>
		<li onclick="load_page('purchase/add_material_form')" style="cursor: pointer; background-color: #f0bc62; color: #ffffff; font-weight: bold; font-size: 15px;">Add New Material <span>(+)</span></li>
	<?php } ?>	
</ul>