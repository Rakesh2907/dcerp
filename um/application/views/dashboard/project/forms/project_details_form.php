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