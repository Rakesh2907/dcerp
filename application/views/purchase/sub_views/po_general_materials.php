<div class="row">
            	    	<div class="col-sm-12">
            	    	 	<button type="button" class="btn btn-primary" id="material_select" style="margin-bottom: 11px;" data-action="<?php echo $submit_type;?>" data-cat_id="<?php echo $cat_id;?>">Select</button>
            	    	</div> 	
            	    </div>
	            	<div class="row">
	            		<div class="col-sm-12" style="overflow: auto;height: 556px;">
			               <table id="material_list_pop_up" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_cat_list_info">
			                      <thead>
			                      	  <th></th>
			                          <th>Material id</th>
			                          <th>Material code</th>
			                          <th>Material Name</th>
			                          <th>Category Name</th>
			                      </thead>
			                      <tbody>
				                      	<?php 
				                      	 if(!empty($general_materials)){?>
				                      	 	<?php foreach($general_materials as $key => $material) {?>
						                       <tr id="material_id_<?php echo $material['mat_id']?>">
						                       	    <td><input name="" class="sub_chk" data-id="<?php echo $material['mat_id']?>" type="checkbox"></td>
						                            <td><?php echo $material['mat_id']?></td>
						                            <td class="mat_code_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_code']?></td>
						                            <td class="mat_name_cls_<?php echo $material['mat_id']?>"><?php echo $material['mat_name']?></td>
						                            <td><?php echo $material['cat_name']?></td>
						                        </tr> 
						                     <?php } ?>   
				                    	<?php } ?>
			                      </tbody>
			                </table>  
	                    </div>
	                </div> 
	                <div class="row">					
	               </div>

<script type="text/javascript">
	$(document).ready(function(){

		 var table_material = $('#material_list_pop_up').DataTable({
	            'columnDefs': [{
	               'targets': 0,
	               'searchable':false,
	               'orderable':false,
	               'className': 'dt-body-center',
	               'render': function (data, type, full, meta){
	                   return data;
	               }
	            }],
	            'order': [1, 'asc'],
	            "pageLength": 50
	     });

		$("#material_select").on('click',function(){
	 		 var allMat = [];
		$(".sub_chk:checked").each(function() {  
	          		allMat.push($(this).attr('data-id'));
	     });

		 var action_form = $(this).attr('data-action');
		 var cat_id = $(this).attr('data-cat_id');
		 var dep_id = $("#dep_id").val();
		 var po_type = $("#po_type").val();
		 var supplier_id = $("#supplier_id").val();

		 if(allMat.length <=0){
	 	  		swal({
  					title: "",
  					text: "Please select materials.",
  					type: "warning",
			    });
	 	  }else{
	 	  		 var join_selected_values = allMat.join(","); 
	 	  		 $.ajax({
	 	  		 	type: "POST",  
				    url: baseURL +"purchase/selected_material_generals",
				    headers: { 'Authorization': user_token },
				    cache: false,
				    data: 'mat_ids='+join_selected_values+'&cat_id='+cat_id+'&dep_id='+dep_id+'&po_type='+po_type+'&supplier_id='+supplier_id+'&action='+action_form, 
				    success: function(result, status, xhr){
				    	var res = JSON.parse(result);
				    	$("#gereral_materials").modal('hide');
     					if(res.status == 'success'){
     						 swal({
                                				title: "",
                                				text: res.message,
                                				type: "success",
                                				timer:2000,
  												showConfirmButton: false
                            					},function(){
                            						swal.close();
                                					load_page(res.redirect);
                             });
				    	}else if(res.status == 'error'){
				    		swal({
				               				title: "",
	  										text: res.message,
	  										type: "error",
				            });
				    	}else if(res.status == 'warning'){
				    		swal({
				               				title: "",
	  										text: res.message,
	  										type: "warning",
				            });
				    	}
				    } 
	 	  		});
	 	  }		 
	 });
  });
</script>               