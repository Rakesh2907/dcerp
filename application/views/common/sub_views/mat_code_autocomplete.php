<ul id="mat-code-list">
	<?php if(!empty($mat_code)){?>
		<?php foreach($mat_code as $key => $code){?>
			<li onclick="get_mat_code('<?php echo trim($code["mat_code"]); ?>','<?php echo $code["mat_id"]; ?>');"><?php echo $code["mat_code"]; ?></li>
		<?php } ?>
	<?php } ?>	
</ul>	