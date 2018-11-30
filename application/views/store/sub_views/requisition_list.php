 <table id="approved_material_req_list" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <!--  <th></th> -->
                                       <th>Requisation Number</th>
                                       <th>Requisation Date</th>
                                       <th>Departments</th>
                                       <th>Status</th>
                                    </tr>
                                  </thead> 
                                  <tbody id="approved_tbody">
                                      <?php if(!empty($approved_material_requisation_list)){?>
                                            <?php foreach($approved_material_requisation_list as $key=> $material_requisation):?>
                                               <tr style="cursor: pointer;" data-row-id="<?php echo $material_requisation['req_id']?>" id="req_id_<?php echo $material_requisation['req_id']?>" ondblclick="get_material_requisation(<?php echo $material_requisation['req_id']?>)">
                                                  <!-- <td class="details-control-<?php //echo $material_requisation['req_id']?>"><img src="<?php //echo $this->config->item("cdn_css_image")?>dist/img/details_open.png" /></td> -->
                                                  <td width="200" class="req_number_cls_<?php echo $material_requisation['req_id']?>"><?php echo $material_requisation['req_number']?></td>
                                                  <td><?php echo date("d-m-Y",strtotime($material_requisation['req_date']));?></td>
                                                  <td><?php echo $material_requisation['dep_name'];?></td>
                                                  <td><?php echo ucfirst($material_requisation['approval_flag']);?></td>
                                               </tr>    
                                            <?php endforeach;?>  
                                      <?php }else{ ?>
                                         <tr><td colspan="4" align="center">No Requisition found</td></tr>
                                      <?php } ?>  
                                  </tbody> 
                                   <tfoot>
                                      <tr> 
                                         <th>Requisation Number</th>
                                         <th>Requisation Date</th>
                                         <th>Departments</th>
                                         <th>Status</th>
                                      </tr>
                                  </tfoot> 
</table>
<script type="text/javascript">
     $(document).ready(function(){
         // Approved list
           var table_material_req_approved = $('#approved_material_req_list').DataTable({
                    'columnDefs': [{
                       'targets': 0,
                       'searchable':false,
                       'orderable':false,
                       'className': 'dt-body-center',
                       'render': function (data, type, full, meta){
                            return data;
                           //return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                       }
                    }],
                    'order': [2, 'asc']
           });
     });

     function material_requested(req_id,row){
         if(typeof req_id !== "undefined") {  
           $.ajax({
            type: "POST",
            url: baseURL+'store/get_outward_requisation_materials_list',
            headers: { 'Authorization': user_token },
            cache: false,
            data: 'req_id='+req_id,
            beforeSend: function () {
                $(".content-wrapper").LoadingOverlay("show");
              },
            success: function(result){
                $(".content-wrapper").LoadingOverlay("hide");
                row.child(result).show();
            }
           });
         }   
     }
</script>