<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Purchase Order (Quotation)
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Purchase Order</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <div class="box" style="border-top: 3px solid #DD4B39">
         <div class="box-header">
            <div class="pull-left">
              <?php if(validateAccess('PurchaseOrder-add_new_po_button',$access)){ ?> 
                  <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('purchase/add_purchase_order_quotation_form')">Add Purchase Order</a>
              <?php } ?>    
            </div>  
         </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
               <?php if(validateAccess('PurchaseOrder-pending_purchase_order',$access)){ ?> 
                  <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Pending PO(s)</a></li>
               <?php } ?> 
               <?php if(validateAccess('PurchaseOrder-approved_purchase_order',$access)){ ?>   
                  <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Approved PO(s)</a></li>
               <?php } ?> 
               <?php if(validateAccess('PurchaseOrder-completed_purchase_order',$access)){ ?>     
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Completed PO(s)</a></li>
              <?php } ?>  
            </ul> 
            <div class="tab-content">
               <?php if(validateAccess('PurchaseOrder-pending_purchase_order',$access)){ ?>  
              <div class="tab-pane active" id="tab_1">
                <table id="pending_po_list" class="table table-bordered table-striped">
                    <thead>
                       <tr>
                         <th></th>
                         <th><input name="select_all" value="1" id="pending_po_list-select-all" type="checkbox" /></th>
                         <th>PO Number</th>
                         <th>PO Date</th>
                         <th>Departments</th>
                         <th>Vendor</th>
                         <th>Status</th>
                         <th>Total Amt</th>
                         <th>Action(s)</th>
                       </tr>
                    </thead>  
                    <tbody>
                        <?php if(!empty($pending_po)){?>
                          <?php foreach($pending_po as $key=> $purchase_order):?>
                             <tr style="cursor: pointer;" data-row-id="<?php echo $purchase_order['po_id']?>">
                                <td class="details-control-<?php echo $purchase_order['po_id']?>">
                                    <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" />
                                </td>
                                <td width="50"><input type="checkbox" class="sub_chk" data-id="<?php echo $purchase_order['po_id']?>"/></td>
                                <td width="200"><?php echo $purchase_order['po_number']?></td>
                                <td><?php echo date("d-m-Y",strtotime($purchase_order['po_date']));?></td>
                                <td><?php echo $purchase_order['dep_name'];?></td>
                                <td><?php echo $purchase_order['supp_firm_name'];?></td>
                                <td>
                                      <?php
                                          if(validateAccess('PurchaseOrder-approval_flag',$access)){ ?>
                                            <select class="form-control" id="approval_flag_<?php echo $purchase_order['po_id']?>" onchange="change_po_status(this.value,<?php echo $purchase_order['po_id']?>)">
                                                <option value="pending">Pending</option>
                                                <option value="approved">Approved</option>
                                            </select>
                                          <?php }else{ 
                                              echo ucfirst($purchase_order['approval_flag']);
                                          }
                                      ?>      
                                </td>
                                <td><?php echo $purchase_order['total_bill_amt'];?></td>
                                <td>
                                 <?php if(validateAccess('PurchaseOrder-pending_purchase_order_edit',$access)){ ?>  
                                    <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_purchase_order_form/po_id/<?php echo $purchase_order['po_id']?>')"><i class="fa fa-pencil"></i></button>
                                 <?php } ?> 
                                 <?php if(validateAccess('PurchaseOrder-pending_purchase_order_delete',$access)){ ?> 
                                            <button style="cursor: pointer;" onclick="remove_purchase_order(<?php echo $purchase_order['po_id']?>)"><i class="fa fa-close"></i></button>
                                 <?php } ?>  
                                </td>
                             </tr> 
                          <?php endforeach;?>    
                        <?php } ?>  
                    </tbody>  
                </table>  
              </div> 
            <?php } ?>
            <?php if(validateAccess('PurchaseOrder-approved_purchase_order',$access)){ ?>   
              <div class="tab-pane" id="tab_2">
                   <table id="approved_po_list" class="table table-bordered table-striped">
                    <thead>
                       <tr>
                         <th></th>
                         <th><input name="select_all" value="1" id="approved_po_list-select-all" type="checkbox" /></th>
                         <th>PO Number</th>
                         <th>PO Date</th>
                         <th>Departments</th>
                         <th>Vendor</th>
                         <th>Status</th>
                         <th>Total Amt</th>
                         <th>Action(s)</th>
                       </tr>
                    </thead>  
                    <tbody>
                        <?php if(!empty($approved_po)){?>
                          <?php foreach($approved_po as $key=> $purchase_order):?>
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
                                <td><?php echo $purchase_order['total_bill_amt'];?></td>
                                <td>
                                  <?php if(validateAccess('PurchaseOrder-approved_purchase_order_view',$access)){ ?>  
                                      <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_purchase_order_form/po_id/<?php echo $purchase_order['po_id']?>')"><i class="fa fa-eye"></i></button>
                                  <?php } ?>
                                  <?php if(validateAccess('PurchaseOrder-approved_purchase_order_delete',$access)){ ?> 
                                            <button style="cursor: pointer;" onclick="remove_purchase_order(<?php echo $purchase_order['po_id']?>)"><i class="fa fa-close"></i></button>
                                  <?php } ?> 
                                  <button type="button" class="btn btn-box-tool" onclick="print_po(<?php echo $purchase_order['po_id'];?>)"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-print.png"></button>     
                                </td>
                             </tr> 
                          <?php endforeach;?>    
                        <?php } ?>  
                    </tbody>  
                </table>
              </div> 
            <?php } ?> 
             <?php if(validateAccess('PurchaseOrder-completed_purchase_order',$access)){ ?>     
              <div class="tab-pane" id="tab_3">
                  <table id="completed_po_list" class="table table-bordered table-striped">
                    <thead>
                       <tr>
                         <th></th>
                         <th><input name="select_all" value="1" id="completed_po_list-select-all" type="checkbox" /></th>
                         <th>PO Number</th>
                         <th>PO Date</th>
                         <th>Departments</th>
                         <th>Vendor</th>
                         <th>Status</th>
                         <th>Total Amt</th>
                         <th>Action(s)</th>
                       </tr>
                    </thead>  
                    <tbody>
                        <?php if(!empty($completed_po)){?>
                          <?php foreach($completed_po as $key=> $purchase_order):?>
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
                                <td><?php echo $purchase_order['total_bill_amt'];?></td>
                                <td>
                                  <?php if(validateAccess('PurchaseOrder-completed_purchase_order_view',$access)){ ?>
                                    <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_purchase_order_form/po_id/<?php echo $purchase_order['po_id']?>')"><i class="fa fa-eye"></i></button>
                                  <?php } ?>
                                  <?php if(validateAccess('PurchaseOrder-completed_purchase_order_delete',$access)){ ?> 
                                            <button style="cursor: pointer;" onclick="remove_purchase_order(<?php echo $purchase_order['po_id']?>)"><i class="fa fa-close"></i></button>
                                 <?php } ?>
                                 <button type="button" class="btn btn-box-tool" onclick="print_po(<?php echo $purchase_order['po_id'];?>)"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl-print.png"></button>  
                                </td>
                             </tr> 
                          <?php endforeach;?>    
                        <?php } ?>  
                    </tbody>  
                </table>
              </div> 
             <?php } ?>  
            </div> 
        </div>  

       </div>
    </section>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/purchase_order.js"></script>