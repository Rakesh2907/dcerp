 <table id="menu_list_<?php echo $menu_parent_id?>" class="table table-bordered table-striped-sub_menu">
 	<thead>
        <tr>
           <th>Sub Menu Name</th>
           <th>Sub Menu Links</th>
           <th>Sub Menu Icon</th>
           <th>Sub Menu</th>
           <th>Permission</th>
           <th>Action</th>
        </tr>
   </thead>
   <tbody>
   		 <?php if(!empty($sub_menu)) { ?>
   		 	<?php foreach($sub_menu as $key => $menu){
   		 		 $user_name1 = array();
                 if(isset($menu['user_id']) && !empty($menu['user_id'])){
                				$users = $this->user_model->get_user_details($menu['user_id']);
	                			if(!empty($users)){
	                				foreach ($users as $key => $val) {
	                					array_push($user_name1, $val['name']);
	                				}
	                			}
                }	
   		 	?>
   		 	<tr style="cursor: pointer;" data-row-id="<?php echo $menu['menu_id']?>" onclick="sub_menu_details(<?php echo $menu['menu_id']?>)" style="background-color: #f9eeee">
                        <td class=""><?php echo $menu['menu_name']?></td>
                        <td class=""><?php echo $menu['menu_links']?></td>
                        <td class=""><?php echo $menu['menu_icon']?></td>
                        <td class="">
                           <?php if($menu['sub_menu']){
                           		echo "Yes";
                           }else{
                           		echo "No";
                           }?>		
                        </td>
                        <td><?php echo implode(', ',$user_name1);?></td>
                        <td><button style="cursor: pointer;" onclick="edit_sub_menu(<?php echo $menu['menu_id']?>)"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;<button style="cursor: pointer;" onclick="remove_sub_menu(<?php echo $menu['menu_id']?>)"><i class="fa fa-close"></i></button>

                          <div class="pull-right">
                                      <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="add_new_sub_menu('<?php echo $menu['menu_name']?>',<?php echo $menu['menu_id']?>)">Add Sub Menu</a>
                          </div>
                        </td>
            </tr>
            <tr>
            	<td colspan="6">
            		  <?php 
                        $sub_menu_details = $this->common_model->get_sub_menu_details($menu['menu_id']);
                        if(!empty($sub_menu_details)){ ?>
                          <table id="sub_menu_list_<?php echo $menu_parent_id?>" class="table table-bordered table-striped">
                             <thead>
                                  <tr>
                                     <th>Sub Menu Name</th>
                                     <th>Sub Menu Links</th>
                                     <th>Sub Menu Icon</th>
                                     <th>Sub Menu</th>
                                     <th>Permission</th>
                                     <th>Action</th>
                                  </tr>
                             </thead>
                             <tbody>
                               <?php foreach($sub_menu_details as $key => $sub_menu){
                                   $user_name2 = array();
                                   if(isset($sub_menu['user_id']) && !empty($sub_menu['user_id'])){
                                          $myusers = $this->user_model->get_user_details($sub_menu['user_id']);
                                          if(!empty($myusers)){
                                            foreach ($myusers as $key => $myval) {
                                              array_push($user_name2, $myval['name']);
                                            }
                                          }
                                  } 
                               ?>   
                              <tr>
                                 <td><?php echo $sub_menu['menu_name']?></td>
                                 <td><?php echo $sub_menu['menu_links']?></td>
                                 <td><?php echo $sub_menu['menu_icon']?></td>
                                 <td class="">
                                           <?php 
                                              if($sub_menu['sub_menu']){
                                                echo "Yes";
                                              }else{
                                                echo "No";
                                              }
                                           ?>   
                                       </td>
                                       <td><?php echo implode(', ',$user_name2);?></td>
                                       <td><button style="cursor: pointer;" onclick="edit_sub_menu(<?php echo $sub_menu['menu_id']?>)"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;<button style="cursor: pointer;" onclick="remove_sub_menu(<?php echo $sub_menu['menu_id']?>)"><i class="fa fa-close"></i></button></td>
                              </tr>
                              <?php } ?>  
                             </tbody>
                          </table>  
                  <?php } ?>        
            	</td>		
            </tr>
   		 	<?php } // first for loop?>	
   		 <?php } ?>	
   </tbody>	
 </table>	