<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Driver_inventory_model
 *
 * @author Vishal
 */
class Driver_inventory_model extends CI_Model{
    //put your code here
    private $_inventory_id;
    private $_warehouse_id;
    private $_item_id;
    private $_driver_id;
    private $_item_quantity;
    private $_approve_by_admin;
    private $_created_at;
    private $_updated_at;
    private $_order_id;
    
    function getInventory_id() {
        return $this->_inventory_id;
    }

    function getWarehouse_id() {
        return $this->_warehouse_id;
    }

    function getItem_id() {
        return $this->_item_id;
    }

    function getDriver_id() {
        return $this->_driver_id;
    }

    function getItem_quantity() {
        return $this->_item_quantity;
    }

    function getApprove_by_admin() {
        return $this->_approve_by_admin;
    }

    function getCreated_at() {
        return $this->_created_at;
    }

    function getUpdated_at() {
        return $this->_updated_at;
    }

    function setInventory_id($inventory_id) {
        $this->_inventory_id = $inventory_id;
        return $this;
    }

    function setWarehouse_id($warehouse_id) {
        $this->_warehouse_id = $warehouse_id;
        return $this;
    }

    function setItem_id($item_id) {
        $this->_item_id = $item_id;
        return $this;
    }

    function setDriver_id($driver_id) {
        $this->_driver_id = $driver_id;
        return $this;
    }

    function setItem_quantity($item_quantity) {
        $this->_item_quantity = $item_quantity;
        return $this;
    }

    function setApprove_by_admin($approve_by_admin) {
        $this->_approve_by_admin = $approve_by_admin;
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
    
    function getOrder_id() {
        return $this->_order_id;
    }

    function setOrder_id($order_id) {
        $this->_order_id = $order_id;
        return $this;
    }

    
    public function checkDiverInvetoryAgainstOrder(){
      $driverId =  $this->getDriver_id();
      $orderId =   $this->getOrder_id();
      
      $orderItems = $this->db->select('item_id, order_qty')->from('order_items')->where('order_id', $orderId)->get()->result_array();
   // echo $this->db->last_query();
      if(count($orderItems)== 0){
          return FALSE;
      }else {
          foreach ($orderItems as $item) {
              
              $result = $this->db->select('item_id')->from('driver_inventory')->where(array('item_id'=>$item['item_id'], "driver_id"=>$driverId ))->where('item_quantity >=', $item['order_qty'])->get()->row_array();
             
              if(count($result)==0){
                  return FALSE;
              }
              
          }
          return TRUE;
      }   
    }

    public function returnOrderItems(){
        $orderId =   $this->getOrder_id();
    }
}
