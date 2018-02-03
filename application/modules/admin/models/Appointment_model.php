<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Appointment_model
 *
 * @author Vishal
 */
class Appointment_model extends CI_Model {

    //put your code here
    private $_id;
    private $_user_id;
    private $_doctor_id;
    private $_appointment_date;
    private $_appointment_time;
    private $_other_consultation_request;
    private $_paid_amount;
    private $_transaction_no;
    private $_rescheduled_date;
    private $_rescheduled_time;
    private $_status;
    private $_reschedule_resason;
    private $_cancel_reason;
    private $_consultation_for;
    private $_created_at;
    private $_updated_at;

    function getId() {
        return $this->_id;
    }

    function getUser_id() {
        return $this->_user_id;
    }

    function getDoctor_id() {
        return $this->_doctor_id;
    }

    function getAppointment_date() {
        return $this->_appointment_date;
    }

    function getAppointment_time() {
        return $this->_appointment_time;
    }

    function getOther_consultation_request() {
        return $this->_other_consultation_request;
    }

    function getPaid_amount() {
        return $this->_paid_amount;
    }

    function getTransaction_no() {
        return $this->_transaction_no;
    }

    function getRescheduled_date() {
        return $this->_rescheduled_date;
    }

    function getRescheduled_time() {
        return $this->_rescheduled_time;
    }

    function getStatus() {
        return $this->_status;
    }

    function getReschedule_resason() {
        return $this->_reschedule_resason;
    }

    function getCancel_reason() {
        return $this->_cancel_reason;
    }

    function getConsultation_for() {
        return $this->_consultation_for;
    }

    function getCreated_at() {
        return $this->_created_at;
    }

    function getUpdated_at() {
        return $this->_updated_at;
    }

    function setId($id) {
        $this->_id = $id;
        return $this;
    }

    function setUser_id($user_id) {
        $this->_user_id = $user_id;
        return $this;
    }

    function setDoctor_id($doctor_id) {
        $this->_doctor_id = $doctor_id;
        return $this;
    }

    function setAppointment_date($appointment_date) {
        $this->_appointment_date = $appointment_date;
        return $this;
    }

    function setAppointment_time($appointment_time) {
        $this->_appointment_time = $appointment_time;
        return $this;
    }

    function setOther_consultation_request($other_consultation_request) {
        $this->_other_consultation_request = $other_consultation_request;
        return $this;
    }

    function setPaid_amount($paid_amount) {
        $this->_paid_amount = $paid_amount;
        return $this;
    }

    function setTransaction_no($transaction_no) {
        $this->_transaction_no = $transaction_no;
        return $this;
    }

    function setRescheduled_date($rescheduled_date) {
        $this->_rescheduled_date = $rescheduled_date;
        return $this;
    }

    function setRescheduled_time($rescheduled_time) {
        $this->_rescheduled_time = $rescheduled_time;
        return $this;
    }

    function setStatus($status) {
        $this->_status = $status;
        return $this;
    }

    function setReschedule_resason($reschedule_resason) {
        $this->_reschedule_resason = $reschedule_resason;
        return $this;
    }

    function setCancel_reason($cancel_reason) {
        $this->_cancel_reason = $cancel_reason;
        return $this;
    }

    function setConsultation_for($consultation_for) {
        $this->_consultation_for = $consultation_for;
        return $this;
    }

    function setCreated_at($created_at) {
        $this->_created_at = $created_at;
        return $this;
    }

    function setUpdated_at($updated_at) {
        $this->_updated_at = $updated_at;
        return $this;
    }

    public function selectAppointmentDetailsByDoctor() {
        $doctorId = $this->getDoctor_id();

        $appointmentData = $this->db->select("ad.id as appoinment_id, trim(CONCAT(u.first_name, ' ', u.last_name)) as patient_name,"
                . " ad.user_id, ad.appointment_date, ad.appointment_time,"
                . " case ad.status "
                . " when 0 then 'pending' "
                . " when 1 then 'confirm'"
                . " when 2 then 'Reschedule',"
                . " else 'Cancelled'", false)
        ->from('appointment_details ad')
        ->join('users u', 'u.ud=ad.user_id')
        ->where('ad.doctor_id', $doctorId)
        ->order_by('ad.appointment_date', 'desc')
        ->get()
        ->result_array();
        
        return $appointmentData;
           
    }

}
