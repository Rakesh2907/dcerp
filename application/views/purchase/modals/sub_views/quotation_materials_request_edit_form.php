<section class="">
	<div class="box box-default" style="border-top: 3px solid #00A65A">
			<div class="box-body">
				<div class="row">
					<div class="col-md-5">
						<?php if(empty($supplier_details[0]['supplier_logo'])){ ?>	
							<img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/default-logo.png" style="width: 10%"/> 
						<?php }else{?>
							<img src="<?php echo $supplier_details[0]['supplier_logo']?>" style="width: 10%"/>
					    <?php } ?>		
					</div>	
					<div class="col-md-6">
						<h5 style="font-family: bold; font-size: 30px;"><?php echo $supplier_details[0]['supp_firm_name']?></h5>
					</div>
				</div>
			</div>		
    </div>			
</section>	
<section class="content">
	<form role="form" id="vendor_quotation_form" action="purchase/save_quotation_purchase">
							 	 <div class="box box-default" style="border-top: 3px solid #FFFFFF">
						        	   <div class="box-body">
							                <div class="row">
							                    <!-- form start -->
							                       <div class="col-md-12">
								                          <div class="box-body">
								                          	  <div class="row">
									                          	  	 <div class="col-md-4">
									                          	  	 	<div class="form-group">
									                          	  	 		<label for="req_number">Quotation Request Number:</label>	
									                          	  	 		<input type="text" class="form-control" id="quo_req_number" name="quo_req_number" required autocomplete="off" readonly="" value="<?php echo $quotations[0]['quotation_request_number']?>"/>
									                          	  	 	 </div>		
									                          	  	 </div>	
									                          	  	 <div class="col-md-4">
									                          	  	 	<div class="form-group">
								                          	  	 	 		<label for="dep_id">Material Need Department:</label>
								                          	  	 	 		<input type="text" class="form-control" id="dep_name"  name="dep_name" value="<?php echo $quotations[0]['dep_name']?>" readonly=""/>
								                          	  	 	 		<input type="hidden" name="dep_id" value="<?php echo $quotations[0]['dep_id']?>">
								                          	  	 	     </div>
									                          	  	 </div>
									                          	  	 <div class="col-md-4">
									                          	  	 	<div class="form-group">
								                          	  	 	 		<label for="dep_id">Request Date:</label>
								                          	  	 	 		<input type="text" class="form-control" id="request_date"  name="request_date" value="<?php echo $quotations[0]['request_date']?>" readonly="" />
								                          	  	 	     </div>
									                          	  	 </div>	
								                          	  	</div> 
								                          	  	  
								                          </div>
							                       </div>   
							                </div>
							                <div class="row">
							                	<div class="col-md-12">
											          <div class="box box-solid">
											            <!-- /.box-header -->
											            <div class="box-body">
											              <div class="box-group" id="accordion">
											              	<?php if(!empty($quotation_details)){
											              		foreach ($quotation_details as $key => $value) {
											                 ?>	
												                <div class="panel box box-primary">
												                  <div class="box-header with-border">
												                    <h4 class="box-title">
												                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $value['mat_id'];?>" aria-expanded="true" class="">
												                        <?php echo $value['mat_name']; ?> &nbsp;&nbsp;[Mat Code][<?php echo $value['mat_code'];?>]
												                      </a>
												                    </h4>
												                  </div>
												                  <div id="collapse_<?php echo $value['mat_id'];?>" class="panel-collapse collapse in" aria-expanded="true" style="">
												                  	 <input type="hidden" name="mat_id[<?php echo $value['mat_id'];?>]" value="<?php echo $value['mat_id'];?>" />
												                  	 <input type="hidden" name="mat_name[<?php echo $value['mat_id'];?>]" value="<?php echo $value['mat_name']; ?>" />
												                  	  <input type="hidden" name="mat_code[<?php echo $value['mat_id'];?>]" value="<?php echo $value['mat_code'];?>" />
												                    <div class="box-body">
												                    	<div class="row">
												                      			<div class="col-md-3">
												                      				<label for="req_quantity">Require Quantity:</label>
												                      				<span><?php echo $value['quo_qty'];?></span>
												                      				<input type="hidden" name="require_qty[<?php echo $value['mat_id'];?>]" value="<?php echo $value['quo_qty'];?>" />
												                      			</div>
												                      			<div class="col-md-3">
												                      				<label for="expire_date">Expire Date:</label>
												                      				<input type="text" class="form-control expire_date" id="expire_date" placeholder="Enter Purchase Order Date" name="expire_date[<?php echo $value['mat_id'];?>]" value="<?php echo date('d-m-Y',strtotime($value['expire_date']))?>" required="required" autocomplete="off" >
												                      		    </div>		
												                      			<div class="col-md-3">
												                      				 <label for="availability">Availability:</label>
												                      				 <select class="form-control" name="availability[<?php echo $value['mat_id'];?>]" onchange="enabled_substitute(this.value,<?php echo $value['mat_id'];?>)">
												                      				 	<option value="available">Available</option>
												                      				 	<option value="not_available">Not Available</option>
												                      				 </select>
												                      			</div>
												                      			<div class="col-md-3" style="display: none;" id="substitute_material_<?php echo $value['mat_id'];?>">
												                      				<label for="substitute_material">Substitute Material:</label>
												                      				<input class="form-control" type="text" name="substitute_material[<?php echo $value['mat_id'];?>]" id="substitute_material" placeholder="Enter Substitute Material" value=""/>
												                      			</div>	
												                        </div> 
												                        <div class="row">
												                        		<div class="col-md-2">
												                        			<label for="quo_qty">Quotation Qty :</label>
												                        			<input type="text" name="quo_qty[<?php echo $value['mat_id'];?>]" id="quo_qty" value="<?php echo $value['quo_qty'];?>" class="form-control" onkeyup="my_qty(this.value,<?php echo $value['mat_id'];?>)"/>
												                        		</div>
												                        		<div class="col-md-2">
												                        			<label for="quo_rate">Quotation Rate :</label>
												                        			<input type="text" name="quo_rate[<?php echo $value['mat_id'];?>]" id="quo_rate" value="<?php echo $value['quo_rate'];?>" class="form-control" onkeyup="my_rate(this.value,<?php echo $value['mat_id'];?>)"/>
												                        		</div>
												                        		<div class="col-md-2">
												                        			<label for="discount">Discount (Amt):</label>
												                        			<input type="text" name="discount[<?php echo $value['mat_id'];?>]" id="discount" value="<?php echo $value['discount'];?>" class="form-control" onkeyup="my_discount(this.value,<?php echo $value['mat_id'];?>)"/>
												                        		</div>
												                        		<div class="col-md-2">
												                        			<label for="discount">Discount (%):</label>
												                        			<input type="text" name="discount_per[<?php echo $value['mat_id'];?>]" id="discount_per" value="<?php echo $value['discount_per'];?>" class="form-control" onkeyup="my_discount_per(this.value,<?php echo $value['mat_id'];?>)"/>
												                        		</div>
												                        		<div class="col-md-4">
												                        			<label for="quo_price">Price:</label>
												                        			<input type="text" name="quo_price[<?php echo $value['mat_id'];?>]" id="quo_price" value="<?php echo $value['quo_price'];?>" class="form-control" readonly="readonly"/>
												                        		</div>		
												                        </div>
												                        <div class="row">
												                        	<div class="col-md-6">
												                        		<label for="cgst_per">CGST (%):</label>
												                        		<input type="text" name="cgst_per[<?php echo $value['mat_id'];?>]" id="cgst_per[<?php echo $value['mat_id'];?>]" value="<?php echo $value['cgst_per'];?>" class="form-control" onkeyup="my_cgst_per(this.value,<?php echo $value['mat_id'];?>)"/>
												                        	</div>	
												                        	<div class="col-md-6">
												                        		<label for="cgst_amt">CGST (Amt):</label>
												                        		<input type="text" name="cgst_amt[<?php echo $value['mat_id'];?>]" id="cgst_amt[<?php echo $value['mat_id'];?>]" value="<?php echo $value['cgst_amt'];?>" class="form-control" readonly="readonly"/>
												                        	</div>
												                        </div>	
												                        <div class="row">
												                        	<div class="col-md-6">
												                        		<label for="sgst_per">SGST (%):</label>
												                        		<input type="text" name="sgst_per[<?php echo $value['mat_id'];?>]" id="sgst_per[<?php echo $value['mat_id'];?>]" value="<?php echo $value['sgst_per'];?>" class="form-control" onkeyup="my_sgst_per(this.value,<?php echo $value['mat_id'];?>)"/>
												                        	</div>	
												                        	<div class="col-md-6">
												                        		<label for="sgst_amt">SGST (Amt):</label>
												                        		<input type="text" name="sgst_amt[<?php echo $value['mat_id'];?>]" id="sgst_amt[<?php echo $value['mat_id'];?>]" value="<?php echo $value['sgst_amt'];?>" class="form-control" readonly="readonly"/>
												                        	</div>
												                        </div>
												                        <div class="row">
												                        	<div class="col-md-6">
												                        		<label for="igst_per">IGST (%):</label>
												                        		<input type="text" name="igst_per[<?php echo $value['mat_id'];?>]" id="igst_per[<?php echo $value['mat_id'];?>]" value="<?php echo $value['igst_per'];?>" class="form-control" onkeyup="my_igst_per(this.value,<?php echo $value['mat_id'];?>)"/>
												                        	</div>	
												                        	<div class="col-md-6">
												                        		<label for="igst_amt">IGST (Amt):</label>
												                        		<input type="text" name="igst_amt[<?php echo $value['mat_id'];?>]" id="igst_amt[<?php echo $value['mat_id'];?>]" value="<?php echo $value['igst_amt'];?>" class="form-control" readonly="readonly"/>
												                        	</div>
												                        </div>		
												                    </div>
												                  </div>
												                </div>
											                <?php
											                	} 
											                 }?>
											              
											              </div>
											            </div>
											            <!-- /.box-body -->
											          </div>
						          <!-- /.box -->
						        				</div>
							                </div>
							                <div class="row">
							                	<div class="col-md-3">
							                	  <div class="form-group">	
							                	  	 <label for="notes">Notes:</label> 
							                	   </div>		
							                    </div>
							                    <div class="col-md-3">
							                       <div class="form-group">	
							                       		<textarea class="form-control" name="notes" rows="1"><?php echo $edit_quotation[0]['note']?></textarea>
							                       </div> 		
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<label for="total_price">Total Price:</label>
							                        </div> 		
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<input type="text" name="total_price" id="total_price" value="<?php echo $edit_quotation[0]['total_price']?>" class="form-control" readonly="readonly"/>
							                        </div>		
							                    </div>		
							                </div>
							                <div class="row">
							                	<div class="col-md-3">
							                		<div class="form-group">
							                    		<label for="total_price">Upload Quotation:</label>
							                    		<i>File Format : PDF,JPG,JPEG,PNG</i>
							                        </div> 
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<input class="form-control" type="file" name="quotation_file" id="quotation_file"/>
							                        </div>
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<label for="total_cgst">Total CGST:</label>
							                        </div> 		
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<input type="text" name="total_cgst" id="total_cgst" value="<?php echo $edit_quotation[0]['total_cgst']?>" class="form-control" readonly="readonly"/>
							                        </div>		
							                    </div>		
							                </div>
							                <div class="row">
							                	<div class="col-md-3">
							                		<?php if(!empty($edit_quotation[0]['quotation_file'])){ 
							                			 $filename = basename($edit_quotation[0]['quotation_file']);
					 	  								 $ext = pathinfo($filename, PATHINFO_EXTENSION);	

					 	  								 	if($ext == 'pdf'){
					 	  											$img = $this->config->item("cdn_css_image").'dist/img/adobe-pdf-icon.png';
					 	  								 	}else if($ext == 'jpeg'){
					 	  										$img = $this->config->item("cdn_css_image").'dist/img/jpeg-icon.png';
											 	  			}else if($ext == 'png'){
											 	  				$img = $this->config->item("cdn_css_image").'dist/img/png-icon.png';
											 	  			}
											 	  	 ?>	
											 	  	 <a href="javascript:void(0)" onclick="popupWindow('<?php echo $edit_quotation[0]['quotation_file'];?>')"><img src="<?php echo $img?>" width="40"/></a>	
											 	  	<?php  
							                		}?>
							                    </div>
							                    <div class="col-md-3">
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<label for="total_sgst">Total SGST:</label>
							                        </div> 		
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<input type="text" name="total_sgst" id="total_sgst" value="<?php echo $edit_quotation[0]['total_sgst']?>" class="form-control" readonly="readonly"/>
							                        </div>		
							                    </div>		
							                </div>
							                <div class="row">
							                	<div class="col-md-3">

							                    </div>
							                    <div class="col-md-3">
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<label for="total_igst">Total IGST:</label>
							                        </div> 		
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<input type="text" name="total_igst" id="total_igst" value="<?php echo $edit_quotation[0]['total_igst']?>" class="form-control" readonly="readonly"/>
							                        </div>		
							                    </div>		
							                </div>
							                <div class="row">
							                	<div class="col-md-3">

							                    </div>
							                    <div class="col-md-3">
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<label for="total_igst">Other charges:</label>
							                        </div> 		
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<input type="text" name="other_amt" id="other_amt" value="<?php echo $edit_quotation[0]['other_amt']?>" class="form-control" onkeyup="other_charges(this.value)" />
							                        </div>		
							                    </div>		
							                </div>
							                <div class="row">
							                	<div class="col-md-3">

							                    </div>
							                    <div class="col-md-3">
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<label for="total_igst">Total Bill Amount:</label>
							                        </div> 		
							                    </div>
							                    <div class="col-md-3">
							                    	<div class="form-group">
							                    		<input type="text" name="total_bill_amt" id="total_bill_amt" value="<?php echo $edit_quotation[0]['total_amt']?>" class="form-control" readonly="readonly"/>
							                        </div>		
							                    </div>		
							                </div>
						               </div>           	
							 	 </div>		
								 <div class="box-footer">
								 	         <input type="hidden" name="submit_type" value="edit" /> 
								 	         <input type="hidden" id="erp_vendor_id" name="erp_vendor_id" value="<?php echo $supplier_id;?>" />
								 	         <input type="hidden" id="quo_req_id" name="quo_req_id" value="<?php echo $quo_req_id;?>" />
								 	         <input type="hidden" id="vquotation_id" name="vquotation_id" value="<?php echo $edit_quotation[0]['quotation_id']?>" />
										 	 <div class="col-md-6">
								                  
								             </div>
								             <div class="col-md-6">
								             		<button type="submit" class="btn btn-primary pull-right">Save</button>
								             </div>  
								</div>
	</form>
