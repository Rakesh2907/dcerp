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
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=base_url()?>assets/template_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/iCheck/square/blue.css">

    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/whirl.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?=base_url()?>assets/template_components/select2/dist/css/select2.min.css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <?php /*<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">*/?>
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
        <?php //endif;?>
    </script>
    <style type="text/css">
        .error{
            font-size: 12px;
            font-weight: normal;
            color: #f00;
        }
    </style>
</head>
<body class="hold-transition skin-blue-light sidebar-mini noselect">

    
