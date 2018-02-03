<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Customer extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('User_coupons_model');
        $this->load->helper('admin_helper');
        $this->load->library('s3');
        
    }
    
    public function customersList(){
        $customerObj = new Customer_model();
        $customerObj->setSearchText($this->input->post('searchText'));
        $customerObj->setFrom_time($this->input->post('from_time'));
        $customerObj->setTo_time($this->input->post('to_time'));
        $customerObj->setPreOrder($this->input->post('preOrder'));
        $customerObj->setFirstTimeUsers($this->input->post('firstTimeUsers'));
        $customerObj->setNonVerifiedUsers($this->input->post('nonVerifiedUsers'));        
        $customerObj->setPrescription($this->input->post('prescription'));        
        $result['customerlist'] = $customerObj->getAllCustomers();
        $this->load->view('customer/manageCustomer',$result); 
    }
    
    public function addCustomer(){
        $customerObj = new Customer_model();
        $this->load->view('customer/add_customer'); 
    }
    
    
    public function saveCustomer(){
        $customerObj = new Customer_model();
        $result = $customerObj->saveCustomerData();
        if($result){
            $this->session->set_flashdata('success','Customer added successfully');
            $this->session->flashdata('success');
            $this->load->view('customer/add_customer'); 
        }else{
            $this->session->set_flashdata('error','This user is already registered');
            $this->session->flashdata('error');
            $this->load->view('customer/add_customer'); 
        }
        
    }

    public function viewCustomerDetails(){
        $customerObj = new Customer_model();
        $customerObj->set_customer_id($this->uri->segment('2'));
       
        $userCouponsModel = new User_coupons_model();
        $userCouponsModel->setUser_id($this->uri->segment('2'));
        
        $result['couponDetails'] = $userCouponsModel->selectUserCoupons();
        $result['personalDetail'] = $customerObj->viewCustomerData();
        $result['personalOrdersDetail'] = $customerObj->viewCustomerOrdersData();
        $result['prescription'] = $customerObj->prescription();
        $result['rewardPoint'] = $customerObj->getRewardedPoint();
        $this->load->view('customer/view_customer_details',$result); 
    }
    
    public function redeemReward(){
        $result = array();
        $customerObj = new Customer_model();
        $customerObj->set_customer_id($this->uri->segment('2'));
        $data = $customerObj->redeemRewarded();
        if(sizeOf($data) > 0){
           $result = array('result'=>1,'data'=>$data,'message'=>'success');  
        }else{
           $result = array('result'=>0,'data'=>array(),'message'=>'No Record Found');  
        }
        echo json_encode($result);
        exit();
    }
    
    public function  getCustomerReferredUsers(){
     
        //ini_set('display_errors', 'On');
        //error_reporting(E_ALL);
        
        $result = array();
        $customerObj = new Customer_model();
        $customerObj->set_customer_id($this->uri->segment('2'));
        $data = $customerObj->selectReferredUserByCustomer();
        if(sizeOf($data) > 0){
           $result = array('result'=>1,'data'=>$data,'message'=>'success');  
        }else{
           $result = array('result'=>0,'data'=>array(),'message'=>'No Record Found');  
        }
        echo json_encode($result);
        exit();
        
        
    }
}
