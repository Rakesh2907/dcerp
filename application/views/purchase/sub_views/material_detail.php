<div class="box box-default" style="overflow: auto;width: 1604px;">
	<div class="box-header with-border">
        	
    </div>
    <div class="box-body">
    		<table class="table table-bordered">
    			<thead>
                          <th>Bar Code</th>
                          <th>Batch No.</th>
                          <th>Serial No.</th>
                          <th>Received Qty.</th>
                          <th>Accepted Qty.</th>
                          <th>Outward Qty.</th>
                          <th>Exprire Date</th>
                          <th>Shipping Temp.</th>
                          <th>Storage Temp.</th>
                      </thead>
                      <tbody>
                       <?php 
                          foreach($batch_number as $batch_id => $batch){  //echo "<pre>"; print_r($batch);
                        ?> 
                          <tr id="batch_row_id_<?php echo $batch['batch_id']?>">
                              <td>
                                <input type="text" class="form-control inputs" value="<?php echo $batch['bar_code']?>" disabled="disabled"/>
                              </td>
                              <td><input type="text" class="form-control inputs" value="<?php echo $batch['batch_number']?>" disabled="disabled"/></td>
                              <td><input type="text" class="form-control inputs" value="<?php echo $batch['lot_number']?>" disabled="disabled"/></td>
                              <td><input type="text" class="form-control inputs" value="<?php echo $batch['received_qty']?>" disabled="disabled"/></td>
                              <td><input type="text" class="form-control inputs" value="<?php echo $batch['accepted_qty']?>" disabled="disabled"/></td>
                              <td><input type="text" class="form-control inputs" value="<?php echo $batch['outward_qty']?>" disabled="disabled"/></td>
                              <td>
                                <?php
                                  if($batch['na_allowed'] == 'no'){
                                    $expire_date = date("d-m-Y",strtotime($batch['expire_date']));
                                  }else{
                                    $expire_date = 'NA';
                                  } 
                                ?>

                                <input class="form-control expire_date" type="text" class="form-control inputs" value="<?php echo $expire_date;?>" disabled="disabled"/>
                              </td>
                              <td><input type="text" class="form-control inputs" value="<?php echo $batch['shipping_temp']?>" disabled="disabled"/></td>
                              <td><input type="text" class="form-control inputs" value="<?php echo $batch['storage_temp']?>" disabled="disabled"/></td>
                          </tr>
                      <?php
                       } ?>  
                      </tbody> 
    		</table>
    </div>	
</div>
<div class="box box-default">
		<div class="box-header with-border">
             <h3 class="box-title">Sub Materials</h3>
        		 <button type="button" class="btn btn-primary pull-right" onclick="add_sub_material(<?php echo $mat_id?>)">Add Sub Material</button>
        </div>
         <div class="box-body">
        	<div class="col-sm-12" style="overflow: auto; height: 220px" id="sub_material_list">
        		<?php if(!empty($sub_materials)){?>
        				<table id="sub_material_listing_<?php echo $mat_id?>" class="table table-bordered table-striped" role="grid" aria-describedby="sub_cat_list_info">
			                      <thead>
			                      	  <th></th>
			                          <th>Sub Material</th>
			                          <th>Action(s)</th>
			                      </thead>
			                      <tbody>
				                      	 	<?php foreach($sub_materials as $key => $material) {?>
						                     <tr id="sub_mat_<?php echo $material['sub_mat_id']?>" style="cursor: pointer; background-color: #dff0f9" data-sub-mat-id="<?php echo $material['sub_mat_id']?>" data-mat-id="<?php echo $material['mat_id']?>">
						                       	    <td class="details-control-<?php echo $material['sub_mat_id']?> dt-body-center-sub">
                                    						<img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" />
                                					</td>
						                            <td><strong><?php echo $material['sub_material_name']?></strong></td>
						                            <td><button type="button" class="btn btn-primary" onclick="remove_sub_material(<?php echo $material['sub_mat_id']?>)">x</button></td>
						                     </tr>  
						                     <?php } ?>   
			                      </tbody>
							</table>
        		<?php } ?>	
            </div>		
         </div> 
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var table_sub_material_list = $('#sub_material_listing_<?php echo $mat_id?>').DataTable({
			        paging:         false
		 });

		$('#sub_material_listing_<?php echo $mat_id?> tbody').on('click', '.dt-body-center-sub', function () {
	  		 var tr = $(this).closest('tr');
        	 var row = table_sub_material_list.row( tr );
             var sub_mat_id = tr.attr('data-sub-mat-id');
             var mat_id = tr.attr('data-mat-id');

             if (row.child.isShown()) {
             	row.child.hide();
            	tr.removeClass('shown');
            	$(".details-control-"+sub_mat_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
             }else{
                 sub_material_batch_details(mat_id,sub_mat_id,row);   
	             tr.addClass('shown');
	             $(".shown .details-control-"+sub_mat_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
             }
	  });
	});

	function sub_material_batch_details(mat_id,sub_mat_id,row){
		$.ajax({
			type: "POST",
		 	url: baseURL+'purchase/sub_material_batch_mumber',
		 	headers: { 'Authorization': user_token },
		 	cache: false,
		 	data: JSON.stringify({mat_id:mat_id,sub_mat_id:sub_mat_id}),
		 	beforeSend: function(){
			},
			success: function(result){
				row.child(result).show();
			}
		});
	}

</script>	
