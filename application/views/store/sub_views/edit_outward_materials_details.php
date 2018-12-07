<?php if(!empty($outward_materials)){
  $i = 1;
?>
<div class="panel-group" id="accordion">
   <?php foreach($outward_materials as $materials){
      //echo "<pre>"; print_r($materials); echo "</pre>";
      $where = array('outward_id' => $outward_id, 'mat_id' => $materials['mat_id'], 'is_deleted' => '0'); 
      $outward_batch_items = $this->store_model->outward_batch_details($where);
    ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i?>" class="panel-title expand">
          <?php if(empty($outward_batch_items)){?>
             <div class="right-arrow pull-right" onclick="remove_outward_items(<?php echo $materials['mat_id']?>,<?php echo $outward_id?>)">
                   <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-bin.png" style="margin-right: 5px; cursor: pointer;" >  
             </div>
          <?php }?>
          <a href="#"><?php echo $materials['mat_name']?></a>
        </h4>
         <input type="hidden" name="mat_req_quantity[<?php echo $materials['mat_id']?>]" value="<?php echo $materials['quantity']?>" />
      </div>
      <div id="collapse<?php echo $i?>" class="panel-collapse collapse">
        <div class="panel-body">
          <div class="col-md-8">
          </div>  
          <div class="col-md-4">
            <div class="form-group" style="float: right;">
                 <div class="col-sm-5">
                      <label for="mat_qty">Stock Quantity:</label>
                 </div>
                 <div class="col-sm-5">
                   <input type="text" name="mat_stock_quantity[<?php echo $materials['mat_id']?>]" value="<?php echo $materials['current_stock']?>" class="form-control inputs" readonly/>
                 </div> 
            </div>  
          </div>  
           <table id="outward_material_list_<?php echo $materials['mat_id']?>" class="table table-bordered table-striped dataTable" role="grid">
              <thead>
                          <th>Material Code</th>
                          <th><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-barcode-reader.png" style="margin-right: 5px;">Bar Code</th>
                          <th>Batch No.</th>
                          <th>Lot No.</th>
                          <th>Pack Size</th>
                          <th>Require Qty</th>
                          <th>Exprire Date</th>
                          <th>Remark</th>
                          <th>Remaining Qty</th>
                          <th>Action(s)</th>
              </thead>
              <tbody>
                <?php
                  if(!empty($outward_batch_items)){
                     $k = 1;
                    foreach ($outward_batch_items as $key => $batch) {
                      # code...
                ?> 
                      <tr id="batch_row_id_<?php echo $k?>_<?php echo $materials['mat_id']?>">
                          <td>
                             <input type="text" class="form-control inputs" value="<?php echo $materials['mat_code']?>" disabled="" />
                          </td>
                          <td>
                             <input type="text" class="form-control inputs" name="mat_bar_code[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['bar_code']?>" autocomplete="off" onblur="scan_barcode(this.value,<?php echo $materials['mat_id']?>,<?php echo $k?>)" id="mat_bar_code_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                          </td>
                          <td>
                              <input type="text" class="form-control inputs" name="mat_batch_no[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['batch_number']?>" autocomplete="off" onblur="mat_batch_number(this.value,<?php echo $materials['mat_id']?>,<?php echo $k?>)" id="mat_batch_no_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                          </td>
                          <td>
                              <input type="text" class="form-control inputs" name="mat_lot_no[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['lot_number']?>" autocomplete="off" onblur="mat_lot_number(this.value,<?php echo $materials['mat_id']?>,<?php echo $k?>)" id="mat_lot_no_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                          </td>
                          <td><input type="text" class="form-control inputs" name="mat_pack_size[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['pack_size']?>" autocomplete="off" id="mat_pack_size_<?php echo $k?>_<?php echo $materials['mat_id']?>"/></td>
                          <td>
                              <input type="text" class="form-control inputs" name="mat_outward_qty[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['outward_qty']?>" autocomplete="off" onkeyup="change_stock(this.value,<?php echo $materials['mat_id']?>,<?php echo $k?>)" id="mat_outward_qty_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                          </td>
                          <td><input class="form-control batch_expire_date" type="text" class="form-control inputs" name="mat_expire_date[<?php echo $materials['mat_id']?>][]" value="<?php echo date('d-m-Y',strtotime($batch['expire_date']))?>" autocomplete="off" id="mat_expire_date_<?php echo $k?>_<?php echo $materials['mat_id']?>"/></td>
                          
                          <td><input type="text" class="form-control inputs" name="mat_remark[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['remark']?>" autocomplete="off" id="mat_remark_<?php echo $k?>_<?php echo $materials['mat_id']?>"/></td>
                          <td>
                              <input type="text" class="form-control inputs" name="mat_stock_qty[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['stock_qty']?>" autocomplete="off" readonly id="mat_stock_qty_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                              <input type="hidden" name="mat_batch_id[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['batch_id']?>" id="mat_batch_id_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                              <input type="hidden" name="sub_mat_id[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['sub_mat_id']?>" id="sub_mat_id_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                              <input type="hidden" name="mat_inward_id[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['inward_id']?>" id="mat_inward_id_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                              <input type="hidden" name="mat_po_id[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['po_id']?>" id="mat_po_id_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                              <input type="hidden" name="mat_inward_qty[<?php echo $materials['mat_id']?>][]" value="<?php echo $batch['inward_qty']?>" id="mat_inward_qty_<?php echo $k?>_<?php echo $materials['mat_id']?>"/>
                          </td>

                          <td>
                            <select class="form-control" name="mat_is_deleted[<?php echo $materials['mat_id']?>][]">
                              <option value="0" <?php if($batch['is_deleted'] == '0'){ echo 'selected="selected"';}else{ echo '';}?>>Saved</option>
                              <option value="1" <?php if($batch['is_deleted'] == '1'){ echo 'selected="selected"';}else{ echo '';}?>>Delete</option>
                            </select>
                          </td>
                 </tr>
                <?php 
                    $k = $k + 1;   
                    }
                  }
                ?>  
                 
              </tbody>  
           </table> 
           <table class="table">
              <tr>
                <td><button class="pull-right" type="button" onclick="add_row_outward_material('edit',<?php echo $materials['mat_id']?>)">+</button></td>
              </tr>
           </table>
        </div>

      </div>
    </div>
  <?php
     $i = $i + 1; 
  } ?>  
</div>
<script type="text/javascript">
  $(document).ready(function(){
     
 });   
</script>
<?php }?>