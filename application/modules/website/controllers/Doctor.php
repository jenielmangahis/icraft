<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Doctor extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('doctor_id') == null){
            redirect('login');
        }else{
            
        }
        $this->load->model("doctor_model");
        $this->load->model("Login_model");
        $this->load->library('S3');

    }
    
    public function dashboard() {
        $webObj = new Doctor_model();
        $timeSlots   = $webObj->getTimeSlots();
        $a_timeslots = array();
        foreach( $timeSlots as $t ){
            $a_timeslots[] = date("g:i A", strtotime($t->time));
        }

        $schedules       = $webObj->getDoctorTimeSchedules();
        $group_schedules = array();
        foreach($schedules as $s){
            $group_schedules[$s->day][] = array('from' => $s->from_time, 'to' => $s->to_time);
        }
                
        $result['schedules'] = $group_schedules;
        $result['timeslots'] = $a_timeslots;
        $this->load->view('dashboard.php', $result);
    }

    public function analysis() {        
        $webObj = new Doctor_model();

        $date = date("Y-m-d");        
        $ts   = strtotime($date);        
        $dow  = date('w', $ts);
        $offset = $dow - 1;
        if ($offset < 0) {
            $offset = 6;
        }
        
        $ts = $ts - $offset*86400;     
        $appointments = array();   
        for ($i = 0; $i < 7; $i++, $ts += 86400){
            $date = date("Y-m-d", $ts);
            $appointments[$date] = $webObj->getDoctorAppointmentsByDate($date);
        }

        $result['appointments'] = $appointments;
        $is_mobile = isMobile();
        if( $is_mobile ){
            $this->load->view('analysis_mobile.php',$result);
        }else{
            $this->load->view('analysis_desktop.php',$result);
        }        
    }
    
    public function updateStatus() {
        $webObj = new Doctor_model();
        $availablity = trim($this->input->post('availablity'));
        $data = $webObj->updateAvail($availablity);//update doctor's availability
        
    }
    
    public function updateDaysAndTime() {                
        $webObj = new Doctor_model();
        //check entry is availble or not if available then update else make new entry
        $hasDoctor = $webObj->notemptyChecker($this->session->userdata('doctor_id'));
        if($hasDoctor){//if we have entry the update it
            $result = $webObj->updateAvailTbl();
            redirect('dashboard');
        }else{//if we donot have entry then we will insert
            $result = $webObj->insertAvailTbl();
            redirect('dashboard');
        }
        $data = $webObj->updateAvailDaysTime($availableTime);
    }

    public function updateDoctorSchedules() {
        $webObj = new Doctor_model();
        $result = $webObj->addDoctorSchedules();
        redirect('dashboard');
    }
    
    public function appointments() {
        
        $webObj = new Doctor_model();

        if($this->input->get('search') != ''){             
            $webObj->setSearch($this->input->get('search'));
        }
        if($this->input->get('status') != ''){ 
            $webObj->setStatus($this->input->get('status'));
        }
        if($this->input->get('date') != ''){ 
            $webObj->setDate($this->input->get('date'));
        }
        
        $data = $webObj->clientList();//get all client's list by doctor Id
        //echo "<pre>";print_r($data);die;
        $result['appointments'] = $data;

        $is_mobile = isMobile();
        if( $is_mobile ){
            $this->load->view('appointments_mobile.php',$result);
        }else{
            $this->load->view('appointments_desktop.php',$result);
        }
    }
    
    public function prescriptions() {
        $webObj = new Doctor_model();

        if($this->input->get('search') != ''){             
            $webObj->setSearch($this->input->get('search'));
        }
        if($this->input->get('status') != ''){ 
            $webObj->setStatus($this->input->get('status'));
        }
        if($this->input->get('date') != ''){ 
            $webObj->setDate($this->input->get('date'));
        }
        
        $data = $webObj->prescriptionList();//get all client's prescriptionList list by doctor Id
        $result['prescriptions'] = $data;
        $is_mobile = isMobile();
        if( $is_mobile ){
            $this->load->view('prescriptions_mobile.php',$result);
        }else{
            $this->load->view('prescriptions_desktop.php',$result);
        }        
    }
    
    public function clientDetailedPage() {
        $webObj = new Doctor_model();
        $data = $webObj->detailsByClient($this->uri->segment('2'));//complete detail client wise
        $result['client'] = $data;
        $result['call_url'] = base_url().'cus-video-consultation?roomName='.$this->input->post('room').'&doctor=yes&appointment_id='.$this->input->post('appointment_id');
        $result['appointment_id'] = $this->input->post('appointment_id');
        $result['room'] = $this->input->post('room');
        $is_mobile = isMobile();
        if( $is_mobile ){
            $this->load->view('clientDetail_mobile.php',$result);
        }else{
            $this->load->view('clientDetail_desktop.php',$result);
        }           
    }
    
    public function recommendation() {
        $webObj = new Doctor_model();        
        $data = $webObj->detailsByClient($this->uri->segment('2'));//complete detail client wise                
        $result['client'] = $data;
        $result['call_url'] = base_url().'cus-video-consultation?roomName='.$this->input->post('room').'&doctor=yes&appointment_id='.$this->input->post('appointment_id');
        $result['appointment_id'] = $this->input->post('appointment_id');
        $result['room'] = $this->input->post('room');
        $is_mobile = isMobile();
        if( $is_mobile ){
            $this->load->view('recommendation_mobile.php',$result);
        }else{
            $this->load->view('recommendation_desktop.php',$result);
        }        
    }
    
    public function confirmAppointment() {
        $webObj = new Doctor_model();
        $data = $webObj->confirmClientAppointment($this->input->post('user_id'));//appointment confirmation
        echo $data;
        
    }
    
    public function cancelAppointment() {
        $webObj = new Doctor_model();
        $data = $webObj->cancelClientAppointment($this->input->post('user_id'),$this->input->post('cancel_reason'));//cancel appointment
        echo $data;
        
    }
    
    public function rescheduleAppointment() {
        $webObj = new Doctor_model();
        $data = $webObj->rescheduleClientAppointment($this->input->post('user_id'),$this->input->post('reschedule_reason'),$this->input->post('pickerDate'),$this->input->post('timepicker'));
        echo $data;
        
    }
    
    public function profile() {
        $webObj = new Doctor_model();
        $data = $webObj->doctorData($this->session->userdata('doctor_id'));
        $result['data'] = $data;
//        echo "<pre>";
//        print_r($data);exit;
        $this->load->view('profile.php', $result);
    }
    
    
    public function updateProfile() {
        $webObj = new Doctor_model();
//        echo "<pre>";
//        print_r($_FILES);
//        print_r($_POST);
//        exit;
        /********* Upload Logo ****************************/
        if(!empty($_FILES["profile_pic"]['name'])) {
            $profile_new_name=time().$_FILES["profile_pic"]['name'];
            $profileTempName=$_FILES["profile_pic"]['tmp_name'];
            $profile_url = uploadImageOnS3($profile_new_name,$profileTempName,'profile');
        }else{
            $profile_url = $_POST['profile_pic_old'];
        }

        
        if(!empty($_FILES["signature"]['name'])) {
            $signature_new_name=time().$_FILES["signature"]['name'];
            $signatureTempName=$_FILES["signature"]['tmp_name'];
            $signature_url = uploadImageOnS3($signature_new_name,$signatureTempName,'signature');
        }else{
            $signature_url = $_POST['signature_old'];
        }
        
        $webObj->doctorProfileUpdate($profile_url,$signature_url);
        redirect('profile');        
    }
    
    
    public function generatePdf() {
        $webObj = new Doctor_model();
//       
        $userId         = $this->input->post('userId');
        $notes          = $this->input->post('notes');
        $appointment_id = $this->input->post('appointmentId');
        $data = '';
        $html = $this->load->view('generatePdf.php',$data,true);
       
     
        //this the the PDF filename that user will get to download
        $pdfFilePath = FCPATH . "pdf/prescription_".$appointment_id.".pdf";
        
        //load mPDF library
        $this->load->library('M_pdf');
        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();
        //generate the PDF!
        $stylesheet = file_get_contents(FCPATH  . "assets/css/instastyle.css"); // external css
        
        $pdf->WriteHTML($stylesheet,1);
        $pdf->WriteHTML($html,2);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $pdf->Output($pdfFilePath, "F");
        $userpdfLink = base_url() . "pdf/prescription_".$appointment_id.".pdf";
        $result = $webObj->savePdf($userpdfLink,$notes,$userId,$appointment_id);
        
        /*****************Send Mail To Customer *****************/
        $customer = $webObj->getCustomerEmail($appointment_id);
        if($customer){
        //Load email library
        $this->load->library('email');

        //SMTP & mail configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'developerravindrasingh@gmail.com',
            'smtp_pass' => 'zqpcethlxsiiioky',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        
        $this->email->from('info@instacraft.com', 'Ravi');
        $this->email->to($customer->email); 
        //Email content
        $htmlContent  = '<h1>Doctor recommended prescription</h1>';
        $htmlContent .= '<p>Please find the attached prescription document.</p>';

        $this->email->reply_to('noreply@instacraft.com', 'instacraft');
        $this->email->attach($pdfFilePath);
        $this->email->subject('Doctor recommended prescription');
        $this->email->message($htmlContent);
// Set to, from, message, etc.

        $this->email->send();
        }

        /**********************************/

        //return $userpdfLink;
        redirect('prescriptions');
    }
    
    public function prescriptionDetail(){
        $webObj = new Doctor_model();
        $data = $webObj->prescriptionByClient($this->uri->segment('2'));//complete detail client wise        
        $result['client'] = $data;        
        $is_mobile = isMobile();        
        if( $is_mobile ){
            $this->load->view('prescriptionDetail_mobile.php',$result);
        }else{
            $this->load->view('prescriptionDetail_desktop.php',$result);
        }        
    }
    
    public function checkIncomingCall(){
        $webObj = new Doctor_model();
        $data = $webObj->checkIncomingCall();//complete detail client wise
        echo json_encode($data);die;
    }

    public function updatePrescriptionNotes(){       
        print_r($_POST);
        $webObj = new Doctor_model();
        $result = $webObj->updatePrescriptionNotes($_POST['prescription_id'], $_POST['notes']);
        redirect('prescriptionDetail/' . $_POST['userId']);

    }

    public function updatePrescriptionRecommendations(){               
        $webObj = new Doctor_model();
        $result = $webObj->updatePrescriptionRecommendations($_POST['prescription_id'], $_POST['recommendations']);
        $refer =  $this->agent->referrer();
        redirect($refer);

    }
    
    public function test(){
        
    }
 }       