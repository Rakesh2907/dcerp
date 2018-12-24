<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Management</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>assets/images/fav_ico.png" />
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?=base_url()?>assets/template_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url()?>assets/template_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=base_url()?>assets/template_components/Ionicons/css/ionicons.min.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/google_fonts_css.css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <?php //$this->load->view('dashboard/dashboard_include/load_css');?>    
    <script language="javascript">
        document.onmousedown = document.oncontextmenu = disableclick;
        status="Right Click Disabled";
        function disableclick(e)
        {
            if(e.button==2)
            {
                alert(status);
                return false;  
            }
        }
    </script>
    <style type="text/css">
        body, html {
            height: 100%;
            margin: 0;
        }

        .bg {
            /* The image used */
            background-image: url("<?php echo base_url();?>assets/login_background.jpg");

            /* Full height */
            height: 100%; 

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .center_div {
            padding: 15px;
            height: 300px;
            background-color: #fff;

            position: absolute;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;

            margin: auto;
            opacity: 0.85;
            border-radius: 6px;
        }

        .form-control{
            border-top: unset !important;
            box-shadow: none !important;
            border-right: unset !important;
            border-left: unset !important;
            border-radius: unset !important;
        }
        </style>
    </style>
</head>
<body class="bg">
    <div class="container">
        <?php
            $error = $this->session->flashdata('error');
            $success = $this->session->flashdata('success');
        ?>
        <div class="row">
            <div class="col-md-8  col-md-offset-2">
                <?php if($error):?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $error; ?>                    
                    </div>
                <?php 
                    endif;
                    if($success):
                ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $success; ?>                    
                    </div>
                <?php endif; ?>
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
        <?php $this->load->view($page);?>   
    </div>

    <script src="<?=base_url()?>assets/template_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?=base_url()?>assets/template_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?=base_url()?>assets/template_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
