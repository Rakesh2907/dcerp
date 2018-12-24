<div class="col-md-6 center_div">
	<div class="row">
		<div class="col-md-6 col-md-offset-3" style="margin-bottom: 25px;">
			<img src="<?php echo base_url();?>assets/dcgl_logo.png" style="width: 100%">
		</div>
	</div>
	<form action="<?php echo site_url("login/loginMe"); ?>" method="post" style="opacity: 1">
		<div class="form-group has-feedback">
			<input type="text" class="form-control" placeholder="User Name" name="email" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required />
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required />
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="col-xs-8"></div>
			<div class="col-xs-4">
				<input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In" />
			</div>
		</div>
	</form>
</div>

	