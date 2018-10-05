<div class="modal-content">
	        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="supplier_name"><?php echo $supplier_details[0]['supp_firm_name']?></h4>
			</div>            
            <div class="modal-body" id="supplier_quotation">
				 <table class="table">
				 	  <tr>
					 	  <th>Quotation Number:</th>
					 	  <th><?php echo $quotation_id;?></th>
					 	  <th>Cradit Days:</th>
					 	  <th><?php echo $cradit_days;?></th>
				 	  </tr>
				 	  <tr>
				 	  	<td>Firm Name:</td>
				 	  	<td><?php echo $supplier_details[0]['supp_firm_name']?></td>
				 	  	<td>Contact Person:</td>
				 	  	<td><?php echo $supplier_details[0]['supp_contact_person']?></td>
				 	  </tr>	
				 	  <tr>
				 	  	 <td>Mobile:</td>
				 	  	 <td><?php echo $supplier_details[0]['supp_mobile']?></td>
				 	  	 <td>Email:</td>
				 	  	 <td><?php echo $supplier_details[0]['supp_email']?></td>
				 	  </tr>
				 	  <tr>
				 	  	 <td>Address:</td>
				 	  	 <td><?php echo $supplier_details[0]['supp_address']." ".$supplier_details[0]['supp_state']." ".$supplier_details[0]['supp_country'];?></td>
				 	  </tr>
                      <?php 
                      	 if(validateAccess('quotation-purchase_approval_status',$access)){ 
                      	 	$disabled = '';
                      	 	if($status == 'approved'){

                      	 	}else{
                      	 		if($approval_status == 'approved'){
                      	 				$disabled = 'disabled="disabled"';
                      	 		}
                      ?>		
				 	  	      <tr>
				 	  	      	    <td>Approval Status:</td>
							 	  	<td>
							 	  		<select <?php echo $disabled;?> class="form-control" style="width: 50%;" onchange="quotation_status(this.value,<?php echo $quotation_id;?>,<?php echo $quotation_request_id;?>,<?php echo $supplier_details[0]['supplier_id'];?>,'Purchase')">
							 	  			<option value="pending">Pending</option>
							 	  			<option value="approved">Approved</option>
							 	  		</select>
							 	  	</td>
							 	  	 <td>Approval By:</td>
							 	  	 <td></td>
					 	  	  </tr> 
				 	  	<?php
				 	  	    }
				 	  	  } 
				 	    ?>

				 	  <?php 
				 	  	if(validateAccess('quotation-accounts_approval_status',$access)){
				 	  		$disabled = '';
				 	  		if($status_account == 'approved'){

				 	  		}else{
				 	  			if($approval_status_account == 'approved'){
                      	 				$disabled = 'disabled="disabled"';
                      	 		}
				 	  ?>		
				 	  			<tr>
				 	  	      	    <td>Approval Status:</td>
							 	  	<td>
							 	  		<select class="form-control" style="width: 50%;" onchange="quotation_status(this.value,<?php echo $quotation_id;?>,<?php echo $quotation_request_id;?>,<?php echo $supplier_details[0]['supplier_id'];?>,'Accounts')">
							 	  			<option value="pending">Pending</option>
							 	  			<option value="approved">Approved</option>
							 	  		</select>
							 	  	</td>
							 	  	 <td>Approval By (Account):</td>
							 	  	 <td></td>
					 	  	    </tr> 
				 	  <?php 
				 	          }
				 	        }
				 	   ?> 	
				 </table>
				 <table class="table table-bordered" style="margin-bottom: 0px;">	
				 	 <thead>
				 	 	<th>Material Code</th>
				 	 	<th>Material Name</th>
				 	 	<th>Quatation Rate</th>
				 	 	<th>Quatation Quantity</th>
				 	 	<th>Quatation Price</th>
				 	 	<th>Expire Date</th>
				 	 	<th>Discount(%)</th>
				 	 	<th>Discount(Amt)</th>
				 	 	<th>CGST(%)</th>
				 	 	<th>CGST(Amt)</th>
				 	 	<th>SGST(%)</th>
				 	 	<th>SGST(Amt)</th>
				 	 	<th>IGST(%)</th>
				 	 	<th>IGST(Amt)</th>
				 	 </thead>
				 	 <tbody>
				 	   <?php if(!empty($quotation_details)){
				 	   		$total_price = 0;
				 	   	?>	
				 	 		<?php foreach($quotation_details as $key => $details){?>
					 	 		<tr>
					 	 			<td><?php echo $details['mat_code'];?></td>
					 	 			<td><?php echo $details['mat_name'];?></td>
					 	 			<td><?php echo $details['quo_rate'];?></td>
					 	 			<td><?php echo $details['quo_qty'];?></td>
					 	 			<td align="right"><?php echo $details['quo_price'];?> (Rs)</td>
					 	 			<td><?php echo date('d-m-Y',strtotime($details['expire_date']));?></td>
					 	 			<td><?php echo $details['discount'];?></td>
					 	 			<td><?php echo $details['discount_per'];?></td>
					 	 			<td><?php echo $details['cgst_per'];?></td>
					 	 			<td><?php echo $details['cgst_amt'];?></td>
					 	 			<td><?php echo $details['sgst_per'];?></td>
					 	 			<td><?php echo $details['sgst_amt'];?></td>
					 	 			<td><?php echo $details['igst_per'];?></td>
					 	 			<td><?php echo $details['igst_amt'];?></td>
					 	 		</tr>
				 	 		<?php
				 	 			 $total_price =  $total_price + $details['quo_price'];
				 	 		}?>
				 	 		<tr>
				 	 		   <td colspan="12"></td>
				 	 		   <th>Total Price:</th>
				 	 		   <td align="right"><?php echo $quotation[0]['total_price'];?> (Rs)</td>
				 	 		</tr>
				 	 		<tr>
				 	 			<td colspan="12"></td>
				 	 			<th>Total CGST</th>
				 	 			<td align="right"><?php echo $quotation[0]['total_cgst'];?> (Rs)</td>
				 	 		</tr>
				 	 		<tr>
				 	 			<td colspan="12"></td>
				 	 			<th>Total SGST</th>
				 	 			<td align="right"><?php echo $quotation[0]['total_sgst'];?> (Rs)</td>
				 	 		</tr>
				 	 		<tr>
				 	 			<td colspan="12"></td>
				 	 			<th>Total IGST</th>
				 	 			<td align="right"><?php echo $quotation[0]['total_igst'];?> (Rs)</td>
				 	 		</tr>
				 	 		<tr>
				 	 			<td colspan="12"></td>
				 	 			<th>Other Amt</th>
				 	 			<td align="right"><?php echo $quotation[0]['other_amt'];?> (Rs)</td>
				 	 		</tr>
				 	 		<tr>
				 	 			<td colspan="12"></td>
				 	 			<th>Total Bill Amt</th>
				 	 			<td align="right"><?php echo $quotation[0]['total_amt'];?> (Rs)</td>
				 	 		</tr>
				 	   <?php }?>	
				 	 </tbody>	
				 </table>           		
            </div>
</div>