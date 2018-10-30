<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
          				<div class="col-md-6">
          					    <div class="form-group">
		                          <label for="invoice_date">Invoice Date:</label>
		                          <input type="text" class="form-control" id="invoice_date" name="invoice_date" required autocomplete="off" value=""/>
		                        </div>
          						 <div class="form-group">
                          			 <label for="invoice_number">Invoice Number:</label>
                         			 <input type="text" class="form-control" id="invoice_number" name="invoice_number" required autocomplete="off" value=""/>
                        		 </div>
                        		 <div class="form-group">
		                          <label for="chalan_date">Chalan Date:</label>
		                          <input type="text" class="form-control" id="chalan_date" name="chalan_date" required autocomplete="off" value=""/>
		                        </div>
                        		 <div class="form-group">
                        		 	<label for="chalan_number">Chalan Number:</label>
                        		 	<input type="text" class="form-control" id="chalan_number" name="chalan_number" required autocomplete="off" value=""/>
                        		</div>	
                        		<div class="form-group">
		                          <label for="gate_entry_no">Gate Entry Number:</label>
		                          <input type="text" class="form-control" id="gate_entry_no" name="gate_entry_no" required autocomplete="off" value=""/>
		                        </div>
                        		<div class="form-group">
                        		 	<label for="gate_entry_date">Gate Entry Date:</label>
                        		 	<input type="text" class="form-control" id="gate_entry_date" name="gate_entry_date" required autocomplete="off" value=""/>
                        		</div>	
          				</div>
          				<div class="col-md-6">
          					<div class="form-group">
          						 <label for="po_id">PO Number:</label>
          						 <select id="po_id" name="po_id" class="form-control" onchange="get_vendor(this.value)">
          						 	<option value="">Select PO</option>
          						 	<?php foreach($po_list as $key => $purchase_order){?>
          						 		<option value="<?php echo $purchase_order->po_id?>"><?php echo $purchase_order->po_number?></option>
          						 	<?php } ?>
          						 </select>
          					</div>
          					<div class="form-group">
          						 <label for="vendor_name">Vendor Name</label>
          						 <input class="form-control" type="text" name="vendor_name" id="vendor_name" value="" readonly>
          						 <input type="hidden" name="po_vendor_id" id="po_vendor_id" value=""/>
          					</div>
          					 <div class="form-group">
		                          <label for="grn_date">GRN Date:</label>
		                          <input type="text" class="form-control" id="grn_date" name="grn_date" required autocomplete="off" value=""/>
		                     </div>
                        	<div class="form-group">
                        		 	<label for="grn_number">GRN Number:</label>
                        		 	<input type="text" class="form-control" id="grn_number" name="grn_number" required autocomplete="off" value=""/>
                        	</div>	
                        	<div class="form-group">
                        		 	<label for="state_code">State Code:</label>
                        		 	<input type="text" class="form-control" id="state_code" name="state_code" required autocomplete="off" value=""/>
                        	</div>
          				</div>	
          			</div>	
          		</div>
            </div>			
		</div>	
	</form>	
</section>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>  
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/store/material_inward.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#invoice_date, #chalan_date, #gate_entry_date, #grn_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
          }).datepicker("setDate", new Date());
	   });
</script>