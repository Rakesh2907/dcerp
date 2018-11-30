<tr id="batch_row_id_<?php echo $i?>_<?php echo $mat_id?>">
                  <td>
                     
                  </td>
                  <td>
                     <input type="text" class="form-control inputs" name="mat_bar_code[<?php echo $i?>][<?php echo $mat_id?>]" value="" autocomplete="off" onblur="scan_barcode(this.value,<?php echo $mat_id?>,<?php echo $i?>)"/>
                  </td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_batch_no[<?php echo $i?>][<?php echo $mat_id?>]" value="" autocomplete="off" onblur="mat_batch_number(this.value,<?php echo $mat_id?>,<?php echo $i?>)"/>
                  </td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_lot_no[<?php echo $i?>][<?php echo $mat_id?>]" value="" autocomplete="off" onblur="mat_lot_number(this.value,<?php echo $mat_id?>,<?php echo $i?>)"/>
                  </td>
                  <td><input type="text" class="form-control inputs" name="mat_pack_size[<?php echo $i?>][<?php echo $mat_id?>]" value="" autocomplete="off"/></td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_outward_qty[<?php echo $i?>][<?php echo $mat_id?>]" value="0" autocomplete="off" onkeyup="change_stock(this.value,<?php echo $mat_id?>,<?php echo $i?>)"/>
                  </td>
                  <td><input class="form-control batch_expire_date" type="text" class="form-control inputs" name="mat_expire_date[<?php echo $i?>][<?php echo $mat_id?>]" value="" autocomplete="off"/></td>
                  
                  <td><input type="text" class="form-control inputs" name="mat_remark[<?php echo $i?>][<?php echo $mat_id?>]" value="" autocomplete="off"/></td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_stock_qty[<?php echo $i?>][<?php echo $mat_id?>]" value="" autocomplete="off" readonly/>
                      <input type="hidden" name="mat_batch_id[<?php echo $i?>][<?php echo $mat_id?>]" value=""/>
                      <input type="hidden" name="sub_mat_id[<?php echo $i?>][<?php echo $mat_id?>]" value=""/>
                      <input type="hidden" name="mat_inward_id[<?php echo $i?>][<?php echo $mat_id?>]" value=""/>
                      <input type="hidden" name="mat_po_id[<?php echo $i?>][<?php echo $mat_id?>]" value=""/>
                      <input type="hidden" name="mat_inward_qty[<?php echo $i?>][<?php echo $mat_id?>]" value=""/>
                  </td>
                  <td><button type="button" onclick="remove_row_outward(<?php echo $i?>,<?php echo $mat_id?>,'insert')">x</button></td>
</tr>