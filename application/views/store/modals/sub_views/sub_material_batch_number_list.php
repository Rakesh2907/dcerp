<table id="sub_mat_list_<?php echo $sub_mat_id?>" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_mat_list_info">
                      <thead>
                          <!-- <th><img src="<?php //echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode-reader.png" style="margin-right: 5px;">Bar Code <i style="color: red; font-size: 10px;">(NA Not Allowed)</i></th> -->
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
                        <tr id="batch_row_id_1">
                            <!-- <td> -->
                            	<input type="hidden" name="sub_mat_id[<?php echo $sub_mat_id?>][1]" value="<?php echo $sub_mat_id?>" />
                            	<!-- <img src="<?php //echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode.png" style="margin-right: 5px;"><input type="text" class="form-control inputs" name="bar_code[<?php //echo $sub_mat_id?>][1]" value="" id="sub_mat_bar_code_<?php //echo $sub_mat_id?>_1"  autocomplete="off"/> -->
                            <!-- </td> -->
                            <td><input type="text" class="form-control inputs" name="batch_no[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_batch_no_<?php echo $sub_mat_id?>_1"  autocomplete="off"/><button type="button" onclick="create_batch_number_sub_material(<?php echo $sub_mat_id?>,1)">Generate Batch No.</button></td>
                            <td><input type="text" class="form-control inputs" name="lot_no[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_lot_no_<?php echo $sub_mat_id?>_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="batch_received_qty[<?php echo $sub_mat_id?>][1]" value="0" id="sub_mat_received_qty_<?php echo $sub_mat_id?>_1"  autocomplete="off"/></td>
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
                              <input type="text" class="form-control inputs" name="accepted_qty[<?php echo $sub_mat_id?>][1]" value="0" id="sub_mat_accepted_qty_<?php echo $sub_mat_id?>_1"  autocomplete="off" <?php echo $readonly?>/>
                            </td>
                            <td><input class="form-control expire_date" type="text" class="form-control inputs" name="expire_date[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_expire_date_<?php echo $sub_mat_id?>_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="shipping_temp[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_shipping_temp_<?php echo $sub_mat_id?>_1"  autocomplete="off"/></td>
                            <td><input type="text" class="form-control inputs" name="storage_temp[<?php echo $sub_mat_id?>][1]" value="" id="sub_mat_storage_temp_<?php echo $sub_mat_id?>_1"  autocomplete="off"/></td>
                            <td>
                                <input type="text" class="form-control inputs" name="stored_in[<?php echo $sub_mat_id?>][1]" value="" id="stored_in_<?php echo $sub_mat_id?>_1"  autocomplete="off"/>
                            </td>
                            <td>
                              <!-- <button type="button" onclick="add_row(<?php echo $sub_mat_id?>,1)">+</button> -->&nbsp;&nbsp;<button type="button" onclick="remove_sub_mat_row(<?php echo $sub_mat_id?>,<?php echo $mat_id?>,<?php echo $inward_id?>,<?php echo $po_id?>,1,'insert')">x</button></td>
                              <script type="text/javascript">
                                  $(document).ready(function(){
                                       $('.expire_date').datepicker({
                                                autoclose: true,
                                                format: 'dd-mm-yyyy'
                                       });

                                       /*$('#batch_form #sub_mat_bar_code_<?php //echo $sub_mat_id?>_1').rules('add', {
                                            required: true
                                       });*/

                                       $('#batch_form #sub_mat_batch_no_<?php echo $sub_mat_id?>_1').rules('add', {
                                            required: true
                                       });

                                       $('#batch_form #sub_mat_lot_no_<?php echo $sub_mat_id?>_1').rules('add', {
                                            required: true
                                       });

                                       $('#batch_form #sub_mat_received_qty_<?php echo $sub_mat_id?>_1').rules('add', {
                                            number: true,
                                            required: true
                                       });

                                       $('#batch_form #sub_mat_accepted_qty_<?php echo $sub_mat_id?>_1').rules('add', {
                                            number: true,
                                            required: true
                                       });

                                       $('#batch_form #sub_mat_expire_date_<?php echo $sub_mat_id?>_1').rules('add', {
                                            required: true
                                       });
                                  });
                             </script>
                        </tr>
                      </tbody>             
</table> 