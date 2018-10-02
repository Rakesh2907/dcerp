<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Units Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class="active">Units</li>
      </ol>
    </section>

    <!-- Main content -->  
    <section class="content">
      <!-- /.box -->
        <div class="box">
            <!-- <div class="box-header">
              <h3 class="box-title">Units</h3>
            </div> -->
            <div class="box-header">
              <div class="pull-left">
                <?php if(validateAccess('units-add_new_unit',$access)){?>
                          <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('purchase/add_unit_form')">Add Units</a>
                <?php } ?>
                 <!-- <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="delete_all_unit">Delete</a> -->
                <?php if(validateAccess('units-export_unit',$access)){?> 
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="export_unit">Export</a>
                <?php } ?>  
              </div>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="unit_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><input name="select_all" value="1" id="unit_list-select-all" type="checkbox" /></th>
                  <th>Units</th>
                  <th>Unit Decriptions</th>
                  <?php if(validateAccess('units-edit_unit',$access) or validateAccess('units-delete_unit',$access)){?> 
                     <th>Action(s)</th>
                  <?php } ?>   
                </tr>
                </thead>
                <tbody>
                  <?php if(!empty($myunits)) { ?>
                    <?php foreach($myunits as $key=>$units):?>
                     <tr style="cursor: pointer;" data-row-id="<?php echo $units['unit_id']?>" <?php if(validateAccess('units-edit_unit',$access)){?> ondblclick="edit_unit(<?php echo $units['unit_id']?>)" <?php } ?>>
                        <td><input type="checkbox" name="" class="sub_chk" data-id="<?php echo $units['unit_id']?>"></td>
                        <td class="edit_field"><?php echo $units['unit']?></td>
                        <td class="edit_field"><?php echo $units['unit_description']?></td>
                         <?php if(validateAccess('units-edit_unit',$access) or validateAccess('units-delete_unit',$access)){?> 
                            <td>
                                <?php if(validateAccess('units-edit_unit',$access)){?> 
                                    <button style="cursor: pointer;" data-toggle="modal" onclick="edit_unit(<?php echo $units['unit_id']?>)"><i class="fa fa-pencil"></i>    
                                    </button>
                                <?php } ?>  
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php if(validateAccess('units-delete_unit',$access)){?>  
                                    <button style="cursor: pointer;" onclick="remove_unit(<?php echo $units['unit_id']?>)"><i class="fa fa-close"></i></button>
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
                    <th>Units</th>
                    <th>Unit Decriptions</th>
                     <?php if(validateAccess('units-edit_unit',$access) or validateAccess('units-delete_unit',$access)){?> 
                        <th>Action(s)</th>
                     <?php } ?>     
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
    </section>
    <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Unit</h4>
              </div>
              <div class="modal-body">
                 <form role="form" id="units_form" action="purchase/save_unit" method="post">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="unit">Units</label>
                        <input type="text" class="form-control" id="unit" placeholder="Enter Unit" required="required" name="unit">
                      </div>
                      <div class="form-group">
                        <label for="unit_description">Unit Description</label>
                        <input type="text" class="form-control" id="unit_description" placeholder="Enter Unit Description" name="unit_description">
                      </div>
                    </div>
                    <input type="hidden" name="unit_id" value="" id="unit_id">
                    <div class="box-footer">
                      <button type="button" class="btn btn-default pull-left" id="myclose">Close</button>
                      <button id="reset_unit" type="reset" class="btn btn-primary pull-left" style="margin-left: 10px;">Reset</button>
                      <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                  </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/editable.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/units.js"></script>