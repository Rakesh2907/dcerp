<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Purchase Order (Requisition)
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Purchase Order</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <div class="box">
         <div class="box-header">
            <div class="pull-left">
                <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('purchase/add_purchase_order_requisation_form')">Add Purchase Order</a>
            </div>  
         </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Pending PO(s)</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Approved PO(s)</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Completed PO(s)</a></li>
            </ul> 
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <table id="pending_po_list" class="table table-bordered table-striped">
                    <thead>
                       <tr>
                         <th></th>
                         <th><input name="select_all" value="1" id="pending_po_list-select-all" type="checkbox" /></th>
                         <th>PO Number</th>
                         <th>PO Date</th>
                         <th>Departments</th>
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
                                <td><?php echo ucfirst($purchase_order['approval_flag']);?></td>
                                <td><?php echo $purchase_order['total_bill_amt'];?></td>
                                <td>
                                  <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_purchase_order_form/po_id/<?php echo $purchase_order['po_id']?>')"><i class="fa fa-pencil"></i></button>
                                </td>
                             </tr> 
                          <?php endforeach;?>    
                        <?php } ?>  
                    </tbody>  
                </table>  
              </div> 
              <div class="tab-pane" id="tab_2">
                   <table id="approved_po_list" class="table table-bordered table-striped">
                    <thead>
                       <tr>
                         <th></th>
                         <th><input name="select_all" value="1" id="approved_po_list-select-all" type="checkbox" /></th>
                         <th>PO Number</th>
                         <th>PO Date</th>
                         <th>Departments</th>
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
                                <td><?php echo ucfirst($purchase_order['approval_flag']);?></td>
                                <td><?php echo $purchase_order['total_bill_amt'];?></td>
                                <td>
                                  <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_purchase_order_form/po_id/<?php echo $purchase_order['po_id']?>')"><i class="fa fa-pencil"></i></button>
                                </td>
                             </tr> 
                          <?php endforeach;?>    
                        <?php } ?>  
                    </tbody>  
                </table>
              </div> 
              <div class="tab-pane" id="tab_3">
                  <table id="completed_po_list" class="table table-bordered table-striped">
                    <thead>
                       <tr>
                         <th></th>
                         <th><input name="select_all" value="1" id="completed_po_list-select-all" type="checkbox" /></th>
                         <th>PO Number</th>
                         <th>PO Date</th>
                         <th>Departments</th>
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
                                <td><?php echo ucfirst($purchase_order['approval_flag']);?></td>
                                <td><?php echo $purchase_order['total_bill_amt'];?></td>
                                <td>
                                  <button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_purchase_order_form/po_id/<?php echo $purchase_order['po_id']?>')"><i class="fa fa-pencil"></i></button>
                                </td>
                             </tr> 
                          <?php endforeach;?>    
                        <?php } ?>  
                    </tbody>  
                </table>
              </div>  
            </div> 
        </div>  

       </div>
    </section>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/purchase_order.js"></script>