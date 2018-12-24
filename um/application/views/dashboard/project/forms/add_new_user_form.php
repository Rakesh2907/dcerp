<?php echo form_open_multipart($this->uri->uri_string(),array("id"=>"lims_add_user_frm", "name"=>"lims_add_user_frm", "class"=>"classForm form-horizontal" ));?>
    <div class="form-group">
        <label for="id" class="col-md-4 control-label">User Type</label>
        <div class="col-md-4">
        	<?php echo form_dropdown("userType", $limsUserTypeOptions, $user_type, array('id'=>'idUserTypes', 'class'=>'form-control', "placeholder"=>"Select a Receiver"));?>
        </div>
    </div>
    <div class="form-group">
        <label for="idName" class="col-md-4 control-label">Name</label>
        <div class="col-md-5">
            <?php echo form_input(array('name' => 'name',
        								'id' => 'idName',
                                        'class' => 'form-control',
                                        'placeholder' => 'Name',
                                        'value'=> isset($name) ? $name : ''));?>
        </div>
    </div>
    <div class="form-group">
        <label for="idUsername" class="col-md-4 control-label">Username</label>
        <div class="col-md-5">
        	<?php echo form_input(array('name' => 'username',
        								'id' => 'idUsername',
                                        'class' => 'form-control',
                                        'placeholder' => 'Username',
                                        'value'=> isset($login_user_name) ? $login_user_name : '',
                                        'required'=>'required'));?>
        </div>
    </div>
    <div class="form-group">
    	<div class="col-md-9"><a href="javascript:void(0)" class="pull-right" onclick="setPasswordhere('8')">Generate Password</a></div>
        <label for="idPassword" class="col-md-4 control-label">Password</label>
        <div class="col-md-5">
            <input type="password" class="form-control" id="idPassword" name="password" placeholder="Password" required>
        </div>
    </div>
    <div class="form-group">
        <label for="idPasswordC" class="col-md-4 control-label">Password Again</label>
        <div class="col-md-5">
            <input type="password" class="form-control" id="idPasswordC" name="passwordC" placeholder="Confirm Password" required>
        </div>
    </div>
    <div class="form-group">
        <label for="idEmail" class="col-md-4 control-label">Email</label>
        <div class="col-md-5">
            <input type="email" class="form-control" id="idEmail" name="email" placeholder="Email" value="<?php echo  isset($email) ? $email : '';?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="idContactNo" class="col-md-4 control-label">Contact Number</label>
        <div class="col-md-5">
            <input type="input" class="form-control" id="idContactNo" name="contactNo" placeholder="Contact Number" value="<?php echo isset($contactNo) ? $contactNo : '';?>" required>
        </div>
    </div>
    <div class="form-group" id="idGenderContainer">
        <label for="idGender" class="col-md-4 control-label">Gender</label>
        <div class="col-md-5">
            <select name="gender" id="idGender" class="classInputSelect form-control">
            	<?php if(isset($gender) && !empty($gender) && ($gender==='Male')):?>
            		<option value="Male" selected>Male</option>
            		<option value="Female">Female</option>
            	<?php elseif(isset($gender) && !empty($gender) && ($gender==='Female')):?>
            		<option value="Male">Male</option>
            		<option value="Female" selected>Female</option>
            	<?php else:?>
            		<option value="Male">Male</option>
                    <option value="Female">Female</option>
            	<?php endif;?>
            </select>
        </div>
    </div>            
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right" name="save_user_details">Add User</button>
        </div>
    </div>
<?php echo form_close();?>
<script type="text/javascript">
    function setPasswordhere(length){
        var pass = generateRandomString(length);
        document.getElementById('idPassword').value = pass;
        document.getElementById('idPasswordC').value = pass;
    }
</script>