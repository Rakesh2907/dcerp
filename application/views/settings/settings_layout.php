<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/bootstrap/dist/css/bootstrap-toggle.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>dist/css/jquery.multiselect.css">
<section class="content-header">
      <h1>
        Settings Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Settings</li>
      </ol>
</section>
<section class="content">
       <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#menu-settings" data-toggle="tab" aria-expanded="false">Menus</a></li>
              <li class=""><a href="#user-settings" data-toggle="tab" aria-expanded="false">Users</a></li>
            </ul>
            <div class="tab-content">
	              <div class="tab-pane active" id="menu-settings">
					<div class="box-body">
						<div class="box-header">
				              <div class="pull-right">
                        <?php if(validateAccess('Settings-add_new_menu',$access)){ ?>  
				                 <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="add_new_menu()">Add Menu</a>
                        <?php } ?> 
				              </div>  
            			</div>
				    <div class="panel box box-primary">
				                  <div class="box-header">
					                  	<div class="col-md-2">
					                  		 <h5 style="font-weight: bold;">Menu Name</h5>
					                    </div>
					                    <div class="col-md-2">
					                    	 <h5 style="font-weight: bold;">Menu Links</h5>
					                    </div>	
					                    <div class="col-md-2">
					                    	 <h5 style="font-weight: bold;">Menu Icon</h5>
					                    </div>
					                    <div class="col-md-2">
					                        <h5 style="font-weight: bold;">Sub Menu</h5>	
					                    </div>
					                    <div class="col-md-2">
					                        <h5 style="font-weight: bold;">Access Permission</h5>	
					                    </div>
					                    <div class="col-md-2">
					                        <h5 style="font-weight: bold;">Action(s)</h5>	
					                    </div>	
				                  </div>
				    </div>              		
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->

                <?php if(!empty($parent_menu)){?>
                	<?php foreach($parent_menu as $key => $menu){ 
                		 $user_name = array();
                		 if(isset($menu['user_id']) && !empty($menu['user_id'])){
                				$users = $this->user_model->get_user_details($menu['user_id']);
	                			if(!empty($users)){
	                				foreach ($users as $key => $val) {
                            $myusername = "'".$val['name']."'";
	                					array_push($user_name, '<a href="javascript:void(0)" onclick="access_permission('.$val['id'].','.$myusername.')">'.$val['name'].'</a>');
	                				}
	                			}
                		  }	
                	?>
                		 	<div class="panel box box-primary">
				                  <div class="box-header with-border">
					                   <div class="col-md-2">
						                    <h4 class="box-title">
                                  <?php if(validateAccess('Settings-sub_menu_details',$access)){ ?>  
  						                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $menu['menu_id']?>" aria-expanded="false" class="collapsed" onclick="sub_menu_details(<?php echo $menu['menu_id']?>)">
  						                       <?php echo $menu['menu_name']?>
  						                      </a>
                                <?php } ?>
						                    </h4>
					                   </div> 
					                   <div class="col-md-2">
					                   	 <?php echo $menu['menu_links']?>
					                   </div>	
					                   <div class="col-md-2">
					                   	<?php echo $menu['menu_icon']?>
					                   </div>
					                   <div class="col-md-2">
					                   	<?php if($menu['sub_menu'] == '1'){
					                   		echo 'Yes';
					                     }else{
					                     	echo 'No'; 
					                     } ?> 		
					                   </div>
					                   <div class="col-md-2">
					                   	<?php echo implode(', ',$user_name);?>
					                   </div>
					                   <div class="col-md-2">
                              <?php if(validateAccess('Settings-edit_parent_menu_link',$access)){ ?>  
					                   	  	  <button style="cursor: pointer;" onclick="edit_parent_menu(<?php echo $menu['menu_id']?>)"><i class="fa fa-pencil"></i></button>
                              <?php } ?>      
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                              <?php if(validateAccess('Settings-remove_parent_menu_link',$access)){ ?>        
                                    <button style="cursor: pointer;" onclick="remove_parent_menu(<?php echo $menu['menu_id']?>)"><i class="fa fa-close"></i></button>
                              <?php } ?>      
                                   <div class="pull-right">
                                    <?php if(validateAccess('Settings-add_sub_menu',$access)){ ?>        
                                      <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="add_new_sub_menu('<?php echo $menu['menu_name']?>',<?php echo $menu['menu_id']?>)">Add Sub Menu</a>
                                    <?php } ?>  
                                   </div>
					                   </div>	
				                  </div>
				                  <div id="collapse_<?php echo $menu['menu_id']?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
				                    <div class="box-body">
				             
				                    </div>
				                  </div>
                			</div>
                    <?php }?>	
                <?php } ?>	
              </div>
            </div>
	              </div>
	              <div class="tab-pane" id="user-settings">
                  <?php if(!empty($myusers)){  ?>
                      <div class="box-body">
                          <div class="panel box box-primary">
                              <div class="box-header">
                                  <div class="col-md-2">
                                      <h5 style="font-weight: bold;">ID</h5>
                                  </div>  
                                  <div class="col-md-2">
                                      <h5 style="font-weight: bold;">Name</h5>
                                  </div>
                                  <div class="col-md-2">
                                      <h5 style="font-weight: bold;">Email</h5>
                                  </div>  
                                  <div class="col-md-2">
                                      <h5 style="font-weight: bold;">Mobile</h5>
                                  </div>
                                  <div class="col-md-2">
                                      <h5 style="font-weight: bold;">Department</h5>  
                                  </div>
                                  <div class="col-md-2">
                                      <h5 style="font-weight: bold;">Access key(s)</h5> 
                                      <label>Maintanance(Yes/No)</label>
                                  </div>  
                              </div>
                          </div> 
                          <div class="box-group" id="accordion">
                              <?php foreach($myusers as $key => $users){ ?>
                                 <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                         <div class="col-md-2">
                                            <h4 class="box-title">
                                                <?php echo $users['id']?>  
                                            </h4>
                                         </div> 
                                         <div class="col-md-2">
                                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse_user_<?php echo $users['id']?>" aria-expanded="false" class="collapsed" ><?php echo $users['name']?></a>
                                         </div> 
                                         <div class="col-md-2">
                                             <?php echo $users['email']?>
                                         </div>
                                         <div class="col-md-2">
                                             <?php echo $users['mobile']?>
                                         </div>
                                         <div class="col-md-2">
                                             <?php echo $users['dep_name']?>
                                         </div>
                                         <div class="col-md-2">
                                             <?php if(validateAccess('Settings-access_permission_key',$access)){ ?> 
                                                <button style="cursor: pointer;" onclick="access_permission(<?php echo $users['id']?>,'<?php echo $users['name']?>')"><i class="fa fa-key"></i></button> 
                                             <?php } ?>
                                             <?php if($users['under_maintenance'] == '1'){
                                                 $maintenance = 'Yes';
                                                 $style = 'margin-top: 7px;margin-left: 4px;color: white;';
                                                 $checked = "checked";
                                              }else{
                                                  $maintenance = 'No';
                                                  $style = 'margin-top: 7px;margin-left: 34px;color: white;';
                                                  $checked = '';
                                              } ?> 

                                             <label class="switch">
                                                <input type="checkbox" <?php echo $checked;?> id="maintenance_user_<?php echo $users['id']?>" name="maintenance_user_<?php echo $users['id']?>">
                                                 <span class="slider round" onclick="maintenance_status(<?php echo $users['id']?>)"><div id="maintenance_user_status_<?php echo $users['id']?>" style="<?php echo $style?>"><?php echo $maintenance;?></div></span>
                                            </label> 
                                         </div> 
                                    </div>
                                    <div id="collapse_user_<?php echo $users['id']?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                           <div class="box-body">
                                               <div class="col-md-6">
                                                    <div class="box box-primary" style="border-top-color: #FFFFFF">
                                                       <div class="box-header with-border" style="background: #cedeed;">
                                                              <h3 class="box-title" style="font-size: 14px;">Prevent Events/Keys</h3>
                                                       </div>
                                                       <div class="box-body">
                                                          <div class="form-group">
                                                               <div class="checkbox">
                                                                    <label>
                                                                        <?php 
                                                                           $checked1 = '';
                                                                          if($users['prevent_right_click']){
                                                                            $checked1 = 'checked="checked"';
                                                                          }?>
                                                                       <input type="checkbox" name="prevent_right_click[<?php echo $users['id']?>]" <?php echo $checked1;?>>
                                                                        Prevent Right Click
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox">
                                                                    <label>
                                                                         <?php 
                                                                           $checked2 = '';
                                                                          if($users['prevent_right_click']){
                                                                            $checked2 = 'checked="checked"';
                                                                          }?>
                                                                        <input type="checkbox" name="prevent_f12[<?php echo $users['id']?>]" <?php echo $checked1;?>>
                                                                         Prevent F12 And Ctrl+Shift+I
                                                                    </label>
                                                                </div>
                                                          </div>
                                                       </div> 
                                                       <div class="box-footer clearfix">
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary pull-right" onclick="save_prevent(<?php echo $users['id']?>)">Save</a>
                                                       </div>
                                                    </div>  
                                                 </div>
                                           </div>
                                    </div>
                                </div>
                              <?php } ?>
                          </div>
                      </div>  
                  <?php } ?>  
	              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
       </div>	
       <input type="hidden" name="active_tab" value="<?php echo $tabs?>">
</section>  
<?php
	$this->load->view("settings/modals/add_parent_menu"); 
	$this->load->view("settings/modals/edit_parent_menu");
  $this->load->view("settings/modals/user_access_permission");        
?>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>	
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/settings/settings.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/jquery.multiselect.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/bootstrap/dist/js/bootstrap-toggle.min.js"></script>
<script>
$('#access_keys').multiselect({
    columns: 6,
    search        : true
});
</script>