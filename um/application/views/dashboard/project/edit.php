<section class="content">
	<div class="row">
		<div class="col-md-9 col-md-offset-1">
          	<div class="box box-solid">
                    <div class="box-header">
                         <h3>Update Project Details</h3>
                    </div>
          		<div class="box-body">
                         <div class="col-md-12">
                              <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                         </div>
                         <?php echo form_open_multipart($this->uri->uri_string(),array("id"=>"edit_project", "name"=>"edit_project"));?>
                         <div class="form-group">
                              <label>Project Name</label>
                              <?php echo form_input(array('name' => 'name',
                                                       'id' => 'projectName',
                                                       'class' => 'form-control',
                                                       'placeholder' => 'Project Name',
                                                       'value'=> isset($project_details->name) ? $project_details->name : ''));?>
                         </div>
                         <div class="form-group">
                              <label>Login URL</label>
                              <?php echo form_input(array('name' => 'project_url',
                                                       'id' => 'projectURL',
                                                       'class' => 'form-control',
                                                       'placeholder' => 'Login URL',
                                                       'value'=> isset($project_details->project_url) ? $project_details->project_url : ''));?>
                         </div>
                         <div class="form-group">
                              <label>User Registration URL</label>
                              <?php echo form_input(array('name' => 'add_user_url',
                                                       'id' => 'addUserURL',
                                                       'class' => 'form-control',
                                                       'placeholder' => 'User Registration URL',
                                                       'value'=> isset($project_details->add_user_url) ? $project_details->add_user_url : ''));?>
                         </div>
                         <div class="form-group">
                              <input type="submit" class="btn btn-primary pull-right" name="update_project" value="Update">
                         </div>
                         <?php echo form_close();?>
			    </div>
			</div>
		</div>
    </div>
</section>