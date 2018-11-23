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
        <div class="box-body">
             <table id="material_inward_list" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th>PO Number</th>
                    <th>Bill Date (Invoice Date)</th>
                    <th>Bill Number (Invoice No.)</th>
                    <th>GRN Date</th>
                    <th>GRN Number</th>
                    <th>Vendor Name</th>
                    <th>Action(s)</th>
                  </tr>  
                </thead> 
                 <tbody>
                    <?php 
                      if(!empty($general_materials)){
                        foreach ($general_materials as $key => $value) {
                           // echo "<pre>"; print_r($value); echo "</pre>";
                     ?> 
                        <tr style="cursor: pointer;" data-row-id="<?php echo $value['inward_id']?>">
                          <td class="details-control-<?php echo $value['inward_id']?>">
                             <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" />
                          </td>
                          <td><?php echo $value['po_number']?></td>
                          <td><?php echo date("d-m-Y", strtotime($value['invoice_date']))?></td>
                          <td><?php echo $value['invoice_number'];?></td>
                          <td><?php echo date("d-m-Y", strtotime($value['grn_date']));?></td>
                          <td><?php echo $value['grn_number'];?></td>
                          <td><?php echo $value['supp_firm_name'];?></td>
                          <td><button style="cursor: pointer;" data-toggle="modal" onclick="load_page('store/edit_inward_general_form/inward_id/<?php echo $value['inward_id']?>')"><i class="fa fa-pencil"></i></button></td>
                        </tr>  
                    <?php
                       } 
                     } ?>
                 </tbody> 
             </table> 
        </div>       	
	</div>
</section>	
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/general_inward.js"></script>