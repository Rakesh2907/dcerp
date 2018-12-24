<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">  

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php
                if(isset($role_id)):
                    switch(true){
                        case ($role_id === '1'):
                            $this->load->view('dashboard/dashboard_include/side_bar_menu/admin_menu');
                            break;
                        default:
                            $this->load->view('dashboard/dashboard_include/side_bar_menu/employee_menu');
                            break;
                    }
                else:
                    $this->load->view('dashboard/dashboard_include/side_bar_menu/employee_menu');
                endif;
            ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>