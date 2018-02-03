<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Orders_model extends CI_Model {

    public function myOrders() {
        $this->db->where('user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->where('captured',1);
        $results    =   $this->db->get('orders')->result();
        return $results;
    }
    
    public function orderDetail() {
        $this->db->select('orders.*,items.*,driver.full_name as driver_name,driver.profile_image as driver_image');
        $this->db->where('orders.user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->where('orders.order_id',$this->input->get('order_id'));
        $this->db->join('order_items','order_items.order_id=orders.order_id','left');
        $this->db->join('items','items.item_id=order_items.item_id','left');
        $this->db->join('driver','driver.driver_id=orders.driver_id','left');
        $results    =   $this->db->get('orders')->result();
        //echo $this->db->last_query();die;
        return $results;
    }
  
}
