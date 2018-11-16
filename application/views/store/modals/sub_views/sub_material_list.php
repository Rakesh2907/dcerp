<?php if(!empty($sub_materials)){?>
<table id="sub_material_list_pop_up" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_cat_list_info">
			                      <thead>
			                      	  <th></th>
			                          <th>Sub Material</th>
			                          <th>Action(s)</th>
			                      </thead>
			                      <tbody>
				                      	 	<?php foreach($sub_materials as $key => $material) {?>
						                     <tr id="sub_mat_<?php echo $material['sub_mat_id']?>" style="cursor: pointer;" data-sub-mat-id="<?php echo $material['sub_mat_id']?>" data-mat-id="<?php echo $material['mat_id']?>">
						                       	    <td class="details-control-<?php echo $material['sub_mat_id']?> dt-body-center">
                                    						<img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" />
                                					</td>
						                            <td><?php echo $material['sub_material_name']?></td>
						                            <td><button type="button" class="btn btn-primary" onclick="remove_sub_material(<?php echo $material['sub_mat_id']?>)">x</button></td>
						                     </tr>  
						                     <?php } ?>   
			                      </tbody>
</table>
<script type="text/javascript">

  function remove_sub_material(sub_mat_id){
  		$("#sub_mat_"+sub_mat_id).remove();
  		$("#sub_mat_list_"+sub_mat_id).remove();
  }

 $(document).ready(function(){

	var table_sub_material_list = $('#sub_material_list_pop_up').DataTable({
			        paging:         false
	});

	$('#sub_material_list_pop_up tbody').on('click', '.dt-body-center', function () {
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

	$('.dt-body-center').trigger('click');
});	

function sub_material_batch_details(mat_id,sub_mat_id,row){
		 $.ajax({
		 	type: "POST",
		 	url: baseURL+'commonrequesthandler_ui/sub_material_batch_mumber',
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
<?php } ?>