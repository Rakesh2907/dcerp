<section class="content">
    <?php if(isset($pswd_updated_now) && !empty($pswd_updated_now)):?>
    <div style="position: absolute;width: 45%;z-index: 99;opacity: .8;text-align: center;left: 30%;top: 50px;">
        <div class="col-md-12">
            <div class="callout callout-danger">
                It's being too long that you had updated your password.Please update it now.
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="row">
        <div class="col-md-4">
          <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Enter Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo site_url('user/changePassword');?>" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputPassword1">Old Password</label>
                                    <input type="password" class="form-control" id="inputOldPassword" placeholder="Old password" name="oldPassword" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputPassword1">New Password</label>
                                    <input type="password" class="form-control" id="inputPassword1" placeholder="New password" name="newPassword" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputPassword2">Confirm New Password</label>
                                    <input type="password" class="form-control" id="inputPassword2" placeholder="Confirm new password" name="cNewPassword" required>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" value="Submit" />
                        <input type="reset" class="btn btn-default" value="Reset" />
                        <?php if(isset($pswd_updated_days) && ($pswd_updated_days >= PASSWROD_UPDATE_DAYS)):?>
                            <a href="<?php echo site_url('user/logout');?>" class="btn btn-default pull-right">Cancel</a>
                        <?php else:?>
                            <a href="<?php echo site_url('dashboard');?>" class="btn btn-default pull-right">Cancel</a>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">            
            <?php /*
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
            
            <?php  
                $noMatch = $this->session->flashdata('nomatch');
                if($noMatch)
                {
            ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('nomatch'); ?>
            </div>
            <?php } ?>
            
            <div class="row">
                <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>*/?>
        </div>
    </div>
</section>