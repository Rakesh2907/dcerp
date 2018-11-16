<table id="sub_mat_list_<?php echo $sub_mat_id?>" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_mat_list_info">
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
                            	<input type="hidden" name="sub_mat_id[<?php echo $sub_mat_id?>][1]" value="<?php echo $sub_mat_id?>" />
                            	<img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode.png" style="margin-right: 5px;"><input type="text" class="form-control inputs" name="sub_mat_bar_code[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_bar_code_<?php echo $sub_mat_id?>_1" />
                            </td>
                            <td><input type="text" class="form-control inputs" name="sub_mat_batch_no[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_batch_no_<?php echo $sub_mat_id?>_1" /></td>
                            <td><input type="text" class="form-control inputs" name="sub_mat_lot_no[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_lot_no_<?php echo $sub_mat_id?>_1" /></td>
                            <td><input type="text" class="form-control inputs" name="sub_mat_received_qty[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_received_qty_<?php echo $sub_mat_id?>_1" /></td>
                            <td><input type="text" class="form-control inputs" name="sub_mat_accepted_qty[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_accepted_qty_<?php echo $sub_mat_id?>_1" /></td>
                            <td><input class="expire_date" type="text" class="form-control inputs" name="sub_mat_expire_date[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_expire_date_<?php echo $sub_mat_id?>_1" /></td>
                            <td><input type="text" class="form-control inputs" name="sub_mat_shipping_temp[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_shipping_temp_<?php echo $sub_mat_id?>_1" /></td>
                            <td><input type="text" class="form-control inputs" name="sub_mat_storage_temp[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_storage_temp_<?php echo $sub_mat_id?>_1" /></td>
                            <td><button type="button" onclick="add_row(<?php echo $sub_mat_id?>,1)">+</button>&nbsp;&nbsp;<button type="button" onclick="remove_row(<?php echo $sub_mat_id?>, 1)">x</button></td>
                        </tr>
                      </tbody>             
</table> 
<script type="text/javascript">
	function remove_row(sub_mat_id,row_id){
		$("#batch_row_id_"+row_id).remove();
	}
	
	function add_row(sub_mat_id,row_id){
		    var row = row_id + 1;

		    $.ajax({
		    				url: baseURL +'commonrequesthandler_ui/add_new_row',
	     	   				headers: { 'Authorization': user_token },
	               			method: "POST",
	                		data: JSON.stringify({sub_mat_id:sub_mat_id,row:row}),
	                		contentType:false,
	                		cache:false,
	                		processData:false,
	                		beforeSend: function () {
	     							//$(".content-wrapper").LoadingOverlay("show");
     						},
					        success: function(result, status, xhr) {
					        	$('#sub_mat_list_'+sub_mat_id).append(result);
		   						$('#sub_mat_bar_code_'+sub_mat_id+'_'+row).focus().select();	
					        }
		    });
	}

	$(document).ready(function(){
		 $('.expire_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
        });
	});
</script>