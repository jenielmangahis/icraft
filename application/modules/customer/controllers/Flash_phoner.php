<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Flash_phoner extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/Customer_model');
        $this->load->model('customer/Cus_prescription_model');
        $this->load->model('website/Doctor_model');
        $this->load->helper('common_helper');
        $this->load->helper('user_helper');
        $this->load->helper('url');
        $this->load->library('s3');
    }

    function makeVideoCall() {
        if($this->input->post('appointment_id') != ''){
            $this->session->set_userdata('apt_id',$this->input->post('appointment_id'));
        }
        if($this->input->get('appointment_id') != ''){
            $this->session->set_userdata('apt_id',$this->input->get('appointment_id'));
        }
        if($this->input->get('doctor') != 'yes'){
    
            $custObj = new Customer_model();
            $output['title'] = 'Video Consultation';
            $output['pageName'] = 'Video Consultation';
            $output['header_class'] = '';
            $output['appointment_id']   =   $this->input->post('appointment_id');
            /******** check if appointment is valid ***************/
                //will write function over here for appointment id validatino
                $isValid    =   $custObj->validateAppointment();
                if(!$isValid){
                    redirect('cus-home');
                }
            /*********************************************************/
            $userRecord = $custObj->getUserRecordBySlug();
            if(sizeof($userRecord) <= 0){
                $output['userRecord']['email']   =   '123';
            }
            $output['userRecord']   =   $userRecord;
            $this->load->view($this->config->item('customer') . '/mobile/video_call', $output);
        }else{
            
            $docObj = new Doctor_model;
            $output['title'] = 'Video Consultation';
            $output['pageName'] = 'Video Consultation';
            $output['header_class'] = 'icon-back-arrow,' . $_SERVER['HTTP_REFERER'];
            $output['appointment_id']   =   $this->input->get('appointment_id');
            /******** check if appointment id is valid ***************/
                //will write function over here for appointment id validatino
//                $isValid    =   $docObj->validateAppointment();
//                if(!$isValid){
//                    redirect('cus-home');
//                }
            /*********************************************************/
            $userRecord = $docObj->getDoctorData($this->session->userdata('doctor_id'));
            if(sizeof($userRecord) <= 0){
                $output['userRecord']['email']   =   '123';
            }
            $output['userRecord']   =   $userRecord;
            $this->load->view($this->config->item('website') . '/video_call', $output);
        }
    }
    
    public function saveVideoRoom(){
        if($this->input->post('appointment_id') == '')
            redirect($_SERVER['HTTP_REFERER']);
        $presObj = new Cus_prescription_model();
        $data = $presObj->saveVideoRoom();
    }
    
    public function removeVideoRoom(){
        $presObj = new Cus_prescription_model();
        $data = $presObj->removeVideoRoom();
    }
    
    public function changeCallStatus(){
        $presObj = new Cus_prescription_model();
        $data = $presObj->changeCallStatus();
    }
    
    public function endCallStatus(){
        $presObj = new Cus_prescription_model();
        $data = $presObj->endCallStatus();
        echo json_encode($data);die;
    }
    
}
