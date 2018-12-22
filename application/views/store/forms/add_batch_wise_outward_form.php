<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Add Materials
        <small> Store Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="javascript:void(0)" onclick="load_page('store/outward_batch_wise');">Outward</a></li>
        <li class="active">Add Materials</li>
      </ol>
</section>
<section class="content">
	<form role="form" id="outward_form" action="store/save_outward_material">
	  <div class="box box-default">	
			<div class="box-header with-border">
			          <h3 class="box-title">Add Outward Materials</h3>

			          <div class="box-tools pull-right">
			            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse"><i class="fa fa-minus"></i></button>
			            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse2" style="display: none;"><i class="fa fa-plus"></i></button>
			          </div>
	       </div>
	       <div class="box-body">
	       	<div class="row">
	       		<div class="box-body">
		       	  <div class="col-md-6">
			       	  	<div class="form-group">
		                          <label for="outward_date">Issue/Outward Date:</label>
		                          <input type="text" class="form-control" id="outward_date" placeholder="Enter Outward Date" name="outward_date" required autocomplete="off">
		                </div>
		                <div class="form-group">
                            <label for="dep_id">Department:</label>
                            <select class="form-control select2" data-show-subtext="true" data-live-search="true" name="dep_id" id="dep_id" required="required">
                                      <option value="">Select Department</option>
                                      <?php if(!empty($departments)){?>
                                        <?php foreach($departments as $key => $department){?>
                                          <?php
                                               $selected = ""; 
                                               if($dep_id == $department['dep_id']){
                                                    $selected = "selected='selected'";
                                               }
                                          ?>
                                          <option value="<?php echo $department['dep_id']?>" <?php echo $selected;?>><?php echo $department['dep_name']?></option>
                                        <?php }?>
                                        <?php }?>   
                            </select> 
                        </div>
		       	  </div>
		       	  <div class="col-md-6">
		       	  	   <div class="form-group">
                          <label for="outward_number">Outward Number:</label>
                          <input type="text" class="form-control" id="outward_number" name="outward_number" required autocomplete="off" value="<?php echo $outward_number;?>" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="requisition_number">Requisition Number:</label>
                            <input type="text" class="form-control" id="requisition_number" value="" placeholder="Requisition Number" name="requisition_number" autocomplete="off" readonly required="required">
                            <input type="hidden" name="req_id" value="" id="req_id" />
                            <button type="button" class="btn btn-primary" style="margin-top: 4px;" onclick="outward_browse_requisition()">Browse</button>
                        </div>
		       	  </div>	
		       	</div>  
	       	</div>  	
	       </div>	
      </div> 
      <div class="box box-default">
      		<div class="box-header with-border">
                      <h3 class="box-title">Materials</h3>
                      <button type="button" class="btn btn-primary pull-right" onclick="browse_material('insert',0)">Browse Materials</button>
          </div>
          <div class="box-body">
            <div class="col-md-12" id="req_material_details">
                         
             </div>
          </div>
      </div>
      <div class="box box-default">
         <div class="row">
            <div class="box-body">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="raised_by">Requisition Raised By:</label>
                    <select class="form-control select2" id="raised_by" name="raised_by" required="required">
                      <option value="">Select Users</option>
                      <?php if(!empty($require_users)){
                          foreach ($require_users as $key => $val) {
                      ?>
                            <option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>    
                      <?php
                          } 
                        } ?>  
                    </select>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                     <label for="received_by">Material Received By:</label>
                     <input class="form-control" type="text" name="received_by" id="received_by" value="" required="required"/>
                  </div>  
              </div> 
              <div class="col-md-4">
                  <div class="form-group">
                   <label for="issue_by">Issue By:</label>
                     <select class="form-control select2" id="issue_by" name="issue_by" required="required">
                          <?php 
                           if(!empty($issue_by)){
                            foreach ($issue_by as $key => $val) {
                          ?>
                              <option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
                          <?php 
                            }
                          ?>
                          <?php } ?>  
                     </select>
                  </div>   
              </div> 
            </div>
         </div>        
      </div>
      <div class="box-footer">
                      <input type="hidden" name="submit_type" value="insert"/>
                      <input type="hidden" name="outward_form" value="bachwise_outward_form">
                      <div class="col-md-6">
                          <button type="button" class="btn btn-primary" onclick="load_page('store/add_batch_wise_outward_form')">Add Outward</button>
                          <button type="button" class="btn btn-primary" onclick="load_page('store/outward_batch_wise')" style="margin-right: 3px;">View</button> 
                      </div>
                      <div class="col-md-6">   
                          <button type="submit" class="btn btn-primary pull-right">Save</button>
                      </div>    
      </div>  
	</form>	
</section>
<?php
 	$this->load->view("purchase/modals/approved_material_requisition");
 	$this->load->view("store/modals/requisition_material_list");
 	$this->load->view("store/modals/material_purchase_rquisation");
 ?>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/batchwise_outward.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#outward_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
        }).datepicker("setDate", new Date());
	});
</script>	