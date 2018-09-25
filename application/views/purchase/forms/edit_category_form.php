<section class="content-header">
      <h1>
        Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>/dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class=""><a href="javascript:void(0)" class="" onclick="load_page('purchase/category');">Category</a></li>
        <li class="active">Edit Category</li>
      </ol>
</section>

    <!-- Main content -->
<section class="content">
    <!-- SELECT2 EXAMPLE -->
    <form role="form" id="category_form" action="purchase/save_category"> 
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Category</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                          <?php if($pre_cat_id > 0){?>
                                    <button type="button" class="btn" onclick="load_page('purchase/edit_category_form/<?php echo $pre_cat_id;?>')">Pre</button>
                          <?php } ?> 
                    </div> 
                    <div class="col-md-6">
                        <?php if($next_cat_id > 0){?>
                                    <button type="button" class="btn pull-right" onclick="load_page('purchase/edit_category_form/<?php echo $next_cat_id;?>')">Next</button>
                        <?php } ?>
                    </div> 
                </div>
                <div class="row">
                    <!-- form start -->
                       
                          <div class="box-body">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cat_code">Category code</label>
                                  <input type="text" class="form-control" id="cat_code" placeholder="Enter Category code" name="cat_code" value="<?php echo $cat_code;?>" required autocomplete="off" />
                              </div>
                              <div class="form-group">
                                  <label>Category Flag</label>
                                  <select class="form-control" name="cat_for">
                                      <option value="material_po" <?php if($cat_for == 'material_po'){ echo 'selected="selected"';}else{ echo '';}?>>Material PO</option>
                                      <option value="general_po" <?php if($cat_for == 'general_po'){ echo 'selected="selected"';}else{ echo '';}?>>General PO</option>
                                  </select>
                               </div>
                            </div>
                            <div class="col-md-6">  
                               <div class="form-group">
                                  <label for="cat_name">Category name</label>
                                  <input type="text" class="form-control" id="cat_name" placeholder="Enter Category name" name="cat_name" value="<?php echo $cat_name;?>" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label>Stokable Flag</label>
                                  <select class="form-control" name="cat_stockable">
                                      <option value="consumable" <?php if($cat_stockable == 'consumable'){ echo 'selected="selected"';}else{ echo '';}?>>Consumable</option>
                                      <option value="non_consumable" <?php if($cat_stockable == 'non_consumable'){ echo 'selected="selected"';}else{ echo '';}?>>Non consumable</option>
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
                          <th>Action</th>
                      </thead>
                      <tbody>
                         <?php 
                            $sub_categories = $this->purchase_model->get_sub_categories_details(array("cat_id"=>$cat_id));
                            if(!empty($sub_categories)){
                              foreach ($sub_categories as $key => $subcat_val) {
                          ?>
                           <tr id="sub_id_<?php echo $subcat_val['sub_cat_id']?>">
                                <td><input type="checkbox" class="inputs" name="allow_po[]"/></td>
                                <td><input type="text" class="form-control inputs" name="sub_cat_code[]" value="<?php echo $subcat_val['cat_code']?>" /></td>
                                <td><input type="text" class="form-control inputs" name="sub_cat_name[]" value="<?php echo $subcat_val['cat_name']?>" /></td>
                                <td><button style="cursor: pointer;" onclick="remove_sub_category(<?php echo $subcat_val['sub_cat_id']?>)"><i class="fa fa-close"></i></button></td>
                          </tr>
                         <?php
                              }         
                            }
                         ?>
                        <tr>
                            <td><input type="checkbox" class="inputs" name="allow_po[]"/></td>
                            <td><input type="text" class="form-control inputs" name="sub_cat_code[]"/></td>
                            <td><input type="text" class="form-control inputs lst" name="sub_cat_name[]" /></td>
                            <td></td>
                        </tr>
                      </tbody>
                  </table>  
               </div> 
            </div>  
         </div> 
      </div>  
      <div class="box-footer">
            <input type="hidden" name="submit_type" value="edit" id="submit_type"/>
            <input type="hidden" name="cat_id" value="<?php echo $cat_id;?>" id="cat_id"/>
            <div class="col-md-6">  
              <button type="button" class="btn btn-primary" id="add_categories">Save & Close</button> 
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary pull-right" onclick="load_page('purchase/add_category_form')">Add Category</button>
                <button type="button" class="btn btn-primary pull-right" onclick="load_page('purchase/category_material/<?php echo $cat_id;?>')" style="margin-right: 4px;">Materials</button>
                <button type="button" class="btn btn-primary pull-right" id="view_categories" onclick="load_page('purchase/category');" style="margin-right: 4px;">View</button>
            </div>  
              
      </div>
      <!-- /.box -->
   </form>   
 </section>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/category.js"></script>