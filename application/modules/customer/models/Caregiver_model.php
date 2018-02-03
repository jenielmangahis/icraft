<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Caregiver_model extends CI_Model {

    private $_full_name = "";
    private $_dob = "";
    private $_phone_number = "";
    private $_home_address = "";
    private $_city = "";
    private $_state = "";
    private $_zip = "";
    private $_country = "";
    private $_medical_certification = "";

    function get_full_name() {
        return $this->_full_name;
    }

    function get_dob() {
        return $this->_dob;
    }

    function get_phone_number() {
        return $this->_phone_number;
    }

    function get_home_address() {
        return $this->_home_address;
    }

    function get_city() {
        return $this->_city;
    }

    function get_state() {
        return $this->_state;
    }

    function get_zip() {
        return $this->_zip;
    }

    function get_country() {
        return $this->_country;
    }

    function get_medical_certification() {
        return $this->_medical_certification;
    }

    function set_full_name($_full_name) {
        $this->_full_name = $_full_name;
    }

    function set_dob($_dob) {
        $this->_dob = $_dob;
    }

    function set_phone_number($_phone_number) {
        $this->_phone_number = $_phone_number;
    }

    function set_home_address($_home_address) {
        $this->_home_address = $_home_address;
    }

    function set_city($_city) {
        $this->_city = $_city;
    }

    function set_state($_state) {
        $this->_state = $_state;
    }

    function set_zip($_zip) {
        $this->_zip = $_zip;
    }

    function set_country($_country) {
        $this->_country = $_country;
    }

    function set_medical_certification($_medical_certification) {
        $this->_medical_certification = $_medical_certification;
    }

    public function caregiverFirstStep() {
        $class_vars = get_object_vars($this);
        foreach ($class_vars as $key => $var) {
            if (!empty($var)) {
                $datatest = "get$key";
                $data[ltrim($key, '_')] = $this->$datatest();
            }
        }
        $this->session->set_userdata('caregiver_first',$data);
        return true;
    }
    
    public function caregiverSecondStep($profile_image) {
        $this->session->set_userdata('caregiver_second',$profile_image);
        return true;
    }
    
    public function caregiverFinal() {
        $dateTime           =   explode(' ',$this->session->userdata('delivery_date_time'));
        $deliveryLatLng     =   explode(',',$this->session->userdata('delivery_lat_lng'));
        
        /********* create entry in order table and (order items and order_caregiver ) table against this order ********************/
        $this->db->set('user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->set('order_type','1');
        $this->db->set('drop_location',$this->session->userdata('delivery_address'));
        $this->db->set('delivery_date',isset($dateTime[0]) ? $dateTime[0] : '');
        $this->db->set('delivery_time',isset($dateTime[1]) ? $dateTime[1] : '');
        $this->db->set('drop_location_lat',isset($deliveryLatLng[0]) ? $deliveryLatLng[0] : "0");
        $this->db->set('drop_location_lang',isset($deliveryLatLng[1]) ? $deliveryLatLng[1] : "0");
        $this->db->set('pay_status','0');
        $this->db->set('order_status','0');
        //$this->db->set('amount',$this->input->post('total_amount'));
        $this->db->insert('orders');
        $lastInsertedId =   $this->db->insert_id();
        if($lastInsertedId != ''){
            //$this->session->set_userdata('ORDER-ID',$lastInsertedId);
            /*********** Get cart items *************************/
            $cartItems  =   $this->AddToCart();
            $totalCartValue = 0;
            $caregivers =   array();
            foreach($cartItems as $key=>$item){
                /********** insert cart items into order items table ****************/
                $totalCartValue =   $item->total+$totalCartValue;
                $this->db->set('order_id',$lastInsertedId);
                $this->db->set('item_id',$item->item_id);
                $this->db->set('order_qty',$item->quantity);
                $this->db->set('total_amount',$item->total);
                $this->db->insert('order_items');
                
                /*********insert caregivers form detail in order_caregiver table ***/
                $this->db->set('order_id',$lastInsertedId);
                $this->db->set('item_id',$item->item_id);
                $this->db->set('order_qty',$item->quantity);
                $this->db->set('caregiver_id',$item->caregiver_id);
                $this->db->set('user_signature',$this->session->userdata('caregiver_second'));
                $this->db->set($this->session->userdata('caregiver_first'));
                $this->db->insert('tbl_order_caregivers');
            }
            
            /************* update total amount in table order *****************/
            $this->db->set('amount',$totalCartValue);
            $this->db->where('order_id',$lastInsertedId);
            $this->db->update('orders');
            /******************************************************************/
            /************** unset caregiver data ******************************/
            $this->session->unset_userdata('caregiver_first');
            $this->session->unset_userdata('caregiver_second');
            $this->session->unset_userdata('delivery_date_time');
            $this->session->unset_userdata('delivery_address');
            $this->session->unset_userdata('delivery_lat_lng');
            
            $result['order_id']         =   $lastInsertedId;
            $result['payable_amount']   =   $totalCartValue;
            
            return $result;
        }else{
            return FALSE;
        }
        return true;
    }
    
    public function getAllCaregiversAgainstCart() {
        $this->db->select('i.caregiver_id,caregiver_details.*,c.*');
        $this->db->from('cart as c');
        $this->db->join('items as i','i.item_id = c.item_id','left');
        $this->db->join('caregiver_details','caregiver_details.id = i.caregiver_id','left');
        $this->db->where('c.user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->group_by('i.caregiver_id');
        $result  =   $this->db->get()->result();
        return $result;
    }
    
    
    public function AddToCart(){
   
        $this->db->select('i.*,c.item_id,c.quantity,(i.price_one * c.quantity) as total,category.name as category_name,item_familly.name as family');
        $this->db->from('cart as c');
        $this->db->join('items as i','i.item_id = c.item_id','left');
        $this->db->join('category','category.category_id=i.category_id','left');
        $this->db->join('item_familly','item_familly.id=i.item_familly','left');
        $this->db->where('c.user_id',$this->session->userdata('CUSTOMER-ID'));
        $result  =   $this->db->get()->result();
        return $result;
    }
    
    public function AddToCartTotalAmount(){
   
        $result =   $this->AddToCart();
        $totalCartValue = 0;
        foreach($result as $key=>$item){
            $totalCartValue =   $item->total+$totalCartValue;
        }
        return $totalCartValue;
    }
    
    

}
