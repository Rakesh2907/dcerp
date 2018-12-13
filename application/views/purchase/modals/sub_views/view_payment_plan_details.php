<div class="modal-body">
                <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                              <label for="invoice_number">INVOICE:</label>
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <span id="invoice_number"><?php echo $inwards[0]['invoice_number']?></span>-<span id="invoice_amount">(Rs)<?php echo $inwards[0]['total_bill_amt']?></span>
                  </div>  
                </div>
                <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                              <label for="installment_count">Installment Count:</label>
                      </div>
                  </div>  
                  <div class="col-sm-6">
                      <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]" disabled="disabled">
                                  <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                            <input type="text" name="quant[2]" class="form-control input-number" value="<?php echo count($payments_plan)?>" min="1" max="100" readonly="">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]" disabled="disabled">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                      </div>
                  </div>  
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered" id="installment_table">
                          <tr> 
                            <th>Installments</th>
                            <th>Date</th>
                            <th>Installment Amount(RS)</th>
                            <th>Balance Amount(RS)</th>
                          </tr>
                          <?php 
                            if(!empty($payments_plan)){
                              $i = 1;
                              $total_installment_amount = 0;
                              foreach ($payments_plan as $key => $value) {
                                //echo "<pre>"; print_r($value); echo "</pre>";
                          ?>
                                  <tr id="count_<?php echo $i?>">
                                    <td>
                                      #<?php echo $i?>
                                        <input type="hidden" name="rows[<?php echo $i?>]" value="<?php echo $i?>" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control bill_date_will_be" id="bill_due_date" name="bill_due_date[<?php echo $i?>]" placeholder="Set Billing Date" name="bill_date_will_be" value="<?php echo date('d-m-Y',strtotime($value['due_date']))?>" required autocomplete="off" readonly>
                                    </td>
                                    <td>
                                       <input type="text" class="form-control" name="amount[<?php echo $i?>]" value="<?php echo $value['installment_amout']?>" onkeyup="set_balance_amount(this.value,1)" readonly>
                                    </td>
                                    <td>
                                      <input type="text" class="form-control" name="balance_amount[<?php echo $i?>]" value="<?php echo $value['balance_amount']?>" readonly>
                                    </td>
                                  </tr>
                          <?php
                              $total_installment_amount = $total_installment_amount + $value['installment_amout'];
                             $i++; 
                              }
                          } ?> 
                        </table> 
                        <table class="table table-bordered">
                          <tr>
                            <td style="width: 27.8%">Total:</td>
                            <td style="width: 18%"><input type="text" class="form-control" name="total_installment_amount" id="total_installment_amount" value="<?php echo $total_installment_amount;?>" readonly></td>
                            <td style="width: 18%">&nbsp;</td>
                          </tr>
                        </table>   
</div>
                </div>   
            </div>