<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background: #2d4f68;">
              <i class="fa fa-bell-o" id="notify_ring"></i>
              <span class="label label-warning"><?php echo $count_notification;?></span>
</a>
<ul class="dropdown-menu" style="width: 700px;">
              <li class="header">You have <?php echo $count_notification;?> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php
                     foreach ($notifications_list as $key => $list) {  //echo "<pre>"; print_r($list); echo "</pre>";
                  ?>
                    <li style="cursor: pointer;">
                      <a onclick="update_unseen(<?php echo $list['notify_id']?>); load_page('<?php echo $list['redirect_url']?>');"><img src="<?php echo $list['img_url']?>" style="width: 30px"/>[FROM]&nbsp;&nbsp;<span style="color: blue;"><?php echo $list['from']?></span>: <?php echo $list['message']?>&nbsp;&nbsp;<small class="label" style="background-color: #098e1b;color:#FFFFFF"><?php echo ucfirst($list['notify_check'])?></small>
                      </a>
                    </li>  
                  <?php      
                     }
                  ?>
                </ul>
              </li>
              <li class="footer"><a href="javascript:void(0)" onclick="load_page('notification/notification_list/unseen')" style="background: #2d4f68; color: #FFFFFF !important; font-weight: bold;">View all</a></li>
</ul>