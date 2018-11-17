<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- <link rel="stylesheet" href="<?php //echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/fixedColumns.bootstrap.min.css"> -->
<section class="content-header">
      <h1>
        Edit Materials
        <small> Store Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="javascript:void(0)" onclick="load_page('store/material_inward');">Inward</a></li>
        <li class="active">Edit Materials</li>
      </ol>
</section>
<section class="content">
	<form role="form" id="inward_form" action="store/save_inward_material">
		<div class="box box-default">
			<div class="box-header with-border">
		          <h3 class="box-title">Edit Materials</h3>

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
                       <input class="form-control" type="text" name="vendor_name" id="vendor_name" value="<?php echo $inward_material[0]['supp_firm_name'];?>" required readonly>
                       <input type="hidden" name="po_vendor_id" id="po_vendor_id" value="<?php echo $inward_material[0]['vendor_id'];?>"/>
                    </div>
                    <div class="form-group">
                       <label for="po_id">PO Number:</label>
                       <input class="form-control" type="text" value="<?php echo $inward_material[0]['po_number'];?>" readonly>
                       <input type="hidden" name="po_id" id="po_id" value="<?php echo $inward_material[0]['po_id'];?>"/>
                    </div>  
                    <div class="form-group">
                              <label for="state_code">State Code:</label>
                              <input type="text" class="form-control" id="state_code" name="state_code" required autocomplete="off" value="<?php echo $inward_material[0]['state_code'];?>"/>
                    </div>
                  </div>
          				<div class="col-md-4">
          					    <div class="form-group">
		                          <label for="invoice_date">Invoice/Bill Date:</label>
		                          <input type="text" class="form-control" id="invoice_date" name="invoice_date" required autocomplete="off" value="<?php echo date("d-m-Y", strtotime($inward_material[0]['invoice_date']));?>"/>
		                        </div>
          						 <div class="form-group">
                          			 <label for="invoice_number">Invoice/Bill Number:</label>
                         			 <input type="text" class="form-control" id="invoice_number" name="invoice_number" required autocomplete="off" value="<?php echo $inward_material[0]['invoice_number'];?>" placeholder="INVOICE-" />
                        		 </div>
                        		 <div class="form-group">
		                          <label for="chalan_date">Chalan Date:</label>
		                          <input type="text" class="form-control" id="chalan_date" name="chalan_date" required autocomplete="off" value="<?php echo date("d-m-Y", strtotime($inward_material[0]['chalan_date']));?>"/>
		                        </div>
                        		 <div class="form-group">
                        		 	<label for="chalan_number">Chalan Number:</label>
                        		 	<input type="text" class="form-control" id="chalan_number" name="chalan_number" required autocomplete="off" value="<?php echo $inward_material[0]['chalan_number'];?>" placeholder="CHALAN-"/>
                        		</div>				
          				</div>
                  <div class="col-md-4">
                      <div class="form-group">
                              <label for="gate_entry_date">Gate Entry Date:</label>
                              <input type="text" class="form-control" id="gate_entry_date" name="gate_entry_date" required autocomplete="off" value="<?php echo date("d-m-Y", strtotime($inward_material[0]['gate_entry_date']));?>"/>
                      </div>
                      <div class="form-group">
                              <label for="gate_entry_no">Gate Entry Number:</label>
                              <input type="text" class="form-control" id="gate_entry_no" name="gate_entry_no" required autocomplete="off" value="<?php echo $inward_material[0]['gate_entry_number'];?>" placeholder="GATE-"/>
                      </div>
                      <div class="form-group">
                              <label for="grn_date">GRN Date:</label>
                              <input type="text" class="form-control" id="grn_date" name="grn_date" required autocomplete="off" value="<?php echo date("d-m-Y", strtotime($inward_material[0]['grn_date']));?>"/>
                      </div>
                      <div class="form-group">
                              <label for="grn_number">GRN Number:</label>
                              <input type="text" class="form-control" id="grn_number" name="grn_number" required autocomplete="off" value="<?php echo $inward_material[0]['grn_number'];?>" placeholder="GRN-"/>
                      </div>
                  </div> 	
          			</div>	
          		</div>
            </div>			
		</div>
    <div class="box box-default">
        <div class="box-header with-border">
                    <h3 class="box-title">Materials</h3>
                    <button type="button" class="btn btn-primary pull-right" onclick="browse_material('edit')">Browse Materials</button>
        </div>
        <div class="box-body" id="selected_material_list">
              <?php $this->load->view("store/sub_views/edit_inward_selected_material_list");?>     
        </div>  
    </div>
    <div class="box box-default">
        <div class="row">
            <div class="col-sm-6">
                <?php $this->load->view("store/sub_views/inward_material_others");?>  
            </div>
            <div class="col-sm-6">
                <?php $this->load->view("store/sub_views/inward_material_totals");?>     
            </div>  
        </div>      
    </div>
    <div class="box-footer">
                      <input type="hidden" name="submit_type" value="edit"/>
                      <input type="hidden" name="inward_form" value="material_inward_form">
                      <input type="hidden" name="inward_id" value="<?php echo $inward_id;?>">
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
    //$this->load->view("store/modals/add_sub_material_form");
    $this->load->view("store/modals/inward_batchwise_items");
    $this->load->view("store/modals/purchase_order_materials");
?>    
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>  
<!-- <script src="<?php //echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.fixedColumns.min.js"></script> -->
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/material_inward.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#invoice_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    });

    $('#chalan_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    });

    $('#gate_entry_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    });

    $('#grn_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy'
    });

    setTimeout(function(){ 
               total_amount();
               total_cgst();
               total_sgst();
               total_igst();
               total_bill_amount();
    }, 2000);

	});
</script>