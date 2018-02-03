<?php 

    $menus =  $this->session->userdata('userdata');
    
    if($menus['menus'] !='all' && $menus['menus'] !=''){
    $menu_Items = $menus['menus'] ;
        $menu_data = $this->db->select('*', false)->from('modules')->where_in('id', $menu_Items, false)->order_by('id', 'asc')->get()->result_array();
        //echo $this->db->last_query();
    }else{
        $menu_data = $this->db->select('*')->from('modules')->order_by('id', 'asc')->get()->result_array();
    }
    //echo $this->db->last_query();die;
 ?>
<div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <li class="sidebar-toggler-wrapper" style="margin-bottom:5px;">
                    <div class="sidebar-toggler"></div>
                </li>
                <?php
                foreach ($menu_data as $menu):
                ?>
                    <li class="<?php if($this->uri->segment('1') ==  $menu['path']){echo 'active'; }else { echo ''; }  ?>" >
                        <a href="<?php echo base_url() . $menu['path']; ?>">
                            <i class="fa fa-tachometer" aria-hidden="true"></i> <span class="title"><?php echo $menu['module_name'];?> </span>
                        </a>
                    </li>
               <?php
                endforeach;
               ?>
                <li class="<?php if($this->uri->segment('1') == 'logout'){echo 'active'; }else { echo ''; }  ?>" >
                    <a href="<?php echo base_url() . "logout"; ?>">
                        <!-- <i class="icon-logout"></i>-->
                        <i class="fa fa-power-off" aria-hidden="true"></i>
                        <span class="title">Log Out</span>
                    </a>
                </li>
            </ul>		
        </div>
    </div>



