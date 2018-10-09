<?php
 if(!empty($suppliers_ids))
 {
	 	$totalprice = [];
?>
<table class="table table-bordered">
  <thead>	
	<th style="width:10px;">Material code</th>
	<th style="width:10px;">Material Name</th>
	<th style="width:10px;">Require Qty</th>
	<?php foreach($suppliers as $key => $supplier){ ?>
				<th style="width:10px;"><?php echo $supplier['supp_firm_name'];?></th>
	<?php } ?>
  </thead>
  <tbody>
  	 <?php
  	 	foreach($bid_details as $mat_id => $values){?>
  	 	<tr>
  	 		<td align="left"><?php echo $values['mat_code']?></td>
  	 		<td align="left"><?php echo $values['mat_name']?></td>
  	 		<td align="left"><?php echo $values['require_qty']?></td>
  	 		<?php 
  	 		    foreach($suppliers as $supp_key => $mysupplier_id){
  	 		    	$totalprice[$mysupplier_id['supplier_id']] += 0;
  	 		    ?> 
	  	     <td>
	  	     	<?php if(!empty($values['suppliers_bid'])){?>
		  	 	<?php foreach ($values['suppliers_bid'] as $key => $val) {?>		   
			  	 		 <?php if($mysupplier_id['supplier_id'] === $val['supplier_id']){ 
			  	 		 	     $totalprice[$val['supplier_id']] += $val['quo_price'];
			  	 		 	?>
							  	  <table class="table table-bordered" style="margin-bottom: 0px;">	
							  	 			  <tr>	
								  	 			<td align="right">
								  	 				<?php
									  	 				 if(!empty($val['quo_price'])){
									  	 				 	echo $val['quo_price'].' (Rs)';
									  	 				  }else{
									  	 				 	echo "0.00";
									  	 				 } 
								  	 			    ?>
								  	 			</td>
								  	 		   </tr> 	
								  </table> 
			  	 		  <?php 
			  	 		   }else{
			  	 		   	   
			  	 		   } 
			  	 		?> 			
		  	 	<?php }// foreach end supplier bid details  ?> 
		  	 <?php }else{
		  	 	 echo "No Quotation";
		  	 }?>
	  	     </td>
  	 	   <?php } // foreach end supplier?>	
  	 	</tr>
  	<?php

  	} ?>
  	 <tr>
  	   <th colspan="3"></th>
	    <?php 
  	 		 foreach($suppliers as $supp_key => $mysupplier_id){ ?>
		  	 		 <td>   	
			    		<?php 
			    			if($totalprice[$mysupplier_id['supplier_id']] > 0){
			    				$quotation = $this->purchase_model->get_supplier_quotation(array('quo_req_id'=>$quotation_request_id,'supplier_id'=>$mysupplier_id['supplier_id']));

			    				if($quotation[0]['status_purchase'] === 'approved' && $quotation[0]['status_account'] === 'approved'){
			    					$button_class = 'btn btn-primary';
			    				}else{
			    					$button_class = 'btn';
			    				}

			    	    ?>	
			    	    	 <table class="table" style="margin-bottom: 0px;">
			    	    	 	<tr>
			    	    	 		<td align="left">
			    	    	 		    <?php if(validateAccess('quotation-view_quotation_details',$access)){?>  	
			    	    	 				<button class="<?php echo $button_class;?>" onclick="get_quotation(<?php echo $quotation_request_id;?>,<?php echo $mysupplier_id['supplier_id'];?>)"><i class="fa fa-eye"></i></button>
			    	    	 		    <?php } ?>		
			    	    	 	    </td>
			    	    	 		<td align="right">Quotation Price:</td>
			    	    	 		<td align="right"><strong><?php echo $totalprice[$mysupplier_id['supplier_id']];?></strong> (Rs)</td>
			    	    	 	</tr>
			    	    	 	<tr>
			    	    	 		<td></td>
			    	    	 		<td align="right">Total Bill Amt:</td>
			    	    	 		<td align="right"><strong><?php echo $quotation[0]['total_amt'];?></strong> (Rs)</td>		
			    	    	 	</tr>	
			    	    	 </table> 			
			    	    <?php			
			    			}else{
			    				echo 'Quotation Price Not Get';
			    			}
			    		?>
			         </td>		 
	   <?php }?>
     </tr>	
  </tbody>	
</table>
<?php  }else{ ?>
<table class="table table-bordered">
	<tr><td colspan="4" align="center">Currently not received any quotation from vendors.</td></tr>
</table>	
<?php } ?>
	