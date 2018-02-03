<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Payment extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/Payment_model');
        $this->load->helper('common_helper');
        $this->load->helper('user_helper');
        $this->load->helper('url');
        $this->load->library('s3');
        if ($this->session->userdata('CUSTOMER-SL') == '') {
            redirect('cus-login');
        }
        checkCartQuantity();
    }

    public function checkDoctorAvailbility() {
        $paymentObj = new Payment_model();
        $selectedTime = $this->input->post('selectedTime');
        $selectedDate = $this->input->post('selectedDate');
        $this->session->set_userdata('selectedTime', $selectedTime);
        $this->session->set_userdata('selectedDate', $selectedDate);
        $docId  =   $paymentObj->getRandomDoctor()->id;
        echo json_encode($docId);die;
    }
    
    public function makePrescriptionPayment() {
        $paymentObj = new Payment_model();
        $paymentObj->makePrescriptionPayment();
        echo "Payment successfully made";
        redirect('cus-my-prescription');
    }

    public function makeProductsPayement() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://54.245.183.187/shaco/product_form.php');
        curl_setopt($ch, CURLOPT_FAILonerror, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "order_id=".$this->input->post('order_id')."&payable_amount=".$this->input->post('payable_amount'));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
