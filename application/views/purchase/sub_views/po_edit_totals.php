<div class="box-header with-border">
                      <h3 class="box-title">Totals</h3>
              </div>
              <div class="box-body">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group">  
                        <div class="col-sm-5">
                            <label for="total_amt">Total Amount:</label>
                        </div>
                        <div class="col-sm-2">
                          <select class="form-control select2" name="currency" id="currency" <?php echo $disabled?>>
                            <option value="RS" <?php if($purchase_order[0]['currency'] == 'RS'){ echo 'selected="selected"';}else{ echo '';}?>>RS</option>
                            <option value="USD" <?php if($purchase_order[0]['currency'] == 'USD'){ echo 'selected="selected"';}else{ echo '';}?>>USD</option>
                          </select>
                        </div>
                        <div class="col-sm-5">
                          <input class="form-control" id="total_amt" name="total_amt" placeholder="0" type="text" value="<?php echo $purchase_order[0]['total_amt'];?>" readonly>
                        </div>
                   </div>
                </div> 
                <div class="row" style="margin-bottom: 5px;">   
                   <div class="form-group">  
                      <div class="col-sm-5">
                            <label for="total_cgst">Total CGST:</label>
                       </div>
                       <div class="col-sm-2">
                       </div> 
                       <div class="col-sm-5">
                        <input class="form-control" id="total_cgst" name="total_cgst" placeholder="0" type="text" value="<?php echo $purchase_order[0]['total_cgst'];?>" readonly>
                       </div> 
                   </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">     
                   <div class="form-group">  
                      <div class="col-sm-5">
                            <label for="total_sgst">Total SGST:</label>
                       </div>
                       <div class="col-sm-2">
                       </div> 
                       <div class="col-sm-5">
                        <input class="form-control" id="total_sgst" name="total_sgst" placeholder="0" type="text" value="<?php echo $purchase_order[0]['total_sgst'];?>" readonly>
                       </div> 
                   </div>
                 </div> 
                 <div class="row" style="margin-bottom: 5px;">     
                   <div class="form-group">  
                      <div class="col-sm-5">
                            <label for="total_igst">Total IGST:</label>
                       </div>
                       <div class="col-sm-2">
                       </div> 
                       <div class="col-sm-5">
                        <input class="form-control" id="total_igst" name="total_igst" placeholder="0" type="text" value="<?php echo $purchase_order[0]['total_igst'];?>" readonly>
                       </div> 
                   </div>
                 </div> 
                 <div class="row" style="margin-bottom: 5px;">     
                   <div class="form-group">  
                      <div class="col-sm-5">
                            <label for="freight_amt">Frieght:</label>
                       </div>
                       <div class="col-sm-2">
                       </div> 
                       <div class="col-sm-5">
                        <input class="form-control" id="freight_amt" name="freight_amt" placeholder="0" type="text" value="<?php echo $purchase_order[0]['freight_amt'];?>" onkeyup="freight_amount(this.value);" <?php echo $disabled?>>
                       </div> 
                   </div>
                 </div>
                 <div class="row" style="margin-bottom: 5px;">     
                   <div class="form-group">  
                      <div class="col-sm-5">
                            <label for="other_amt">Other Charge:</label>
                       </div>
                       <div class="col-sm-2">
                       </div> 
                       <div class="col-sm-5">
                              <input class="form-control" id="other_amt" name="other_amt" placeholder="0" type="text" value="<?php echo $purchase_order[0]['other_amt'];?>" onkeyup="other_charges(this.value);" <?php echo $disabled?>>
                       </div> 
                   </div>
                 </div>
                 <div class="row" style="margin-bottom: 5px;">     
                   <div class="form-group">  
                      <div class="col-sm-5">
                            <label for="total_bill_amt">Total Bill Amount:</label>
                       </div>
                       <div class="col-sm-2">
                       </div> 
                       <div class="col-sm-5">
                        <input class="form-control" id="total_bill_amt" name="total_bill_amt" placeholder="0" type="text" value="<?php echo $purchase_order[0]['total_bill_amt'];?>" readonly>
                       </div> 
                   </div>
                 </div>
                 <div class="row" style="margin-bottom: 5px;">     
                   <div class="form-group">  
                      <div class="col-sm-5">
                            <label for="rounded_amt">Rounded Off Say:</label>
                       </div>
                       <div class="col-sm-2">
                       </div> 
                       <div class="col-sm-5">
                        <input class="form-control" id="rounded_amt" name="rounded_amt" placeholder="0" type="text" value="<?php echo $purchase_order[0]['rounded_amt'];?>" <?php echo $disabled?>>
                       </div> 
                   </div>
                 </div>
              </div>