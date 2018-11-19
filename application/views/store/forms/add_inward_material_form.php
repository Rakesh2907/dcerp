<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- <link rel="stylesheet" href="<?php //echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/fixedColumns.bootstrap.min.css"> -->
<section class="content-header">
      <h1>
        Add Materials
        <small> Store Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Inward</li>
        <li><a href="javascript:void(0)" onclick="load_page('store/material_inward');">Inward</a></li>
        <li class="active">Add Materials</li>
      </ol>
</section>
<section class="content">
	<form role="form" id="inward_form" action="store/save_inward_material">
		<div class="box box-default">
			<div class="box-header with-border">
		          <h3 class="box-title">Add Materials</h3>

		          <div class="box-tools pull-right">
		            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse"><i class="fa fa-minus"></i></button>
		            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse2" style="display: none;"><i class="fa fa-plus"></i></button>
		          </div>
        	</div>
        	<div class="box-body">
          		<div class="row">
          			<div class="box-body">
                  <div class="col-md-4">
                    <div class="form-group">
                       <label for="vendor_name">Vendor Name</label>
                       <input class="form-control" type="text" name="vendor_name" id="vendor_name" value="<?php echo $vendor_name;?>" required readonly>
                       <input type="hidden" name="po_vendor_id" id="po_vendor_id" value="<?php echo $po_vendor_id;?>"/>
                       <button type="button" class="btn btn-primary" style="margin-top: 4px;" onclick="browse_vendor()">Browse</button>
                    </div>
                    <div class="form-group">
                       <label for="po_id">PO Number:</label>
                       <select id="po_id" name="po_id" class="form-control" onchange="get_po_details(this.value,'add_form')" required>
                         <?php if(!empty($purchase_order_list)){
                              foreach ($purchase_order_list as $key => $po) {
                                $selected = '';
                                if($po['po_id'] == $po_id){
                                    $selected = 'selected="selected"';
                                }
                         ?>
                                <option value="<?php echo $po['po_id']?>" <?php echo $selected?>><?php echo $po['po_number']?></option>
                        <?php
                            }
                          }  
                        ?>
                       </select>
                    </div>  
                    <div class="form-group">
                              <label for="state_code">State Code:</label>
                              <input type="text" class="form-control" id="state_code" name="state_code" required autocomplete="off" value="<?php echo $state_code?>"/>
                    </div>
                  </div>
          				<div class="col-md-4">
          					    <div class="form-group">
		                          <label for="invoice_date">Invoice/Bill Date:</label>
		                          <input type="text" class="form-control" id="invoice_date" name="invoice_date" required autocomplete="off" value="<?php echo $invoice_date;?>"/>
		                        </div>
          						 <div class="form-group">
                          			 <label for="invoice_number">Invoice/Bill Number:</label>
                         			 <input type="text" class="form-control" id="invoice_number" name="invoice_number" required autocomplete="off" value="<?php echo $invoice_number;?>" placeholder="INVOICE-" />
                        		 </div>
                        		 <div class="form-group">
		                          <label for="chalan_date">Chalan Date:</label>
		                          <input type="text" class="form-control" id="chalan_date" name="chalan_date" required autocomplete="off" value="<?php echo $chalan_date;?>"/>
		                        </div>
                        		 <div class="form-group">
                        		 	<label for="chalan_number">Chalan Number:</label>
                        		 	<input type="text" class="form-control" id="chalan_number" name="chalan_number" required autocomplete="off" value="<?php echo $chalan_number;?>" placeholder="CHALAN-"/>
                        		</div>				
          				</div>
                  <div class="col-md-4">
                      <div class="form-group">
                              <label for="gate_entry_date">Gate Entry Date:</label>
                              <input type="text" class="form-control" id="gate_entry_date" name="gate_entry_date" required autocomplete="off" value="<?php echo $gate_entry_date;?>"/>
                      </div>
                      <div class="form-group">
                              <label for="gate_entry_no">Gate Entry Number:</label>
                              <input type="text" class="form-control" id="gate_entry_no" name="gate_entry_no" required autocomplete="off" value="<?php echo $gate_entry_no;?>" placeholder="GATE-"/>
                      </div>
                      <div class="form-group">
                              <label for="grn_date">GRN Date:</label>
                              <input type="text" class="form-control" id="grn_date" name="grn_date" required autocomplete="off" value="<?php echo $grn_date;?>"/>
                      </div>
                      <div class="form-group">
                              <label for="grn_number">GRN Number:</label>
                              <input type="text" class="form-control" id="grn_number" name="grn_number" required autocomplete="off" value="<?php echo $grn_number;?>" placeholder="GRN-"/>
                      </div>
                  </div> 	
          			</div>	
          		</div>
            </div>			
		</div>
    <div class="box box-default">
        <div class="box-header with-border">
                    <h3 class="box-title">Materials</h3>
                    <button type="button" class="btn btn-primary pull-right" onclick="browse_material('insert',0)">Browse Materials</button>
        </div>
        <div class="box-body" id="selected_material_list">
              <?php $this->load->view("store/sub_views/inward_selected_material_list");?>     
        </div>  
    </div>
    <div class="box box-default">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <?php $this->load->view("store/sub_views/inward_material_totals");?>     
            </div>  
        </div>      
    </div>
    <div class="box-footer">
                      <input type="hidden" name="submit_type" value="insert"/>
                      <input type="hidden" name="inward_form" value="material_inward_form">
                      <div class="col-md-6">
                          <button type="button" class="btn btn-primary" onclick="load_page('store/add_inward_material_form')">Add Materials</button>
                          <button type="button" class="btn btn-primary" onclick="load_page('store/material_inward')" style="margin-right: 3px;">View</button> 
                      </div>
                      <div class="col-md-6">   
                          <button type="submit" class="btn btn-primary pull-right">Save</button>
                      </div>    
      </div>	
	</form>	
</section>
<?php 
    $this->load->view("store/modals/supplier_listing");
    $this->load->view("store/modals/purchase_order_materials");
?>    
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>  
<!-- <script src="<?php //echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.fixedColumns.min.js"></script> -->
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/material_inward.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#invoice_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    }).datepicker("setDate", new Date());

    $('#chalan_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    }).datepicker("setDate", new Date());

    $('#gate_entry_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    }).datepicker("setDate", new Date());

    $('#grn_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    }).datepicker("setDate", new Date());

    setTimeout(function(){ 
               total_amount();
               total_cgst();
               total_sgst();
               total_igst();
               total_bill_amount();
    }, 2000);

	});
</script>