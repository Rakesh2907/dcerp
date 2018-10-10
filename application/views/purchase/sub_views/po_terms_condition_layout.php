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
                            <input type="text" class="form-control" name="delievery_schedule_days" id="delievery_schedule_days" value="0" /> Days
                        </div>
                        <div class="col-sm-5">
                          <select class="form-control" id="delievery_schedule" name="delievery_schedule">

                              <?php foreach ($delievery_schedule as $key => $value): ?>
                                  <option value="<?php echo $value['delievery_schedule']?>"><?php echo $value['delievery_schedule']?></option>
                              <?php endforeach ?>  
                          </select>
                          
                            <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-default" style="float: right;" onclick="terms_condition_prompt('erp_delievery_schedule','Delievery Schedule','delievery_schedule')">+</button>
                          
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
                          <select class="form-control" id="transport" name="transport">
                              <?php foreach ($transport as $key => $value): ?>
                                  <option value="<?php echo $value['transport']?>"><?php echo $value['transport']?></option>
                              <?php endforeach ?> 
                          </select>
                          <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-default" style="float: right;" onclick="terms_condition_prompt('erp_transport','Transport','transport')">+</button>
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
                          <select class="form-control" id="freight_charges" name="freight_charges">
                              <?php foreach ($freight_charges as $key => $value): ?>
                                  <option value="<?php echo $value['freight_charges']?>"><?php echo $value['freight_charges']?></option>
                              <?php endforeach ?> 
                          </select>
                          <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-default" style="float: right;" onclick="terms_condition_prompt('erp_freight_charges','Freight Charges','freight_charges')">+</button>
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
                          <select class="form-control" id="payment_terms" name="payment_terms">
                              <?php foreach ($payment_terms as $key => $value): ?>
                                  <option value="<?php echo $value['payment_terms']?>"><?php echo $value['payment_terms']?></option>
                              <?php endforeach ?> 
                          </select>
                          <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-default" style="float: right;" onclick="terms_condition_prompt('erp_payment_terms','Payments Terms','payment_terms')">+</button>
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
                          <select class="form-control" id="test_certificate" name="test_certificate">
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
                          <select class="form-control" id="custom_duty" name="custom_duty">
                              <?php foreach ($custom_duty as $key => $value): ?>
                                  <option value="<?php echo $value['custom_duty']?>"><?php echo $value['custom_duty']?></option>
                              <?php endforeach ?> 
                          </select>
                          <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-default" style="float: right;" onclick="terms_condition_prompt('erp_custom_duty','Custom Duty','custom_duty')">+</button>
                        </div>
                   </div>
                </div> 
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="approval_flag">Approval:</label>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control select2" id="approval_flag" name="approval_flag">
                              <option value="pending">Pending</option>
                              <option value="approved">Approved</option>
                           </select> 
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control select2" id="approval_by" name="approval_by">
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
                            <label for="notes">Notes:</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                            <textarea name="notes" id="notes" class="form-control"></textarea>
                        </div>
                   </div>
                </div>
                 <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="notes">Remark:</label>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="col-sm-5">
                            <textarea name="remarks" id="remarks" class="form-control"></textarea>
                        </div>
                   </div>
                </div>
             </div> 