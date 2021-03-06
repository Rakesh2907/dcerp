<tr id="batch_row_id_<?php echo $i?>">
	<td><input type="text" class="form-control inputs" name="bar_code[]" value="" id="bar_code_<?php echo $i?>"  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="batch_no[]" value="" id="batch_no_<?php echo $i?>"  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="lot_no[]" value="" id="lot_no_<?php echo $i?>"  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="batch_received_qty[]" value="0" id="batch_received_qty_<?php echo $i?>"  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="accepted_qty[]" value="0" id="accepted_qty_<?php echo $i?>"  autocomplete="off"/></td>
	<td><input class="form-control expire_date" type="text" class="form-control inputs" name="expire_date[<?php echo $i?>]" value="" id="expire_date_<?php echo $i?>"  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="shipping_temp[]" value="" id="shipping_temp_<?php echo $i?>"  autocomplete="off"/></td>
	<td><input type="text" class="form-control inputs" name="storage_temp[]" value="" id="storage_temp_<?php echo $i?>"  autocomplete="off"/></td>
	<td><button type="button" onclick="remove_row(<?php echo $i?>,'edit')">x</button></td>
<script type="text/javascript">
  $(document).ready(function(){
     $("#add_new_row_<?php echo $i?>").remove(); 
	$('#batch_form .expire_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    });

    $('#batch_form #bar_code_<?php echo $i?>').rules('add', {
          required: true
    });

    $('#batch_form #batch_no_<?php echo $i?>').rules('add', {
          required: true
    });

    $('#batch_form #lot_no_<?php echo $i?>').rules('add', {
          required: true
    });

    $('#batch_form #batch_received_qty_<?php echo $i?>').rules('add', {
    	  number: true,	
          required: true
    });

    $('#batch_form #accepted_qty_<?php echo $i?>').rules('add', {
    	  number: true,
          required: true
    });

    $('#batch_form #expire_date_<?php echo $i?>').rules('add', {
          required: true
    });

  });
</script>
</tr>