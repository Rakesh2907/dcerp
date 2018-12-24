<li>
    <a href="<?php echo site_url();?>">
        <i class="fa fa-industry"></i>
        <span>Projects</span>
    </a>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-users"></i>
        <span>Users</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="<?=site_url('user/userListing');?>">
                <i class="fa fa-circle-o"></i>Users
            </a>
        </li>
        <li>
            <a href="<?=site_url('user/userRoleListing');?>">
                <i class="fa fa-circle-o"></i>User Roles
            </a>
        </li>
    </ul>
</li>