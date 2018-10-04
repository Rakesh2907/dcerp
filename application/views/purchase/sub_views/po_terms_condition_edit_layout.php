 <div class="box-header with-border">
                      <h3 class="box-title">Terms & Conditions</h3>
                   </div>
              <div class="box-body">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="total_amt">Delievery Schedule:</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="delievery_schedule_days" id="delievery_schedule_days" value="<?php echo $purchase_order[0]['delievery_schedule_days']?>" <?php echo $disabled?>/> Days
                        </div>
                        <div class="col-sm-5">
                          <select class="form-control select2" id="delievery_schedule" name="delievery_schedule" <?php echo $disabled?>>

                              <?php foreach ($delievery_schedule as $key => $value): ?>
                                  <?php
                                    $selected = ''; 
                                    if($purchase_order[0]['delievery_schedule'] == $value['delievery_schedule']){
                                         $selected = 'selected="selected"'; 
                                    }
                                  ?>
                                  <option value="<?php echo $value['delievery_schedule']?>" <?php echo $selected;?>><?php echo $value['delievery_schedule']?></option>
                              <?php endforeach ?> 
                          </select>
                        </div>
                   </div>
                </div> 
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="transport">Transport:</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                          <select class="form-control select2" id="transport" name="transport" <?php echo $disabled?>>
                              <?php foreach ($transport as $key => $value): ?>
                                  <?php
                                    $selected = ''; 
                                    if($purchase_order[0]['transport'] == $value['transport']){
                                         $selected = 'selected="selected"'; 
                                    }
                                  ?>
                                  <option value="<?php echo $value['transport']?>" <?php echo $selected;?>><?php echo $value['transport']?></option>
                              <?php endforeach ?> 
                          </select>
                        </div>
                   </div>
                </div> 
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="freight_charges">Freight Charges:</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                          <select class="form-control select2" id="freight_charges" name="freight_charges" <?php echo $disabled?>>
                              <?php foreach ($freight_charges as $key => $value): ?>
                                  <?php
                                    $selected = ''; 
                                    if($purchase_order[0]['freight_charges'] == $value['freight_charges']){
                                         $selected = 'selected="selected"'; 
                                    }
                                  ?>
                                  <option value="<?php echo $value['freight_charges']?>" <?php echo $selected;?>><?php echo $value['freight_charges']?></option>
                              <?php endforeach ?> 
                          </select>
                        </div>
                   </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="payment_terms">Payments Terms:</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                          <select class="form-control select2" id="payment_terms" name="payment_terms" <?php echo $disabled?>>
                              <?php foreach ($payment_terms as $key => $value): ?>
                                  <?php
                                    $selected = ''; 
                                    if($purchase_order[0]['payment_terms'] == $value['payment_terms']){
                                         $selected = 'selected="selected"'; 
                                    }
                                  ?>
                                  <option value="<?php echo $value['payment_terms']?>" <?php echo $selected;?>><?php echo $value['payment_terms']?></option>
                              <?php endforeach ?> 
                          </select>
                        </div>
                   </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="test_certificate">Routine Test certificate:</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                          <select class="form-control select2" id="test_certificate" name="test_certificate" <?php echo $disabled?>>
                              <option value="MUST BE ON THE NAME OF Datar Cancer Genetics Limited">MUST BE ON THE NAME OF Datar Cancer Genetics Limited</option> 
                          </select>
                        </div>
                   </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="custom_duty">Custom Duty</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                          <select class="form-control select2" id="custom_duty" name="custom_duty" <?php echo $disabled?>>
                              <?php foreach ($custom_duty as $key => $value): ?>
                                  <?php
                                    $selected = ''; 
                                    if($purchase_order[0]['custom_duty'] == $value['custom_duty']){
                                         $selected = 'selected="selected"'; 
                                    }
                                  ?>
                                  <option value="<?php echo $value['custom_duty']?>" <?php echo $selected;?>><?php echo $value['custom_duty']?></option>
                              <?php endforeach ?> 
                          </select>
                        </div>
                   </div>
                </div> 
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="approval_flag">Approval</label>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control select2" id="approval_flag" name="approval_flag" <?php echo $disabled?>>
                              <option value="pending" <?php if($purchase_order[0]['approval_flag'] =='pending'){ echo "selected='selected'";}else{ echo "";}?>>Pending</option>
                              <option value="approved" <?php if($purchase_order[0]['approval_flag'] =='approved'){ echo "selected='selected'";}else{ echo "";}?>>Approved</option>
                           </select> 
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control select2" id="approval_by" name="approval_by" <?php echo $disabled?>>
                              <?php 
                                if(!empty($po_approval_assign_by)){
                                  foreach ($po_approval_assign_by as $key => $users) {
                              ?>
                                       <option value="<?php echo $users['id']?>"><?php echo $users['name']?></option>
                              <?php     
                                  }
                              } ?>
                             
                           </select>
                        </div>
                   </div>
                </div> 
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="notes">Notes</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                            <textarea name="notes" id="notes" class="form-control" <?php echo $disabled?>><?php echo $purchase_order[0]['notes']?></textarea>
                        </div>
                   </div>
                </div>
                 <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="notes">Remark</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                            <textarea name="remarks" id="remarks" class="form-control" <?php echo $disabled?>><?php echo $purchase_order[0]['remarks']?></textarea>
                        </div>
                   </div>
                </div>
             </div> 