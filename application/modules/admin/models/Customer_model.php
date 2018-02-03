<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Customer_model extends CI_Model {

    function getPrescription() {
       return $this->_prescription;
    }

    function setPrescription($prescription) {
       $this->_prescription =
               $prescription;
    }

    function getSearchText() {
       return $this->_searchText;
    }

    function getFrom_time() {
       return $this->_from_time;
    }

    function getTo_time() {
       return $this->_to_time;
    }

    function getPreOrder() {
       return $this->_preOrder;
    }

    function getFirstTimeUsers() {
       return $this->_firstTimeUsers;
    }

    function getNonVerifiedUsers() {
       return $this->_nonVerifiedUsers;
    }

    function setSearchText($searchText) {
       $this->_searchText =
               $searchText;
    }

    function setFrom_time($from_time) {
       $this->_from_time =
               $from_time;
    }

    function setTo_time($to_time) {
       $this->_to_time =
               $to_time;
    }

    function setPreOrder($preOrder) {
       $this->_preOrder =
               $preOrder;
    }

    function setFirstTimeUsers($firstTimeUsers) {
       $this->_firstTimeUsers =
               $firstTimeUsers;
    }

    function setNonVerifiedUsers($nonVerifiedUsers) {
       $this->_nonVerifiedUsers =
               $nonVerifiedUsers;
    }
    
    function get_customer_id() {
        return $this->_customer_id;
    }

    function set_customer_id($_customer_id) {
        $this->_customer_id = $_customer_id;
    }

    

    private $_searchText = "";
    private $_from_time = "";
    private $_to_time = "";
    private $_preOrder = "";
    private $_firstTimeUsers = "";
    private $_nonVerifiedUsers = "";
    private $_prescription = "";
    private $_customer_id = "";

    public function getAllCustomers($from = '',$perPage = '') {
        $data = array();
        $variable = '';
        $orderQuery = "SELECT count(*) from orders where orders.user_id = users.id";

        $variable .= "SELECT  `orders`.*, `users`.*,
            ($orderQuery) as orders_count,
            (select uploaded_by from prescriptions where user_id =  users.id ORDER BY prescriptions.id DESC LIMIT 1) as uploaded_by
            FROM  `orders` 
            LEFT JOIN  `users` ON  `orders`.`user_id` =  `users`.`id`";

        if ($this->input->post('searchText') != "") {
            $variable .= " AND ( users.first_name LIKE '%".$this->input->post('searchText')."%'";
            $variable .= " OR users.last_name LIKE '%".$this->input->post('searchText')."%'";
            $variable .= " OR users.email LIKE '%".$this->input->post('searchText')."%'";
            $variable .= " OR users.address LIKE '%".$this->input->post("searchText")."%' )";
        }  
        
        
        if (trim($this->input->post("from_time")) != "" && trim($this->input->post("to_time")) != "") {
            //check the below query before proceed
            $variable .= " and users.created_at BETWEEN ".$this->input->post('from_time')." AND ".$this->input->post('from_time');
        }

        if ($this->input->post("firstTimeUsers")) {
            //
        }

        if ($this->input->post("preOrder")) {
            //echo "Preorder";
        }

        if ($this->input->post("nonVerifiedUsers") != null) {
            $variable .= " and users.is_verified = '1'";
        }

        if ($this->input->post("prescription") != null) {
            $variable .= " and users.is_medical_prescription = '1'";
        }

        $variable .=" and  `user_type` =  '0'
        AND  `is_deleted` =  '0' 
        GROUP BY users.id ORDER BY users.id DESC
        LIMIT 0 , 300";
        
        $query = $this->db->query($variable);

        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }

    public function saveCustomerData(){
        $this->load->library('S3');

        $query = $this->db->select('*')->from('users')->where('email',$this->input->post('email'))->get();
        if ($query->num_rows() > 0) {//if already a user
            return false;
        }else{//If new user
            $new_name = time() . $_FILES["profile_pic"]['name'];
            $fileTempName = $_FILES["profile_pic"]['tmp_name'];
            $profile_mage = uploadImageOnS3($new_name,$fileTempName,'customer');

            $data = array(
                'first_name' => $this->input->post('first_name'), 
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone_number' => $this->input->post('mobile'),
                'dob' => $this->input->post('dob'),
                'gender' => $this->input->post('gender'),
                'password' => md5($this->input->post('password')),
                'profile_pic' => $profile_mage,
                'user_type' => '0',
                'is_deleted' => '0',
                'is_blocked' => '0'
                    );

            $this->db->insert('users',$data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
        
        
    }
    
    public function viewCustomerData(){
        $data = [];
        $query = $this->db->select('*')
                ->from('users')
                ->where('id', $this->uri->segment('2'))
                ->get();       
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }
    
    public function viewCustomerOrdersData(){
        $data = [];
        $query = $this->db->select('od.*, driver.driver_id,driver.first_name as driverFirstName, driver.last_name as driverLastName, dao.delivery_time, dao.delivered_date, dao.drop_location')
                ->from('orders as od')
                ->join('driver','driver.driver_id=od.driver_id')
                ->join('driver_assigned_order as dao','dao.order_id=od.order_id')
                ->where('od.user_id', $this->uri->segment('2'))
                ->get();       
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }
    
    public function getRewardedPoint(){
        $data = ['total_point' => 0];
        $query = $this->db->select('total_point')
                ->from('user_points')
                ->where('user_id', $this->uri->segment('2'))
                ->order_by('id', 'DESC')
                ->limit(1)
                ->get();       
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }
    
    public function redeemRewarded(){
        $data = array();
        $query = $this->db->select('*')
                ->from('user_points')
                ->where('user_id', $this->get_customer_id())
                ->order_by('id', 'DESC')
                //->limit(1)
                ->get();       
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }
    
    public function prescription() {
        $data = array();
        $currentDate = date('Y-m-d');
        //echo $currentDate; die;
        $query = $this->db->select('*')
                ->from('prescriptions')
                ->where('user_id', $this->get_customer_id())
                ->where('expire_date >=', $currentDate)
                ->where('expire_date !=', '0000-00-00')
                ->order_by('id', 'DESC')
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function selectReferredUserByCustomer(){
        $data = array();
       return  $this->db->select("email, created_at as join_date, '100' as point_earned ", false)
                ->from('users')
                ->where('reffered_by', $this->get_customer_id())
                ->order_by('created_at', 'DESC')
                ->order_by("CONCAT(first_name, ' ', last_name)", 'DESC', false)                
                ->get()
                ->result_array();
       // $this->db->last_query();
         
    }
}

?>
