<?php

class Doctor_model extends CI_Model {

    private $_status = "";
    private $_date = "";
    private $_search = "";

    function getStatus() {
   return $this->_status;
}

function getDate() {
   return $this->_date;
}

function getSearch() {
   return $this->_search;
}

function setStatus($status) {
   $this->_status =
           $status;
}

function setDate($date) {
   $this->_date =
           $date;
}

function setSearch($search) {
   $this->_search =
           $search;
}


    public function updateAvail($availablity) {
        if($availablity>0){
            $this->db->set('availablity','0')
                     ->where('id',$this->session->userdata('doctor_id'))
                     ->update('users');
            
        }else{
            $this->db->set('availablity','1')
                     ->where('id',$this->session->userdata('doctor_id'))
                     ->update('users');
            
        }
       
        return TRUE;
    }
    
    public function notemptyChecker($doctorId){
        $query = $this->db->select('*')
                            ->from('doctor_availability')
                            ->where('doctor_id', $doctorId)
                            ->get();
//        echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function insertAvailTbl(){
        if($_POST['mon']){
            $mon = '1'; 
        }else{
            $mon = '0';
        }
        if($_POST['tue']){
            $tue = '1'; 
        }else{
            $tue = '0';
        }
        if($_POST['wed']){
            $wed = '1'; 
        }else{
            $wed = '0';
        }
        if($_POST['thu']){
            $thu = '1'; 
        }else{
            $thu = '0';
        }
        if($_POST['fri']){
            $fri = '1'; 
        }else{
            $fri = '0';
        }
        if($_POST['sat']){
            $sat = '1'; 
        }else{
            $sat = '0';
        }
        if($_POST['sun']){
            $sun = '1'; 
        }else{
            $sun = '0';
        }
        $fromTime = $_POST['fromTime'];
        $toTime = $_POST['toTime'];    
        $data = array(
                        'doctor_id'=> $this->session->userdata('doctor_id'),
                        'mon' => $mon,
                        'tue' => $tue,
                        'wed' => $wed,
                        'thu' => $thu,
                        'fri' => $fri,
                        'sat' => $sat,
                        'sun' => $sun,
                        'from_time' => $this->input->post('fromTime'),
                        'to_time' => $this->input->post('toTime')
                     );
        $this->db->insert('doctor_availability', $data);
        return TRUE;
        
    }
    
    public function updateAvailTbl(){
        if($_POST['mon']){
            $mon = '1'; 
        }else{
            $mon = '0';
        }
        if($_POST['tue']){
            $tue = '1'; 
        }else{
            $tue = '0';
        }
        if($_POST['wed']){
            $wed = '1'; 
        }else{
            $wed = '0';
        }
        if($_POST['thu']){
            $thu = '1'; 
        }else{
            $thu = '0';
        }
        if($_POST['fri']){
            $fri = '1'; 
        }else{
            $fri = '0';
        }
        if($_POST['sat']){
            $sat = '1'; 
        }else{
            $sat = '0';
        }
        if($_POST['sun']){
            $sun = '1'; 
        }else{
            $sun = '0';
        }
        $fromTime = $_POST['fromTime'];
        $toTime = $_POST['toTime'];    
        $data = array(
                        'mon' => $mon,
                        'tue' => $tue,
                        'wed' => $wed,
                        'thu' => $thu,
                        'fri' => $fri,
                        'sat' => $sat,
                        'sun' => $sun,
                        'from_time' => $fromTime,
                        'to_time' => $toTime
                    );
        $this->db->where('doctor_id', $this->session->userdata('doctor_id'));
        $this->db->update('doctor_availability', $data);
        return true;
        
    }
    
