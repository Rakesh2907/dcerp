<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Quotations
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class="active">Quotations</li>
      </ol>
</section>

    <!-- Main content -->
<section class="content">
  <div class="box">
        <div class="box-body">
           <div class="box-header">
                      <div class="pull-left">
                           <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('purchase/add_quotations_form')">Send Quotation Request</a>
                      </div>  
           </div>
           <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Pending Quotation(s)</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Approved Quotation(s)</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                   
                     <table id="quotation_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="quaotation_list_info">
                        <thead>
                            <th></th>
                            <th>Request Number</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Vendor(s)</th>
                        </thead> 
                        <tbody>
                          <?php if(!empty($pending_quotations)){?>
                              <?php foreach($pending_quotations as $key => $quotation){?>
                                  <tr style="cursor: pointer;" data-row-id="<?php echo $quotation['quo_req_id']?>">
                                      <td class="details-control-<?php echo $quotation['quo_req_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>
                                      <td><?php echo $quotation['quotation_request_number'];?></td>
                                      <td><?php echo date("d-m-Y",strtotime($quotation['request_date']));?></td>
                                      <td><?php echo ucfirst($quotation['approval_status']);?></td>
                                      <td style="width: 30%">
                                          <?php 
                                                $supplier_id = explode(',', $quotation['supplier_id']);
                                                $suppliers_details = $this->purchase_model->get_supplier_details($supplier_id);
                                                $supplier_firm_pending = array();
                                                foreach ($suppliers_details as $key => $val) {
                                                   array_push($supplier_firm_pending,$val['supp_firm_name']);
                                                }
                                                echo implode(', ', $supplier_firm_pending);
                                            ?>
                                            <input id="supplier_id_<?php echo $quotation['quo_req_id']?>" type="hidden" name ="supplier_id_<?php echo $quotation['quo_req_id']?>" value="<?php echo $quotation['supplier_id']?>" />
                                      </td>
                                  </tr>  
                              <?php }?>
                          <?php } ?>  
                        </tbody> 
                    </table>  
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                    <table id="approved_quotation_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="quaotation_list_info">
                            <thead>
                                <th></th>
                                <th>Request Number</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>supplier(s)</th>
                            </thead> 
                            <tbody>
                              <?php if(!empty($approved_quotations)){?>
                                  <?php foreach($approved_quotations as $key => $quotation){?>
                                      <tr style="cursor: pointer;" data-row-id="<?php echo $quotation['quo_req_id']?>">
                                          <td class="details-control-<?php echo $quotation['quo_req_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>
                                          <td><?php echo $quotation['quotation_request_number'];?></td>
                                          <td><?php echo date("d-m-Y",strtotime($quotation['request_date']));?></td>
                                          <td><?php echo ucfirst($quotation['approval_status']);?></td>
                                          <td style="width: 30%">
                                            <?php 
                                                $supplier_id = explode(',', $quotation['supplier_id']);
                                                $suppliers_details = $this->purchase_model->get_supplier_details($supplier_id);
                                                $supplier_firm_appr = array();
                                                foreach ($suppliers_details as $key => $val) {
                                                   array_push($supplier_firm_appr,$val['supp_firm_name']);
                                                }
                                                echo implode(', ', $supplier_firm_appr);
                                            ?>
                                            <input id="supplier_id_<?php echo $quotation['quo_req_id']?>" type="hidden" name ="supplier_id_<?php echo $quotation['quo_req_id']?>" value="<?php echo $quotation['supplier_id']?>" />
                                          </td>
                                      </tr>  
                                  <?php }?>
                              <?php } ?>  
                            </tbody> 
                      </table>
              </div>
             
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
        </div>  
  </div>  
</section>
<?php 
   $this->load->view("purchase/modals/supplier_quotation_details");
?>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/quotations.js"></script>
<script type="text/javascript">
   var tab = '<?php echo $tabs;?>';
   $('.nav-tabs a[href="#'+tab+'"]').tab('show');
</script>