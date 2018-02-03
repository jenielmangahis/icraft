<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Welcome extends MX_Controller {

    public function __construct() {
        parent::__construct();
        checkCartQuantity();
    }

    public function index() {
        $output['title'] = 'Home';
        $output['pageName'] = 'Home';
        $output['header_class'] = 'icon-menu,javascript:;';
        $output['header_class_right'][0] = 'icon-cart cart-badge,'.base_url().'cus-add-tocart';
        $output['header_class_right'][1] = 'icon-bell,javascript:;';
        if($this->session->userdata('CUSTOMER-SL') != ''){
            $output['nav_display'] = 'block';
        }else{
            $output['nav_display'] = 'none';
        }
        // redirect to splash
        if ( !isset($_COOKIE['splash_shown']) || $_COOKIE['splash_shown'] == 'no' )
        {
            redirect('cus-splash');
        }
        //echo sizeof($output['header_class_right']);die;
        //$output['allProducts']		= $this->banner_model->getAllBannersForFront('linker-front');
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/home');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    public function Splash() {
        if(!isset($_COOKIE['splash_shown'])) {
            $output['nav_display'] = 'none';
            $output['pageName'] = 'Splash';
            $output['bodyClass'] = 'gradient-bg';
            $this->load->view($this->config->item('customer') . '/mobile/header', $output);
            $this->load->view($this->config->item('customer') . '/mobile/splash');
            //$this->load->view($this->config->item('customer') . '/mobile/footer');
        }else{
            redirect('cus-home');
        }
    }

}
