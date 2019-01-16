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
	<div class="box" style="border-top: 3px solid #F2B0EB">
		<div class="box-header">
			<div class="pull-left">
				<a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('store/add_batch_wise_outward_form')">Add Outward</a>
			</div>	
		</div>
    <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                            <label for="from_requisition_date">From Outward Date:</label>
                            <input type="text" class="form-control" id="from_outward_date" placeholder="From Outward Date" name="from_outward_date" value="<?php echo $fselected_from_outward_date;?>" required autocomplete="off">
                          </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                            <label for="to_requisition_date">To Outward Date:</label>
                            <input type="text" class="form-control" id="to_outward_date" placeholder="To Outward Date" name="to_outward_date" value="<?php echo $fselected_to_outward_date;?>" required autocomplete="off">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Department:</label>
                  <select class="form-control select2" name="dep_id" id="filter_dep_id">
                     <option value="0">Select Department</option> 
                     <?php foreach ($departments as $key => $value) { 
                            if($value['dep_id'] == $selected_dep_id){
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
                  <button class="btn btn-primary pull-right" onclick="load_page('store/outward_batch_wise');" style="margin-right: 5px;">Reset</button>
                  <button class="btn btn-primary pull-right" onclick="search_export()" style="margin-right: 5px;">Export</button>
                  <button class="btn btn-primary pull-right" onclick="search_outward()" style="margin-right: 5px;">Search</button>
                </div>
            </div>  
        </div>	
    <div class="box-body">
       <table id="material_outward_list" class="table table-bordered table-striped">
          <thead>
            <tr>
                    <th></th>
                    <th>Outward Number</th>
                    <th>Issue/Outward Date</th>
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
                      <td><?php echo date('d-m-Y', strtotime($value['outward_date']))?></td>
                      <td><?php echo $value['dep_name']?></td>
                      <td><?php echo $value['req_number']?></td>
                      <td><button style="cursor: pointer;" data-toggle="modal" onclick="load_page('store/edit_batch_wise_outward_form/outward_id/<?php echo $value['outward_id']?>')" rel="tooltip" class="edit_button_class" title="Edit/ Update"><i class="fa fa-pencil"></i></button></td>
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
<script type="text/javascript">
  $('#from_outward_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
   }); // .datepicker("setDate", new Date())

   $('#to_outward_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
   });//.datepicker("setDate", new Date());
</script>  