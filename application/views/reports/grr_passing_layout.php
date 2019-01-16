<section class="content-header">
      <h1>
         GRR Passing | Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Report</li>
        <li class="active">GRR Passing</li>
      </ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                                <label for="from_requisition_date">From GRN Date:</label>
                                <input type="text" class="form-control" id="from_grn_date" placeholder="From GRN Date" name="from_grn_date" value="<?php echo $fselected_from_grn_date;?>" required autocomplete="off">
                              </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                                <label for="to_requisition_date">To GRN Date:</label>
                                <input type="text" class="form-control" id="to_grn_date" placeholder="To GRN Date" name="to_grn_date" value="<?php echo $fselected_to_grn_date;?>" required autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Vendor:</label>
                      
                      <select class="form-control select2" name="vendor_id" id="filter_vendor_id">
                              <option value="0">Select Vendor</option>
                         <?php foreach ($suppliers as $key => $value) { 
                                if($vendor_id == $value['supplier_id']){
                                  $selected = 'selected="selected"';
                                }else{
                                  $selected = '';
                                }
                          ?>
                                <option value="<?php echo $value['supplier_id']?>" <?php echo $selected;?>><?php echo $value['supp_firm_name'];?></option>
                         <?php } ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <div class="row">
                    <div class="box-footer">
                        <button class="btn btn-primary pull-right" onclick="search_export()">Export</button>
                    </div>
                </div>  
        </div> 
	</div>	
</section>	
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/reports/grr_passing.js"></script>
<script type="text/javascript">
   $('#from_grn_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
   }); // .datepicker("setDate", new Date())

   $('#to_grn_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
   });//.datepicker("setDate", new Date());
</script>  