<div class="modal fade" id="supplier_listing">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Vendors</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<table id="supplier_list_pop_up" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="sub_cat_list_info">
							<thead>
								<th>Vendor Id</th>
								<th>Vendor Name</th>
								<th>Mobile</th>
							</thead>
							<tbody>
								<?php if(!empty($suppliers)){?>
										<?php foreach($suppliers as $key => $supplier) {?>
											<tr id="vendor_id_<?php echo $supplier['supplier_id']?>" ondblclick="get_vendor(<?php echo $supplier['supplier_id'];?>,'<?php echo $form?>')">
						                            <td><?php echo $supplier['supplier_id']?></td>
						                            <td class="supplier_name_cls_<?php echo $supplier['supplier_id']?>"><?php echo $supplier['supp_firm_name']?></td>
						                            <td class="supplier_mobile_cls_<?php echo $supplier['supplier_id']?>"><?php echo $supplier['supp_mobile']?></td>
						                    </tr>
										<?php } ?>	
								<?php } ?>	
							</tbody>
						</table>	
					</div>	
				</div>	
			</div>	
		</div>	
	</div>	
</div>