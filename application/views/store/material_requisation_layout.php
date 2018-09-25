<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
         Material Requisation
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Store</li>
        <li class="active">Material Requisation</li>
      </ol>
</section>
<section class="content">
  <div class="box">
  		<div class="box-header">
              <div class="pull-left">
                 <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('store/add_requisation_form')">Add Requisation</a>
                <!--  <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="delete_all_supplier">Delete</a>
                 <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="export_supplier">Export</a> -->
              </div>  
        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Pending Requisation(s)</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Approved Requisation(s)</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Completed Requisation(s)</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <table id="material_req_list" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                     <th></th>
                                     <th><input name="select_all" value="1" id="material_req_list-select-all" type="checkbox" /></th>
                                     <th>Requisation Number</th>
                                     <th>Requisation Date</th>
                                     <th>Departments</th>
                                     <th>Status</th>
                                     <th>Action(s)</th>
                                  </tr>
                                </thead> 
                                <tbody>
                                    <?php if(!empty($pending_material_requisation_list)){?>
                                          <?php foreach($pending_material_requisation_list as $key=> $material_requisation):
                                          ?>
                                             <tr style="cursor: pointer;" data-row-id="<?php echo $material_requisation['req_id']?>">
                                               <td class="details-control-<?php echo $material_requisation['req_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>

                                               <td width="50"><input type="checkbox" class="sub_chk" data-id="<?php echo $material_requisation['req_id']?>"/></td>
                                                <td width="200"><?php echo $material_requisation['req_number']?></td>
                                                <td><?php echo date("d-m-Y",strtotime($material_requisation['req_date']));?></td>
                                                <td><?php echo $material_requisation['dep_name'];?></td>
                                                <td><?php echo ucfirst($material_requisation['approval_flag']);?></td>
                                                <td>
                                                  <?php
                                                    if($sess_dep_id === $material_requisation['dep_id']){
                                                          $icon = 'fa fa-pencil';
                                                    }else{
                                                          $icon = 'fa fa-eye';
                                                    } 
                                                  ?>
                                                  <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('store/edit_requisation_form/req_id/<?php echo $material_requisation['req_id']?>')"><i class="<?php echo $icon;?>"></i></button></td>
                                             </tr>    
                                          <?php endforeach;?>  
                                    <?php } ?>  
                                </tbody> 
                                 <tfoot>
                                    <tr>
                                       <th></th>
                                       <th></th>
                                       <th>Requisation Number</th>
                                       <th>Requisation Date</th>
                                       <th>Departments</th>
                                       <th>Status</th>
                                       <th>Action(s)</th>
                                    </tr>
                                </tfoot> 
                  </table>  
              </div> 
              <div class="tab-pane" id="tab_2">
                  <table id="approved_material_req_list" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                     <th></th>
                                     <th><input name="select_all" value="1" id="approved_material_req_list-select-all" type="checkbox" /></th>
                                     <th>Requisation Number</th>
                                     <th>Requisation Date</th>
                                     <th>Departments</th>
                                     <th>Status</th>
                                     <th>Action(s)</th>
                                  </tr>
                                </thead> 
                                <tbody>
                                    <?php if(!empty($approved_material_requisation_list)){?>
                                          <?php foreach($approved_material_requisation_list as $key=> $material_requisation):?>
                                             <tr style="cursor: pointer;" data-row-id="<?php echo $material_requisation['req_id']?>">
                                               <td class="details-control-<?php echo $material_requisation['req_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>

                                               <td width="50"><input type="checkbox" class="sub_chk" data-id="<?php echo $material_requisation['req_id']?>"/></td>
                                                <td width="200"><?php echo $material_requisation['req_number']?></td>
                                                <td><?php echo date("d-m-Y",strtotime($material_requisation['req_date']));?></td>
                                                <td><?php echo $material_requisation['dep_name'];?></td>
                                                <td><?php echo ucfirst($material_requisation['approval_flag']);?></td>
                                                <td><button style="cursor: pointer;" data-toggle="modal" onclick="load_page('store/edit_requisation_form/req_id/<?php echo $material_requisation['req_id']?>')"><i class="fa fa-eye"></i></button></td>
                                             </tr>    
                                          <?php endforeach;?>  
                                    <?php } ?>  
                                </tbody> 
                                 <tfoot>
                                    <tr>
                                       <th></th>
                                       <th></th>
                                       <th>Requisation Number</th>
                                       <th>Requisation Date</th>
                                       <th>Departments</th>
                                       <th>Status</th>
                                       <th>Action(s)</th>
                                    </tr>
                                </tfoot> 
                  </table>
              </div> 
              <div class="tab-pane" id="tab_3">
                   <table id="completed_material_req_list" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                     <th></th>
                                     <th><input name="select_all" value="1" id="completed_material_req_list-select-all" type="checkbox" /></th>
                                     <th>Requisation Number</th>
                                     <th>Requisation Date</th>
                                     <th>Departments</th>
                                     <th>Status</th>
                                     <th>Action(s)</th>
                                  </tr>
                                </thead> 
                                <tbody>
                                    <?php if(!empty($completed_material_requisation_list)){?>
                                          <?php foreach($completed_material_requisation_list as $key=> $material_requisation):?>
                                             <tr style="cursor: pointer;" data-row-id="<?php echo $material_requisation['req_id']?>">
                                               <td class="details-control-<?php echo $material_requisation['req_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>

                                               <td width="50"><input type="checkbox" class="sub_chk" data-id="<?php echo $material_requisation['req_id']?>"/></td>
                                                <td width="200"><?php echo $material_requisation['req_number']?></td>
                                                <td><?php echo date("d-m-Y",strtotime($material_requisation['req_date']));?></td>
                                                <td><?php echo $material_requisation['dep_name'];?></td>
                                                <td><?php echo ucfirst($material_requisation['approval_flag']);?></td>
                                                <td><button style="cursor: pointer;" data-toggle="modal" onclick="load_page('store/edit_requisation_form/req_id/<?php echo $material_requisation['req_id']?>')"><i class="fa fa-eye"></i></button></td>
                                             </tr>    
                                          <?php endforeach;?>  
                                    <?php } ?>  
                                </tbody> 
                                 <tfoot>
                                    <tr>
                                       <th></th>
                                       <th></th>
                                       <th>Requisation Number</th>
                                       <th>Requisation Date</th>
                                       <th>Departments</th>
                                       <th>Status</th>
                                       <th>Action(s)</th>
                                    </tr>
                                </tfoot> 
                  </table>
              </div> 
            </div>  
        </div>  
  </div>
</section>
<?php 
   $this->load->view("store/modals/material_notes");
?>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/material_requisation.js"></script>
<script type="text/javascript">
   var tab = '<?php echo $tabs;?>';
   $('.nav-tabs a[href="#'+tab+'"]').tab('show');
</script>