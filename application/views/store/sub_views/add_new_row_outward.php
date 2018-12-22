<tr id="batch_row_id_<?php echo $i?>_<?php echo $mat_id?>">
                  <td>
                     
                  </td>
                  <td>
                     <input type="text" class="form-control inputs" name="mat_bar_code[<?php echo $mat_id?>][]" value="" autocomplete="off" onblur="scan_barcode(this.value,<?php echo $mat_id?>,<?php echo $i?>)" id="mat_bar_code_<?php echo $i?>_<?php echo $mat_id?>"/>
                  </td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_batch_no[<?php echo $mat_id?>][]" value="" autocomplete="off" onblur="mat_batch_number(this.value,<?php echo $mat_id?>,<?php echo $i?>)" id="mat_batch_no_<?php echo $i?>_<?php echo $mat_id?>"/>
                  </td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_lot_no[<?php echo $mat_id?>][]" value="" autocomplete="off" onblur="mat_lot_number(this.value,<?php echo $mat_id?>,<?php echo $i?>)" id="mat_lot_no_<?php echo $i?>_<?php echo $mat_id?>"/>
                  </td>
                  <td><input type="text" class="form-control inputs" name="mat_pack_size[<?php echo $mat_id?>][]" value="" autocomplete="off" id="mat_pack_size_<?php echo $i?>_<?php echo $mat_id?>"/></td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_outward_qty[<?php echo $mat_id?>][]" value="0" autocomplete="off" onkeyup="change_stock(this.value,<?php echo $mat_id?>,<?php echo $i?>)" id="mat_outward_qty_<?php echo $i?>_<?php echo $mat_id?>"/>
                  </td>
                  <td><input class="form-control batch_expire_date" type="text" class="form-control inputs" name="mat_expire_date[<?php echo $mat_id?>][]" value="" autocomplete="off" id="mat_expire_date_<?php echo $i?>_<?php echo $mat_id?>"/></td>
                  
                  <td><input type="text" class="form-control inputs" name="mat_remark[<?php echo $mat_id?>][]" value="" autocomplete="off" id="mat_remark_<?php echo $i?>_<?php echo $mat_id?>"/></td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_stock_qty[<?php echo $mat_id?>][]" value="" autocomplete="off" readonly id="mat_stock_qty_<?php echo $i?>_<?php echo $mat_id?>"/>
                      <input type="hidden" name="mat_batch_id[<?php echo $mat_id?>][]" value="" id="mat_batch_id_<?php echo $i?>_<?php echo $mat_id?>"/>
                      <input type="hidden" name="sub_mat_id[<?php echo $mat_id?>][]" value="" id="sub_mat_id_<?php echo $i?>_<?php echo $mat_id?>"/>
                      <input type="hidden" name="mat_inward_id[<?php echo $mat_id?>][]" value="" id="mat_inward_id_<?php echo $i?>_<?php echo $mat_id?>"/>
                      <input type="hidden" name="mat_po_id[<?php echo $mat_id?>][]" value="" id="mat_po_id_<?php echo $i?>_<?php echo $mat_id?>"/>
                      <input type="hidden" name="mat_inward_qty[<?php echo $mat_id?>][]" value="" id="mat_inward_qty_<?php echo $i?>_<?php echo $mat_id?>"/>
                      <input type="hidden" name="my_mat_id[<?php echo $mat_id?>][<?php echo $i?>]" value="<?php echo $mat_id?>_<?php echo $i?>" /> 
                  </td>
                  <td><button id="remove_button_<?php echo $i?>_<?php echo $mat_id?>" type="button" onclick="remove_row_outward(<?php echo $i?>,<?php echo $mat_id?>,'insert')">x</button></td>
</tr>