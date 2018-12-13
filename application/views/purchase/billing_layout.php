<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Billing Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class="active">Billing</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
      <!-- /.box -->
        <div class="box" style="border-top: 3px solid #F39C12">
           
            <!-- /.box-header -->
            <div class="box-body">
              <div class="nav-tabs-custom">
              	<ul class="nav nav-tabs">
              		 <?php if(validateAccess('vendor-invoice_tab',$access)){?>   
                  			<li class="" id="vendor_invoice"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Invoice(s)</a></li>
              		 <?php } ?>   
		            <?php if(validateAccess('vendor-payments_tab',$access)){?>      
		                  <li class="" id="vendor_payments"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Payment(s)</a></li>
		            <?php } ?> 
              	</ul>
              	<div class="tab-content">
              		<?php if(validateAccess('vendor-payments_tab',$access)){?>      
		                <div class="tab-pane" id="tab_2">
		                    vendor payments
		                </div>
              		<?php } ?>
              <?php if(validateAccess('vendor-invoice_tab',$access)){?>  
                  <div class="tab-pane active" id="tab_1">
                      <?php if(!empty($invoice_listing)) {?>
                         <table id="invoice_list" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>PO Number</th>
                                  <th>Vendor</th>
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
                                <td><?php echo $value['supp_firm_name']?></td>
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
                                <td><button class="btn" type="button" onclick="set_billing_date(<?php echo $value['inward_id']?>,<?php echo $value['vendor_id']?>)">Add Payments Plan</button></td>
                              </tr>  
                          <?php
                             } 
                           } ?>
                     </tbody> 
                    </table> 
                      <?php } ?>  
                 </div>
              <?php } ?>
              	</div>	
              </div>	
            </div>
            <!-- /.box-body -->
          </div>
    </section>
 <?php   
 	  $this->load->view("purchase/modals/payments_plan_modal");
 ?>    
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/billing.js"></script>