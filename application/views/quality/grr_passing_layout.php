<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
         GRR Passing
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Quality</li>
        <li class="active">GRR Passing</li>
      </ol>
</section>
<section class="content">
	<div class="box" style="border-top: 3px solid #F2C291;">
        <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                                <label for="from_requisition_date">From GRN Date:</label>
                                <input type="text" class="form-control" id="from_grn_date" placeholder="From GRN Date" name="from_grn_date" value="<?php echo $fselected_from_grn_date;?>" required autocomplete="off">
                              </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                                <label for="to_requisition_date">To GRN Date:</label>
                                <input type="text" class="form-control" id="to_grn_date" placeholder="To GRN Date" name="to_grn_date" value="<?php echo $fselected_to_grn_date;?>" required autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Vendor:</label>
                      
                      <select class="form-control select2" name="vendor_id" id="filter_vendor_id">
                              <option value="0">Select Vendor</option>
                         <?php foreach ($suppliers as $key => $value) { 
                                if($vendor_id == $value['supplier_id']){
                                  $selected = 'selected="selected"';
                                }else{
                                  $selected = '';
                                }
                          ?>
                                <option value="<?php echo $value['supplier_id']?>" <?php echo $selected;?>><?php echo $value['supp_firm_name'];?></option>
                         <?php } ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <div class="row">
                    <div class="box-footer">
                        <button class="btn btn-primary pull-right" onclick="search_material_inward()">Search</button>
                    </div>
                </div>  
        </div> 

        <div class="box-body">
             <table id="material_inward_list" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <!-- <th>PO Number</th>
                    <th>Bill Date (Invoice Date)</th>
                    <th>Bill Number (Invoice No.)</th> -->
                    <th>GRN Date</th>
                    <th>GRN Number</th>
                    <th>Vendor Name</th>
                    <th>Quality Status</th>
                    <th>Payment Status</th>
                    <th>Bill/Invoice</th>
                    <th>Action(s)</th>
                  </tr>  
                </thead> 
                 <tbody>
                    <?php 
                      if(!empty($inward_materials)){
                        foreach ($inward_materials as $key => $value) {
                           // echo "<pre>"; print_r($value); echo "</pre>";
                     ?> 
                        <tr style="cursor: pointer;" data-row-id="<?php echo $value['inward_id']?>">
                          <td class="details-control-<?php echo $value['inward_id']?>">
                             <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" />
                          </td>
                          <!-- <td><?php //echo $value['po_number']?></td>
                          <td><?php //echo date("d-m-Y", strtotime($value['invoice_date']))?></td>
                          <td><?php //echo $value['invoice_number'];?></td> -->
                          <td><?php echo date("d-m-Y", strtotime($value['grn_date']));?></td>
                          <td><?php echo $value['grn_number'];?></td>
                          <td><?php echo $value['supp_firm_name'];?></td>
                          <td>
                            <?php
                              if($value['quality_status'] == 'check'){
                                 echo '<small class="label" style="background-color: #098e1b;color:#FFFFFF">QC Checked</small>';
                              }else{
                                 echo '<small class="label" style="background-color: #F51212;color:#FFFFFF">Unchecked</small>';  
                              } 
                            ?>
                          </td>
                          <td>
                            <?php
                                if($value['payment_status'] == 'paid'){
                                   echo '<small class="label" style="background-color: #098e1b;color:#FFFFFF">Paid By A/c</small>';
                                }else{
                                   echo '<small class="label" style="background-color: #F51212;color:#FFFFFF">Unpaid</small>';
                                } 
                            ?>
                          </td>
                          <td>
                             <?php   
                               if(!empty($value['invoice_file']))
                               { 
                                   $ext = pathinfo(basename($value['invoice_file']), PATHINFO_EXTENSION);
                                   if($ext == 'pdf'){
                                    $icon_path = $this->config->item("cdn_css_image").'/dist/img/adobe-pdf-icon.png';
                                   }else if($ext == 'png'){
                                    $icon_path = $this->config->item("cdn_css_image").'/dist/img/png-icon.png';
                                   }else{
                                    $icon_path = $this->config->item("cdn_css_image").'/dist/img/jpeg-icon.png';
                                   }    
                                ?>  
                                  <a href="<?php echo $value['invoice_file']?>" target="_blank"><img src="<?php echo $icon_path;?>" style="width: 25px;"/></a>
                          <?php } ?>
                          </td>
                          <td>
                            <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('quality/view_inward_material_form/inward_id/<?php echo $value['inward_id']?>')" rel="tooltip" class="edit_button_class" title="View">QC</button>
                          </td>
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
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/quality/quality.js"></script>
<script type="text/javascript">
   $('#from_grn_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
   }); // .datepicker("setDate", new Date())

   $('#to_grn_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
   });//.datepicker("setDate", new Date());
</script>  