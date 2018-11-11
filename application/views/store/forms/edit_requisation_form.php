<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<?php
	// echo "<pre>"; print_r($requisation_details); echo "</pre>";
	$date = date("Y-m-d",strtotime($requisation_details[0]->req_date));
    $date = explode("-",$date);
    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    $fulldate = $year.','.$month.','.$day;
?>


<section class="content-header">
      <h1>
       <?php echo ucfirst($requisation_details[0]->approval_flag);?> Material Requisation
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>/dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Store</li>
        <li class=""><a href="javascript:void(0)" class="" onclick="load_page('store/material_requisation');">Material Requisation</a></li>
        <li class="active"><?php echo ucfirst($requisation_details[0]->approval_flag);?> Material Requisation</li>
      </ol>
</section>
<section class="content">
	<form role="form" id="material_requisation_form" action="store/save_material_requisation">
		 <div class="box box-default" style="border-top: 3px solid #00ACD7">
			<div class="box-header with-border">
	          			<h3 class="box-title"> <?php echo ucfirst($requisation_details[0]->approval_flag);?> Material Requisation</h3>
	        </div>
	        <!-- /.box-header -->
        	<div class="box-body">
        		<div class="row">
        			<div class="col-md-12">
	        			 <div class="box-body">
	        			 	<div class="row">
		        			 	<div class="col-md-6">
				        			 	<div class="form-group">
				                                <label for="req_number">Requisation No:</label>
				                                <input type="text" class="form-control" id="req_number" placeholder="Enter Category code" name="req_number" required autocomplete="off" readonly="" value="<?php echo $requisation_details[0]->req_number;?>"/>
				                        </div>
			                     </div>   
			                     <div class="col-md-6">
				                        <div class="form-group">
			                                  <label>Requisation Date:</label>
			                                  <div class="input-group date">
			                                        <div class="input-group-addon">
			                                          <i class="fa fa-calendar"></i>
			                                        </div>
			                                        <input type="text" class="form-control pull-right" name="req_date" required="required" readonly="" value="<?php echo $day.'-'.$month.'-'.$year ?>">
			                                  </div> 
			                            </div> 
			                    </div>  
			                </div>
			                <div class="row">
			                	<div class="col-md-6">
			            				<div class="form-group">
				                                <label for="req_given_by">Requisation Given By:</label>
				                                <select class="form-control select2" name="req_given_by" id="req_given_by" required="required">
				                                	<option value="0">Select Requisation Given Person</option>
				                                	<?php if(!empty($requisation_given_by)) {?>
				                                		<?php foreach($requisation_given_by as $key => $users){
				                                				$selected = "";
				                                				if($users['id'] == $requisation_details[0]->req_given_by){
				                                					$selected = "selected='selected'";
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
			                    	  		<select class="form-control select2" data-show-subtext="true" data-live-search="true" name="dep_id" id="dep_id" required="required" disabled="disabled">
			                    	  			<option value="0">Select Department</option>
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
				                                	<option value="0">Select Approval Assigned Person</option>
				                                <?php if(!empty($approval_assign_to)) {?>
				                                	<?php foreach($approval_assign_to as $key => $users){ 
				                                				$selected = "";
				                                				if($users['id'] === $requisation_details[0]->approval_assign_to){
				                                					$selected = "selected='selected'";
				                                				}
				                                	?>
				                                			<option value="<?php echo $users['id']?>" <?php echo $selected;?>><?php echo $users['name']?></option>
	 												<?php } ?>
				                                <?php } ?> 	
				                                </select>
			                		</div>		
			                    </div>		
			                </div>
			                <?php if(isset($sess_dep_id) && $sess_dep_id == '21'){?>
					                <div class="row">
					                    <div class="col-md-6">
					                    	<div class="form-group">
					                    		<label for="approval_date">Approval Status:</label>
					                    		<select class="form-control" name="approval_flag" id="approval_flag" required="required" onchange="change_status(<?php echo $req_id;?>)">
					                    			<option value="">Select Status</option>
					                    			<option value="pending" <?php if($requisation_details[0]->approval_flag == 'pending'){ echo 'selected="selected"';}else{ echo '';}?>>Pending</option>
					                    			<option value="approved" <?php if($requisation_details[0]->approval_flag == 'approved'){ echo 'selected="selected"';}else{ echo '';}?>>Approved</option>
					                    		</select>
					                        </div>		
					                    </div> 	
					                </div>	
				            <?php }?>    
	        			 </div>	
        			</div>
        		</div>	
        	</div>
		 </div>
		<?php if(($requisation_details[0]->approval_flag == 'pending') && ($sess_dep_id == $dep_id)){ ?> 
				 <div class="box box-default" style="border-top: 3px solid #00ACD7">
					 	   <div class="box-header with-border">
			            			<h3 class="box-title">Materials</h3>
			            			<button id="browse_material" type="button" class="btn btn-primary pull-right">Browse Materials</button>
			               </div>
			               <div class="box-body">
			        			<div class="row">
			        				  <?php $this->load->view("store/sub_views/edit_requisation_selected_material_list");?> 	
			        			</div>
			        	   </div> 			
				 </div>	
				 <div class="box-footer">
				 	 <div class="col-md-6">
				 	 	   <input type="hidden" name="submit_type" value="<?php echo $submit_type;?>"/>
				 	 	   <input type="hidden" name="req_id" value="<?php echo $req_id;?>"/>
		                   <button type="submit" class="btn btn-primary">Update Requisation</button>
		             </div>
		             <div class="col-md-6">
		             		<button type="button" class="btn btn-primary pull-right" onclick="load_page('store/material_requisation')">View</button>
		             </div>  
				 </div>	
		<?php }else if(($requisation_details[0]->approval_flag == 'approved') || $sess_dep_id == '21'){ ?>
				<div class="box box-default" style="border-top: 3px solid #00ACD7">
					<div class="box-header with-border">
						<h3 class="box-title">Materials</h3>
				    </div>
				    <div class="box-body">
			        			<div class="row">
			        				  <?php $this->load->view("store/sub_views/view_requisation_selected_material_list");?> 	
			        			</div>
			        </div> 		
			    </div>
			    <div class="box-footer">
			    	<div class="col-md-12">
			    	 	<button type="button" class="btn btn-primary pull-right" onclick="load_page('store/material_requisation')">View</button>
			    	</div> 	
			    </div>		
		<?php } ?>	 
    </form>		
</section>
<?php	
	 $this->load->view("store/modals/assign_material_requisation");
?>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/material_requisation.js"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
			$('#req_date').datepicker({
	              autoclose: true,
	              format: 'dd-mm-yyyy',
	              startDate:new Date()
	         }).datepicker("setDate", new Date('<?php echo $fulldate;?>'));

	        $('.require_date').datepicker({
	              autoclose: true,
	              format: 'dd-mm-yyyy',
	              startDate:new Date()
	        });


	        <?php if($requisation_details[0]->approval_flag == 'approved' && $sess_dep_id != '21'){ ?> 
	        		  $("#dep_id").select2("enable", false);
	        		  $("#req_given_by").select2("enable", false);
	        		  $("#approval_assign_by").select2("enable", false);
	        		  $("#approval_flag").select2("enable", false);
	        <?php } ?>	

	        <?php if($sess_dep_id == '21'){ ?>
	        			$("#dep_id").select2("enable", false);
	        			$("#req_given_by").select2("enable", false);
	        		    $("#approval_assign_by").select2("enable", false);
	        <?php } ?> 	
	});
</script>
