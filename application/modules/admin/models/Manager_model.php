<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Manager_model extends CI_Model {   
    private $_searchData = "", $_unit = "", $_category = "", $_subCategory = "", $_productUnit = "";
    private $_firstname, $_lastname, $_email, $_phone, $_picUrl, $_customid, $_customname, $_customarray;
    private $_doc1Name, $_do2Name, $_doc3Name, $_doc1Url, $_doc2Url, $_doc3Url, $_orderType;
    private $_sdate, $_edate, $_stime, $_etime, $_searchStatus, $_searchDriver, $_searchLocation;
    private $_driverid, $_orderid, $_lat, $_lng;
    private $_name, $_designee, $_identityno, $_city, $_state, $_country;
    //------------ Add/View/Edit Product private variable
    private $_categories = array(), $_itemSubType, $_itemname, $_itemunit, $_itemfamily, $_itemcolor, $_itemflavour, $_deducted_price;
    private $_itemid, $_ounce8price, $_ounce8offprice, $_anounceprice, $_anounceoffprice, $_itemrecommends, $_itemeffects, $_itemreview, $_categoryName;
    private $_itemhot, $_itembiweekly, $_itemluxurious, $_itemthc, $_itemcbg, $_itemcbc, $_itemcbn, $_itemcbd, $_itemthcv, $_itemswhQnty;
    private $_message, $_link, $_familyId, $_familyname, $_modules, $_whid, $_whname, $_whaddress, $_zipcode;
    private $_cargiver;
    private $_onegramprice, $_onegramoffprice, $_limited, $_moods, $_medicals,$_quantity_type;
    //--  Coupons private variables
    private $_couponName, $_couponMinOrderPrice, $_couponCode, $_couponValidity, $_couponPoints, $_couponDiscount, $_couponDistype, $_couponCategoryid;

    //--- Start date setter/getter

     function get_quantity_type() {
        return $this->_quantity_type;
    }

    function set_quantity_type($_quantity_type) {
        $this->_quantity_type = $_quantity_type;
    }

    
    function get_moods() {
        return $this->_moods;
    }

    function get_medicals() {
        return $this->_medicals;
    }

    function set_moods($_moods) {
        $this->_moods = $_moods;
    }

    function set_medicals($_medicals) {
        $this->_medicals = $_medicals;
    }

    function get_limited() {
        return $this->_limited;
    }

    function set_limited($_limited) {
        $this->_limited = $_limited;
    }

    function get_do2Name() {
        return $this->_do2Name;
    }

    function get_cargiver() {
        return $this->_cargiver;
    }

    function get_deducted_price() {
        return $this->_deducted_price;
    }

    function set_deducted_price($_deducted_price) {
        $this->_deducted_price = $_deducted_price;
    }

    function set_do2Name($_do2Name) {
        $this->_do2Name = $_do2Name;
    }

    function set_cargiver($_cargiver) {
        $this->_cargiver = $_cargiver;
    }

    function get_ounce8offprice() {
        return $this->_ounce8offprice;
    }

    function get_anounceoffprice() {
        return $this->_anounceoffprice;
    }

    function get_onegramprice() {
        return $this->_onegramprice;
    }

    function get_onegramoffprice() {
        return $this->_onegramoffprice;
    }

    function set_ounce8offprice($_ounce8offprice) {
        $this->_ounce8offprice = $_ounce8offprice;
    }

    function set_anounceoffprice($_anounceoffprice) {
        $this->_anounceoffprice = $_anounceoffprice;
    }

    function set_onegramprice($_onegramprice) {
        $this->_onegramprice = $_onegramprice;
    }

    function set_onegramoffprice($_onegramoffprice) {
        $this->_onegramoffprice = $_onegramoffprice;
    }

    function set_sdate($_sdate) {
        $this->_sdate = $_sdate;
    }

    function get_sdate() {
        return $this->_sdate;
    }

    //--- End date setter/getter
    function set_edate($_edate) {
        $this->_edate = $_edate;
    }

    function get_edate() {
        return $this->_edate;
    }

    //--- Start Time setter/getter
    function set_stime($_stime) {
        $this->_stime = $_stime;
    }

    function get_stime() {
        return $this->_stime;
    }

    //--- End Time setter/getter
    function set_etime($_etime) {
        $this->_etime = $_etime;
    }

    function get_etime() {
        return $this->_etime;
    }

    //--- userid setter/getter
    function set_userid($_userid) {
        $this->_userid = $_userid;
    }

    function get_userid() {
        return $this->_userid;
    }

    //--- customid setter/getter
    function set_customid($_customid) {
        $this->_customid = $_customid;
    }

    function get_customid() {
        return $this->_customid;
    }

    //--- customid setter/getter
    function set_customname($_customname) {
        $this->_customname = $_customname;
    }

    function get_customname() {
        return $this->_customname;
    }

    //--- custom Array setter/getter
    function set_customarray($_customarray) {
        $this->_customarray = $_customarray;
    }

    function get_customarray() {
        return $this->_customarray;
    }

    //--- First Name setter/getter
    function set_firstname($_firstname) {
        $this->_firstname = $_firstname;
    }

    function get_firstname() {
        return $this->_firstname;
    }

    //--- Last Name setter/getter
    function set_lastname($_lastname) {
        $this->_lastname = $_lastname;
    }

    function get_lastname() {
        return $this->_lastname;
    }

    //--- Last Name setter/getter
    function set_email($_email) {
        $this->_email = $_email;
    }

    function get_email() {
        return $this->_email;
    }

    //--- Last Name setter/getter
    function set_phone($_phone) {
        $this->_phone = $_phone;
    }

    function get_phone() {
        return $this->_phone;
    }

    //--- Last Name setter/getter
    function set_picUrl($_picUrl) {
        $this->_picUrl = $_picUrl;
    }

    function get_picUrl() {
        return $this->_picUrl;
    }

    //--- Last Name setter/getter
    function set_doc1Name($_doc1Name) {
        $this->_doc1Name = $_doc1Name;
    }

    function get_doc1Name() {
        return $this->_doc1Name;
    }

    //--- Last Name setter/getter
    function set_doc2Name($_doc2Name) {
        $this->_doc2Name = $_doc2Name;
    }

    function get_doc2Name() {
        return $this->_doc2Name;
    }

    //--- Last Name setter/getter
    function set_doc3Name($_doc3Name) {
        $this->_doc3Name = $_doc3Name;
    }

    function get_doc3Name() {
        return $this->_doc3Name;
    }

    //--- Last Name setter/getter
    function set_doc1Url($_doc1Url) {
        $this->_doc1Url = $_doc1Url;
    }

    function get_doc1Url() {
        return $this->_doc1Url;
    }

    //--- Last Name setter/getter
    function set_doc2Url($_doc2Url) {
        $this->_doc2Url = $_doc2Url;
    }

    function get_doc2Url() {
        return $this->_doc2Url;
    }

    //--- Last Name setter/getter
    function set_doc3Url($_doc3Url) {
        $this->_doc3Url = $_doc3Url;
    }

    function get_doc3Url() {
        return $this->_doc3Url;
    }

    //-- Search Text Setter / Getter
    function getSearchData() {
        return $this->_searchData;
    }

    function setSearchData($searchData) {
        $this->_searchData = $searchData;
    }

    //-- Search Text Setter / Getter
    function getSearchStatus() {
        return $this->_searchStatus;
    }

    function setSearchStatus($searchStatus) {
        $this->_searchStatus = $searchStatus;
    }

    //-- Category Text Setter / Getter
    function getCategory() {
        return $this->_category;
    }

    function setCategory($category) {
        $this->_category = $category;
    }

    //-- Units Text Setter / Getter
    function getUnit() {
        return $this->_unit;
    }

    function setUnit($unit) {
        $this->_unit = $unit;
    }
    function get_subCategory() {
        return $this->_subCategory;
    }

    function set_subCategory($_subCategory) {
        $this->_subCategory = $_subCategory;
    }

        //-- Product Unit Text Setter / Getter
    function getProductUnit() {
        return $this->_productUnit;
    }

    function setProductUnit($productUnit) {
        $this->_productUnit = $productUnit;
    }

    //-- Search Text Setter / Getter
    function getSearchDriver() {
        return $this->_searchDriver;
    }

    function setSearchDriver($searchDriver) {
        $this->_searchDriver = $searchDriver;
    }

    //-- Search Text Setter / Getter
    function getSearchLocation() {
        return $this->_searchLocation;
    }

    function setSearchLocation($searchLocation) {
        $this->_searchLocation = $searchLocation;
    }

    //-- Search Text Setter / Getter
    function get_zipcode() {
        return $this->_zipcode;
    }

    function set_zipcode($_zipcode) {
        $this->_zipcode = $_zipcode;
    }

    //-- Search Text Setter / Getter
    function get_name() {
        return $this->_name;
    }

    function set_name($_name) {
        $this->_name = $_name;
    }

    //-- Search Text Setter / Getter
    function get_city() {
        return $this->_city;
    }

    function set_city($_city) {
        $this->_city = $_city;
    }

    //-- Search Text Setter / Getter
    function get_state() {
        return $this->_state;
    }

    function set_state($_state) {
        $this->_state = $_state;
    }

    //-- Search Text Setter / Getter
    function get_country() {
        return $this->_country;
    }

    function set_country($_country) {
        $this->_country = $_country;
    }

    //-- Search Text Setter / Getter
    function get_identityno() {
        return $this->_identityno;
    }

    function set_identityno($_identityno) {
        $this->_identityno = $_identityno;
    }

    //-- Search Text Setter / Getter
    function get_designee() {
        return $this->_designee;
    }

    function set_designee($_designee) {
        $this->_designee = $_designee;
    }

    //-- Search Text Setter / Getter
    function get_lat() {
        return $this->_lat;
    }

    function set_lat($_lat) {
        $this->_lat = $_lat;
    }

    //-- Search Text Setter / Getter
    function get_lng() {
        return $this->_lng;
    }

    function set_lng($_lng) {
        $this->_lng = $_lng;
    }

    //--- Order Id Setter/Getter
    function set_orderid($_orderid) {
        $this->_orderid = $_orderid;
    }

    function get_orderid() {
        return $this->_orderid;
    }

    //--- Driver Id Setter/Getter
    function set_driverid($_driverid) {
        $this->_driverid = $_driverid;
    }

    function get_driverid() {
        return $this->_driverid;
    }

    //--- categories setter/getter
    function set_categories($_categories) {
        $this->_categories = $_categories;
    }

    function get_categories() {
        return $this->_categories;
    }

    //--- itemSubType setter/getter
    function set_itemSubType($_itemSubType) {
        $this->_itemSubType = $_itemSubType;
    }

    function get_itemSubType() {
        return $this->_itemSubType;
    }

    //--- itemid setter/getter
    function set_itemid($_itemid) {
        $this->_itemid = $_itemid;
    }

    function get_itemid() {
        return $this->_itemid;
    }

    //--- itemname setter/getter
    function set_itemname($_itemname) {
        $this->_itemname = $_itemname;
    }

    function get_itemname() {
        return $this->_itemname;
    }

    //--- itemunit setter/getter
    function set_itemunit($_itemunit) {
        $this->_itemunit = $_itemunit;
    }

    function get_itemunit() {
        return $this->_itemunit;
    }

    //--- itemfamily setter/getter
    function set_itemfamily($_itemfamily) {
        $this->_itemfamily = $_itemfamily;
    }

    function get_itemfamily() {
        return $this->_itemfamily;
    }

    //--- itemcolor setter/getter
    function set_itemcolor($_itemcolor) {
        $this->_itemcolor = $_itemcolor;
    }

    function get_itemcolor() {
        return $this->_itemcolor;
    }

    //--- itemflavour setter/getter
    function set_itemflavour($_itemflavour) {
        $this->_itemflavour = $_itemflavour;
    }

    function get_itemflavour() {
        return $this->_itemflavour;
    }

    //--- ounce8price setter/getter
    function set_ounce8price($_ounce8price) {
        $this->_ounce8price = $_ounce8price;
    }

    function get_ounce8price() {
        return $this->_ounce8price;
    }

    //--- anounceprice setter/getter
    function set_anounceprice($_anounceprice) {
        $this->_anounceprice = $_anounceprice;
    }

    function get_anounceprice() {
        return $this->_anounceprice;
    }

    //--- itemrecommends setter/getter
    function set_itemrecommends($_itemrecommends) {
        $this->_itemrecommends = $_itemrecommends;
    }

    function get_itemrecommends() {
        return $this->_itemrecommends;
    }

    //--- itemeffects setter/getter
    function set_itemeffects($_itemeffects) {
        $this->_itemeffects = $_itemeffects;
    }

    function get_itemeffects() {
        return $this->_itemeffects;
    }

    //--- itemreview setter/getter
    function set_itemreview($_itemreview) {
        $this->_itemreview = $_itemreview;
    }

    function get_itemreview() {
        return $this->_itemreview;
    }

    //--- item hot setter/getter
    function set_itemhot($_itemhot) {
        $this->_itemhot = $_itemhot;
    }

    function get_itemhot() {
        return $this->_itemhot;
    }

    //--- item biweekly setter/getter
    function set_itembiweekly($_itembiweekly) {
        $this->_itembiweekly = $_itembiweekly;
    }

    function get_itembiweekly() {
        return $this->_itembiweekly;
    }

    //--- item hot setter/getter
    function set_itemluxurious($_itemluxurious) {
        $this->_itemluxurious = $_itemluxurious;
    }

    function get_itemluxurious() {
        return $this->_itemluxurious;
    }

    //--- item thc setter/getter
    function set_itemthc($_itemthc) {
        $this->_itemthc = $_itemthc;
    }

    function get_itemthc() {
        return $this->_itemthc;
    }

    //--- ite mcbg setter/getter
    function set_itemcbg($_itemcbg) {
        $this->_itemcbg = $_itemcbg;
    }

    function get_itemcbg() {
        return $this->_itemcbg;
    }

    //--- cbc mcbg setter/getter
    function set_itemcbc($_itemcbc) {
        $this->_itemcbc = $_itemcbc;
    }

    function get_itemcbc() {
        return $this->_itemcbc;
    }

    //--- item cbn setter/getter
    function set_itemcbn($_itemcbn) {
        $this->_itemcbn = $_itemcbn;
    }

    function get_itemcbn() {
        return $this->_itemcbn;
    }

    //--- ite mcbg setter/getter
    function set_itemcbd($_itemcbd) {
        $this->_itemcbd = $_itemcbd;
    }

    function get_itemcbd() {
        return $this->_itemcbd;
    }

    //--- cbc mcbg setter/getter
    function set_itemthcv($_itemthcv) {
        $this->_itemthcv = $_itemthcv;
    }

    function get_itemthcv() {
        return $this->_itemthcv;
    }

    //--- Warehouse Items setter/getter
    function set_itemswhQnty($_itemswhQnty) {
        $this->_itemswhQnty = $_itemswhQnty;
    }

    function get_itemswhQnty() {
        return $this->_itemswhQnty;
    }

    //--- Order Schedule Type setter/getter
    function set_orderType($_orderType) {
        $this->_orderType = $_orderType;
    }

    function get_orderType() {
        return $this->_orderType;
    }

    //--- Warehouse Items setter/getter
    function set_categoryName($_categoryName) {
        $this->_categoryName = $_categoryName;
    }

    function get_categoryName() {
        return $this->_categoryName;
    }

    //--- Warehouse Items setter/getter
    function set_modules($_modules) {
        $this->_modules = $_modules;
    }

    function get_modules() {
        return $this->_modules;
    }

    //--- Warehouse Items setter/getter
    function set_familyname($_familyname) {
        $this->_familyname = $_familyname;
    }

    function get_familyname() {
        return $this->_familyname;
    }

    //--- Warehouse Items setter/getter
    function set_familyId($_familyId) {
        $this->_familyId = $_familyId;
    }

    function get_familyId() {
        return $this->_familyId;
    }

    //--- Warehouse Name setter/getter
    function set_whname($_whname) {
        $this->_whname = $_whname;
    }

    function get_whname() {
        return $this->_whname;
    }

    //--- Warehouse Id setter/getter
    function set_whid($_whid) {
        $this->_whid = $_whid;
    }

    function get_whid() {
        return $this->_whid;
    }

    //--- Warehouse Id setter/getter
    function set_whaddress($_whaddress) {
        $this->_whaddress = $_whaddress;
    }

    function get_whaddress() {
        return $this->_whaddress;
    }

    //--- Warehouse Items setter/getter
    function set_message($_message) {
        $this->_message = $_message;
    }

    function get_message() {
        return $this->_message;
    }

    //--- Warehouse Items setter/getter
    function set_link($_link) {
        $this->_link = $_link;
    }

    function get_link() {
        return $this->_link;
    }

    //-- Coupons Setter/Getter
    // $_couponName, $_couponMinOrderPrice, $_couponCode, $_couponValidity, $_couponPoints, $_couponDiscount, $_couponDistype, $_couponCategoryid; 
    function set_couponName($_couponName) {
        $this->_couponName = $_couponName;
    }

    function get_couponName() {
        return $this->_couponName;
    }

    function set_couponMinOrderPrice($_couponMinOrderPrice) {
        $this->_couponMinOrderPrice = $_couponMinOrderPrice;
    }

    function get_couponMinOrderPrice() {
        return $this->_couponMinOrderPrice;
    }

    function set_couponCode($_couponCode) {
        $this->_couponCode = $_couponCode;
    }

    function get_couponCode() {
        return $this->_couponCode;
    }

    function set_couponValidity($_couponValidity) {
        $this->_couponValidity = $_couponValidity;
    }

    function get_couponValidity() {
        return $this->_couponValidity;
    }

    function set_couponPoints($_couponPoints) {
        $this->_couponPoints = $_couponPoints;
    }

    function get_couponPoints() {
        return $this->_couponPoints;
    }

    function set_couponDiscount($_couponDiscount) {
        $this->_couponDiscount = $_couponDiscount;
    }

    function get_couponDiscount() {
        return $this->_couponDiscount;
    }

    function set_couponDistype($_couponDistype) {
        $this->_couponDistype = $_couponDistype;
    }

    function get_couponDistype() {
        return $this->_couponDistype;
    }

    function set_couponCategoryid($_couponCategoryid) {
        $this->_couponCategoryid = $_couponCategoryid;
    }

    function get_couponCategoryid() {
        return $this->_couponCategoryid;
    }

    /*
     * Admin Dashboard Section
     * @author : niraj
     * @admin panel 
     * @function for : Count All Box Data 
     */

    public function analised_data_for_dashboard() {

        $returndata = array(
            'customer_counts' => 0,
            'doctor_counts' => 0,
            'total_orders' => 0,
            'scheduled_orders' => 0,
            'orders_in_transnit' => 0,
            'orders_completed' => 0,
            'total_appointments' => 0,
            'prescription_issued' => 0,
        );


        //--- Doctor / Customers Counts
        if ($this->get_sdate() != '' && $this->get_edate() != '') {
            $this->db->where('created_at >=', $this->get_sdate());
            $this->db->where('created_at <=', $this->get_edate());
        }

        $tbl_users_data = $this->db->where('is_deleted', '0')
                        ->where('is_blocked', '0')
                        ->get('users')->result_array();

        foreach ($tbl_users_data AS $user_row) {
            if ($user_row['user_type'] == 0) {
                $returndata['customer_counts'] += 1;
            }   //-- Total Customers
            if ($user_row['user_type'] == 1) {
                $returndata['doctor_counts'] += 1;
            }     //-- Total doctors
        }

        //--- All Order Details 
        if ($this->get_sdate() != '' && $this->get_edate() != '') {
            $this->db->where('created_at >=', $this->get_sdate());
            $this->db->where('created_at <=', $this->get_edate());
        }

        $tbl_orders_data = $this->db->get('orders')->result_array();

        $returndata['total_orders'] = sizeof($tbl_orders_data);                       //-- Total oredrs 
        foreach ($tbl_orders_data AS $order_row) {
            if ($order_row['order_status'] == 6) {
                $returndata['orders_completed'] += 1;
            } //-- Orders completed
            if ($order_row['order_type'] == 0) {
                $returndata['scheduled_orders'] += 1;
            }   //-- Orders scheduled
            if ($order_row['status'] == 2) {
                $returndata['orders_in_transnit'] += 1;
            }     //-- Orders in-transit
        }

        //--- Doctor - customer Appointment 
        if ($this->get_sdate() != '' && $this->get_edate() != '') {
            $this->db->where('created_at >=', $this->get_sdate());
            $this->db->where('created_at <=', $this->get_edate());
        }
        $tbl_appointments_data = $this->db->get('appointment_details')->result_array();

        $returndata['total_appointments'] = sizeof($tbl_appointments_data);            //-- Total Appointment 
        //--- Total Users Prescription 
        if ($this->get_sdate() != '' && $this->get_edate() != '') {
            $this->db->where('created_at >=', $this->get_sdate());
            $this->db->where('created_at <=', $this->get_edate());
        }
        $tbl_appointments_data = $this->db->get('appointment_details')->result_array();

        $returndata['total_appointments'] = sizeof($tbl_appointments_data);            //-- Total Appointment 


        return $returndata;
    }

    /*     * *****************************************
     *   Orders Section                       *
     * ***************************************** */

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Count All Orders Records 
     */

    public function ordersCount() {
        $data = array();
        $query = $this->db->select('orders.order_id AS oid, orders.user_id AS uid,fetchPrescription(orders.user_id) as prescriptions, orders.driver_id AS did, orders.delivery_time, orders.delivery_date, orders.drop_location, orders.drop_location_lat, orders.drop_location_lang, orders.pay_status, orders.order_type, orders.order_status, orders.amount, orders.created_at, orders.updated_at, driver.first_name AS driver_fname, driver.last_name AS driver_lname, driver.email AS driver_email, driver.contact_number AS driver_contact, driver.starting_location AS warehouseid, driver.latitude AS driver_latitude, driver.longitude AS driver_longitude, warehouse.name AS driver_sloc, warehouse.address AS driver_saddr, warehouse.lat AS driver_slat, warehouse.lang AS driver_slang, driver_professional_detail.registration_number AS driver_vehicleno,driver_professional_detail.vehicle_model_type AS driver_vehiclemodel, users.first_name AS user_fname, users.last_name AS user_lname, users.email AS user_email, users.phone_number AS user_contact, users.city, users.state, users.address')->from('orders')
                ->join('driver', 'driver.driver_id = orders.driver_id', 'left')
                ->join('users', 'users.id = orders.user_id', 'left')
                ->join('driver_professional_detail', 'driver_professional_detail.driver_id = orders.driver_id', 'left')
                ->join('warehouse', 'warehouse.id = driver.starting_location', 'left');
        //-- Search by date range 
        if ($this->get_sdate() != '' && $this->get_edate() != '') {
            $this->db->where('orders.created_at >=', $this->get_sdate());
            $this->db->where('orders.created_at <=', $this->get_edate());
        }

        //-- Search by order Status
        if ($this->getSearchStatus() != "") {
            $makeFilter = $this->getSearchStatus();
            $query = $this->db->where('orders.order_status', $makeFilter);
        }
        //-- Search by Customer Name
        if ($this->getsearchDriver() != "") {
            $makeFilter = $this->getsearchDriver();
            $query = $this->db->where('orders.driver_id', $makeFilter);
        }
        //-- Search by Order Location 
        if ($this->getSearchLocation() != "") {
            $makeFilter = $this->getSearchLocation();
            //$query=$this->db->where(array('users.city' =>$makeFilter,'users.state' => $makeFilter));
            $query = $this->db->where(array('users.city' => $makeFilter));
        }

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            $query = $this->db->or_like(array('users.first_name' => $makeFilter, 'users.last_name' => $makeFilter, 'users.email' => $makeFilter, 'orders.order_id' => $makeFilter)); /* LIKE OR LIKE */
        }

        $count = $this->db->get()->num_rows();

        return $count;
    }

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Return Orders Details
     */

    public function driversdetails() {
        return $this->db->select('*')->from('driver')->get()->result_array();
    }

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Return Orders Locations 
     */

    public function ordersLocationsdetails() {
        $query = $this->db->select('orders.order_id AS oid, orders.user_id AS uid, orders.driver_id AS did, orders.pay_status, orders.order_type, orders.order_status, orders.amount, orders.created_at, orders.updated_at, driver.first_name AS driver_fname, driver.last_name AS driver_lname, driver.latitude AS driver_latitude, driver.longitude AS driver_longitude, users.first_name AS user_fname, users.last_name AS user_lname, users.email AS user_email, users.city, users.state, users.address')->from('orders')
                ->join('driver', 'driver.driver_id = orders.driver_id', 'left')
                ->join('users', 'users.id = orders.user_id', 'left');

        return $query->get()->result_array();
    }

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Details All Orders Records 
     */

    public function getAllOrders($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select('orders.order_id AS oid, orders.first_time AS first_time, orders.user_id AS uid,fetchPrescription(orders.user_id) as prescriptions, orders.driver_id AS did, orders.delivery_time, orders.delivery_date, orders.drop_location, orders.drop_location_lat, orders.drop_location_lang, orders.pay_status, orders.order_type, orders.order_status, orders.amount, orders.created_at, orders.updated_at, driver.first_name AS driver_fname, driver.last_name AS driver_lname, driver.email AS driver_email, driver.contact_number AS driver_contact, driver.starting_location AS warehouseid, driver.latitude AS driver_latitude, driver.longitude AS driver_longitude, warehouse.name AS driver_sloc, warehouse.address AS driver_saddr, warehouse.lat AS driver_slat, warehouse.lang AS driver_slang, driver_professional_detail.registration_number AS driver_vehicleno,driver_professional_detail.vehicle_model_type AS driver_vehiclemodel, users.first_name AS user_fname, users.last_name AS user_lname, users.email AS user_email, users.phone_number AS user_contact, users.city, users.state, users.address, users.is_approved as active, users.id')->from('orders')
                ->join('driver', 'driver.driver_id = orders.driver_id', 'left')
                ->join('users', 'users.id = orders.user_id', 'left')
                ->join('driver_professional_detail', 'driver_professional_detail.driver_id = orders.driver_id', 'left')
                ->join('warehouse', 'warehouse.id = driver.starting_location', 'left');
        //-- Search by date range 
        if ($this->get_sdate() != '' && $this->get_edate() != '') {
            $this->db->where('orders.created_at >=', $this->get_sdate());
            $this->db->where('orders.created_at <=', $this->get_edate());
        }

        //-- Search by order Status
        if ($this->getSearchStatus() != "") {
            $makeFilter = $this->getSearchStatus();
            $query = $this->db->where('orders.order_status', $makeFilter);
        }
        //-- Search by Customer Name
        if ($this->getsearchDriver() != "") {
            $makeFilter = $this->getsearchDriver();
            $query = $this->db->where('orders.driver_id', $makeFilter);
        }
        //-- Search by Order Location 
        if ($this->getSearchLocation() != "") {
            $makeFilter = $this->getSearchLocation();
            //$query=$this->db->where(array('users.city' =>$makeFilter,'users.state' => $makeFilter));
            $query = $this->db->where(array('users.city' => $makeFilter));
        }

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            $query = $this->db->or_like(array("CONCAT(users.first_name, ' ', users.last_name)" => $makeFilter, 'users.first_name' => '%'.$makeFilter.'%', 'users.last_name' => '%'.$makeFilter.'%', 'users.email' => '%'.$makeFilter.'%', 'orders.order_id' => '%'.$makeFilter.'%')); /* LIKE OR LIKE */
        }

        if ($all) {
            $this->db->order_by('orders.created_at', "asc");
            $query = $this->db->get();
        } else {
            $this->db->order_by('orders.created_at', "desc");
            $query = $this->db->limit($from, $perPage)->get();
        }

