<?php if(!empty($selected_materials)){
  $i = 1;
?>
<div class="panel-group" id="accordion">
   <?php foreach($selected_materials as $materials){
      //echo "<pre>"; print_r($materials); echo "</pre>";
    ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i?>" class="panel-title expand">
           <div class="right-arrow pull-right"></div>
          <a href="#"><?php echo $materials['mat_name']?></a>
        </h4>
         <input type="hidden" name="mat_req_quantity[<?php echo $materials['mat_id']?>]" value="<?php echo $materials['require_qty']?>" />
      </div>
      <div id="collapse<?php echo $i?>" class="panel-collapse collapse">
        <div class="panel-body">
          <div class="col-md-8">
             <div class="form-group" style="float: right;">
                 <div class="col-sm-5">
                      <label for="mat_qty">Pending Quantity (Requisition):</label>
                 </div>
                 <div class="col-sm-5">
                   <input type="text" name="req_pending_quantity[<?php echo $materials['mat_id']?>]" value="<?php echo ($materials['require_qty']-$materials['received_qty'])?>" class="form-control inputs" readonly/>
                 </div> 
            </div>
          </div>  
          <div class="col-md-4">
            <div class="form-group" style="float: right;">
                 <div class="col-sm-5">
                      <label for="mat_qty">Stock Quantity (Store):</label>
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
                          <th>Serial No.</th>
                          <th>Pack Size</th>
                          <th>Qty</th>
                          <th>Exprire Date</th>
                          <th>Remark</th>
                          <th>Available Stock Qty (Store)</th>
                          <th>Action(s)</th>
              </thead>
              <tbody>
                 <tr id="batch_row_id_1_<?php echo $materials['mat_id']?>">
                  <td>
                     <input type="text" class="form-control inputs" value="<?php echo $materials['mat_code']?>" disabled="" />
                  </td>
                  <td>
                     <input type="text" class="form-control inputs" name="mat_bar_code[<?php echo $materials['mat_id']?>][]" value="" autocomplete="off" onblur="scan_barcode(this.value,<?php echo $materials['mat_id']?>,1)" id="mat_bar_code_1_<?php echo $materials['mat_id']?>"/>
                  </td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_batch_no[<?php echo $materials['mat_id']?>][]" value="" autocomplete="off" onblur="mat_batch_number(this.value,<?php echo $materials['mat_id']?>,1)" id="mat_batch_no_1_<?php echo $materials['mat_id']?>"/>
                  </td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_lot_no[<?php echo $materials['mat_id']?>][]" value="" autocomplete="off" onblur="mat_lot_number(this.value,<?php echo $materials['mat_id']?>,1)" id="mat_lot_no_1_<?php echo $materials['mat_id']?>"/>
                  </td>
                  <td><input type="text" class="form-control inputs" name="mat_pack_size[<?php echo $materials['mat_id']?>][]" value="" autocomplete="off" id="mat_pack_size_1_<?php echo $materials['mat_id']?>"/></td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_outward_qty[<?php echo $materials['mat_id']?>][]" value="0" autocomplete="off" onkeyup="change_stock(this.value,<?php echo $materials['mat_id']?>,1)" id="mat_outward_qty_1_<?php echo $materials['mat_id']?>"/>
                  </td>
                  <td><input class="form-control batch_expire_date" type="text" class="form-control inputs" name="mat_expire_date[<?php echo $materials['mat_id']?>][]" value="" autocomplete="off" id="mat_expire_date_1_<?php echo $materials['mat_id']?>"/></td>
                  
                  <td><input type="text" class="form-control inputs" name="mat_remark[<?php echo $materials['mat_id']?>][]" value="" autocomplete="off" id="mat_remark_1_<?php echo $materials['mat_id']?>"/></td>
                  <td>
                      <input type="text" class="form-control inputs" name="mat_stock_qty[<?php echo $materials['mat_id']?>][]" value="" autocomplete="off" readonly id="mat_stock_qty_1_<?php echo $materials['mat_id']?>"/>
                      <input type="hidden" name="mat_batch_id[<?php echo $materials['mat_id']?>][]" value="" id="mat_batch_id_1_<?php echo $materials['mat_id']?>"/>
                      <input type="hidden" name="sub_mat_id[<?php echo $materials['mat_id']?>][]" value="" id="sub_mat_id_1_<?php echo $materials['mat_id']?>"/>
                      <input type="hidden" name="mat_inward_id[<?php echo $materials['mat_id']?>][]" value="" id="mat_inward_id_1_<?php echo $materials['mat_id']?>"/>
                      <input type="hidden" name="mat_po_id[<?php echo $materials['mat_id']?>][]" value="" id="mat_po_id_1_<?php echo $materials['mat_id']?>"/>
                      <input type="hidden" name="mat_inward_qty[<?php echo $materials['mat_id']?>][]" value="" id="mat_inward_qty_1_<?php echo $materials['mat_id']?>"/>
                      <input type="hidden" name="my_mat_id[<?php echo $materials['mat_id']?>][1]" value="<?php echo $materials['mat_id']?>_1" /> 
                  </td>

                  <td></td>
                 </tr>
              </tbody>  
           </table> 
           <table class="table">
              <tr>
                <td><button class="pull-right" type="button" onclick="add_row_outward_material('insert',<?php echo $materials['mat_id']?>)">+</button></td>
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