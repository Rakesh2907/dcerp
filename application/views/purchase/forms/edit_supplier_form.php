<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/bootstrap/dist/css/bootstrap-toggle.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Edit Vendor
        <small>Vendor Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li><a href="javascript:void(0)" onclick="load_page('purchase/supplier');">Vendor</a></li>
        <li class="active">Edit Vendor</li>
      </ol>
</section>
 <section class="content">
    <!-- SELECT2 EXAMPLE -->
      <div class="box box-default" style="border-top: 3px solid #F39C12">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $supp_firm_name;?> - Edit Vendor</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse2" style="display: none;"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
             <?php if(validateAccess('vendor-edit_tab',$access)){?>   
                  <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Vendor</a></li>
             <?php } ?>
                  <li><a href="#tab_7" data-toggle="tab" aria-expanded="false">Others</a></li>
                  <li><a href="#tab_8" data-toggle="tab" aria-expanded="false">Bank Details</a></li> 
                  <li><a href="#tab_9" data-toggle="tab" aria-expanded="false">QC Verified</a></li>  
              <?php if(validateAccess('vendor-quotation_tab',$access)){?>  
                  <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Quotation(s)</a></li>
              <?php } ?> 
              <?php if(validateAccess('vendor-purchase_order_tab',$access)){?>   
                  <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="true">Purchase Order(s)</a></li>
              <?php } ?> 
              <?php if(validateAccess('vendor-material_tab',$access)){?>   
                  <li class="" id="sup_materials"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Material(s)</a></li>
              <?php } ?>
              <?php if(validateAccess('vendor-invoice_tab',$access)){?>   
                  <li class="" id="vendor_invoice"><a href="#tab_6" data-toggle="tab" aria-expanded="false">Invoice(s)</a></li>
              <?php } ?>   
              <?php if(validateAccess('vendor-payments_tab',$access)){?>      
                  <li class="" id="vendor_payments"><a href="#tab_5" data-toggle="tab" aria-expanded="false">Payment(s)</a></li>
              <?php } ?> 
            </ul>
            <div class="tab-content">
             <?php if(validateAccess('vendor-edit_tab',$access)){?>   
              <div class="tab-pane active" id="tab_1">
                <div class="row">
                      <div class="col-md-6">
                          <?php if($pre_supplier_id > 0){?>
                                      <button type="button" class="btn" onclick="load_page('purchase/edit_supplier_form/<?php echo $pre_supplier_id;?>')">Pre</button>
                          <?php } ?>
                      </div> 
                      <div class="col-md-6">
                            <?php if($next_supplier_id > 0){?>
                                      <button type="button" class="btn pull-right" onclick="load_page('purchase/edit_supplier_form/<?php echo $next_supplier_id;?>')">Next</button>
                            <?php } ?> 
                      </div> 
                </div>  
                <div class="row">
                    <!-- form start -->
                        <form role="form" id="supplier_form" action="purchase/save_supplier">
                          <div class="box-body">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="supp_firm_name">Vendor Firm Name</label>
                                <input type="text" class="form-control" id="supp_firm_name" placeholder="Enter supplier name" name="supp_firm_name" required autocomplete="off" value="<?php echo $supp_firm_name;?>" />
                              </div>
                              <div class="form-group">
                                <label for="supp_contact_person">Contact Person</label>
                                <input type="text" class="form-control" id="supp_contact_person" placeholder="Enter Contact Person" name="supp_contact_person" required autocomplete="off" value="<?php echo $supp_contact_person;?>">
                              </div>
                              <div class="form-group">
                                <label for="supp_address">Firm Address</label>
                                <textarea class="form-control" rows = "5" cols = "50" name="supp_address" id="supp_address" required><?php echo $supp_address;?></textarea>
                              </div>
                              <div class="form-group">
                                  <label for="supp_contact_designation">Designation</label>
                                  <input type="text" class="form-control" id="supp_contact_designation" placeholder="Enter Designation" name="supp_contact_designation" autocomplete="off" value="<?php echo $supp_contact_designation;?>">
                              </div>
                              <div class="form-group">
                                  <label for="supp_country">Country</label>
                                  <input type="text" class="form-control" id="supp_country" placeholder="Enter Country" name="supp_country" value="<?php echo $supp_country;?>" >
                              </div>
                              <div class="form-group">
                                  <label for="supp_state">State</label>
                                  <input type="text" class="form-control" id="supp_state" placeholder="Enter State" name="supp_state" value="<?php echo $supp_state;?>">
                              </div>
                              <div class="form-group">
                                  <label for="supp_city">City</label>
                                  <input type="text" class="form-control" id="supp_city" placeholder="Enter City" name="supp_city" value="<?php echo $supp_city;?>" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label for="supp_pin">Postal Code</label>
                                  <input type="text" class="form-control" id="supp_pin" placeholder="Enter Postal Code" name="supp_pin" value="<?php echo $supp_pin;?>">
                              </div>
                            </div>
                            <div class="col-md-6"> 
                               <div class="form-group">
                                  <label for="supp_phone1">Phone1</label>
                                  <input type="text" class="form-control" id="supp_phone1" placeholder="Enter Phone1" name="supp_phone1" value="<?php echo $supp_phone1;?>" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label for="supp_phone2">Phone2</label>
                                  <input type="text" class="form-control" id="supp_phone2" placeholder="Enter Phone2" name="supp_phone2" value="<?php echo $supp_phone2;?>" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label for="supp_mobile">Mobile1</label>
                                  <input type="text" class="form-control" id="supp_mobile" placeholder="Enter Mobile1" name="supp_mobile" value="<?php echo $supp_mobile;?>" required autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label for="supp_mobile2">Mobile2</label>
                                  <input type="text" class="form-control" id="supp_mobile2" placeholder="Enter Mobile2" name="supp_mobile2" value="<?php echo $supp_mobile2;?>" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label for="supp_fax">Fax Number</label>
                                  <input type="text" class="form-control" id="supp_fax" placeholder="Enter Fax Number" name="supp_fax" value="<?php echo $supp_fax;?>" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label for="supp_email">Email</label>
                                  <input type="text" class="form-control" id="supp_email" placeholder="Enter Email" name="supp_email" value="<?php echo $supp_email;?>" required autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label for="supp_website">Website</label>
                                  <input type="text" class="form-control" id="supp_website" placeholder="Enter Website" name="supp_website" value="<?php echo $supp_website;?>" autocomplete="off">
                              </div>
                              <div class="form-group">
                                    <label for="supp_description">Vendor Description</label>
                                   <textarea class="form-control" rows = "3" cols = "50" name="supp_description" id="supp_description" required><?php echo $supp_description;?></textarea>
                              </div>
                              <div class="form-group">
                                 <label for="department">Assign Department:</label> 
                                 <select id="department_dropdown" class="form-control select2" multiple="multiple" data-placeholder="Select Departments"
                            style="width: 100%;" name="dep_id[]" required="required">
                                     <?php 
                                       $dep_id = explode(',', $assign_dep_id);
                                       foreach($departments as $key => $department){
                                        $selected = '';
                                        if(isset($assign_dep_id))
                                        {
                                            if(in_array($department['dep_id'], $dep_id)){
                                                  $selected = 'selected="selected"';
                                            }
                                        }
                                     ?>
                                      <option value="<?php echo $department['dep_id']?>" <?php echo $selected;?>><?php echo $department['dep_name']?></option>
                                     <?php }?>  
                                 </select>
                              </div>  
                            </div>  
                          </div>
                          <div class="box-footer">
                            <input type="hidden" name="submit_type" value="edit"/>
                            <input type="hidden" name="supplier_id" value="<?php echo $supplier_id?>"/>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary pull-left" onclick="load_page('purchase/add_supplier_form')" style="margin-right: 4px;">Add Vendor</button>
                                <button type="button" class="btn btn-primary pull-left" id="tab_material" style="margin-right: 4px;">Materials</button>
                                <button type="button" class="btn btn-primary pull-left" id="view_categories" onclick="load_page('purchase/supplier');" style="margin-right: 4px;">View</button>
                                
                            </div>  
                            <div class="col-md-6">   
                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                            </div>   
                          </div>
                        </form>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
             <?php } ?> 
              <!-- /.tab-pane -->
              <?php if(validateAccess('vendor-material_tab',$access)){?> 
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-md-12">
                             <button type="button" class="btn btn-primary" id="get_material">Browse Material</button>
                             <button type="button" class="btn btn-primary" id="add_material_supp" onclick="load_page('purchase/add_material_form/supplier_id/<?php echo $supplier_id?>')">Add Material</button>
                        </div>
                    </div>
                    <div class="row" id="vendor_assign_material"> 
                          <?php $this->load->view("purchase/sub_views/supplier_assign_material_list");?> 
                    </div>
                </div>
              <?php } ?>    
              <!-- /.tab-pane -->
              <?php if(validateAccess('vendor-quotation_tab',$access)){?>  
                <div class="tab-pane" id="tab_3">
                    <?php if(!empty($quotation_list)) {?>
                         <table id="quotation_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="quaotation_list_info">
                             <thead>
                                <th></th>
                                <th>ID</th>
                                <th>Quotation Number</th>
                                <th>Credit Days</th>
                                <th>Accounts Status</th>
                                <th>Purchase Status</th>
                                <th>Total Bill Amount</th>
                                <th>Approval By A/c</th>
                                <th>Approval By Purchase</th>
                             </thead>
                             <tbody>
                                <?php foreach($quotation_list as $key => $quotations) {
                                    if(isset($quotations['approval_by_account'])){
                                          $users = $this->user_model->get_user_details($quotations['approval_by_account']);
                                          $user_name_account = $users[0]['name'];
                                    }else{
                                          $user_name_account = '';
                                    }

                                    if(isset($quotations['approval_by_purchase'])){
                                          $users = $this->user_model->get_user_details($quotations['approval_by_purchase']);
                                          $user_name_purchase = $users[0]['name'];
                                    }else{
                                          $user_name_purchase = '';
                                    }
                                ?>
                                  <tr style="cursor: pointer;" data-row-id="<?php echo $quotations['quotation_id']?>">
                                    <td class="details-control-<?php echo $quotations['quotation_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>
                                    <td><?php echo $quotations['quotation_id']?></td>
                                    <td><?php echo $quotations['quotation_number']?></td>
                                    <td><?php echo $quotations['credit_days']?></td>
                                    <td><?php echo ucfirst($quotations['status_account'])?></td>
                                    <td><?php echo ucfirst($quotations['status_purchase'])?></td>
                                    <td><?php echo $quotations['total_amt']?></td>
                                    <td><?php echo $user_name_account;?></td>
                                    <td><?php echo $user_name_purchase;?></td>
                                  </tr>
                                <?php }?>
                             </tbody>
                         </table> 
                      
                    <?php }?>  
                </div>
              <?php } ?>
              <?php if(validateAccess('vendor-purchase_order_tab',$access)){?>   
                <div class="tab-pane" id="tab_4">
                     <?php if(!empty($po_listing)) {?>
                        <table id="po_list" class="table table-bordered table-striped">
                            <thead>
                               <tr>
                                 <th></th>
                                 <th><input name="select_all" value="1" id="po_list-select-all" type="checkbox" /></th>
                                 <th>PO Number</th>
                                 <th>PO Date</th>
                                 <th>Departments</th>
                                 <th>Vendor</th>
                                 <th>Status</th>
                                 <th>PO</th>
                                 <th>Total Amt</th>
                                 <th>Action(s)</th>
                               </tr>
                            </thead>  
                              <tbody>
                                  <?php if(!empty($po_listing)){?>
                                    <?php foreach($po_listing as $key=> $purchase_order):?>
                                       <tr style="cursor: pointer;" data-row-id="<?php echo $purchase_order['po_id']?>">
                                          <td class="details-control-<?php echo $purchase_order['po_id']?>">
                                              <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" />
                                          </td>
                                          <td width="50"><input type="checkbox" class="sub_chk" data-id="<?php echo $purchase_order['po_id']?>"/></td>
                                          <td width="200"><?php echo $purchase_order['po_number']?></td>
                                          <td><?php echo date("d-m-Y",strtotime($purchase_order['po_date']));?></td>
                                          <td><?php echo $purchase_order['dep_name'];?></td>
                                          <td><?php echo $purchase_order['supp_firm_name'];?></td>
                                          <td><?php echo ucfirst($purchase_order['approval_flag']);?></td>
                                          <td>
                                            <?php 
                                                if($purchase_order['po_form'] == 'requisition_form'){
                                                    echo 'Requisition';
                                                }
                                                if($purchase_order['po_form'] == 'quotation_form'){
                                                    echo 'Quotation';
                                                }
                                            ?>
                                          </td>
                                          <td><?php echo $purchase_order['total_bill_amt'];?></td>
                                          <td>
                                            <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_purchase_order_form/po_id/<?php echo $purchase_order['po_id']?>')"><i class="fa fa-eye"></i></button>
                                          </td>
                                       </tr> 
                                    <?php endforeach;?>    
                                  <?php } ?>  
                              </tbody>  
                        </table> 
                     <?php }?>   
                </div>
              <?php } ?>  
              <?php if(validateAccess('vendor-payments_tab',$access)){?>      
                <div class="tab-pane" id="tab_5">
                    vendor payments
                </div>
              <?php } ?>
              <?php if(validateAccess('vendor-invoice_tab',$access)){?>  
                  <div class="tab-pane" id="tab_6">
                      <?php if(!empty($invoice_listing)) {?>
                         <table id="invoice_list" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>PO Number</th>
                                  <th>Bill Date (Invoice Date)</th>
                                  <th>Bill Number (Invoice No.)</th>
                                  <th>Amount</th>
                                  <th>Invoice/Bill</th>
                                  <th>Action(s)</th>
                                </tr>  
                              </thead> 
                          <tbody>
                          <?php 
                            if(!empty($invoice_listing)){
                              foreach ($invoice_listing as $key => $value) {
                                 // echo "<pre>"; print_r($value); echo "</pre>";
                           ?> 
                              <tr style="cursor: pointer;" data-row-id="<?php echo $value['inward_id']?>">
                                <td class="details-control-<?php echo $value['inward_id']?>">
                                   <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" />
                                </td>
                                <td><?php echo $value['po_number']?></td>
                                <td><?php echo date("d-m-Y", strtotime($value['invoice_date']))?></td>
                                <td><?php echo $value['invoice_number'];?></td>
                                <td><?php echo $value['total_bill_amt'];?></td>
                                <td>
                                  <?php 
                                   if(!empty($value['invoice_file'])){
                                     $path_parts = pathinfo($value['invoice_file']);
                                     if($path_parts['extension'] == 'pdf'){
                                        $img = $this->config->item("cdn_css_image").'dist/img/adobe-pdf-icon.png';
                                     }else if($path_parts['extension'] == 'png'){
                                        $img = $this->config->item("cdn_css_image").'dist/img/png-icon.png';
                                     }else{
                                        $img = $this->config->item("cdn_css_image").'dist/img/jpeg-icon.png';
                                     }
                                  ?>
                                   <a href="<?php echo $value['invoice_file']?>" target="_blank"><img src="<?php echo $img;?>" style="width: 7%"/></a>
                                  <?php } ?>  
                                </td>
                                <td><button class="btn" type="button" onclick="view_payments_plan(<?php echo $value['inward_id']?>,<?php echo $supplier_id?>)">Payments Plan</button></td>
                              </tr>  
                          <?php
                             } 
                           } ?>
                     </tbody> 
                    </table> 
                      <?php } ?>  
                 </div>
              <?php } ?>  
                  <div class="tab-pane" id="tab_7">
                      <div class="row">
                          <form role="form" id="supplier_others_form" action="purchase/save_supplier_registration">
                            <div class="box-body">
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="gst_number">GST Number:</label>
                                      <input type="text" class="form-control" id="gst_number" placeholder="Enter GST Number" name="gst_number" autocomplete="off" value="<?php echo $gst_number;?>" />
                                   </div>
                                   <div class="form-group">
                                      <label for="permanent_regi_number">Permanent Registration Number:</label> 
                                      <input type="text" class="form-control" id="permanent_regi_number" placeholder="Enter Permanent Registration Number" name="permanent_regi_number" autocomplete="off" value="<?php echo $supplier_details[0]['permanent_regi_number']?>" /><button type="button" onclick="generate_reg_number(<?php echo $supplier_id?>)">Generate Number</button>
                                   </div>
                                   <div class="form-group">
                                      <label for="supp_contact_person">Non-Disclosure Agreement(NDA) Sign:</label>
                                      <?php if($nda_sign == 'yes'){
                                          $style = 'margin-top: 7px;margin-left: 4px;color: white;';
                                          $checked = "checked";
                                      }else{
                                          $style = 'margin-top: 7px;margin-left: 34px;color: white;';
                                          $checked = '';
                                      } ?>

                                      <label class="switch">
                                          <input type="checkbox" <?php echo $checked;?> id="nda_sign" name="nda_sign">
                                          <span class="slider round" onclick="nda_change_status()"><div id="nda_agree" style="<?php echo $style?>"><?php echo ucfirst($nda_sign);?></div></span>
                                      </label>
                                   </div>
                                </div>  
                            </div>
                            <div class="box-footer">
                               <input type="hidden" name="supplier_id" value="<?php echo $supplier_id?>"/>
                               <div class="col-md-12">
                                  <button type="submit" class="btn btn-primary pull-right">Save</button>
                               </div> 
                            </div>  
                          </form>  
                      </div>  
                  </div>
                  <div class="tab-pane" id="tab_8">
                       <div class="row">
                          <form role="form" id="supplier_bank_detail_form" action="purchase/save_supplier_bank_detail">
                            <div class="box-body">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="customer_name">Name:</label>
                                    <input type="text" class="form-control" id="customer_name" placeholder="Enter Name" name="customer_name" autocomplete="off" value="<?php echo $supplier_details[0]['bank_account_name']?>" required/>
                                  </div>
                                  <div class="form-group">
                                    <label for="account_num">Account Number:</label>
                                    <input type="text" class="form-control" id="account_num" placeholder="Enter Account Number" name="account_num" autocomplete="off" value="<?php echo $supplier_details[0]['bank_account_num']?>" required/>
                                  </div>
                                  <div class="form-group">
                                    <label for="bank_name">Bank Name:</label>
                                    <input type="text" class="form-control" id="bank_name" placeholder="Enter Bank Name" name="bank_name" autocomplete="off" value="<?php echo $supplier_details[0]['bank_name']?>" />
                                  </div> 
                                  <div class="form-group">
                                    <label for="bank_ifsc">Bank IFSC Code:</label>
                                    <input type="text" class="form-control" id="bank_ifsc" placeholder="Enter Bank IFSC Code" name="bank_ifsc" autocomplete="off" value="<?php echo $supplier_details[0]['bank_ifsc']?>" required/>
                                  </div> 
                                </div>  
                            </div>  
                            <div class="box-footer">
                               <input type="hidden" name="supplier_id" value="<?php echo $supplier_id?>"/>
                               <div class="col-md-12">
                                  <button type="submit" class="btn btn-primary pull-right">Save</button>
                               </div> 
                            </div>
                          </form>  
                       </div> 
                  </div>
                  <div class="tab-pane" id="tab_9">
                      <div class="row">
                        <form role="form" id="supplier_verified" action="purchase/save_supplier_verified">
                           <div class="box-body">
                             <div class="col-md-6">
                                <div class="form-group">
                                      <label for="supp_contact_person">Quality Control Verified:</label>
                                      <?php if($qc_verified == 'yes'){
                                          $style = 'margin-top: 7px;margin-left: 4px;color: white;';
                                          $checked = "checked";
                                      }else{
                                          $style = 'margin-top: 7px;margin-left: 34px;color: white;';
                                          $checked = '';
                                      } ?>

                                      <label class="switch">
                                          <input type="checkbox" <?php echo $checked;?> id="qc_verified" name="qc_verified">
                                          <span class="slider round" onclick="qc_change_status()"><div id="qc_verified_status" style="<?php echo $style?>"><?php echo ucfirst($qc_verified);?></div></span>
                                      </label>
                                </div> 
                                <div class="form-group">
                                     <label for="qc_remark">Remarks/Notes:</label>
                                     <textarea class="form-control" rows="3" cols="50" name="qc_remark" id="qc_remark"><?php echo $qc_remark?></textarea>
                                </div> 
                             </div> 
                           </div>
                           <div class="box-footer">
                               <input type="hidden" name="supplier_id" value="<?php echo $supplier_id?>"/>
                               <div class="col-md-12">
                                  <button type="submit" class="btn btn-primary pull-right">Save</button>
                               </div> 
                          </div> 
                        </form>  
                      </div>  
                  </div>     
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
        </div>  
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <input type="hidden" name="active_tab" value="<?php echo $tabs;?>">
 </section>
 <?php
    $this->load->view("purchase/modals/assign_material_supplier");
    $this->load->view("purchase/modals/view_payments_plan_modal");
 ?>
 
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/bootstrap/dist/js/bootstrap-toggle.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>  
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/supplier.js"></script>