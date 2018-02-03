<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Caregiver extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/Customer_model');
        $this->load->model('customer/Caregiver_model');
        $this->load->model('customer/Products_model');
        $this->load->model('customer/Settings_model');
        $this->load->helper('user_helper');
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->library('s3');
        if ($this->session->userdata('CUSTOMER-SL') == '') {
            redirect('cus-login');
        }
        checkCartQuantity();
    }

    public function deliveryDateTime() {

        $custObj = new Customer_model();
        $careObj = new Caregiver_model();
        $setting = new Settings_model();
        $prodObj = new Products_model();
        if($careObj->AddToCartTotalAmount() <= 0){
            redirect('cus-our-products');
        }
        $output['title'] = 'Caregiver Form';
        $output['pageName'] = 'Caregiver Form';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-add-tocart';
        $output['products'] = $prodObj->AddToCart();
        if ($this->input->is_ajax_request()) {
            $this->session->set_userdata('delivery_date_time',$this->input->post('delivery_date_time'));
            $this->session->set_userdata('delivery_address',$this->input->post('delivery_address'));
            $this->session->set_userdata('delivery_lat_lng',$this->input->post('delivery_lat_lng'));
            $data['success'] = true;
            echo json_encode($data);
            die;
        }
        $output['cartTotal']  =   $careObj->AddToCartTotalAmount();
        $output['restrictedAreas'] = $setting->getAllRestrictedAreas();
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/delivery_time_date');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    
    public function caregiverFirst() {
        if($this->session->userdata('delivery_date_time') != '' && $this->session->userdata('delivery_address') != '') {
            $proObj = new Products_model();
            $custObj = new Customer_model();
            $careObj = new Caregiver_model();
            $output['title'] = 'Caregiver Details';
            $output['pageName'] = 'Caregiver Details';
            $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-add-tocart';
            $output['userDetail'] = $custObj->getUserRecordBySlug();
            $output['minimumDeliveryAmount'] = $proObj->getMinimumDeliveryAmount();

            if (!empty($_POST)) {

                $this->form_validation->set_rules('full_name', 'Full Name', 'required');
                //$this->form_validation->set_rules('dob', 'dob', 'required');
                $this->form_validation->set_rules('phone_number', 'phone_number', 'required');
                $this->form_validation->set_rules('home_address', 'Home Address', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('state', 'State', 'required');
                $this->form_validation->set_rules('zip', 'Zip', 'required');
                //$this->form_validation->set_rules('country', 'Country', 'required');
                //$this->form_validation->set_rules('medical_certification', 'Medical certification', 'required');

                $failure = false;
                $errorMsg = "";

                if ($this->form_validation->run()) {

                    $careObj->set_full_name($this->input->post('full_name'));
                    $careObj->set_dob($this->input->post('dob'));
                    $careObj->set_phone_number($this->input->post('phone_number'));
                    $careObj->set_home_address($this->input->post('home_address'));
                    $careObj->set_city($this->input->post('city'));
                    $careObj->set_state($this->input->post('state'));
                    $careObj->set_zip($this->input->post('zip'));
                    $careObj->set_country($this->input->post('country'));
                    $careObj->set_medical_certification($this->input->post('medical_certification'));

                    /*                 * ****** Insert user record ***************** */
                    $res = $careObj->caregiverFirstStep();
                    
                    if ($res === true) {
                        $success_message = 'First step completed successfully.';
                    } else {
                        $errorMsg = 'Something went wrong, Please try again later.';
                        $failure = true;
                    }
                } else {
                    $errorMsg .= validation_errors();
                    $failure = true;
                }
                if ($this->input->is_ajax_request()) {
                    if ($failure) {
                        $data['success'] = false;
                        $data['error_message'] = $errorMsg;
                    } else {
                        $data['success'] = true;
                        $data['url'] = site_url('cus-caregiver-step2');
                        $data['resetForm'] = false;
                        $data['success_message'] = $success_message;
                    }
                    $data['scrollToThisForm'] = true;
                    echo json_encode($data);
                    die;
                }
            }

            $this->load->view($this->config->item('customer') . '/mobile/header', $output);
            $this->load->view($this->config->item('customer') . '/mobile/caregiver_first');
            $this->load->view($this->config->item('customer') . '/mobile/footer');
        }else {
            redirect('cus-delivery-datetime');
        }
    }

    public function caregiverSecond() {
        /******* check if caregiver form first is filled or not. If no then redirect to first caregiver form *********** */
        if (sizeof($this->session->userdata('caregiver_first')) > 0) {
            $careObj = new Caregiver_model();
            $output['title'] = 'Caregiver Details';
            $output['pageName'] = 'Caregiver Details';
            $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-caregiver-step1';
            if (!empty($_FILES)) {
                $new_name = time() . $_FILES["image"]['name'];
                $fileTempName = $_FILES["image"]['tmp_name'];
                //$profile_image = uploadImageOnS3($new_name, $fileTempName, 'customer');
                $profile_image = 's3 image url';
                $res = $careObj->caregiverSecondStep($profile_image);
                
                $success_message = 'Form submitted successfully.';

                if ($this->input->is_ajax_request()) {
                    if (!$res) {
                        $data['success'] = false;
                        $data['error_message'] = $errorMsg;
                    } else {
                        $data['success'] = true;
                        $data['resetForm'] = false;
                        $data['success_message'] = $success_message;
                    }
                    $data['scrollToThisForm'] = true;
                    echo json_encode($data);
                    die;
                }
            }

            $this->load->view($this->config->item('customer') . '/mobile/header', $output);
            $this->load->view($this->config->item('customer') . '/mobile/caregiver_second');
            $this->load->view($this->config->item('customer') . '/mobile/footer');
        } else {
            redirect('cus-caregiver-step1');
        }
    }
    
    public function caregiverFinal() {
        //if ($this->session->userdata('caregiver_second') != '') {
            $failure = false;
            $careObj = new Caregiver_model();
            $custObj = new Customer_model();
            $output['title'] = 'Caregiver View';
            $output['pageName'] = 'Caregiver View';
            $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-caregiver-step2';
            if (!empty($_POST)) {
                $res = $careObj->caregiverFinal();
                if ($res['order_id'] != '' && $res['payable_amount'] != '') {
                    $success_message = 'Redirectig to payment gateway, Please wait...';
                } else {
                    $errorMsg = 'Something went wrong, Please try again later.';
                    $failure = true;
                }
                if ($this->input->is_ajax_request()) {
                    if ($failure) {
                        $data['success'] = false;
                        $data['error_message'] = $errorMsg;
                    } else {
                        $data['success'] = true;
                        $data['resetForm'] = false;
                        $data['success_message'] = $success_message;
                        $data['order_id'] = $res['order_id'];
                        $data['payable_amount'] = $res['payable_amount'];
                    }
                    $data['scrollToThisForm'] = true;
                    echo json_encode($data);
                    die;
                }
            }
            $output['careGivers'] =   $careObj->getAllCaregiversAgainstCart();
            $output['userRecord'] = $custObj->getUserRecordBySlug();
            
            $this->load->view($this->config->item('customer') . '/mobile/header', $output);
            $this->load->view($this->config->item('customer') . '/mobile/caregiver_forms');
            $this->load->view($this->config->item('customer') . '/mobile/footer');
//        } else {
//            redirect('cus-caregiver-step2');
//        }
    }

    public function caregiverDesignationForm() 
    {
        $cusObj = new Customer_model();
        $output['title'] = 'Caregiver Designation Form';
        $output['pageName'] = 'Caregiver Designation Form';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'customer/Customer/caregiverDesignationForm';
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/caregiver_designation_forms');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
}
