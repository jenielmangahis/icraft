<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class User extends MX_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('Driver_model');
        $this->load->model('Manager_model');
        $this->load->library('S3');
//        if($this->session->userdata('id') == ''){
//            redirect('login');
//        }else{
//            
//        }
    }
    
    
    /*
     * Delete User section in the admin panel
     * @niraj kumar 
     * @functionName manageCategory
     * @access Public
     * @return string as TRUE or False
     * @return $data
     */
    /*_______________= Manage Users =____________*/
    public function manageUsers(){ 
        
        $manager_model = new Manager_model();
        
        if($this->input->get('searchText') != ''){ 
            $manager_model->setSearchData(strtolower(trim($this->input->get('searchText'))));
        }
        
        $totalPage      = $manager_model->usersCount();
        $baseUrl        = base_url() ."manageUsers";
        $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
        if($this->input->get('all') != ''){ 
            $all = true;
            $data['result'] = $manager_model->getAllUsers(RECORDS_PERPAGE,$pageFrom,$all);
        }elseif($this->input->get('searchText') != ''){
            $all = true;
            $data['result'] = $manager_model->getAllUsers(RECORDS_PERPAGE,$pageFrom,$all);
        }
        else{
            $data['result'] = $manager_model->getAllUsers(RECORDS_PERPAGE,$pageFrom);
        }
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content']   = array('view' => 'usersDetails', 'data' => $data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*_______________= Manage Countries =____________*/
    public function manageCountries(){ 
        $manager_model = new Manager_model();
        //-- If PostData Then Insert New Country
        $resData = "";
        if(isset($_POST['cname']) && isset($_POST['ccode']) && isset($_POST['csecretkey'])){
            $country_name = $this->input->post("cname");
            $country_code = $this->input->post("ccode");
            $country_key  = $this->input->post("csecretkey");
            $manager_model = new Manager_model();
            
            $resData = $manager_model->addNewCntry($country_name, $country_code, $country_key);
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Invalid entry, country name/code/secret key already exist.')</script>";
            }else{
                echo "<script type='text/javascript'>alert('A new country has been successfully added.')</script>";
            }
            
        }
        
        //-- IF SEARCH STRING EXISTS
        if($this->input->get('searchText') != ''){ 
            $manager_model->setSearchData(strtolower(trim($this->input->get('searchText'))));
        }
        
        $totalPage      = $manager_model->countriesCount();
        $baseUrl        = base_url() ."manageCountries";
        $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
        if($this->input->get('all') != ''){ 
            $all = true;
            $data['result'] = $manager_model->getAllCountries(RECORDS_PERPAGE,$pageFrom,$all);
        }elseif($this->input->get('searchText') != ''){
            $all = true;
            $data['result'] = $manager_model->getAllCountries(RECORDS_PERPAGE,$pageFrom,$all);
        }
        else{
            $data['result'] = $manager_model->getAllCountries(RECORDS_PERPAGE,$pageFrom);
        }
        //print_r($data['result']);die;
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content']   = array('view' => 'countriesDetails', 'data' => $data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);

    }
    
    
    /*_______________= Manage Numbers =____________*/
    public function manageNumbers(){ 
        
        $manager_model = new Manager_model();
        //-- If PostData Then Insert New Country
        $resData = "";
        //if(isset($_POST['doctorno']) && isset($_POST['assistanceno']) && isset($_POST['claimno']) && isset($_POST['supportno']) && isset($_POST['link'])){
        if($this->input->post('doctorno',true) && $this->input->post('assistanceno',true) && $this->input->post('claimno',true) && $this->input->post('supportno',true) && $this->input->post('link',true)){
            // echo "<hr/>";print_r($_POST);echo "<hr/>";die;
            $update_cid = '1';
            
            $upData = array(
                'doctor'    => str_replace(' ','',$this->input->post('doctorno')),
                'assistance'=> str_replace(' ','',$this->input->post('assistanceno')),
                'claim'     => str_replace(' ','',$this->input->post('claimno')),
                'support'   => str_replace(' ','',$this->input->post('supportno')),
                'weblink'   => str_replace(' ','',$this->input->post('link')),
                'active'    => 1
            );
            
            $resData = $manager_model->UpdateAllCountacts($update_cid, $upData);
            echo "<script type='text/javascript'>alert('All contacts has been successfully updated.')</script>";
        }
        $getContact_cid = '1';
        $data['result'] = $manager_model->getAllContacts($getContact_cid);
        //print_r($data['result']);die;
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $data);
            $data['main_content']   = array('view' => 'numbersDetails', 'data' => $data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
        

    }
    
    /*_______________= Manage Health Info Push Details =____________*/
    public function healthDetails(){ 
        $manager_model = new Manager_model();
        if($this->input->get('searchText') != ''){ 
            $manager_model->setSearchData(strtolower(trim($this->input->get('searchText'))));
        }
        
        
        
        $totalPage      = $manager_model->healthInfoCount();
        $baseUrl        = base_url() ."healthDetails";
        $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
        if($this->input->get('all') != ''){ 
            $all = true;
            $data['result'] = $manager_model->getAllhealthDetails(RECORDS_PERPAGE,$pageFrom,$all);
        }elseif($this->input->get('searchText') != ''){
            $all = true;
            $data['result'] = $manager_model->getAllhealthDetails(RECORDS_PERPAGE,$pageFrom,$all);
        }
        else{
            $data['result'] = $manager_model->getAllhealthDetails(RECORDS_PERPAGE,$pageFrom);
        }
        
        //print_r($data['result']);die;
        $data['header']           = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']          = array('view' => 'templates/common_sidebar', 'data' => $data);
            $data['main_content'] = array('view' => 'healthDetails', 'data' => $data);
        $data['footer']           = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }       
    
    /*_______________= Terms & Condition Details =____________*/
    public function termsDetails(){ 
        
        $manager_model = new Manager_model();   
        $resData = "";
        if($this->input->post('termCondtion',true) && $this->input->post('tpid',true) ){
            $upData = array('terms_condition' => $this->input->post('termCondtion'));
            $resData = $manager_model->setPrivacyTermsCondition($this->input->post('tpid'), $upData);
            echo "<script type='text/javascript'>alert('All Term & Condtion has been successfully updated.')</script>";
        }
        
        $data['result']      = $manager_model->getPrivacyTermsCondition();
        $data['header']      = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']     = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content']= array('view' => 'termsDetails', 'data' => $data);
        $data['footer']      = array('view' => 'templates/footer', 'data' => $data);
        
        $this->load->view('templates/common_template', $data);
    }
    
    
    /*_______________= Privacy Policy Details =____________*/
    public function privacyDetails(){ 
         
        $manager_model = new Manager_model();   
        $resData = "";
        if($this->input->post('privacyPolicy',true) && $this->input->post('tpid',true) ){
            $upData = array('privacy_policy' => $this->input->post('privacyPolicy'));
            $resData = $manager_model->setPrivacyTermsCondition($this->input->post('tpid'), $upData);
            echo "<script type='text/javascript'>alert('All Privacy Policy has been successfully updated.')</script>";
        }
        
        $data['result']      = $manager_model->getPrivacyTermsCondition();
        $data['header']      = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']     = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content']= array('view' => 'privacyDetails', 'data' => $data);
        $data['footer']      = array('view' => 'templates/footer', 'data' => $data);
        
        $this->load->view('templates/common_template', $data);      
    }
    
    
    /*_________________= Block/Activate Users  =__________________*/
    public function activeDeactiveUser(){  
        $manager_model = new Manager_model();
        $status = $this->uri->segment('2');
        $userId = $this->uri->segment('3');
        $data = $manager_model->setUserStatus($status,$userId);
        
        if($data){
            redirect('manageUsers');
        }else{
            echo "something went wrong ";
        }
    }
    
    /*_________________= Block/Activate Users  =__________________*/
    public function activeDeactiveUserParticular(){
        $manager_model = new Manager_model();
        $status = $this->uri->segment('3');
        $userId = $this->uri->segment('4'); 
        
        $data = $manager_model->setUserStatus($status,$userId);
        $returnUrl = 'userDetail/'.$userId;
        if($data){
            redirect($returnUrl);
        }else{
            echo "something went wrong ";
        }
    }
    
    
    /*_____________= User Detail Page =____________*/
    public function UserDetailPage(){
        $manager_model = new Manager_model();
        $userId = $this->uri->segment('2');
        $data['result'] = $manager_model->getUserDetails($userId);
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']         = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content']   = array('view' => 'personalUserDetails', 'data' => $data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*_________________= Delete Users  =__________________*/ 
    public function UserDel4mTbl(){
        $manager_model = new Manager_model();
        $userId = $this->uri->segment('2'); 
        
        $data = $manager_model->setUserDel($userId);
        if($data){
            redirect('manageUsers');
        }else{
            echo "something went wrong ";
        }
    }
    
    /*_________________= Add New Country =__________________*/
    public function addNewCountry(){ // use it for api service
        print_r($_POST);die;
        if($this->input->post("cname",TRUE) && $this->input->post("cname",true) && $this->input->post("cname", true) ){
            $country_name = $this->input->post("cname");
            $country_code = $this->input->post("ccode");
            $country_key  = $this->input->post("csecretkey");
            $manager_model = new Manager_model();

            $data = $manager_model->addNewCntry($country_name, $country_code, $country_key);
            if($data){
                redirect('manageCountries');
            }else{
                echo "something went wrong ";
            }
        }else{
             echo "something went wrong ";
        }
            
    }
    
    /*_____________= User Detail Page =____________*/
    public function editCountryPage(){
        $manager_model = new Manager_model();
        
        
        if($this->uri->segment('2') != Null && $this->uri->segment('2') !=''){
            $countryId = $this->uri->segment('2'); 
            
            //-- If PostData Then Insert New Country
            $resData = "";
            if(isset($_POST['cname']) && isset($_POST['ccode']) && isset($_POST['csecretkey'])){
                $country_name = $this->input->post("cname");
                $country_code = $this->input->post("ccode");
                $country_key  = $this->input->post("csecretkey");

                $resData = $manager_model->updateCountry($countryId, $country_name, $country_code, $country_key);
                if($resData == '-1'){
                    echo "<script type='text/javascript'>alert('Invalid Update, Country name/code/secret  already exist.')</script>";
                }else{
                    echo "<script type='text/javascript'>alert('Country record has been successfully updated.')</script>";
                }
            }


            $data['result'] = $manager_model->getCountryDetail($countryId);
            $data['header']         = array('view' => 'templates/header', 'data' => $data);
            $data['sidebar']         = array('view' => 'templates/common_sidebar', 'data' => $data);
            $data['main_content']   = array('view' => 'editCountry_page', 'data' => $data);
            $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data);
        }else{
            echo "<script type='text/javascript'>alert('Something went wrong !.');history.go(-1);</script>";
        }
            
    }
    
    /*_________________= Delete Users  =__________________*/ 
    public function deleteCountryPage(){
        $manager_model = new Manager_model();
        $countryId = $this->uri->segment('2'); 

        $data = $manager_model->setCountryDel($countryId);
        if($data){
            redirect('manageCountries');
        }else{
            echo "something went wrong ";
        }
    }
    
    
    /*_____________= User Detail Page =____________*/
    public function editHealthInfoPage(){
        $manager_model = new Manager_model();
        
        if($this->uri->segment('2') != Null && $this->uri->segment('2') !=''){
            $healthId = $this->uri->segment('2'); 
            
            //-- If PostData Then Insert New Country
            $resData = "";            
            if($this->input->post('headline') && $this->input->post('content')){
                $udateHealthData = array(
                   'headline' => $this->input->post('headline'),
                   'body'     => $this->input->post('content')
                );
                
                $resData = $manager_model->updateHealthInfo($healthId, $udateHealthData);
                echo "<script type='text/javascript'>alert('Country record has been successfully updated.')</script>";
            }


            $data['result'] = $manager_model->getHealthDetailParticular($healthId)[0];
            //  echo "<pre>";print_r($data['result']);die;
            $data['header']         = array('view' => 'templates/header', 'data' => $data);
            $data['sidebar']         = array('view' => 'templates/common_sidebar', 'data' => $data);
            $data['main_content']   = array('view' => 'editHealthInfo_page', 'data' => $data);
            $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data);

        }else{
            echo "<script type='text/javascript'>alert('Something went wrong !.');history.go(-1);</script>";
        }
            
    }
    
    
    /*_________________= Delete Health Info Particular  =__________________*/ 
    public function deleteHealthInfoPage(){
        $manager_model = new Manager_model();
        $healthInfoId = $this->uri->segment('2'); 

        $data = $manager_model->setHealthInfoDel($healthInfoId);
        if($data){
            redirect('healthInfo');
        }else{
            echo "something went wrong ";
        }
    }
    
    /*_________________= Block/Activate Users  =__________________*/
    public function activeDeactiveHealthInfo(){  
        $manager_model = new Manager_model();
        $activeStatus  = $this->uri->segment('2');
        $hlthInfoId    = $this->uri->segment('3');
        //echo $activeStatus." - ".$hlthInfoId;die;
        $data = $manager_model->setHealthInfoStatus($activeStatus,$hlthInfoId);
        //print_r($data);die;
        if($data){
            redirect('healthInfo');
        }else{
            echo "something went wrong ";
        }
    
    }
    
    
    /*_____________= User Detail Page =____________*/ 
    public function addHealthInfo(){
        $manager_model = new Manager_model();
        //-- If PostData Then Insert New Country
        $resData = "";         
        if(isset($_POST['healthHeadline']) && isset($_POST['healthCountry']) && isset($_POST['healthContent'])){
            //print_r($_POST);die;
            $health_hline = $this->input->post("healthHeadline");
            $country_id   = $this->input->post("healthCountry");
            $health_body  = $this->input->post("healthContent");

            $resData = $manager_model->addNewHealthInfo( $country_id,$health_hline, $health_body);
            if($resData == '1'){
                echo "<script type='text/javascript'>alert('Health Info record has been successfully added')</script>";
            }
        }

        $data['result'] = $manager_model->getAllCountriesList();
        
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content']   = array('view' => 'newHealthinfo', 'data' => $data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);  
    }

    
    /*_____________= Read csv file for all Countries =____________*/ 
    public function readCsv($path='')
    {
        if($path != ''){
            $this->load->library('csvreader');
            return $this->csvreader->parse_file('./'.$path);
        }
        return 0;
    }
    
    
    public function updateCountrieFromCsv()
    {
            $listArr = $this->readCsv('./assets/admin/CountryList.csv');
            if($listArr){
                $manager_model = new Manager_model();
                $manager_model->updateCountriesList($listArr);
            }
            return 0;                
        
    }   






    
    public function editOldAdvert(){
        $driverObj = new Driver_model();
        $data = array();

        
        
            if (!empty($_FILES['bIcon']['name'])) { 
                if ($_FILES['bIcon']['error'] == 0) {
                    
                    $bIcon=time().$_FILES["bIcon"]['name'];
                    $fileTempName=$_FILES["bIcon"]['tmp_name'];

                    if($this->s3->putObjectFile($fileTempName,"taxinew",'brandIcon/'.$bIcon, $this->s3->ACL_PUBLIC_READ)) {
                        $furl = "https://s3-us-west-2.amazonaws.com/taxinew/brandIcon".$bIcon;
                        $bIcon = "https://s3.amazonaws.com/taxinew/brandIcon/".$bIcon;
                    }

 
                }
            }else{
                 $bIcon = $_POST['bIcon'];
            }
            if (!empty($_FILES['cIcon']['name'])) { 
                if ($_FILES['cIcon']['error'] == 0) {
                    
                    $cIcon=time().$_FILES["cIcon"]['name'];
                    $fileTempNameC=$_FILES["cIcon"]['tmp_name'];

                    if($this->s3->putObjectFile($fileTempNameC,"taxinew","cardIcon/".$cIcon, $this->s3->ACL_PUBLIC_READ)) {
                        $furl = "https://s3-us-west-2.amazonaws.com/taxinew/cardIcon/".$cIcon;
                        $cIcon = "https://s3.amazonaws.com/taxinew/cardIcon/".$cIcon;
                    }
                }
            }else{
                 $cIcon = $_POST['cIcon'];
            }
            if (!empty($_FILES['fIcon']['name'])) { 
                if ($_FILES['fIcon']['error'] == 0) {
                    $fIcon=time().$_FILES["fIcon"]['name'];
                    $fileTempNamef=$_FILES["fIcon"]['tmp_name'];

                    if($this->s3->putObjectFile($fileTempNamef,"taxinew","fullSizeImage/".$fIcon, $this->s3->ACL_PUBLIC_READ)) {
                        $furl = "https://s3-us-west-2.amazonaws.com/taxinew/fullSizeImage/".$fIcon;
                        $fIcon = "https://s3.amazonaws.com/taxinew/fullSizeImage/".$fIcon;
                    }
                }
            }else{
                 $fIcon = $_POST['fIcon'];
            }
            
            $advertName = $_POST['advertName'];
            $selectCategory = $_POST['selectCategory'];
            $description = $_POST['description'];
            $address = $_POST['addressLoc'];
            $advertLat = $_POST['advertLat'];
            $advertLong = $_POST['advertLong'];
            $publishedOn = $_POST['publishedOn'];//to be changed as per column type
            $expiredOn = $_POST['expiredOn'];//to be changed as per column type

            $advertDetails = array(
                'brandIcon'=>$bIcon,
                'cardIcon'=>$cIcon,
                'fullSizeImage'=>$fIcon,
                'advertName'=>$advertName,
                'categoryId'=>$selectCategory,
                'description'=>$description,
                'address'=>$address,
                'latitude'=>$advertLat,
                'longitude'=>$advertLong,
                'publishedOn'=>date("Y-m-d H:i:s",strtotime($publishedOn)),
                'expiredOn'=>date("Y-m-d H:i:s",strtotime($expiredOn))
                
                );
            
            $advertisementId = $_POST['advertisementId'];
            $data = $driverObj->updateAdvert($advertDetails,$advertisementId);
            if($data){
                redirect('manageAds');
            }else{
                echo "Something has went wrong";
            }
            
    }
    
    
    
    
    
}

