<?php 
  $user_data = $this->session->userdata('erp');
  $is_login = $user_data['isLoggedIn'];
  $user_name = $user_data['name'];
  $user_id = $user_data['userId'];
  $menus = get_menu(null,$user_id);
?>  
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl_avatar3_160.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user_name;?></p> 
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="javascript:void(0)" id="dashboard_home">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php if(!empty($menus)){ ?>
           <?php 
              foreach($menus as $menu_key => $menu_val){
            ?>
              <li class="treeview" id="parent_id_<?php echo $menu_val['menu_id'];?>">
                <a href="javascript:void(0)" onclick="get_sub_menu(<?php echo $menu_val['menu_id'];?>);load_page('<?php echo $menu_val['menu_links']?>');">
                  <i class="<?php if(!empty($menu_val['menu_icon'])){echo $menu_val['menu_icon'];}else{echo "";}?>"></i> 
                  <span><?php echo $menu_val['menu_name']?></span>
                   <?php if($menu_val['sub_menu'] == 1){?>
                       <span class="pull-right-container">
                           <span class="fa fa-angle-left pull-right"></span>
                       </span>
                   <?php }?>
                </a>
              </li>
           <?php } ?>
        <?php } //exit; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>