<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/left_sidebar')?>
<div class="content-wrapper">
	<?php echo $contents ?>
</div>
<?php $this->load->view('layouts/session_expire_modal');?>
<?php $this->load->view('layouts/footer'); ?>