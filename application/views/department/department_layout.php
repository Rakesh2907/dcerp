<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
      <h1>
        Department Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Purchase</li>
        <li class="active">Deartments</li>
      </ol>
</section>
<section class="content">
		<div class="box">
		   <div class="box-header">
		   	  <div class="pull-left">
                 <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="load_page('department/add_department_form')">Add Department</a>
                 <!-- <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="delete_all_unit">Delete</a> -->
                 <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="export_department">Export</a>
              </div>
		   </div> 
		   	 <!-- /.box-header -->
            <div class="box-body">
            	<table id="department_list" class="table table-bordered table-striped">
            		<thead>
            			<tr>
            				<th><input name="select_all" value="1" id="dep_list-select-all" type="checkbox" /></th>
            				 <th>Name</th>
                  			 <th>Decriptions</th>
                  			 <th>Action(s)</th>
            			</tr>	
            		</thead>	
            		<tbody>
            			<?php if(!empty($departments)) { ?>
            				<?php foreach($departments as $key=>$department):?>
            						<tr style="cursor: pointer;" data-row-id="<?php echo $department['dep_id']?>" ondblclick="load_page('department/edit_department_form/<?php echo $department['dep_id']?>')">
					                        <td><input type="checkbox" name="" class="sub_chk" data-id="<?php echo $department['dep_id']?>"></td>
					                        <td class="edit_field"><?php echo $department['dep_name']?></td>
					                        <td class="edit_field"><?php echo $department['dep_description']?></td>
					                        <td>
                                      <button style="cursor: pointer;" onclick="load_page('department/edit_department_form/<?php echo $department['dep_id']?>')"><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;<!-- <button style="cursor: pointer;" onclick="remove_department(<?php //echo $department['dep_id']?>)"><i class="fa fa-close"></i></button> -->
                                  </td>
                     				</tr>
            			    <?php endforeach;?>	
            		    <?php } ?>		
            	    </tbody>		
                </table>		
            </div>	
            <!-- /.box-body -->

	    </div>		
</section>	





<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/department/department.js"></script>