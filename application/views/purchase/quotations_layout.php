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
  <div class="box" style="border-top: 3px solid #00A65A">
        <div class="box-body">
           <div class="box-header">
                      <div class="pull-left">
                        <?php if(validateAccess('quotation-send_quotation_request',$access)){?>   
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('purchase/add_quotations_form')">Add Quotation Request</a>
                        <?php } ?>   
                      </div>  
           </div>
           <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <?php if(validateAccess('quotation-pending_quotations_list',$access)){?>   
                  <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Request Quotation(s)</a></li>
              <?php } ?> 
              <?php if(validateAccess('quotation-quotations_list',$access)){?>   
                <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">Quotation(s)</a></li>
              <?php } ?>  
              <?php if(validateAccess('quotation-approved_quotations_list',$access)){?>    
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">(Accounts & Purchase) Approved Quotation(s)</a></li>
              <?php } ?>     
            </ul>
            <div class="tab-content">
             <?php if(validateAccess('quotation-pending_quotations_list',$access)){?> 
                <div class="tab-pane active" id="tab_1">
                     
                       <table id="pending_quotation_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="quaotation_list_info">
                          <thead>
                              <th></th>
                              <th>Request Number</th>
                              <th>Request Date</th>
                              <th>Department</th>
                              <th>Vendor(s)</th>
                              <th>Action(s)</th>
                          </thead> 
                          <tbody>
                            <?php if(!empty($pending_quotations)){?>
                                <?php foreach($pending_quotations as $key => $quotation){?>
                                    <tr style="cursor: pointer;" data-row-id="<?php echo $quotation['quo_req_id']?>">
                                        <td class="details-control-<?php echo $quotation['quo_req_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>
                                        <td><?php echo $quotation['quotation_request_number'];?></td>
                                        <td><?php echo date("d-m-Y",strtotime($quotation['request_date']));?></td>
                                        <th><?php echo $quotation['dep_name'];?></th>
                                        <td style="width: 30%">
                                            <?php 
                                                  $supplier_id = explode(',', $quotation['supplier_id']);
                                                  $suppliers_details = $this->purchase_model->get_supplier_details($supplier_id);
                                                  $supplier_firm_pending = array();
                                                  foreach ($suppliers_details as $key => $val) {
                                                     //echo "<pre>"; print_r($val); echo "</pre>";
                                                     array_push($supplier_firm_pending,'<a style="color: #FFFFFF" class="" onclick="vendor_quotations('.$val['supplier_id'].','.$quotation['quo_req_id'].')"><small class="label" style="background-color: #e7b662 !important">'.$val['supp_firm_name'].'</small></a>');
                                                  }
                                                  echo implode('<br>', $supplier_firm_pending);
                                              ?>
                                              <input id="supplier_id_<?php echo $quotation['quo_req_id']?>" type="hidden" name ="supplier_id_<?php echo $quotation['quo_req_id']?>" value="<?php echo $quotation['supplier_id']?>" />
                                        </td>
                                        <td>
                                          <button class="btn btn-sm btn-primary" onclick="resend_quotation_request(<?php echo $quotation['quo_req_id']?>)">Request Send to Vender(s)</button>

                                        </td>
                                    </tr>  
                                <?php }?>
                            <?php } ?>  
                          </tbody> 
                      </table>  
                </div>
             <?php } ?> 
             <?php if(validateAccess('quotation-quotations_list',$access)){?>   
                <div class="tab-pane" id="tab_2">
                     <table id="quotation_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="quaotation_list_info">
                              <thead>
                                  <th></th>
                                  <th>Request Number</th>
                                  <th>Request Date</th>
                                  <th>Department</th>
                                  <th>Waiting for quotation Vendor(s)</th>
                                  <th>Action(s)</th>
                              </thead> 
                              <tbody>
                                <?php if(!empty($quotations)){?>
                                    <?php foreach($quotations as $key => $quotation){?>
                                        <tr style="cursor: pointer;" data-row-id="<?php echo $quotation['quo_req_id']?>">
                                            <td class="details-control-<?php echo $quotation['quo_req_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>
                                            <td><?php echo $quotation['quotation_request_number'];?></td>
                                            <td><?php echo date("d-m-Y",strtotime($quotation['request_date']));?></td>
                                            <th><?php echo $quotation['dep_name'];?></th>
                                            <td style="width: 30%">
                                              <?php 

                                                 $received_bid = $this->purchase_model->get_supplier_quotation(array('quo_req_id'=>$quotation['quo_req_id'],'is_deleted' => '0'));
                                                 $vendors = array();
                                                 foreach ($received_bid as $key => $val) {
                                                    $vendors[] = $val['supplier_id'];
                                                 }
                                                  $supplier_id = explode(',', $quotation['supplier_id']);
                                                  $pending_vendor = array();
                                                  foreach ($supplier_id as $key => $vendor_id) {
                                                      if(!in_array($vendor_id, $vendors)){
                                                         $pending_vendor[] = $vendor_id;
                                                      }
                                                  }

                                                 if(!empty($pending_vendor))
                                                 {
                                                      $suppliers_details = $this->purchase_model->get_supplier_details($pending_vendor);
                                                      $supplier_firm_appr = array();
                                                      foreach ($suppliers_details as $key => $val) {
                                                         array_push($supplier_firm_appr,'<a style="color: #FFFFFF" onclick="vendor_quotations('.$val['supplier_id'].','.$quotation['quo_req_id'].')"><small class="label" style="background-color: #e7b662 !important">'.$val['supp_firm_name'].'</small></a>');
                                                      }
                                                      echo implode('<br>', $supplier_firm_appr);
                                                 }
                                                 
                                              ?>
                                              <input id="supplier_id_<?php echo $quotation['quo_req_id']?>" type="hidden" name ="supplier_id_<?php echo $quotation['quo_req_id']?>" value="<?php echo $quotation['supplier_id']?>" />
                                            </td>
                                              <td>
                                               <?php  if(!empty($pending_vendor)){ ?> 
                                                   <input id="pending_supplier_id_<?php echo $quotation['quo_req_id']?>" type="hidden" name ="pending_supplier_id_<?php echo $quotation['quo_req_id']?>" value="<?php echo implode(',', $pending_vendor);?>" />  
                                                  <button class="btn btn-sm btn-primary" onclick="pending_resend_quotation_request(<?php echo $quotation['quo_req_id']?>)">Resend Request</button>
                                               <?php } ?> 
                                              </td> 
                                        </tr>  
                                    <?php }?>
                                <?php } ?>  
                              </tbody> 
                        </table>
                </div> 
             <?php } ?> 
              <!-- /.tab-pane -->
              <?php if(validateAccess('quotation-approved_quotations_list',$access)){?>    
                <div class="tab-pane" id="tab_3">
                      <table id="approved_quotation_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="quaotation_list_info">
                              <thead>
                                  <th></th>
                                  <th>Request Number</th>
                                  <th>Request Date</th>
                                  <th>Department</th>
                                  <th>Vendor(s)</th>
                              </thead> 
                              <tbody>
                                <?php if(!empty($approved_quotations)){?>
                                    <?php foreach($approved_quotations as $key => $quotation){?>
                                        <tr style="cursor: pointer;" data-row-id="<?php echo $quotation['quo_req_id']?>">
                                            <td class="details-control-<?php echo $quotation['quo_req_id']?>"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td>
                                            <td><?php echo $quotation['quotation_request_number'];?></td>
                                            <td><?php echo date("d-m-Y",strtotime($quotation['request_date']));?></td>
                                            <th><?php echo $quotation['dep_name'];?></th>
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
              <?php } ?>  
             
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
        </div>  
  </div>  
</section>
<?php 
   $this->load->view("purchase/modals/supplier_quotation_details");
   $this->load->view("purchase/modals/add_quotation_purchase_form");
?>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/quotations.js"></script>
<script type="text/javascript">
   var tab = '<?php echo $tabs;?>';
   $('.nav-tabs a[href="#'+tab+'"]').tab('show');

   var quo_req_id = '<?php echo $quo_req_id;?>';

   if(quo_req_id > 0 && tab == 'tab_2'){
      setTimeout(function(){ 
          $('#quotation_list tbody').find('.details-control-'+quo_req_id).trigger('click');
      }, 800);
   }  
</script>