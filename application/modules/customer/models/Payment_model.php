<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Payment_model extends CI_Model {
    
    public function getRandomDoctor(){
        $selectedDateTime   =   $this->session->userdata('selectedDate').' '.$this->session->userdata('selectedTime').':00';
        $timestamp          =   strtotime($this->session->userdata('selectedDate'));
        $day                =   strtolower(date('D', $timestamp));
        
        $where = "'$selectedDateTime' NOT BETWEEN CONCAT(appointment_date, ' ', appointment_time) and date_add(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 14 MINUTE)";
        
        $this->db->select('users.id,first_name');        
        $this->db->from('users');        
        $this->db->join('appointment_details as ad','ad.doctor_id=users.id','left');        
        $this->db->join('doctor_availability as da','da.doctor_id=users.id','left');        
        $this->db->where($where);
        $this->db->where("da.$day =",'1');
        $this->db->where("da.from_time <=",$this->session->userdata('selectedTime').':00');
        $this->db->where("da.to_time >=",$this->session->userdata('selectedTime').':00');
        $this->db->where('users.user_type','1');
        $this->db->limit('1');
        $this->db->order_by('rand()');
        $query  =   $this->db->get();
        return $query->row();
    }
    
    public function makePrescriptionPayment(){
        $data['doctor_id']  =   $this->getRandomDoctor()->id;
        $data['user_id']    =   $this->session->userdata('CUSTOMER-ID');
        $data['appointment_time']    =   $this->session->userdata('selectedTime');
        //$data['other_consultation_request']    =   $this->session->userdata('other_reason');
        $data['other_consultation_request']    =   1;
        $data['appointment_date']    =   $this->session->userdata('selectedDate');
        $data['paid_amount']    =   '';
        $data['transaction_no']    =   '';
        $data['consultation_for']    =   $this->session->userdata('selectedConsultations');
        $data['other_prescription']    =   $this->session->userdata('other_prescription');
        $data['other_doctor']    =   $this->session->userdata('other_doctor');
        //$data['videoRoomId'] =   $this->generateRandomString();
        $this->db->insert('appointment_details',$data);
        $lastInsertedId =   $this->db->insert_id();
        if($lastInsertedId != ''){
            /******** Insert transactio detail against apoointment_id *************/
            
            $stripeData =   unserialize($this->input->get('data'));
            $this->db->set('appointment_id',$lastInsertedId);
            $this->db->set('transaction_id',$stripeData['balance_transaction']);
            $this->db->set('amount_refunded',$stripeData['amount_refunded']);
            $this->db->set('paid_amount',$stripeData['amount']);
            $this->db->set('card_type',$stripeData['card_type']);
            $this->db->set('processing_fee',$stripeData['processing_fee']);
            $this->db->set('captured',$stripeData['captured']);
            $this->db->set('currency',$stripeData['currency']);
            $this->db->set('description',$stripeData['description']);
            $this->db->set('failure_code',$stripeData['failure_code']);
            $this->db->set('failure_message',$stripeData['failure_message']);
            $this->db->set('invoice',$stripeData['invoice']);
            if($stripeData['failure_code'] == ''){
                $this->db->set('status','success');
            }else{
                $this->db->set('status','fail');
            }
            $this->db->insert('tbl_appointment_transaction');
            
            /**********************************************************************/
            
            $this->session->unset_userdata('selectedConsultations');
            $this->session->unset_userdata('other_reason');
            $this->session->unset_userdata('other_prescription');
            $this->session->unset_userdata('other_doctor');

            $this->session->unset_userdata('selectedTime');
            $this->session->unset_userdata('selectedDate');
        }
    }
    
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    
}
