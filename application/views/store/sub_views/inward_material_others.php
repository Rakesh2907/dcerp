<div class="box-header with-border">
          <h3 class="box-title">Others</h3>
</div>
<div class="box-body">
              <?php 
                if($inward_material[0]['inward_form'] == 'general_inward_form'){?>
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
               <?php } ?>  
                <div class="row" style="margin-bottom: 5px;">     
                   <div class="form-group">  
                       <div class="col-sm-5">
                          <label for="remark">Remark/notes:</label>
                       </div>
                       <div class="col-sm-7">
                            <textarea rows="4" cols="50" name="remark" class="form-control"><?php if(isset($inward_material[0]['remark'])){ echo $inward_material[0]['remark'];}else{ echo '';}?></textarea>
                       </div> 
                   </div>
                 </div> 
                 <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="invoice_file">Upload Invoice:</label>
                            <i>File Format : PDF,JPEG,PNG</i>
                        </div>
                        <div class="col-sm-7">
                          <input class="form-control" id="invoice_file" name="invoice_file" type="file" readonly>
                          <input type="hidden" name="inward_bill_file" id="inward_bill_file" value="<?php if(isset($inward_material[0]['invoice_file'])){ echo $inward_material[0]['invoice_file'];}else{echo '';}?>" />
                        </div>
                    </div>
                </div> 
                <div class="row" style="margin-bottom: 5px;">   
                   <div class="form-group">  
                       <div class="col-sm-12">
                          <?php   
                               if(!empty($inward_material[0]['invoice_file']))
                               { 
                                   $ext = pathinfo(basename($inward_material[0]['invoice_file']), PATHINFO_EXTENSION);
                                   if($ext == 'pdf'){
                                    $icon_path = $this->config->item("cdn_css_image").'/dist/img/adobe-pdf-icon.png';
                                   }else if($ext == 'png'){
                                    $icon_path = $this->config->item("cdn_css_image").'/dist/img/png-icon.png';
                                   }else{
                                    $icon_path = $this->config->item("cdn_css_image").'/dist/img/jpeg-icon.png';
                                   }    
                                ?>  
                                  <a href="<?php echo $inward_material[0]['invoice_file']?>" target="_blank"><img src="<?php echo $icon_path;?>" width="100"/></a>
                          <?php } ?>  
                       </div> 
                   </div>
                </div>
</div>