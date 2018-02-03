<?php $h = isset($header['data']) ? $header['data'] : ""; ?>
<?php $s = isset($sidebar['data']) ? $sidebar['data'] : ""; ?>
<?php $m = isset($main_content['data']) ? $main_content['data'] : ""; ?>
<?php  $this->load->view($header['view'],$h); ?>
<?php 
    if(!isset($header['data']['requiredcss']))
    {
        $this->load->view($sidebar['view'],$s);
    }
?>
<?php  $this->load->view($main_content['view'],$m); ?>    
<?php  $this->load->view($footer['view'],$footer['data']); ?>  