<form id="pop_up_add_payments_plan" action="purchase/save_billing_date_installment">
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
                                <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                                  <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                            <input type="text" name="quant[2]" class="form-control input-number" value="<?php echo count($payments_plan)?>" min="1" max="100" readonly="">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
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
                                        <input type="text" class="form-control bill_date_will_be" id="bill_due_date" name="bill_due_date[<?php echo $i?>]" placeholder="Set Billing Date" name="bill_date_will_be" value="<?php echo date('d-m-Y',strtotime($value['due_date']))?>" required autocomplete="off">
                                    </td>
                                    <td>
                                       <input type="text" class="form-control" name="amount[<?php echo $i?>]" value="<?php echo $value['installment_amout']?>" onkeyup="set_balance_amount(this.value,1)">
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
                <div class="row">   
                   <input type="hidden" id="pop_up_inward_id" name="pop_up_inward_id" value="<?php echo $inward_id?>" />
                   <input type="hidden" name="pop_up_vendor_id" value="<?php echo $inwards[0]['vendor_id']?>" />
                   <input type="hidden" name="total_bill_amount" id="total_bill_amount" value="<?php echo $inwards[0]['total_bill_amt']?>"/>
                   <input type="hidden" name="submit_type" value="edit" />
                     <div class="col-sm-12">  
                      <button type="submit" class="btn btn-primary pull-right" id="">Save</button>
                     </div>     
                  </div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
   
    $('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());

    var html = '';
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();

                 html+='<tr id="count_'+(currentVal - 1)+'"><td>#'+(currentVal - 1)+'</td><td><input type="text" class="form-control bill_date_will_be" id="bill_due_date" name="bill_due_date['+(currentVal - 1)+']" placeholder="Set Billing Date" name="bill_date_will_be" required autocomplete="off"></td><td><input type="text" class="form-control" name="percentage['+(currentVal - 1)+']" value="0"></td><td><input type="text" class="form-control" name="amount['+(currentVal - 1)+']"></td></tr>';

                 $('#installment_table #count_'+currentVal).remove();  
                 total_installment_amout(currentVal - 1);
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {
            if(currentVal < input.attr('max')) {
               if($("#total_installment_amount").val() == $("#total_bill_amount").val()){
                   swal({
                      title: "",
                      text: 'Total Installment Amt and Bill Amount Matched.',
                      type: "error"
                    });
               }else{ 
                    input.val(currentVal + 1).change(); 
                    $.ajax({
                       type: "POST",
                       url: baseURL+'purchase/add_new_row_bill',
                       headers: { 'Authorization': user_token },
                       cache: false,
                       data: JSON.stringify({row_id:(currentVal + 1)}),
                       beforeSend: function () {
                        
                       },
                       success: function(result){
                          $('#installment_table').append(result);
                       }
                    }); 
               }   
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
  $('.input-number').focusin(function(){
     $(this).data('oldValue', $(this).val());
  });
  $('.input-number').change(function() {
      
      minValue =  parseInt($(this).attr('min'));
      maxValue =  parseInt($(this).attr('max'));
      valueCurrent = parseInt($(this).val());
      
      name = $(this).attr('name');
      if(valueCurrent >= minValue) {
          $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
      } else {
          alert('Sorry, the minimum value was reached');
          $(this).val($(this).data('oldValue'));
      }
      if(valueCurrent <= maxValue) {
          $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
      } else {
          alert('Sorry, the maximum value was reached');
          $(this).val($(this).data('oldValue'));
      }
      
      
  });
  $(".input-number").keydown(function (e) {
          // Allow: backspace, delete, tab, escape, enter and .
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
               // Allow: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) || 
               // Allow: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
                   // let it happen, don't do anything
                   return;
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      });

      $('.bill_date_will_be').datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    startDate:new Date()
      });

      $("#pop_up_add_payments_plan").on('submit',function(e){
        e.preventDefault();
      }).validate({
        submitHandler: function(form) {
          var form_data = new FormData(form);
            var page_url = $(form).attr('action');
            $.ajax({
              url: baseURL +""+page_url,
              headers: { 'Authorization': user_token },
                method: "POST",
                data: form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend: function () {

                },
                success: function(result, status, xhr) {
                  var res = JSON.parse(result);
               if(res.status == 'success'){
                 swal({
                                  title: "",
                                  text: res.message,
                                  type: "success",
                                  timer:2000,
                    showConfirmButton: false
                            },function(){
                              swal.close(); 
                              $("#payment_plan").modal('hide');     
                            });
               }
                }
            });
        }
    });

    $('[name^="bill_due_date"]').each(function() {
            $(this).rules('add', {
                required: true,
            })
    });

    $('[name^="amount"]').each(function() {
            $(this).rules('add', {
                required: true,
                number: true,
            })
    });

  });

function total_installment_amout(row_id){
  var total_installment_amout = 0;
  $('[name^="rows"]').each(function() {
          var row_id = $(this).val();
          var installment_amount = $("input[name='amount["+row_id+"]']").val();
          total_installment_amout = total_installment_amout + parseFloat(installment_amount);
    });
  $("#total_installment_amount").val(parseFloat(total_installment_amout).toFixed(2));
}

function set_balance_amount(installment_amount,row_id){
  var total_bill_amount = $("#total_bill_amount").val();

  if(total_bill_amount >= installment_amount){
    if(row_id == '1'){
      var balance_amount = (total_bill_amount - installment_amount);
      }else{
        var previous_bal_amout =  $("input[name='balance_amount["+(row_id-1)+"]']").val();
        if(previous_bal_amout >= installment_amount){
          var balance_amount = (previous_bal_amout - installment_amount);
        }else{
          $("input[name='amount["+row_id+"]']").val(0);
        $("input[name='balance_amount["+row_id+"]']").val(0); 
          swal({
          title: "",
          text: 'Installment amout less then total amount',
          type: "error",
        });
        } 
      }   
    $("input[name='balance_amount["+row_id+"]']").val(parseFloat(balance_amount).toFixed(2));
    total_installment_amout(row_id);
  }else{
    if(row_id == '1'){
        $("input[name='amount["+row_id+"]']").val(0);
      $("input[name='balance_amount["+row_id+"]']").val(0);
    }
    swal({
      title: "",
      text: 'Installment amout less then total amount',
      type: "error",
    });
  }
}
</script>