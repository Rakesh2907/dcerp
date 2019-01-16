<ul id="mat-code-list_<?php echo $row_id?>" class="mat-code-list_cls">
	<?php if(!empty($mat_code)){?>
		<?php foreach($mat_code as $key => $code){?>
			<li onclick="set_material(<?php echo $code["mat_id"];?>,<?php echo $row_id?>,'mat_code');" style="cursor: pointer;"><?php echo $code["mat_code"];?></li>
		<?php } ?>
	<?php } ?>	
</ul>