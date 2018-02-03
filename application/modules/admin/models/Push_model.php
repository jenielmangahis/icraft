<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Push_model extends CI_Model {

    private $_searchData = "";

    function getSearchData() {
       return $this->_searchData;
    }

    function setSearchData($searchData) {
       $this->_searchData =
               $searchData;
    }

    /*##################################################################*/
    /*###########=            All Solace Api Work          =############*/

    /*___________= Set privacyPolicy / termsCondition Info | Solace =____________*/ 
    public function get_all_isd(){ 
        
        $context = stream_context_create(array(
            'http' => array(
            'method' => 'GET',
            'header' => "Authorization: kJAb389lKansm6259ankjaKAj0308Knam38hGBBAVavqke581lasmWowiq71891cnmBajhaiqo8260uHGASCvvbnqInmNIq1092",
            )
        ));
        //$url = 'https://beta.solacesecure.co.uk/api/alerts?limit=100&countryName=All';
        $url = 'https://restcountries.eu/rest/v2/all';
        $result = file_get_contents($url, false, $context);
        
        $new_country__list_with_code = array();
        $all_country_with_code  = json_decode($result);

        //echo "<pre>"; print_r($all_country_with_code);die;

        foreach ($all_country_with_code as $dbCountry) {
            $c_name = $dbCountry->name;
            $c_code = $dbCountry->alpha2Code;
            $c_std  = $dbCountry->callingCodes[0];
            if(!empty($c_code)) $new_country__list_with_code[$c_code] = array($c_name, $c_std);
        }
        return $new_country__list_with_code;
    }
    
    /*___________= Fetch All  =____________*/ 
    public function getSolaceContryList(){ 
        
        $context = stream_context_create(array(
            'http' => array(
            'method' => 'GET',
            'header' => "Authorization: kJAb389lKansm6259ankjaKAj0308Knam38hGBBAVavqke581lasmWowiq71891cnmBajhaiqo8260uHGASCvvbnqInmNIq1092",
            )
        ));
        $url = 'https://beta.solacesecure.co.uk/api/countries';
        $result = file_get_contents($url, false, $context);
        return $result;
    }


    /*___________= Set privacyPolicy / termsCondition Info | Solace =____________*/ 
    public function countryAlerts($countryname, $limit){ 
        
        $context = stream_context_create(array(
            'http' => array(
            'method' => 'GET',
            'header' => "Authorization: kJAb389lKansm6259ankjaKAj0308Knam38hGBBAVavqke581lasmWowiq71891cnmBajhaiqo8260uHGASCvvbnqInmNIq1092",
            )
        ));
        //$url = 'https://beta.solacesecure.co.uk/api/alerts?limit=100&countryName=All';
        $url    = 'https://beta.solacesecure.co.uk/api/alerts?limit='.$limit.'&countryName='.$countryname;
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result);
        if(empty($result)){
            return 0 ;
        }else{
            return $result;
        }
    }

    /*___________= Set privacyPolicy / termsCondition Info =____________*/ 
    public function get_usersRecordWithTokens(){ 
        $plateforms_array = array('apk','ios');
        /* $query = $this->db
                      ->select('t1.email, t1.country, t2.last_push_time, t2.dev_id AS devtoken, t2.dev_plateform AS plateform, t2.push_certificate AS certificate, t2.pushapi_token AS pushtoken')
                      ->from('tbl_travel_users t1')
                      ->where_in('t2.dev_plateform', $plateforms_array)
                      //->where('t2.email','d@gmail.com')
                      ->join("tbl_app_session t2","t2.email = t1.email",'right')
                      ->get();
        */
        $query = $this->db
                      ->select('email, country, last_push_time, push_count, dev_id AS devtoken, dev_plateform AS plateform, push_certificate AS certificate, pushapi_token AS pushtoken')
                      ->from('tbl_app_session')
                      ->where_in('dev_plateform', $plateforms_array)
                      //->where('t2.email','d@gmail.com')
                      ->get();
                      
        $data = $query->result_array();
        return $data;
        
    }

    /*___________= Set privacyPolicy / termsCondition Info =____________*/ 
    public function get_usersRecordWithTokens_plateformWise($userArray){ 
        //$userArray = $this->get_usersRecordWithTokens();
        $newArray  = array();
        $apkArray = array();
        $iosArray = array();
        foreach($userArray AS $row){
            if($row['plateform'] == 'ios'){
                array_push($iosArray, $row);
            }
            if($row['plateform'] == 'apk'){
                array_push($apkArray, $row);
            }
        }

        return array('apk'=>$apkArray, 'ios'=>$iosArray);
    }


    /*___________= Find distinct country list of user data  =____________*/ 
    public function get_all_distinct_countries_from_usersdata($user_array){ 
        $distinct_countries = [];
        foreach($user_array as $row) {
            array_push($distinct_countries, ucfirst($row['country']));
        }
        return array_unique($distinct_countries);
    }


    /*___________= Find distinct country list of user data  =____________*/ 
    public function get_countrywise_users($users_array, $countryname){ 
        //echo "<pre>";print_r($users_array);echo "<hr/>";
        $temp_array = array();
        $country_userlist = [];
        foreach($users_array as $row) {
            $user_country = ucfirst($row['country']);
            if($user_country === $countryname){
                $indata = array('email'=>$row['email'], 'push_count'=>$row['push_count'], 'certificate'=>$row['certificate'],'token'=>$row['pushtoken'], 'dev_type'=>$row['plateform'], 'pushtime'=>$row['last_push_time']);
                array_push($country_userlist, $indata);
            }            
        }
        return $country_userlist;
    }

    /*___________= Update Last Push Time  =____________*/ 
    public function setPushTime($devicetoken,$upTime){ 
        $data=array('last_push_time'=>$upTime, 'last_cron_time'=>date('Y-m-d H:i:s'));
        $this->db->where('pushapi_token',$devicetoken);
        $this->db->update('tbl_app_session',$data);
    }

    /*___________= Update Last Push Time  =____________*/ 
    public function setPushCountTimeUpdated($devicetoken,$upTime, $badgeCount){ 
        $data=array('push_count'=>$badgeCount, 'last_push_time'=>$upTime, 'last_cron_time'=>date('Y-m-d H:i:s'));
        $this->db->where('pushapi_token',$devicetoken);
        $this->db->update('tbl_app_session',$data);
    }

    /*___________= Update Country Code   =____________*/ 
    public function setCountryStdcode($countrycode,$stdcode){ 
       if(isset($stdcode) && isset($countrycode)){
            $data=array('stdcode'=>$stdcode);
            $this->db->where('countrycode',$countrycode);
            $this->db->update('tbl_travel_countrylist',$data);
            return true;   
        }else{
            return false;
        }
    }





















    /*______________ MANAGAE USERS  __________________*/
    public function usersCount(){
        $query = $this->db->where_in('active',array(0,1,2))->where('usertype','user');
//        if($this->getSearchData() != ''){
//           $query = $this->db->like('LOWER(driverName)',$this->getSearchData(),'both');
//        }        
        $count = $this->db->get('tbl_travel_users')->num_rows();
        return $count;
    }
    
    /*____________= Get All Users =_____________*/
    public function getAllUsers($from='',$perPage='') {
        $data = array();
        $query = $this->db->select('*')->from('tbl_travel_users');
                
        if($this->getSearchData() != ''){
            $query = $this->db->like('LOWER(fname)',$this->getSearchData(),'both');
        }
        $query = $this->db->order_by('fname','DESC')
                ->where_in('active',array(0,1,2))
                ->limit($from,$perPage)
                            
                            ->get();
        //echo $this->db->last_query();exit;
        if($query->num_rows() > 0){
            $data = $query->result_array();
        }
        return $data; 
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
    
    
    public function getAllCountries($from='',$perPage='') {
        $data = array();
        $query = $this->db->select('*')->from('tbl_travel_countrylist');
                
        if($this->getSearchData() != ''){
            $query = $this->db->like('LOWER(countryname)',$this->getSearchData(),'both');
        }
        $query = $this->db->order_by('id','ASC')
                ->where_in('active',array(0,1))
                ->limit($from,$perPage)
                            
                            ->get();
        //echo $this->db->last_query();exit;
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
        $query = $this->db->where_in('active',array(0,1));
        if($this->getSearchData() != ''){
          $query = $this->db->like('LOWER(countryname)',$this->getSearchData(),'both');
       }        
        $count = $this->db->get('tbl_push_healthinfo')->num_rows();
        return $count;
    }
    
    public function getAllhealthDetails($from='',$perPage='') { 
        $data = array();
        $query = $this->db->select('tbl_push_healthinfo.*,tbl_travel_countrylist.countryname,tbl_travel_countrylist.countrycode');
        $query = $this->db->from('tbl_push_healthinfo');
                
        if($this->getSearchData() != ''){
            $query = $this->db->like('LOWER(countryname)',$this->getSearchData(),'both'); // LOWER(countryname)
        }
        $query = $this->db->order_by('date(createdon)','desc')
                ->where_in('tbl_push_healthinfo.active',array(1,2))
                ->join('tbl_travel_countrylist', 'tbl_push_healthinfo.cid = tbl_travel_countrylist.id', 'left outer')
                ->limit($from,$perPage)
                ->get();
        //echo $this->db->last_query();exit;
        //echo "<pre>";print_r($query->row());die;
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
        //echo $this->db->last_query();exit;
        //echo "<pre>";print_r($query->row());die;
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
    
    /*___________= Get privacyPolicy / termsCondition Info =____________*/ 
    public function getPrivacyTermsCondition() { 
        $data  = array();
        $query = $this->db->select('*')
                          ->where('uid','1')
                          ->from('tbl_travel_privacyterm')
                          ->get();
        //echo $this->db->last_query();
        //echo "<pre>";print_r($query->row());die;
        if($query->num_rows() > 0){
            $data = $query->result_array()[0];
        }
        return $data; 
    }
    
    /*___________= Set privacyPolicy / termsCondition Info =____________*/ 
    public function setPrivacyTermsCondition($termsPrivacyID, $upData) { 
        $this->db->where('id',$termsPrivacyID);        
        $this->db->update('tbl_travel_privacyterm',$upData);
        //echo $this->db->last_query();
        //echo "SAfsfsdsadasdasfsdf";die;
        $data = $this->db->affected_rows();
        return $data;
    }
    
    
    
    
    /*___________= Set privacyPolicy / termsCondition Info =____________*/ 
    public function updateCountriesList($updateData) { 
        
        $countriesBySolace = $this->GetSolaceContryList();
        $all_countries     = json_decode($countriesBySolace, TRUE);        
        $solace_countries  = array();
        foreach($all_countries as $row){
            $temp_country = $row['countryName'];
            $solace_countries[$temp_country]['latitude']  = $row['latitude'];
            $solace_countries[$temp_country]['longitude'] = $row['longitude'];;
        }        
        if(isset($updateData[1])){
            $res = $this->db->empty_table('tbl_travel_countrylist');
            foreach($updateData as $row) {
                $temp_cntry = $row['name'];$lattitude = $longitude  ="";
                if(isset($solace_countries[$temp_cntry])){
                    $lattitude = $solace_countries[$temp_cntry]['latitude'];
                    $longitude = $solace_countries[$temp_cntry]['longitude'];
                }
                $rowArr = array(
                    'countryname' => $row['name'], 
                    'countrycode' => $row['code'],
                    'countrykey'  => $row['key'],
                    'lattitude'   => $lattitude,
                    'longitude'   => $longitude,
                    'active'      => 1

                );
                $this->db->insert('tbl_travel_countrylist', $rowArr);
            }
           
            return TRUE;
            
        }
            return 0;
    }

    /*___________= Set privacyPolicy / termsCondition Info =____________*/ 
    /*public function updateCountriesCodeList($updateData) { 
        
        $countriesBySolace = $this->GetSolaceContryList();
        $all_countries     = json_decode($countriesBySolace, TRUE);        
        $solace_countries  = array();
        foreach($all_countries as $row){
            $temp_country = $row['countryName'];
            $solace_countries[$temp_country]['latitude']  = $row['latitude'];
            $solace_countries[$temp_country]['longitude'] = $row['longitude'];;
        }        
        if(isset($updateData[1])){
            $res = $this->db->empty_table('tbl_travel_countrylist');
            foreach($updateData as $row) {
                $temp_cntry = $row['name'];$lattitude = $longitude  ="";
                if(isset($solace_countries[$temp_cntry])){
                    $lattitude = $solace_countries[$temp_cntry]['latitude'];
                    $longitude = $solace_countries[$temp_cntry]['longitude'];
                }
                $rowArr = array(
                    'countryname' => $row['name'], 
                    'countrycode' => $row['code'],
                    'countrykey'  => $row['key'],
                    'lattitude'   => $lattitude,
                    'longitude'   => $longitude,
                    'active'      => 1

                );
                $this->db->insert('tbl_travel_countrylist', $rowArr);
            }
           
            return TRUE;
            
        }
            return 0;
    }*/



    
 
    
}
?>