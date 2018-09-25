<section class="content-header">
      <h1>
        New Units
        <small>Unit Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Units</a></li>
        <li class="active">Add Units</li>
      </ol>
</section>
 <section class="content">
    <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Units</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse2" style="display: none;"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <!-- form start -->
                  <form role="form" id="units_form" action="purchase/save_unit">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="unit">Units</label>
                        <input type="text" class="form-control" id="unit" placeholder="Enter Unit" required="required" name="unit">
                      </div>
                      <div class="form-group">
                        <label for="unit_description">Unit Description</label>
                        <input type="text" class="form-control" id="unit_description" placeholder="Enter Unit Description" name="unit_description">
                      </div>
                    </div>
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Save & Close</button>
                      <button id="reset_unit" type="reset" class="btn btn-primary">Reset</button>
                      <button type="button" class="btn btn-primary" onclick="load_page('purchase/unit')">Cancel</button>
                    </div>
                  </form>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
 </section>
 <script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
 <script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/units.js"></script>