<div class="modal fade" id="add_new_units">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Unit</h4>
              </div>
              <div class="modal-body">
                 <form role="form" id="units_form" action="purchase/save_unit" method="post">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="unit">Units</label>
                        <input type="text" class="form-control" id="unit" placeholder="Enter Unit" required="required" name="unit">
                      </div>
                      <div class="form-group">
                        <label for="unit_description">Unit Description</label>
                        <input type="text" class="form-control" id="unit_description" placeholder="Enter Unit Description" name="unit_description">
                      </div>
                    </div>
                    <input type="hidden" name="unit_id" value="" id="unit_id">
                    <input type="hidden" name="parent_form" value="material_form" id="parent_form">
                    <div class="box-footer">
                      <button id="reset_unit" type="reset" class="btn btn-primary pull-left" style="margin-left: 10px;">Reset</button>
                      <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                  </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>