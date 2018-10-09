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
				 	  	 <td></td>
				 	  	 <td>
				 	  	 	<?php if($quotation[0]['status_purchase']=='approved' && $quotation[0]['status_account']=='approved'){?>
				 	  	 		  <?php if(validateAccess('quotation-prepare_purchase_order_button',$access)){?> 
				 	  	 			<button class="btn btn-primary" onclick="prepare_purchase_order(<?php echo $quotation[0]['quotation_id']?>, <?php echo $quotation[0]['supplier_id']?>, <?php echo $quotation_request[0]['dep_id']?>,'material_po')">Prepare PO</button>
				 	  	 		  <?php } ?> 	
				 	  	 	<?php } ?>	
				 	  	 </td>
				 	  </tr>
                      <?php 
                      	 	if($quotation_request[0]['approval_quotation_id_purchase'] == $quotation_id && $quotation_request[0]['approval_quotation_id_account'] == $quotation_id){ ?>
                      	 		<tr>
				 	  	      	    <td>Approval Status (Purchase):</td>
							 	  	<td>
							 	  		<select class="form-control" style="width: 50%;" disabled="disabled">
							 	  			<option value="pending">Pending</option>
							 	  			<option value="approved" selected="selected">Approved</option>
							 	  		</select>
							 	  	</td>
							 	  	 <td>Approval By (Purchase):</td>
							 	  	 <td><?php echo $user_name;?></td>
					 	  	   </tr>
                     <?php 	 		
                      	 	}else if($quotation_request[0]['approval_quotation_id_purchase'] == $quotation_request[0]['approval_quotation_id_account']){

                      	 	}else{

                      	 	 if(validateAccess('quotation-purchase_approval_status',$access)){ 	 		
                      ?>	
				 	  	      <tr>
				 	  	      	    <td>Approval Status (Purchase):</td>
							 	  	<td>
							 	  		<select class="form-control" style="width: 50%;" onchange="quotation_status(this.value,<?php echo $quotation_id;?>,<?php echo $quotation_request_id;?>,'Purchase')">
							 	  			<option value="pending" <?php if($quotation[0]['status_purchase']=='pending'){echo 'selected="selected"';}else{echo '';}?>>Pending</option>
							 	  			<option value="approved" <?php if($quotation[0]['status_purchase']=='approved'){echo 'selected="selected"';}else{echo '';}?>>Approved</option>
							 	  		</select>
							 	  	</td>
							 	  	 <td>Approval By (Purchase):</td>
							 	  	 <td><?php echo $user_name;?></td>
					 	  	   </tr>
					 	  	   <tr>
					 	  	   		<td>Approval Status (Accounts):</td>
					 	  	   		<td><?php echo ucfirst($quotation[0]['status_account']);?></td>
					 	  	   		<td>Approval By (Accounts)</td>
					 	  	   		<td><?php echo $user_name_account;?></td>
					 	  	   </tr>	

				 	  	<?php
				 	  	   }
				 	  	  } 
				 	    ?>

				 	  <?php 
				 	  		if($quotation_request[0]['approval_quotation_id_purchase'] == $quotation_id && $quotation_request[0]['approval_quotation_id_account'] == $quotation_id){ ?>
							 	  		<tr>
							 	  	      	    <td>Approval Status (Account):</td>
										 	  	<td>
										 	  		<select class="form-control" style="width: 50%;" disabled="disabled">
										 	  			<option value="pending">Pending</option>
										 	  			<option value="approved" selected="selected">Approved</option>
										 	  		</select>
										 	  	</td>
										 	  	 <td>Approval By (Account):</td>
										 	  	 <td><?php echo $user_name_account;?></td>
								 	  	</tr>	
				 	  <?php			
                      	 	}else if($quotation_request[0]['approval_quotation_id_purchase'] == $quotation_request[0]['approval_quotation_id_account']){
                      	 	}else{	
                      	 	 if(validateAccess('quotation-accounts_approval_status',$access)){	
				 	  ?>
				 	  			<tr>
				 	  	      	    <td>Approval Status (Account):</td>
							 	  	<td>
							 	  		<select class="form-control" style="width: 50%;" onchange="quotation_status(this.value,<?php echo $quotation_id;?>,<?php echo $quotation_request_id;?>,'Accounts')">
							 	  			<option value="pending" <?php if($quotation[0]['status_account']=='pending'){echo 'selected="selected"';}else{echo '';}?>>Pending</option>
							 	  			<option value="approved" <?php if($quotation[0]['status_account']=='approved'){echo 'selected="selected"';}else{echo '';}?>>Approved</option>
							 	  		</select>
							 	  	</td>
							 	  	 <td>Approval By (Account):</td>
							 	  	 <td><?php echo $user_name_account;?></td>
					 	  	   </tr>
					 	  	   <tr>
					 	  	   		<td>Approval Status (Purchase):</td>
					 	  	   		<td><?php echo ucfirst($quotation[0]['status_purchase']);?></td>
					 	  	   		<td>Approval By (Purchase):</td>
					 	  	   		<td><?php echo $user_name;?></td>
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