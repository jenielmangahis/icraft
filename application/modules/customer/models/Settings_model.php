<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ 
class Settings_model extends CI_Model {

    private $_searchData = "", $_unit = "", $_category = "", $_subCategory = "", $_productUnit = "";
    private $_firstname, $_lastname, $_email, $_phone, $_picUrl, $_customid, $_customname, $_customarray;
    private $_doc1Name, $_do2Name, $_doc3Name, $_doc1Url, $_doc2Url, $_doc3Url;
    private $_sdate,$_edate, $_searchStatus, $_searchDriver, $_searchLocation; 
    private $_lat, $_lng ; 
    
    //------------ Add/View/Edit Product private variable
    private $_categories =array(), $_itemSubType, $_itemname, $_itemunit, $_itemfamily, $_itemcolor, $_itemflavour ; 
    private $_itemid, $_ounce8price, $_anounceprice, $_itemrecommends, $_itemeffects, $_itemreview , $_categoryName;
    private $_itemhot, $_itembiweekly, $_itemluxurious, $_itemthc, $_itemcbg, $_itemcbc, $_itemcbn, $_itemcbd, $_itemthcv, $_itemswhQnty;
    private $_message, $_link, $_familyId ,$_familyname , $_modules, $_whid, $_whname, $_whaddress , $_zipcode;
    
    //--- Start date setter/getter
    function set_sdate($_sdate) {$this->_sdate = $_sdate;}
    function get_sdate(){return $this->_sdate;}
    //--- End date setter/getter
    function set_edate($_edate) {$this->_edate = $_edate;}
    function get_edate(){return $this->_edate;}
    //--- userid setter/getter
    function set_userid($_userid) {$this->_userid = $_userid;}
    function get_userid(){return $this->_userid;}
    //--- customid setter/getter
    function set_customid($_customid) {$this->_customid = $_customid;}
    function get_customid(){return $this->_customid;}
    //--- customid setter/getter
    function set_customname($_customname) {$this->_customname = $_customname;}
    function get_customname(){return $this->_customname;}
    //--- custom Array setter/getter
    function set_customarray($_customarray) {$this->_customarray = $_customarray;}
    function get_customarray(){return $this->_customarray;}
    //--- First Name setter/getter
    function set_firstname($_firstname) {$this->_firstname = $_firstname;}
    function get_firstname(){return $this->_firstname;}
    //--- Last Name setter/getter
    function set_lastname($_lastname) {$this->_lastname = $_lastname;}
    function get_lastname(){return $this->_lastname;}
    //--- Last Name setter/getter
    function set_email($_email) {$this->_email = $_email;}
    function get_email(){return $this->_email;}
    //--- Last Name setter/getter
    function set_phone($_phone) {$this->_phone = $_phone;}
    function get_phone(){return $this->_phone;}
    //--- Last Name setter/getter
    function set_picUrl($_picUrl) {$this->_picUrl = $_picUrl;}
    function get_picUrl(){return $this->_picUrl;}
    
    //--- Last Name setter/getter
    function set_doc1Name($_doc1Name) {$this->_doc1Name = $_doc1Name;}
    function get_doc1Name(){return $this->_doc1Name;}
    //--- Last Name setter/getter
    function set_doc2Name($_doc2Name) {$this->_doc2Name = $_doc2Name;}
    function get_doc2Name(){return $this->_doc2Name;}
    //--- Last Name setter/getter
    function set_doc3Name($_doc3Name) {$this->_doc3Name = $_doc3Name;}
    function get_doc3Name(){return $this->_doc3Name;}
    //--- Last Name setter/getter
    function set_doc1Url($_doc1Url) {$this->_doc1Url = $_doc1Url;}
    function get_doc1Url(){return $this->_doc1Url;}
    //--- Last Name setter/getter
    function set_doc2Url($_doc2Url) {$this->_doc2Url = $_doc2Url;}
    function get_doc2Url(){return $this->_doc2Url;}
    //--- Last Name setter/getter
    function set_doc3Url($_doc3Url) {$this->_doc3Url = $_doc3Url;}
    function get_doc3Url(){return $this->_doc3Url;}
    

    //-- Search Text Setter / Getter
    function getSearchData() {return $this->_searchData; }
    function setSearchData($searchData) { $this->_searchData = $searchData; }
    //-- Search Text Setter / Getter
    function getSearchStatus() {return $this->_searchStatus; }
    function setSearchStatus($searchStatus) { $this->_searchStatus = $searchStatus; }
    //-- Category Text Setter / Getter
    function getCategory() {return $this->_category; }
    function setCategory($category) { $this->_category = $category; }
    //-- Units Text Setter / Getter
    function getUnit() {return $this->_unit; }
    function setUnit($unit) { $this->_unit = $unit; }
    //-- Category Text Setter / Getter
    function getSubCategory() {return $this->_subCategory; }
    function setSubCategory($subCategory) { $this->_subCategory = $subCategory; }
    //-- Product Unit Text Setter / Getter
    function getProductUnit() {return $this->_productUnit; }
    function setProductUnit($productUnit) { $this->_productUnit = $productUnit; }
    
    //-- Search Text Setter / Getter
    function getSearchDriver() {return $this->_searchDriver; }
    function setSearchDriver($searchDriver) { $this->_searchDriver = $searchDriver; }
    
    //-- Search Text Setter / Getter
    function getSearchLocation() {return $this->_searchLocation; }
    function setSearchLocation($searchLocation) { $this->_searchLocation = $searchLocation; }
    
    //-- Search Text Setter / Getter
    function get_zipcode() {return $this->_zipcode; }
    function set_zipcode($_zipcode) { $this->_zipcode = $_zipcode; }
    
