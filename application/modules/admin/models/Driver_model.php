<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Driver_model extends CI_Model {

    function getDate() {
        return $this->_date;
    }

    function setDate($date) {
        $this->_date = $date;
    }

    function getFrom_time() {
        return $this->_from_time;
    }

    function getTo_time() {
        return $this->_to_time;
    }

    function getPayable_amount() {
        return $this->_payable_amount;
    }

    function getDriver_id() {
        return $this->_driver_id;
    }

    function getShift_id() {
        return $this->_shift_id;
    }

    function setFrom_time($from_time) {
        $this->_from_time = $from_time;
    }

    function setTo_time($to_time) {
        $this->_to_time = $to_time;
    }

    function setPayable_amount($payable_amount) {
        $this->_payable_amount = $payable_amount;
    }

    function setDriver_id($driver_id) {
        $this->_driver_id = $driver_id;
    }

    function setShift_id($shift_id) {
        $this->_shift_id = $shift_id;
    }

    function getQuantity() {
        return $this->_quantity;
    }

    function getItemId() {
        return $this->_itemId;
    }

    function getWarehouseId() {
        return $this->_warehouseId;
    }

    function setQuantity($quantity) {
        $this->_quantity = $quantity;
    }

    function setItemId($itemId) {
        $this->_itemId = $itemId;
    }

    function setWarehouseId($warehouseId) {
        $this->_warehouseId = $warehouseId;
    }

    function getItemSearch() {
        return $this->_itemSearch;
    }

    function setItemSearch($itemSearch) {
        $this->_itemSearch = $itemSearch;
    }

    function get_start_date() {
        return $this->_start_date;
    }

    function get_end_date() {
        return $this->_end_date;
    }

    function set_start_date($_start_date) {
        $this->_start_date = $_start_date;
    }

    function set_end_date($_end_date) {
        $this->_end_date = $_end_date;
    }
    function get_break_id() {
        return $this->_break_id;
    }

    function set_break_id($_break_id) {
        $this->_break_id = $_break_id;
    }

   
    function get_original_payable_amount() {
        return $this->_original_payable_amount;
    }

    function set_original_payable_amount($_original_payable_amount) {
        $this->_original_payable_amount = $_original_payable_amount;
    }
    function get_template_id() {
        return $this->_template_id;
    }

    function set_template_id($_template_id) {
        $this->_template_id = $_template_id;
    }
    function get_template_name() {
        return $this->_template_name;
    }

    function set_template_name($_template_name) {
        $this->_template_name = $_template_name;
    }

        
    
    private $_itemSearch = "";
    private $_quantity = "";
    private $_itemId = "";
    private $_warehouseId = "";
    private $_from_time = "";
    private $_to_time = "";
    private $_payable_amount = "";
    private $_driver_id = "";
    private $_shift_id = "";
    private $_date = "";
    private $_start_date = "";
    private $_end_date = "";
    private $_break_id = "";
    private $_original_payable_amount = "";
    private $_template_id = "";
    private $_template_name = "";

    public function getAllDrivers($from = '', $perPage = '') {
        $data = array();
        $query = $this->db->select('driver.driver_id,driver.online,driver.email,driver.contact_number,driver.first_name,driver.last_name,professional_detail.registration_number,warehouse.name')
                ->from('driver')
                ->join('driver_professional_detail as professional_detail', 'professional_detail.driver_id=driver.driver_id', 'left')
                ->join('warehouse', 'warehouse.id=driver.starting_location');

        if ($this->input->get("searchText") != "") {

            $query = $this->db->like('driver.full_name', trim($this->input->get("searchText")), 'both');
            $query = $this->db->or_like('driver.first_name', trim($this->input->get("searchText")), 'both');
            $query = $this->db->or_like('driver.contact_number', trim($this->input->get("searchText")), 'both');
            $query = $this->db->or_like('driver.location', trim($this->input->get("searchText")), 'both');
        }

        if (trim($this->input->get("status")) != "") {
//            $status = $this->input->get("status");
//            $query = $this->db->where('online',$status);
            $query = $this->db->like('online', trim($this->input->get("status")), 'both');
        }

//        $query = $this->db->order_by('driver_id','DESC')
        $query = $this->db->where('is_deleted', '0')
                ->limit($from, $perPage)
                ->get();
//        echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function saveDriver() {
        $this->load->library('S3');

        $new_name = time() . $_FILES["driver_image"]['name'];
        $fileTempName = $_FILES["driver_image"]['tmp_name'];
        $profile_mage = uploadImageOnS3($new_name, $fileTempName, 'driver');

        $document_new_name = time() . $_FILES["document1"]['name'];
        $documentTempName = $_FILES["document1"]['tmp_name'];
        $document_url = uploadImageOnS3($document_new_name, $documentTempName, 'document');

        $vehicle_new_name = time() . $_FILES["vehicle_image"]['name'];
        $vehicleTempName = $_FILES["vehicle_image"]['tmp_name'];
        $vehicle_url = uploadImageOnS3($vehicle_new_name, $vehicleTempName, 'vehicle');


        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'contact_number' => $this->input->post('mobile'),
            'password' => md5($this->input->post('password')),
            'gender' => $this->input->post('gender'),
            'starting_location' => $this->input->post('warehouse'),
            'hourly_pay_rate' => $this->input->post('hourly_pay'),
            'profile_image' => $profile_mage
        );
        if ($this->db->insert('driver', $data)) {
            $driver_id = $this->db->insert_id();
            $proffesional = array(
                'license_number' => $this->input->post('driving_license'),
                'ssn' => $this->input->post('ssn'),
                'vehicle_make' => $this->input->post('make'),
                'vehicle_model_type' => $this->input->post('model'),
                'vehicle_color' => $this->input->post('color'),
                'registration_number' => $this->input->post('registration_number'),
                'manufacture_date' => $this->input->post('manufactur_date'),
                'manufacture_date' => $this->input->post('manufactur_date'),
                'driver_id' => $driver_id,
                'document_name' => $this->input->post('document1'),
                'document_image' => $document_url,
                'vehicle_image' => $vehicle_url
            );
            $this->db->insert('driver_professional_detail', $proffesional);
            //$this->updateVehicleImage();
            //insert driver shift details
            $sunday = $this->input->post('sunday') == 'on' ? 1 : 0;
            $monday = $this->input->post('monday') == 'on' ? 1 : 0;
            $tuseday = $this->input->post('tuseday') == 'on' ? 1 : 0;
            $wednesday = $this->input->post('wednesday') == 'on' ? 1 : 0;
            $thursday = $this->input->post('thursday') == 'on' ? 1 : 0;
            $friday = $this->input->post('friday') == 'on' ? 1 : 0;
            $saturday = $this->input->post('saturday') == 'on' ? 1 : 0;
            $fromTime = $_POST['fromTime'];
            $toTime = $_POST['toTime'];
            $availibility = array(
                'driver_id' => $driver_id,
                'mon' => $monday,
                'tue' => $tuseday,
                'wed' => $wednesday,
                'thu' => $thursday,
                'fri' => $friday,
                'sat' => $saturday,
                'sun' => $sunday,
                'from_time' => $this->input->post('from_time'),
                'to_time' => $this->input->post('to_time')
            );
            $this->db->insert('driver_availability', $availibility);

            //send credential on mail to driver
        }

        return TRUE;
    }

    public function checkEmail($email) {
        $query = $this->db->select('*')->from('driver')->where('email', $email)->get();
        if ($query->num_rows() > 0) {
            return true;
        }
    }

    public function getDriverDetails($driverId) {
        $data = array();
        $query = $this->db->select('driver.*,professional_detail.ssn,professional_detail.license_number')
                ->from('driver')
                ->join('driver_professional_detail as professional_detail', 'professional_detail.driver_id=driver.driver_id', 'left')
                ->where('driver.driver_id', $driverId)
                ->get();
//        echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function getDriverInventory() {
        $driverId = $this->getDriver_id();
        $data = array();
        $query = $this->db->select('driver_inventory.*,warehouse.name,items.item_name')
                ->from('driver_inventory')
                ->join('driver_professional_detail as professional_detail', 'professional_detail.driver_id=driver_inventory.driver_id', 'left')
                ->join('items', 'driver_inventory.item_id=items.item_id', 'left')
                ->join('warehouse', 'driver_inventory.warehouse_id=warehouse.id')
                ->where('driver_inventory.driver_id', $driverId)
//                ->limit(3)
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }
    
    public function getDriverTotalOrder() {
        $data = array();
        $currentDate = date("Y-m-d");
        $currentDay  = date ('l');
        
        $driverId = $this->getDriver_id();
        $query = $this->db->select('count(id) as total_order')
                ->from('driver_assigned_order')
                ->where('driver_id', $driverId)
                ->where('expected_delivery_date', $currentDate)
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();   
        }else{
            $data['total_order']= 0;
        }
        $data['currentDate'] = $currentDate;
        $data['currentDay'] = $currentDay;
        return $data;
    }

    public function getDriverOrders($driverId) {
        $data = array();
        $query = $this->db->select('driver_assigned_order.*,users.first_name,users.last_name,orders.order_type')
                ->from('driver_assigned_order')
                ->join('users as users', 'driver_assigned_order.user_id=users.id', 'left')
                ->join('orders', 'driver_assigned_order.driver_id=orders.driver_id', 'left')
                ->where('driver_assigned_order.driver_id', $driverId)
                ->group_by('driver_assigned_order.order_id')
                ->get();
//        echo $this->db->last_query();die;
//        $sql =     'SELECT `driver_assigned_order`.*, `users`.`first_name`, `users`.`last_name`,(select order_type from orders where orders.order_id=driver_assigned_order.order_id) as order_type FROM `driver_assigned_order` LEFT JOIN `users` as `users` ON `driver_assigned_order`.`user_id`=`users`.`id` WHERE `driver_assigned_order`.`driver_id` ='.$driverId;
//        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function getDriverAvailability($driverId) {
        $data = array();
        $query = $this->db->select('*')
                ->from('driver_availability')
                ->where('driver_id', $driverId)
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function getItemsFromInventory() {
        $data = array();
        $query = $this->db->select('mwi.*,items.item_name,wh.name as warehousename')
                ->from('manage_warehouse_items as mwi')
                ->join('warehouse as wh', 'mwi.warehouse_id=wh.id', 'left')
                ->join('items', 'mwi.item_id=items.item_id', 'left')
                ->like('items.item_name', $this->getItemSearch())
                ->group_by('items.item_name')
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

   /* public function assignPickup($driverId) {
        $data = array();
        $query = $this->db->select('*')
                ->from('driver_inventory')
                ->where('driver_id', $driverId)
                ->where('warehouse_id', $this->getWarehouseId())
                ->where('item_id', $this->getItemId())
                ->get();

        if ($query->num_rows() > 0) {
            //update
            $res = $query->row_array();
            $data = array(
                'item_quantity' => $res['item_quantity'] + $this->getQuantity()
            );
            $this->db->where('driver_id', $driverId);
            $this->db->where('warehouse_id', $this->getWarehouseId());
            $this->db->where('item_id', $this->getItemId());
            $this->db->update('driver_inventory', $data);
//            echo $this->db->last_query();exit;
            return true;
        } else {
            //insert
            $data = array(
                'driver_id' => $driverId,
                'warehouse_id' => $this->getWarehouseId(),
                'item_id' => $this->getItemId(),
                'item_quantity' => $this->getQuantity()
            );
            $this->db->where('driver_id', $driverId);
            $this->db->where('warehouse_id', $this->getWarehouseId());
            $this->db->where('item_id', $this->getItemId());
            $this->db->insert('driver_inventory', $data);
            //echo $this->db->last_query();exit;
            return true;
        }
    }*/

    public function removeAssignedProduct() {
        $this->db->where('id', $this->getItemId());
        $this->db->delete('template_items');
        return true;
    }

    public function updateAssignedQuantity() {
        $data = array('quantity' => $this->getQuantity());
        $this->db->where('id', $this->getItemId());
        $this->db->update('template_items', $data);
        return true;
    }

    public function notemptyChecker($driverId) {
        $query = $this->db->select('*')
                ->from('driver_availability')
                ->where('driver_id', $driverId)
                ->get();
//        echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insertAvailTbl() {

        if ($_POST['mon']) {
            $mon = '1';
        } else {
            $mon = '0';
        }
        if ($_POST['tue']) { 
            $tue = '1';
        } else {
            $tue = '0';
        }
        if ($_POST['wed']) {
            $wed = '1';
        } else {
            $wed = '0';
        }
        if ($_POST['thu']) {
            $thu = '1';
        } else {
            $thu = '0';
        }
        if ($_POST['fri']) {
            $fri = '1';
        } else {
            $fri = '0';
        }
        if ($_POST['sat']) {
            $sat = '1';
        } else {
            $sat = '0';
        }
        if ($_POST['sun']) {
            $sun = '1';
        } else {
            $sun = '0';
        }

        $fromTime = $_POST['fromTime'];
        $toTime = $_POST['toTime'];
        $data = array(
            'driver_id' => $this->input->post('driverId'),
            'mon' => $mon,
            'tue' => $tue,
            'wed' => $wed,
            'thu' => $thu,
            'fri' => $fri,
            'sat' => $sat,
            'sun' => $sun,
            'from_time' => $this->input->post('fromTime'),
            'to_time' => $this->input->post('toTime')
        );
        $this->db->insert('driver_availability', $data);
        return TRUE;
    }

    public function updateAvailTbl() {
        if ($_POST['mon']) {
            $mon = '1';
        } else {
            $mon = '0';
        }
        if ($_POST['tue']) {
            $tue = '1';
        } else {
            $tue = '0';
        }
        if ($_POST['wed']) {
            $wed = '1';
        } else {
            $wed = '0';
        }
        if ($_POST['thu']) {
            $thu = '1';
        } else {
            $thu = '0';
        }
        if ($_POST['fri']) {
            $fri = '1';
        } else {
            $fri = '0';
        }
        if ($_POST['sat']) {
            $sat = '1';
        } else {
            $sat = '0';
        }
        if ($_POST['sun']) {
            $sun = '1';
        } else {
            $sun = '0';
        }
        $fromTime = $_POST['fromTime'];
        $toTime = $_POST['toTime'];
        $data = array(
            'mon' => $mon,
            'tue' => $tue,
            'wed' => $wed,
            'thu' => $thu,
            'fri' => $fri,
            'sat' => $sat,
            'sun' => $sun,
            'from_time' => $fromTime,
            'to_time' => $toTime
        );
        $this->db->where('driver_id', $this->input->post('driverId'));
        $this->db->update('driver_availability', $data);
        return true;
    }

    public function getdriverReviews($driverId) {
        $data = [];
        $query = $this->db->select('drr.*,us.first_name,us.last_name,us.profile_pic')
                ->from('driver_review_rating as drr')
                ->join('users as us', 'drr.review_by=us.id', 'left')
                ->where('drr.driver_id', $driverId)
                ->get();
//        echo $this->db->last_query();exit;

        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function driverStatistics($driverId) {
//SELECT COUNT( break_id ) AS shift_taken, shift_clock.driver_id, break_clock.shift_id
//FROM  `shift_clock` 
//LEFT JOIN break_clock ON shift_clock.shift_id = break_clock.shift_id
//AND shift_clock.driver_id = break_clock.driver_id
//WHERE break_clock.shift_id !=  'null'
//GROUP BY break_clock.shift_id
//LIMIT 0 , 30
        $data = [];
        $query = $this->db->query("SELECT 
    shift_clock . *,(SELECT IF(count(break_id) is NULL ,0, count(break_id) )   FROM `break_clock` where break_clock.shift_id != 'null' and break_clock.shift_id = shift_clock.shift_id and driver_id = shift_clock.driver_id group by shift_id) as break_taken,
    SUM(CASE
        WHEN order_status = '6' THEN 1
        ELSE 0
    END ) total, 
    6371 *acos(cos(radians(driver_assigned_order.pickup_location_lat))*cos( radians( driver_assigned_order.drop_location_lat ) )*cos( radians( driver_assigned_order.pickup_location_lang )-radians(driver_assigned_order.drop_location_lang) )+sin( radians(driver_assigned_order.drop_location_lat) )* sin( radians( driver_assigned_order.pickup_location_lat )))  as distance_in_km,
    driver_assigned_order.delivered_date,
    driver_assigned_order.driver_id
FROM
    driver_assigned_order
        LEFT JOIN
    shift_clock ON driver_assigned_order.driver_id = shift_clock.driver_id
        AND driver_assigned_order.delivered_date = shift_clock.date
left join break_clock on shift_clock.shift_id = break_clock.shift_id and shift_clock.driver_id = break_clock.driver_id
WHERE
    delivered_date != '0000-00-00'
        AND driver_assigned_order.driver_id = $driverId
GROUP BY driver_assigned_order.driver_id , driver_assigned_order.delivered_date
LIMIT 0 , 30");


//                $query = $this->db->select("SELECT 
//    shift_clock . *,(SELECT IF(count(break_id) is NULL ,0, count(break_id) )   FROM `break_clock` where break_clock.shift_id != 'null' and break_clock.shift_id = shift_clock.shift_id and driver_id = shift_clock.driver_id group by shift_id) as break_taken,
//    SUM(CASE
//        WHEN order_status = '6' THEN 1
//        ELSE 0
//    END) total,
//    111.111 * DEGREES(ACOS(COS(RADIANS(driver_assigned_order.pickup_location_lat)) * COS(RADIANS(driver_assigned_order.drop_location_lang)) * COS(RADIANS(driver_assigned_order.pickup_location_lang - driver_assigned_order.drop_location_lang)) + SIN(RADIANS(driver_assigned_order.pickup_location_lat)) * SIN(RADIANS(driver_assigned_order.drop_location_lang)))) AS distance_in_km,
//    driver_assigned_order.delivered_date,
//    driver_assigned_order.driver_id
//FROM
//    driver_assigned_order
//        LEFT JOIN
//    shift_clock ON driver_assigned_order.driver_id = shift_clock.driver_id
//        AND driver_assigned_order.delivered_date = shift_clock.date
//left join break_clock on shift_clock.shift_id = break_clock.shift_id and shift_clock.driver_id = break_clock.driver_id
//WHERE
//    delivered_date != '0000-00-00'
//        AND driver_assigned_order.driver_id = 1
//GROUP BY driver_assigned_order.driver_id , driver_assigned_order.delivered_date
//LIMIT 0 , 30");
        //  echo $this->db->last_query();exit;
        
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
//        echo "<pre>ff";
//        print_r($data);exit;

        return $data;
    }

    public function blockUnblockDriver($driverId, $status) {
        if ($status == '1') {
            $newStatus = '0';
        } else {
            $newStatus = '1';
        }
        $data = array('is_blocked' => $newStatus);
        $this->db->where('driver_id', $driverId);
        $this->db->update('driver', $data);
        $this->db->affected_rows();

        return true;
    }

    public function viewShiftDetailedPageByDate($driverId, $date) {
        $data = array();
        $query = $this->db->select('shift_id,driver_id,start_time,edited_start_time,end_time,edited_end_time,total_time,payable_amount,original_payable_amount,date')
                ->from('shift_clock')
                ->where('date', $date)
                ->where('driver_id', $driverId)
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function viewBreakShiftDetailedPageByDate($driverId, $date) {
        $data = array();
        $query = $this->db->select('break_id,driver_id,shift_id,start_time,edited_start_time,break_type,end_time,edited_end_time,total_time,date')
                ->from('break_clock')
                ->where('date', $date)
                ->where('driver_id', $driverId)
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function fetchWorkedInfo($shiftId, $driverId) {
        $data = array();
        $query = $this->db->select('*')
                ->from('shift_clock')
                ->where('shift_id', $shiftId)
                ->where('driver_id', $driverId)
                ->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function getTotalBreakData($shiftId, $date) {
        $data = array();
        $query = $this->db->select('count(break_clock.break_id) as total_break_taken,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total_break_time_taken')
                ->from('break_clock')
                ->where('driver_id', $shiftId)
                ->where('date', $date)
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function getTotaldeliveryData($driverId, $date) {
        $data = array();
        $query = $this->db->select('count(id) as totaldelivery, SUM(6371 *acos(cos(radians(driver_assigned_order.pickup_location_lat))*cos( radians(driver_assigned_order.drop_location_lat ) )*cos( radians(pickup_location_lang )-radians(driver_assigned_order.drop_location_lang) )+sin( radians(driver_assigned_order.drop_location_lat) )* sin( radians(driver_assigned_order.pickup_location_lat )))) as distance_in_km ')
                ->from('driver_assigned_order')
                ->where('driver_id', $driverId)
                ->where('delivered_date', $date)
                ->where('order_status', '6')
                ->get();
       
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function fetchBreakInfo($breakId) {
        $data = array();
        $query = $this->db->select('*')
                ->from('break_clock')
                ->where('break_id', $breakId)
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function updateWorkedInfo() {
        $start = $this->getFrom_time();
        $end = $this->getTo_time();
        $diff = date_diff(date_create($end), date_create($start));
        $data = array(
            'start_time' => $this->getFrom_time(),
            'end_time' => $this->getTo_time(),
            'payable_amount' => $this->getPayable_amount(),
            'total_time' => $diff->h . ':' . $diff->i . ':' . $diff->s
        );
        $this->db->where('shift_id', $this->getShift_id());
        $this->db->update('shift_clock', $data);
//        echo $this->db->last_query();exit;
        return true;
    }

    public function updateBreakInfo() {
        $start = $this->getFrom_time();
        $end = $this->getTo_time();
        $diff = date_diff(date_create($end), date_create($start));
        $data = array(
            'start_time' => $this->getFrom_time(),
            'end_time' => $this->getTo_time(),
            'total_time' => $diff->h . ':' . $diff->i . ':' . $diff->s
        );
        $this->db->where('break_id', $this->getShift_id());
        $this->db->update('break_clock', $data);

        return true;
    }

    public function driverWeekStatistics($driverId, $startDate = null, $endDate = null) {
        $data = array();
        $date = new DateTime(date("Y-m-d"));
        if ($startDate) {
            $backDate = $startDate;
        } else {
            $date->modify('-7 day');
            $backDate = $date->format('Y-m-d');
        }

        if ($endDate) {
            $currentDate = $endDate;
        } else {
            $currentDate = $date->format('Y-m-d');
        }

        $this->set_start_date($backDate);
        $this->set_end_date($currentDate);
        $this->setDriver_id($driverId);
        $data[] = $this->getDriverWeekTotalBreakTime();
        $data[] = $this->getDriverWeekTotalDis_DelOrder_PayAmount();
        return array_merge($data[0], $data[1]);
    }

    public function getDriverWeekTotalBreakTime() {

        $query = $this->db->query("SELECT count(break_clock.break_id) as total_break_taken, SEC_TO_TIME(SUM(TIME_TO_SEC(break_clock.total_time))) AS total_break_time_taken FROM break_clock where break_clock.shift_id IN(select sc.shift_id FROM driver_assigned_order dao LEFT JOIN shift_clock as sc ON dao.driver_id = sc.driver_id AND dao.delivered_date = sc.date where dao.delivered_date >='" . $this->get_start_date() . "' AND dao.delivered_date <='" . $this->get_end_date() . "' AND dao.driver_id = '" . $this->getDriver_id() . "')")->row_array();
        return $query;
    }

    public function getDriverWeekTotalDis_DelOrder_PayAmount() {
        $query = $this->db->query("SELECT
        SEC_TO_TIME(SUM(TIME_TO_SEC(shift_clock.total_time))) AS total_shift_clock_time,
        count(shift_clock.total_time) AS count_shift_clock_time,
        SUM(shift_clock. payable_amount)as total_payable_amount,
        SUM(CASE WHEN order_status = '6' THEN 1 ELSE 0 END) total_delivered_order,
        SUM(6371 *acos(cos(radians(driver_assigned_order.pickup_location_lat))*cos( radians(driver_assigned_order.drop_location_lat ) )*cos( radians(pickup_location_lang )-radians(driver_assigned_order.drop_location_lang) )+sin( radians(driver_assigned_order.drop_location_lat) )* sin( radians(driver_assigned_order.pickup_location_lat )))) as distance_in_km 
        FROM driver_assigned_order 
        LEFT JOIN shift_clock ON  driver_assigned_order.driver_id = shift_clock.driver_id 
        AND driver_assigned_order.delivered_date = shift_clock.date
        where driver_assigned_order.delivered_date >='" . $this->get_start_date() . "'
        AND driver_assigned_order.delivered_date <='" . $this->get_end_date() . "'
        AND driver_assigned_order.driver_id = '" . $this->getDriver_id() . "'")->row_array();
        return $query;
    }
    
    
    public function updateDriverBreakTime(){
        $break = $this->db->select('*')
                ->from('break_clock')
                ->where('break_id',$this->get_break_id())
                ->get()->row_array();
     
        if($this->getFrom_time() !=""){
            $endTime = ($break['edited_end_time'] && $break['edited_end_time'] !="00:00:00")?$break['edited_end_time']:$break['end_time'];
            $data['edited_start_time']=  date("H:i:s", strtotime($this->getFrom_time()));
    
            $datetime1 = new DateTime($data['edited_start_time']);
            $datetime2 = new DateTime($endTime);
            $interval = $datetime1->diff($datetime2);
            
            $data['total_time'] = $interval->format('%h').":".$interval->format('%i').":".$interval->format('%s');
           
        }
        
        if($this->getTo_time() !=""){
            $startTime = ($break['edited_start_time'] && $break['edited_start_time'] !="00:00:00")?$break['edited_start_time']:$break['start_time'];
            $data['edited_end_time']= date("H:i:s", strtotime($this->getTo_time()));
            $datetime1 = new DateTime($startTime);
            $datetime2 = new DateTime($data['edited_end_time']);
            $interval = $datetime1->diff($datetime2);
            $data['total_time'] = $interval->format('%h').":".$interval->format('%i').":".$interval->format('%s');
        }
      
        $this->db->where('break_id',$this->get_break_id());
        $this->db->update('break_clock',$data); 
        return true;
    }
    
    public function updateDriverShiftTime(){
        $data = array();
        $break = $this->db->select('*')
                ->from('shift_clock')
                ->where('shift_id',$this->getShift_id())
                ->get()->row_array();
     
        if($this->getFrom_time() !=""){
            $endTime = ($break['edited_end_time'] && $break['edited_end_time'] !="00:00:00")?$break['edited_end_time']:$break['end_time'];
            $data['edited_start_time']=  date("h:i:s", strtotime($this->getFrom_time()));
          
            $datetime1 = new DateTime($data['edited_start_time']);
            $datetime2 = new DateTime($endTime);
            
            $interval = $datetime1->diff($datetime2);
            $data['total_time'] = $interval->format('%h').":".$interval->format('%i').":".$interval->format('%s');
            
        }
        
        if($this->getTo_time() !=""){
            $startTime = ($break['edited_start_time'] && $break['edited_start_time']!="00:00:00")?$break['edited_start_time']:$break['start_time'];
            $data['edited_end_time']= date("H:i:s", strtotime($this->getTo_time()));
            $datetime1 = new DateTime($startTime);
            $datetime2 = new DateTime($data['edited_end_time']);
            $interval = $datetime1->diff($datetime2);
            $data['total_time'] = $interval->format('%h').":".$interval->format('%i').":".$interval->format('%s');
        }     
        $this->db->where('shift_id',$this->getShift_id());
        $this->db->update('shift_clock',$data); 
        return true;
    }
    
    public function driverShiftAmountEdit(){
        $data['original_payable_amount'] =  $this->get_original_payable_amount();
        $data['payable_amount']          =  $this->getPayable_amount();
        $this->db->where('shift_id',$this->getShift_id());
        $this->db->update('shift_clock',$data); 
       
        return true;
    }
    
    public function getDriverTemplate(){
        $template = $this->db->select('*')
                ->from('template')
                ->where('driver_id',$this->getDriver_id())
                ->get()->result_array();
       
        return $template;
    }
    
    public function getAllProduct(){
        $product = $this->db->select('*')
                ->from('items')
                ->get()->result_array();
       
        return $product;
    }
    public function getAllWarehouse(){
        $warehouse = $this->db->select('*')
                ->from('warehouse')
                ->get()->result_array();
       
        return $warehouse;
    }
    
    public function getDriverTemplateInventory() {
        $driverId = $this->getDriver_id();
        $data = array();
        $query = $this->db->select('ti.*,w.name,i.item_name')
                ->from('template as t')
                ->join('template_items as ti', 't.id=ti.template_id')
                ->join('driver_professional_detail as pd', 'pd.driver_id=t.driver_id', 'left')
                ->join('items as i', 'ti.item_id=i.item_id', 'left')
                ->join('warehouse as w', 'ti.warehouse_id=w.id')
                ->where('t.driver_id', $driverId)
                ->where('t.is_assigned', '1')
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }
    
    public function getDriverTemplateInventoryFront($driverId) {
        $data = array();
        $query = $this->db->select('ti.*,w.name,i.item_name,ct.name as cat_name')
                ->from('template as t')
                ->join('template_items as ti', 't.id=ti.template_id')
                ->join('driver_professional_detail as pd', 'pd.driver_id=t.driver_id', 'left')
                ->join('items as i', 'ti.item_id=i.item_id', 'left')
                ->join('category as ct', 'ct.category_id=i.category_id', 'left')
                ->join('warehouse as w', 'ti.warehouse_id=w.id')
                ->where('t.driver_id', $driverId)
                ->where('t.is_assigned', '1')
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }
    
    public function getTemplateItem(){
        $driverId   = $this->getDriver_id();
        $templateId = $this->get_template_id();
        $data = $this->db->select('ti.*,w.name,i.item_name')
                ->from('template as t')
                ->join('template_items as ti', 't.id=ti.template_id')
                ->join('driver_professional_detail as pd', 'pd.driver_id=t.driver_id', 'left')
                ->join('items as i', 'ti.item_id=i.item_id', 'left')
                ->join('warehouse as w', 'ti.warehouse_id=w.id')
                ->where('t.driver_id', $driverId)
                ->where('ti.template_id', $templateId)
                ->get()->result_array();
        return $data;
    }
    
    public function saveTemplateItem(){
        $item_ids            = $this->getItemId();
        $item_quantity      = $this->getQuantity();
        $item_warehouse_id  = $this->getWarehouseId();
        $item_template_id  = $this->get_template_id();
        
        $insertArray = array();
        $succesfullyInsaert = array();
        if(sizeof($item_ids)>0){
            $i = 0;
            foreach($item_ids as $item_id){
                if($item_id !=0 && $item_id !='' && $item_quantity[$i] !=0 && $item_quantity[$i] !='' && $item_warehouse_id[$i]!=0 && $item_warehouse_id[$i]!=''){
                    
                   $checkProduct = $this->db->select('*')
                           ->from('template_items')
                           ->where('item_id', $item_id)
                           ->where('template_id', $item_template_id)
                           ->get()->result_array();
                   //echo"<pre/>"; print_r($checkProduct); die;
                    if($checkProduct){
                        $updateArray = array('quantity'=>$item_quantity[$i]);
                        $this->db->where('item_id', $item_id);
                        $this->db->where('template_id', $item_template_id);
                        $this->db->update('template_items', $updateArray);
                        $succesfullyInsaert[]= array(1);
                    }else{
                        $insertArray = array(
                            'template_id'=> $item_template_id,
                            'item_id'=> $item_id,
                            'warehouse_id'=>$item_warehouse_id[$i],
                            'quantity'=>$item_quantity[$i]
                        );   
                        $this->db->insert('template_items', $insertArray);
                        $succesfullyInsaert[]= array(1);
                    } 
                }
                
                $i++;
            } 
            
            if(sizeof($succesfullyInsaert)>0){
                return true;
            }else{
                return false;
            }
        }else{
              return false;
        }
          
    }
    
    public function assignTemplate(){
        $driverId   = $this->getDriver_id();
        $templateId = $this->get_template_id();
        $updateArray1 = array('is_assigned'=>'0');
                    $this->db->where('driver_id', $driverId);
                    $this->db->update('template', $updateArray1);

        $updateArray2 = array('is_assigned'=>'1');
                    $this->db->where('driver_id', $driverId);
                    $this->db->where('id', $templateId);
                    $this->db->update('template', $updateArray2);             
        echo $this->db->last_query($updateArray2);
       
        return true;
    }
    
    public function addTemplate() {
        $driverId = $this->getDriver_id();
        $templateName = $this->get_template_name();
        $checkProduct = $this->db->select('*')
                        ->from('template')
                        ->where('name', $templateName)
                        ->where('driver_id', $driverId)
                        ->get()->result_array();
        //echo"<pre/>"; print_r($checkProduct); die;
        if ($checkProduct) {
            return false;
        } else {
            $insertArray = array(
                'name' => $templateName,
                'driver_id' => $driverId
            );
            $this->db->insert('template', $insertArray);
            return true;
        }
    }
    
     public function removeTemplate() {
        $this->db->where('id', $this->getItemId());
        $this->db->delete('template');
        
        $this->db->where('template_id', $this->getItemId());
        $this->db->delete('template_items');
        return true;
    }

}

?>