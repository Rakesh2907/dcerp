<tr id="batch_row_id_<?php echo $i?>">
	<td>
		<input type="hidden" name="sub_mat_id[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="<?php echo $sub_mat_id?>" />
		<img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode.png" style="margin-right: 5px;"><input type="text" class="form-control inputs" name="sub_mat_bar_code[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="" id="sub_mat_bar_code_<?php echo $sub_mat_id?>_<?php echo $i?>" />
	</td>
	<td><input type="text" class="form-control inputs" name="sub_mat_batch_no[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="" id="sub_mat_batch_no_<?php echo $sub_mat_id?>_<?php echo $i?>"/></td>
	<td><input type="text" class="form-control inputs" name="sub_mat_lot_no[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="" id="sub_mat_lot_no_<?php echo $sub_mat_id?>_<?php echo $i?>" /></td>
	<td><input type="text" class="form-control inputs" name="sub_mat_received_qty[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="" id="sub_mat_received_qty_<?php echo $sub_mat_id?>_<?php echo $i?>" /></td>
	<td><input type="text" class="form-control inputs" name="sub_mat_accepted_qty[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="" id="sub_mat_accepted_qty_<?php echo $sub_mat_id?>_<?php echo $i?>" /></td>
	<td><input class="expire_date" type="text" class="form-control inputs" name="sub_mat_expire_date[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="" id="sub_mat_expire_date_<?php echo $sub_mat_id?>_<?php echo $i?>" /></td>
	<td><input type="text" class="form-control inputs" name="sub_mat_shipping_temp[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="" id="sub_mat_shipping_temp_<?php echo $sub_mat_id?>_<?php echo $i?>" /></td>
	<td><input type="text" class="form-control inputs" name="sub_mat_storage_temp[<?php echo $sub_mat_id?>][<?php echo $i?>]" value="" id="sub_mat_storage_temp_<?php echo $sub_mat_id?>_<?php echo $i?>" /></td>
	<td><button type="button" onclick="add_row(<?php echo $sub_mat_id?>,<?php echo $i?>)">+</button>&nbsp;&nbsp;<button type="button" onclick="remove_row(<?php echo $sub_mat_id?>, <?php echo $i?>)">x</button></td>
</tr>
<script type="text/javascript">
  $(document).ready(function(){
		 $('.expire_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
        });
  });
</script>