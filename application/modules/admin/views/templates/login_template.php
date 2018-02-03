<?php  $this->load->view($header['view'],isset($header['data']) ? $header['data'] : []); ?>
<?php  $this->load->view($main_content['view'],isset($main_content['data']) ? $main_content['data'] : []); ?>    
<?php $this->load->view($footer['view'],isset($footer['data']) ? $footer['data'] : []); ?>