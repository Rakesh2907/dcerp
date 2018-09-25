<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Add Material Requisation
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>/dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Store</li>
        <li class=""><a href="javascript:void(0)" class="" onclick="load_page('store/material_requisation');">Material Requisation</a></li>
        <li class="active">Add Material Requisation</li>
      </ol>
</section>
<section class="content">
	<form role="form" id="material_requisation_form" action="store/save_material_requisation">
		 <div class="box box-default">
			<div class="box-header with-border">
	          			<h3 class="box-title">Add Material Requisation</h3>
	        </div>
	        <!-- /.box-header -->
        	<div class="box-body">
        		<div class="row">
        			<div class="col-md-12">
		        			 <div class="box-body">
		        			 	<div class="row">
			        			 	<div class="col-md-6">
					        			 	<div class="form-group">
					                                <label for="req_number">Requisation Number:</label>
					                                <input type="text" class="form-control" id="req_number" placeholder="Enter Requisation No" name="req_number" required autocomplete="off" readonly="" value="<?php echo $material_requisation_number;?>"/>
					                                <input type="hidden" name="hidden_req_number" value="<?php echo $hidden_req_number;?>" />
					                        </div>
				                     </div>   
				                     <div class="col-md-6">
					                        <div class="form-group">
				                                  <label>Requisation Date:</label>
				                                  <div class="input-group date">
				                                        <div class="input-group-addon">
				                                          <i class="fa fa-calendar"></i>
				                                        </div>
				                                        <input type="text" class="form-control pull-right" id="req_date" placeholder="DD-MM-YYYY" name="req_date" required="required">
				                                  </div> 
				                            </div> 
				                    </div>  
				                </div>
				                <div class="row">
				                	<div class="col-md-6">
				            				<div class="form-group">
					                                <label for="req_given_by">Requisation Given By:</label>
					                                <select class="form-control select2" name="req_given_by" id="req_given_by" required="required">
					                                	<option value="">Select Requisation Given Person</option>
					                                	<?php if(!empty($requisation_given_by)) {?>
				                                		<?php foreach($requisation_given_by as $key => $users){
				                                				if($user_id === $users['id']){
				                                					$selected = 'selected="selected"';
				                                				}else{
				                                					$selected = '';
				                                				}
				                                		?>
				                                			<option value="<?php echo $users['id']?>" <?php echo $selected;?>><?php echo $users['name']?></option>
				                                		<?php }?>
				                                    <?php } ?>
					                                </select>
					                        </div>    		
				           	         </div>
				                    <div class="col-md-6">	
				                    	  <div class="form-group">
				                    	  		<label for="dep_id">Department:</label>
				                    	  		<select class="form-control select2" data-show-subtext="true" data-live-search="true" name="dep_id" id="dep_id" required="required">
				                    	  			<option value="">Select Department</option>
				                    	  			<?php if(!empty($departments)){?>
				                    	  				<?php foreach($departments as $key => $department){?>
				                    	  					<?php
				                    	  					     $selected = "";
				                    	  					     if($dep_id == $department['dep_id'])
				                    	  					     {
				                    	  					     		$selected = 'selected="selected"';
				                    	  					     } 
				                    	  					?>
				                    	  					<option value="<?php echo $department['dep_id']?>" <?php echo $selected;?>><?php echo $department['dep_name']?></option>
				                    	  				<?php }?>
				                    	  		    <?php }?>		
				                    	  		</select>	
				                    	  </div>	
				                    </div>		
				                </div> 	
				                 <div class="row">
				                	<div class="col-md-6">
				                		<div class="form-group">
				                				    <label for="approval_assign_by">Approval Assigned By:</label>
				                				    <select class="form-control select2" name="approval_assign_by" id="approval_assign_by" required="required">
					                                	<option value="">Select Approval Assigned Person</option>
					                                	<?php if(!empty($approval_assign_to)) {?>
						                                	<?php foreach($approval_assign_to as $key => $users){?>
						                                		     <option value="<?php echo $users['id']?>"><?php echo $users['name']?></option>
			 												<?php } ?>
				                                        <?php } ?>
					                                </select>
				                		</div>		
				                    </div>
				                    <!-- <div class="col-md-6">
				                    		<div class="form-group">
				                    				<label for="approval_date">Approval Date:</label>
				                    				<div class="input-group date">
				                                        <div class="input-group-addon">
				                                          <i class="fa fa-calendar"></i>
				                                        </div>
				                                        <input type="text" class="form-control pull-right" id="approval_date" placeholder="DD-MM-YYYY" name="approval_date">
				                                   </div>
				                    		</div>	
				                    </div> -->		
				                </div>
		        			 </div>
        			 </div>	
        		</div>	
        	</div>
		 </div>
		 <div class="box box-default">
		 	   <div class="box-header with-border">
            			<h3 class="box-title">Materials</h3>
            			<button id="browse_material" type="button" class="btn btn-primary pull-right">Browse Materials</button>
               </div>
               <div class="box-body">
        			<div class="row">
        				  <?php $this->load->view("store/sub_views/requisation_selected_material_list");?> 	
        			</div>
        	   </div>			
		 </div>	
		 <div class="box-footer">
		 	 <div class="col-md-6">
		 	 	   <input type="hidden" name="submit_type" value="<?php echo $submit_type;?>"/>
                   <button type="submit" class="btn btn-primary">Send Requisation</button>
             </div> 
             <div class="col-md-6">
             	   <button type="button" class="btn btn-primary pull-right" onclick="load_page('store/material_requisation')">View</button>
             </div> 
		 </div>	
    </form>		
</section>
<?php	
	 $this->load->view("store/modals/assign_material_requisation");
	 $this->load->view("store/modals/material_notes");
?>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/material_requisation.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#req_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
         }).datepicker("setDate", new Date());

        $('.require_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
        });

        //$("#dep_id").select2("enable", false);
	});
</script>
