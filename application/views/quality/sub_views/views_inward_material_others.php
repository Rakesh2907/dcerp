<div class="box-header with-border">
          <h3 class="box-title">Others</h3>
</div>
<div class="box-body">
                <div class="row" style="margin-bottom: 5px;">     
                   <div class="form-group">  
                       <div class="col-sm-5">
                          <label for="remark">QC Checked:</label>
                       </div>
                       <div class="col-sm-7">
                           <?php if($inward_material[0]['quality_status'] == 'check'){
                                          $style = 'margin-top: 7px;margin-left: 4px;color: white;';
                                          $checked = "checked";
                          }else{
                                          $style = 'margin-top: 7px;margin-left: 34px;color: white;';
                                          $checked = '';
                          } ?>

                           <label id="quality_status_switch" class="switch" rel="tooltip" title="Bofore 'Yes' Set Accepted Qty for Materials. After that click 'Save' button.">
                                          <input type="checkbox" <?php echo $checked;?> id="quality_status" name="quality_status">
                                          <span class="slider round" onclick="qc_change_status()">
                                             <div id="qc_verified_status" style="<?php echo $style?>"><?php if($inward_material[0]['quality_status'] == 'check'){echo 'Yes';}else{echo 'No';} ?></div>
                                          </span>
                           </label> 
                       </div> 
                   </div>
                 </div>  
</div>