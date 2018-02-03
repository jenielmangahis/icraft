<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_model extends CI_Model {
    
    private $_id = "";
    private $_admin = "";
    private $_password = "";
    private $_admin_type = "";
    private $_created_on = "";
    private $_modified_on = "";
    private $_new_password = "";
    private $_confirm_password = "";

    function getId() {
        return $this->_id;
    }

    function getAdmin() {
        return $this->_admin;
    }

    function getPassword() {
        return $this->_password;
    }

    function getAdmin_type() {
        return $this->_admin_type;
    }

    function getCreated_on() {
        return $this->_created_on;
    }

    function getModified_on() {
        return $this->_modified_on;
    }

    function setId($id) {
        $this->_id = $id;
    }

    function setAdmin($admin) {
        $this->_admin = $admin;
    }

    function setPassword($password) {
        $this->_password = $password;
    }

    function setAdmin_type($admin_type) {
        $this->_admin_type = $admin_type;
    }

    function setCreated_on($created_on) {
        $this->_created_on = $created_on;
    }

    function setModified_on($modified_on) {
        $this->_modified_on = $modified_on;
    }
    function getNew_password() {
        return $this->_new_password;
    }

    function getConfirm_password() {
        return $this->_confirm_password;
    }

    function setNew_password($new_password) {
        $this->_new_password = $new_password;
    }

    function setConfirm_password($confirm_password) {
        $this->_confirm_password = $confirm_password;
    }

    public function adminLogin($emailId,$password) {
        $query = $this->db->select('*')
                            ->from('tbl_admin')
                            ->where('email', $emailId)
                            ->where('password', md5($password))
                            ->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }

    public function chkUserEmail() {
        $email = $this->getAdmin();
        $query = $this->db->select('*')->from('tbl_admin')
                ->where('admin', $email)
                ->get();
        $row = $query->row_array();
        if ($query->num_rows() > 0) {
            return $row;
        } else {
            return FALSE;
        }
    }
    
    public function updatePassword(){
        $this->db->set('password',md5($this->getNew_password()))
                 ->where('admin',$this->getAdmin())
                 ->update('tbl_admin');
        return TRUE;
    }
    
    //get admin old password
    public function checkOldPassword(){
        $userData = $this->db->select('password')
                             ->where('password',md5($this->getPassword()))
                             ->where('id',$this->getId())
                             ->get('tbl_admin');
        if($userData->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    //update new admin password
     public function changePassword() {
        $this->db->set('password',md5($this->getNew_password()))
                        ->where('id',$this->getId())
                        ->update('tbl_admin');
        
        return true;
    }

}
