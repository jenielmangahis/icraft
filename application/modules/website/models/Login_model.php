<?php

class Login_model extends CI_Model {

    
    public function webLogin($emailId,$password) {
        $query = $this->db->select('id,user_type,first_name,last_name,profile_pic,gender,email,is_notification,is_verified,is_approved,is_deleted,is_blocked,city,address')
                            ->from('users')
                            ->where('email', $emailId)
                            ->where('password', md5($password))
                            ->get();
                            
        if ($query->num_rows() > 0) {
            $data['doctor'] = $query->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }
    
    public function getUserData(){
        $query = $this->db->select('*')
                ->from('users')
                ->where('id',$this->session->userdata('doctor_id'))
                ->get();
        //echo $this->db->last_query();exit;
        
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
        
    }
    
    public function setNewPassword($password){
        $data = array(
               'password' => md5($password)
               
            );

        $this->db->where('id', $this->session->userdata('doctor_id'));
        $this->db->update('users', $data); 
        return true;
    }
    
    
    

}
