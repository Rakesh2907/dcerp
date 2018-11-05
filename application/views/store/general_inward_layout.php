<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
         General Inward
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Store</li>
        <li class="active">General Inward</li>
      </ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header">
              <div class="pull-left">
              		<a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('store/add_inward_general_form')">Add General Materials</a>
              </div>
        </div>      	
	</div>
</section>	
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>