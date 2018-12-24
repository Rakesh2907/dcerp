<div id="edit_role" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Role</h4>
            </div>
            <div class="modal-body">
              <?php echo form_open($this->uri->uri_string(), array('id'=>'frm_edit_roles', 'style'=>'min-height: 220px;'));?>
                <div class="form-group">
                  <?=form_input(array('name'=>'edit_role_name',
                                      'tabindex'=>'1',
                                      'id'=>'edit_role_name',
                                      'class'=>'form-control',
                                      'placeholder'=>'Role Name',
                                      'value'=>''))?>
                </div>
                <div class="form-group">
                    <label>Set Permissions</label>                                    
                    <select name="permissions[]" id="permissions" multiple="" class="form-control">
                        <option value="all">All</option>
                        <?php foreach($groups as $key=>$permission):?>                            
                            <option value="<?=$key?>"><?=$permission?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                  <input type="hidden" name="role_id" id="role_id" />
                  <?=form_submit(array('name'=>'frm_edit_role_submit','class'=>'btn btn-primary pull-right','value'=>'Submit'));?>  
                </div>
              <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>