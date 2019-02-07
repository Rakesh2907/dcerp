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
                          <th>Batch Status(QC)</th>
                          <th>Remark (QC)</th>
                          <th style="display: none;">Action(s)</th>

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
                                	<input type="text" class="form-control inputs" name="mat_bar_code[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['bar_code']?>" id="bar_code_<?php echo $batch['batch_id']?>"  autocomplete="off" readonly/>
                                </td>
                                <td>
                                  <input type="text" class="form-control inputs" name="mat_batch_no[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['batch_number']?>" id="batch_no_<?php echo $batch['batch_id']?>"  autocomplete="off" readonly/>
                                </td>
                                <td>
                                   <input type="text" class="form-control inputs" name="mat_lot_no[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['lot_number']?>" id="lot_no_<?php echo $batch['batch_id']?>"  autocomplete="off" readonly/>
                                </td>
                                <td>
                                  <input type="text" class="form-control inputs" name="mat_batch_received_qty[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['received_qty']?>" id="batch_received_qty_<?php echo $batch['batch_id']?>"  autocomplete="off" readonly/>
                                </td>
                                <td>
                                 <?php  
                                    if($batch['received_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){
                                       $myreadonly = 'readonly';
                                    }else{
                                       $myreadonly = '';
                                    }
                                 ?> 
                                    <input type="text" class="form-control inputs" name="mat_accepted_qty[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['accepted_qty']?>" id="accepted_qty_<?php echo $batch['batch_id']?>" autocomplete="off" <?php echo $myreadonly?>/>
                                </td>
                                <td>
                                    <input class="form-control batch_expire_date" type="text" class="form-control inputs" name="mat_expire_date[<?php echo $batch['batch_id']?>]" value="<?php echo date('d-m-Y',strtotime($batch['expire_date']))?>" id="expire_date_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                    <input type="checkbox" name="mat_na[<?php echo $batch['batch_id']?>]" id="na_allowed_<?php echo $batch['batch_id']?>">
                                    <label>NA</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_shipping_temp[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['shipping_temp']?>" id="shipping_temp_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_storage_temp[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['storage_temp']?>" id="storage_temp_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_stored_in[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['stored_in']?>" id="stored_in_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                                </td>
                                <td>
                                  <?php if($batch['received_qty'] > 0 && $batch['accepted_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){ ?>
                                       <small class="label" style="background-color: #098e1b;color:#FFFFFF">Outward / <?php echo ucfirst($batch['qc_batch_status'])?></small>
                                       <input type="hidden" name="mat_qc_batch_status[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['qc_batch_status']?>" />
                                  <?php }else{ ?>
                                    <select id="qc_batch_status_<?php echo $batch['batch_id']?>" name="mat_qc_batch_status[<?php echo $batch['batch_id']?>]" onchange="set_accepted_qty(this.value,<?php echo $batch['batch_id']?>)" class="form-control">
                                        <option value="regretted" <?php if($batch['qc_batch_status']=='regretted'){ echo 'selected';}else{echo '';}?>>Regretted</option>
                                        <option value="accepted" <?php if($batch['qc_batch_status']=='accepted'){ echo 'selected';}else{echo '';}?>>Accepted</option>
                                        <option value="accepted_with_deviation" <?php if($batch['qc_batch_status']=='accepted_with_deviation'){ echo 'selected';}else{echo '';}?>>Accepted with Deviation</option>
                                    </select>
                                  <?php } ?>  
                                </td>
                                <td>
                                    <input type="text" class="form-control inputs" name="mat_qc_batch_remark[<?php echo $batch['batch_id']?>]" value="<?php echo $batch['qc_batch_remark']?>" id="qc_batch_remark_<?php echo $batch['batch_id']?>"  autocomplete="off"/> 
                                </td>
                                <td style="display: none;">
                                  <select name="mat_is_deleted[<?php echo $batch['batch_id']?>]" class="form-control">
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

                                        $('#batch_form_qc #bar_code_<?php echo $batch['batch_id']?>').rules('add', {
                                              required: true
                                        });

                                        $('#batch_form_qc #batch_no_<?php echo $batch['batch_id']?>').rules('add', {
                                               required: true
                                        }); 

                                        $('#batch_form_qc #lot_no_<?php echo $batch['batch_id']?>').rules('add', {
                                              required: true
                                        });

                                        $('#batch_form_qc #batch_received_qty_<?php echo $batch['batch_id']?>').rules('add', {
                                              number: true, 
                                              required: true
                                        });
                                    
                                        $('#batch_form_qc #accepted_qty_<?php echo $batch['batch_id']?>').rules('add', {
                                              number: true, 
                                              required: true
                                        });

                                        $('#batch_form_qc #na_allowed_<?php echo $batch['batch_id']?>').change(function() {
                                            if(this.checked) {
                                                  $("#batch_form_qc #expire_date_<?php echo $batch['batch_id']?>").removeClass("batch_expire_date");
                                                  $('#batch_form_qc #expire_date_<?php echo $batch['batch_id']?>').attr('disabled', true);
                                                  $('#batch_form_qc #expire_date_<?php echo $batch['batch_id']?>').val('');
                                            }else{
                                                  $('#batch_form_qc #expire_date_<?php echo $batch['batch_id']?>').rules('add', {
                                                     required: true
                                                  });
                                                  $('#batch_form_qc #expire_date_<?php echo $batch['batch_id']?>').attr('disabled', false);
                                                  $("#batch_form_qc #expire_date_<?php echo $batch['batch_id']?>").addClass("batch_expire_date");
                                            }
                                        });

                                        <?php if($batch['na_allowed'] == 'yes'){ ?>
                                                    $('#batch_form_qc #na_allowed_<?php echo $batch['batch_id']?>').trigger('click');
                                        <?php } ?>
                                    });
                                </script>
                            </tr>
                      <?php
                          } 
                        } ?>
                      </tbody>             
</table>