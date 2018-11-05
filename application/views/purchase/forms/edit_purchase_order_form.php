<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Edit Purchase Order
        <small> Purchase Order Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li><a href="javascript:void(0)" onclick="load_page('purchase/purchase_order');">Purchase Orders</a></li>
        <li class="active">Edit Purchase Order</li>
      </ol>
</section>
 <section class="content">
  <?php if($purchase_order[0]['approval_flag'] != 'approved'){ ?>  
    <form role="form" id="po_form" action="purchase/save_purchase_order">
  <?php } ?>    
    <!-- SELECT2 EXAMPLE -->

      <div class="box box-default" style="border-top: 3px solid #DD4B39">
        <div class="box-header with-border">
          <?php 
            if($purchase_order[0]['po_form'] == 'requisition_form'){
                $poform = '(Requisition)';
            }else if($purchase_order[0]['po_form'] == 'quotation_form'){
                $poform = '(Quotation)';
            }else if($purchase_order[0]['po_form'] == 'general_form'){
                $poform = '(General)';
            }

          ?>
          <h3 class="box-title">Edit Purchase Order <?php echo $poform;?></h3>

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
                          <select class="form-control select2" data-show-subtext="true" data-live-search="true" name="po_type" id="po_type" required="required" <?php echo $disabled?>>
                            <option value="material_po" <?php if($purchase_order[0]['po_type'] == 'material_po'){ echo "selected = 'selected'";}else{ echo '';}?>>Material PO</option>
                            <option value="general_po" <?php if($purchase_order[0]['po_type'] == 'general_po'){ echo "selected = 'selected'";}else{ echo '';}?>>General PO</option>
                          </select>  
                        </div>

                        <div class="form-group">
                          <label for="po_number">PO Number:</label>
                          <input type="text" class="form-control" id="po_number" name="po_number" autocomplete="off" value="<?php echo $purchase_order[0]['po_number'];?>" readonly required="required"/>
                        </div>
                        
                        <div class="form-group">
                          <label for="vendor_name">Vendor Name:</label>
                          <input type="text" class="form-control" id="vendor_name" placeholder="Vendor Name" name="vendor_name" value="<?php echo $supplier_name;?>" autocomplete="off" readonly required="required">
                          <input type="hidden" name="supplier_id" value="<?php echo $purchase_order[0]['supplier_id'];?>" id="supplier_id" />
                          <?php if($purchase_order[0]['approval_flag'] == 'pending' && $form == 'requisation'){ ?>
                              <button type="button" class="btn btn-primary" style="margin-top: 4px;" onclick="browse_vendor()">Browse</button>
                          <?php }?>  
                        </div>
                        
                      </div>
                      <div class="col-md-6">  
                        <div class="form-group">
                          <label for="po_date">PO Date</label>
                          <input type="text" class="form-control" id="po_date" placeholder="Enter Purchase Order Date" name="po_date" autocomplete="off" required="required" value="<?php echo date('d-m-Y', strtotime($purchase_order[0]['po_date']))?>" <?php echo $disabled?>>
                        </div>
                        <div class="form-group">
                            <label for="dep_id">Department:</label>
                            <select class="form-control select2" data-show-subtext="true" data-live-search="true" name="dep_id" id="dep_id" required="required" disabled="disabled">
                                      <option value="">Select Department</option>
                                      <?php if(!empty($departments)){?>
                                        <?php foreach($departments as $key => $department){?>
                                          <?php
                                               $selected = ""; 
                                               if($purchase_order[0]['dep_id'] == $department['dep_id']){
                                                    $selected = "selected='selected'";
                                               }
                                          ?>
                                          <option value="<?php echo $department['dep_id']?>" <?php echo $selected;?>><?php echo $department['dep_name']?></option>
                                        <?php }?>
                                        <?php }?>   
                            </select> 
                        </div>
                        <?php if($form == 'requisation'){?>
                           <div class="form-group">
                              <label for="requisition_number">Requisition Number:</label>
                              <input type="text" class="form-control" id="requisition_number" value="<?php echo $req_number;?>" placeholder="Requisition Number" name="requisition_number" autocomplete="off" readonly required="required">
                              <input type="hidden" name="req_id" value="<?php echo $req_id;?>" id="req_id" />
                              <!-- <button type="button" class="btn btn-primary" style="margin-top: 4px;" onclick="browse_requisition()">Browse</button> -->
                          </div>
                       <?php }?> 
                       <?php if($form == 'quotation'){?>
                          <div class="form-group">
                              <label for="quotation_number">Quotation Number:</label>
                              <input type="text" class="form-control" id="quotation_number" value="<?php echo $quo_number;?>" placeholder="Quotation Number" name="requisition_number" autocomplete="off" readonly required="required">
                              <input type="hidden" name="quotation_id" value="<?php echo $quotation_id;?>" id="quotation_id" />
                          </div>
                        <?php }?> 
                        <?php if($form == 'general'){?>
                            <div class="form-group">
                                <label for="cat_id">Category:</label>
                                <select class="form-control select2" data-show-subtext="true" data-live-search="true" name="cat_id" id="cat_id" required="required" disabled="disabled">
                                <option value="">Select Category</option>
                                <?php if(!empty($general_category)){?>
                                    <?php foreach($general_category as $key => $category){
                                            $selected = '';

                                            if($cat_id == $category['cat_id']){
                                              $selected = 'selected="selected"';
                                            }
                                    ?>
                                        <option value="<?php echo $category['cat_id']?>" <?php echo $selected;?>><?php echo $category['cat_name']?></option>
                                    <?php } ?>
                                <?php } ?>
                                </select>
                            </div>  
                        <?php } ?>  
                      </div>  
                    </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div id="po_content">
        <div class="box box-default" style="border-top: 3px solid #DD4B39">
            <div class="box-header with-border">
                      <h3 class="box-title">Materials</h3>
                   </div>
                   <div class="box-body">
                  <div class="row">
                      <?php $this->load->view("purchase/sub_views/po_material_details");?>      
                  </div>
            </div>     
        </div>
        
        <div class="box box-default" style="border-top: 3px solid #DD4B39">
          <div class="row">
              <div class="col-sm-6">
                   <?php $this->load->view("purchase/sub_views/po_terms_condition_edit_layout");?>      
              </div>
              <div class="col-sm-6">
                   <?php $this->load->view("purchase/sub_views/po_edit_totals");?>      
              </div>
           </div>           
        </div>
        <div class="box-footer">
                    
                          <input type="hidden" name="submit_type" value="edit"/>
                          <input type="hidden" name="po_form" value="<?php echo $purchase_order[0]['po_form'];?>">
                          <input type="hidden" name="po_id" value="<?php echo $po_id;?>">
                          <input type="hidden" name="amendment" value="<?php echo $amend;?>">
                          <div class="col-md-6">   
                            <?php if($purchase_order[0]['po_form'] == 'requisition_form'){
                                  $add_purchase_order_link = 'purchase/add_purchase_order_requisation_form';
                                  $view_purchase_order = 'purchase/purchase_order_requisition';
                            }else if($purchase_order[0]['po_form'] == 'quotation_form'){
                                  $add_purchase_order_link = 'purchase/add_purchase_order_quotation_form';
                                  $view_purchase_order = 'purchase/purchase_order_quotation';
                            }else if($purchase_order[0]['po_form'] == 'general_form'){
                                   $add_purchase_order_link = 'purchase/add_purchase_order_form';
                                   $view_purchase_order = 'purchase/purchase_order';
                            }?>
                              <button type="button" class="btn btn-primary" onclick="load_page('<?php echo $add_purchase_order_link;?>')">Add Purchase Order</button>
                              <button type="button" class="btn btn-primary" onclick="load_page('<?php echo $view_purchase_order;?>')" style="margin-right: 3px;">View</button>
                          </div>

                          <div class="col-md-6">
                             <?php if($purchase_order[0]['approval_flag'] == 'pending'){ ?>
                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                             <?php }else{
                                 if($purchase_order[0]['po_form'] == 'quotation_form')
                                 {
                                    $onclick = 'onclick="send_po_quotation('.$purchase_order[0]['po_id'].','.$purchase_order[0]['supplier_id'].','.$purchase_order[0]['quotation_id'].')"';
                                 }else if($purchase_order[0]['po_form'] == 'requisition_form'){
                                    $onclick = 'onclick="send_po_requisation('.$purchase_order[0]['po_id'].','.$purchase_order[0]['supplier_id'].')"';
                                 }else{
                                    $onclick = 'onclick="send_po_general('.$purchase_order[0]['po_id'].','.$purchase_order[0]['supplier_id'].')"';
                                 }
                              ?>
                                <?php if($purchase_order[0]['status'] != 'completed') { ?>
                                    <button type="button" class="btn btn-primary pull-right" <?php echo $onclick;?>>Send PO</button>
                             <?php }
                              } ?>    
                          </div>    
        </div>
      </div>
    <?php if($purchase_order[0]['approval_flag'] != 'approved'){ ?>    
     </form>
    <?php } ?>  
 </section>
 <?php 
    $this->load->view("purchase/modals/supplier_listing");
    $this->load->view("purchase/modals/approved_material_requisition");
 ?>
 <script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
 <script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script> 
 <script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/purchase_order.js"></script>
 <script type="text/javascript">
     $(document).ready(function(){
         $('#po_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
          });
     });
 </script>