<?php echo form_open_multipart($this->uri->uri_string(),array("id"=>"lims_add_user_frm", "name"=>"lims_add_user_frm", "class"=>"classForm form-horizontal" ));?>
    <div class="form-group">
        <label for="id" class="col-md-4 control-label">User Type</label>
        <div class="col-md-4">
        	<?php echo form_dropdown("userType", $limsUserTypeOptions, $user_type, array('id'=>'idUserTypes', 'class'=>'form-control', "placeholder"=>"Select a Receiver"));?>
        </div>
    </div>
    <?php $hide = "hide"; $required = ""; if(($user_type === '4') || (isset($staff_type) && !empty($staff_type))){$hide = ''; $required = "required";}?>
    <div class="form-group <?php echo $hide;?>" id="idStaffTypesContainer">
        <label for="id" class="col-md-4 control-label">Staff Type</label>
        <div class="col-md-4">
            <select class="classInputSelect form-control <?php echo $hide;?>" id="idStaffSTypes" name="staffType" <?php echo $required;?>>
            	<option value="">Select Staff Type</option>
                <?php foreach ($limsStaffTypes as $value):?>
                	<?php if(isset($staff_type) && !empty($staff_type) && ($value->staff_type_id === $staff_type)):?>
                		<option value="<?php echo $value->staff_type_id; ?>" selected><?php echo $value->staff_type; ?></option>
                	<?php else:?>
                		<option value="<?php echo $value->staff_type_id; ?>"><?php echo $value->staff_type; ?></option>
                	<?php endif;?>
                <?php endforeach;?>
            </select>
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
            <input type="input" class="form-control" id="idContactNo" name="contactNo" placeholder="Contact Number" value="<?php echo isset($contactNo) ? $contactNo : '';?>">
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
            <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : '';?>">
            <button type="submit" class="btn btn-primary pull-right" name="save_user_details">Add User</button>
        </div>
    </div>
<?php echo form_close();?>

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(event) {
		var frm = document.getElementById('lims_add_user_frm');

		frm.elements.userType.onchange = function(ele){
			if(ele.target.value === "4"){
				document.getElementById('idStaffTypesContainer').setAttribute("class","form-group");
				document.getElementById('idStaffSTypes').setAttribute("class","classInputSelect form-control");
				document.getElementById('idStaffSTypes').setAttribute("required",true);
			}else{
				document.getElementById('idStaffTypesContainer').setAttribute("class","form-group hide");
				document.getElementById('idStaffSTypes').setAttribute("class","classInputSelect form-control hide");
				document.getElementById('idStaffSTypes').removeAttribute("required");
			}
		}
	});

	function setPasswordhere(length){
	    var pass = generateRandomString(length);
	    document.getElementById('idPassword').value = pass;
	    document.getElementById('idPasswordC').value = pass;
	}
</script>