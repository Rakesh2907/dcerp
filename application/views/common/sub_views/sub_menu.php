<ul class="treeview-menu" style="display: block;" id="treeview_perent_id_<?php echo $parent_id?>">  
  <?php  foreach ($menu_details as $key => $val) {?>
            <li class="treeview" id="parent_id_<?php echo $val['menu_id'];?>">
                <a href="javascript:void(0)" onclick="get_sub_menu(<?php echo $val['menu_id'];?>);load_page('<?php echo $val['menu_links']?>');">
                    <i class="<?php echo $val['menu_icon']?>"></i>
                    <span><?php echo $val['menu_name'];?></span>
                    <?php if($val['sub_menu'] == 1){ ?>
                        <span class="pull-right-container">
                          <span class="fa fa-angle-left pull-right"></span>
                        </span>
                    <?php }?>
                </a>  
            </li>        
  <?php } ?>
</ul>