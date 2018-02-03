<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_coupons_model
 *
 * @author Vishal
 */
class User_coupons_model extends CI_Model {
    //put your code here
    private $_id;
    private $_user_id;
    private $_coupon_code;
    private $_expiry;
    private $_redeemed_on;
    private $_points;
    private $_discount_in_percent;
    private $_is_redeemed;
    private $_received_on;
    private $_coupon_id;
    
    function getId() {
        return $this->_id;
    }

    function getUser_id() {
        return $this->_user_id;
    }

    function getCoupon_code() {
        return $this->_coupon_code;
    }

    function getExpiry() {
        return $this->_expiry;
    }

   
    function getPoints() {
        return $this->_points;
    }

    function getDiscount_in_percent() {
        return $this->_discount_in_percent;
    }

    function getIs_redeemed() {
        return $this->_is_redeemed;
    }

    function getReceived_on() {
        return $this->_received_on;
    }

    function setId($id) {
        $this->_id = $id;
        return $this;
    }

    function setUser_id($user_id) {
        $this->_user_id = $user_id;
        return $this;
    }

    function setCoupon_code($coupon_code) {
        $this->_coupon_code = $coupon_code;
        return $this;
    }

    function setExpiry($expiry) {
        $this->_expiry = $expiry;
        return $this;
    }



    function setPoints($points) {
        $this->_points = $points;
        return $this;
    }

    function setDiscount_in_percent($discount_in_percent) {
        $this->_discount_in_percent = $discount_in_percent;
        return $this;
    }

    function setIs_redeemed($is_redeemed) {
        $this->_is_redeemed = $is_redeemed;
        return $this;
    }

    function setReceived_on($received_on) {
        $this->_received_on = $received_on;
        return $this;
    }
    
    function getRedeemed_on() {
        return $this->_redeemed_on;
    }

    function getCoupon_id() {
        return $this->_coupon_id;
    }

    function setRedeemed_on($redeemed_on) {
        $this->_redeemed_on = $redeemed_on;
        return $this;
    }

    function setCoupon_id($coupon_id) {
        $this->_coupon_id = $coupon_id;
        return $this;
    }

        

    public function selectUserCoupons(){
        $userId = $this->getUser_id();
        
        $data = $this->db->select("coupon_code, redeemed_on, is_redeemed, expiry, received_on")
                ->from('user_coupons')
                ->where('user_id', $userId)
                ->order_by('received_on', 'asc')
                ->order_by('redeemed_on', 'asc')
                ->get()
                ->result_array();
         return $data;
    }
    
    public function insertUpdateCouponInUser(){
        $couponid = $this->getCoupon_id();
        $userId = $this->getUser_id();
        $data = array();
            $class_vars = get_object_vars($this);
            foreach ($class_vars as $key => $var) {
                if (!empty($var)) {
                    $datatest = "get" . ltrim(ucwords(strtolower($key)), '_');
                    $data[ltrim($key, '_')] = $this->$datatest();
                }
            }
            $this->db->set($data)->insert('user_coupons');
           // echo $this->db->last_query();
            return TRUE;
        
                
    }
    
    public function getCouponDetails(){
        $couponid = $this->getCoupon_id();
        
        return $this->db->select('*, DATE_ADD(CURRENT_DATE(), INTERVAL 3 MONTH) as coupan_expiry')->from('coupons')->where('id', $couponid)->get()->row_array();
    }
    
}