//        echo $this->db->last_query();exit;
        //echo "<pre>";print_r($query);die;
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Return Orders Locations 
     */

    public function fetchOrderdetails() {
        //echo "sssssssssss";exit;
        $query = $this->db->select('orders.order_id AS oid, orders.user_id AS uid,fetchPrescription(orders.user_id) as prescriptions, orders.driver_id AS did, orders.delivery_time, orders.delivery_date, orders.drop_location, orders.drop_location_lat, orders.drop_location_lang, '
                        . 'orders.pay_status, orders.order_type, orders.order_status, orders.amount, '
                        . 'date(orders.created_at) as created_at, time(orders.created_at) as order_time, orders.updated_at, driver.first_name AS driver_fname, '
                        . 'driver.last_name AS driver_lname, driver.email AS driver_email, '
                        . 'driver.contact_number AS driver_contact, driver.starting_location AS warehouseid, '
                        . 'driver.latitude AS driver_latitude, driver.longitude AS driver_longitude, warehouse.name AS driver_sloc,'
                        . ' warehouse.address AS driver_saddr, warehouse.lat AS driver_slat, warehouse.lang AS driver_slang,'
                        . ' driver_professional_detail.registration_number AS driver_vehicleno,'
                        . 'driver_professional_detail.vehicle_model_type AS driver_vehiclemodel,'
                        . ' users.first_name AS user_fname, users.last_name AS user_lname, '
                        . 'users.email AS user_email, users.phone_number AS user_contact, '
                        . 'users.city, users.country, users.state, users.address,'
                        . 'fn_returnOrderStatusName(orders.order_status) as orderStatusName', false)
                ->from('orders')->where('orders.order_id', $this->get_customid())
                ->join('driver', 'driver.driver_id = orders.driver_id', 'left')
                ->join('users', 'users.id = orders.user_id', 'left')
                ->join('warehouse', 'warehouse.id = driver.starting_location', 'left')
                ->join('driver_professional_detail', 'driver_professional_detail.driver_id = orders.driver_id', 'left');

        return $query->get()->row_array();
    }

    /*
     * Order Detail Page : Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Check User Verified / Non Verified
     */
    public function check_verfied_user() {
        $query = $this->db->select('*')
                ->from('orders')
                ->where(array('user_id' => '(SELECT user_id FROM orders WHERE order_id = ' . $this->get_customid() . ')', 'order_status' => '6'))
                ->get();
        return $query->num_rows();
    }

    /*
     * Order Detail Page : Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Check User First Time
     */

    public function check_first_time() {
        $query = $this->db->select('*')
                ->from('orders')
                ->where("`user_id` = (SELECT user_id FROM orders WHERE order_id = " . $this->get_customid() . ")", NULL, FALSE)
                ->where(array('order_status !=' => '6'))
                ->get();
        return $query->num_rows();
    }

    /*
     * Order Detail Page : Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Assign Order 
     */

    public function assignDriver($oredr_info) {
        $order_type = $this->get_orderType() == 'asap' ? '1' : '0';
        
        // Check first if there is already the same order assigned to a driver, if so then just update it
        $driverAssignedExist = $this->db->where(['order_id' => $this->get_orderid()])->get('driver_assigned_order')->row_array();

        // prepare the list of data
        $bt = new DateTime($oredr_info['created_at']);
        $cdate = $bt->format('Y-m-d');
        $in_data = array(
            'order_id' => $oredr_info['oid'],
            'user_id' => $oredr_info['uid'],
            'driver_id' => $oredr_info['did'],
            'delivery_time' => $this->get_stime(),
            'drop_location' => isset($oredr_info['drop_location']) && $oredr_info['drop_location'] != null ? $oredr_info['drop_location'] : "-",
            'drop_location_lat' => isset($oredr_info['drop_location_lat']) && $oredr_info['drop_location_lat'] != null ? $oredr_info['drop_location_lat'] : "-",
            'drop_location_lang' => isset($oredr_info['drop_location_lang']) && $oredr_info['drop_location_lang'] != null ? $oredr_info['drop_location_lang'] : "-",
            'pickup_location' => isset($oredr_info['driver_sloc']) && $oredr_info['driver_sloc'] != null ? $oredr_info['driver_sloc'] : "-",
            'pickup_location_lat' => isset($pickupLocationLatLng[0]) && $pickupLocationLatLng[0] != null ? $pickupLocationLatLng[0] : "-",
            'pickup_location_lang' => isset($pickupLocationLatLng[1]) && $pickupLocationLatLng[1] != null ? $pickupLocationLatLng[1] : "-",
            'order_date' => $cdate,
            'order_status' => $oredr_info['order_type'],
            'updated_at' => date('Y-m-d H:i:s'),
        );

        if ( $driverAssignedExist == null )
        {
            $dataWhr = array('order_id' => $this->get_orderid());
            $up_data = array('driver_id' => $this->get_driverid(), 'order_type' => $order_type, 'delivery_time' => $this->get_stime(), 'delivery_date' => $this->get_sdate(), 'order_status' => '1');
            $query = $this->db->where($dataWhr)
                    ->update('orders', $up_data);
            /*$userInfo = $this->db->select('*')->from('users')->where("`id` = (SELECT user_id FROM orders WHERE order_id = " . $this->get_orderid() . ")", NULL, FALSE)->get()->row_array();*/
            //echo "<pre>"; print_r($oredr_info);die;
            $pickupLocationLatLng = explode(',', $this->input->post('pickup_location_latlng'));
            $res = $this->db->insert('driver_assigned_order', $in_data);
        }
        else
        {
            $updateAssignDriverData = $this->db->where(['order_id' => $this->get_orderid()])->update('driver_assigned_order', $in_data);
        }

        $data = $this->db->affected_rows();
        return $data;
    }

    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Modal for Ajax function 
     */

    public function fetchAllDrivers() {
        $data = array();

        //-- Search record by Date 
        if ($this->get_customid() != "") {
            $this->db->where('a.id =', $this->get_customid());
        }
        $query = $this->db->get('driver');


        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }

    /*     * *****************************************
     *   Care Givers Section                       *
     * ***************************************** */

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Count All Care Givers Records 
     */

    public function careGiversCount() {
        $query = $this->db->select('*')->from('caregiver_details');

        //-- Search by date range 
        if ($this->get_sdate() != '' && $this->get_edate() != '') {
            $this->db->where('orders.created_at >=', $this->get_sdate());
            $this->db->where('orders.created_at <=', $this->get_edate());
        }

        return $this->db->get()->num_rows();
    }

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Return All CareGivers  Details
     */

    public function careGiversdetails() {
        return $this->db->select('*')->from('caregiver_details')->get()->result_array();
    }

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Details All Care Givers Records 
     */

    public function getAllCareGivers($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select('*')->from('caregiver_details');

        //-- Search by order Status
        if ($this->getSearchData() != "") {
            $makeFilter = $this->getSearchData();
            $query = $this->db->where('name', '%'.$makeFilter.'%');
        }

        if ($all) {
            $query = $this->db->get();
        } else {
            $query = $this->db->limit($from, $perPage)->get();
        }

        //echo $this->db->last_query();exit;
        //echo "<pre>";print_r($query);die;
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
        var_dump($data);die();
    }

    /*
     * Admin Orders Section
     * @author : niraj
     * @admin panel 
     * @function for : Return Orders Locations 
     */

    public function fetchCareGiverdetails() {
        $query = $this->db->select('*')->from('caregiver_details')->where('caregiver_details.order_id', $this->get_customid());
        return $query->get()->row_array();
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Add New Doctor 
     */

    public function addNewCareGiver() {
        $in_data = array(
            'name' => $this->get_name(),
            'telephone_number' => $this->get_phone(),
            'email' => $this->get_email(),
            'designee_name' => $this->get_designee(),
            'designee_signature_image' => $this->get_picUrl(),
            'identification_number' => $this->get_identityno(),
            'city' => $this->get_city(),
            'state' => $this->get_state(),
            'country' => $this->get_country(),
            'zip_code' => $this->get_zipcode(),
            'created_at' => date('Y-m-d H:i:s')
        );
        $res = $this->db->insert('caregiver_details', $in_data);
        $data = $this->db->affected_rows();

        return $data;
    }

    public function delete_care_giver() {
        $this->db->where('id', $this->get_userid())->delete('caregiver_details');
        $data = $this->db->affected_rows();
        return $data;
    }

    /*     * *****************************************
     *   Doctors Section                       *
     * ***************************************** */

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Count All Orders Records 
     */

    public function doctorsCount() {
        $data = array();
        $query = $this->db->select('users.id AS id, users.first_name AS doctor_fname, users.last_name AS doctor_lname, users.email AS doctor_email, users.city, doctorAppointmentCount(users.id) AS appointments, users.state, users.address, users.phone_number AS doctor_contact, users.availablity AS status, b.specialization AS doctor_qualification')->from('users')->where('users.user_type', '1')
                ->join('doctor_professional_information b', 'b.doctor_id = users.id', 'left');



        //-- Search by order Status
        if ($this->getSearchStatus() != "") {
            $makeFilter = $this->getSearchStatus();
            $query = $this->db->where('users.availablity', $makeFilter);
        }

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(users.first_name like '%$makeFilter%' OR users.last_name like '%$makeFilter%' OR users.email like '%$makeFilter%' OR users.phone_number like '%$makeFilter%' OR users.city like '%$makeFilter%' OR users.state like '%$makeFilter%' OR users.address like '%$makeFilter%')");
        }

        $count = $this->db->get()->num_rows();
        return $count;
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Details All Orders Records 
     */

    public function getAllDoctors($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select('users.id AS id, users.first_name AS doctor_fname, users.last_name AS doctor_lname, users.email AS doctor_email, users.city, doctorAppointmentCount(users.id) AS appointments, users.state, users.address, users.phone_number AS doctor_contact, users.availablity AS status, b.specialization AS doctor_qualification')->from('users')->where('users.user_type', '1')
                ->join('doctor_professional_information b', 'b.doctor_id = users.id', 'left');

        //-- Search by order Status
        if ($this->getSearchStatus() != "") {
            $makeFilter = $this->getSearchStatus();
            $query = $this->db->where('users.availablity', $makeFilter);
        }

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(users.first_name like '%$makeFilter%' OR users.last_name like '%$makeFilter%' OR users.email like '%$makeFilter%' OR users.phone_number like '%$makeFilter%' OR users.city like '%$makeFilter%' OR users.state like '%$makeFilter%' OR users.address like '%$makeFilter%')");
        }

        $query = $this->db->limit($from, $perPage)->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Add New Doctor 
     */

    public function addNewDoctor() {
        $s = substr(str_shuffle(str_repeat("123456789abcdefghijklmnopqrstuvwxyzABCZKMSLPY", 5)), 0, 5);
        $confidentials['email'] = $this->get_email();
        $confidentials['password'] = $s . rand(1111, 9999);

        $in_data = array(
            'user_type' => '1',
            'password' => md5($confidentials['password']),
            'first_name' => $this->get_firstname(),
            'last_name' => $this->get_lastname(),
            'profile_pic' => $this->get_picUrl(),
            'email' => $this->get_email(),
            'phone_number' => $this->get_phone(),
            'is_notification' => 1,
            'created_at' => date('Y-m-d H:i:s')
        );
        $res = $this->db->insert('users', $in_data);
        $data = $this->db->affected_rows();
        if ($data) {
            $insert_id = $this->db->insert_id();
            $in_data_docs = array(
                'doctor_id' => (int) $insert_id,
                'specialization' => '',
                'experience ' => '',
                'license_number' => '',
                'signature_or_document' => '',
                'doc1_name' => $this->get_doc1Name(),
                'doc1_url' => $this->get_doc1Url(),
                'doc2_name' => $this->get_doc2Name(),
                'doc2_url' => $this->get_doc2Url(),
                'doc3_name' => $this->get_doc3Name(),
                'doc3_url' => $this->get_doc3Url(),
            );
            $res = $this->db->insert('doctor_professional_information', $in_data_docs);

            //-- Mail to doctor 
            $name = "there";
            $email = $this->get_email();
            $subject = 'Account credentials | InstaCraft';
            $emailMessage = '<div style="max-width:640px; margin:auto; padding:0 20px;border:1px solid #d4d2d2;">
                                <p style="text-align:center;margin:30px 0 30px 0;">
                                        <p style="color:#c51225;font-weight:bold;   font-size:25px; text-align:center; margin:0px;">ACCOUNT CREDENTIAL - INSTACRAFT<span style="color:#256d95; font-size:25px;"></span></p>
                                </p>  
                                <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;">Hi <strong>' . $name . '</strong>,</p>
                                <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;"></p>     
                                <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;">Your account is created successfully, Please check your credentials below</p>     
                                <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;"><table style="padding : 5px; border-left:3px solid grey "><tr><th>Username : </th> <td>' . $email . '</td></tr><tr><th> Password : </th> <td>' . $confidentials['password'] . '</td></tr></table></p>
                                <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;"><i>Please do not share this credentials to others</i>.</p>  
                                <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;">Warm Regards,<br />Instacraft Support</p>
                            </div>';

            sendEmailGlobal(SUPPORT_EMAIL, "niraj@techaheadcorp.com", $name, $subject, $emailMessage, $attachment);
        }

        return $data;
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Add New Doctor 
     */

    public function updateDoctor() {
        $updatedata = array(
            'first_name' => $this->get_firstname(),
            'last_name' => $this->get_lastname(),
            'profile_pic' => $this->get_picUrl(),
            'phone_number' => $this->get_phone(),
        );
        $this->db->where(array('id' => $this->get_customid()))->update('users', $updatedata);
        $data = $this->db->affected_rows();
        if ($data) {
            $where_id = $this->get_customid();
            $up_data_docs = array(
                'doc1_name' => $this->get_doc1Name(),
                'doc1_url' => $this->get_doc1Url(),
                'doc2_name' => $this->get_doc2Name(),
                'doc2_url' => $this->get_doc2Url(),
                'doc3_name' => $this->get_doc3Name(),
                'doc3_url' => $this->get_doc3Url(),
            );
            $this->db->where(array('doctor_id' => (int) $insert_id))->update('doctor_professional_information', $up_data_docs);
        }

        return $data;
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : View New Doctor 
     */

    public function fetch_doctor_details($userId) {
        $data = array();
        $query = $this->db->select('users.id AS id, users.first_name AS doctor_fname, users.last_name AS doctor_lname, users.profile_pic AS doctor_pic, users.email AS doctor_email, users.city,users.phone_number AS doctor_phone, doctorAppointmentCount(users.id) AS appointments, users.state, users.address, users.phone_number AS doctor_contact, users.availablity AS status, b.specialization AS doctor_qualification, b.doc1_name, b.doc2_name, b.doc3_name, b.doc1_url, b.doc2_url, b.doc3_url ')->from('users')->where('users.id', $this->get_userid())->where('users.user_type', '1')
                ->join('doctor_professional_information b', 'b.doctor_id = users.id', 'left')
                ->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Appointment Counts 
     */

    public function appointmentsRecordCount() {
        $data = array();
        $query = $this->db->select('a.id as recordid, a.user_id,a.doctor_id,a.appointment_date,a.appointment_time,a.rescheduled_date,a.rescheduled_time,a.status,a.reschedule_resason,a.cancel_reason,a.consultation_for,a.created_at,a.updated_at,b.user_type,b.refferal_code,b.reffered_by,b.password,b.first_name,b.last_name,b.profile_pic,b.gender,b.country_code,b.email,b.phone_number AS phone ,b.is_approved, b.latitude,b.longitude,b.lang, b.is_deleted, b.is_blocked, b.is_termcondition_accepted, b.is_medical_prescription, b.state, b.city, b.address, b.street1, b.street2, b.preferred_zip_code, b.availablity')->from('appointment_details a')
                ->join('users b', 'b.id = a.user_id', 'left')
                ->where('a.doctor_id', $this->get_userid());

        //-- Search record by Date 
        if ($this->get_sdate() != "") {
            $this->db->where('DATE(a.created_at) =', $this->get_sdate());
        }

        $query = $this->db->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $count = $query->num_rows();
                return $count;
            } else {
                return 0;
            }
        }
        return 0;
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Appointments Records 
     */

    public function fetch_doctor_appointments($from = '', $perPage = '', $all = '') {
        $date = $this->get_sdate() ? $this->get_sdate() : date('Y-m-d');
        $data = array();
        $query = $this->db->select('a.id as recordid, a.user_id,a.doctor_id,a.appointment_date,a.appointment_time,a.rescheduled_date,a.rescheduled_time,a.status,a.reschedule_resason,a.cancel_reason,a.consultation_for,a.created_at,a.updated_at,b.user_type,b.refferal_code,b.reffered_by,b.password,b.first_name,b.last_name,b.profile_pic,b.gender,b.country_code,b.email,b.phone_number AS phone ,b.is_approved, b.latitude,b.longitude,b.lang, b.is_deleted, b.is_blocked, b.is_termcondition_accepted, b.is_medical_prescription, b.state, b.city, b.address, b.street1, b.street2, b.preferred_zip_code, b.availablity')->from('appointment_details a')
                ->join('users b', 'b.id = a.user_id', 'left')
                ->where('a.doctor_id', $this->get_userid());
        //-- Search record by Date 
        if ($this->get_sdate() != "") {
            $this->db->where('DATE(a.created_at) =', $this->get_sdate());
        }
        $query = $this->db->limit($from, $perPage)->get();
        // echo $this->db->last_query();die;
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Appointment detail Date wise 
     */

    public function fetch_doctor_revenues() {
        $data['totalcount'] = $data['canceled'] = $data['rescheduled'] = $data['confirmed'] = $data['pending'] = $data['prescription_issues'] = 0;
        $data = array();
        $today = date('Y-m-d');
        $setDate = $this->get_sdate();

        //--query
        $query = $this->db->select('a.id as recordid, a.user_id,a.doctor_id,a.appointment_date,a.appointment_time,a.rescheduled_date,a.rescheduled_time,a.status,a.reschedule_resason,a.cancel_reason,a.consultation_for,a.created_at,a.updated_at,b.user_type,b.refferal_code,b.reffered_by,b.password,b.first_name,b.last_name,b.profile_pic,b.gender,b.country_code,b.email,b.phone_number AS phone ,b.is_approved, b.latitude,b.longitude,b.lang, b.is_deleted, b.is_blocked, b.is_termcondition_accepted, b.is_medical_prescription, b.state, b.city, b.address, b.street1, b.street2, b.preferred_zip_code, b.availablity')->from('appointment_details a')
                ->join('users b', 'b.id = a.user_id', 'left')
                ->where('a.doctor_id', $this->get_userid());
        if ($setDate != '') {
            //-- Fetch All Revenues till today
            $this->db->where('DATE(a.created_at) =', $this->get_sdate());
        }

        $query = $this->db->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $records = $query->result_array();
                $data['totalcounts'] = count($records);
                foreach ($records AS $record) {
                    (isset($record['is_medical_prescription']) && $record['is_medical_prescription'] != '0') ? $data['prescription_issues'] ++ : 0;


                    $a = $record['status'];
                    $a != '0' ? ($a != '1' ? ($a != '2' ? $data['canceled'] ++ : $data['rescheduled'] ++) : $data['confirmed'] ++) : $data['pending'] ++;
                }
                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Modal for Ajax function 
     */

    public function fetchAppointmentUserinfo() {
        $data = array();
        $query = $this->db->select('a.id as recordid, a.user_id,a.doctor_id,a.appointment_date,a.appointment_time,a.rescheduled_date,a.rescheduled_time,a.status,a.reschedule_resason,a.cancel_reason,a.consultation_for,a.created_at,a.updated_at,b.user_type,b.refferal_code,b.reffered_by,b.password,b.first_name,b.last_name,b.profile_pic,b.gender,b.country_code,b.email,b.phone_number AS phone ,b.dob ,b.is_approved, b.latitude,b.longitude,b.lang, b.is_deleted, b.is_blocked, b.is_termcondition_accepted, b.is_medical_prescription, b.state, b.city, b.address, b.street1, b.street2, b.preferred_zip_code, b.availablity')->from('appointment_details a')
                ->join('users b', 'b.id = a.user_id', 'left');
        //-- Search record by Date 
        if ($this->get_customid() != "") {
            $this->db->where('a.id =', $this->get_customid());
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    /*     * *****************************************
     *   All Products Section                       *
     * ***************************************** */

    /*
     * Admin Products Section
     * @author : niraj
     * @admin panel 
     * @function for : Count All Products Records 
     */

    public function productsCount() {
        $data = array();
        $query = $this->db->select('`a`.`item_id` AS `itemid`, categoryNamesByItemId(a.item_id) as categoryname, `a`.`item_name` AS `itemname`, `a`.`item_unit` AS `itemunit`, `a`.`item_image` AS `itemsrc`, `a`.`price_eigth`, `a`.`price_one`, `a`.`weight`, `a`.`item_familly`, `a`.`recommended_uses`, `a`.`flavor`, `a`.`smell`, `a`.`effect`, `a`.`color_code`, `a`.`review` AS `itemdsc`, `a`.`thc`, `a`.`cbg`, `a`.`cbc`, `a`.`cbn`, `a`.`cbd`, `a`.`thcv`, `a`.`is_biweekly`, `a`.`is_hot_item`, `a`.`is_luxurious_item`, `a`.`created_at`, `a`.`updated_at`')->from('items a')
                ->join('item_familly b', 'b.id = a.item_familly', 'left')
                ->join('order_items c', 'c.item_id = a.item_id', 'left');

        //-- Search by order Status
        if ($this->getCategory() != "") {
            $makeFilter = $this->getSearchStatus();
            $query = $this->db->where('orders.order_status', $makeFilter);
        }
        //-- Search by Customer Name
//        if ($this->getSubCategory() != "") {
        if ($this->get_subCategory() != "") {
            $makeFilter = $this->getsearchDriver();
            $query = $this->db->where('orders.driver_id', $makeFilter);
        }
        //-- Search by Order Location 
        if ($this->getUnit() != "") {
            $makeFilter = $this->getUnit();
            //$query=$this->db->where(array('users.city' =>$makeFilter,'users.state' => $makeFilter));
            $query = $this->db->where(array('users.city' => $makeFilter));
        }

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(users.first_name like '%$makeFilter%' OR users.last_name like '%$makeFilter%' OR users.email like '%$makeFilter%' OR users.phone_number like '%$makeFilter%' OR users.city like '%$makeFilter%' OR users.state like '%$makeFilter%' OR users.address like '%$makeFilter%')");
        }

        $query = $this->db->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $count = $query->num_rows();
                return $count;
            } else {
                return 0;
            }
        }
        return 0;
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch All Products Records 
     */

    public function getAllProducts($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select('`a`.`item_id` AS `itemid`, categoryNamesByItemId(a.item_id) as categoryname, `a`.`item_name` AS `itemname`, `a`.`item_unit` AS `itemunit`, `a`.`item_image` AS `itemsrc`, `a`.`price_eigth`,`a`.`price_eight_off`, `a`.`price_one`,`a`.`price_one_off`, `a`.`price_gram`,`a`.`price_gram_off`, `a`.`weight`, `a`.`item_familly`, `a`.`recommended_uses`, `a`.`flavor`, `a`.`smell`, `a`.`effect`, `a`.`color_code`, `a`.`review` AS `itemdsc`, `a`.`thc`, `a`.`cbg`, `a`.`cbc`, `a`.`cbn`, `a`.`cbd`, `a`.`thcv`, `a`.`is_biweekly`, `a`.`is_hot_item`, `a`.`is_luxurious_item`, `a`.`created_at`, `a`.`updated_at`')->from('items a')
                ->join('item_familly b', 'b.id = a.item_familly', 'left')
                ->join('order_items c', 'c.item_id = a.item_id', 'left');

        //-- Search by order Status
        if ($this->getCategory() != "") {
            $makeFilter = $this->getSearchStatus();
            $query = $this->db->where('orders.order_status', $makeFilter);
        }
        //-- Search by Customer Name
        if ($this->get_subCategory() != "") {
            $makeFilter = $this->getsearchDriver();
            $query = $this->db->where('orders.driver_id', $makeFilter);
        }
        //-- Search by Order Location 
        if ($this->getUnit() != "") {
            $makeFilter = $this->getUnit();
            //$query=$this->db->where(array('users.city' =>$makeFilter,'users.state' => $makeFilter));
            $query = $this->db->where(array('users.city' => $makeFilter));
        }

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(users.first_name like '%$makeFilter%' OR users.last_name like '%$makeFilter%' OR users.email like '%$makeFilter%' OR users.phone_number like '%$makeFilter%' OR users.city like '%$makeFilter%' OR users.state like '%$makeFilter%' OR users.address like '%$makeFilter%')");
        }

        $query = $this->db->limit($from, $perPage)->get();
//        echo $this->db->last_query();exit;
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch All Warehouses Records & Deatails
     */

    public function fetch_warehouses_detail() {
        $data = array();
        $query = $this->db->select('d.id AS warehouse_id, d.name AS warehouse_name, d.address AS warehouse_address, d.lat AS warehouse_lat, d.lang AS warehouse_lang, d.status AS warehouse_status, d.created_at AS warehouse_created_at')->from('warehouse d')->get();
        //echo $this->db->last_query();die;
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    public function getCaregivers() {
        $caregiver_lists = $this->db->select('id,name')
                ->from('caregiver_details')
                ->get();
        if ($caregiver_lists->num_rows() > 0) {
            $data = $caregiver_lists->result();
            return $data;
        }
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @add product / view product
     * @function for : Fetch All Sub-category / category-wise records
     */

    public function fetch_items_categories() {
        $data = array();
        $query = $this->db->select("category_id AS catid ,name AS catname ,status AS catstatus, created_at AS category_created_date")->from('category')->where(array('parent_id' => '0'))->where(array('status' => '1'))->get();
//        echo $this->db->last_query();die;
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                $start = 0;
                foreach ($data AS $record) {
                    $data[$start]['subcategories'] = array();
                    $subquery = $this->db->select("category_id AS subcatid, name AS subcatname, parent_id AS parent , status AS subcatstatus")->from('category')->where(array('parent_id' => $record['catid']))->where(array('status' => '1'))->get();
//                    echo $this->db->last_query();die;
                    if ($subquery) {
                        if ($subquery->num_rows() > 0) {
                            $data[$start]['subcategories'] = $subquery->result_array();
                        }
                    }
                    $start++;
                }

                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Admin Product Section
     * @author : Ankit
     * @add product / view product
     * @function for : Fetch All Sub-category / category-wise records
     */

    function fetch_moods() {
        $query = $this->db->select("*")
                ->from('purpose')
                ->where(array('purpose_type' => '1'))
                ->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function fetch_medicals() {
        $query = $this->db->select("*")
                ->from('purpose')
                ->where(array('purpose_type' => '2'))
                ->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @add product / view product
     * @function for : Fetch All Sub-category / category-wise records
     */

    public function fetch_items_families() {
        $data = array();
        $query = $this->db->select("id AS familyid, name familyname, created_at , updated_at")->from('item_familly')->where(array('status' => '1'))->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @add product / view product
     * @function for : Fetch All Sub-category / category-wise records
     */

    public function addNewProduct() {

        $selected_moods = $this->get_moods();
        is_null($selected_moods) && $selected_moods = [];
        $selected_sizes_comma_seprated_moods = implode(',', $selected_moods);

        $selected_medicals = $this->get_medicals();
        is_null($selected_medicals) && $selected_medicals = [];
        $selected_sizes_comma_seprated_medicals = implode(',', $selected_medicals);

        $in_data = array(
            'category_id' => $this->get_categories(),
            'sub_category_ids' => $this->get_subCategory(),
            'item_name' => $this->get_itemname(),
            'item_unit' => $this->get_itemunit(),
            'item_image' => $this->get_picUrl(),
            'price_eigth' => $this->get_ounce8price(),
            'price_eight_off' => $this->get_ounce8offprice(),
            'price_one' => $this->get_anounceprice(),
            'price_one_off' => $this->get_anounceoffprice(),
            'price_gram' => $this->get_onegramprice(),
            'price_gram_off' => $this->get_onegramoffprice(),
            'item_familly' => $this->get_itemfamily(),
            'recommended_uses' => $this->get_itemrecommends(),
            'flavor' => $this->get_itemflavour(),
            'effect' => $this->get_itemeffects(),
            'color_code' => "#" . $this->get_itemcolor(),
            'review' => $this->get_itemreview(),
            'thc' => '0',
            'cbg' => '0',
            'cbc' => '0',
            'cbn' => '0',
            'cbd' => '0',
            'thcv' => '0',
            'is_biweekly' => $this->get_itembiweekly(),
            'is_hot_item' => $this->get_itemhot(),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'is_luxurious_item' => $this->get_itemluxurious(),
            'limited' => $this->get_limited(),
            'caregiver_id' => $this->get_cargiver(),
            'moods' => $selected_sizes_comma_seprated_moods,
            'medicals' => $selected_sizes_comma_seprated_medicals
        );

        $res = $this->db->insert('items', $in_data);
        $data = $this->db->affected_rows();

        if ($data) {
            $insert_id = $this->db->insert_id();

            // Quantity for ware House 
            $ware_items_records = $this->get_itemswhQnty();
            $ware_quantity_type = $this->get_quantity_type();
            //update $ware_quantity_type record with the below loop in same table using item id 
            if (count($ware_items_records) > 0) {
                foreach ($ware_items_records AS $key => $val) {
                    $ware_data[] = array(
                        'warehouse_id' => $key,
                        'item_id' => $insert_id,
                        'inventry_left' => $val,
                        'quantity_type' => $ware_quantity_type[$key],
                        'created_at' => date('Y-m-d H:i:s'),
                    );
                }
                $this->db->insert_batch('manage_warehouse_items', $ware_data);
            }

            // Item Category & Sub-category
            $categories_records = $this->get_categories();

            $cat_records = [];

            if ( is_array($categories_records) )
            {
                 foreach ($categories_records AS $key => $val) {
                    $cat_records[] = array(
                        'item_id' => $insert_id,
                        'category_id' => $val,
                        'created_at' => date('Y-m-d H:i:s'),
                    );
                }
            }
            elseif(is_numeric($categories_records))
            {
                $cat_records[] = array(
                    'item_id' => $insert_id,
                    'category_id' => $categories_records,
                    'created_at' => date('Y-m-d H:i:s'),
                );
            }

            !empty($cat_records) && $this->db->insert_batch('item_category_mapping', $cat_records);
        }

        return $data;
    }

    public function deleteProduct($item_id)
    {
        $result = false;

        // as long as there are no constraints we have to delete all records that has the item id as foreign key.
        try
        {
            $this->db->where(array('item_id' => $item_id))->delete('item_category_mapping');
            $this->db->where(array('item_id' => $item_id))->delete('manage_warehouse_items');
            $this->db->where(array('item_id' => $item_id))->delete('order_items');
            $this->db->where(array('item_id' => $item_id))->delete('cart');
            $this->db->where(array('item_id' => $item_id))->delete('items');
            
            $result = $this->db->affected_rows();
        }
        catch (\Exception $e)
        {
            $result = false;
        }

        return $result;
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch Any Product Details
     */

    public function fetch_product_details($itemId) {
        if ($itemId != '') {
            $data = array();
            $query = $this->db->select('`a`.`item_id` AS `itemid`, categoryNamesByItemId(a.item_id) as categoryname, `a`.`item_name` AS `itemname`, `a`.`item_unit` AS `itemunit`, `a`.`item_image` AS `itemsrc`, `a`.`price_eigth`, `a`.`price_one`, `a`.`weight`, `a`.`item_familly`, `a`.`recommended_uses`, `a`.`flavor`, `a`.`smell`, `a`.`effect`, `a`.`color_code`, `a`.`review` AS `itemdsc`, `a`.`thc`, `a`.`cbg`, `a`.`cbc`, `a`.`cbn`, `a`.`cbd`, `a`.`thcv`, `a`.`is_biweekly`, `a`.`is_hot_item`, `a`.`is_luxurious_item`, `a`.`created_at`, `a`.`updated_at`')->from('items a')->where('a.item_id', $itemId)
                    ->join('item_familly b', 'b.id = a.item_familly', 'left')
                    ->join('order_items c', 'c.item_id = a.item_id', 'left')
                    ->get();

            if ($query->num_rows() > 0) {
                $data = $query->row_array();
            }

            return $data;
        } else {
            $data = array();
            $query = $this->db->select('`a`.`item_id` AS `itemid`, categoryNamesByItemId(a.item_id) as categoryname, `a`.`item_name` AS `itemname`, `a`.`item_unit` AS `itemunit`, `a`.`item_image` AS `itemsrc`, `a`.`price_eigth`, `a`.`price_one`, `a`.`weight`, `a`.`item_familly`, `a`.`recommended_uses`, `a`.`flavor`, `a`.`smell`, `a`.`effect`, `a`.`color_code`, `a`.`review` AS `itemdsc`, `a`.`thc`, `a`.`cbg`, `a`.`cbc`, `a`.`cbn`, `a`.`cbd`, `a`.`thcv`, `a`.`is_biweekly`, `a`.`is_hot_item`, `a`.`is_luxurious_item`, `a`.`created_at`, `a`.`updated_at`')->from('items a')->where('a.item_id', $this->get_itemid())
                    ->join('item_familly b', 'b.id = a.item_familly', 'left')
                    ->join('order_items c', 'c.item_id = a.item_id', 'left')
                    ->get();
            if ($query->num_rows() > 0) {
                $data = $query->row_array();
            }

            return $data;
        }
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @admin panel 
     * @function for : Particula Product Quantity in each Ware house
     */

    public function product_quantity_wareHouseWise($itemId) {
        if ($itemId != '') {
            $data = array();
            $query = $this->db->select('d.id AS warehouse_id, d.name AS warehouse_name, d.address AS warehouse_address, d.lat AS warehouse_lat, d.lang AS warehouse_lang, d.status AS warehouse_status, d.created_at AS warehouse_created_at , b.inventry_left  AS quantity, b.created_at AS wharehouse_created_at, b.updated_at AS warehouse_updated_at ')->from('warehouse d')
                    ->join('manage_warehouse_items b', '`b`.`warehouse_id` =  `d`.`id` AND  `b`.`item_id` = ' . $itemId, 'left')
                    ->get();
            if ($query) {
                if ($query->num_rows() > 0) {
                    $data = $query->result_array();
                    return $data;
                } else {
                    return $data;
                }
            }
        } else {
            $data = array();
            $query = $this->db->select('d.id AS warehouse_id, d.name AS warehouse_name, d.address AS warehouse_address, d.lat AS warehouse_lat, d.lang AS warehouse_lang, d.status AS warehouse_status, d.created_at AS warehouse_created_at , b.inventry_left  AS quantity, b.updated_at AS warehouse_updated_at ')->from('warehouse d')
                    ->join('manage_warehouse_items b', '`b`.`warehouse_id` =  `d`.`id` AND  `b`.`item_id` = ' . $this->get_itemid(), 'left')
                    ->get();
            if ($query) {
                if ($query->num_rows() > 0) {
                    $data = $query->result_array();
                    return $data;
                } else {
                    return $data;
                }
            }
        }
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @admin panel 
     * @function for : Particula Product Quantity in each Ware house
     */

    public function fetch_product_categories($itemId = '') {
        if ($itemId != '') {
            $data = array();
            $query = $this->db->get_where('item_category_mapping', array('item_id' => $itemId));
            if ($query) {
                if ($query->num_rows() > 0) {
                    $data = $query->result_array();
                    return $data;
                } else {
                    return $data;
                }
            }
        } else {
            $data = array();
            $query = $this->db->get_where('item_category_mapping', array('item_id' => $this->get_itemid()));
            if ($query) {
                if ($query->num_rows() > 0) {
                    $data = $query->result_array();
                    return $data;
                } else {
                    return $data;
                }
            }
        }
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @add product / view product
     * @function for : Fetch All Sub-category / category-wise records
     */

    public function updateProduct() {

        $update_data = array(
            'category_id' => '',
            'sub_category_ids' => '',
            'item_name' => $this->get_itemname(),
            'item_unit' => $this->get_itemunit(),
            'item_image' => $this->get_picUrl(),
            'price_eigth' => $this->get_anounceprice(),
            'price_one' => $this->get_anounceprice(),
            'item_familly' => $this->get_itemfamily(),
            'recommended_uses' => $this->get_itemrecommends(),
            'flavor' => $this->get_itemflavour(),
            'effect' => $this->get_itemeffects(),
            'color_code' => "#" . $this->get_itemcolor(),
            'review' => $this->get_itemreview(),
            'thc' => $this->get_itemthc(),
            'cbg' => $this->get_itemcbg(),
            'cbc' => $this->get_itemcbc(),
            'cbn' => $this->get_itemcbn(),
            'cbd' => $this->get_itemcbd(),
            'thcv' => $this->get_itemthcv(),
            'is_biweekly' => $this->get_itembiweekly(),
            'is_hot_item' => $this->get_itemhot(),
            'status' => 1,
            'is_luxurious_item' => $this->get_itemluxurious()
        );

        $res = $this->db->where(array('item_id' => $this->get_itemid()))->update('items', $update_data);
        //echo  $this->db->last_query(); die;
        $data = $this->db->affected_rows();

        //echo $this->get_itemid();die;
        $item_id = $this->get_itemid();
        //-- Delete All records for this item
        $this->db->where(array('item_id' => $item_id))->delete('manage_warehouse_items');

        // Quantity for ware House 
        $ware_items_records = $this->get_itemswhQnty();
        if (count($ware_items_records) > 0) {
            foreach ($ware_items_records AS $key => $val) {
                $ware_data[] = array(
                    'warehouse_id' => $key,
                    'item_id' => $item_id,
                    'inventry_left' => $val,
                    'created_at' => date('Y-m-d H:i:s'),
                );
            }
            $this->db->insert_batch('manage_warehouse_items', $ware_data);
        }

        //-- Delete All records from item_category_mapping for this item
        $this->db->where('item_id', $item_id)->delete('item_category_mapping');
        // Item Category & Sub-category
        $categories_records = $this->get_categories();
        if (count($categories_records) > 0) {
            foreach ($categories_records AS $key => $val) {
                $cat_records[] = array(
                    'item_id' => $item_id,
                    'category_id' => $val,
                    'created_at' => date('Y-m-d H:i:s'),
                );
            }
            $this->db->insert_batch('item_category_mapping', $cat_records);
        }


        return $data;
    }

    /*     * *****************************************
     *   All Category Section                       *
     * ***************************************** */
    /*
     * Admin Category Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch All Products Count By its Cat id
     */

    public function fetchItemCount($catID) {
        //$query  = $this->db->query("SELECT item_id FROM  `item_category_mapping` WHERE  `item_category_mapping`.`category_id` = $catID");
        $return_array = array();
        $query1 = $this->db->select('item_id')->from('item_category_mapping')->where(array('category_id' => $catID))->get();
        if ($query1) {
            $return_array['items_count'] = 0;
            $return_array['items_array'] = array();
            if ($query1->num_rows() > 0) {
                foreach ($query1->result() as $row) {
                    $return_array['items_count'] ++;
                    array_push($return_array['items_array'], $row->item_id);
                }
                return $return_array;
            } else {
                return $return_array;
            }
        } else {
            return $return_array;
        }
    }

    /*
     * Admin Category Section
     * @author : niraj
     * @admin panel 
     * @function for : Count All Category Records 
     */

    public function categoriesCount() {
        $data = array();
        $query = $this->db->select("category_id AS catid ,name AS catname ,status AS catstatus, created_at AS category_created_date")->from('category')->where(array('parent_id' => '0'))->where(array('status' => '1'));

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(name like '%$makeFilter%')");
        }

        $query = $this->db->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $count = $query->num_rows();
                return $count;
            } else {
                return 0;
            }
        }
        return 0;
    }

    /*
     * Admin Category Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch All Category Records 
     */

    public function getAllcategories($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select("category_id AS catid ,name AS catname ,status AS catstatus, created_at AS category_created_date")->from('category')->where(array('parent_id' => '0'))->where(array('status' => '1'));

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(name like '%$makeFilter%')");
        }

        $query = $this->db->limit($from, $perPage)->get();
        //echo $this->db->last_query();die;
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                $start = 0;
                foreach ($data AS $record) {
                    $itemcount = 0;
                    $data[$start]['items'] = $this->fetchItemCount($record['catid']);
                    $itemcount += $data[$start]['items']['items_count'];

                    $data[$start]['subcategories'] = array();
                    $subquery = $this->db->select("category_id AS subcatid, name AS subcatname, status AS subcatstatus")->from('category')->where(array('parent_id' => $record['catid']))->where(array('status' => '1'))->get();
                    if ($subquery) {
                        if ($subquery->num_rows() > 0) {
                            $subCatRows = $subquery->result_array();
                            $data[$start]['subcategories'] = $subCatRows;

                            $substart = 0;
                            foreach ($data[$start]['subcategories'] AS $subCatRow) {
                                $data[$start]['subcategories'][$substart]['items'] = $this->fetchItemCount($subCatRow['subcatid']);
                                $itemcount += $data[$start]['subcategories'][$substart]['items']['items_count'];

                                $substart++;
                            }
                        }
                    }
                    $data[$start]['all_items_count'] = $itemcount;
                    $start++;
                }

                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Admin Category Section
     * @author : niraj
     * @add product / view product
     * @function for : Fetch All Sub-category / category-wise records
     */

    public function addNewCategory() {
        $in_data = array(
            'category_id' => '',
            'name' => $this->get_categoryName(),
            'parent_id' => '0',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        );

        $res = $this->db->insert('category', $in_data);
        $data = $this->db->affected_rows();
        if ($data) {
            return $data;
        }

        return $data;
    }

    function check_category_name($rcv_catname) {
        $query = $this->db->select("category_id AS catid ,name AS catname ,status AS catstatus, created_at AS category_created_date")
                ->from('category')
                ->where(array('parent_id' => '0'))
                ->where(array('status' => '1'))
                ->where(array('name' => $rcv_catname))
                ->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                return TRUE;
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /*     * *****************************************
     *   Message Section                       *
     * ***************************************** */

    /*
     * Admin Message Section
     * @author : niraj
     * @admin panel 
     * @function for : Count All Messages Records 
     */

    public function messagesCount() {
        $data = array();
        $query = $this->db->select('a.id AS mid, a.message, a.link, a.imgsrc, a.is_sent AS sent_status, a.created_at AS mdate')->from('messages a');

        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(message like '%$makeFilter%')");
        }

        $query = $this->db->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $count = $query->num_rows();
                return $count;
            } else {
                return 0;
            }
        }
        return 0;
    }

    /*
     * Admin Product Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch All Products Records 
     */

    public function getAllMessages($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select('a.id AS mid, a.message, a.link, a.imgsrc, a.is_sent AS sent_status, a.created_at AS mdate')->from('messages a');

        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(message like '%$makeFilter%')");
        }

        $query = $this->db->limit($from, $perPage)->get();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Admin Category Section
     * @author : niraj
     * @add product / view product
     * @function for : Add New Message 
     */

    public function addNewMessage() {
        $in_data = array(
            'id' => '',
            'message' => $this->get_message(),
            'link' => $this->get_link(),
            'imgsrc' => $this->get_picUrl(),
            'is_sent' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        );

        $res = $this->db->insert('messages', $in_data);
        $data = $this->db->affected_rows();
        if ($data) {
            return TRUE;
        }

        return $data;
    }

    /*     * *****************************************
     *   Coupons Section                       *
     * ***************************************** */
    /*
     * Admin Coupons Section
     * @author : niraj
     * @admin panel 
     * @function for : Count All Coupons Records 
     */

    public function couponsCount() {
        $data = array();
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(message like '%$makeFilter%')");
        }

        $query = $this->db->get('coupons');
        if ($query) {
            if ($query->num_rows() > 0) {
                $count = $query->num_rows();
                return $count;
            } else {
                return 0;
            }
        }
        return 0;
    }

    /*
     * Admin Coupon Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch All Coupons Records 
     */

    public function getAllcoupons($from = '', $perPage = '', $all = '') {
        $data = array();
        //$query = $this->db->select('a.id AS mid, a.message, a.link, a.imgsrc, a.is_sent AS sent_status, a.created_at AS mdate')->from('messages a');
        //-- Search Text by Customer Name, Order Id , Email        
        if ($this->getSearchData() != "") {
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where("(message like '%$makeFilter%')");
        }

        $query = $this->db->limit($from, $perPage)->get('coupons');
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return $data;
            } else {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Admin Coupon Section
     * @author : niraj
     * @add product / view product
     * @function for : Add New Coupon 
     */

    public function addNewCoupon() {
        $monthsVal = $this->get_couponValidity();
        $valid_to = date("Y-m-d", strtotime(" +" . $monthsVal . " months"));

        $in_data = array(
            'category_id' => $this->get_couponCategoryid(),
            'name' => $this->get_couponName(),
            'code' => $this->get_couponCode(),
            'min_order_price' => $this->get_couponMinOrderPrice(),
            'points' => $this->get_couponPoints(),
            'discount' => $this->get_couponDiscount(),
            'discount_type' => $this->get_couponDistype(),
            'validity' => $this->get_couponValidity(),
            'status' => '1',
            'valid_from' => date('Y-m-d'),
            'valid_to' => $valid_to,
            'created_at' => date('Y-m-d H:i:s')
        );

        $res = $this->db->insert('coupons', $in_data);
        $data = $this->db->affected_rows();
        if ($data) {
            return TRUE;
        }

        return $data;
    }

    /*
     * Admin Doctors Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch Any Product Details
     */

    public function fetch_coupon_details($catid) {
        $data = array();
        $query = $this->db->select('*')->from('coupons')->where('id', $catid)
                ->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    /*
     * Admin Coupon Section
     * @author : niraj
     * @add product / view product
     * @function for : Update Coupon 
     */

    public function updateExistCoupon() {
        $couponData = $this->db->get_where('coupons', array('id' => $this->get_customid()))->row_array();
        // $couponData['created_at']

        $monthsVal = $this->get_couponValidity();
        // $valid_to  = date("Y-m-d", strtotime(" +".$monthsVal." months"));

        $date = $couponData['valid_from'];
        $date = strtotime(date("Y-m-d", strtotime($date)) . "+" . $monthsVal . " months");
        $valid_to = date("Y-m-d", $date);
        //echo $valid_to;  die;

        $update_data = array(
            'category_id' => $this->get_couponCategoryid(),
            'name' => $this->get_couponName(),
            'code' => $this->get_couponCode(),
            'min_order_price' => $this->get_couponMinOrderPrice(),
            'points' => $this->get_couponPoints(),
            'discount' => $this->get_couponDiscount(),
            'discount_type' => $this->get_couponDistype(),
            'validity' => $this->get_couponValidity(),
            'status' => '1',
            'valid_from' => date('Y-m-d'),
            'valid_to' => $valid_to,
        );

        $res = $this->db->where(array('id' => $this->get_customid()))->update('coupons', $update_data);
        $data = $this->db->affected_rows();
        if ($data) {
            return TRUE;
        }

        return $data;
    }

    /**     * ****************************************
     *   Orders Section                       *
     * ***************************************** */
    /*
     * Function : Check user email existance 
     * author   : Niraj
     * Argument : tablename e.g; users 
     */

    public function chkUserEmail($tablename) {

        $chkData = array('email' => $this->get_email());
        $res = $this->db->get_where($tablename, $chkData);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return 0;
        }
    }

    /*
     * Function : Check user id existance 
     * author   : Niraj
     * Argument : tablename e.g; users 
     */

    public function chkUserId($tablename) {

        $chkData = array('id' => $this->get_customid());
        $res = $this->db->get_where($tablename, $chkData);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return 0;
        }
    }

    /* ______________ MANAGAE USERS  __________________ */

    public function usersCount() {
        $query = $this->db->where_in('active', array(0, 1, 2));
        if ($this->getSearchData() != '') {
            $query = $this->db->like('LOWER(first_name)', $this->getSearchData(), 'both');
        }
        $count = $this->db->get('tbl_travel_users')->num_rows();

        return $count;
    }

    /* ____________= Get All Users =_____________ */

    public function getAllUsers($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select('*')->from('tbl_travel_users');
        //--- Search Text        
        if ($this->getSearchData() != '') {
            $query = $this->db->like('LOWER(fname)', $this->getSearchData(), 'both');
        }
        //--- All or Pagination
        if ($all) {
            $query = $this->db->order_by('fname', 'ASC')
                    ->where_in('active', array(0, 1, 2))
                    ->get();
        } else {
            $query = $this->db->order_by('fname', 'ASC')
                    ->where_in('active', array(0, 1, 2))
                    ->limit($from, $perPage)
                    ->get();
        }

        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    /* ______________ MANAGAE COUNTRIES  __________________ */

    public function countriesCount() {
        $query = $this->db->where_in('active', array(0, 1));
        if ($this->getSearchData() != '') {
            $query = $this->db->like('LOWER(countryname)', $this->getSearchData(), 'both');
        }
        $count = $this->db->get('tbl_travel_countrylist')->num_rows();
        return $count;
    }

    public function getAllCountriesList() {
        $data = array();
        $query = $this->db->select('*')->order_by('countryname', 'DESC')->from('tbl_travel_countrylist')->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function getAllCountries($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select('*')->from('tbl_travel_countrylist');
        //--- Search Text        
        if ($this->getSearchData() != '') {
            $query = $this->db->like('LOWER(countryname)', $this->getSearchData(), 'both');
        }
        //--- All or Pagination
        if ($all) {
            $query = $this->db->order_by('countryname', 'ASC')
                    ->where_in('active', array(0, 1))
                    ->get();
        } else {
            $query = $this->db->order_by('countryname', 'ASC')
                    ->where_in('active', array(0, 1))
                    ->limit($from, $perPage)
                    ->get();
        }
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function getAllContacts($get_cid) {
        $data = array();
        $query = $this->db->select('*')
                ->from('tbl_travel_contacts')
                ->where_in('active', array(0, 1))
                ->where_in('cid', $get_cid)
                ->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data[0];
    }

    /* ______________ HEALTH PUSHED DETAILS __________________ */

    public function healthInfoCount() {
        $query = $this->db->where_in('active', array(1, 2));
        if ($this->getSearchData() != '') {
            $idz = array();
            $res1 = $this->db->select("id")
                            ->like('LOWER(a.countryname)', $this->getSearchData(), 'both')
                            ->get('tbl_travel_countrylist a')->result_array();
            foreach ($res1 as $key => $val) {
                array_push($idz, $val['id']);
            }

            $this->db->where_in('cid', $idz);
        }

        $count = $this->db->get('tbl_push_healthinfo')->num_rows();
        return $count;
    }

    public function getAllhealthDetails($from = '', $perPage = '', $all = '') {
        $data = array();
        $query = $this->db->select('tbl_push_healthinfo.*,tbl_travel_countrylist.countryname,tbl_travel_countrylist.countrycode');
        $query = $this->db->from('tbl_push_healthinfo');
        //--- Search Tech        
        if ($this->getSearchData() != '') {
            $query = $this->db->like('LOWER(countryname)', $this->getSearchData(), 'both'); // LOWER(countryname)
        }
        //--- All or Pagination
        if ($all) {
            $query = $this->db->order_by('tbl_travel_countrylist.countryname', 'ASC')
                    ->where_in('tbl_push_healthinfo.active', array(1, 2))
                    ->join('tbl_travel_countrylist', 'tbl_push_healthinfo.cid = tbl_travel_countrylist.id', 'left outer')
                    ->get();
        } else {
            $query = $this->db->order_by('tbl_travel_countrylist.countryname', 'ASC')
                    //$this->db->order_by('date(createdon)','desc')
                    ->where_in('tbl_push_healthinfo.active', array(1, 2))
                    ->join('tbl_travel_countrylist', 'tbl_push_healthinfo.cid = tbl_travel_countrylist.id', 'left outer')
                    ->limit($from, $perPage)
                    ->get();
        }
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    /* ___________= Block/Activate User =____________ */

    public function setUserStatus($status, $userId) {
        if ($status == '1') {
            $newStatus = '2';
        } else {
            $newStatus = '1';
        }
        $data = array('active' => $newStatus);
        $this->db->where('id', $userId);

        $this->db->update('tbl_travel_users', $data);
        //$this->db->last_query(); die;

        $data = $this->db->affected_rows();
        return $data;
    }

    /* ____________= User Detail Page =_____________ */

    public function getUserDetails($userId) {
        $data = array();
        $query = $this->db->select('*')
                ->from('tbl_travel_users')
                ->where(array('id' => $userId))
                ->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    /* ____________= User Detail Page =_____________ */

    public function setUserDel($userId) {

        $data = array('active' => 3);
        $this->db->where('id', $userId);

        $this->db->update('tbl_travel_users', $data);
        //$this->db->last_query(); die;

        $data = $this->db->affected_rows();
        return $data;
    }

    /* ____________= User Detail Page =_____________ */

    public function addNewCntry($countryName, $countryCode, $countrySecretKey) {

        $data = array(
            'countryname' => $countryName,
            'countrycode' => $countryCode,
            'countrykey' => $countrySecretKey
        );
        $res = $this->db->insert('tbl_travel_countrylist', $data);
        //$this->db->last_query(); die;

        $data = $this->db->affected_rows();
        return $data;
    }

    /* ____________= Country Detail Data =_____________ */

    public function getCountryDetail($country_Id) {
        $data = array();
        $query = $this->db->select('*')
                ->from('tbl_travel_countrylist')
                ->where(array('id' => $country_Id))
                ->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    /* ___________= Block/Activate User =____________ */

    public function updateCountry($c_id, $c_name, $c_code, $c_key) {
        $data = array('countryname' => $c_name, 'countrycode' => $c_code, 'countrykey' => $c_key,);
        $this->db->where('id', $c_id);

        $this->db->update('tbl_travel_countrylist', $data);
        //$this->db->last_query(); die;

        $data = $this->db->affected_rows();
        return $data;
    }

    /* ____________= User Detail Page =_____________ */

    public function setCountryDel($c_id) {
        //-- firstly delete all its Health Info
        $this->db->where('cid', $c_id);
        $this->db->delete('tbl_push_healthinfo');
        //-- Then delete its record 
        $this->db->where('id', $c_id);
        $this->db->delete('tbl_travel_countrylist');
        $data = $this->db->affected_rows();
        return $data;
    }

    /* ____________= User Detail Page =_____________ */

    public function UpdateAllCountacts($up_cid, $up_data) {
        $this->db->where('cid', $up_cid);
        $this->db->update('tbl_travel_contacts', $up_data);
        $data = $this->db->affected_rows();
        return $data;
    }

    /* ____________= Country Detail Data =_____________ */

    public function getHealthDetailParticular($hid) {
        $data = array();
        $query = $this->db->select('tbl_push_healthinfo.*,tbl_travel_countrylist.countryname,tbl_travel_countrylist.countrycode');
        $query = $this->db->from('tbl_push_healthinfo');

        $query = $this->db->order_by('date(createdon)', 'desc')
                ->where_in('tbl_push_healthinfo.id', $hid)
                ->join('tbl_travel_countrylist', 'tbl_push_healthinfo.cid = tbl_travel_countrylist.id', 'left outer')
                ->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    /* ____________= Add New Health Info  =_____________ */

    public function addNewHealthInfo($country_id_v, $health_hline_v, $health_body_v) {

        $data = array(
            'cid' => $country_id_v,
            'headline' => $health_hline_v,
            'body' => $health_body_v,
            'active' => 1,
        );
        $res = $this->db->insert('tbl_push_healthinfo', $data);
        //$this->db->last_query(); die;
        $data = $this->db->affected_rows();
        return $data;
    }

    /* ___________= Block/Activate User =____________ */

    public function updateHealthInfo($h_id, $up_data) {
        $this->db->where('id', $h_id);
        $this->db->update('tbl_push_healthinfo', $up_data);
        $data = $this->db->affected_rows();
        //echo $this->db->last_query();exit;
        return $data;
    }

    /* ____________= User Detail Page =_____________ */

    public function setHealthInfoDel($h_id) {

        $data = array('active' => 3);
        $this->db->where('id', $h_id);

        $this->db->update('tbl_push_healthinfo', $data);
        //$this->db->last_query(); die;

        $data = $this->db->affected_rows();
        return $data;
    }

    /* ___________= Block/Activate Health Info =____________ */

    public function setHealthInfoStatus($actState, $h_Id) {
        $newStatus = $actState == '1' ? '2' : '1';
        $data = array('active' => $newStatus);

        $this->db->where('id', $h_Id);
        $this->db->update('tbl_push_healthinfo', $data);
        //echo $this->db->last_query();
        //echo "SAfsfsdsadasdasfsdf";die;
        $data = $this->db->affected_rows();
        return $data;
    }

    public function edit_a_caregiver($careGivrId) {
        echo "Model";
    }

}

?>
