<section class="content">
	<div class="row">
		<div class="col-md-9 col-md-offset-1">
          	<div class="box box-solid">
                    <div class="box-header">
                         <h3>Add New Project</h3>
                    </div>
          		<div class="box-body">
                         <?php if(isset($error_msg) && !empty($error_msg)):?>
                         <div class="col-md-12">
                              <div class="alert alert-danger alert-dismissable">
                                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                   <?php echo $error_msg;?>
                              </div>
                              <?php //echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                         </div>
                         <?php endif;?>
                         <?php echo form_open_multipart($this->uri->uri_string(),array("id"=>"add_project", "name"=>"add_project"));?>
                         <?php $this->load->view("dashboard/project/forms/project_details_form");?>
                         <div class="form-group">
                              <button type="submit" class="btn btn-primary pull-right" name="add_project" value="Submit">Save</button>
                         </div>
                         <?php echo form_close();?>
			    </div>
			</div>
		</div>
    </div>
</section>