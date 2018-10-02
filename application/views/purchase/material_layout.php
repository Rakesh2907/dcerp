<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Materials
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class="active">Material</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <!-- /.box -->
        <div class="box">
             <div class="box-header">
              <div class="pull-left">
                 <?php if(validateAccess('material-add_new_material',$access)){?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('purchase/add_material_form')">Add Material</a>
                 <?php } ?>   
                 <!-- <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="delete_all_material">Delete</a> -->
                 <?php if(validateAccess('material-export_material',$access)){?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="export_material">Export</a>
                 <?php } ?>   
              </div>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="material_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_cat_list_info">
                            <thead>
                                <th><input name="select_all" value="1" id="material_list-select-all" type="checkbox" /></th>
                                <th>Material code</th>
                                <th>Material Name</th>
                                <th>Material Description</th>
                                <th>Catgory Name</th>
                                <th>Unit</th>
                                <th>Current Stock</th>
                                <th>Rejected Current Qty</th>
                                <th>Minimum Level</th>
                                <th>Material Status</th>
                                <th>Scrape Opening Qty</th>
                                <th>Scrape Current_qty</th>
                                <?php if(validateAccess('material-edit_material',$access) or validateAccess('material-delete_material',$access)){?> 
                                  <th>Action(s)</th>
                                <?php } ?>  
                            </thead>
                            <tbody>
                                <?php 
                                 if(!empty($material_list)){?>
                                  <?php foreach($material_list as $key => $material) {?>
                                    <tr style="cursor: pointer;" data-row-id="<?php echo $material['mat_id']?>" <?php if(validateAccess('material-edit_material',$access)){?> ondblclick="load_page('purchase/edit_material_form/<?php echo $material['mat_id']?>')" <?php } ?>>
                                        <td><input type="checkbox" name="" class="sub_chk" data-id="<?php echo $material['mat_id']?>"></td>
                                        <td><?php echo $material['mat_code']?></td>
                                        <td><?php echo $material['mat_name']?></td>
                                        <td><?php echo $material['mat_details']?></td>
                                        <td><?php echo $material['cat_name']?></td>
                                        <td><?php echo $material['unit']?></td>
                                        <td><?php echo $material['current_stock']?></td>
                                        <td><?php echo $material['rejected_current_qty']?></td>
                                        <td><?php echo $material['minimum_level']?></td>
                                        <td><?php echo $material['mat_status']?></td>
                                        <td><?php echo $material['scrape_opening_qty']?></td>
                                        <td><?php echo $material['scrape_current_qty']?></td>
                                        <?php if(validateAccess('material-edit_material',$access) or validateAccess('material-delete_material',$access)){?> 
                                            <td>
                                                <?php if(validateAccess('material-edit_material',$access)){?>
                                                    <button onclick="load_page('purchase/edit_material_form/<?php echo $material['mat_id']?>')"><i class="fa fa-pencil"></i></button>
                                                <?php } ?>    
                                                &nbsp;&nbsp;
                                                <?php if(validateAccess('material-delete_material',$access)){?>
                                                    <button onclick="remove_materials(<?php echo $material['mat_id']?>)"><i class="fa fa-close"></i></button>
                                                <?php } ?>    
                                            </td>
                                        <?php } ?>    
                                    </tr>
                                 <?php } ?>   
                              <?php } ?>
                            </tbody>
                </table>  
            </div>  
        </div>  
    </section>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/material.js"></script>