</section>
<script type="text/javascript">
 $(document).ready(function(){
		$('#vendor_quotation_form').on('submit',function(e){
           e.preventDefault();
     	}).validate({
          submitHandler: function(form) 
          {
            var form_data = new FormData(form);
            var page_url = $(form).attr('action');  
            $.ajax({
                url: page_url,
                headers: { 'Authorization': user_token },
                method: "POST",
                data: form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend: function () {
                     $(".content-wrapper").LoadingOverlay("show");
                     $("#add_quotation_purchase_form").modal('hide');
                },
                success: function(result, status, xhr) {
                     $(".content-wrapper").LoadingOverlay("hide");
                    var res = JSON.parse(result);
                    if(res.status == 'success')
                    {
                          swal({
                                        title: "",
                                        text: res.message,
                                        type: "success",
                                        timer:2000,
                                        showConfirmButton: false
                          },function(){
                                  swal.close();
                                  load_page(res.redirect);
                          });
                    }else if(res.status == 'error'){
                        swal({
                              title: "",
                              text: res.message,
                              type: "error",
                        });
                    }
                }
            });
        }
     }); 

     $('[name^="quo_qty"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
 });

     $('[name^="quo_rate"]').each(function() {
          $(this).rules('add', {
              number: true,
              required: true
          })
      });

     $('[name^="discount"]').each(function() {
          $(this).rules('add', {
              number: true,
              required: true
          })
      });

     $('[name^="discount_per"]').each(function() {
          $(this).rules('add', {
              number: true,
              required: true
          })
      });

     $('[name^="cgst_per"]').each(function() {
          $(this).rules('add', {
              number: true,
              required: true
          })
      });

     $('[name^="sgst_per"]').each(function() {
          $(this).rules('add', {
              number: true,
              required: true
          })
      });

      $('[name^="igst_per"]').each(function() {
          $(this).rules('add', {
              number: true,
              required: true
          })
      });
	});

    $('.expire_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
    });
</script>