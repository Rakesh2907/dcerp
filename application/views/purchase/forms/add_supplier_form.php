<section class="content-header">
      <h1>
        New Vendor
        <small>Vendor Manager</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li><a href="javascript:void(0)" onclick="load_page('purchase/supplier');">Vendor</a></li>
        <li class="active">Add Vendor</li>
      </ol>
</section>
 <section class="content">
    <!-- SELECT2 EXAMPLE -->
      <div class="box box-default" style="border-top: 3px solid #F39C12">
        <div class="box-header with-border">
          <h3 class="box-title">Add Vendor</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="mycollapse2" style="display: none;"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
  
              <!-- form start -->
                  <form role="form" id="supplier_form" action="purchase/save_supplier">
                    <div class="box-body">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="supp_firm_name">Vendor Firm Name</label>
                          <input type="text" class="form-control" id="supp_firm_name" placeholder="Enter supplier name" name="supp_firm_name" required autocomplete="off" />
                        </div>
                        <div class="form-group">
                          <label for="supp_contact_person">Contact Person</label>
                          <input type="text" class="form-control" id="supp_contact_person" placeholder="Enter Contact Person" name="supp_contact_person" required autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="supp_address">Firm Address</label>
                          <textarea class="form-control" rows = "5" cols = "50" name="supp_address" id="supp_address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="supp_contact_designation">Designation</label>
                            <input type="text" class="form-control" id="supp_contact_designation" placeholder="Enter Designation" name="supp_contact_designation" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="supp_country">Country</label>
                            <input type="text" class="form-control" id="supp_country" placeholder="Enter Country" name="supp_country" value="INDIA" >
                        </div>
                        <div class="form-group">
                            <label for="supp_state">State</label>
                            <input type="text" class="form-control" id="supp_state" placeholder="Enter State" name="supp_state" value="MAHARASHATRA">
                        </div>
                        <div class="form-group">
                            <label for="supp_city">City</label>
                            <input type="text" class="form-control" id="supp_city" placeholder="Enter City" name="supp_city" value="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="supp_pin">Postal Code</label>
                            <input type="text" class="form-control" id="supp_pin" placeholder="Enter Postal Code" name="supp_pin" value="">
                        </div>
                      </div>
                      <div class="col-md-6">  
                         <div class="form-group">
                            <label for="supp_phone1">Phone1</label>
                            <input type="text" class="form-control" id="supp_phone1" placeholder="Enter Phone1" name="supp_phone1" value="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="supp_phone2">Phone2</label>
                            <input type="text" class="form-control" id="supp_phone2" placeholder="Enter Phone2" name="supp_phone2" value="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="supp_mobile">Mobile1</label>
                            <input type="text" class="form-control" id="supp_mobile" placeholder="Enter Mobile1" name="supp_mobile" value="" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="supp_mobile2">Mobile2</label>
                            <input type="text" class="form-control" id="supp_mobile2" placeholder="Enter Mobile2" name="supp_mobile2" value="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="supp_fax">Fax Number</label>
                            <input type="text" class="form-control" id="supp_fax" placeholder="Enter Fax Number" name="supp_fax" value="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="supp_email">Email</label>
                            <input type="text" class="form-control" id="supp_email" placeholder="Enter Email" name="supp_email" value="" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="supp_website">Website</label>
                            <input type="text" class="form-control" id="supp_website" placeholder="Enter Website" name="supp_website" value="" autocomplete="off">
                        </div>
                        <div class="form-group">
                                   <label for="supp_description">Vendor Description</label>
                                   <textarea class="form-control" rows = "5" cols = "50" name="supp_description" id="supp_description" required></textarea>
                        </div>
                        <div class="form-group">
                                 <label for="department">Assign Department:</label> 
                                 <select id="department_dropdown" class="form-control select2" multiple="multiple" data-placeholder="Select Departments"
                            style="width: 100%;" name="dep_id[]" required="required">
                                     <?php 
                                       foreach($departments as $key => $department){
                                     ?>
                                      <option value="<?php echo $department['dep_id']?>"><?php echo $department['dep_name']?></option>
                                     <?php }?>  
                                 </select>
                        </div>
                      </div>  
                    </div>
                    <div class="box-footer">
                      <input type="hidden" name="submit_type" value="insert"/>
                      <input type="hidden" name="<?php echo $variable;?>" value="<?php echo $myid;?>"/>
                      <div class="col-md-6">
                          <button type="submit" class="btn btn-primary">Save</button>
                          <button id="reset_supplier" type="reset" class="btn btn-primary">Reset</button>
                      </div>
                      <div class="col-md-6">   
                          <button type="button" class="btn btn-primary pull-right" onclick="load_page('purchase/add_supplier_form')">Add Vendor</button>
                          <button type="button" class="btn btn-primary pull-right" onclick="load_page('purchase/supplier')" style="margin-right: 3px;">View</button>
                      </div>    
                    </div>
                  </form>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
 </section>
 <script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>  
 <script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/purchase/supplier.js"></script>