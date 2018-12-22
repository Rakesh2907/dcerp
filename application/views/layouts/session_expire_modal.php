<div class="modal fade" id="session_expire_timeout">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
	        	<button type="button" class="btn btn-primary pull-right" onClick="window.location.reload()">Login</button>
				<h4 class="modal-title" id="session_timeout">Session Expired</h4>
			</div>
			 <div class="modal-body">
			 	<div class="row">
			 	  <div class="col-sm-4">&nbsp;&nbsp;&nbsp;&nbsp;</div>
			 	  <div class="col-sm-4">
			 		<img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl_expire_session.jpg" style="width: 93%"/>
			 	  </div> 	
			 	  <div class="col-sm-4">&nbsp;&nbsp;&nbsp;</div>
			 	</div>  	
			 </div>	
		</div>
    <!-- /.modal-content -->
    </div>
</div>