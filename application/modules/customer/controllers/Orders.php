<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Orders extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/Customer_model');
        $this->load->model('customer/Orders_model');
        $this->load->helper('user_helper');
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->library('s3');
        if ($this->session->userdata('CUSTOMER-SL') == '') {
            redirect('cus-login');
        }
        checkCartQuantity();
    }

    public function orderStatus() {
        $orderObj   =   new Orders_model();
        $output['title'] = 'Order Status';
        $output['pageName'] = 'Order Status';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-my-orders';
        $output['orderDetail'] =   $orderObj->orderDetail();
        
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/order_status');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    public function myOrders() {
        $orderObj   =   new Orders_model();
        $output['title'] = 'My Orders';
        $output['pageName'] = 'My Orders';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';
        $output['orders'] =   $orderObj->myOrders();
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/my_orders');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    public function orderDetail() {
        $orderObj   =   new Orders_model();
        $output['title'] = 'Order Detail';
        $output['pageName'] = 'Order Detail';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-my-orders';
        $output['orderDetail'] =   $orderObj->orderDetail();
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/order_detail');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    

}
