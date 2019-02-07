<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
         Notifications
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Notifications</li>
      </ol>
</section>
<section class="content">
	<div class="box" style="border-top: 3px solid #F2C291;">
        <div class="box-body">
             <table id="notification_list" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Modules</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Message</th>
                    <th>Unseen</th>
                  </tr>  
                </thead> 
                 <tbody>
                    <?php 
                      if(!empty($notification_list)){
                        foreach ($notification_list as $key => $list) {
                     ?> 
                        <tr data-row-id="<?php echo $list['notify_id']?>">
                          <td><img src="<?php echo $list['img_url']?>" style="width: 30px"/></td>
                          <td><?php echo $list['from']?></td>
                          <td><?php echo $list['to'];?></td>
                          <td><?php echo $list['message'];?></td>
                          <td><a style="cursor: pointer;" onclick="update_unseen(<?php echo $list['notify_id']?>); load_page('<?php echo $list['redirect_url']?>');"><small class="label" style="background-color: #098e1b;color:#FFFFFF"><?php echo ucfirst($list['notify_check']);?></small></a></td>
                        </tr>  
                    <?php
                       } 
                     } ?>
                 </tbody> 
             </table> 
        </div>     	
	</div>
</section>	
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>  
<script type="text/javascript">
  $(document).ready(function(){
     // Pending list
   var table_material_req = $('#notification_list').DataTable({
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
              'pageLength': 50
   });
}); 
</script>
  