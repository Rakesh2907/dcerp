<tr id="count_<?php echo $row_id?>">
	<td>#<?php echo $row_id?><input type="hidden" name="rows[<?php echo $row_id?>]" value="<?php echo $row_id?>" /></td>
	<td><input type="text" class="form-control bill_date_will_be" id="bill_due_date_<?php echo $row_id?>" name="bill_due_date[<?php echo $row_id?>]" placeholder="Set Billing Date" name="bill_date_will_be" required autocomplete="off"></td>
	<td><input type="text" class="form-control" id="amount_<?php echo $row_id?>" name="amount[<?php echo $row_id?>]" value="0" onkeyup="set_balance_amount(this.value,<?php echo $row_id?>)"></td><td><input type="text" class="form-control" name="balance_amount[<?php echo $row_id?>]" value="0" readonly></td>
</tr>
<script type="text/javascript">
	$('.bill_date_will_be').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
    });

	$('#bill_due_date_<?php echo $row_id?>').rules('add', {
		      required: true,
    });

    $('#amount_<?php echo $row_id?>').rules('add', {
		      required: true,
		      number: true,
    });
</script>