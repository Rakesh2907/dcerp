<?php $this->load->view('dashboard/dashboard_include/main_header');?>
<!-- Site wrapper -->
<div class="wrapper">
    <?php $this->load->view('dashboard/dashboard_include/header');?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div id="alert-msgs" style="position: absolute;width: 65%;z-index: 99;opacity: .8;text-align: center;left: 20%;">
            <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong>&nbsp;<?php echo $this->session->flashdata('success'); ?>
            </div><?php }else if($this->session->flashdata('error')){  ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Error!</strong>&nbsp;<?php echo $this->session->flashdata('error'); ?>
            </div><?php }else if($this->session->flashdata('warning')){  ?>
            <div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Warning!</strong>&nbsp;<?php echo $this->session->flashdata('warning'); ?>
            </div><?php }else if($this->session->flashdata('info')){  ?>
            <div class="alert alert-info">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Info!</strong>&nbsp;<?php echo $this->session->flashdata('info'); ?>
            </div><?php } ?>
        </div>
        <section class="content-header">
            <?php if(isset($page_title)):?>
            <h1>
                <?=$page_title?>                
            </h1>
            <?php endif;?>
            <?php if(isset($breadcrumb)){?>
            <ol class="breadcrumb">
                <?php for($i=0;$i<count($breadcrumb);$i++){?>
                <li class="<?=isset($breadcrumb[$i]['class']) ? $breadcrumb[$i]['class'] : '';?>">
                    <a href="<?=isset($breadcrumb[$i]['url']) ? $breadcrumb[$i]['url'] : '#';?>">
                        <?=$breadcrumb[$i]['title'] ? $breadcrumb[$i]['title'] : '';?>
                    </a>
                </li>
                <?php }?>
            </ol>
            <?php }?>
        </section>
        <?php $this->load->view($page);?>
    </div>
    <?php $this->load->view('dashboard/dashboard_include/footer');?>
</div>
<?php $this->load->view('dashboard/dashboard_include/main_footer');?>