    //-- Search Text Setter / Getter
    function get_lat() {return $this->_lat; }
    function set_lat($_lat) { $this->_lat = $_lat; }
    
    //-- Search Text Setter / Getter
    function get_lng() {return $this->_lng; }
    function set_lng($_lng) { $this->_lng = $_lng; }
    
    //--- categories setter/getter
    function set_categories($_categories) {$this->_categories = $_categories;}
    function get_categories(){return $this->_categories;}
    //--- itemSubType setter/getter
    function set_itemSubType($_itemSubType) {$this->_itemSubType = $_itemSubType;}
    function get_itemSubType(){return $this->_itemSubType;}
    //--- itemid setter/getter
    function set_itemid($_itemid) {$this->_itemid = $_itemid;}
    function get_itemid(){return $this->_itemid;}    
    //--- itemname setter/getter
    function set_itemname($_itemname) {$this->_itemname = $_itemname;}
    function get_itemname(){return $this->_itemname;}    
    //--- itemunit setter/getter
    function set_itemunit($_itemunit) {$this->_itemunit = $_itemunit;}
    function get_itemunit(){return $this->_itemunit;}
    //--- itemfamily setter/getter
    function set_itemfamily($_itemfamily) {$this->_itemfamily = $_itemfamily;}
    function get_itemfamily(){return $this->_itemfamily;}
    //--- itemcolor setter/getter
    function set_itemcolor($_itemcolor) {$this->_itemcolor = $_itemcolor;}
    function get_itemcolor(){return $this->_itemcolor;}
    //--- itemflavour setter/getter
    function set_itemflavour($_itemflavour) {$this->_itemflavour = $_itemflavour;}
    function get_itemflavour(){return $this->_itemflavour;}
    //--- ounce8price setter/getter
    function set_ounce8price($_ounce8price) {$this->_ounce8price = $_ounce8price;}
    function get_ounce8price(){return $this->_ounce8price;}
    //--- anounceprice setter/getter
    function set_anounceprice($_anounceprice) {$this->_anounceprice = $_anounceprice;}
    function get_anounceprice(){return $this->_anounceprice;}
    //--- itemrecommends setter/getter
    function set_itemrecommends($_itemrecommends) {$this->_itemrecommends = $_itemrecommends;}
    function get_itemrecommends(){return $this->_itemrecommends;}
    //--- itemeffects setter/getter
    function set_itemeffects($_itemeffects) {$this->_itemeffects = $_itemeffects;}
    function get_itemeffects(){return $this->_itemeffects;}
    //--- itemreview setter/getter
    function set_itemreview($_itemreview) {$this->_itemreview = $_itemreview;}
    function get_itemreview(){return $this->_itemreview;}


    //--- item hot setter/getter
    function set_itemhot($_itemhot) {$this->_itemhot = $_itemhot;}
    function get_itemhot(){return $this->_itemhot;}
    //--- item biweekly setter/getter
    function set_itembiweekly($_itembiweekly) {$this->_itembiweekly = $_itembiweekly;}
    function get_itembiweekly(){return $this->_itembiweekly;}
    //--- item hot setter/getter
    function set_itemluxurious($_itemluxurious) {$this->_itemluxurious = $_itemluxurious;}
    function get_itemluxurious(){return $this->_itemluxurious;}

    //--- item thc setter/getter
    function set_itemthc($_itemthc) {$this->_itemthc = $_itemthc;}
    function get_itemthc(){return $this->_itemthc;}
    //--- ite mcbg setter/getter
    function set_itemcbg($_itemcbg) {$this->_itemcbg = $_itemcbg;}
    function get_itemcbg(){return $this->_itemcbg;}
    //--- cbc mcbg setter/getter
    function set_itemcbc($_itemcbc) {$this->_itemcbc = $_itemcbc;}
    function get_itemcbc(){return $this->_itemcbc;}
    //--- item cbn setter/getter
    function set_itemcbn($_itemcbn) {$this->_itemcbn = $_itemcbn;}
    function get_itemcbn(){return $this->_itemcbn;}
    //--- ite mcbg setter/getter
    function set_itemcbd($_itemcbd) {$this->_itemcbd = $_itemcbd;}
    function get_itemcbd(){return $this->_itemcbd;}
    //--- cbc mcbg setter/getter
    function set_itemthcv($_itemthcv) {$this->_itemthcv = $_itemthcv;}
    function get_itemthcv(){return $this->_itemthcv;}

    //--- Warehouse Items setter/getter
    function set_itemswhQnty($_itemswhQnty) {$this->_itemswhQnty = $_itemswhQnty;}
    function get_itemswhQnty(){return $this->_itemswhQnty;}
    
    
    
    
    //--- Warehouse Items setter/getter
    function set_categoryName($_categoryName) {$this->_categoryName = $_categoryName;}
    function get_categoryName(){return $this->_categoryName;}
    //--- Warehouse Items setter/getter
    function set_modules($_modules) {$this->_modules = $_modules;}
    function get_modules(){return $this->_modules;}
    
    //--- Warehouse Items setter/getter
    function set_familyname($_familyname) {$this->_familyname = $_familyname;}
    function get_familyname(){return $this->_familyname;} 
    //--- Warehouse Items setter/getter
    function set_familyId($_familyId) {$this->_familyId = $_familyId;}
    function get_familyId(){return $this->_familyId;} 
    
