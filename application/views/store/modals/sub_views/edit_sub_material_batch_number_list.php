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
                       <?php 
                          foreach($sub_mat_bath_number_details as $batch_id => $batch){  //echo "<pre>"; print_r($batch);
                            $i = 1;
                        ?> 
                          <tr id="batch_row_id_<?php echo $batch['batch_id']?>">
                              <td>
                              	<input type="hidden" name="sub_mat_id[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $sub_mat_id?>" />
                              	<img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode.png" style="margin-right: 5px;"><input type="text" class="form-control inputs" name="bar_code[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['bar_code']?>" id="sub_mat_bar_code_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                              </td>
                              <td><input type="text" class="form-control inputs" name="batch_no[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['batch_number']?>" id="sub_mat_batch_no_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/></td>
                              <td><input type="text" class="form-control inputs" name="lot_no[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['lot_number']?>" id="sub_mat_lot_no_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/></td>
                              <td><input type="text" class="form-control inputs" name="batch_received_qty[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['received_qty']?>" id="sub_mat_received_qty_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/></td>
                              <td><input type="text" class="form-control inputs" name="accepted_qty[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['accepted_qty']?>" id="sub_mat_accepted_qty_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/></td>
                              <td><input class="form-control expire_date" type="text" class="form-control inputs" name="expire_date[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo date("d-m-Y",strtotime($batch['expire_date']))?>" id="sub_mat_expire_date_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/></td>
                              <td><input type="text" class="form-control inputs" name="shipping_temp[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['shipping_temp']?>" id="sub_mat_shipping_temp_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/></td>
                              <td><input type="text" class="form-control inputs" name="storage_temp[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['storage_temp']?>" id="sub_mat_storage_temp_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/></td>
                              <td><!-- <button type="button" onclick="add_row(<?php //echo $sub_mat_id?>,1)">+</button> -->&nbsp;&nbsp;<!-- <button type="button" onclick="remove_sub_mat_row(<?php echo $sub_mat_id?>,<?php echo $mat_id?>,<?php //echo $inward_id?>,<?php //echo $po_id?>,<?php //echo $batch['batch_id']?>,'edit')">x</button> -->
                                <select name="sub_mat_is_deleted[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" class="form-control">
                                      <option value="0">Saved</option>
                                      <option value="1">Delete</option> 
                                </select>
                              </td>
                               <script type="text/javascript">
                                  $(document).ready(function(){
                                     $('.expire_date').datepicker({
                                              autoclose: true,
                                              format: 'dd-mm-yyyy'
                                     });

                                     $('#batch_form #sub_mat_bar_code_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>').rules('add', {
                                            required: true
                                     });

                                     $('#batch_form #sub_mat_batch_no_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>').rules('add', {
                                            required: true
                                     });

                                     $('#batch_form #sub_mat_lot_no_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>').rules('add', {
                                            required: true
                                     });

                                     $('#batch_form #sub_mat_received_qty_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>').rules('add', {
                                            number:true,
                                            required: true
                                     });

                                     $('#batch_form #sub_mat_accepted_qty_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>').rules('add', {
                                            number:true,
                                            required: true
                                     });

                                     $('#batch_form #sub_mat_expire_date_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>').rules('add', {
                                            required: true
                                     });

                                  });
                              </script>
                          </tr>
                      <?php
                        $i = $i + 1; 
                       } ?>  
                      </tbody>             
</table> 