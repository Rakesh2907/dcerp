<div class="modal fade" id="add_new_location">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Location</h4>
              </div>
              <div class="modal-body">
                 <form role="form" id="location_form" action="purchase/save_location" method="post">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location_name" placeholder="Enter new location" name="location_name" required="required">
                      </div>
                    </div>
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