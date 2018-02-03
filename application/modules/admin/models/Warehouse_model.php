<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Warehouse_model extends CI_Model {
    
    private $_id = "";
    private $_name = "";
    private $_address='';
    
    function get_id() {
        return $this->_id;
    }

    function get_name() {
        return $this->_name;
    }

    function get_address() {
        return $this->_address;
    }

    function set_id($_id) {
        $this->_id = $_id;
    }

    function set_name($_name) {
        $this->_name = $_name;
    }

    function set_address($_address) {
        $this->_address = $_address;
    }

    public function getWareHouse(){
      $query=$this->db->select('*')->from('warehouse')->where('status','1')->get();
       //echo $this->db->last_query();exit;
      $data = $query->result_array();
      return $data;
    }

    

}