    //--- Warehouse Name setter/getter
    function set_whname($_whname) {$this->_whname = $_whname;}
    function get_whname(){return $this->_whname;} 
    //--- Warehouse Id setter/getter
    function set_whid($_whid) {$this->_whid = $_whid;}
    function get_whid(){return $this->_whid;} 
    //--- Warehouse Id setter/getter
    function set_whaddress($_whaddress) {$this->_whaddress = $_whaddress;}
    function get_whaddress(){return $this->_whaddress;} 
    
    
    
    //--- Warehouse Items setter/getter
    function set_message($_message) {$this->_message = $_message;}
    function get_message(){return $this->_message;}
    //--- Warehouse Items setter/getter
    function set_link($_link) {$this->_link = $_link;}
    function get_link(){return $this->_link;}
    
    

    
    /*******************************************
     *   Setting Section : Manage Users        *
     *******************************************/
    
    /*
     * Function : Manage Users Seb-section 
     * author   : Niraj
     * function : Count All Admin Users  
     */
    public function usersCount(){       
        $data = array();               
        $query = $this->db->select('a.id AS user_id, a.email AS user_email, a.fname AS user_fname, a.lname AS user_lname, a.phone AS contact, a.user_right, a.allowed_menus, a.last_login, a.created_from, a.deleted_from, a.created_date, a.deleted_time')->from('admin a')->where(array('active'=>'1'))->where('id !=', '1');
        
        if($this->getSearchData() != ""){
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where( "(message like '%$makeFilter%')");
        }   
        
        $query = $this->db->get();
        if($query){
            if($query->num_rows() > 0){
                $count = $query->num_rows();
                return $count;
            }else{
                return 0;
            }
            
        }
        return 0;
    }
    /*
     * Function : Manage Users Seb-section 
     * author   : Niraj
     * function : Fetch All Admin Users  
     */
    public function getAllUsers($from='',$perPage='', $all = '') {
        $data = array();
        $query = $this->db->select('a.id AS user_id, a.email AS user_email, a.fname AS user_fname, a.lname AS user_lname, a.phone AS contact, a.user_right, a.allowed_menus, a.last_login, a.created_from, a.deleted_from, a.created_date, a.deleted_time')->from('admin a')->where(array('active'=>'1'))->where('id !=', '1');
        
        //-- Search Text by Customer Name, Order Id , Email        
        if($this->getSearchData() != ""){
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where( "(message like '%$makeFilter%')");
        }  
        
        $query = $this->db->limit($from,$perPage)->get();
        if($query){
            if($query->num_rows() > 0){
                $data = $query->result_array();
                // echo"<pre>";print_r($data);die;
                return $data;
            }else{
                return $data;
            }
            
        }
        
        return $data;
    }
    
   /*
     * Admin Setting Section
     * author   : Niraj
     * function : Add Admin User
     */
    public function addAdminUser() {
        $data = array();    
        $selected_modules = '';
        $modules = $this->get_modules();
        for($i=0; $i < count($modules); $i++){
            $selected_modules .= $modules[$i];
            if($i < count($modules)-1)$selected_modules .=',';
        }
        $password = strtoupper(substr($this->get_firstname(), 0,3).rand(99999,11111));
        
        $in_data=array(       
            id              => '',
            email           => $this->get_email(),
            fname           => $this->get_firstname(),
            lname           => $this->get_lastname(),   
            password        => md5($password),
            phone           => $this->get_phone(),
            user_right      => '2',
            allowed_menus   => $selected_modules,
            last_login      => '0000-00-00 00:00:00',
            created_from    => '1',
            deleted_from    => '0',
            created_date    => date('Y-m-d H:i:s'),
            deleted_time    => '0000-00-00 00:00:00',
            active          => '1'
        );
       
        $res = $this->db->insert('admin', $in_data);
        $data = $this->db->affected_rows();        
        return $data; 
    }
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : Fetch Admin User Details
     */
    public function fetch_admin_user_details($userId=''){
        if($userId != ''){
            $data = array();
            $query = $this->db->select('a.id AS user_id, a.email AS user_email, a.fname AS user_fname, a.lname AS user_lname, a.phone AS contact, a.user_right, a.allowed_menus, a.last_login, a.created_from, a.deleted_from, a.created_date, a.deleted_time')->from('admin a')->where(array('active'=>'1'))->where('id =', $userId)->get();

            if($query->num_rows() > 0){
                $data = $query->row_array();
            }

            return $data; 
        }else{
            $data = array();
            $query = $this->db->select('a.id AS user_id, a.email AS user_email, a.fname AS user_fname, a.lname AS user_lname, a.phone AS contact, a.user_right, a.allowed_menus, a.last_login, a.created_from, a.deleted_from, a.created_date, a.deleted_time')->from('admin a')->where(array('active'=>'1'))->where('id =', $this->get_userid())->get();

            if($query->num_rows() > 0){
                $data = $query->row_array();
            }

            return $data;
        }
            
    }
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : Update Admin User Details
     */
    public function updateAdminUser() {
        $data = array();    
        $selected_modules = '';
        $modules = $this->get_modules();
        for($i=0; $i < count($modules); $i++){
            $selected_modules .= $modules[$i];
            if($i < count($modules)-1)$selected_modules .=',';
        }	
        $update_data=array(    
            fname           => $this->get_firstname(),
            lname           => $this->get_lastname(),  
            phone           => $this->get_phone(),
            allowed_menus   => $selected_modules,
        );
        
        $res = $this->db->where(array('id'=>$this->get_userid()))->update('admin', $update_data);
        $data = $this->db->affected_rows();        
        return $data; 
    }
    
