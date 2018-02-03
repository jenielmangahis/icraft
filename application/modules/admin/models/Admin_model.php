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
    private $_remember = "";

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
    
    function getRemember() {
        return $this->_remember;
    }
    

    function setNew_password($new_password) {
        $this->_new_password = $new_password;
    }

    function setConfirm_password($confirm_password) {
        $this->_confirm_password = $confirm_password;
    }
    
    function setRemember($remember) {
        $this->_remember = $remember;
    }

    public function adminLogin($emailId,$password,$remember='') {
        
        $query = $this->db->select('*')
                            ->from('admin')
                            ->where('email', $emailId)
                            ->where('password', md5($password))
                            ->where('active', '1')
                            ->get();

        if ($query->num_rows() > 0) {
            
            if($remember){
                    delete_cookie('kobo_admin_auth');
                    $pesacookiedata = array(
                            'name'   => 'insta_auth',
                            'value'  => $hashedkey,
                            'expire' => 86400*30,
                            'prefix' => 'vas_product_'
                    );
                    set_cookie($pesacookiedata);
            }
            
            $data = $query->row_array();
            
            return $data;
        } else {
            return FALSE;
        }
    }

    public function chkUserEmail() {
        $email = $this->getAdmin();
        $chkData = array( 'email' => $email);
        $res    = $this->db->get_where('admin', $chkData);
        //$result = $res->result_array();
        //echo $this->db->last_query();die;
        if ($res->num_rows() > 0)
        {
            return $res->row_array();
        }else{
            return 0;           
        }
    }
    
    //--update User Password 
    public function update_userPassword($emailid, $new_password){
        $this->db->set('password', md5($new_password)) 
                 ->set('reset_password_act', 0) 
                 ->where('email', $emailid) 
                 ->update('tbl_travel_users');
        return 1;
    }

    public function updatePassword(){
        $this->db->set('password',md5($this->getNew_password()))
                 ->where('admin',$this->getAdmin())
                 ->update('admin');
        return TRUE;
    }
    
    //get admin old password
    public function checkOldPassword(){
        $userData = $this->db->select('password')
                             ->where('password',md5($this->getPassword()))
                             ->where('id',$this->getId())
                             ->get('admin');
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
                        ->update('admin');
        
        return true;
    }
    
    //send global email function 
    function sendEmailGlobal($from_email = '', $email = '', $name = '', $subject = '', $emailMessage = '', $attachment = '') {

        $CI = & get_instance();
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $CI->load->library('email');
        $CI->email->set_newline("\r\n");
        $CI->email->initialize($config);
        $CI->email->from($from_email, $from_email);
        $CI->email->to($email, $email);
        $CI->email->subject($subject);

        $CI->email->message($emailMessage);
        $CI->email->send();
        if($CI->email->send()){ 
            return TRUE;
        }else{
        // echo "else";
         echo "<pre>";print_r($this->email->print_debugger());die;
        }
    }


    public function check_forgot_password_user($email){
        $allUserData = $this->db->get('tbl_travel_users')->result_array();
        //print_r($allUserData);die;
        $newArray = array();
        foreach($allUserData as $rowData) {
            
            $email   = $rowData['email'];
            $pswChk  = $rowData['reset_password_act'];
            $chkTime = $rowData['reset_password_time'];

            $codedemail = base64_encode($email);
            $newArray[$codedemail] = $email;
            $newArray[$email] = $pswChk."&".$chkTime ;
        }
        return $newArray;

    }

}
