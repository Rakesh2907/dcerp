<section class="content-header">
      <h1>
        New Department
        <small>Department Manager</small>
      </h1>  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Deparments</a></li>
        <li class="active">Add Departments</li>
      </ol>
</section>
 <section class="content">
    <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Departments</h3>

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
                  <form role="form" id="department_form" action="department/save_department">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="dep_name">Department Name</label>
                        <input type="text" class="form-control" id="dep_name" placeholder="Enter Department" required="required" name="dep_name">
                      </div>
                      <div class="form-group">
                        <label for="dep_description">Department Description</label>
                        <input type="text" class="form-control" id="dep_description" placeholder="Enter Department Description" name="dep_description">
                      </div>
                    </div>
                    <div class="box-footer">
                      <input type="hidden" name="submit_type" value="insert" />
                     <div class="col-md-6"> 
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button id="department_unit" type="reset" class="btn btn-primary">Reset</button>
                     </div> 
                     <div class="col-md-6">    
                        <button type="button" class="btn btn-primary pull-right" onclick="load_page('department/index')">View</button>
                     </div>   
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
 <script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/department/department.js"></script>