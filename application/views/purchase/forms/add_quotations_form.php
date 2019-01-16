<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Add Quotation Request
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>/dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class=""><a href="javascript:void(0)" class="" onclick="load_page('purchase/quotations');">Quotations</a></li>
        <li class="active">Add Quotation Request</li>
      </ol>
</section>
<section class="content">
	 <form role="form" id="quotation_form" action="purchase/save_quotations">
	 	 <div class="box box-default" style="border-top: 3px solid #00A65A">
					 	   <div class="box-header with-border">
			            			<h3 class="box-title">Materials</h3>
			            			<button id="browse_material" type="button" class="btn btn-primary pull-right">Browse Materials</button>
			               </div>
			               <div class="box-body">
			        			<div class="row" id="material_listing">
			        				  <?php $this->load->view("purchase/sub_views/quotation_selected_material_list");?> 	
			        			</div>
			        	   </div> 			
		</div>
	 	 <div class="box box-default" style="border-top: 3px solid #00A65A">
        	   <div class="box-body">
	                <div class="row">
	                    <!-- form start -->
	                       <div class="col-md-12">
		                          <div class="box-body">
		                          	  <div class="row">
			                          	  	 <div class="col-md-6">
			                          	  	 	<div class="form-group">
			                          	  	 		<label for="req_number">Quotation Request Number:</label>	
			                          	  	 		<input type="text" class="form-control" id="quo_req_number" placeholder="Enter Requisation No" name="quo_req_number" required autocomplete="off" readonly="" value="<?php echo $quotation_request_number;?>"/>
						                            <input type="hidden" name="hidden_quo_req_number" value="<?php echo $hidden_quo_req_number;?>" />
			                          	  	 	 </div>		
			                          	  	 </div>	
			                          	  	 <div class="col-md-6">
			                          	  	 	<div class="form-group">
		                          	  	 	 		<label for="dep_id">Department:</label>
		                          	  	 	 		<select class="form-control select2" name="dep_id" id="dep_id" required="required" onchange="get_vendor(this.value)">
		                          	  	 	 			<option value="">Select Department</option>
		                          	  	 	 			<?php foreach($departments as $key => $department){
		                          	  	 	 					$selected = '';
		                          	  	 	 					if($department['dep_id'] == $dep_id){
		                          	  	 	 						$selected = 'selected="selected"';
		                          	  	 	 					}
		                          	  	 	 			?>
		                          	  	 	 				<option value="<?php echo $department['dep_id']?>" <?php echo $selected;?>><?php echo $department['dep_name']?></option>
		                          	  	 	 			<?php } ?>
		                          	  	 	 		</select>
		                          	  	 	     </div>
			                          	  	 </div>	
		                          	  	</div> 
		                          	  	<div class="row">
						                 <div class="col-md-4">
						                 	<div class="form-group" id="supplier_list">
						                 		 <label for="req_number">Vendors:</label>	
						                 		 <select id="supplier_dropdown" class="form-control select2" multiple="multiple" data-placeholder="Select Vendors"
		                        style="width: 100%;" name="suppliers[]" required="required" <?php echo $readonly;?>>
		                        				 <?php foreach($mysuppliers as $key => $suppliers){
		                        				 	  $selected = '';
		                        				 	  if(isset($vendor_id) && $variable == 'supplier_id')
		                        				 	  {
		                        				 	  	  if(in_array($suppliers['supplier_id'], $vendor_id)){
		                        				 	  	  	  	$selected = 'selected="selected"';
		                        				 	  	  }
		                        				 	  }
		                        				 ?>
		                        				 	<option value="<?php echo $suppliers['supplier_id']?>" <?php echo $selected;?>><?php echo $suppliers['supp_firm_name']?></option>
		                        				 <?php }?>	
								                 </select>
						                 	</div>	
						                 </div>
						                 <div class="col-md-2">
						                 	<div class="form-group">
						                 		<label>&nbsp;</label>	
						                 	 	<button class="btn btn-primary" type="button" style="margin-top: 22px;" onclick="add_vendor(0,'insert')">+</button>
						                 	</div>
						                 </div>	
						               </div>   
		                          </div>
	                       </div>   
	                </div>
               </div>           	
	 	 </div>		
		 <div class="box-footer">
		             <div class="col-md-6">
		             		<button type="button" class="btn btn-primary pull-left" onclick="load_page('purchase/quotations')">View</button>
		             </div> 
		             <div class="col-md-6">
				 	 	   <input type="hidden" name="submit_type" value="<?php echo $submit_type;?>"/>
		                   <button type="submit" class="btn btn-primary pull-right">Save Quotation Request</button>
		             </div> 
		</div>
	 </form>	
</section>
<?php	
	 $this->load->view("purchase/modals/assign_material_quotation");
?>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/quotations.js"></script>	
<script type="text/javascript">
	 var dep_id = '<?php echo $dep_id;?>';
	 if(dep_id > 0){
	 		$("#dep_id").val(dep_id).trigger('change');
	 }
</script>