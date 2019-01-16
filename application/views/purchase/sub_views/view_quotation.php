<?php 
  /* echo "<pre>";
	print_r($quotation);
   echo "</pre>";*/	
?>
<div class="modal-content">
	        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="supplier_name"><?php echo $supplier_details[0]['supp_firm_name']?></h4><i><strong><?php echo $quotation[0]['quotation_number'];?></strong></i> 
				<?php if(isset($quotation[0]['created_by_purchase']) && $quotation[0]['created_by_purchase'] > 0){
						if($quotation[0]['status_purchase'] != 'approved' && $quotation[0]['status_account'] != 'approved')
						{
				?>			<br><button class="btn btn-primary pull-right" onclick="add_quotation_purchase(<?php echo $quotation[0]['supplier_id']?>,<?php echo $quotation[0]['quo_req_id']?>,<?php echo $quotation[0]['quotation_id']?>)"><i class="fa fa-pencil"></i></button>
				<?php
						}
				 } ?>
			</div>            
            <div class="modal-body" id="supplier_quotation">
				 <table class="table">
				 	  <tr>
					 	  <th>Quotation ID:</th>
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
				 	  	 <td>&nbsp;</td>
				 	  	 <td>
				 	  	 	<?php if($quotation[0]['status_purchase']=='approved' && $quotation[0]['status_account']=='approved'){?>
				 	  	 		  <?php if(validateAccess('quotation-prepare_purchase_order_button',$access)){?> 
				 	  	 			<button class="btn btn-primary" onclick="prepare_purchase_order(<?php echo $quotation[0]['quotation_id']?>, <?php echo $quotation[0]['supplier_id']?>, <?php echo $quotation_request[0]['dep_id']?>,'material_po',0)">Prepare PO</button>
				 	  	 		  <?php } ?> 	
				 	  	 	<?php } ?>	
				 	  	 </td>
				 	  </tr>
				 	  <tr>
				 	  	<td>Vendor Notes:</td>
				 	  	<td><?php echo $quotation[0]['note']?></td>
				 	  </tr>
				 	  <tr>
				 	  	 <td>Created By:</td>
				 	  	 <td><span style="color: #f04b15;font-weight: bold;"><?php echo $created_by_name;?></span></td>
				 	  </tr>
				 	  <tr>
				 	  	 <td>Updated By:</td>
				 	  	 <td><span style="color: #f04b15;font-weight: bold;"><?php echo $updated_by_name;?><span></td>
				 	  </tr>

				 	  <?php if($quotation[0]['status_purchase']=='approved' && $quotation[0]['status_account']=='approved'){

				 	  }else{?>
				 	   <?php if(validateAccess('quotation-approved_disapproved_button',$access)){ ?> 
					 	   <tr>
					 	   	 <td><button class="btn btn-primary" id="approved_quotation" onclick="approved_quotation(<?php echo $quotation_id;?>)">Approval</button>&nbsp;&nbsp;<button style="display: none;" class="btn btn-primary" id="disapproved_quotation" onclick="disapproved_quotation(<?php echo $quotation_id;?>)">Disapproval</button></td><td></td>
					 	   </tr> 
					  <?php } 
					      }
					  ?>	   	
				 </table>
				 <table class="table table-bordered" style="margin-bottom: 0px;" id="vender_quotations">	
				 	 <thead>
				 	 	<th>Approved</th>
				 	 	<th>Material Code</th>
				 	 	<th>Material Name</th>
				 	 	<th>Availaility</th>
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
				 	 		<?php 
				 	 			foreach($quotation_details as $key => $details){
				 	 				if($details['status'] == 'approval'){
				 	 					$checked = 'checked';
				 	 				}else{
				 	 					$checked = '';
				 	 				}
				 	 		?>
					 	 		<tr>
					 	 			<td>
					 	 				<?php if($sess_dep_id == '21'){?>
					 	 					<input type="checkbox" name="material_chk[]" class="sub_chk" data-id="<?php echo $details['mat_id'];?>" <?php echo $checked;?>>
					 	 			     <?php }else if($details['status'] == 'approval'){ ?>
					 	 			     	 <i class="fa fa-fw fa-check-square"></i>
					 	 			     	 <input type="checkbox" name="material_chk[]" class="sub_chk" data-id="<?php echo $details['mat_id'];?>" <?php echo $checked;?> style="display: none;">
					 	 			     <?php } ?>		
					 	 			</td>
					 	 			<td><?php echo $details['mat_code'];?></td>
					 	 			<td><?php 
					 	 					echo $details['mat_name']; echo "<br>";
					 	 					if($details['availability'] == 'not_available')
											{
												if(!empty($details['substitute_material'])){
													echo '<strong>Substitute :</strong>'.'<span>'.$details['substitute_material'].'</span>';
												}
					 	 					}
					 	 			 ?>
					 	 			</td>
					 	 			<td><?php echo ucfirst(str_replace('_', ' ', $details['availability']));?></td>
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
				 	 		   <td colspan="5"></td>
				 	 		   <th>Total Price:</th>
				 	 		   <td align="right"><?php echo $quotation[0]['total_price'];?> (Rs)</td>
				 	 		   <td colspan="3"></td>
				 	 		   <th>Total CGST</th>
				 	 		   <td align="right"><?php echo $quotation[0]['total_cgst'];?> (Rs)</td>
				 	 		   <th>Total SGST</th>
				 	 		   <td align="right"><?php echo $quotation[0]['total_sgst'];?> (Rs)</td>
				 	 		   <th>Total IGST</th>
				 	 		   <td align="right"><?php echo $quotation[0]['total_igst'];?> (Rs)</td>
				 	 		</tr>
				 	 		<tr>
				 	 			<td colspan="14"></td>
				 	 			<th>Other Amt</th>
				 	 			<td align="right"><?php echo $quotation[0]['other_amt'];?> (Rs)</td>
				 	 		</tr>
				 	 		<tr>
				 	 			<td colspan="14"></td>
				 	 			<th>Total Bill Amt</th>
				 	 			<td align="right"><?php echo $quotation[0]['total_amt'];?> (Rs)</td>
				 	 		</tr>
				 	   <?php }?>	
				 	 </tbody>	
				 </table>
				 <table class="table">
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
                      	 	}else{
                      	 		
                      	 	 if(validateAccess('quotation-purchase_approval_status',$access)){ 	 		
                      ?>	
				 	  	      <tr>
				 	  	      	    <td>Approval Status (Purchase):</td>
							 	  	<td>
							 	  		<select id="approval_status-Purchase" class="form-control" style="width: 50%;" onchange="quotation_status(this.value,<?php echo $quotation_id;?>,<?php echo $quotation_request_id;?>,'Purchase')">
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
				 	  		if($quotation_request[0]['approval_quotation_id_purchase'] == $quotation_id && $quotation_request[0]['approval_quotation_id_account'] == $quotation_id){ //echo "in111";?>
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
                      	 	}else{	
                      	 		//echo "in33";
                      	 	 if(validateAccess('quotation-accounts_approval_status',$access)){	 //echo "in444";
				 	  ?>
				 	  			<tr>
				 	  	      	    <td>Approval Status (Account):</td>
							 	  	<td>
							 	  		<select id="approval_status-Accounts" class="form-control" style="width: 50%;" onchange="quotation_status(this.value,<?php echo $quotation_id;?>,<?php echo $quotation_request_id;?>,'Accounts')">
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
				 	   <?php if(isset($quotation[0]['quotation_file']) && !empty($quotation[0]['quotation_file'])){?>
					 	  <tr>
					 	  	<td>
					 	  		<?php 
					 	  			$filename = basename($quotation[0]['quotation_file']);
					 	  			$ext = pathinfo($filename, PATHINFO_EXTENSION);

					 	  			if($ext == 'pdf'){
					 	  				$img = $this->config->item("cdn_css_image").'dist/img/adobe-pdf-icon.png';
					 	  			}else if($ext == 'jpeg'){
					 	  				$img = $this->config->item("cdn_css_image").'dist/img/jpeg-icon.png';
					 	  			}else if($ext == 'png'){
					 	  				$img = $this->config->item("cdn_css_image").'dist/img/png-icon.png';
					 	  			}
					 	  		?>

					 	  		<a href="javascript:void(0)" onclick="popupWindow('<?php echo $quotation[0]['quotation_file'];?>')"><img src="<?php echo $img?>" width="40"/></a>
					 	  	</td>
					 	  </tr>
				 	 <?php }?>
				 </table>           		
            </div>
</div>
<script type="text/javascript">
		$(document).ready(function(){
				$("#vender_quotations input:checkbox").change(function() {
                    var ischecked= $(this).is(':checked');
                    if(ischecked){
                    	$("#approved_quotation").show();
                    	$("#disapproved_quotation").hide();
                    }else{
                    	$("#disapproved_quotation").show();
                    	$("#approved_quotation").hide();
                    }
                });
		});
</script>