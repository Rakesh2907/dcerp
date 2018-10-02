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
                              <option value="01-01-2018 to 31-12-2018">01-01-2018 to 31-12-2018</option>
                              <option value="IMMIDIATE">IMMIDIATE</option>
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
                          <select class="form-control" id="transport" name="transport">
                              <option value="As Require">As Require</option>
                              <option value="By Courier">By Courier</option>
                              <option value="By Courier DDP Mode">By Courier DDP Mode</option>
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
                          <select class="form-control" id="freight_charges" name="freight_charges">
                              <option value="At Actual">At Actual</option>
                              <option value="Extra as applicable">Extra as applicable</option>
                              <option value="NIL">NIL</option>
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
                          <select class="form-control" id="payment_terms" name="payment_terms">
                              <option value="50% Advance & 50% after completion work">50% Advance </option>
                              <option value="100% Advance">100% Advance</option>
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
                              <option value="Extra as applicable">Extra as applicable</option>
                              <option value="NIL">NIL</option>
                              <option value="NA">NA</option>
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
                            <select class="form-control" id="approval_flag" name="approval_flag">
                              <option value="pending">Pending</option>
                              <option value="approved">Approved</option>
                           </select> 
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" id="approval_by" name="approval_by">
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
                            <textarea name="notes" id="notes" class="form-control"></textarea>
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
                            <textarea name="remarks" id="remarks" class="form-control"></textarea>
                        </div>
                   </div>
                </div>
             </div> 