    public function clientList(){
        $data = array();
        $query = $this->db->select("*")
                            ->from('appointment_details')
                            ->join('users','appointment_details.user_id = users.id','left')
                            ->where('doctor_id', $this->session->userdata('doctor_id'));
        
        if($this->getSearch() != ""){
            
            $query =  $this->db->like('users.first_name',trim(strtolower($this->getSearch())),'both'); 
            $query =  $this->db->or_like('users.last_name',trim(strtolower($this->getSearch())),'both'); 
        }
        if($this->getStatus() != ""){
            $query =  $this->db->where('status',$this->getStatus()); 
        }
        if($this->getDate() != ""){
            $query =  $this->db->where('appointment_date',date('Y-m-d',strtotime($this->getDate()))); 
        }
        
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        } 
        return $data;
    }
    
    public function prescriptionList(){
        $data = array();
        $query = $this->db->select("*")
                            ->from('appointment_details')
                            ->join('users','appointment_details.user_id = users.id','left')
                            ->where('doctor_id', $this->session->userdata('doctor_id'));
        
        if($this->getSearch() != ""){
            
            $query =  $this->db->like('users.first_name',trim(strtolower($this->getSearch())),'both'); 
            $query =  $this->db->or_like('users.last_name',trim(strtolower($this->getSearch())),'both'); 
        }
        if($this->getStatus() != ""){
            $query =  $this->db->where('status',$this->getStatus()); 
        }
        if($this->getDate() != ""){
            $query =  $this->db->where('appointment_date',date('Y-m-d',strtotime($this->getDate()))); 
        }
        
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        } 
        return $data;
    }
    
    public function detailsByClient($clientId){
        $query = $this->db->select('users.*, appointment_details.id as appointment_id, appointment_details.appointment_date, appointment_details.appointment_time, appointment_details.consultation_for, appointment_details.status')
                            ->from('users')
                            ->join('appointment_details','users.id = appointment_details.user_id')
                            ->where('users.id', $clientId)
                            ->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    
    public function prescriptionByClient($clientId){
        $query = $this->db->select('users.*, appointment_details.id as appointment_id,appointment_details.appointment_date, appointment_details.appointment_time, appointment_details.consultation_for, appointment_details.status, prescriptions.prescription_front_image, prescriptions.notes')
                            ->from('users')
                            ->join('appointment_details','users.id = appointment_details.user_id')
                            ->join('prescriptions','users.id = prescriptions.user_id')
                            ->where('users.id', $clientId)
                            ->group_by('appointment_date')
                            ->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    
    public function confirmClientAppointment($clientId){
        $data = array(
                        'status' => '1'
                    );
        $this->db->where('doctor_id', $this->session->userdata('doctor_id'));
        $this->db->where('user_id', $clientId);
        $this->db->update('appointment_details', $data);
        return true;

    }
    
    public function cancelClientAppointment($clientId,$cancelReason){
        $data = array(
                        'status' => '3',
                        'cancel_reason' => $cancelReason
                    );
        $this->db->where('doctor_id', $this->session->userdata('doctor_id'));
        $this->db->where('user_id', $clientId);
        $this->db->update('appointment_details', $data);
        return true;

    }
    public function rescheduleClientAppointment($clientId,$cancelReason,$date,$time){
        $data = array(
                        'status' => '2',
                        'cancel_reason' => $cancelReason,
                        'rescheduled_date' => $date,
                        'rescheduled_time' => $time
                    );
        $this->db->where('doctor_id', $this->session->userdata('doctor_id'));
        $this->db->where('user_id', $clientId);
        $this->db->update('appointment_details', $data);

        return true;

    }
    
    public function doctorData($userId) {
        $userDetail = $this->db->select('users.*, doctor_professional_information.specialization, doctor_professional_information.experience, doctor_professional_information.license_number, doctor_professional_information.signature_or_document')
                            ->from('users')
                            ->join('doctor_professional_information','users.id = doctor_professional_information.doctor_id','left')
                            ->where('users.id', $userId)
                            ->get();
//        echo $this->db->last_query();
//        exit;
        if ($userDetail->num_rows() > 0) {
            $data['data'] = $userDetail->row_array();
            return $data;
        }
    }
    
    public function doctorProfileUpdate($pic,$sign) {
        $dataUsers = array(
                        'profile_pic' => $pic,
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'email' => $this->input->post('email'),
                        'phone_number' => $this->input->post('phone_number'),
                        'address' => $this->input->post('address')
                    );
        $dataProffessionalInfo = array(
                        'specialization' => $this->input->post('specialization'),
                        'experience' => $this->input->post('experience'),
                        'license_number' => $this->input->post('license_number'),
                        'signature_or_document' => $sign
                    );
        $dataProffessionalInfoINSERT = array(
                        'doctor_id' => $this->session->userdata('doctor_id'),
                        'specialization' => $this->input->post('specialization'),
                        'experience' => $this->input->post('experience'),
                        'license_number' => $this->input->post('license_number'),
                        'signature_or_document' => $sign
                    );
        $this->db->where('id', $this->session->userdata('doctor_id'));
        $this->db->update('users', $dataUsers); 
//        echo "<pre>";
//        print_r($dataUsers);
//        print_r($dataProffessionalInfo);
//        exit;
        $queryCount = $this->db->select("*")
                            ->from('doctor_professional_information')
                            ->where('doctor_id', $this->session->userdata('doctor_id'))
                            ->get();

        if(sizeof($queryCount->row_array())>0){
            $this->db->where('doctor_id', $this->session->userdata('doctor_id'));
            $this->db->update('doctor_professional_information', $dataProffessionalInfo);   
          
        }else{
            $this->db->insert('doctor_professional_information', $dataProffessionalInfoINSERT);
        }
        
        
//        echo "<pre>";
//        echo $this->db->last_query();     exit; 
        return TRUE;
    }
    
    
    public function savePdf($link,$notes,$userId,$appointment_id) {
        $presc = array(
                        'user_id'   => $userId,
                        'prescription_front_image' => $link,
                        'notes' =>  $notes,
                        'appointment_id'  => $appointment_id,
                        'doctor_id' => $this->session->userdata('doctor_id')
                    );
        $this->db->insert('prescriptions', $presc);    
        return TRUE;
    }
    
    public function checkIncomingCall(){
        $where = "timestamp(DATE_SUB(NOW(), INTERVAL 300 MINUTE)) between date_sub(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) and date_add(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 15 MINUTE)";
        $this->db->select('id as appointment_id,status,appointment_time,appointment_date,videoRoomId');
        $this->db->where('doctor_id',$this->session->userdata('doctor_id'));
        $this->db->where('videoRoomId is NOT NULL', NULL, FALSE);
        $this->db->where('call_status', 'ringing');
        $this->db->where($where);
        $query   =   $this->db->get('appointment_details');
        return $query->row();
    }
    
    public function validateAppointment(){
        $where = "current_timestamp() between date_sub(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) and date_add(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 15 MINUTE)";
        $this->db->select('id as appointment_id,status,appointment_time,appointment_date');
        $this->db->where('doctor_id',$this->session->userdata('doctor_id'));
        $this->db->where('id',$this->session->userdata('apt_id'));
        $this->db->where('status','1');
        $this->db->where($where);
        $query   =   $this->db->get('appointment_details');
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function getDoctorData($userId) {
        $userDetail = $this->db->select('users.*, doctor_professional_information.specialization, doctor_professional_information.experience, doctor_professional_information.license_number, doctor_professional_information.signature_or_document')
                            ->from('users')
                            ->join('doctor_professional_information','users.id = doctor_professional_information.doctor_id','left')
                            ->where('users.id', $userId)
                            ->get();
        if ($userDetail->num_rows() > 0) {
            return $userDetail->row();
        }
    }
    
    public function getCustomerEmail($userId) {
        $userDetail = $this->db->select('u.email')
                            ->from('appointment_details as ad')
                            ->join('users as u','u.id = ad.user_id','left')
                            ->where('ad.id', $userId)
                            ->get();
        if ($userDetail->num_rows() > 0) {
            return $userDetail->row();
        }
    }


}
