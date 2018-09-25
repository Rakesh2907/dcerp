<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Add Quotations
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>/dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class=""><a href="javascript:void(0)" class="" onclick="load_page('purchase/quotations');">Quotations</a></li>
        <li class="active">Add Quotations</li>
      </ol>
</section>
<section class="content">
	 <form role="form" id="quotation_form" action="purchase/save_quotations">
	 	 <div class="box box-default">
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
	 	 <div class="box box-default">
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
						                 <div class="col-md-4">
						                 	<div class="form-group">
						                 		 <label for="req_number">Vendors:</label>	
						                 		 <select id="supplier_dropdown" class="form-control select2" multiple="multiple" data-placeholder="Select Vendors"
		                        style="width: 100%;" name="suppliers[]" required="required">
		                        				 <?php foreach($mysuppliers as $key => $suppliers){
		                        				 	  $selected = '';
		                        				 	  if(isset($myid) && $variable === 'supplier_id')
		                        				 	  {
		                        				 	  	  if($myid == $suppliers['supplier_id']){
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
				 	 	   <input type="hidden" name="submit_type" value="<?php echo $submit_type;?>"/>
				 	 	   <input type="hidden" name="dep_id" value="<?php echo $dep_id;?>" />
		                   <button type="submit" class="btn btn-primary">Send Quotation</button>
		             </div>
		             <div class="col-md-6">
		             		<button type="button" class="btn btn-primary pull-right" onclick="load_page('purchase/quotations')">View</button>
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