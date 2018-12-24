<style type="text/css">
  .red-box{
    border: 1px solid #ff0000;
    border-radius: 10px;
    width: 10px;
    height: 10px;
    background-color: #ff0000;
  }
  .gree-box{

  }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                <button name="btn_add_role" id="btn_add_role" class="btn btn-primary pull-right" style="margin-bottom: 10px;" data-toggle="modal" data-target="#add_role" onclick="setFocusToTextBox()">
                  <i class="fa fa-plus"></i> Add New
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <h3 class="box-title">Users Role List</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-bordered table-striped user_table">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Groups</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(!empty($role_list))
                  {
                      foreach($role_list as $role)
                      {
                  ?>
                  <tr>
                    <td><?php echo $role->id ?></td>
                    <td><?php echo $role->user_role ?></td>
                    <td>
                      <?php
                        $grp_str = '';
                        if(!empty($role->groups)):
                            $groups = json_decode($role->groups);
                            $grp_str = implode(",",$groups);
                            foreach($groups as $k=>$grp){
                              if($grp != 'all'):
                                echo permission_array($grp)."&nbsp;";
                                if(!empty($groups[$k+1])):
                                  echo ", ";
                                endif;
                              else:
                                echo "All";
                              endif;
                            }
                        endif;
                      ?>
                    </td>
                    
                    <td class="text-center">
                        <button name="btn_edit_role" id="btn_edit_role" class="btn btn-primary pull-right" data-toggle="modal" data-target="#edit_role" onclick="edit_user_role('<?=$role->id?>','<?=$role->user_role?>','<?=$grp_str?>')"><i class="fa fa-pencil"></i></button>
                    </td>
                  </tr>
                  <?php
                      }
                  }
                  ?>
                </tbody>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
    </div>
</section>
<!-- Add Test Modal-->
<?php $this->load->view('user/modals/add_role_modal');?>
<!-- Edit Test Modal-->
<?php $this->load->view('user/modals/edit_role_modal');?>

<script type="text/javascript">
  var edit_user_role = function(id,role,groups){
      var grp_arr = groups.split(",");
      document.getElementById('role_id').value = id;
      document.getElementById('edit_role_name').value = role;
      document.getElementById("edit_role_name").focus();
      el = document.getElementById('permissions');
      for (var j = 0; j < grp_arr.length; j++) {
          for (var i = 0; i < el.length; i++) {
              if (el[i].value == grp_arr[j]) {
                  el[i].selected = true;
                  //alert("option should be selected");
              }
          }
      }
  }
  var setFocusToTextBox = function(){
    document.getElementById("role_name").focus();
  }
</script>
