<table id="sub_mat_list_<?php echo $sub_mat_id?>" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_mat_list_info">
                      <thead>
                         <!--  <th><img src="<?php //echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode-reader.png" style="margin-right: 5px;">Bar Code <i style="color: red; font-size: 10px;">(NA Not Allowed)</i></th> -->
                          <th>Batch No. <i style="color: red; font-size: 10px;">(NA Not Allowed)</i></th>
                          <th>Serial No. <i style="color: red; font-size: 10px;">(NA Not Allowed)</i></th>
                          <th>Received Qty.</th>
                          <th>Accepted Qty. (QC Check)</th>
                          <th>Exprire Date <i style="color: red; font-size: 10px;">(NA Not Allowed)</i></th>
                          <th>Shipping Temp.</th>
                          <th>Storage Temp.</th>
                          <th>Stored In Location</th>
                          <th>Action(s)</th>
                      </thead>
                      <tbody>
                       <?php 
                          foreach($sub_mat_bath_number_details as $batch_id => $batch){  //echo "<pre>"; print_r($batch); echo "</pre>";
                           if($batch['received_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){
                                    $myreadonly = 'readonly';
                           }else{
                                    $myreadonly = '';
                          }
                        ?> 
                          <tr id="batch_row_id_<?php echo $batch['batch_id']?>">
                              <!-- <td> -->
                              	<input type="hidden" name="sub_mat_id[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $sub_mat_id?>" />
                              	<!-- <input type="text" class="form-control inputs" name="bar_code[<?php //echo $sub_mat_id?>][<?php //echo $batch['batch_id']?>]" value="<?php //echo $batch['bar_code']?>" id="sub_mat_bar_code_<?php //echo $sub_mat_id?>_<?php //echo $batch['batch_id']?>"  autocomplete="off" <?php //echo $myreadonly?>/> -->
                              <!-- </td> -->
                              <td>
                                <input type="text" class="form-control inputs" name="batch_no[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['batch_number']?>" id="sub_mat_batch_no_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off" <?php echo $myreadonly?>/>
                                <?php if($batch['received_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){}else{ ?>
                                  <button type="button" onclick="create_batch_number_sub_material(<?php echo $sub_mat_id?>,<?php echo $batch['batch_id']?>)">Generate Batch No.</button>
                                <?php } ?>   
                              </td>
                              <td>
                                  <input type="text" class="form-control inputs" name="lot_no[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['lot_number']?>" id="sub_mat_lot_no_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off" <?php echo $myreadonly?>/>
                              </td>
                              <td>
                                  <input type="text" class="form-control inputs" name="batch_received_qty[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['received_qty']?>" id="sub_mat_received_qty_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off" <?php echo $myreadonly?>/>
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
                                        if($batch['received_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){
                                            $readonly = 'readonly';
                                        }else{
                                            $readonly = '';
                                        }
                                      }
                              ?>
                                  <input type="text" class="form-control inputs" name="accepted_qty[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['accepted_qty']?>" id="sub_mat_accepted_qty_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off" <?php echo $readonly?>/>
                              </td>
                              <td>
                                <input class="form-control expire_date" type="text" class="form-control inputs" name="expire_date[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo date("d-m-Y",strtotime($batch['expire_date']))?>" id="sub_mat_expire_date_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                              </td>
                              <td>
                                <input type="text" class="form-control inputs" name="shipping_temp[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['shipping_temp']?>" id="sub_mat_shipping_temp_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                              </td>
                              <td>
                                <input type="text" class="form-control inputs" name="storage_temp[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['storage_temp']?>" id="sub_mat_storage_temp_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                              </td>
                              <td>
                                <input type="text" class="form-control inputs" name="stored_in[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="<?php echo $batch['stored_in']?>" id="stored_in_<?php echo $sub_mat_id?>_<?php echo $batch['batch_id']?>"  autocomplete="off"/>
                              </td>
                              <td>
                                <?php if($inward_data[0]['quality_status'] == 'check' || $inward_data[0]['payment_status'] == 'paid'){ ?>
                                    <input type="hidden" name="sub_mat_is_deleted[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="0">
                                <?php }else{ 
                                      if($batch['received_qty'] > 0 && $batch['accepted_qty'] == $batch['outward_qty']){ ?>
                                        <input type="hidden" name="sub_mat_is_deleted[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" value="0">
                                <?php }else{ 
                                ?>   
                                    <select name="sub_mat_is_deleted[<?php echo $sub_mat_id?>][<?php echo $batch['batch_id']?>]" class="form-control">
                                          <option value="0">Saved</option>
                                          <option value="1">Delete</option> 
                                    </select>
                              <?php }
                                  }
                               ?>
                              </td>
                               <script type="text/javascript">
                                  $(document).ready(function(){
                                     $('.expire_date').datepicker({
                                              autoclose: true,
                                              format: 'dd-mm-yyyy'
                                     });

                                    /* $('#batch_form #sub_mat_bar_code_<?php //echo $sub_mat_id?>_<?php //echo $batch['batch_id']?>').rules('add', {
                                            required: true
                                     });*/

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
                        
                       } ?>  
                      </tbody>             
</table> 