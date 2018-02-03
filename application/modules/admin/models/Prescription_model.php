<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prescription_model extends CI_Model {
    private $_appointment_id;
    private $_created_at;
    private $_doctor_id;
    private $_expire_date;
    private $_id;
    private $_is_approved;
    private $_notes;
    private $_prescription_back_image;
    private $_prescription_front_image;
    private $_reason;
    private $_updated_at;
    private $_uploaded_by;
    private $_user_id;
    private $_valid_till;
    
    function getAppointment_id() {
        return $this->_appointment_id;
    }

    function getCreated_at() {
        return $this->_created_at;
    }

    function getDoctor_id() {
        return $this->_doctor_id;
    }

    function getExpire_date() {
        return $this->_expire_date;
    }

    function getId() {
        return $this->_id;
    }

    function getIs_approved() {
        return $this->_is_approved;
    }

    function getNotes() {
        return $this->_notes;
    }

    function getPrescription_back_image() {
        return $this->_prescription_back_image;
    }

    function getPrescription_front_image() {
        return $this->_prescription_front_image;
    }

    function getReason() {
        return $this->_reason;
    }

    function getUpdated_at() {
        return $this->_updated_at;
    }

    function getUploaded_by() {
        return $this->_uploaded_by;
    }

    function getUser_id() {
        return $this->_user_id;
    }

    function getValid_till() {
        return $this->_valid_till;
    }

    function setAppointment_id($appointment_id) {
        $this->_appointment_id = $appointment_id;
        return $this;
    }

    function setCreated_at($created_at) {
        $this->_created_at = $created_at;
        return $this;
    }

    function setDoctor_id($doctor_id) {
        $this->_doctor_id = $doctor_id;
        return $this;
    }

    function setExpire_date($expire_date) {
        $this->_expire_date = $expire_date;
        return $this;
    }

    function setId($id) {
        $this->_id = $id;
        return $this;
    }

    function setIs_approved($is_approved) {
        $this->_is_approved = $is_approved;
        return $this;
    }

    function setNotes($notes) {
        $this->_notes = $notes;
        return $this;
    }

    function setPrescription_back_image($prescription_back_image) {
        $this->_prescription_back_image = $prescription_back_image;
        return $this;
    }

    function setPrescription_front_image($prescription_front_image) {
        $this->_prescription_front_image = $prescription_front_image;
        return $this;
    }

    function setReason($reason) {
        $this->_reason = $reason;
        return $this;
    }

    function setUpdated_at($updated_at) {
        $this->_updated_at = $updated_at;
        return $this;
    }

    function setUploaded_by($uploaded_by) {
        $this->_uploaded_by = $uploaded_by;
        return $this;
    }

    function setUser_id($user_id) {
        $this->_user_id = $user_id;
        return $this;
    }

    function setValid_till($valid_till) {
        $this->_valid_till = $valid_till;
        return $this;
    }

    
    public function updatePrescriptionStatus(){
        
        $prescriptioId = $this->getId();
        $isApproved = $this->getIs_approved();
        $reason = $this->getReason();
        $this->db->set(array('is_approved'=>$isApproved, 'reason'=>$reason))->where('id', $prescriptioId)->update('prescriptions');
        return true;
        
    }

}
