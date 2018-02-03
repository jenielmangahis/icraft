<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cus_prescription_model extends CI_Model {
    
    private $_prescription_front_image = "";
    private $_prescription_back_image = "";
    private $_uploaded_by = "";
    private $_user_id = "";
    function get_user_id() {
        return $this->_user_id;
    }

    function set_user_id($_user_id) {
        $this->_user_id = $_user_id;
    }

    function get_uploaded_by() {
        return $this->_uploaded_by;
    }

    function set_uploaded_by($_uploaded_by) {
        $this->_uploaded_by = $_uploaded_by;
    }

    function get_prescription_front_image() {
        return $this->_prescription_front_image;
    }
    
    function get_prescription_back_image() {
        return $this->_prescription_back_image;
    }

    function get_upoaded_by() {
        return $this->_upoaded_by;
    }

    function set_prescription_front_image($_prescription_front_image) {
        $this->_prescription_front_image = $_prescription_front_image;
    }
    
    function set_prescription_back_image($_prescription_back_image) {
        $this->_prescription_back_image = $_prescription_back_image;
    }

    public function getAllConsultationTypes(){
        $this->db->select("id,name,is_other");
        $query =   $this->db->get('consultation_type');
        return $query->result();
    }
    
    public function uploadMedicalLicense(){
        $new_name = time() . $_FILES["prescription_image"]['name'];
        $fileTempName = $_FILES["prescription_image"]['tmp_name'];
        $front_image = uploadImageOnS3($new_name,$fileTempName,'customer');
        //$front_image = $fileTempName;
        $this->set_prescription_front_image($front_image);
        
        $back_image = time() . $_FILES["prescription_image_back"]['name'];
        $fileTempName = $_FILES["prescription_image_back"]['tmp_name'];
        $back_image = uploadImageOnS3($back_image,$fileTempName,'customer');
        //$back_image = $fileTempName;
        $this->set_prescription_back_image($back_image);
        
        $class_vars = get_object_vars($this);
        foreach ($class_vars as $key => $var) {
            if (!empty($var)) {
                $dataVal = "get$key";
                $data[ltrim($key, '_')] = $this->$dataVal();
            }
        }
        
        $this->db->insert('prescriptions',$data);
        $lastInsertedId =   $this->db->insert_id();
        return $lastInsertedId;
    }
    
    public function saveAppointment(){
        
    }
    
    public function getRandomDoctor(){
        $this->db->select('users.id,first_name');        
        $this->db->from('users left');        
        $this->db->join('appointment_details','appointment_details.doctor_id=users.id','left');        
        $this->db->where('user_type','1');
        $this->db->order_by('rand()');
        $query  =   $this->db->get();
        return $query->row();
    }
    
    public function getMyPrescription(){
        $this->db->select('appointment_details.id,appointment_details.user_id,appointment_details.appointment_date,appointment_details.appointment_time,appointment_details.created_at,users.first_name,users.last_name');
        $this->db->where('user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->where('users.user_type','1');
        $this->db->join('users','appointment_details.doctor_id=users.id','left');
        $this->db->order_by('appointment_date','desc');
        $doctor_prescriptions  =   $this->db->get('appointment_details');
        $data['doctor_prescriptions']   =    $doctor_prescriptions->result();
        
        $this->db->select('prescriptions.prescription_front_image,prescriptions.expire_date,prescriptions.is_approved,prescriptions.created_at,users.first_name,users.last_name');
        $this->db->where('user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->where('users.user_type','1');
        $this->db->join('users','prescriptions.doctor_id=users.id','left');
        $this->db->order_by('created_at','desc');
        $my_prescriptions  =   $this->db->get('prescriptions');
        $data['my_prescriptions']   =    $my_prescriptions->result();
        
        return $data;
    }
    
    public function checkUpcomingAppointment(){
        $where = "timestamp(DATE_SUB(NOW(), INTERVAL 300 MINUTE)) between date_sub(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) and date_add(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 15 MINUTE)";
        $this->db->select('id as appointment_id,status,appointment_time,appointment_date');
        $this->db->where('user_id',$this->input->post('userId'));
        $this->db->where('status','1');
        $this->db->where('videoRoomId is NULL', NULL, FALSE);
        $this->db->where($where);
        $query   =   $this->db->get('appointment_details');
        return $query->row();
    }
    
    public function saveVideoRoom(){
        $this->db->set('videoRoomId',$this->input->post('videoRoomId'));
        $this->db->set('call_status','ringing');
        $this->db->where('id',$this->input->post('appointment_id'));
        $this->db->update('appointment_details');
    }
    
    public function removeVideoRoom(){
        $this->db->set('videoRoomId',NULL);
        $this->db->set('call_status',NULL);
        $this->db->where('id',$this->session->userdata('apt_id'));
        $this->db->update('appointment_details');
    }
    
    public function changeCallStatus(){
        $this->db->set('call_status','ongoing');
        $this->db->where('id',$this->input->post('appointment_id'));
        $this->db->update('appointment_details');
    }
    
    public function endCallStatus(){
        $this->db->where('user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->where('call_status','ringing');
        $this->db->set('videoRoomId',NULL);
        $this->db->set('call_status',NULL);
        $this->db->update('appointment_details');
    }

    
}
