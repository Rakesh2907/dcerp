<input type="hidden" name="mat_batch_list" value="1" />
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
                        <?php 
                            if(!empty($mat_bat_number))
                            {
                              foreach ($mat_bat_number as $key => $batch) {
                                //echo "<pre>"; print_r($batch); echo "</pre>";
                        ?>
                            <tr id="batch_row_id_<?php echo $batch['batch_id']?>">
                                <td>
                                	<input type="text" class="form-control inputs" name="mat_bar_code[]" value="<?php echo $batch['bar_code']?>" id="bar_code_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                  <input type="text" class="form-control inputs" name="mat_batch_no[]" value="<?php echo $batch['batch_number']?>" id="batch_no_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                   <input type="text" class="form-control inputs" name="mat_lot_no[]" value="<?php echo $batch['lot_number']?>" id="lot_no_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                  <input type="text" class="form-control inputs" name="mat_batch_received_qty[]" value="<?php echo $batch['received_qty']?>" id="batch_received_qty_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_accepted_qty[]" value="<?php echo $batch['accepted_qty']?>" id="accepted_qty_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                    <input class="form-control batch_expire_date" type="text" class="form-control inputs" name="mat_expire_date[]" value="<?php echo date('d-m-Y',strtotime($batch['expire_date']))?>" id="expire_date_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_shipping_temp[]" value="<?php echo $batch['shipping_temp']?>" id="shipping_temp_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_storage_temp[]" value="<?php echo $batch['storage_temp']?>" id="storage_temp_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                  <select name="mat_is_deleted[]" class="form-control">
                                      <option value="0">Saved</option>
                                      <option value="1">Delete</option> 
                                  </select>

                                  <!-- <button type="button" onclick="remove_row(<?php //echo $batch['batch_id']?>,<?php //echo $mat_id;?>,<?php //echo $inward_id?>,<?php //echo $po_id?>,'edit')">x</button> -->
                                </td>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('.batch_expire_date').datepicker({
                                              autoclose: true,
                                              format: 'dd-mm-yyyy'
                                        });

                                        $('#batch_form #bar_code_<?php echo $batch['batch_id']?>').rules('add', {
                                              required: true
                                        });

                                        $('#batch_form #batch_no_<?php echo $batch['batch_id']?>').rules('add', {
                                               required: true
                                        }); 

                                        $('#batch_form #lot_no_<?php echo $batch['batch_id']?>').rules('add', {
                                              required: true
                                        });

                                        $('#batch_form #batch_received_qty_<?php echo $batch['batch_id']?>').rules('add', {
                                              number: true, 
                                              required: true
                                        });
                                    
                                        $('#batch_form #accepted_qty_<?php echo $batch['batch_id']?>').rules('add', {
                                              number: true, 
                                              required: true
                                        });

                                        $('#batch_form #expire_date_<?php echo $batch['batch_id']?>').rules('add', {
                                              required: true
                                        });
                                    });
                                </script>
                            </tr>
                      <?php
                          } 
                        } ?>
                      </tbody>             
</table>
<table class="table">
  <tr>
    <td><button type="button" onclick="add_row()">+</button></td>
  </tr>
</table>