<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
    #mat-code-list{float:left;list-style:none;margin-top:0px;padding:0;width:97%;position: absolute;z-index:1;}
    #mat-code-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
    #mat-code-list li:hover{background:#ece3d2;cursor: pointer;}
</style>
<section class="content-header">
      <h1>
        Add Material
        <small>Material Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Purchase</a></li>
        <li><a href="javascript:void(0)" onclick="load_page('purchase/material');">Material</a></li>
        <li class="active">Add Material</li>
      </ol>
</section>
 <section class="content">
    <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Material</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse2" style="display: none;"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
             <div class="col-md-12">
              <!-- form start -->
                  <form role="form" id="material_form" action="purchase/save_material">
                    <div class="box-body">
                           <div class="row">
                              <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="mat_code">Material Code:</label>
                                      <input type="text" class="form-control mat_code" id="mat_code" placeholder="Enter Material Code" required="required" name="mat_code" autocomplete="off">
                                      <div id="matcode-box"></div>
                                    </div>
                              </div> 
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="unique_number">Unique Number:</label>
                                    <input type="text" class="form-control" id="unique_number" placeholder="Enter Material Code" required="required" name="unique_number" value="<?php echo $material_unique_number;?>" autocomplete="off" readonly>
                                 </div>
                              </div>  
                          </div>    
                          <div class="row">
                              <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="mat_name">Material Name:</label>
                                      <input type="text" class="form-control" id="mat_name" placeholder="Enter Material Name" required="required" name="mat_name">
                                    </div>
                              </div>
                         </div>           
                          <div class="row">        
                                 <div class="col-md-6">     
                                      <div class="form-group">
                                        <label for="mat_details">Material Details:</label>
                                        <textarea class="form-control" rows = "3" cols = "50" name="mat_details" id="mat_details" required></textarea>
                                      </div>
                                 </div>
                          </div> 
                          <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                     <label>Material Category:</label>
                                        <select class="form-control select2" name="cat_id" id="cat_id" required="required">
                                              <option value="">Select Category</option>
                                          <?php foreach($categories as $key => $category){ ?>
                                              <option value="<?php echo $category['cat_id']?>"><?php echo strtoupper($category['cat_name'])?></option>
                                          <?php } ?>  
                                        </select>
                                 </div>   
                              </div> 
                              <div class="col-md-6">
                                <div class="form-group">
                                   <label>Material Sub Category:</label>
                                   <select class="form-control" name="sub_cat_id" id="sub_cat_id">
                                   </select>
                                </div> 
                              </div>
                          </div>
                          <div class="row">
                             <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Rate:</label>
                                        <input type="text" class="form-control" id="mat_rate" placeholder="Enter Rate" required="required" name="mat_rate" value="0.00">
                                    </div>
                                </div>  
                             </div> 
                              <div class="col-md-4">
                                 <div class="form-group">
                                        <label>Unit:</label>
                                        <select class="form-control select2" name="unit_id" id="unit_id">
                                             <?php if(!empty($units)){
                                                foreach ($units as $key => $unit){
                                        ?>
                                                  <option value="<?php echo $unit['unit_id']?>"><?php echo strtoupper($unit['unit'])?></option>      
                                        <?php
                                                }
                                        ?>
                                        <?php }?>
                                        </select>
                                  </div>
                             </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                        <label>Tolerance:</label>
                                        <input type="text" class="form-control" id="tolerance" placeholder="Enter Tolerance" required="required" name="tolerance" value="0.00">
                                  </div>  
                             </div>
                          </div>  
                          <div class="row">
                            <div class="col-md-6">
                                  <div class="form-group">
                                      <label>As On Date:</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="as_on_date" placeholder="DD/MM/YYYY" name="as_on_date">
                                      </div> 
                                   </div>    
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location:</label>
                                      <select class="form-control select2" name="location_id" id="location_id">
                                        <option value="0">Select Location</option>
                                        <?php if(!empty($location_list)){
                                                foreach ($location_list as $key => $location) {
                                        ?>
                                                  <option value="<?php echo $location['location_id']?>"><?php echo $location['location_name'];?></option>   
                                        <?php          
                                                }
                                        }?>
                                      </select>  
                                </div>  
                            </div> 
                          </div> 
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Opening Stock:</label>
                                       <input type="text" class="form-control" id="opening_stock" placeholder="Enter Opening Stock" required="required" name="opening_stock" value="0.00">
                                  </div>  
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Rejection Opening Qty:</label>
                                      <input type="text" class="form-control" id="rejected_opening_qty" placeholder="Enter Rejection Opening Qty" required="required" name="rejected_opening_qty" value="0.00">
                                  </div> 
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Scrap Opening Qty:</label>
                                      <input type="text" class="form-control" id="scrape_opening_qty" placeholder="Enter Scrap Opening Qty" required="required" name="scrape_opening_qty" value="0.00">
                                  </div> 
                              </div>  
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                      <label>Current Stock:</label>
                                      <input type="text" class="form-control" id="current_stock" placeholder="Enter Current Stock" required="required" name="current_stock" value="0.00">
                                </div>  
                            </div>
                            <div class="col-md-4">
                                 <div class="form-group">
                                      <label>Rejection Opening Qty:</label>
                                      <input type="text" class="form-control" id="rejected_current_qty" placeholder="Enter Rejection Opening Qty" required="required" name="rejected_current_qty" value="0.00">
                                 </div> 
                            </div>
                            <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Scrap Current Qty:</label>
                                      <input type="text" class="form-control" id="scrape_current_qty" placeholder="Enter Scrap Current Qty" required="required" name="scrape_current_qty" value="0.00">
                                  </div>  
                            </div>  
                          </div> 
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                        <label>Free Stock:</label>
                                        <input type="text" class="form-control" id="free_stock" placeholder="Enter Free Stock" required="required" name="free_stock" value="0.00">
                                  </div>  
                              </div> 
                              <div class="col-md-4">
                                  <div class="form-group">
                                        <label>Minimum Stock Level:</label>
                                        <input type="text" class="form-control" id="minimum_level" placeholder="Enter Minimum Stock Level" required="required" name="minimum_level" value="0.00">
                                  </div>  
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                        <label>Reorder Qty:</label>
                                        <input type="text" class="form-control" id="reorder_qty" placeholder="Enter Reorder Qty" required="required" name="reorder_qty" value="0.00">
                                  </div>  
                              </div> 
                          </div>
                          <div class="row"> 
                              <div class="col-md-4">
                                  <div class="form-group">
                                       <label>Material Length:</label>
                                       <input type="text" class="form-control" id="mat_length" placeholder="Enter Material Length" required="required" name="mat_length" value="0.00">
                                  </div>  
                              </div>  
                              <div class="col-md-4">
                                   <div class="form-group">
                                        <label>Length Unit:</label>
                                        <select class="form-control select2" name="length_unit_id" id="length_unit_id">
                                             <?php if(!empty($units)){
                                                foreach ($units as $key => $unit){
                                        ?>
                                                  <option value="<?php echo $unit['unit_id']?>"><?php echo strtoupper($unit['unit'])?></option>      
                                        <?php
                                                }
                                        ?>
                                        <?php }?>
                                        </select>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                               <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Material Width:</label>
                                      <input type="text" class="form-control" id="mat_width" placeholder="Enter Material Width" required="required" name="mat_width" value="0.00">
                                  </div>  
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Material Thickness:</label>
                                      <input type="text" class="form-control" id="mat_thickness" placeholder="Enter Material Thickness" required="required" name="mat_thickness" value="0.00">
                                  </div>
                               </div>
                          </div> 
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Material Weight:</label>
                                      <input type="text" class="form-control" id="mat_weight" placeholder="Enter Material Weight" required="required" name="mat_weight" value="0.00">
                                  </div>
                              </div> 
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Weight Unit:</label>
                                      <select class="form-control select2" name="weight_unit_id" id="weight_unit_id">
                                        <?php if(!empty($units)){
                                                foreach ($units as $key => $unit){
                                        ?>
                                                  <option value="<?php echo $unit['unit_id']?>"><?php echo strtoupper($unit['unit'])?></option>      
                                        <?php
                                                }
                                        ?>
                                        <?php }?>
                                      </select>
                                  </div>
                              </div> 
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Material Status:</label>
                                      <select class="form-control select2" name="mat_status" id="mat_status">
                                        <option value="Regular">Regular</option>
                                        <option value="Non-Moveable">Non-Moveable</option>
                                        <option value="Deactive">Deactive</option>
                                      </select>
                                  </div>  
                              </div>  
                          </div> 
                          <div class="row">
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label>No of Reactions:</label>
                                        <input type="text" class="form-control" id="no_of_reaction" placeholder="Enter No of Reactions" name="no_of_reaction">
                                    </div>  
                               </div>
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pack Size:</label>
                                        <input type="text" class="form-control" id="pack_size" placeholder="Enter Pack Size" name="pack_size">
                                    </div>  
                               </div> 
                               <div class="col-md-4">
                                    <div class="form-group"></div>
                               </div>     
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Parent Material Code:</label>
                                      <input type="text" class="form-control" id="parent_mat_code" placeholder="Enter Parent Material Code" name="parent_mat_code" readonly/>
                                      <input type="button" class="btn btn-primary" value="Browse Material" style="margin-top: 10px" id="get_material" />
                                  </div>  
                              </div>
                              <div class="col-md-6">
                                   <div class="form-group">
                                      <label>Parent Material Name:</label>
                                      <input type="text" class="form-control" id="parent_mat_name" placeholder="Enter Parent Material Code" name="parent_mat_name" readonly/>
                                   </div> 
                              </div> 
                          </div>  
                    </div>
                    <div class="box-footer">
                      <input type="hidden" name="mat_parent_id" id="mat_parent_id" value="0" />
                      <input type="hidden" name="submit_type" value="insert" />
                      <input type="hidden" name="<?php echo $variable?>" value="<?php echo $myid?>"/>
                      <input type="hidden" name="action" value="<?php echo $action;?>" />
                      <div class="col-md-6">
                          <button type="submit" class="btn btn-primary">Save</button>
                          <button id="reset_unit" type="reset" class="btn btn-primary">Reset</button>
                      </div>  
                      <div class="col-md-6">
                          <button type="button" class="btn btn-primary pull-right" onclick="load_page('purchase/add_material_form')">Add Material</button>
                          <button type="button" class="btn btn-primary pull-right" onclick="load_page('purchase/material')" style="margin-right: 3px;">View</button>
                      </div>  
                    </div>

                  </form>
            <!-- /.col -->
             </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
 </section>
 <?php 
    $this->load->view("purchase/modals/add_sub_categories_form");
    $this->load->view("purchase/modals/assign_parent_material");
 ?>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/material.js"></script>
<script type="text/javascript">
  $(document).ready(function(){ 
      $('#as_on_date').datepicker({
              autoclose: true,
              format: 'dd/mm/yyyy'
           }).datepicker("setDate", new Date());

      $('#mat_code').keyup(function(){
           $.ajax({
               type: "POST",
               url: baseURL +"commonrequesthandler_ui/get_mat_code",
               data:'keyword='+$(this).val(),
               beforeSend: function(){

               },
               success: function(data){
                  $("#matcode-box").show();
                  $("#matcode-box").html(data);  
               }
           });
      });
  });
</script>
