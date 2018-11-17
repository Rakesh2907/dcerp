<table id="batch_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_mat_list_info">
                      <thead>
                          <th><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode-reader.png" style="margin-right: 5px;">Bar Code</th>
                          <th>Batch No.</th>
                          <th>Lot No.</th>
                          <th>Received Qty.</th>
                          <th>Accepted Qty.</th>
                          <th>Exprire Date</th>
                          <th>Shipping Temp.</th>
                          <th>Storage Temp.</th>
                          <th>Action(s)</th>
                      </thead>
                      <tbody>
                        <tr id="batch_row_id_1">
                            <td>
                            	<input type="text" class="form-control inputs" name="bar_code[1]" value="" id="bar_code_1"  autocomplete="off"/>
                            </td>
                            <td><input type="text" class="form-control inputs" name="batch_no[1]" value="" id="batch_no_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="lot_no[1]" value="" id="sub_mat_lot_no_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="batch_received_qty[1]" value="0" id="sub_mat_received_qty_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="accepted_qty[1]" value="0" id="sub_mat_accepted_qty_1"  autocomplete="off"/></td>
                            <td><input class="form-control expire_date" type="text" class="form-control inputs" name="expire_date[1]" value="" id="sub_mat_expire_date_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="shipping_temp[1]" value="" id="sub_mat_shipping_temp_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="storage_temp[1]" value="" id="sub_mat_storage_temp_1"  autocomplete="off"/></td>
                            <td><button type="button" onclick="add_row(1)">+</button>&nbsp;&nbsp;<button type="button" onclick="remove_row(1)">x</button></td>
                        </tr>
                      </tbody>             
</table> 
<script type="text/javascript">
	$(document).ready(function(){
		 $('.expire_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
        });
	});
</script>