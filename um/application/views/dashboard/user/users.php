<section class="content-header">
	<h1>
		<i class="fa fa-users"></i> User Management
		<small>Add, Edit, Delete</small>
	</h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                <a class="btn btn-primary" href="<?php echo site_url('user/addNew');?>"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-xs-12">
    		<div class="box">
    			<div class="box-header">
                    <h3 class="box-title">Users List</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                	<table class="table table-hover" id="user_list">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Name</th>
                                <th>Role</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
    	            	<tbody>
                            <?php if(!empty($userRecords)): foreach($userRecords as $record):?>
                            <tr>
                                <td><?php echo $record->id ?></td>
                                <td><?php echo $record->name ?></td>
                                <td><?php echo $record->email_id ?></td>
                                <td><?php echo $record->login_user_name ?></td>
                                <td><?php echo $record->role ?></td>
                                <td class="text-center">
                                    <a class="btn btn-xs btn-info" href="<?php echo site_url('user/editOld/'.$record->id); ?>"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-xs btn-danger deleteUser" href="#" data-userid="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                                    <a class="btn btn-xs btn-success" href="<?php echo site_url('projects/user/'.$record->id); ?>"><i class="fa fa-chain"></i></a>
                                    <?php if($record->attempted_number >= 3):?>
                                        <button class="btn btn-xs btn-danger btn_unlock" data-uid="<?php echo $record->id;?>">Unlock</button>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endforeach;endif;?>
                        </tbody>
                 	</table>
                </div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section>