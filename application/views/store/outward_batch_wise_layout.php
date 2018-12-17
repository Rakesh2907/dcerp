<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
         Material Outward
      </h1>
      <i>(From Store)</i>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Store</li>
        <li class="active">Material Outward</li>
      </ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header">
			<div class="pull-left">
				<a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('store/add_batch_wise_outward_form')">Add Outward</a>
			</div>	
		</div>	
    <div class="box-body">
       <table id="material_outward_list" class="table table-bordered table-striped">
          <thead>
            <tr>
                    <th></th>
                    <th>Outward Number</th>
                    <th>Outward Date</th>
                    <th>Depatment Name</th>
                    <th>Requisation Number</th>
                    <th>Action(s)</th>
            </tr>
          </thead> 
          <tbody>
              <?php 
                 if(!empty($outwards)){
                   foreach ($outwards as $key => $value) {
              ?>
                    <tr style="cursor: pointer;" data-row-id="<?php echo $value['outward_id']?>">
                      <td></td>
                      <td><?php echo $value['outward_number']?></td>
                      <td><?php echo $value['outward_date']?></td>
                      <td><?php echo $value['dep_name']?></td>
                      <td><?php echo $value['req_number']?></td>
                      <td><button style="cursor: pointer;" data-toggle="modal" onclick="load_page('store/edit_batch_wise_outward_form/outward_id/<?php echo $value['outward_id']?>')"><i class="fa fa-pencil"></i></button></td>
                    </tr>  
              <?php
                   }
                 } 
              ?>
          </tbody> 
       </table> 
    </div>  
	</div>
</section>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/batchwise_outward.js"></script>	