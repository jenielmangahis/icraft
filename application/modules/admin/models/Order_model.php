<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order_model
 *
 * @author Vishal
 */
class Order_model extends CI_Model{
    //put your code here
    private $_order_id;
    private $_user_id;
    private $_driver_id;
    private $_transaction_no;
    private $_order_type;
    private $_delivery_time;
    private $_delivery_date;
    private $_drop_location;
    private $_drop_location_lat;
    private $_drop_location_lang;
    private $_pay_status;
    private $_order_status;
    private $_amount;
    private $_created_at;
    private $_updated_at;
    private $_id;
    private $_item_id;
    private $_order_qty;
    
    function getOrder_id() {
        return $this->_order_id;
    }

    function getUser_id() {
        return $this->_user_id;
    }

    function getDriver_id() {
        return $this->_driver_id;
    }

    function getTransaction_no() {
        return $this->_transaction_no;
    }

    function getOrder_type() {
        return $this->_order_type;
    }

    function getDelivery_time() {
        return $this->_delivery_time;
    }

    function getDelivery_date() {
        return $this->_delivery_date;
    }

    function getDrop_location() {
        return $this->_drop_location;
    }

    function getDrop_location_lat() {
        return $this->_drop_location_lat;
    }

    function getDrop_location_lang() {
        return $this->_drop_location_lang;
    }

    function getPay_status() {
        return $this->_pay_status;
    }

    function getOrder_status() {
        return $this->_order_status;
    }

    function getAmount() {
        return $this->_amount;
    }

    function getCreated_at() {
        return $this->_created_at;
    }

    function getUpdated_at() {
        return $this->_updated_at;
    }

    function getId() {
        return $this->_id;
    }

    function getItem_id() {
        return $this->_item_id;
    }

    function getOrder_qty() {
        return $this->_order_qty;
    }

    function setOrder_id($order_id) {
        $this->_order_id = $order_id;
        return $this;
    }

    function setUser_id($user_id) {
        $this->_user_id = $user_id;
        return $this;
    }

    function setDriver_id($driver_id) {
        $this->_driver_id = $driver_id;
        return $this;
    }

    function setTransaction_no($transaction_no) {
        $this->_transaction_no = $transaction_no;
        return $this;
    }

    function setOrder_type($order_type) {
        $this->_order_type = $order_type;
        return $this;
    }

    function setDelivery_time($delivery_time) {
        $this->_delivery_time = $delivery_time;
        return $this;
    }

    function setDelivery_date($delivery_date) {
        $this->_delivery_date = $delivery_date;
        return $this;
    }

    function setDrop_location($drop_location) {
        $this->_drop_location = $drop_location;
        return $this;
    }

    function setDrop_location_lat($drop_location_lat) {
        $this->_drop_location_lat = $drop_location_lat;
        return $this;
    }

    function setDrop_location_lang($drop_location_lang) {
        $this->_drop_location_lang = $drop_location_lang;
        return $this;
    }

    function setPay_status($pay_status) {
        $this->_pay_status = $pay_status;
        return $this;
    }

    function setOrder_status($order_status) {
        $this->_order_status = $order_status;
        return $this;
    }

    function setAmount($amount) {
        $this->_amount = $amount;
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

    function setId($id) {
        $this->_id = $id;
        return $this;
    }

    function setItem_id($item_id) {
        $this->_item_id = $item_id;
        return $this;
    }

    function setOrder_qty($order_qty) {
        $this->_order_qty = $order_qty;
        return $this;
    }

    public function selectOrderItemDetails(){
        $orderid = $this->getOrder_id();
       // echo $orderid;
        $orders = $this->db->select("item_name,  group_concat(c.name) AS category_name, order_qty, i.price_eigth", false)
                ->from('order_items oi')
                ->join('items i', 'i.item_id=oi.item_id')
                ->join('item_category_mapping ic', 'ic.item_id=oi.item_id' )                
                ->join('category c', 'c.category_id = ic.category_id')
                ->where('oi.order_id', $orderid)
                ->group_by('i.item_id')
                ->get()
                ->result_array();
        
        return $orders;
    }

}
