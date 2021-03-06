<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
         Material Requisition (Purchase)
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class="active">Material Requisition</li>
      </ol>
</section>
<section class="content">
  <div class="box box-default" style="border-top: 3px solid #00C0EF">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse2" style="display: none;"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                            <label for="from_requisition_date">From Date:</label>
                            <input type="text" class="form-control" id="from_requisition_date" placeholder="From Requisition Date" name="from_requisition_date" value="<?php echo $fselected_from_date;?>" required autocomplete="off">
                          </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                            <label for="to_requisition_date">To Date:</label>
                            <input type="text" class="form-control" id="to_requisition_date" placeholder="To Requisition Date" name="to_requisition_date" value="<?php echo $fselected_to_date;?>" required autocomplete="off">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Department:</label>
                  <?php 
                    //if($sess_dep_id == '21'){
                    if(is_array($access_dep) && in_array($sess_dep_id, $access_dep)){
                             $disabled = '';
                    }else{
                             $disabled = 'disabled="disabled"';     
                    }
                  ?>
                  <select class="form-control select2" name="dep_id" id="filter_dep_id" <?php echo $disabled;?>>
                     <?php foreach ($departments as $key => $value) { 
                            if(isset($fdep_id) && !empty($fdep_id)){
                                  $sess_dep_id = $fdep_id;
                            }

                            if($value['dep_id'] == $sess_dep_id){
                                  $selected = 'selected="selected"';
                            }else{
                                  $selected = '';
                            } 

                      ?>
                            <option value="<?php echo $value['dep_id']?>" <?php echo $selected;?>><?php echo $value['dep_name'];?></option>
                     <?php } ?>
                  </select>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <div class="row">
                <div class="box-footer">
                    <button class="btn btn-primary pull-right" onclick="search_requisition()">Search</button>
                </div>
            </div>  
        </div>
  </div>
  <div class="box" style="border-top: 3px solid #fff;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <?php //if(validateAccess('material_requisition-pending_requisition',$access)){?>  
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Pending Requisition(s)</a></li>
              <?php //} ?>
              <?php //if(validateAccess('material_requisition-approved_requisition',$access)){?>  
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Approved Requisition(s)</a></li>
              <?php //} ?>
              <?php //if(validateAccess('material_requisition-completed_requisition',$access)){?>    
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Completed Requisition(s)</a></li>
              <?php //} ?>      
            </ul>
            <div class="tab-content">
              <?php //if(validateAccess('material_requisition-pending_requisition',$access)){?>  
                <div class="tab-pane active" id="tab_1">
                    <table id="pending_material_req_list" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <?php //if(validateAccess('material_requisition-view_materials',$access)){?>  
                                       <th></th>
                                      <?php //} ?>   
                                       <th><input name="select_all" value="1" id="material_req_list-select-all" type="checkbox" /></th>
                                       <th>Requisition Number</th>
                                       <th>Requisition Date</th>
                                       <th>Departments</th>
                                       <th>Status</th>
                                       <th>Action(s)</th>
                                    </tr>
                                  </thead> 
                                  <tbody>
                                        <?php if(!empty($pending_material_requisation_list)){?>
                                            <?php foreach($pending_material_requisation_list as $key=> $material_requisation):
                                            ?>
                                               <tr style="cursor: pointer;" data-row-id="<?php echo $material_requisation['req_id']?>" data-row-dep_id="<?php echo $material_requisation['dep_id']?>">
                                                <?php //if(validateAccess('material_requisition-view_materials',$access)){?> 
                                                    <td class="details-control-<?php echo $material_requisation['req_id']?>">
                                                       
                                                    </td>
                                                <?php //} ?>  
                                                 <td width="50"><input type="checkbox" class="sub_chk" data-id="<?php echo $material_requisation['req_id']?>"/></td>
                                                  <td width="200"><?php echo $material_requisation['req_number']?></td>
                                                  <td><?php echo date("d-m-Y",strtotime($material_requisation['req_date']));?></td>
                                                  <td><?php echo $material_requisation['dep_name'];?></td>
                                                  <td>
                                                      <?php if($material_requisation['purchase_approval_flag'] != 'completed'){?> 
                                                         <select class="form-control" name="purchase_approval_flag" id="purchase_approval_flag" required="required" onchange="purchase_change_status(this.value,<?php echo $material_requisation['req_id']?>)">
                                                            <option value="pending" <?php if($material_requisation['purchase_approval_flag'] == 'pending'){ echo 'selected="selected"';}else{ echo '';}?>>Pending</option>
                                                            <option value="approved" <?php if($material_requisation['purchase_approval_flag'] == 'approved'){ echo 'selected="selected"';}else{ echo '';}?>>Approved</option>
                                                          </select> 
                                                      <?php } ?>  
                                                  </td>
                                                  <td>
                                                  <?php
                                                        $icon = 'fa fa-eye';
                                                   ?>
                                                    <?php //if(validateAccess('material_requisition-view_edit',$access)){?> 
                                                        <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/view_requisation_form/req_id/<?php echo $material_requisation['req_id']?>')"><i class="<?php echo $icon;?>"></i></button>
                                                    <?php //} ?>  
                                                  </td>
                                               </tr>    
                                            <?php endforeach;?>  
                                      <?php } ?>
                                  </tbody> 
                                   <tfoot>
                                      <tr>
                                      <?php //if(validateAccess('material_requisition-view_materials',$access)){?>  
                                            <th></th>
                                      <?php //} ?> 
                                         <th></th>
                                         <th>Requisition Number</th>
                                         <th>Requisition Date</th>
                                         <th>Departments</th>
                                         <th>Status</th>
                                         <th>Action(s)</th>
                                      </tr>
                                  </tfoot> 
                    </table>  
                </div>
              <?php //} ?>
              <?php //if(validateAccess('material_requisition-approved_requisition',$access)){?>   
                <div class="tab-pane" id="tab_2">
                    <table id="approved_material_req_list" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <?php //if(validateAccess('material_requisition-view_materials',$access)){?>
                                       <th></th>
                                      <?php //} ?> 
                                       <th><input name="select_all" value="1" id="approved_material_req_list-select-all" type="checkbox" /></th>
                                       <th>Requisition Number</th>
                                       <th>Requisition Date</th>
                                       <th>Departments</th>
                                       <th>Status</th>
                                       <th>Action(s)</th>
                                    </tr>
                                  </thead> 
                                  <tbody id="approved_tbody">
                                       <?php if(!empty($approved_material_requisation_list)){?>
                                            <?php foreach($approved_material_requisation_list as $key=> $material_requisation):?>
                                               <tr style="cursor: pointer;" data-row-id="<?php echo $material_requisation['req_id']?>">
                                               <?php //if(validateAccess('material_requisition-view_materials',$access)){?>
                                                 <td class="details-control-<?php echo $material_requisation['req_id']?>">
                                                 </td>
                                               <?php //} ?>
                                                 <td width="50"><input type="checkbox" class="sub_chk" data-id="<?php echo $material_requisation['req_id']?>"/></td>
                                                  <td width="200"><?php echo $material_requisation['req_number']?></td>
                                                  <td><?php echo date("d-m-Y",strtotime($material_requisation['req_date']));?></td>
                                                  <td><?php echo $material_requisation['dep_name'];?></td>
                                                  <td><?php echo ucfirst($material_requisation['approval_flag']);?></td>
                                                  <td>
                                                     <?php //if(validateAccess('material_requisition-view_edit',$access)){?> 
                                                        <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/view_requisation_form/req_id/<?php echo $material_requisation['req_id']?>')"><i class="fa fa-eye"></i></button>
                                                     <?php //} ?>   
                                                  </td>
                                               </tr>    
                                            <?php endforeach;?>  
                                      <?php } ?>
                                  </tbody> 
                                   <tfoot>
                                      <tr>
                                      <?php //if(validateAccess('material_requisition-view_materials',$access)){?>
                                       <th></th>
                                      <?php //} ?> 
                                         <th></th>
                                         <th>Requisition Number</th>
                                         <th>Requisition Date</th>
                                         <th>Departments</th>
                                         <th>Status</th>
                                         <th>Action(s)</th>
                                      </tr>
                                  </tfoot> 
                    </table>
                </div> 
              <?php //} ?>  
              <?php //if(validateAccess('material_requisition-completed_requisition',$access)){?> 
                <div class="tab-pane" id="tab_3">
                     <table id="completed_material_req_list" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <?php //if(validateAccess('material_requisition-view_materials',$access)){?>
                                       <th></th>
                                      <?php //} ?> 
                                       <th><input name="select_all" value="1" id="completed_material_req_list-select-all" type="checkbox" /></th>
                                       <th>Requisition Number</th>
                                       <th>Requisition Date</th>
                                       <th>Departments</th>
                                       <th>Status</th>
                                       <th>Action(s)</th>
                                    </tr>
                                  </thead> 
                                  <tbody>
                                       <?php if(!empty($completed_material_requisation_list)){?>
                                            <?php foreach($completed_material_requisation_list as $key=> $material_requisation):?>
                                               <tr style="cursor: pointer;" data-row-id="<?php echo $material_requisation['req_id']?>">
                                               <?php //if(validateAccess('material_requisition-view_materials',$access)){?>
                                                 <td class="details-control-<?php echo $material_requisation['req_id']?>">
                                                 </td>
                                               <?php //} ?>
                                                 <td width="50"><input type="checkbox" class="sub_chk" data-id="<?php echo $material_requisation['req_id']?>"/></td>
                                                  <td width="200"><?php echo $material_requisation['req_number']?></td>
                                                  <td><?php echo date("d-m-Y",strtotime($material_requisation['req_date']));?></td>
                                                  <td><?php echo $material_requisation['dep_name'];?></td>
                                                  <td><?php echo ucfirst($material_requisation['approval_flag']);?></td>
                                                  <td>
                                                     <?php //if(validateAccess('material_requisition-view_edit',$access)){?> 
                                                        <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/view_requisation_form/req_id/<?php echo $material_requisation['req_id']?>')"><i class="fa fa-eye"></i></button>
                                                     <?php //} ?>   
                                                  </td>
                                               </tr>    
                                            <?php endforeach;?>  
                                       <?php } ?> 
                                  </tbody> 
                                   <tfoot>
                                      <tr>
                                        <?php //if(validateAccess('material_requisition-view_materials',$access)){?>
                                          <th></th>
                                        <?php //} ?> 
                                         <th></th>
                                         <th>Requisition Number</th>
                                         <th>Requisition Date</th>
                                         <th>Departments</th>
                                         <th>Status</th>
                                         <th>Action(s)</th>
                                      </tr>
                                  </tfoot> 
                    </table>
                </div> 
             <?php //} ?>     
            </div>  
        </div>  
  </div>
</section>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/purchase_material_requisation.js"></script>
<script type="text/javascript">
   var tab = '<?php echo $tabs;?>';
   $('.nav-tabs a[href="#'+tab+'"]').tab('show');

   $('#from_requisition_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
   }); // .datepicker("setDate", new Date())

   $('#to_requisition_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
   });//.datepicker("setDate", new Date());
</script>