<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>/dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class="active">Category</li>
      </ol>
</section>

 <!-- Main content -->
     <section class="content">
      <!-- /.box -->
        <div class="box">
            <!-- <div class="box-header">
              <h3 class="box-title">Units</h3>
            </div> -->
            <div class="box-header">
              <div class="pull-left">
                 <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('purchase/add_category_form')">Add Category</a>
                 <!-- <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="delete_all_supplier">Delete</a> -->
                 <!-- <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="export_category">Export</a> -->
              </div>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="category_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><input name="select_all" value="1" id="category_list-select-all" type="checkbox" /></th>
                  <th>Category Code</th>
                  <th>Category Name</th>
                  <th>Category Flag</th>
                  <th>Category Stock</th>
                  <th>Action(s)</th>
                </tr>
                </thead>
                <tbody>
                  <?php if(!empty($mycategory)) { ?>
                    <?php foreach($mycategory as $key=>$category):?>
                     <tr style="cursor: pointer;" data-row-id="<?php echo $category['cat_id']?>" ondblclick="load_page('purchase/edit_category_form/<?php echo $category['cat_id']?>')">
                        <td><input type="checkbox" class="sub_chk" data-id="<?php echo $category['cat_id']?>"/></td>
                        <td><?php echo $category['cat_code']?></td>
                        <td><?php echo $category['cat_name']?></td>
                        <td><?php echo ucfirst($category['cat_for'])?></td>
                        <td><?php echo ucfirst($category['cat_stockable'])?></td>
                        <td><button style="cursor: pointer;" data-toggle="modal" onclick="load_page('purchase/edit_category_form/<?php echo $category['cat_id']?>')"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;<button style="cursor: pointer;" onclick="remove_category(<?php echo $category['cat_id']?>)"><i class="fa fa-close"></i></button></td>
                     </tr>
                    <?php endforeach;?>
                 <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>Category Code</th>
                    <th>Category Name</th>
                    <th>Category Flag</th>
                    <th>Category Stock</th>
                    <th>Action(s)</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
    </section>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/category.js"></script>