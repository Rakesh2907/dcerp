<input type="hidden" name="mat_batch_list" value="1" />
<table id="batch_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_mat_list_info">
                      <thead>
                          <th><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode-reader.png" style="margin-right: 5px;">Bar Code <i style="color: red; font-size: 10px;">(NA Not Allowed)</i></th>
                          <th>Batch No. <i style="color: red; font-size: 10px;">(NA Not Allowed)</i></th>
                          <th>Serial No. <i style="color: red; font-size: 10px;">(NA Not Allowed)</i></th>
                          <th>Received Qty.</th>
                          <th>Accepted Qty. (QC Check)</th>
                          <th>Exprire Date <i style="color: red; font-size: 10px;"></i></th>
                          <th>Shipping Temp.</th>
                          <th>Storage Temp.</th>
                          <th>Stored In Location</th>
                          <th>Action(s)</th>
                      </thead>
                      <tbody>
                        <tr id="batch_row_id_1">
                            <td>
                            	<input type="text" class="form-control inputs" name="mat_bar_code[]" value="" id="bar_code_1"  autocomplete="off"/>
                            </td>
                            <td><input type="text" class="form-control inputs" name="mat_batch_no[]" value="" id="batch_no_1"  autocomplete="off"/><button type="button" onclick="create_batch_number(1)">Generate Batch No.</button></td>
                            <td><input type="text" class="form-control inputs" name="mat_lot_no[]" value="" id="lot_no_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="mat_batch_received_qty[]" value="0" id="batch_received_qty_1"  autocomplete="off"/></td>
                            <td>
                              <?php
                                if($inward_form_type == 'material_inward_form'){
                                   if(validateAccess('material_inward-quality_accepted_quantity',$access)){
                                        $readonly = '';
                                    }else{
                                        $readonly = 'readonly';
                                    }
                                }else{
                                    $readonly = '';
                                }
                              ?>
                              <input type="text" class="form-control inputs" name="mat_accepted_qty[]" value="0" id="accepted_qty_1" autocomplete="off" <?php echo $readonly?>/>
                            </td>
                            <td>
                                <input class="form-control batch_expire_date" type="text" class="form-control inputs" name="mat_expire_date[]" value="" id="expire_date_1"  autocomplete="off"/>
                                <input type="checkbox" name="mat_na[]" id="na_allowed_1">
                                <label>NA</label>
                            </td>
                            <td><input type="text" class="form-control inputs" name="mat_shipping_temp[]" value="" id="shipping_temp_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="mat_storage_temp[]" value="" id="storage_temp_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="mat_stored_in[]" value="" id="stored_in_1"  autocomplete="off"/></td>
                            <td><button type="button" onclick="remove_row(1,<?php echo $mat_id;?>,<?php echo $inward_id?>,<?php echo $po_id?>,'insert')">x</button></td>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                   $('.batch_expire_date').datepicker({
                                            autoclose: true,
                                            format: 'dd-mm-yyyy'
                                    });

                                    $('#batch_form #bar_code_1').rules('add', {
                                          required: true
                                     });

                                    $('#batch_form #batch_no_1').rules('add', {
                                          required: true
                                    }); 

                                    $('#batch_form #lot_no_1').rules('add', {
                                          required: true
                                    });

                                    $('#batch_form #batch_received_qty_1').rules('add', {
                                          number: true, 
                                          required: true
                                    });

                                    $('#batch_form #accepted_qty_1').rules('add', {
                                          number: true, 
                                          required: true
                                    });

                                    $('#batch_form #na_allowed_1').change(function(){
                                            if(this.checked) {
                                                  $("#batch_form #expire_date_1").removeClass("batch_expire_date");
                                                  $('#batch_form #expire_date_1').attr('disabled', true);
                                                  $('#batch_form #expire_date_1').val('');
                                            }else{
                                                  $('#batch_form #expire_date_1').rules('add', {
                                                     required: true
                                                  });
                                                  $('#batch_form #expire_date_1').attr('disabled', false);
                                                  $("#batch_form #expire_date_1").addClass("batch_expire_date");
                                            }
                                    });

                                });
                            </script>
                        </tr>
                      </tbody>             
</table>
<table class="table">
  <tr>
    <td><button type="button" onclick="add_row('insert',<?php echo $inward_id?>)">+</button></td>
  </tr>
</table>