    /*
     * Function : Manage Users Seb-section 
     * author   : Niraj
     * Function : Delete Admin User record  
     */
    public function delete_admin_user(){  
        $this->db->where('id', $this->get_userid())->delete('admin'); 
        $data = $this->db->affected_rows();
        return $data;
    }
    
    
    /**********************************************
     *   Setting Section : Manage Products Family *
     **********************************************/
    /*
     * Function : Manage Products Seb-section 
     * author   : Niraj
     * function : Count All Products Families
     */
    public function productFamilyCount(){       
        $data = array();               
        $query = $this->db->select('a.id AS family_id, a.name AS family_name, a.status AS family_status, a.created_at  AS family_created_at, a.updated_at AS family_updated_at')->from('item_familly a');
        
        if($this->getSearchData() != ""){
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where( "(message like '%$makeFilter%')");
        }   
        
        $query = $this->db->get();
        if($query){
            if($query->num_rows() > 0){
                $count = $query->num_rows();
                return $count;
            }else{
                return 0;
            }
            
        }
        return 0;
    }
     /*
     * Function : Manage Products Seb-section 
     * author   : Niraj
     * function : Count All Products Families Details
     */
    public function getAllProductFamily($from='',$perPage='', $all = '') {
        $data = array();
        $query = $this->db->select('a.id AS family_id, a.name AS family_name, a.status AS family_status, a.created_at  AS family_created_at, a.updated_at AS family_updated_at')->from('item_familly a');
        
        //-- Search Text by Customer Name, Order Id , Email        
        if($this->getSearchData() != ""){
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where( "(message like '%$makeFilter%')");
        }  
        
        $query = $this->db->limit($from,$perPage)->get();
        if($query){
            if($query->num_rows() > 0){
                $data = $query->result_array();
                // echo"<pre>";print_r($data);die;
                return $data;
            }else{
                return $data;
            }
            
        }
        
        return $data;
    }
    
    /*
     * Function : Manage Products Seb-section 
     * author   : Niraj
     * Function : Acivate/ Inactivate Family Status
     */
    public function changeFamilyStatus($familyId = ""){
        if($familyId != ''){
            $this->set_customid($familyId);
            $familyInfo = $this->chkUserId('item_familly');
            $newStatus  = $familyInfo['status'] == 1 ? '0' : '1' ; 

            $data = array();
            $this->db->where('id',$familyId)->update('item_familly',array('status'=>$newStatus));
            $data = $this->db->affected_rows();
            return $data;
        }else{
            $this->set_customid($this->get_familyId());
            $familyInfo = $this->chkUserId('item_familly');
            $newStatus  = $familyInfo['status'] == 1 ? '0' : '1' ; 
            
            $data = array();
            $this->db->where('id',$this->get_customid())->update('item_familly',array('status'=>$newStatus));
            $data = $this->db->affected_rows();
            return $data;
        }
    }
    
     /*
     * Function : Manage Products Seb-section 
     * author   : Niraj
     * @function for : Add New Product Family
     */ 
    public function addNewProductFamily() {	
        $in_data=array(       
            'id'          => '',
            'name'        => $this->get_familyname(),
            'status'      => '1',
            'created_at'  => date('Y-m-d H:i:s'),
        );
       
        $res = $this->db->insert('item_familly', $in_data);
        $data = $this->db->affected_rows();
        return $data; 
    }
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : View/Edit Product Family
     */
    public function fetch_product_family_details($familyId){
        if($familyId != ''){
            $data = array();
            $query = $this->db->select('a.id AS family_id, a.name AS family_name, a.status AS family_status, a.created_at  AS family_created_at, a.updated_at AS family_updated_at')->from('item_familly a')->where('id =', $familyId)->get();

            if($query->num_rows() > 0){
                $data = $query->row_array();
            }

            return $data; 
        }else{
            $data = array();
            $query = $this->db->select('a.id AS family_id, a.name AS family_name, a.status AS family_status, a.created_at  AS family_created_at, a.updated_at AS family_updated_at')->from('item_familly a')->where('id =', $this->get_familyId())->get();

            if($query->num_rows() > 0){
                $data = $query->row_array();
            }

            return $data;
        }
            
    }
    
    /*
     * MAnage Products : Admin Setting Section
     * author   : Niraj
     * function : Update Product Family
     */
    public function updateProductFamilyDetails() {
        $data = array();    	
        $update_data=array( 'name' => $this->get_familyname(), 'updated_at' => date('Y-m-d H:i:s'));
        $res = $this->db->where(array('id'=>$this->get_familyId()))->update('item_familly', $update_data);
        $data = $this->db->affected_rows();        
        return $data; 
    }
    
