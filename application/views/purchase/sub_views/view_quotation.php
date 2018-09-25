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
				 	  </tr>
				 	  <tr>
				 	  	  <th>Cradit Days:</th>
					 	  <th><?php echo $cradit_days;?></th>
				 	  </tr>
				 	  <tr>
				 	  	<td>Firm Name:</td>
				 	  	<td><?php echo $supplier_details[0]['supp_firm_name']?></td>
				 	  </tr>	
				 	  <tr>
				 	  	 <td>Contact Person:</td>
				 	  	 <td><?php echo $supplier_details[0]['supp_contact_person']?></td>
				 	  </tr>
				 	  <tr>
				 	  	 <td>Mobile:</td>
				 	  	 <td><?php echo $supplier_details[0]['supp_mobile']?></td>
				 	  </tr>
				 	  <tr>
				 	  	 <td>Email:</td>
				 	  	 <td><?php echo $supplier_details[0]['supp_email']?></td>
				 	  </tr>
				 	  <tr>
				 	  	 <td>Address:</td>
				 	  	 <td><?php echo $supplier_details[0]['supp_address']." ".$supplier_details[0]['supp_state']." ".$supplier_details[0]['supp_country'];?></td>
				 	  </tr>
				 	  <?php if(isset($status) && $status === 'approved'){ ?>
							  <tr>
							 	  	<td>Approval Status:</td>
							 	  	<td><span style="color: #6063E5; font-weight: bold;"><?php echo ucfirst($status);?></span></td>
			                      </tr>
			                      <tr>
			                      	 <td>Approval By:</td>
			                      	 <td><?php echo $user_name;?></td>
			                  </tr>
				 	  <?php	}else if($approval_status === 'approved'){?>
                      <?php }else{ ?>
				 	  	      <tr>
				 	  	      	    <td>Approval Status:</td>
							 	  	<td>
							 	  		<select class="form-control" style="width: 50%;" onchange="quotation_status(this.value,<?php echo $quotation_id;?>,<?php echo $quotation_request_id;?>,<?php echo $supplier_details[0]['supplier_id'];?>)">
							 	  			<option value="pending">Pending</option>
							 	  			<option value="approved">Approved</option>
							 	  		</select>
							 	  	</td>
					 	  	  </tr>
						 	  <tr>
							 	  	 <td>Approval By:</td>
							 	  	 <td></td>
					 	  	   </tr>
				 	  <?php } ?>
				 </table>
				 <table class="table table-bordered" style="margin-bottom: 0px;">	
				 	 <thead>
				 	 	<th>Material Code</th>
				 	 	<th>Material Name</th>
				 	 	<th>Quatation Rate</th>
				 	 	<th>Quatation Quantity</th>
				 	 	<th>Quatation Price</th>
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
					 	 		</tr>
				 	 		<?php
				 	 			 $total_price =  $total_price + $details['quo_price'];
				 	 		}?>
				 	 		<tr>
				 	 		   <td colspan="3"></td>
				 	 		   <th>Total:</th>
				 	 		   <td align="right"><?php echo $total_price;?> (Rs)</td>
				 	 		</tr>
				 	   <?php }?>	
				 	 </tbody>	
				 </table>           		
            </div>
</div>