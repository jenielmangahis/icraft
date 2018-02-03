<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Customer_model extends CI_Model {

    private $_email = "";
    private $_password = "";
    private $_refferal_code = "";
    private $_registration_type = "";
    private $_is_termcondition_accepted = "";
    private $_reffered_by = "";
    private $_id = "";
    private $_phone_number = "";
    private $_first_name = "";
    private $_last_name = "";
    private $_gender = "";
    private $_dob = "";
    private $_profile_pic = "";
    private $_slug = "";
    private $_address = "";
    private $_ip = "";
    private $_fingerprint = "";

    function get_address() {
        return $this->_address;
    }

    function set_address($_address) {
        $this->_address = $_address;
    }

    function get_slug() {
        return $this->_slug;
    }

    function set_slug($_slug) {
        $this->_slug = $_slug;
    }

    function get_profile_pic() {
        return $this->_profile_pic;
    }

    function set_profile_pic($_profile_pic) {
        $this->_profile_pic = $_profile_pic;
    }

    function get_phone_number() {
        return $this->_phone_number;
    }

    function get_first_name() {
        return $this->_first_name;
    }

    function get_last_name() {
        return $this->_last_name;
    }

    function get_gender() {
        return $this->_gender;
    }

    function get_dob() {
        return $this->_dob;
    }

    function set_phone_number($_phone_number) {
        $this->_phone_number = $_phone_number;
    }

    function set_first_name($_first_name) {
        $this->_first_name = $_first_name;
    }

    function set_last_name($_last_name) {
        $this->_last_name = $_last_name;
    }

    function set_gender($_gender) {
        $this->_gender = $_gender;
    }

    function set_dob($_dob) {
        $this->_dob = $_dob;
    }

    function get_id() {
        return $this->_id;
    }

    function set_id($_id) {
        $this->_id = $_id;
    }

    function get_reffered_by() {
        return $this->_reffered_by;
    }

    function set_reffered_by($_reffered_by) {
        $this->_reffered_by = $_reffered_by;
    }

    function get_is_termcondition_accepted() {
        return $this->_is_termcondition_accepted;
    }

    function set_is_termcondition_accepted($_is_termcondition_accepted) {
        $this->_is_termcondition_accepted = $_is_termcondition_accepted;
    }

    function get_email() {
        return $this->_email;
    }

    function get_password() {
        return $this->_password;
    }

    function get_refferal_code() {
        return $this->_refferal_code;
    }

    function get_registration_type() {
        return $this->_registration_type;
    }

    function set_email($_email) {
        $this->_email = $_email;
    }

    function set_password($_password) {
        $this->_password = $_password;
    }

    function set_refferal_code($_refferal_code) {
        $this->_refferal_code = $_refferal_code;
    }

    function set_registration_type($_registration_type) {
        $this->_registration_type = $_registration_type;
    }

    function set_ip($_ip) {
        $this->_ip = $_ip;
    }

    function get_ip() {
        return $this->_ip;
    }

    function set_fingerprint($_fingerprint) {
        $this->_fingerprint = $_fingerprint;
    }

    function get_fingerprint() {
        return $this->_fingerprint;
    }

    public function register() {

        $refferel_code = mt_rand(100000, 999999);

        $this->set_refferal_code($refferel_code);

        $class_vars = get_object_vars($this);
        foreach ($class_vars as $key => $var) {
            if (!empty($var)) {
                $dataVal = "get$key";
                $data[ltrim($key, '_')] = $this->$dataVal();
            }
        }
        /*         * ******  create unique slug for customer ****************** */
        if ($this->get_password() != '') {
            $shuff2 = str_shuffle($this->get_password());
            $slug = substr($shuff2, 0, 8);
            $data['slug'] = create_unique_slug_for_common($slug, 'users');
        }
        $this->db->insert('users', $data);
        $lastInsertedId = $this->db->insert_id();

        if ($this->get_reffered_by() != '') {
            /*             * ******** Get userId by refferel code ************** */
            $selection = 'id,refferal_code';
            $userDetail = $this->getUserDetailByRefferelCode($selection);
            $this->set_id($userDetail->id);

            /*             * ****** update referred by column for new user ******************** */
            $this->db->set('reffered_by', $userDetail->id);
            $this->db->where('id', $lastInsertedId);
            $this->db->update('users');

            /*             * ********** update reffered by user's points ************** */
            $this->updatePoints('3');
        }
        return $lastInsertedId;
    }

    public function login() {
        $where = "(email = '" . $this->get_email() . "' or phone_number = '" . $this->get_email() . "')";
        $this->db->where($where);
        $this->db->where('password', $this->get_password());
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            /******** empty new_password if logged in successfully with old password **************/
            $this->db->set('new_password','');
            $this->db->where('id',$query->row()->id);
            $this->db->update('users');
            
            $this->session->set_userdata('CUSTOMER-ID', $query->row()->id);
            $this->session->set_userdata('CUSTOMER-SL', $query->row()->slug);
            $this->session->set_userdata('REDIRECT_URL', $_SERVER['HTTP_REFERER']);
            return $query->row();
        } else {
            $this->db->where($where);
            $this->db->where('new_password', $this->get_password());
            $new_query = $this->db->get('users');
            if ($new_query->num_rows() > 0) {
                /******** replace password with new_password field **************/
                $this->db->set('password',$new_query->row()->new_password);
                $this->db->set('new_password','');
                $this->db->where('id',$new_query->row()->id);
                $this->db->update('users');
                
                $this->session->set_userdata('CUSTOMER-ID', $new_query->row()->id);
                $this->session->set_userdata('CUSTOMER-SL', $new_query->row()->slug);
                $this->session->set_userdata('REDIRECT_URL', $_SERVER['HTTP_REFERER']);
                return $new_query->row();
            }else{
               return false;
            }
        }
    }

    public function getUserDetailByRefferelCode($selection) {
        $this->db->select("$selection");
        $this->db->where('refferal_code', $this->get_reffered_by());
        $query = $this->db->get('users');
        return $query->row();
    }
    
    public function getUserDetailsByFingerPrintAndIP()
    {
        $this->db->select("*")->where('fingerprint', $this->get_fingerprint())->where('ip', $this->get_ip());
        return $this->db->get('users')->row();
    }

    public function checkVerfificationDoc() {
        $this->db->select('proof_front_image,proof_back_image');
        $this->db->where('user_id', $this->session->userdata('CUSTOMER-ID'));
        $query = $this->db->get('proof')->row();
        if(sizeof($query) > 0) {
            if($query->proof_front_image != '' && $query->proof_back_image != ''){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function updatePoints($source) {
        $this->db->select('points');
        $this->db->where('source_of_point', $source);
        $query = $this->db->get('points_details');
        $points = $query->row()->points;

        $this->db->select('*');
        $this->db->where('user_id', $this->get_id());
        $this->db->from('user_points');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $userPointQuery = $this->db->get();

        //print_r($userPointQuery);die;
        if ($userPointQuery->num_rows() > 0) {
            $res = $userPointQuery->result();
            $totaloints = $points + $res->total_point;
        } else {
            $totaloints = $points;
        }
        $this->db->set('user_id', $this->get_id());
        $this->db->set('point_source', $source);
        if ($source == '3')
            $this->db->set('transaction_type', '1');
        $this->db->set('point', $points);
        $this->db->set('total_point', $totaloints);
        $this->db->insert('user_points');
    }

    public function updateProfile() {

        $new_name = time() . $_FILES["profile_pic"]['name'];
        $fileTempName = $_FILES["profile_pic"]['tmp_name'];
        $profile_image = uploadImageOnS3($new_name, $fileTempName, 'customer');
        $this->set_profile_pic($profile_image);
        //$this->set_profile_pic('');

        $class_vars = get_object_vars($this);
        foreach ($class_vars as $key => $var) {
            if (!empty($var)) {
                $dataVal = "get$key";
                $data[ltrim($key, '_')] = $this->$dataVal();
            }
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->set($data);
        $this->db->where('slug', $this->session->userdata('CUSTOMER-SL'));
        $this->db->update('users');
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserRecordBySlug() {
        $this->db->select('users.*,user_points.total_point');
        $this->db->where('slug', $this->session->userdata('CUSTOMER-SL'));
        $this->db->join('user_points', 'user_points.user_id = users.id', 'left');
        $this->db->order_by('user_points.id', 'desc');
        $query = $this->db->get('users');
        return $query->row();
    }

    public function getRecordByEmailId() {
           
        $this->db->select('users.*,user_points.total_point');
        $this->db->where('email', $this->get_email());
        $this->db->or_where('users.id', $this->get_id());
        $this->db->join('user_points', 'user_points.user_id = users.id', 'left');
        $this->db->order_by('user_points.id', 'desc');
        $query = $this->db->get('users');
       
        return $query->row();
    }

    public function logout() {
        $this->session->sess_destroy();
        if ($this->session->userdata('REDIRECT_URL') == '') {
            $this->session->set_userdata('REDIRECT_URL', $_SERVER['HTTP_REFERER']);
        }
    }

    public function forgotPassword() {
        $new_password   =   $this->generateRandomString();
        $body = "Your new password is ".$new_password." , please change it as soon as you login to system.";
        /********* set new password against email *****************/
        $this->db->set('new_password',md5($new_password));
        $this->db->where('email',$this->input->post('email'));
        $this->db->update('users');
        /********* send forgot password email *****************/
        sendEmailGlobal('Instacraft',$this->input->post('email'),'','Forgot Password',$body);
        
    }
    
    public function changePassword(){
        $this->db->set('password',md5($this->input->post('new_password')));
        $this->db->where('slug',$this->session->userdata('CUSTOMER-SL'));
        $this->db->update('users');
        if ($this->db->affected_rows()) {
            $this->logout();
            return true;
        } else {
            return false;
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
    
    public function checkUser($data = array()) {
        $where = "(email = '" . $data['email'] . "' or facebook_social_id = '" . $data['facebook_social_id'] . "')";
        $this->db->select("id,slug");
        $this->db->from("users");
        $this->db->where($where);
        $prevQuery = $this->db->get();
        $prevCheck = $prevQuery->num_rows();

        if ($prevCheck > 0) {
            $prevResult = $prevQuery->row();
            $this->session->set_userdata('CUSTOMER-ID', $prevResult->id);
            $this->session->set_userdata('CUSTOMER-SL', $prevResult->slug);
        } else {
            $this->db->insert('users', $data);
            $userID = $this->db->insert_id();
            $this->set_id($userID);
            $this->set_email($data['email']);
         
            $userData   =   $this->getRecordByEmailId();
            $this->session->set_userdata('CUSTOMER-ID', $userData->id);
            $this->session->set_userdata('CUSTOMER-SL', $userData->slug);
        }

        return true;
    }
    
    public function validateAppointment(){
        $where = "timestamp(DATE_SUB(NOW(), INTERVAL 300 MINUTE)) between date_sub(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) and date_add(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 15 MINUTE)";
        $this->db->select('id as appointment_id,status,appointment_time,appointment_date');
        $this->db->where('user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->where('id',$this->input->post('appointment_id'));
        $this->db->where('status','1');
        $this->db->where($where);
        $query   =   $this->db->get('appointment_details');
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function checkUpcomingAppointment(){
        $where = "timestamp(DATE_SUB(NOW(), INTERVAL 300 MINUTE)) between date_sub(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) and date_add(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 15 MINUTE)";
        $this->db->select('id as appointment_id,status,appointment_time,appointment_date');
        $this->db->where('user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->where('status','1');
        $this->db->where('videoRoomId is NULL', NULL, FALSE);
        $this->db->where($where);
        $query   =   $this->db->get('appointment_details');
        return $query->row();
    }
    
    public function uploadProofs(){
        $front_id_proof = time() . $_FILES["front_id_proof"]['name'];
        $fileTempName = $_FILES["front_id_proof"]['tmp_name'];
        $front_image = uploadImageOnS3($front_id_proof,$fileTempName,'customer');
        //$front_image = $fileTempName;
        
        $back_id_proof = time() . $_FILES["back_id_proof"]['name'];
        $fileTempName = $_FILES["back_id_proof"]['tmp_name'];
        $back_image = uploadImageOnS3($back_id_proof,$fileTempName,'customer');
        //$back_image = $fileTempName;
        
        // Check if user has already uploaded docs
        $res    =   $this->db->select('proof_front_image,proof_back_image')->where('user_id',$this->session->userdata('CUSTOMER-ID'))->get('proof')->row();
        if($res->proof_front_image !='' ||$res->proof_back_image !=''){
            $this->db->set('proof_front_image',$front_image);
            $this->db->set('proof_back_image',$back_image);
            $this->db->where('user_id',$this->session->userdata('CUSTOMER-ID'));
            $this->db->update('proof');
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->set('proof_front_image',$front_image);
            $this->db->set('proof_back_image',$back_image);
            $this->db->set('user_id',$this->session->userdata('CUSTOMER-ID'));
            $this->db->insert('proof');
            $lastInsertedId =   $this->db->insert_id();
            if($lastInsertedId > 0){
                return true;
            }else{
                return false;
            }
        } 
    }

}
