<section class="content">
	<div class="row">
		<?php if(isset($project_list) && !empty($project_list)):?>
          	<?php foreach($project_list as $project):?>
		        <div class="col-xs-3">
		          	<div class="box box-solid">
		          		<div class="box-body text-center" style="min-height: 110px;">
		          			<h3><label><a href="javascript:void(0)"><?php echo $project->name;?></a></label></h3>		          			
		          		</div>
		          		<div class="box-footer text-center">
		          			<?php //echo "<pre>";print_r($project);echo "</pre>";?>
		          			<?php if(isset($project->user_id) && isset($project->project_id)):?>
			          			<?php if($role_id===ROLE_ADMIN):?>
				          			<div class="pull-left">
				          				<a class="btn btn-info btn-xs" href="<?php echo site_url('projects/manageuser/'.$project->user_id.'/'.$project->project_id);?>" ><i class="fa fa-pencil"></i></a>
				          			</div>
				          			<?php if(isset($project->project_end_user_name) && !empty($project->project_end_user_name)):?>
				          			<div class="pull-right">
				          				<button class="btn btn-success btn-xs" data-pid="<?php echo $project->project_id;?>" onclick="jumpon(this)"><i class="fa fa-sign-in"></i></button>
				          			</div>
				          			<?php endif;?>
				          		<?php else:?>
				          			 <button class="btn btn-success btn-xs" id="jump_to_project" data-pid="<?php echo $project->project_id;?>" onclick="jumpon(this)">
				          			 	<i class="fa fa-sign-in"></i>
				          			 </button>
				          		<?php endif;?>
				          	<?php else:?>
				          		<?php if($role_id===ROLE_ADMIN):?>
					          		<div class="pull-left">
				          				<a class="btn btn-info btn-xs" href="<?php echo site_url('projects/edit/'.$project->id);?>" ><i class="fa fa-pencil"></i></a>
				          			</div>
				          		<?php endif;?>
				          	<?php endif;?>
		          		</div>
		          	</div>
		      	</div>
      		<?php endforeach;?>
        <?php endif;?>
    </div>
</section>