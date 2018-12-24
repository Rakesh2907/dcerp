<?php //echo "<pre>";print_r($projects);echo "</pre>";?>
<section class="content">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
          	<div class="box box-solid">
                    <div class="box-header">
                         <h3>Manage user details for <?php echo $projects->name;?></h3>
                    </div>
          		<div class="box-body">
          			<?php 
          				if(in_array($projects->key, array('lims','thyro_lims'))){
          					$this->load->view("dashboard/project/forms/lims_add_new_user_form");
          				}else{
          					$this->load->view("dashboard/project/forms/add_new_user_form");
          				}
          				
          			?>
			    </div>
			</div>
		</div>
    </div>
</section>