<?php
    $segs = $this->uri->segment_array();
	$seg1 = $this->uri->segment(1);
	$seg2 = $this->uri->segment(2);
    $main_session = $this->session->userdata('um');
    //print_r($segs);
?>
<script type="text/javascript">
    if(window.screen.availWidth > 767 ){
        if(document.body.className.indexOf('sidebar-collapse') === -1) 
            document.body.className += ' ' + 'sidebar-collapse';
    }
    
    var baseURL = "<?php echo base_url(); ?>";
    var siteURL = "<?php echo site_url(); ?>/";
    var user_token = "<?php echo base64_encode($main_session['userId']);?>";
    var todays_date = <?php echo date('d/m/Y');?>;    

    function setPassword(length){
        var pass = generateRandomString(length);
        document.getElementById('password').value = pass;
        document.getElementById('cpassword').value = pass;
    }

    function generateRandomString(length){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }
</script>

<script src="<?=base_url()?>assets/template_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url()?>assets/template_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>assets/template_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?=base_url()?>assets/template_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>assets/template_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/template_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
    
<!-- SlimScroll -->
<script src="<?=base_url()?>assets/template_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>assets/template_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/dist/js/adminlte.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        <?php $success = $this->session->flashdata('success');?>
        <?php if($success === "Password updated successfully"):?>
            if(confirm("Password updated successfully")){
                window.location.replace("<?php echo site_url('user/logout');?>");
            }else{
                window.location.replace("<?php echo site_url('user/logout');?>");
            }
        <?php endif;?>
        setTimeout(function () {
            $('.alert').fadeOut(1000);
        }, 3000);
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });

        jQuery('#projects').select2();
    });
</script>

<?php if(in_array('editOld', $segs)):?>
    <script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>
<?php else:?>
    <script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
    
<?php endif;?>
<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/js/custom_functions.js?v=0.1" type="text/javascript"></script>