<div class="modal fade" id="gereral_categories">
	<div class="modal-dialog modal-lg" style="width:1250px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="general_categoires">General Categories</h4>
			</div>
			<div class="modal-body" id="general_pop_up">
				<div class="row">
	            		<div class="col-sm-12" style="overflow: auto;height: 556px;">
			               <table id="categories_list_pop_up" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="categories_list_info">
			                      <thead>
			                      	  <th>#</th>
			                          <th>Category Name</th>
			                          <th>Category</th>
			                          <th>Category Stockable</th>
			                      </thead>
			                      <tbody>
				                       <?php if(!empty($general_category)){?>
				                       	  <?php foreach($general_category as $key => $val){?>
				                       	  	<tr ondblclick="select_category(<?php echo $val['cat_id']?>)">
				                       	  		<td id="general_cat_id"><?php echo $val['cat_id']?></td>
				                       	  		<td><?php echo $val['cat_name']?></td>
				                       	  		<td><?php echo $val['cat_for']?></td>
				                       	  		<td><?php echo $val['cat_stockable']?></td>	
				                       	    </tr>	
				                       	  <?php }?>
				                       <?php }?>
			                      </tbody>
			                </table>  
	                    </div>
	            </div>
			</div>	
		</div>	
	</div>	
</div>