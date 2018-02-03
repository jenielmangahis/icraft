<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Pages extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/Pages_model');
        $this->load->helper('user_helper');
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->library('s3');
    }

    public function getPageBySlug($slug) {
        $pageObj   =   new Pages_model();
        $pageDetail =   $pageObj->getPageBySlug($slug);
        $output['title'] = $pageDetail->title;
        $output['pageName'] = $pageDetail->title;
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';
        $output['pageDetail']   =   $pageDetail;
        
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/static_page');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    public function privacy()
    {
        $output['title'] = "Privacy Policy";
        $output['pageName'] = "Privacy";
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';
        
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/privacy');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
}
