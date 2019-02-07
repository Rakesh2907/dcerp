<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/left_sidebar')?>
<div class="content-wrapper" style="margin-top: 50px;">
	<?php echo $contents ?>
</div>
<?php $this->load->view('layouts/session_expire_modal');?>
<?php $this->load->view('layouts/under_maintenance_modal');?>
<?php $this->load->view('layouts/footer'); ?>