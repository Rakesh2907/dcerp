<section class="content-header">
      <h1>
         Inward Report
      </h1>
      <i>(Store)</i>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Reports</li>
        <li class="active">Inward</li>
      </ol>
</section>
<section class="content">
	<div class="box" style="border-top: 3px solid #F2B0EB">
		<div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                            <label for="from_requisition_date">From GRN Date:</label>
                            <input type="text" class="form-control" id="from_grn_date" placeholder="From GRN Date" name="from_grn_date" value="<?php //echo $fselected_from_outward_date;?>" required autocomplete="off">
                          </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                            <label for="to_requisition_date">To GRN Date:</label>
                            <input type="text" class="form-control" id="to_grn_date" placeholder="To GRN Date" name="to_grn_date" value="<?php //echo $fselected_to_outward_date;?>" required autocomplete="off">
                </div>
              </div>
              <div class="col-md-4">
               
              </div>
              <!-- /.col -->
            </div>
            <div class="row">
                <div class="box-footer">
                  <button class="btn btn-primary pull-right" onclick="load_page('reports/inward_excel_sheet_store');" style="margin-right: 5px;">Reset</button>
                  <button class="btn btn-primary pull-right" onclick="search_export_inward()" style="margin-right: 5px;">Export</button>
                </div>
            </div>  
        </div>
    </div>		
</section>	
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/reports/reports.js"></script>	
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