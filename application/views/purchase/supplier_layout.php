<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Vendor Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class="active">Vendor</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
      <!-- /.box -->
        <div class="box" style="border-top: 3px solid #F39C12">
            <!-- <div class="box-header">
              <h3 class="box-title">Units</h3>
            </div> -->
            <div class="box-header">
              <div class="pull-left">
                <?php if(validateAccess('vendor-add_new_vendor',$access)){?>
                  <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('purchase/add_supplier_form')">Add Vendor</a>
                <?php } ?>  
                 <!-- <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="delete_all_supplier">Delete</a> -->
                <?php if(validateAccess('vendor-export_details',$access)){?> 
                  <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="export_supplier">Export</a>
                <?php } ?>  
              </div>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="supplier_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><input name="select_all" value="1" id="supplier_list-select-all" type="checkbox" /></th>
                  <th>Vendor</th>
                  <th>Registration Number</th>
                  <th>Contact Person</th>
                  <th>Mobile</th>
                  <th>Phone</th>
                  <th>QC Verified</th>
                  <?php if(validateAccess('vendor-edit_vendor',$access) or validateAccess('vendor-delete_vendor',$access)){?> 
                    <th>Action(s)</th>
                  <?php } ?>  
                </tr>
                </thead>
                <tbody>
                  <?php if(!empty($mysuppliers)) { ?>
                    <?php foreach($mysuppliers as $key=>$suppliers):?>
                     <tr style="cursor: pointer;" data-row-id="<?php echo $suppliers['supplier_id']?>" ondblclick="load_page('purchase/edit_supplier_form/<?php echo $suppliers['supplier_id']?>')">
                        <td><input type="checkbox" class="sub_chk" data-id="<?php echo $suppliers['supplier_id']?>"/></td>
                        <td><?php echo $suppliers['supp_firm_name']?></td>
                        <td><?php echo $suppliers['permanent_regi_number']?></td>
                        <td><?php echo $suppliers['supp_contact_person']?></td>
                        <td><?php echo $suppliers['supp_mobile']?></td>
                        <td><?php echo $suppliers['supp_phone1']?></td>
                        <td><?php echo ucfirst($suppliers['qc_verified'])?></td>
                        <?php if(validateAccess('vendor-edit_vendor',$access) or validateAccess('vendor-delete_vendor',$access)){?> 
                            <td>
                                <?php if(validateAccess('vendor-edit_vendor',$access)){?> 
                                      <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_supplier_form/<?php echo $suppliers['supplier_id']?>')"><i class="fa fa-pencil"></i>
                                      </button>
                                <?php } ?>   
                                 &nbsp;&nbsp;
                                <?php if(validateAccess('vendor-delete_vendor',$access)){?>  
                                    <button style="cursor: pointer;" onclick="remove_supplier(<?php echo $suppliers['supplier_id']?>)"><i class="fa fa-close"></i></button>
                                <?php } ?>    
                            </td>
                         <?php } ?>    
                     </tr>
                    <?php endforeach;?>
                 <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>Vendor</th>
                    <th>Registration Number</th>
                    <th>Contact Person</th>
                    <th>Mobile</th>
                    <th>Phone</th>
                    <?php if(validateAccess('vendor-edit_vendor',$access) or validateAccess('vendor-delete_vendor',$access)){?> 
                        <th>Action(s)</th>
                    <?php } ?> 
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
    </section>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/supplier.js"></script>