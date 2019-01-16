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
                        <?php 
                            if(!empty($mat_bat_number))
                            {
                              foreach ($mat_bat_number as $key => $batch) {
                               // echo "<pre>"; print_r($batch);  echo "</pre>";

                                if($batch['received_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){
                                    $myreadonly = 'readonly';
                                }else{
                                    $myreadonly = '';
                                }
                        ?>
                            <tr id="batch_row_id_<?php echo $batch['batch_id']?>">
                                <td>
                                	<input type="text" class="form-control inputs" name="mat_bar_code[]" value="<?php echo $batch['bar_code']?>" id="bar_code_<?php echo $batch['batch_id']?>"  autocomplete="off" <?php echo $myreadonly?>/>
                                </td>
                                <td>
                                  <input type="text" class="form-control inputs" name="mat_batch_no[]" value="<?php echo $batch['batch_number']?>" id="batch_no_<?php echo $batch['batch_id']?>"  autocomplete="off" <?php echo $myreadonly?>/>
                                  <?php if($batch['received_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){}else{ ?>
                                      <button type="button" onclick="create_batch_number(<?php echo $batch['batch_id']?>)">Generate Batch No.</button>
                                  <?php } ?>  
                                </td>
                                <td>
                                   <input type="text" class="form-control inputs" name="mat_lot_no[]" value="<?php echo $batch['lot_number']?>" id="lot_no_<?php echo $batch['batch_id']?>"  autocomplete="off" <?php echo $myreadonly?>/>
                                </td>
                                <td>
                                  <input type="text" class="form-control inputs" name="mat_batch_received_qty[]" value="<?php echo $batch['received_qty']?>" id="batch_received_qty_<?php echo $batch['batch_id']?>"  autocomplete="off" <?php echo $myreadonly?>/>
                                </td>
                                <td>
                                  <?php
                                        if($inward_form_type == 'material_inward_form'){
                                            if(validateAccess('material_inward-quality_accepted_quantity',$access)){  
                                                 $readonly = '';
                                            }else{
                                                 $readonly = 'readonly';
                                            }
                                        }else{
                                           if($batch['received_qty'] > 0 && $batch['accepted_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){
                                                $readonly = 'readonly';
                                           }else{
                                                $readonly = '';
                                           }   
                                        }
                                  ?>
                                    <input type="text" class="form-control inputs" name="mat_accepted_qty[]" value="<?php echo $batch['accepted_qty']?>" id="accepted_qty_<?php echo $batch['batch_id']?>" autocomplete="off" <?php echo $readonly?>/>
                                </td>
                                <td>
                                    <input class="form-control batch_expire_date" type="text" class="form-control inputs" name="mat_expire_date[]" value="<?php echo date('d-m-Y',strtotime($batch['expire_date']))?>" id="expire_date_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                    <input type="checkbox" name="mat_na[]" id="na_allowed_<?php echo $batch['batch_id']?>">
                                    <label>NA</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_shipping_temp[]" value="<?php echo $batch['shipping_temp']?>" id="shipping_temp_<?php echo $batch['batch_id']?>"  autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_storage_temp[]" value="<?php echo $batch['storage_temp']?>" id="storage_temp_<?php echo $batch['batch_id']?>"  autocomplete="off" />
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_stored_in[]" value="<?php echo $batch['stored_in']?>" id="stored_in_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                  <?php if($inward_data[0]['quality_status'] == 'check' || $inward_data[0]['payment_status'] == 'paid'){ ?>
                                          <input type="hidden" name="mat_is_deleted[]" value="0">
                                  <?php }else{ 
                                      if($batch['received_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){ ?>
                                          <input type="hidden" name="mat_is_deleted[]" value="0">
                                  <?php }else{ ?>      
                                           <select name="mat_is_deleted[]" class="form-control">
                                              <option value="0">Saved</option>
                                              <option value="1">Delete</option> 
                                           </select>
                                  <?php  } 
                                       }
                                  ?> 

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

                                        $('#batch_form #na_allowed_<?php echo $batch['batch_id']?>').change(function() {
                                            if(this.checked) {
                                                  $("#batch_form #expire_date_<?php echo $batch['batch_id']?>").removeClass("batch_expire_date");
                                                  $('#batch_form #expire_date_<?php echo $batch['batch_id']?>').attr('disabled', true);
                                                  $('#batch_form #expire_date_<?php echo $batch['batch_id']?>').val('');
                                            }else{
                                                  $('#batch_form #expire_date_<?php echo $batch['batch_id']?>').rules('add', {
                                                     required: true
                                                  });
                                                  $('#batch_form #expire_date_<?php echo $batch['batch_id']?>').attr('disabled', false);
                                                  $("#batch_form #expire_date_<?php echo $batch['batch_id']?>").addClass("batch_expire_date");
                                            }
                                        });

                                        <?php if($batch['na_allowed'] == 'yes'){ ?>
                                                    $('#batch_form #na_allowed_<?php echo $batch['batch_id']?>').trigger('click');
                                        <?php } ?>
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
    <td><button type="button" onclick="add_row('edit',<?php echo $inward_id?>)">+</button></td>
  </tr>
</table>