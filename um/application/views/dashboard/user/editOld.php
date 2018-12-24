<?php

$userId = '';
$name = '';
$username = '';
$email = '';
$projects_arr = array();
$roleId = '';
$staff_type_id = '';

if(!empty($userInfo))
{
    //foreach ($userInfo as $uf)
    {
        $userId = $userInfo->id;
        $name = $userInfo->name;
        $username = $userInfo->login_user_name;
        $email = $userInfo->email_id;
        if(is_array($userInfo->projects)){
            $projects_arr = $userInfo->projects;
        }else{
            $projects_arr = explode(",",$userInfo->projects);    
        }
        
        $roleId = $userInfo->role_id;
        $staff_type_id = $userInfo->staff_type_id;
    }
}


?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> User Management
        <small>Add / Edit User</small>
    </h1>
</section>
    
<section class="content">

    <div class="row">        
        <div class="col-md-4">
            <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if($error)
                {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>                    
            </div>
            <?php } ?>
            <?php  
                $success = $this->session->flashdata('success');
                if($success)
                {
            ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php } ?>
            
            <div class="row">
                <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter User Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->                    
                    
                    <form role="form" action="<?php echo site_url("user/editUser");?>" method="post" id="editUser" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="fname">Full Name</label>
                                        <input type="text" class="form-control required" id="fname" name="fname" maxlength="128" autocomplete="off" value="<?php echo $name;?>">
                                        <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="text" class="form-control required email" id="email"  name="email" maxlength="128" autocomplete="off" value="<?php echo $email;?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Login User Name</label>
                                        <input type="text" class="form-control login_user_name" id="login_user_name"  name="login_user_name" autocomplete="off" value="<?php echo $username;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password"  name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Confirm Password</label>
                                        <input type="password" class="form-control equalTo" id="cpassword" name="cpassword">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="projects">Projects</label>
                                        <select class="form-control required" id="projects" name="projects[]" multiple="true">
                                            <option value="0">Select Projects</option>
                                            <?php if(!empty($projects)){foreach ($projects as $rl){?>
                                                <?php if(in_array($rl->id, $projects_arr)):?>
                                                    <option value="<?php echo $rl->id ?>" selected><?php echo $rl->name ?></option>
                                                <?php else:?>
                                                    <option value="<?php echo $rl->id ?>"><?php echo $rl->name ?></option>
                                                <?php endif;?> 
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control required" id="role" name="role">
                                            <option value="0">Select Role</option>
                                            <?php if(!empty($roles)){ foreach ($roles as $rl){?>
                                                <?php if($rl->id === $roleId):?>
                                                    <option value="<?php echo $rl->id ?>" selected><?php echo $rl->role ?></option>
                                                <?php else:?>
                                                    <option value="<?php echo $rl->id ?>"><?php echo $rl->role ?></option>
                                                <?php endif;?> 
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php $disabled='disabled="disabled"'; if($roleId === ROLE_STAFF){$disabled='';}?>
                                        <label for="staff_type">Staff Type</label>
                                        <select class="form-control required" id="staff_type" name="staff_type" <?php echo $disabled;?>>
                                            <option value="0">Select Staff Type</option>
                                            <?php if(!empty($staff_type)){ foreach ($staff_type as $rl){?>
                                                <?php if($rl->id === $staff_type_id):?>
                                                    <option value="<?php echo $rl->id ?>" selected><?php echo $rl->name ?></option>
                                                <?php else:?>
                                                    <option value="<?php echo $rl->id ?>"><?php echo $rl->name ?></option>
                                                <?php endif;?>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
        </div>    
</section>