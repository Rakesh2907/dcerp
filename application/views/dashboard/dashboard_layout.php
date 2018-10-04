<!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
</section>
    <!-- Main content -->
<section class="content">
	 <div class="row">

        <?php if(validateAccess('dashboard-requisition_count',$access)){?>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <div id="total_req">	
	              <h3><?php echo $total_requisation;?></h3>
	              <p>Requisations</p>
          	  </div> 
            </div>
            <div class="icon">
              <i class="ion"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/icons_requisation.png"/></i>
            </div>
            <a id="more_info_req" href="javascript:void(0)" class="small-box-footer" onclick="requisation_more_info()">More info <i class="fa fa-arrow-circle-right"></i></a>   
          </div>
          </div>
        <?php } ?>
        <!-- ./col -->
        <?php if(validateAccess('dashboard-quotation_count',$access)){?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $quotation_count;?></h3>

                  <p>Quotations</p>
                </div>
                <div class="icon">
                  <i class="ion"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/icons_quotations.png"/></i>
                </div>
                <a id="more_info_req" href="javascript:void(0)" class="small-box-footer" onclick="load_page('purchase/quotations/tab_1')">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
        <?php } ?>
           
            <!-- ./col -->
        <?php if(validateAccess('dashboard-vendor_count',$access)){?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $vendor_count;?></h3>

                  <p>Vendors</p>
                </div>
                <div class="icon">
                  <i class="ion"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/icons_vendors.png"/></i>
                </div>
                <div id="vendor_status">
    	            <div class="small-box-footer col-sm-4" style="background: #CF850F">
    	            	<a href="#" class="" style="color: #ffffff">&nbsp;</a>
    	            </div> 
    	            <div class="small-box-footer col-sm-4" style="background: #CF850F">
    	            	<a href="#" class="" style="color: #ffffff">More info <i class="fa fa-arrow-circle-right"></i></a>
    	            </div>
    	            <div class="small-box-footer col-sm-4" style="background: #CF850F">
    	            	<a href="#" class="" style="color: #ffffff">&nbsp;</a>
    	            </div>
    	        </div>
              </div>
            </div>
        <?php } ?>
            <!-- ./col -->
        <?php if(validateAccess('dashboard-po_count',$access)){?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $po_count;?></h3>

                  <p>Purchase Orders</p>
                </div>
                <div class="icon">
                  <i class="ion"><img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/icons_po.png"/></i>
                </div>
                <div id="po_status">
    	            <div class="small-box-footer col-sm-4" style="background: #BC4031">
    	            	<a href="#" class="" style="color: #ffffff">&nbsp;</a>
    	            </div> 
    	            <div class="small-box-footer col-sm-4" style="background: #BC4031">
    	            	<a href="javascript:void(0)" class="" style="color: #ffffff" onclick="po_more_info()">More info <i class="fa fa-arrow-circle-right"></i></a>
    	            </div>
    	            <div class="small-box-footer col-sm-4" style="background: #BC4031">
    	            	<a href="#" class="" style="color: #ffffff">&nbsp;</a>
    	            </div>
    	        </div>
              </div>
            </div>
       <?php } ?>
        
        <!-- ./col -->
      </div>	
   <div class="row" style="margin-top: 20px;" id="requisation_toggle">
   </div>
</section>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/dashboard/dashboard.js"></script>