<section class="content-header">
      <h1>
        Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>/dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class=""><a href="javascript:void(0)" class="" onclick="load_page('purchase/category');">Category</a></li>
        <li class="active">Add Category</li>
      </ol>
</section>

    <!-- Main content -->
<section class="content">
    <!-- SELECT2 EXAMPLE -->
    <form role="form" id="category_form" action="purchase/save_category"> 
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Category</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
                <div class="row">
                    <!-- form start -->
                       
                          <div class="box-body">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cat_code">Category code</label>
                                <input type="text" class="form-control" id="cat_code" placeholder="Enter Category code" name="cat_code" value="<?php echo $category_number; ?>" required autocomplete="off" readonly/>
                              </div>
                              <div class="form-group">
                                  <label>Category Flag</label>
                                  <select class="form-control" name="cat_for">
                                      <option value="material_po">Material PO</option>
                                      <option value="general_po">General PO</option>
                                  </select>
                               </div>
                            </div>
                            <div class="col-md-6">  
                               <div class="form-group">
                                  <label for="cat_name">Category name</label>
                                  <input type="text" class="form-control" id="cat_name" placeholder="Enter Category name" name="cat_name" value="" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label>Stokable Flag</label>
                                  <select class="form-control" name="cat_stockable">
                                      <option value="not_applicable">Not Applicable</option>
                                      <option value="consumable">Consumable</option>
                                      <option value="non_consumable">Non consumable</option>
                                  </select>
                              </div>
                            </div>  
                          </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <div class="box box-default">
         <div class="box-header with-border">
            <h3 class="box-title">Sub Category</h3>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-sm-12">
                  <table id="sub_cat_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_cat_list_info">
                      <thead>
                          <th>Allow Stock PO</th>
                          <th>Sub Category Code</th>
                          <th>Sub Category Name</th>
                      </thead>
                      <tbody>
                        <tr>
                            <td><input type="checkbox" class="inputs" name="allow_po[]" id="allow_1" /></td>
                            <td><input type="text" class="form-control inputs" name="sub_cat_code[]" id="sub_cat_code_1" /></td>
                            <td><input type="text" class="form-control inputs lst" name="sub_cat_name[]" id="sub_cat_name_1" /></td>
                        </tr>
                      </tbody>
                  </table>  
               </div> 
            </div>  
         </div> 
      </div>  
      <div class="box-footer">
            <input type="hidden" name="submit_type" value="insert" id="submit_type"/>
            <input name="cat_id" value="" id="cat_id" type="hidden">
            
            <div class="col-md-6">
                <button type="button" class="btn btn-primary pull-left" id="view_categories" onclick="load_page('purchase/category');">View</button>
            </div>  
            <div class="col-md-6">  
              <button type="button" class="btn btn-primary pull-right" id="add_categories">Save</button>
              <button id="reset_supplier" type="reset" class="btn btn-primary pull-right" style="margin-right: 10px;">Reset</button>
            </div>
              
      </div>
      <!-- /.box -->
   </form>   
 </section>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/category.js"></script>