    /*
     * Function : Manage Products Seb-section 
     * author   : Niraj
     * Function : Check Family Name 
     */
    function check_family_name($fname){
        $query = $this->db->get_where('item_familly', array('name'=>$fname));
        if($query){
            if($query->num_rows() > 0){
             return TRUE;   
            }
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    
    /*
     * Function : Manage Users Seb-section 
     * author   : Niraj
     * Function : Delete Product Family record  
     */
    public function delete_productFamily(){  
        $this->db->where('id', $this->get_userid())->delete('item_familly'); 
        $data = $this->db->affected_rows();
        return $data;
    }
    
    
    /*******************************************
     *   Setting Section : Manage Ware-House   *
     *******************************************/
    /*
     * Function : Manage Ware-Houses
     * author   : Niraj
     * function : Count All Ware Houses
     */
    public function WareHosesCount(){       
        $data = array();               
        $query = $this->db->select('d.id AS warehouse_id, d.name AS warehouse_name, d.address AS warehouse_address, d.lat AS warehouse_lat, d.lang AS warehouse_lang, d.status AS warehouse_status, d.created_at AS warehouse_created_at')->from('warehouse d');
        
        if($this->getSearchData() != ""){
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where( "(name like '%$makeFilter%')");
        }   
        
        $query = $this->db->get();
        if($query){
            if($query->num_rows() > 0){
                $count = $query->num_rows();
                return $count;
            }else{
                return 0;
            }
            
        }
        return 0;
    }
    /*
     * Function : Manage Ware Houses
     * author   : Niraj
     * Function : List All Ware Houses 
     */
    public function getAllWareHouses($from='',$perPage='', $all = '') {
        $data = array();
        $query = $this->db->select('d.id AS warehouse_id, d.name AS warehouse_name, d.address AS warehouse_address, d.lat AS warehouse_lat, d.lang AS warehouse_lang, d.status AS warehouse_status, d.created_at AS warehouse_created_at')->from('warehouse d');
        
        //-- Search Text by Customer Name, Order Id , Email        
        if($this->getSearchData() != ""){
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where( "(name like '%$makeFilter%')");
        }  
        
        $query = $this->db->limit($from,$perPage)->get();
        if($query){
            if($query->num_rows() > 0){
                $data = $query->result_array();
                // echo"<pre>";print_r($data);die;
                return $data;
            }else{
                return $data;
            }
            
        }
        
        return $data;
    }
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : Add Ware House
     */
    public function addWareHouse() {
        $data = array();    
        $in_data=array(       
            'id'            => '',
            'name'          => $this->get_whname(),
            'address'       => $this->get_whaddress(),
            'lat'           => $this->get_lat(),
            'lang'          => $this->get_lng(),
            'status'        => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => '0000-00-00 00:00:00'
        );
       
        $res = $this->db->insert('warehouse', $in_data);
        $data = $this->db->affected_rows();        
        return $data; 
    }
    
    /*
     * Function : Manage Products Seb-section 
     * author   : Niraj
     * Function : Acivate/ Inactivate Family Status
     */
    public function changeWareHouseStatus($warehouseId){
        if($warehouseId != ''){
            $this->set_whid($warehouseId);
            $this->set_customid($warehouseId);
            $familyInfo = $this->chkUserId('warehouse');
            $newStatus  = $familyInfo['status'] == 1 ? '0' : '1' ; 

            $data = array();
            $this->db->where('id',$this->get_whid())->update('warehouse',array('status'=>$newStatus));
            $data = $this->db->affected_rows();
            return $data;
        }else{
            $this->set_customid($this->get_whid());
            $familyInfo = $this->chkUserId('warehouse');
            $newStatus  = $familyInfo['status'] == 1 ? '0' : '1' ; 
            
            $data = array();
            $this->db->where('id',$this->get_whid())->update('warehouse',array('status'=>$newStatus));
            $data = $this->db->affected_rows();
            return $data;
        }
    }
    
    /*
     * Function : Manage Users Seb-section 
     * author   : Niraj
     * Function : Delete Product Family record  
     */
    public function delete_wareHouse(){  
        $this->db->where('id', $this->get_whid())->delete('warehouse'); 
        $data = $this->db->affected_rows();
        return $data;
    }
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : Fetch Admin User Details
     */
    public function fetch_warehouse_details($whid){
        if($whid != ''){
            $data = array();
            $query = $this->db->select('d.id AS warehouse_id, d.name AS warehouse_name, d.address AS warehouse_address, d.lat AS warehouse_lat, d.lang AS warehouse_lang, d.status AS warehouse_status, d.created_at AS warehouse_created_at')->from('warehouse d')->where('id =', $whid)->get();

            if($query->num_rows() > 0){
                $data = $query->row_array();
            }

            return $data; 
        }else{
            $data = array();
            $query = $this->db->select('d.id AS warehouse_id, d.name AS warehouse_name, d.address AS warehouse_address, d.lat AS warehouse_lat, d.lang AS warehouse_lang, d.status AS warehouse_status, d.created_at AS warehouse_created_at')->from('warehouse d')->where('id =', $this->get_whid())->get();

            if($query->num_rows() > 0){
                $data = $query->row_array();
            }

            return $data;
        }
            
    }
    
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : Add Ware House
     */
    public function updateWareHouse() {
        $data = array();    
        $up_data=array(       
            'name'          => $this->get_whname(),
            'address'       => $this->get_whaddress(),
            'lat'           => $this->get_lat(),
            'lang'          => $this->get_lng(),
            'updated_at'    => date('Y-m-d H:i:s'),
        );
       
        $res = $this->db->where('id', $this->get_whid())->update('warehouse', $up_data);
        $data = $this->db->affected_rows();        
        return $data; 
    }
    
    
    
    
    
    /*******************************************
     *   Setting Section : RESTRICTED AREA     *
     *******************************************/
    /*
     * Function : Manage Restricted Area 
     * author   : Niraj
     * function : Count All Restricted Area 
     */
    public function RestrictedAreasCount(){       
        $data = array();               
        $query = $this->db->select('id, area_name, area_permission, mon, tue, wed, thu, fri, sat, sun, zip_codes, created_at, updated_at')->from('restricted_areas');
        
        if($this->getSearchData() != ""){
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where( "(name like '%$makeFilter%')");
        }   
        
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if($query){
            if($query->num_rows() > 0){
                $count = $query->num_rows();
                return $count;
            }else{
                return 0;
            }
            
        }
        return 0;
    }
    /*
     * Function : Manage Ware Houses
     * author   : Niraj
     * Function : List All Ware Houses 
     */
    public function getAllRestrictedAreas($from='',$perPage='', $all = '') {
        $data = array();
        $query = $this->db->select('id, area_name, area_permission, mon, tue, wed, thu, fri, sat, sun, zip_codes, created_at, updated_at')->from('restricted_areas');
        
        //-- Search Text by Customer Name, Order Id , Email        
        if($this->getSearchData() != ""){
            $makeFilter = $this->input->post("searchText");
            //$query=$this->db->or_like(array('users.first_name' =>$makeFilter,'users.last_name' => $makeFilter,'users.email' => $makeFilter,'users.phone_number' => $makeFilter,'users.city' => $makeFilter,'users.state' => $makeFilter,'users.address' => $makeFilter));/* LIKE OR LIKE */
            $this->db->where( "(name like '%$makeFilter%')");
        }  
        
        $query = $this->db->limit($from,$perPage)->get();
        if($query){
            if($query->num_rows() > 0){
                $data = $query->result_array();
                // echo"<pre>";print_r($data);die;
                return $data;
            }else{
                return $data;
            }
            
        }
        
        return $data;
    }
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : Add Ware House
     */
    public function addRestrictedArea($dataChk) {
        $data = array(); 
        
        if($dataChk == '0'){
            $in_data = array_merge($data, array(
                'mon'   => '0',
                'wed'   => '0',
                'thu'   => '0',
                'fri'   => '0',
                'sat'   => '0',
                'sun'   => '0',
             ));
        }else{
            $dayz = $this->get_customarray();
            $in_data = array_merge($data, array(
                'mon'   => in_array(1, $dayz) ? '1' : '0',
                'tue'   => in_array(2, $dayz) ? '1' : '0',
                'wed'   => in_array(3, $dayz) ? '1' : '0',
                'thu'   => in_array(4, $dayz) ? '1' : '0',
                'fri'   => in_array(5, $dayz) ? '1' : '0',
                'sat'   => in_array(6, $dayz) ? '1' : '0',
                'sun'   => in_array(7, $dayz) ? '1' : '0',
             ));
        }
        $in_data['id']              = ''; 
        $in_data['area_permission'] = $this->get_customid(); 
        $in_data['area_name']       = $this->get_customname();
        $in_data['zip_codes']       = $this->get_zipcode();
        $in_data['created_at']      = date('Y-m-d H:i:s');
        $in_data['updated_at']      = '';
                
        $res = $this->db->insert('restricted_areas', $in_data);
        $data = $this->db->affected_rows();  
        return $data; 
    }
    

    
    /*
     * Function : Manage Users Seb-section 
     * author   : Niraj
     * Function : Delete Product Family record  
     */
    public function delete_reatricted_area_record(){  
        $data = array();
            $query = $this->db->select('area_name as searchname')->from('restricted_areas')->where('id =', $this->get_customid())->get();
            if($query->num_rows() > 0){
                $data = $query->row_array();
                $this->db->where('area_name', $data['searchname'])->delete('restricted_areas'); 
                $data = $this->db->affected_rows();
            }
        
        return $data;
    }
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : Fetch Admin User Details
     */
    public function fetch_restricted_area_details($resAreaid = ''){
        if($resAreaid != ''){
            $data = array();
            $query = $this->db->select('area_name as serchname')->from('restricted_areas')->where('id =', $resAreaid)->get();
            

            if($query->num_rows() > 0){
                $data = $query->row_array();
                $query = $this->db->select('id, area_name, area_permission, mon, tue, wed, thu, fri, sat, sun, zip_codes, created_at, updated_at')->from('restricted_areas')->where('area_name =', $data['serchname'])->get();
                $data = $query->result_array();
            }

            return $data; 
        }else{
            $data = array();
            $query = $this->db->select('area_name as serchname')->from('restricted_areas')->where('id =', $this->get_customid())->get();

            if($query->num_rows() > 0){
                $data = $query->row_array();
                $query = $this->db->select('id, area_name, area_permission, mon, tue, wed, thu, fri, sat, sun, zip_codes, created_at, updated_at')->from('restricted_areas')->where('area_name =', $data['serchname'])->get();
                $data = $query->result_array();
            }

            return $data;
        }
            
    }
    
    
    /*
     * Admin Setting Section
     * author   : Niraj
     * function : Update Restricted Area 
     */
    public function updateRestrictedArea() {  
        $dayz = $this->get_customarray();
        $up_data=array(       
            'area_name'         => $this->get_customname(), 
            'mon'               => in_array(1, $dayz) ? '1' : '0',
            'tue'               => in_array(2, $dayz) ? '1' : '0',
            'wed'               => in_array(3, $dayz) ? '1' : '0',
            'thu'               => in_array(4, $dayz) ? '1' : '0',
            'fri'               => in_array(5, $dayz) ? '1' : '0',
            'sat'               => in_array(6, $dayz) ? '1' : '0',
            'sun'               => in_array(7, $dayz) ? '1' : '0',
            'zip_codes'         => $this->get_zipcode(), 
            'updated_at'        => date('Y-m-d H:i:s'), 
        );
        $res = $this->db->where('id', $this->get_customid())->update('restricted_areas', $up_data);
        $data = $this->db->affected_rows();  
        return $data; 
    }
    
    
    /** *********************************************
     *  All Setting Section : Manage Minimum Prices *
     ** *********************************************/  
    /*
     * Manage Minimum Prices |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Fetch All minimum prices data records ()
     */
    public function fetch_minimum_delivery_prices_records() {  
        $data = array();
        $query = $this->db->get('minimum_delivery_prices');


        if($query->num_rows() > 0){
            $data = $query->result_array();
        }
        return $data;
    }
    
    
    
    /*
     * Manage Minimum Prices |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Update Minimum Price Data Records ()
     */
    function update_min_delivery_prices_record($udata){
        $up_data = array(
            'name'       => $udata['name'],
            'rate'       => $udata['rate'],
            'last_rate'  => $udata['old_rate'],
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $query = $this->db->where(array('id' => $udata['id']))->update('minimum_delivery_prices', $up_data);
        $data = $this->db->affected_rows();  
        return $data; 
    }
    
    
    /*
     * Manage Minimum Prices |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Change Min Del. Price Status 
     */
    public function changeMinDelPriceStatus($mdpId){
        if($warehouseId != ''){
            $this->set_customid($mdpId);
            $mdpInfo = $this->chkUserId('minimum_delivery_prices');
            $newStatus  = $mdpInfo['active'] == 1 ? '0' : '1' ; 

            $data = array();
            $this->db->where('id',$this->get_customid())->update('minimum_delivery_prices',array('active'=>$newStatus));
            $data = $this->db->affected_rows();
            return $data;
        }else{
            $mdpInfo = $this->chkUserId('minimum_delivery_prices');
            $newStatus  = $mdpInfo['active'] == 1 ? '0' : '1' ;
            
            $data = array();
            $this->db->where('id',$this->get_customid())->update('minimum_delivery_prices',array('active'=>$newStatus));
            $data = $this->db->affected_rows();
            return $data;
        }
    }
    
    
    
    
    
    
    
    
    
    /*******************************************
     *   COMMON USED FUNCTION                  *
     *******************************************/
    /*
     * Function : Check user email existance 
     * author   : Niraj
     * Argument : tablename e.g; users 
     */
    public function chkUserEmail($tablename) {
        
        $chkData = array('email' => $this->get_email());
        $res    = $this->db->get_where($tablename, $chkData);
        if ($res->num_rows() > 0)
        {
            return $res->row_array();
        }else{
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
        $res    = $this->db->get_where($tablename, $chkData);
        if ($res->num_rows() > 0)
        {
            return $res->row_array();
        }else{
            return 0;           
        }
    }
    
    
    
    
    
    
    
    
    
    

    
    
    
    /*______________ MANAGAE COUNTRIES  __________________*/
    public function countriesCount(){
        $query = $this->db->where_in('active',array(0,1));
        if($this->getSearchData() != ''){
          $query = $this->db->like('LOWER(countryname)',$this->getSearchData(),'both');
       }        
        $count = $this->db->get('tbl_travel_countrylist')->num_rows();
        return $count;
    }
    
    public function getAllCountriesList() {
        $data = array();
        $query = $this->db->select('*')->order_by('countryname','DESC')->from('tbl_travel_countrylist')->get();
        //echo $this->db->last_query();exit;
        if($query->num_rows() > 0){
            $data = $query->result_array();
        }
        return $data; 
    }
    
    
    public function getAllCountries($from='',$perPage='', $all = '') {
        $data = array();
        $query = $this->db->select('*')->from('tbl_travel_countrylist');
        //--- Search Text        
        if($this->getSearchData() != ''){
            $query = $this->db->like('LOWER(countryname)',$this->getSearchData(),'both');
        }
        //--- All or Pagination
        if($all){
             $query = $this->db->order_by('countryname','ASC')
                    ->where_in('active',array(0,1))
                    ->get();
        }else{
            $query = $this->db->order_by('countryname','ASC')
                    ->where_in('active',array(0,1))
                    ->limit($from,$perPage)
                    ->get();
        }
        if($query->num_rows() > 0){
            $data = $query->result_array();
        }
        return $data; 
    }
    
    public function getAllContacts($get_cid) {
        $data = array();
        $query = $this->db->select('*')
                 ->from('tbl_travel_contacts')
                ->where_in('active',array(0,1))
                ->where_in('cid', $get_cid)
                ->get();
        //echo $this->db->last_query();exit;
        if($query->num_rows() > 0){
            $data = $query->result_array();
        }
        return $data[0]; 
    }
    
    /*______________ HEALTH PUSHED DETAILS __________________*/
    public function healthInfoCount(){
        $query = $this->db->where_in('active',array(1,2));
        if($this->getSearchData() != ''){
            $idz = array();
            $res1= $this->db->select("id")
                            ->like('LOWER(a.countryname)',$this->getSearchData(),'both')
                            ->get('tbl_travel_countrylist a')->result_array(); 
            foreach($res1 as $key=>$val){ array_push($idz, $val['id']); }   
            
            $this->db->where_in('cid', $idz);
        }  
        
        $count = $this->db->get('tbl_push_healthinfo')->num_rows(); 
        return $count;
    }
    
    public function getAllhealthDetails($from='',$perPage='', $all ='') { 
        $data = array();
        $query = $this->db->select('tbl_push_healthinfo.*,tbl_travel_countrylist.countryname,tbl_travel_countrylist.countrycode');
        $query = $this->db->from('tbl_push_healthinfo');
        //--- Search Tech        
        if($this->getSearchData() != ''){
            $query = $this->db->like('LOWER(countryname)',$this->getSearchData(),'both'); // LOWER(countryname)
        }
        //--- All or Pagination
        if($all){
             $query = $this->db->order_by('tbl_travel_countrylist.countryname','ASC')
                    ->where_in('tbl_push_healthinfo.active',array(1,2))
                    ->join('tbl_travel_countrylist', 'tbl_push_healthinfo.cid = tbl_travel_countrylist.id', 'left outer')
                    ->get();
        }else{
            $query = $this->db->order_by('tbl_travel_countrylist.countryname','ASC') 
                     //$this->db->order_by('date(createdon)','desc')
                    ->where_in('tbl_push_healthinfo.active',array(1,2))
                    ->join('tbl_travel_countrylist', 'tbl_push_healthinfo.cid = tbl_travel_countrylist.id', 'left outer')
                    ->limit($from,$perPage)
                    ->get();
        }
        if($query->num_rows() > 0){
            $data = $query->result_array();
        }
        return $data; 
    }
    
    
    /*___________= Block/Activate User =____________*/ 
    public function setUserStatus($status,$userId){
        if($status == '1'){
            $newStatus = '2';
        }else{
            $newStatus = '1';
        }
        $data=array('active'=>$newStatus);
        $this->db->where('id',$userId);
        
        $this->db->update('tbl_travel_users',$data);
        //$this->db->last_query(); die;
        
        $data = $this->db->affected_rows();
        return $data;
    }
    
    /*____________= User Detail Page =_____________*/ 
    public function getUserDetails($userId){
        $data = array();
        $query = $this->db->select('*')
                ->from('tbl_travel_users')
                ->where(array('id'=>$userId))
                ->get();
        
        if($query->num_rows() > 0){
            $data = $query->row_array();
        }
        
        return $data; 
    }
    
    /*____________= User Detail Page =_____________*/
    public function setUserDel($userId){  
        
        $data=array('active'=>3);
        $this->db->where('id',$userId);
        
        $this->db->update('tbl_travel_users',$data);
        //$this->db->last_query(); die;
        
        $data = $this->db->affected_rows();
        return $data;
    }
    
    /*____________= User Detail Page =_____________*/
    public function addNewCntry($countryName, $countryCode, $countrySecretKey){
        
        $data=array(
                'countryname'=>$countryName,
                'countrycode'=>$countryCode,
                'countrykey' =>$countrySecretKey
                );
        $res = $this->db->insert('tbl_travel_countrylist', $data);
        //$this->db->last_query(); die;
        
        $data = $this->db->affected_rows();
        return $data;
    }
    
    
    /*____________= Country Detail Data =_____________*/
    public function getCountryDetail($country_Id){
        $data = array();
        $query = $this->db->select('*')
                ->from('tbl_travel_countrylist')
                ->where(array('id'=>$country_Id))
                ->get();
        
        if($query->num_rows() > 0){
            $data = $query->row_array();
        }        
        return $data; 
    }
    
    /*___________= Block/Activate User =____________*/
    public function updateCountry($c_id, $c_name, $c_code, $c_key){
        $data=array('countryname'=>$c_name, 'countrycode'=>$c_code, 'countrykey'=>$c_key, );
        $this->db->where('id',$c_id);
        
        $this->db->update('tbl_travel_countrylist',$data);
        //$this->db->last_query(); die;
        
        $data = $this->db->affected_rows();
        return $data;
    }
    
    /*____________= User Detail Page =_____________*/
    public function setCountryDel($c_id){ 
        //-- firstly delete all its Health Info
        $this->db->where('cid',$c_id);
        $this->db->delete('tbl_push_healthinfo');
        //-- Then delete its record 
        $this->db->where('id',$c_id);
        $this->db->delete('tbl_travel_countrylist');        
        $data = $this->db->affected_rows();
        return $data;
    }
    
    /*____________= User Detail Page =_____________*/
    public function UpdateAllCountacts($up_cid, $up_data){
        $this->db->where('cid',$up_cid);
        $this->db->update('tbl_travel_contacts',$up_data);      
        $data = $this->db->affected_rows();
        return $data;
    }
    
    /*____________= Country Detail Data =_____________*/
    public function getHealthDetailParticular($hid){
        $data = array();
        $query = $this->db->select('tbl_push_healthinfo.*,tbl_travel_countrylist.countryname,tbl_travel_countrylist.countrycode');
        $query = $this->db->from('tbl_push_healthinfo');
        
         $query = $this->db->order_by('date(createdon)','desc')
                ->where_in('tbl_push_healthinfo.id',$hid)
                ->join('tbl_travel_countrylist', 'tbl_push_healthinfo.cid = tbl_travel_countrylist.id', 'left outer')                            
                ->get();
        if($query->num_rows() > 0){
            $data = $query->result_array();
        }
        return $data;  
    }
    
    /*____________= Add New Health Info  =_____________*/
    public function addNewHealthInfo($country_id_v, $health_hline_v, $health_body_v){
        
        $data=array(
            'cid'=> $country_id_v,
            'headline'=>$health_hline_v,
            'body' =>$health_body_v,
            'active' =>1,
        ); 
        $res = $this->db->insert('tbl_push_healthinfo', $data);
        //$this->db->last_query(); die;
        $data = $this->db->affected_rows();
        return $data;
    }
    
    
    /*___________= Block/Activate User =____________*/
    public function updateHealthInfo($h_id, $up_data){
        $this->db->where('id',$h_id);
        $this->db->update('tbl_push_healthinfo',$up_data);
        $data = $this->db->affected_rows();
        //echo $this->db->last_query();exit;
        return $data;
    }
    
    /*____________= User Detail Page =_____________*/
    public function setHealthInfoDel($h_id){ 
        
        $data=array('active'=>3);
        $this->db->where('id',$h_id);
        
        $this->db->update('tbl_push_healthinfo',$data);
        //$this->db->last_query(); die;
        
        $data = $this->db->affected_rows();
        return $data;
    }
    
    /*___________= Block/Activate Health Info =____________*/ 
    public function setHealthInfoStatus($actState,$h_Id){
        $newStatus =  $actState == '1' ? '2' : '1';
        $data=array('active'=>$newStatus);
        
        $this->db->where('id',$h_Id);        
        $this->db->update('tbl_push_healthinfo',$data);
        echo $this->db->last_query();
        //echo "SAfsfsdsadasdasfsdf";die;
        $data = $this->db->affected_rows();
        return $data;
    }
    
}
?>