<tr id="material_id_<?php echo $i?>" data-row-id="<?php echo $i?>">
						<input type="hidden" name="mat_id[]" id="mat_id_<?php echo $i?>" value="">
						<td class="mat_code_cls_<?php echo $i?>"> 
						        <input type="text" name="mat_code[]" value="" class="form-control" autocomplete="off" id="mat_code_<?php echo $i?>">
						        <div id="matcode-box_<?php echo $i?>"></div>	
						</td>
				       <td class="mat_name_cls_<?php echo $i?>">
				       	 	    <input type="text" value="" class="form-control" autocomplete="off" id="mat_name_<?php echo $i?>"> 
				       	 	    <div id="matname-box_<?php echo $i?>"></div>		
				       </td>
			           <td class="unitid_cls_<?php echo $i?>" width="100">
					    <select class="form-control" name="unit_id[]" id="unit_id">
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
					  <td class="require_date_cls_<?php echo $i?>">
						        	  <div class="input-group date">
							        		<div class="input-group-addon">
			                                          <i class="fa fa-calendar"></i>
			                                </div>
							        		<input class="require_date" name="require_date[]" id="require_date_<?php echo $i?>" size="10" class="form-control" type="text" />	
						        	   </div>	
						</td>
						        
						<td class="require_qty_cls_<?php echo $i?>">
						        	<input name="require_qty[]" id="require_qty_<?php echo $i?>" size="10" class="form-control" value="" type="text"/>	
						</td>
						<td class="require_users_cls_<?php echo $i?>">
						<input type="text" name="user_mgm_user[]" value="" class="form-control">
						        	
						 </td>
						 <td><span style="cursor: pointer;" onclick="remove_selected_material(<?php echo $i?>,<?php echo $dep_id;?>)"><i class="fa fa-close"></i></span></td>
<script type="text/javascript">
	$(document).ready(function(){
        $('#require_qty_<?php echo $i?>').rules('add', {
            number: true,
            required: true
        });
    
        $('#require_date_<?php echo $i?>').rules('add', {
            required: true
        });

        $('.require_date').datepicker({
              autoclose: true,
              format: 'dd-mm-yyyy',
              startDate:new Date()
        });

        $('#mat_code_<?php echo $i?>').keyup(function(){
            $.ajax({
               type: "POST",
               url: baseURL +"commonrequesthandler_ui/get_mat_code_requisition",
               data:'field=mat_code&keyword='+$(this).val()+'&row_id=<?php echo $i?>',
               beforeSend: function(){

               },
               success: function(data){
               	 if(data.length > 0){
               	 	 $("#matcode-box_<?php echo $i?>").show();
                  	 $("#matcode-box_<?php echo $i?>").html(data); 
               	 }else{
               	 	swal({
			          	 title: "",
  						 text: "This Material not found in material master. Please add material",
  						 type: "warning",
			        });
			        $('#mat_code_<?php echo $i?>').val('');
               	 }
                   
               }
           });
        });

        $('#mat_name_<?php echo $i?>').keyup(function(){
           $.ajax({
               type: "POST",
               url: baseURL +"commonrequesthandler_ui/get_mat_name_requisition",
               data:'field=mat_name&keyword='+$(this).val()+'&row_id=<?php echo $i?>',
               beforeSend: function(){

               },
               success: function(data){
               	 if(data.length > 0){
               	 	 $("#matname-box_<?php echo $i?>").show();
                  	 $("#matname-box_<?php echo $i?>").html(data); 
               	 }else{
               	 	swal({
			          	 title: "",
  						 text: "This Material not found in material master. Please add material",
  						 type: "warning",
			        });
			        $('#mat_name_<?php echo $i?>').val('');
               	 }  
               }
           });
       });


	});
</script>
</tr>