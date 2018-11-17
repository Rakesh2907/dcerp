<tr id="batch_row_id_<?php echo $i?>">
	<td>
		<input type="hidden" name="mat_id[<?php echo $i?>]" value="" />
		<input type="text" class="form-control inputs" name="bar_code[<?php echo $i?>]" value="" id=""  autocomplete="off"/>
	</td>
	<td><input type="text" class="form-control inputs" name="batch_no[<?php echo $i?>]" value="" id=""  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="lot_no[<?php echo $i?>]" value="" id=""  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="batch_received_qty[<?php echo $i?>]" value="0" id=""  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="accepted_qty[<?php echo $i?>]" value="" id="0"  autocomplete="off"/></td>
	<td><input class="form-control expire_date" type="text" class="form-control inputs" name="expire_date[<?php echo $i?>]" value="" id=""  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="shipping_temp[<?php echo $i?>]" value="" id=""  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="storage_temp[<?php echo $i?>]" value="" id=""  autocomplete="off"/></td>
	<td><button type="button" onclick="add_row(<?php echo $i?>)">+</button>&nbsp;&nbsp;<button type="button" onclick="remove_row(<?php echo $i?>)">x</button></td>
</tr>
<script type="text/javascript">
  $(document).ready(function(){
	$('.expire_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    });
  });
</script>