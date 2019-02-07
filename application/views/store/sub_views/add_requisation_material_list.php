<div class="col-sm-12"> 
	<table id="selected_material_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="material_list_info">
			<thead>
			   <th>Material Code</th>
			   <th>Material Name</th>
			   <th>Unit</th>
			   <th>Material Require Date</th>
			   <th>Require Qty</th>
			   <th>Material Require Users</th>
			   <th>Action(s)</th>
		    </thead>
		    <tbody>
					<tr id="material_id_1" data-row-id="1">
						<input type="hidden" name="mat_id[]" id="mat_id_1" value="">
						<td class="mat_code_cls_1"> 
						        <input type="text" name="mat_code[]" value="" class="form-control" autocomplete="off" id="mat_code_1" readonly>
						        <div id="matcode-box_1"></div>    	
						</td>
				       <td class="mat_name_cls_1">
				       	 	    <input type="text" value="" class="form-control mymat_name" autocomplete="off" id="mat_name_1"> 
				       	 	    <div id="matname-box_1"></div>	
				       </td>
			           <td class="unitid_cls_1" width="100">
					    <select class="form-control valid" name="unit_id[]" id="unit_id">
							        	 <?php 
							        	  	if(!empty($unit_list)){
							        	  		foreach ($unit_list as $key => $val) {
							        	  			$selected = '';
							        	  			if($val['unit_id'] == $material['unit_id']){
							        	  				$selected = 'selected="selected"';
							        	  			}
							        	 ?>
							        	 	<option value="<?php echo $val['unit_id']?>" <?php echo $selected;?>><?php echo $val['unit']?></option>	
							        	 <?php 		
							        	 		}
							        	  	}
							        	 ?>	
                                    </select>
					  </td>
					  <td class="require_date_cls_1">
						        	  <div class="input-group date">
							        		<div class="input-group-addon">
			                                          <i class="fa fa-calendar"></i>
			                                </div>
							        		<input class="require_date form-control" name="require_date[]" id="require_date[]" size="10" class="form-control" type="text" />	
						        	   </div>	
						</td>
						        
						<td class="require_qty_cls_1">
						        	<input name="require_qty[]" id="require_qty[]" size="10" class="form-control" value="" type="text"/>	
						</td>
						<td class="require_users_cls_1">
						<input type="text" name="user_mgm_user[]" value="" class="form-control">
						        	
						 </td>
						 <td><span style="cursor: pointer;" onclick="remove_selected_material(1,<?php echo $dep_id;?>)"><i class="fa fa-close"></i></span></td>
						</tr> 
						
		    </tbody>	 			  
	</table>
	<table class="table">
		  <tr>
		    <td><button type="button" onclick="add_row('insert')">+</button></td>
		  </tr>
	</table>	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#mat_name_1').keyup(function(){
           $.ajax({
               type: "POST",
               url: baseURL +"commonrequesthandler_ui/get_mat_name_requisition",
               data:'field=mat_name&keyword='+$(this).val()+'&row_id=1',
               beforeSend: function(){

               },
               success: function(data){
               	 if(data.length > 0){
               	 	 $("#matname-box_1").show();
                  	 $("#matname-box_1").html(data); 
               	 }else{
               	 	swal({
			          	 title: "",
  						 text: "This Material not found in material master. Please add material",
  						 type: "warning",
			        });
			        $('#mat_name_1').val('');
               	 }  
               }
           });
      });

	 $('#mat_code_1').keyup(function(){
           $.ajax({
               type: "POST",
               url: baseURL +"commonrequesthandler_ui/get_mat_code_requisition",
               data:'field=mat_code&keyword='+$(this).val()+'&row_id=1',
               beforeSend: function(){

               },
               success: function(data){
               	 if(data.length > 0){
               	 	 $("#matcode-box_1").show();
                  	 $("#matcode-box_1").html(data); 
               	 }else{
               	 	swal({
			          	 title: "",
  						 text: "This Material not found in material master. Please add material",
  						 type: "warning",
			        });
			        $('#mat_code_1').val('');
               	 }  
               }
           });
      });

	});
</script>