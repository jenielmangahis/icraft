<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Driver extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Driver_model');
        $this->load->model('Warehouse_model');
        $this->load->library('s3');
        $this->load->helper('user_helper');
    }

    /*
     * List of All acitive drivers
     */

    public function getAllDrivers() {
        $driverObj = new Driver_model();

        $data['driverlist'] = $driverObj->getAllDrivers();
        $data['title'] = 'Drivers';
        $data['header'] = array(
            'view' => 'templates/header',
            'data' => $data);
        $data['sidebar'] = array(
            'view' => 'templates/common_sidebar',
            'data' => $data);
        $data['main_content'] = array(
            'view' => 'driver/drivers',
            'data' => $data);
        $data['footer'] = array(
            'view' => 'templates/footer',
            'data' => $data);
        $this->load->view('templates/common_template', $data);
    }

    /*
     * Driver Add Form
     */

    public function addDriver() {
        $warehouseObj = new Warehouse_model();
        $data['warehouses'] = $warehouseObj->getWareHouse();

        $data['title'] = 'Add Driver';
        $data['header'] = array(
            'view' => 'templates/header',
            'data' => $data);
        $data['sidebar'] = array(
            'view' => 'templates/common_sidebar',
            'data' => $data);
        $data['main_content'] = array(
            'view' => 'driver/add_driver',
            'data' => $data);
        $data['footer'] = array(
            'view' => 'templates/footer',
            'data' => $data);
        $this->load->view('templates/common_template', $data);
    }

    /*
     * Save Driver
     */

    public function saveDriver() {
        $this->load->library('email');
        $driverObj = new Driver_model();
        $check = $driverObj->checkEmail($this->input->post('email'));
        if ($check) {

            $this->session->set_flashdata('errorMsg', 'This mail id already register with us!');
            redirect("add-drivers");
        } else {

            if ($driverObj->saveDriver()) {

                $myArr = 'added successfully.';
                $reply_message = '<p> Hello ' . $this->input->post('first_name') . '</p>'
                        . '<p>Your account has been succesfully created.</p>'
                        . '<p>&nbsp;</p>'
                        . '<p>Thanks & Regards</p>'
                        . '<p>Instacraft Team.</p>';

                $subject = 'Login Credential';
                $from_email_subject = "Instacraft";
                $mail = sendEmailGlobal($from_email_subject, $this->input->post('email'), $this->input->post('first_name'), $subject, $reply_message);

                $this->session->set_flashdata('SuccessMsg', $myArr);
                redirect("drivers");
            } else {
                $myArr = 'Something went wrong plz try again!';

                $this->session->set_flashdata('errorMsg', $myArr);
                redirect("drivers");
            }
        }
    }

    public function viewDriver() {
        $data['title'] = 'View Driver';
        $data['header'] = array(
            'view' => 'templates/header',
            'data' => $data);
        $data['sidebar'] = array(
            'view' => 'templates/common_sidebar',
            'data' => $data);
        $data['main_content'] = array(
            'view' => 'driver/view_driver',
            'data' => $data);
        $data['footer'] = array(
            'view' => 'templates/footer',
            'data' => $data);
        $this->load->view('templates/common_template', $data);
    }

    public function view_driver_detail() {
        $driverObj = new Driver_model();
        $result['personalDetail'] = $driverObj->getDriverDetails($this->uri->segment('2'));
        $result['driverInventory'] = $driverObj->getDriverInventory($this->uri->segment('2'));
        $result['driverOrders'] = $driverObj->getDriverOrders($this->uri->segment('2'));
        $result['driverStatistics'] = $driverObj->driverStatistics($this->uri->segment('2'));
        $result['mandatoryInventory']  = $driverObj->getDriverTemplateInventoryFront($this->uri->segment('2'));
        $result['driverWeekStatistics'] = $driverObj->driverWeekStatistics($this->uri->segment('2'), "", "");
        $result['driverAvailability'] = $driverObj->getDriverAvailability($this->uri->segment('2'), "", "");
        $this->load->view('driver/view_driver_details', $result);
    }

    public function manageInventory() {
        $driverObj = new Driver_model();
        
        $driverObj->setDriver_id($this->uri->segment('2'));
        $result['driverInventory']  = $driverObj->getDriverTemplateInventory();
        $result['driverTotalOrder'] = $driverObj->getDriverTotalOrder();
        $result['driverTemplate']   = $driverObj->getDriverTemplate();
        $result['allProduct']       = $driverObj->getAllProduct();
        $result['allWarehouse']     = $driverObj->getAllWarehouse();

        $this->load->view('driver/manageInventory', $result);
    }

    public function searchItem() {//ajax item search request
        $driverObj = new Driver_model();
        $driverObj->setItemSearch($this->input->post('item'));
        $result = $driverObj->getItemsFromInventory();
        echo json_encode($result);
    }

   /* public function assignPickups() {
        $driverObj = new Driver_model();

        $driverObj->setQuantity($this->input->post('quantity'));
        $driverObj->setItemId($this->input->post('itemId'));
        $driverObj->setWarehouseId($this->input->post('warehouseId'));
        $result = $driverObj->assignPickup($this->input->post('driverId'));
        if ($result) {
            redirect('manageInventory/' . $this->input->post('driverId'));
        }
    }*/

    public function removeAssignedProduct() {
        $driverObj = new Driver_model();
        $driverObj->setItemId($this->input->post('id'));
        $res = $driverObj->removeAssignedProduct();
        if($res){
            $this->session->set_flashdata('success_message', 'Item Deleted Successfully');
            $result = array("result"=>1,"data"=>array(),"message"=>"Item Deleted Successfully");
        }else{
            $this->session->set_flashdata('errors_message', 'Something Went Wrong!');   
            $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
        }
        echo json_encode($result); exit; 
    }

    public function updateAssignedQuantity() {
        $driverObj = new Driver_model();
        $driverObj->setItemId($this->input->post('id'));
        $driverObj->setQuantity($this->input->post('quantity'));
        $res = $driverObj->updateAssignedQuantity();
        if($res){
            $this->session->set_flashdata('success_message', 'Item Quantity Edited Successfully');
            $result = array("result"=>1,"data"=>array(),"message"=>"Item Quantity Edited Successfully");
        }else{
            $this->session->set_flashdata('errors_message', 'Something Went Wrong!');   
            $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
        }
        echo json_encode($result); exit; 
    }

    public function drivercompletedata() {
        $driverObj = new Driver_model();
        $hasDoctor = $driverObj->notemptyChecker($this->input->post('driverId'));
        if ($hasDoctor) {//if we have entry the update it
            $result = $driverObj->updateAvailTbl();
            redirect('view-driver-detail/' . $this->input->post('driverId'));
        } else {//if we donot have entry then we will insert
            $result = $driverObj->insertAvailTbl();
            //exit;
            redirect('view-driver-detail/' . $this->input->post('driverId'));
        }
        //$data = $driverObj->updateAvailDaysTime($availableTime);
    }

    public function customerReviews() {
        $driverObj = new Driver_model();
        $result['reviews'] = $driverObj->getdriverReviews($this->uri->segment('2'));
        //echo"<pre/>"; print_r($result); die;
        $this->load->view('driver/viewReviews', $result);
    }

    public function blockDriver() {
        $driverObj = new Driver_model();
        $result['blckUnblck'] = $driverObj->blockUnblockDriver($this->uri->segment('2'), $this->uri->segment('3'));
        redirect('view-driver-detail/' . $this->uri->segment('2'), $result);
    }

    public function viewShiftDetailedPage() {
        $driverObj = new Driver_model();
        $result['driverShift'] = $driverObj->viewShiftDetailedPageByDate($this->uri->segment('2'), $this->uri->segment('3'));

        $result['driverbreakShift'] = $driverObj->viewBreakShiftDetailedPageByDate($this->uri->segment('2'), $this->uri->segment('3'));
       
        $result['totalBreakTime'] = $driverObj->getTotalBreakData($this->uri->segment('2'),$this->uri->segment('3'));
     
        $result['deliveryDetails'] = $driverObj->getTotaldeliveryData($this->uri->segment('2'), $this->uri->segment('3'));
        //   echo "<pre>";print_r($result);exit;
        $this->load->view('driver/customizeShift', $result);
    }
   
    public function editWorkedTime() {
        $driverObj = new Driver_model();
        $result['workedTime'] = $driverObj->fetchWorkedInfo($this->uri->segment('2'), $this->uri->segment('3'));
        $this->load->view('driver/editCustomizeShift', $result);
    }

    public function editbreakTime() {
        $driverObj = new Driver_model();
        $result['breakTime'] = $driverObj->fetchBreakInfo($this->uri->segment('2'), $this->uri->segment('3'));
        $this->load->view('driver/editBreakShift', $result);
    }

    public function updateWorkedTime() {
        $driverObj = new Driver_model();
        $driverObj->setFrom_time($this->input->post('from_time'));
        $driverObj->setTo_time($this->input->post('to_time'));
        $driverObj->setPayable_amount($this->input->post('payable_amount'));
        $driverObj->setDriver_id($this->input->post('driver_id'));
        $driverObj->setShift_id($this->input->post('shift_id'));

        $driverObj->updateWorkedInfo();
        redirect('view-shift-detailed-page/' . $this->input->post('driver_id') . '/' . $this->input->post('date'));
    }

    public function updatebreakTime() {
        $driverObj = new Driver_model();
        $driverObj->setFrom_time($this->input->post('from_time'));
        $driverObj->setTo_time($this->input->post('to_time'));
        $driverObj->setPayable_amount($this->input->post('payable_amount'));
        $driverObj->setDriver_id($this->input->post('driver_id'));
        $driverObj->setShift_id($this->input->post('shift_id'));

        $driverObj->updateBreakInfo();
        redirect('view-shift-detailed-page/' . $this->input->post('driver_id') . '/' . $this->input->post('date'));
    }
    
    public function driverShiftTimeEdit(){
        $editTable = $this->input->post('edit');
        $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
        if($editTable=="shift"){
            $res = $this->updateDriverShiftTime();
            if($res){
                $this->session->set_flashdata('success_message', 'Shift Time Edited Successfully');
                $result = array("result"=>1,"data"=>array(),"message"=>"Shift Time Edited Successfully");
            }else{
                $this->session->set_flashdata('errors_message', 'Something Went Wrong!');   
                $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
            }
            echo json_encode($result); exit;
             
        }elseif ($editTable=="break") {
            $res = $this->updateDriverBreakTime();
            if($res){
                $this->session->set_flashdata('success_message', 'Break Time Edited Successfully');
                $result = array("result"=>1,"data"=>array(),"message"=>"Break Time Edited Successfully");
            }else{
                $this->session->set_flashdata('errors_message', 'Something Went Wrong!');   
                $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
            }
            echo json_encode($result); exit;
            
        }else{
            
            $this->session->set_flashdata('errors_message', 'Something Went Wrong!');
            echo json_encode($result); exit;
        }
        
    }
     
    public function driverShiftAmountEdit(){
        $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
        $driverObj = new Driver_model();
        $driverObj->setPayable_amount($this->input->post('payable_amount'));
        $driverObj->set_original_payable_amount($this->input->post('original_payable_amount'));
        $driverObj->setShift_id($this->input->post('shift_id'));
       
        $res = $driverObj->driverShiftAmountEdit();
      
        if($res){
            $this->session->set_flashdata('success_message', 'Amount Edited Successfully');
            $result = array("result"=>1,"data"=>array(),"message"=>"Amount Edited Successfully");
        }else{
            $this->session->set_flashdata('errors_message', 'Something Went Wrong!');   
            $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
        }
        echo json_encode($result); exit;

    }
    
    
    public function updateDriverBreakTime() {
        $driverObj = new Driver_model();
        $editType = $this->input->post('editType');
        
        $driverObj->set_break_id($this->input->post('id'));
        if($editType=="start_time"){
            $driverObj->setFrom_time($this->input->post('time'));
            $driverObj->updateDriverBreakTime();
            return true;
        }elseif($editType=="end_time"){
            $driverObj->setTo_time($this->input->post('time'));
            $driverObj->updateDriverBreakTime();
            return true;
        }else{
            return false;
        } 
    }
    
    public function updateDriverShiftTime() {
        $driverObj = new Driver_model();
        $editType = $this->input->post('editType');
       
        $driverObj->setShift_id($this->input->post('id'));
        
        if($editType=="start_time"){
            
            $driverObj->setFrom_time($this->input->post('time'));
            $driverObj->updateDriverShiftTime();
            return true;
        }elseif($editType=="end_time"){
            $driverObj->setTo_time($this->input->post('time'));
            $driverObj->updateDriverShiftTime();
           return true;
        }else{
            return false;
        } 
    }
    
    public function getTemplateItem(){

        $driverObj = new Driver_model();
        $driverObj->setDriver_id($this->input->post('driver_id'));
        $driverObj->set_template_id($this->input->post('template_id'));
        $res = $driverObj->getTemplateItem();
      
        if($res){
            $result = array("result"=>1,"data"=>$res,"message"=>"Amount Edited Successfully");
        }else{
            $result = array("result"=>0,"data"=>array(),"message"=>"No Record Found!");
        }
        echo json_encode($result); exit;
     // echo"<pre/>"; print_r($result); die;   
    }
    
    public function saveTemplateItem(){
        $driverObj = new Driver_model();
        $driverObj->set_template_id($this->input->post('template'));
        $driverObj->setItemId($this->input->post('product'));
        $driverObj->setQuantity($this->input->post('quantity'));
        $driverObj->setWarehouseId($this->input->post('pickup'));
        $res = $driverObj->saveTemplateItem();
        if($res){
           $this->session->set_flashdata('success_message', 'Product Added Successfully');
        }else{
           $this->session->set_flashdata('errors_message', 'Please fill the all required field'); 
        }
        redirect('manageInventory/' . $this->input->post('driver_id'));
     
    }
    
    public function assignTemplate(){
        $driverObj = new Driver_model();
        $driverObj->set_template_id($this->input->post('template_id'));
        $driverObj->setDriver_id($this->input->post('driver_id'));
        $res = $driverObj->assignTemplate();
     
        if($res){
            $this->session->set_flashdata('success_message', 'Template Assign Successfully');
            $result = array("result"=>1,"data"=>array(),"message"=>"Template Assign Successfully");
        }else{
            $this->session->set_flashdata('errors_message', 'Something Went Wrong!');   
            $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
        }
        echo json_encode($result); exit;
    }
    
    public function addTemplate(){
        $driverObj = new Driver_model();
        $driverObj->set_template_name($this->input->post('template_name'));
        $driverObj->setDriver_id($this->input->post('driver_id'));
        $res = $driverObj->addTemplate();
     
        if($res){
            $this->session->set_flashdata('success_message', 'Template Added Successfully');
            $result = array("result"=>1,"data"=>array(),"message"=>"Template Added Successfully");
        }else{
            $this->session->set_flashdata('errors_message', 'Template Name Already Exist!');   
            $result = array("result"=>0,"data"=>array(),"message"=>"Template Name Already Exist!");
        }
        echo json_encode($result); exit;
    }
    
    public function removeTemplate() {
        $driverObj = new Driver_model();
        $driverObj->setItemId($this->input->post('id'));
        $res = $driverObj->removeTemplate();
        if($res){
            $this->session->set_flashdata('success_message', 'Item Deleted Successfully');
            $result = array("result"=>1,"data"=>array(),"message"=>"Item Deleted Successfully");
        }else{
            $this->session->set_flashdata('errors_message', 'Something Went Wrong!');   
            $result = array("result"=>0,"data"=>array(),"message"=>"Something Went Wrong!");
        }
        echo json_encode($result); exit; 
    }
     
    

}
