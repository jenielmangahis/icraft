<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prescription extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/Cus_prescription_model');
        $this->load->model('customer/Customer_model');
        $this->load->helper('common_helper');
        $this->load->helper('user_helper');
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->library('s3');
        if ($this->session->userdata('CUSTOMER-SL') == '') {
            redirect('cus-login');
        }
        checkCartQuantity();
    }

    public function consultations() {

        $presObj = new Cus_prescription_model();
        $output['title'] = 'New Consultation Request';
        $output['pageName'] = 'New Consultation Request';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';

        $output['header_class_right'][0] = 'icon-edit,javascript:;';
        $output['allConsultationsTypes'] = $presObj->getAllConsultationTypes();

        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/new_consultation_request');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function myPrescription() {

        $presObj = new Cus_prescription_model();
        $output['title'] = 'My Prescriptions';
        $output['pageName'] = 'My Prescriptions';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';

        $output['header_class_right'][0] = 'icon-add,'.base_url().'cus-medical-license';
        $output['allPrescription'] = $presObj->getMyPrescription();
        //print_r($output['allPrescription']);die;
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/my_prescription');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function medicalLicenceInfo() {

        $presObj = new Cus_prescription_model();
        $output['title'] = 'Medical License Info';
        $output['pageName'] = 'Medical License Info';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';

        $output['header_class_right'][0] = ','.base_url().'cus-new-prescription'.',skip';

        if (!empty($_POST)) {


            $presObj->set_uploaded_by('1');
            $presObj->set_user_id($this->session->userdata('CUSTOMER-ID'));

            /*             * ***** Insert medical license record ***************** */
            $res = $presObj->uploadMedicalLicense();
            $success_message = 'Medical License uploaded success.';

            if ($this->input->is_ajax_request()) {
                if ($failure) {
                    $data['success'] = false;
                    $data['error_message'] = $errorMsg;
                } else {
                    $data['success'] = true;
                    $data['url'] = site_url('cus-my-prescription');
                    $data['resetForm'] = false;
                    $data['success_message'] = $success_message;
                }
                $data['scrollToThisForm'] = true;
                echo json_encode($data);
                die;
            }
        }
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/medical_license');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function saveSelectedConsultations() {
        $cusObj = new Customer_model();
        // check for verification document against user
        $res = $cusObj->checkVerfificationDoc();
        if($res) { 
            $selectedConsultations = implode(',', $this->input->post('selectedValues'));
            $otherReason = $this->input->post('other_reason');
            $this->session->set_userdata('selectedConsultations', $selectedConsultations);
            $this->session->set_userdata('other_reason', $otherReason);
            $this->session->set_userdata('other_prescription', $this->input->post('other_prescription'));
            $this->session->set_userdata('other_doctor', $this->input->post('other_doctor'));
            $data['success']    =   $res;
            echo json_encode($data);die;
        }else {
            $data['success']    =   $res;
            echo json_encode($data);die;
        }
    }

    public function saveSelectedTime() {
        $selectedTime = $this->input->post('selectedTime');
        $selectedDate = $this->input->post('selectedDate');
        $this->session->set_userdata('selectedTime', $selectedTime);
        $this->session->set_userdata('selectedDate', $selectedDate);
    }

    public function cusTimeAvailability() {
        $presObj = new Cus_prescription_model();
        $output['title'] = 'Get Cannabis Prescription';
        $output['pageName'] = 'Get Cannabis Prescription';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-new-prescription';

        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/time_availability');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function checkUpcomingAppointment() {
        $presObj = new Cus_prescription_model();

        $result = $presObj->checkUpcomingAppointment();
        echo json_encode($result);
        die;
    }
    
//    public function downloadPrescription() {
//        ob_clean(); 
//        //$path   =   base_url().'pdf/prescription_'.$this->input->post('appointment_id').'pdf';
//        $path   =   base_url().'pdf/1506592566.pdf';
//        $data = file_get_contents($path); //assuming my file is on localhost
//        $name = 'recommended_prescription.pdf'; 
//        force_download($name,$data); 
//    }
    
    public function downloadPrescription()
    {
        $file   =   base_url().'pdf/prescription_'.$this->input->post('appointment_id').'pdf';
        $file   =   file_get_contents(base_url().'pdf/1506592566.pdf');
        //echo $file;die;
        //get the file extension
        $info = new SplFileInfo($file);
        var_dump($info->getExtension());
die;
        switch ($info->getExtension()) {
            case 'pdf':
            case 'png':
            case 'jpg':
                $contentDisposition = 'inline';
                break;
            default:
                $contentDisposition = 'attachment';
        }

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            // change inline to attachment if you want to download it instead
            header('Content-Disposition: '.$contentDisposition.'; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
        }
        else echo "Not a file";
    }
    
    

}
