<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        New Purchase Order
        <small> Purchase Order Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li><a href="javascript:void(0)" onclick="load_page('purchase/purchase_order');">Purchase Orders</a></li>
        <li class="active">Add Purchase Order</li>
      </ol>
</section>
 <section class="content">
    <form role="form" id="po_form" action="purchase/save_purchase_order">
    <!-- SELECT2 EXAMPLE -->

      <div class="box box-default" style="border-top: 3px solid #DD4B39">
        <div class="box-header with-border">
          <h3 class="box-title">Add Purchase Order (Quotation)</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse2" style="display: none;"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
  
              <!-- form start -->
                 
                    <div class="box-body">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="po_type">PO Type:</label>
                          <select class="form-control select2" data-show-subtext="true" data-live-search="true" name="po_type" id="po_type" required="required">
                            <option value="material_po" <?php if($po_type == 'material_po'){ echo "selected = 'selected'";}else{ echo '';}?>>Material PO</option>
                            <!-- <option value="general_po" <?php //if($po_type == 'general_po'){ //echo "selected = 'selected'";}else{ //echo '';}?>>General PO</option> -->
                          </select>  
                        </div>

                        <div class="form-group">
                          <label for="po_number">PO Number:</label>
                          <input type="text" class="form-control" id="po_number" name="po_number" required autocomplete="off" value="<?php echo $po_number;?>" readonly/>
                        </div>
                        
                        <div class="form-group">
                          <label for="vendor_name">Vendor Name:</label>
                          <input type="text" class="form-control" id="vendor_name" placeholder="Vendor Name" name="vendor_name" value="<?php echo $supplier_name;?>" autocomplete="off"  required="required" readonly>
                          <input type="hidden" name="supplier_id" value="<?php echo $supplier_id;?>" id="supplier_id" />
                          <button type="button" class="btn btn-primary" style="margin-top: 4px;" onclick="browse_vendor()">Browse</button>
                        </div>
                      </div>
                      <div class="col-md-6">  
                        <div class="form-group">
                          <label for="po_date">PO Date</label>
                          <input type="text" class="form-control" id="po_date" placeholder="Enter Purchase Order Date" name="po_date" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="dep_id">Department:</label>
                            <select class="form-control select2" data-show-subtext="true" data-live-search="true" name="dep_id" id="dep_id" required="required">
                                      <option value="">Select Department</option>
                                      <?php if(!empty($departments)){?>
                                        <?php foreach($departments as $key => $department){?>
                                          <?php
                                               $selected = ""; 
                                               if($dep_id == $department['dep_id']){
                                                    $selected = "selected='selected'";
                                               }
                                          ?>
                                          <option value="<?php echo $department['dep_id']?>" <?php echo $selected;?>><?php echo $department['dep_name']?></option>
                                        <?php }?>
                                        <?php }?>   
                            </select> 
                        </div>
                        <div class="form-group">
                            <label for="quotation_number">Quotation Number:</label>
                            <select class="form-control" id="quotation_number" required="required" name="quotation_id">
                                <option value="">Select Quotation</option>
                                <?php if(!empty($quotations)){?>
                                  <?php foreach($quotations as $key => $quotation){
                                      $selected = '';
                                      if($quotation['quotation_id'] == $quo_id){
                                          $selected = 'selected="selected"';
                                      }
                                  ?>
                                     <option value="<?php echo $quotation['quotation_id']?>" <?php echo $selected;?>><?php echo $quotation['quotation_number'];?></option>
                                  <?php } ?>  
                                <?php }?>
                            </select>
                        </div> 
                      </div>  
                    </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box box-default" style="border-top: 3px solid #DD4B39">
          <div class="box-header with-border">
                    <h3 class="box-title">Materials</h3>
                 </div>
                 <div class="box-body">
                  <div class="row" id="po_material_details">
                      <?php $this->load->view("purchase/sub_views/po_material_details_draft");?>      
                  </div>
                </div>     
      </div>
      
      <div class="box box-default" style="border-top: 3px solid #DD4B39">
        <div class="row">
            <div class="col-sm-6">
                 <?php $this->load->view("purchase/sub_views/po_terms_condition_layout");?>      
            </div>
            <div class="col-sm-6">
                 <?php $this->load->view("purchase/sub_views/po_quotation_totals");?>      
            </div>
         </div>           
      </div>
      <div class="box-footer">
                      <input type="hidden" name="submit_type" value="insert"/>
                      <input type="hidden" name="po_form" value="quotation_form">
                      <div class="col-md-6">
                          <button type="button" class="btn btn-primary" onclick="load_page('purchase/add_purchase_order_form')">Add Purchase Order</button>
                          <button type="button" class="btn btn-primary" onclick="load_page('purchase/purchase_order')" style="margin-right: 3px;">View</button> 
                      </div>
                      <div class="col-md-6">   
                         <button type="submit" class="btn btn-primary pull-right">Save</button>
                      </div>    
      </div>
    </form>
 </section>
 <?php 
    $this->load->view("purchase/modals/supplier_listing");
    $this->load->view("purchase/modals/approved_material_requisition");
 ?>
 <script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>  
 <script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/purchase_order.js"></script>
 <script type="text/javascript">
     $(document).ready(function(){
         $('#po_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
          }).datepicker("setDate", new Date());

          setTimeout(function(){ 
               total_amount();
               total_cgst();
               total_sgst();
               total_igst();
               total_bill_amount();
          }, 3000); 
     });
 </script>