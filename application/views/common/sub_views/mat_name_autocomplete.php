<ul id="mat-code-list">
	<?php if(!empty($mat_name)){?>
		<?php foreach($mat_name as $key => $code){?>
			<li onclick="get_mat_code('<?php echo trim($code["mat_code"]); ?>','<?php echo $code["mat_id"]; ?>');"><?php echo $code["mat_name"]; ?></li>
		<?php } ?>
	<?php } ?>	
</ul>	