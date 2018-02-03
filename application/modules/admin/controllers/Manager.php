<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Manager extends MX_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('Manager_model'); 
        $this->load->model('Prescription_model');
        $this->load->model('Driver_inventory_model');
        $this->load->model('Order_model');
        $this->load->model('User_coupons_model');
        $this->load->model('Customer_model');
        $this->load->model('Appointment_model');
        $this->load->helper('order_helper');
    }
    

    /*
     * Admin Dashboard Section
     * @author : niraj
     * @admin panel 
     * @function for : shows dashboard view with all analised data
     */
    public function dashboard(){
        if ( is_null(sessionChk()) )                        //-- Validating session
        {
            redirect(base_url().'admin');
        }
        $manager_model = new Manager_model();//-- Model Object 
        //-- if search by data range
        if($this->input->post('sdate') != '' && $this->input->post('edate') != ''){ 
            $manager_model->set_sdate($this->input->post('sdate'));
            $manager_model->set_edate($this->input->post('edate')); 
        }
        //-- All Dashboard Boxes Data retirieve
        $data['result'] = $manager_model->analised_data_for_dashboard();
        //echo "<pre>";print_r($data['result']);die;
        $data['title']          = 'Dashboard';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content']   = array('view' => 'dashboard/admin_dashboard', 'data' => $data['result']);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /************************
     *     ORDER SECTION    *
     * **********************/
    
    /* Admin Dashboard Section
     * @author : niraj
     * @admin panel 
     * @function for : shows dashboard view with all analised data
     */
    public function orders(){ 
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- if search by data range
        if($this->input->post('sdate') != '' && $this->input->post('edate') != ''){ 
            $manager_model->set_sdate($this->input->post('sdate'));
            $manager_model->set_edate($this->input->post('edate')); 
        }
        
        //-- IF SEARCH TEXT EXIST 
        if($this->input->post('searchText') != ''){ 
            $manager_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
        }
        
        if($this->input->post('orderStatus') != ''){ 
            $manager_model->setSearchStatus($this->input->post('orderStatus'));
        }
        
        if($this->input->post('driver') != ''){ 
            $manager_model->setSearchDriver(strtolower(trim($this->input->post('driver'))));
        }
        
        if($this->input->post('location') != ''){ 
            $manager_model->setSearchLocation(strtolower(trim($this->input->post('location'))));
        }

        $totalPage      = $manager_model->ordersCount();
        $baseUrl        = base_url() ."orders";
        $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);

        //echo $totalPage;die;
        if($this->input->get('all') != ''){ 
            $all = true;
            $data['result'] = $manager_model->getAllOrders(RECORDS_PERPAGE,$pageFrom,$all);
        }elseif($this->input->get('searchText') != ''){
            $all = false;
            $data['result'] = $manager_model->getAllOrders(RECORDS_PERPAGE,$pageFrom,$all);
        }
        else{
            $data['result'] = $manager_model->getAllOrders(RECORDS_PERPAGE,$pageFrom,false);
        }
        $data['drivers']   = $manager_model->driversdetails(); 
        $data['locations'] = $manager_model->ordersLocationsdetails(); 
        $body_data = array('drivers'=>$data['drivers'],'drivers'=>$data['locations']);
        
        //echo "<pre>"; print_r($this->db->last_query());die;
        // echo "<pre>";print_r($data['locations']);die;
        $data['title']          = 'Orders Detail';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content']   = array('view' => 'orders/admin_orders', 'data' => $body_data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /* Order Module : Admin Dashboard Section
     * @author : niraj
     * @admin panel 
     * @function for : View/Edit Section 
     */    
    public function order_detail()
    {    
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        $driverInvetoryModel = new Driver_inventory_model();
        $customerObj = new Customer_model();
        $orderModel = new Order_model();

        if($this->uri->segment('2')){
           $manager_model->set_customid($this->uri->segment('2')); //-- Order Id 
           $orderInfo = $manager_model->fetchOrderdetails($this->uri->segment('2'));
           $customerObj->set_customer_id($orderInfo['uid']);

            $body['orderinfo'] = $orderInfo;
            $orderModel->setOrder_id($orderInfo['oid']);
            $body['orderItemInfo'] = $orderModel->selectOrderItemDetails();
            $body['is_verified'] = $manager_model->check_verfied_user($this->uri->segment('2'));
            $body['is_first_time'] = $manager_model->check_first_time($this->uri->segment('2'));
            $body['prescription'] = $customerObj->prescription();
            $body['personalDetail'] = $customerObj->viewCustomerData();

            if($orderInfo['did']>0)
            {
                // calculate the distance
                $distanceAndDuration = getDistanceAndDuration($orderInfo['driver_slat'], $orderInfo['driver_slang'], $orderInfo['drop_location_lat'], $orderInfo['drop_location_lang']);

                $driverInvetoryModel->setDriver_id($orderInfo['did']);
                $driverInvetoryModel->setOrder_id($orderInfo['oid']);
                $isPickup = $driverInvetoryModel->checkDiverInvetoryAgainstOrder();
                $body['isPickup'] = $isPickup;
                $body['distance_maps'] = $distanceAndDuration;
            }
            else
            {
                $body['isPickup'] = FALSE;
            }

            if(isset($body['orderinfo']) && count(['orderinfo']) > 0 ){
                //-- Update Doctor If Post Data )
                if(isset($_POST['did']) && isset($_POST['oid']) && isset($_POST['dtype'])  && isset($_POST['from_time'])){ 
                    // $check_mail    = $manager_model->chkUserEmail('users');
                    // $check_userid  = $manager_model->chkUserId('users');
                    //- Assign Order 
                    
                    $manager_model->set_orderType($this->input->post("dtype")); // Set Order Id 
                    $manager_model->set_orderid($this->input->post("oid")); // Set Order Id 
                    $manager_model->set_driverid($this->input->post("did")); // Set Driver Id 
                    $this->input->post("schedule_date") ? $manager_model->set_sdate($this->input->post("schedule_date")) : $manager_model->set_sdate('0000-00-00'); // Set Driver Id 
                    $manager_model->set_stime($this->input->post("from_time")); // Set Driver Id 
                    
                    $resData = $manager_model->assignDriver($body['orderinfo']);
                    if($resData == '-1'){
                        echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                    }else{

                        echo "<script type='text/javascript'>alert('Driver has been assigned successfully.')</script>";  
                        
                    } 
                }

                //echo "<pre>";print_r($body['orderinfo']);die;
                $data['title']          = 'Order Detail';
                $data['header']         = array('view' => 'templates/header', 'data' => $data);
                $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
                $data['main_content']   = array('view' => 'orders/order_detail');
                $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
                $this->load->view('templates/common_template', $data);
            }else{
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('orders','refresh');
            }
        }else{
            redirect('orders','refresh');
        }    
    }
    
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Ajax for Appointment User Info Doctor  
     */
    /*_____________= User Detail Page =____________*/
    public function fetch_drivers_list(){
         
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST
        $drivers  = $manager_model->fetchAllDrivers();   
        $list = '<select class="form-control" id="did" name="did">';
        $list .= '<option value="">Choose any Driver</option>';
        foreach ($drivers AS $driver){
            $list .= '<option value="'.$driver['driver_id'].'" data-location="'.$driver['latitude'].','.$driver['longitude'].'">'.ucfirst($driver['first_name']).' '.ucfirst($driver['last_name']).'</option>';
        }
        $list .= '</select ><span id="did-error" class="help-block hide"></span>';
        echo $list;
    }
    
    
    /****************************
     *     CARE GIVERS SECTION  *
     * **************************/
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Care Givers List 
     */
    public function care_givers(){ 
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
        if($this->input->post('searchText') != ''){ 
            $manager_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
        }
        
        if($this->input->post('doctorStatus') != ''){ 
            $manager_model->setSearchStatus($this->input->post('doctorStatus'));
        }

        $totalPage      = $manager_model->careGiversCount();
        //echo $this->db->last_query(); echo "<br>".$totalPage;die;
        $baseUrl        = base_url() ."doctors";
        $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
        //echo $totalPage;die;
        if($this->input->post('all') != ''){ 
            $all = true;
            $body['result'] = $manager_model->getAllCareGivers(RECORDS_PERPAGE,$pageFrom,$all);
        }elseif($this->input->post('searchText') != ''){
            $all = false;
            $body['result'] = $manager_model->getAllCareGivers(RECORDS_PERPAGE,$pageFrom,$all);
        }
        else{
            $body['result'] = $manager_model->getAllCareGivers(RECORDS_PERPAGE,$pageFrom,false);
        }

        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Care Givers List';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'caregivers/admin_care_givers', 'data' => $body_data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Care Givers List 
     */  
    public function add_care_giver()
    {    
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        // fullname, email, contact, designee, idetityno, city ,state ,country ,zip
        if( isset($_FILES['profile_pic']) && $this->input->post('fullname') && $this->input->post('email')&& $this->input->post('contact') &&  $this->input->post('designee') && $this->input->post('idetityno') && $this->input->post('city') && $this->input->post('state') && $this->input->post('country') && $this->input->post('zip') )
        { 
            echo "<pre>";
            $pic_url = $file3 = '';
            $manager_model->set_email(trim($this->input->post("email")));
            $check_mail = $manager_model->chkUserEmail('caregiver_details');

            if(!isset($check_mail['email'])){
                //- Uploading Profile Pic 
                if(isset($_FILES['profile_pic'])){
                    $file_size = $_FILES['profile_pic']['size'];
                    $file_tmp  = $_FILES['profile_pic']['tmp_name'];
                    $file_type = $_FILES['profile_pic']['type'];
                    $file_name = strtolower(array_shift(explode('.',$_FILES['profile_pic']['name'])));
                    $file_ext  = strtolower(end(explode('.',$_FILES['profile_pic']['name'])));
                    $expensions1= array("jpg", "jpeg","jpg","png");
                    $expensions2= array("pdf","doc","docx");
                    //echo "Profile pic Extension is $file_ext and Size is $file_size in byte<br/>";
                    if(in_array($file_ext,$expensions1)!== false){
                        $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                        $pic_url = uploadImageOnS3($filename,$file_tmp);
                    } 
                }
                //echo $pic_url;die;
                if($pic_url){
                    $manager_model->set_name(trim($this->input->post("fullname")));
                    $manager_model->set_email(trim($this->input->post("email")));
                    $manager_model->set_phone(trim($this->input->post("contact")));
                    $manager_model->set_designee(trim($this->input->post("designee")));
                    $manager_model->set_identityno(trim($this->input->post("idetityno")));
                    
                    $manager_model->set_picUrl(trim($pic_url));
                    $manager_model->set_city(trim($this->input->post("city")));
                    $manager_model->set_state(trim($this->input->post("state")));
                    $manager_model->set_country(trim($this->input->post("country")));
                    $manager_model->set_zipcode(trim($this->input->post("zip")));
                    
                    $resData = $manager_model->addNewCareGiver();
                    if($resData == '-1'){
                        echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                        redirect('care-givers','refresh');
                    }else{

                        echo "<script type='text/javascript'>alert('New Care Giver has been added successfully.')</script>";  
                        redirect('care-givers','refresh');
                    } 
                }
            }else{
                echo "<script type='text/javascript'>alert('Email id already exist.')</script>";  
            }

                
        }

        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Care Givers List';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'caregivers/add_care_giver', 'data' => $body_data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);  
    }
    
    
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : View / Edit Care Giver
     */  
    public function care_giver_details()
    {    
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        
        if($this->uri->segment('2')){
            $manager_model->set_customid($this->uri->segment('2')); //-- Order Id 
            $body['orderinfo'] = $manager_model->fetchOrderdetails($this->uri->segment('2'));
            $body['is_verified'] = $manager_model->check_verfied_user($this->uri->segment('2'));
            $body['is_first_time'] = $manager_model->check_first_time($this->uri->segment('2'));
//            echo "<pre>"; print_r($body['is_first_time']); die; 
            if(isset($body['orderinfo']) && count(['orderinfo']) > 0 ){
                //-- Update Doctor If Post Data )
                if(isset($_POST['did']) && isset($_POST['oid']) && isset($_POST['dtype'])  && isset($_POST['from_time'])){ 
                    // $check_mail    = $manager_model->chkUserEmail('users');
                    // $check_userid  = $manager_model->chkUserId('users');
                    //- Assign Order 
                    
                    $manager_model->set_orderType($this->input->post("dtype")); // Set Order Id 
                    $manager_model->set_orderid($this->input->post("oid")); // Set Order Id 
                    $manager_model->set_driverid($this->input->post("did")); // Set Driver Id 
                    $this->input->post("schedule_date") ? $manager_model->set_sdate($this->input->post("schedule_date")) : $manager_model->set_sdate('0000-00-00'); // Set Driver Id 
                    $manager_model->set_stime($this->input->post("from_time")); // Set Driver Id 
                    
                    $resData = $manager_model->assignDriver($body['orderinfo']);
                    //echo $this->db->last_query();die;
                    if($resData == '-1'){
                        echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                    }else{

                        echo "<script type='text/javascript'>alert('Doctor record has been updated successfully.')</script>";  
                    } 
                }

                echo"<pre>";print_r($body['result']);die;
                $data['title']          = 'Care Givers List';
                $data['header']         = array('view' => 'templates/header', 'data' => $data);
                $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
                $data['main_content']   = array('view' => 'caregivers/view_care_givers', 'data' => $body_data);
                $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
                $this->load->view('templates/common_template', $data);
            }else{
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('care-givers','refresh');
            }
        }else{
            redirect('care-givers','refresh');
        }
             
    }
    
    
    public function delete_care_giver_details(){
        
        if($this->uri->segment('2') !=''){
            $caregiverId = $this->uri->segment('2'); 
            $manager_model = new Manager_model();
            
            $manager_model->set_userid($caregiverId);
            $resData = $manager_model->delete_care_giver();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('care-givers','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Care giver has been deleted successfully.')</script>";
                redirect('care-givers','refresh');
            }
        }else{
            redirect('care-givers','refresh');
        }            
    
    }
    
    
    
    
    /************************
     *     DOCTORS SECTION    *
     * **********************/
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Doctor List & search
     */
    public function doctors(){ 
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
            if($this->input->post('searchText') != ''){ 
                $manager_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
            }
            
            if($this->input->post('doctorStatus') != ''){ 
                $manager_model->setSearchStatus($this->input->post('doctorStatus'));
            }

            $totalPage      = $manager_model->doctorsCount();
            //echo $this->db->last_query(); echo "<br>".$totalPage;die;
            $baseUrl        = base_url() ."doctors";
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
            if($this->input->post('all') != ''){ 
                $all = true;
                $body['result'] = $manager_model->getAllDoctors(RECORDS_PERPAGE,$pageFrom,$all);
            }elseif($this->input->get('searchText') != ''){
                $all = false;
                $body['result'] = $manager_model->getAllDoctors(RECORDS_PERPAGE,$pageFrom,$all);
            }
            else{
                $body['result'] = $manager_model->getAllDoctors(RECORDS_PERPAGE,$pageFrom,false);
            }

        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Orders Detail';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'doctors/admin_doctors', 'data' => []);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Add Doctor  
     */
    public function add_doctor(){
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- Add Doctor If Post Data 
            if(isset($_FILES['profile_pic']) && $this->input->post('dctrFname') && $this->input->post('dctrLname') && $this->input->post('dctrEmail') && $this->input->post('dctrPhone') && $this->input->post('document1') && $this->input->post('document2') && $this->input->post('document3')){ 
                $pic_url = $file1 = $file2 = $file3 = '';
                $manager_model->set_email(trim($this->input->post("dctrEmail")));
                $check_mail = $manager_model->chkUserEmail('users');
                
                if(!isset($check_mail['email'])){
                    //- Uploading Profile Pic 
                    if(isset($_FILES['profile_pic'])){
                        $file_size = $_FILES['profile_pic']['size'];
                        $file_tmp  = $_FILES['profile_pic']['tmp_name'];
                        $file_type = $_FILES['profile_pic']['type'];
                        $file_name = strtolower(array_shift(explode('.',$_FILES['profile_pic']['name'])));
                        $file_ext  = strtolower(end(explode('.',$_FILES['profile_pic']['name'])));
                        $expensions1= array("jpg", "jpeg","jpg","png");
                        $expensions2= array("pdf","doc","docx");
                        //echo "Profile pic Extension is $file_ext and Size is $file_size in byte<br/>";
                        if(in_array($file_ext,$expensions1)!== false){
                            $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                            $pic_url = uploadImageOnS3($filename,$file_tmp);
                        } 
                    }
                    //- Uploading Profile Pic 
                    if(isset($_FILES['file_1'])){
                        $file_size = $_FILES['file_1']['size'];
                        $file_tmp  = $_FILES['file_1']['tmp_name'];
                        $file_type = $_FILES['file_1']['type'];
                        $file_name = strtolower(array_shift(explode('.',$_FILES['file_1']['name'])));
                        $file_ext  = strtolower(end(explode('.',$_FILES['file_1']['name'])));
                        $expensions1= array("jpg", "jpeg","jpg","png");
                        $expensions2= array("pdf","doc","docx");
                        // echo "File1 Extension is $file_ext and Size is $file_size in byte<br/>";
                        if(in_array($file_ext,$expensions1)!== false){
                            $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                            $file_1_url = uploadImageOnS3($filename,$file_tmp);
                        } 
                    }
                    //- Uploading Profile Pic 
                    if(isset($_FILES['file_2'])){
                        $file_size = $_FILES['file_2']['size'];
                        $file_tmp  = $_FILES['file_2']['tmp_name'];
                        $file_type = $_FILES['file_2']['type'];
                        $file_name = strtolower(array_shift(explode('.',$_FILES['file_2']['name'])));
                        $file_ext  = strtolower(end(explode('.',$_FILES['file_2']['name'])));
                        $expensions1= array("jpg", "jpeg","jpg","png");
                        $expensions2= array("pdf","doc","docx");
                        // echo "File2 Extension is $file_ext and Size is $file_size in byte<br/>";
                        if(in_array($file_ext,$expensions1)!== false){
                            $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                            $file_2_url = uploadImageOnS3($filename,$file_tmp);
                        } 
                    }
                    //- Uploading Profile Pic 
                    if(isset($_FILES['file_3'])){
                        $file_size = $_FILES['file_3']['size'];
                        $file_tmp  = $_FILES['file_3']['tmp_name'];
                        $file_type = $_FILES['file_3']['type'];
                        $file_name = strtolower(array_shift(explode('.',$_FILES['file_3']['name'])));
                        $file_ext  = strtolower(end(explode('.',$_FILES['file_3']['name'])));
                        $expensions1= array("jpg", "jpeg","jpg","png");
                        $expensions2= array("pdf","doc","docx");
                        // echo "File3 Extension is $file_ext and Size is $file_size in byte<br/>";
                        if(in_array($file_ext,$expensions1)!== false){
                            $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                            $file_3_url = uploadImageOnS3($filename,$file_tmp);
                        } 
                    }

                    if($pic_url){
                        // profile_pic, dctrFname, dctrLname, dctrEmail, dctrPhone, document1, document2, document3, adddoctorbtn, $file_1, $file_2, $file_3
                        $manager_model->set_firstname(trim($this->input->post("dctrFname")));
                        $manager_model->set_lastname(trim($this->input->post("dctrLname")));
                        $manager_model->set_email(trim($this->input->post("dctrEmail")));
                        $manager_model->set_phone(trim($this->input->post("dctrPhone")));

                        $manager_model->set_picUrl(trim($pic_url));
                        $manager_model->set_doc1Name(trim($this->input->post("document1")));
                        $manager_model->set_doc2Name(trim($this->input->post("document2")));
                        $manager_model->set_doc3Name(trim($this->input->post("document3")));
                        $manager_model->set_doc1Url($file_1_url);
                        $manager_model->set_doc2Url($file_2_url);
                        $manager_model->set_doc3Url($file_3_url);


                        $resData = $manager_model->addNewDoctor();
                        if($resData == '-1'){
                            echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                        }else{
                            
                            echo "<script type='text/javascript'>alert('New doctor has been added successfully.')</script>";  
                        } 

                    }
                }else{
                    echo "<script type='text/javascript'>alert('Email id already exist.')</script>";  
                }
                    
            }               

        //echo "<pre>";print_r($body['result']);die;
        $data['title']          = 'Add Doctor';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar');
        $data['main_content']   = array('view' => 'doctors/add_doctor', 'data' => $body_data);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);  
    }
    
    
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : View/Edit Doctor  
     */
    /*_____________= User Detail Page =____________*/
    public function view_doctor(){
         
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        $appointmentModel = new Appointment_model();
        
        $manager_model->set_userid($this->uri->segment('2'));
        $body['doctorinfo'] = $manager_model->fetch_doctor_details($userId);
        
        
        //-- Update Doctor If Post Data 
            if(isset($_POST['doctorid']) && isset($_FILES['profile_pic']) && $this->input->post('dctrFname') && $this->input->post('dctrLname') && $this->input->post('dctrEmail') && $this->input->post('dctrPhone') && $this->input->post('document1') && $this->input->post('document2') && $this->input->post('document3')){ 
                $pic_url = $file1 = $file2 = $file3 = '';
                $manager_model->set_email(trim($this->input->post("dctrEmail")));
                $manager_model->set_customid(trim($this->input->post("doctorid")));
                $check_mail    = $manager_model->chkUserEmail('users');
                $check_userid  = $manager_model->chkUserId('users');

                if(isset($check_mail['email'])){
                    if(isset($check_userid['id'])){
                        //- Uploading Profile Pic
                        $pic_url    = $body['doctorinfo']['doctor_pic'];
                        $file_1_url = $body['doctorinfo']['doc1_url'];
                        $file_2_url = $body['doctorinfo']['doc2_url'];
                        $file_3_url = $body['doctorinfo']['doc3_url'];
                        if(isset($_FILES['profile_pic'])){
                            $file_size = $_FILES['profile_pic']['size'];
                            $file_tmp  = $_FILES['profile_pic']['tmp_name'];
                            $file_type = $_FILES['profile_pic']['type'];
                            $file_name = strtolower(array_shift(explode('.',$_FILES['profile_pic']['name'])));
                            $file_ext  = strtolower(end(explode('.',$_FILES['profile_pic']['name'])));
                            $expensions1= array("jpg", "jpeg","jpg","png");
                            $expensions2= array("pdf","doc","docx");
                            //echo "Profile pic Extension is $file_ext and Size is $file_size in byte<br/>";
                            if(in_array($file_ext,$expensions1)!== false){
                                $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                                $pic_url = uploadImageOnS3($filename,$file_tmp);
                            } 
                        }
                        //- Uploading Profile Pic 
                        if(isset($_FILES['file_1'])){
                            $file_size = $_FILES['file_1']['size'];
                            $file_tmp  = $_FILES['file_1']['tmp_name'];
                            $file_type = $_FILES['file_1']['type'];
                            $file_name = strtolower(array_shift(explode('.',$_FILES['file_1']['name'])));
                            $file_ext  = strtolower(end(explode('.',$_FILES['file_1']['name'])));
                            $expensions1= array("jpg", "jpeg","jpg","png");
                            $expensions2= array("pdf","doc","docx");
                            // echo "File1 Extension is $file_ext and Size is $file_size in byte<br/>";
                            if(in_array($file_ext,$expensions1)!== false){
                                $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                                $file_1_url = uploadImageOnS3($filename,$file_tmp);
                            } 
                        }
                        //- Uploading Profile Pic 
                        if(isset($_FILES['file_2'])){
                            $file_size = $_FILES['file_2']['size'];
                            $file_tmp  = $_FILES['file_2']['tmp_name'];
                            $file_type = $_FILES['file_2']['type'];
                            $file_name = strtolower(array_shift(explode('.',$_FILES['file_2']['name'])));
                            $file_ext  = strtolower(end(explode('.',$_FILES['file_2']['name'])));
                            $expensions1= array("jpg", "jpeg","jpg","png");
                            $expensions2= array("pdf","doc","docx");
                            // echo "File2 Extension is $file_ext and Size is $file_size in byte<br/>";
                            if(in_array($file_ext,$expensions1)!== false){
                                $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                                $file_2_url = uploadImageOnS3($filename,$file_tmp);
                            } 
                        }
                        //- Uploading Profile Pic 
                        if(isset($_FILES['file_3'])){
                            $file_size = $_FILES['file_3']['size'];
                            $file_tmp  = $_FILES['file_3']['tmp_name'];
                            $file_type = $_FILES['file_3']['type'];
                            $file_name = strtolower(array_shift(explode('.',$_FILES['file_3']['name'])));
                            $file_ext  = strtolower(end(explode('.',$_FILES['file_3']['name'])));
                            $expensions1= array("jpg", "jpeg","jpg","png");
                            $expensions2= array("pdf","doc","docx");
                            // echo "File3 Extension is $file_ext and Size is $file_size in byte<br/>";
                            if(in_array($file_ext,$expensions1)!== false){
                                $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                                $file_3_url = uploadImageOnS3($filename,$file_tmp);
                            } 
                        }

                        // profile_pic, dctrFname, dctrLname, dctrEmail, dctrPhone, document1, document2, document3, adddoctorbtn, $file_1, $file_2, $file_3
                        $manager_model->set_firstname(trim($this->input->post("dctrFname")));
                        $manager_model->set_lastname(trim($this->input->post("dctrLname")));
                        $manager_model->set_email(trim($this->input->post("dctrEmail")));
                        $manager_model->set_phone(trim($this->input->post("dctrPhone")));
                        $manager_model->set_picUrl(trim($pic_url));
                        $manager_model->set_doc1Name(trim($this->input->post("document1")));
                        $manager_model->set_doc2Name(trim($this->input->post("document2")));
                        $manager_model->set_doc3Name(trim($this->input->post("document3")));
                        $manager_model->set_doc1Url($file_1_url);
                        $manager_model->set_doc2Url($file_2_url);
                        $manager_model->set_doc3Url($file_3_url);

                        $resData = $manager_model->updateDoctor();
                        //echo $this->db->last_query();die;
                        if($resData == '-1'){
                            echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                        }else{

                            echo "<script type='text/javascript'>alert('Doctor record has been updated successfully.')</script>";  
                        } 
                    }else{
                        echo "<script type='text/javascript'>alert('Record is not matched with our database.')</script>";  
                    }
                }else{
                    echo "<script type='text/javascript'>alert('Email can't be updated a.')</script>";  
                }
                    
            }
        
        
            //-- IF SEARCH TEXT EXIST             
            if($this->input->get('date') && $this->input->get('date') != ''){ 
                $manager_model->set_sdate($this->input->get('date')); 
            }else{
                //$manager_model->set_sdate(date('Y-m-d'));
            }

            $totalPage      = $manager_model->appointmentsRecordCount();
            $baseUrl        = base_url() ."doctor-details/".$this->uri->segment('2');
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
            if($this->input->post('all') != ''){ 
                $all = true;
                $body['result'] = $manager_model->fetch_doctor_appointments(RECORDS_PERPAGE,$pageFrom,$all);
            }elseif($this->input->get('searchText') != ''){
                $all = false;
                $body['result'] = $manager_model->fetch_doctor_appointments(RECORDS_PERPAGE,$pageFrom,$all);
            }
            else{
                $body['result'] = $manager_model->fetch_doctor_appointments(RECORDS_PERPAGE,$pageFrom,false);
            }
        
        $body['doctorinfo'] = $manager_model->fetch_doctor_details($userId);
        $body['searchDate'] = $manager_model->get_sdate();
        $body['revenue']    = $manager_model->fetch_doctor_revenues();
        $body['appointments'] = 
        
        //echo "<pre>";print_r($body['doctorinfo']);die;
        $data['title']          = 'Doctor Detail';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'doctors/view_doctor');
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Ajax for Appointment User Info Doctor  
     */
    /*_____________= User Detail Page =____________*/
    public function appointment_userinfo(){
         
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
        $manager_model->set_customid($this->input->post('userid'));

        if($this->input->get('date') && $this->input->get('date') != ''){ 
            $manager_model->set_sdate($this->input->get('date')); 
        }else{
            $manager_model->set_sdate(date('Y-m-d'));
        }

        $appointmentInfo  = $manager_model->fetchAppointmentUserinfo();
        //print_r($appointmentInfo);die;
        $name        =  ucfirst($appointmentInfo['first_name'])." ".ucfirst($appointmentInfo['last_name']);
        $genLogic    =  $appointmentInfo['gender'] !='' ?  $appointmentInfo['gender'] : '';
        $gender      =  $genLogic !='1' ? $genLogic !='2' ? $genLogic!='3'? '<i style="color:red;">Not set</i>' : 'Otheres' : 'Female' : 'Male';
        $status =  $a != '0' ? ($a != '1' ? ($a != '2' ? "Canceled" : "Rescheduled") : "Confirmed") : 'Pending';
        $dob         =  $appointmentInfo['dob'] !='0000-00-00' && $appointmentInfo['dob'] !='' ?  $appointmentInfo['dob'] : '';

        $interval    = date_diff(date_create(), date_create($dob));
        //$age         = $interval->format("%Y Year, %M Months, %d Days, %H Hours, %i Minutes, %s Seconds Old");
        $age         = $interval->format("%Y")=='00' ?  '<i style="color:red;">Not set</i>' : $interval->format("%Y Year, %M Months"); 

        
        
        $createdOn   = $appointmentInfo['created_at'];
        $appointDate = $appointmentInfo['appointment_date'];
        $appointTime = $appointmentInfo['appointment_time'];
        $schduleDate = ($appointmentInfo['rescheduled_date'] != '0000-00-00' && $appointmentInfo['rescheduled_date']) ? $appointmentInfo['rescheduled_date'] :  '<i style="color:red;">Not set</i>';
        $schduleTime = ($appointmentInfo['rescheduled_time'] != '00:00:00' && $appointmentInfo['rescheduled_time']) ? $appointmentInfo['rescheduled_time'] :  '<i style="color:red;">Not set</i>';
        $reasonText = $appointmentInfo['reschedule_resason'] != '' ? $appointmentInfo['reschedule_resason'] : '<i style="color:red;">Not set</i>';
        $html='<div class="portlet-body flip-scroll table-scrollable" >
                        <table class="table table-bordered table-striped table-condensed flip-content table-hover detained" style="padding-left:0px;padding-right:0px;" >
                            <thead class="flip-content">
                                <tr>
                                    <th colspan="4"><h4 class="modal-title">Appointment Details<a class="closeIcon" id="closeAppointment" ><i class="fa fa-close" style="color:white;" aria-hidden="true"></i></a></h4></th>   
                                </tr>
                            </thead>
                            <tbody style="font-size:11px;border-bottom: 1px solid #e8d1d1;box-shadow: 3px -2px 17px 0px;">
                                <tr>
                                    <td clas="pad9topBtm"> <strong>Patient Name</strong></td>
                                    <td class="numeric pad9topBtm" colspan="3">'.$name.'</td>
                                </tr>
                                <tr>
                                    <td clas="pad9topBtm"> <strong>Gender</strong></td>
                                    <td class="numeric pad9topBtm">'.$gender.'</td>
                                    <td class="pad9topBtm"> <strong>Patient age </strong></td>
                                    <td class="numericpad9topBtm">'.$age.'</td>
                                </tr>
                                <tr>
                                    <td class="pad9topBtm"> <strong>Email</strong></td>
                                    <td class="numericpad9topBtm">kumarniraj.447@gmail.com</td>
                                    <td class="pad9topBtm"> <strong>Location </strong></td>
                                    <td class="numeric pad9topBtm">London</td>
                                </tr>
                                <tr>
                                    <td class="pad9topBtm"> <strong>Created On</strong></td>
                                    <td class="numeric pad9topBtm">'.$createdOn.'</td> 
                                    <td class="pad9topBtm"> <strong>Status</strong></td>
                                    <td class="numeric pad9topBtm">Rescheduled</td>
                                </tr>
                                <tr>
                                    <td class="pad9topBtm"> <strong>Appointment Date</strong></td>
                                    <td class="numeric pad9topBtm">'.$appointDate.'</td> 
                                    <td class="pad9topBtm"> <strong>Appointment Time</strong></td>
                                    <td class="numeric pad9topBtm">'.$appointTime.'</td>
                                </tr>
                                <tr>
                                    <td class="pad9topBtm"> <strong>Rescheduled Date</strong></td>
                                    <td class="numeric pad9topBtm">'.$schduleDate.'</td> 
                                    <td class="pad9topBtm"> <strong>Rescheduled Time</strong></td>
                                    <td class="numeric pad9topBtm">'.$schduleTime.'</td>
                                </tr>
                                <tr>
                                    <td class="pad9topBtm" colspan="4"> <strong>Rescheduled Reason</strong></td>
                                </tr>                            
                                <tr>
                                    <td class="pad9topBtm" colspan="4">'.$reasonText.'</td>
                                </tr>
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <a class="btn red"  id="closePop">Close</a>
                </div>';
        echo $html;

    }
    
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : Ajax for prescription User Info Doctor  
     */
    /*_____________= User Detail Page =____________*/
    public function prescription_userinfo(){
         
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
        $manager_model->set_customid($this->input->post('userid'));

        if($this->input->get('date') && $this->input->get('date') != ''){ 
            $manager_model->set_sdate($this->input->get('date')); 
        }else{
            $manager_model->set_sdate(date('Y-m-d'));
        }

        $appointmentInfo  = $manager_model->fetchAppointmentUserinfo();
        //print_r($appointmentInfo);die;
        $name             =  ucfirst($appointmentInfo['first_name'])." ".ucfirst($appointmentInfo['last_name']);
        $genLogic         =  $appointmentInfo['gender'] !='' ?  $appointmentInfo['gender'] : '';
        $gender           =  $genLogic !='1' ? $genLogic !='2' ? $genLogic!='3'? '<i style="color:red;">Not set</i>' : 'Otheres' : 'Female' : 'Male';
        $status           =  $a != '0' ? ($a != '1' ? ($a != '2' ? "Canceled" : "Rescheduled") : "Confirmed") : 'Pending';
        $dob              =  $appointmentInfo['dob'] !='0000-00-00' && $appointmentInfo['dob'] !='' ?  $appointmentInfo['dob'] : '';

        $interval         = date_diff(date_create(), date_create($dob));
        //$age         = $interval->format("%Y Year, %M Months, %d Days, %H Hours, %i Minutes, %s Seconds Old");
        $age              = $interval->format("%Y")=='00' ?  '<i style="color:red;">Not set</i>' : $interval->format("%Y Year, %M Months"); 

        $ssn              = 6565649654;
        $prescription_src = 'https://accesspharmacy.mhmedical.com/data/books/1810/m_hilgg2_apxI_f001.png';
        $createdOn        = $appointmentInfo['created_at'];
        $appointDate      = $appointmentInfo['appointment_date'];
        $appointTime      = $appointmentInfo['appointment_time'];
        $schduleDate      = ($appointmentInfo['rescheduled_date'] != '0000-00-00' && $appointmentInfo['rescheduled_date']) ? $appointmentInfo['rescheduled_date'] :  '<i style="color:red;">Not set</i>';
        $schduleTime      = ($appointmentInfo['rescheduled_time'] != '00:00:00' && $appointmentInfo['rescheduled_time']) ? $appointmentInfo['rescheduled_time'] :  '<i style="color:red;">Not set</i>';
        $reasonText       = $appointmentInfo['reschedule_resason'] != '' ? $appointmentInfo['reschedule_resason'] : '<i style="color:red;">Not set</i>';
        $html='<div class="portlet-body flip-scroll table-scrollable" >
                        <table class="table table-bordered table-striped table-condensed flip-content table-hover detained" style="padding-left:0px;padding-right:0px;" >
                            <thead class="flip-content">
                                <tr>
                                    <th colspan="4"><h4 class="modal-title">Prescription Details <a class="closeIcon" id="closePrescription" ><i class="fa fa-close" style="color:white;" aria-hidden="true"></i></a></h4></th>   
                                </tr>
                            </thead>
                            <tbody style="font-size:11px;border-bottom: 1px solid #e8d1d1;box-shadow: 3px -2px 17px 0px;">
                                <tr>
                                    <td clas="pad9topBtm"> <strong>Patient Name</strong></td>
                                    <td class="numeric pad9topBtm" >'.$name.'</td>
                                    <td clas="pad9topBtm"> <strong>*SSN</strong></td>
                                    <td class="numeric pad9topBtm" >'.$ssn.'</td>
                                </tr>
                                <tr>
                                    <td clas="pad9topBtm"> <strong>Gender</strong></td>
                                    <td class="numeric pad9topBtm">'.$gender.'</td>
                                    <td class="pad9topBtm"> <strong>Patient age </strong></td>
                                    <td class="numericpad9topBtm">'.$age.'</td>
                                </tr>
                                <tr>
                                    <td class="pad9topBtm" colspan="4" style="margin: 0 auto;">
                                        <code class="sampleText">* Demo prescription image</code>
                                        <a alt="View Image" href="https://accesspharmacy.mhmedical.com/data/books/1810/m_hilgg2_apxI_f001.png" target="_black">
                                            <img src='.$prescription_src.' class="" height="" width="100%" />
                                        </a>
                                    </td>
                                </tr>  
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer" style="margin:0px !important;">
                    <a class="btn red " id="closePop">Close</a>
                </div>';
        echo $html;
        
    }
    
    
    /** ******************************
     *  All Product Section 
     ** ******************************/
    
    /*
     * Admin Product Section
     * @author : niraj
     * @admin panel 
     * @function for : Product List ()
     */
    public function products(){ 
       
//        echo "<pre>";
//        print_r($this->input->post());exit;
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
            if($this->input->post('searchText') != ''){ 
                $manager_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
            }
            
            if($this->input->post('productStatus') != ''){ 
//                echo "productStatus";exit;
                $manager_model->setSearchStatus($this->input->post('productStatus'));
            }
            if($this->input->post('productCategory') != ''){ 
//                    echo "productCategory";exit;
                $manager_model->setCategory($this->input->post('productCategory'));
            }
            if($this->input->post('productSubCategory') != ''){
//                                    echo "productSubCategory";exit;
                $manager_model->setSubCategory($this->input->post('productCategory'));
            }
            if($this->input->post('productUnits') != ''){
//                                    echo "productUnits";exit;
                $manager_model->setProductUnits($this->input->post('productUnits'));
            }

            $totalPage      = $manager_model->productsCount();
            $baseUrl        = base_url() ."doctors";
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
            if($this->input->post('all') != ''){
               
                $all = true;
                $body['result'] = $manager_model->getAllProducts(RECORDS_PERPAGE,$pageFrom,$all);
            }elseif($this->input->post('searchText') != ''){
                
                $all = false;
                $body['result'] = $manager_model->getAllProducts(RECORDS_PERPAGE,$pageFrom,$all);
            }
            else{
                
                $body['result'] = $manager_model->getAllProducts(RECORDS_PERPAGE,$pageFrom,false);
            }

//        echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Orders Detail';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'products/admin_products', 'data' => []);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Admin Product Section
     * @author : niraj
     * @admin panel 
     * @function for : Add Product  
     */
    public function add_product(){
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        $body['warehouses']   = $manager_model->fetch_warehouses_detail();
        $body['getCaregivers']   = $manager_model->getCaregivers();
//        print_r($body['cargivers']);
        //-- Add Doctor If Post Data 
    
                                                                                                                                                                                                                                                             
//        echo "<pre>";print_r($_FILES);
//                    echo "<pre>";print_r($_POST);die;
       
            if(isset($_FILES['item_pic']) && $this->input->post('itemcolor') && $this->input->post('itemflavour') && $this->input->post('itemname') && $this->input->post('itemunit') && $this->input->post('itemfamily') && $this->input->post('ounce8price') && $this->input->post('anounceprice') && $this->input->post('itemrecommends') && $this->input->post('itemeffects') && $this->input->post('itemreview') && $this->input->post('category') && $this->input->post('caregiver')){ 

                $wareArray = array();
                foreach($body['warehouses'] AS $warehouse){
                    $whId   = $warehouse['warehouse_id'];
                    $whName = 'whQnty_'.$whId;
                    if(isset($_POST[$whName])){
                        $wareArray[$whId]= $_POST[$whName];
                    }
                }
                $manager_model->set_itemswhQnty($wareArray);
                
                $quantityTypeArray = array();
                foreach($body['warehouses'] AS $warehouse){
                    $qtTP   = $warehouse['warehouse_id'];
                    $qtType = 'quantity_type_'.$qtTP;
                    if(isset($_POST[$qtType])){
                        $quantityTypeArray[$qtTP]= $_POST[$qtType];
                    }
                }
                $manager_model->set_quantity_type($quantityTypeArray);
                
//                 echo "<pre>";
//                 print_r($wareArray); 
//                 print_r($quantityTypeArray); die;
                // print_r($manager_model->get_itemswhQnty($wareArray)); die;
                
                $pic_url = '';
                $pic_name = explode('.',$_FILES['item_pic']['name']);
                //- Uploading Profile Pic 
                if(isset($_FILES['item_pic'])){
                    $file_size = $_FILES['item_pic']['size'];
                    $file_tmp  = $_FILES['item_pic']['tmp_name'];
                    $file_type = $_FILES['item_pic']['type'];
                    $file_name = strtolower(array_shift($pic_name));
                    $file_ext  = strtolower(end($pic_name));
                    $expensions1= array("jpg", "jpeg","jpg","png");
                    $expensions2= array("pdf","doc","docx");
                    //echo "Profile pic Extension is $file_ext and Size is $file_size in byte<br/>";
                    if(in_array($file_ext,$expensions1)!== false){
                        $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
//                        $pic_url = uploadImageOnS3($filename,$file_tmp);
                        $pic_url = '123';
                    } 
                }
                
                if($pic_url){
                    //-- Set All Value in Setter 
                    $manager_model->set_categories($this->input->post('category'));
                    $manager_model->set_subCategory($this->input->post('subcategory'));
                    $manager_model->set_itemname($this->input->post('itemname'));
                    $manager_model->set_picUrl(trim($pic_url));
                    $manager_model->set_itemunit($this->input->post('itemunit'));
                    $manager_model->set_itemfamily($this->input->post('itemfamily'));
                    $manager_model->set_onegramprice($this->input->post('onegramprice'));
                    $manager_model->set_onegramoffprice($this->input->post('onegramoffprice'));
                    $manager_model->set_ounce8price($this->input->post('ounce8price'));
                    $manager_model->set_ounce8offprice($this->input->post('ounce8offprice'));
                    $manager_model->set_anounceprice($this->input->post('anounceprice'));
                    $manager_model->set_anounceoffprice($this->input->post('anounceoffprice'));
                    $manager_model->set_deducted_price($this->input->post('deducted_price'));
                    $manager_model->set_itemrecommends($this->input->post('itemrecommends'));
                    $manager_model->set_itemeffects($this->input->post('itemeffects'));
                    $manager_model->set_itemreview($this->input->post('itemreview'));
                    $manager_model->set_itemcolor($this->input->post('itemcolor'));
                    $manager_model->set_itemflavour($this->input->post('itemflavour'));
                    $manager_model->set_cargiver($this->input->post('caregiver'));
                    $manager_model->set_moods($this->input->post('moods'));
                    $manager_model->set_medicals($this->input->post('medicals'));
                    
                    $this->input->post('limited') ? $manager_model->set_limited($this->input->post('limited')) : $manager_model->set_limited(0);
                    $this->input->post('biweekly') ? $manager_model->set_itembiweekly('1') : $manager_model->set_itembiweekly('0');
                    $this->input->post('hot') ? $manager_model->set_itemhot('1') : $manager_model->set_itemhot('0');
                    $this->input->post('luxurious') ? $manager_model->set_itemluxurious($this->input->post('luxurious')) : $manager_model->set_itemluxurious('0');
                    $this->input->post('thc') ? $manager_model->set_itemthc($this->input->post('thc')) : $manager_model->set_itemthc('');
                    $this->input->post('cbg') ? $manager_model->set_itemcbg($this->input->post('cbg')) : $manager_model->set_itemcbg('');
                    $this->input->post('cbc') ? $manager_model->set_itemcbc($this->input->post('cbc')) : $manager_model->set_itemcbc('');
                    $this->input->post('cbn') ? $manager_model->set_itemcbn($this->input->post('cbn')) : $manager_model->set_itemcbn('');
                    $this->input->post('cbd') ? $manager_model->set_itemcbd($this->input->post('cbd')) : $manager_model->set_itemcbd('');
                    $this->input->post('thcv') ? $manager_model->set_itemthcv($this->input->post('thcv')) : $manager_model->set_itemthcv('');
                    //$manager_model->set_quantity_type($this->input->post('quantity_type'));
                    
                    $resData = $manager_model->addNewProduct();
                    if($resData == '-1'){
                        echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                        redirect('add-product','refresh');
                    }else{

                        echo "<script type='text/javascript'>alert('New product has been added successfully.')</script>";  
                    } 

                }else{
                    echo "<script type='text/javascript'>alert('Please choose product image..')</script>";  
                }
                    
            }    
        
        
        $body['warehouses']   = $manager_model->fetch_warehouses_detail();
        $body['getCaregivers']   = $manager_model->getCaregivers();
        $body['categories']   = $manager_model->fetch_items_categories();
        $body['moods']   = $manager_model->fetch_moods();
        $body['medicals']   = $manager_model->fetch_medicals();
        $body['itemfamilies'] = $manager_model->fetch_items_families();
        
        // echo "<pre>";print_r($body['categories']);die;             

        // echo "<pre>";print_r($body['itemfamilies']);die;
        $data['title']          = 'Add Product';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar');
        $data['main_content']   = array('view' => 'products/add_product', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);  
    }
    
    
    /*
     * Admin Doctor Section
     * @author : niraj
     * @admin panel 
     * @function for : View Product Page 
     */
    public function view_product(){
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        
        
        $manager_model->set_itemid($this->uri->segment('2'));
        $body['productinfo'] = $manager_model->fetch_product_details($this->uri->segment('2'));
        //echo "<pre>";print_r($body['productinfo']);die;
        
        if(count($body['productinfo']) > 0){
            $body['warehouses']   = $manager_model->product_quantity_wareHouseWise($this->uri->segment('2'));
            // echo "<pre>";print_r($_POST);die;

                if(isset($_FILES['item_pic']) && $this->input->post('itemcolor') && $this->input->post('itemflavour') && $this->input->post('itemname') && $this->input->post('itemunit') && $this->input->post('itemfamily') && $this->input->post('ounce8price') && $this->input->post('anounceprice') && $this->input->post('itemrecommends') && $this->input->post('itemeffects') && $this->input->post('itemreview') && $this->input->post('categories')){ 
                    //echo "<pre>"; print_r($_POST); die;
                    $wareArray = array();
                    foreach($body['warehouses'] AS $warehouse){
                        $whId   = $warehouse['warehouse_id'];
                        $whName = 'whQnty_'.$whId;
                        if(isset($_POST[$whName])){
                            $wareArray[$whId]= $_POST[$whName];
                        }
                    }
                    $manager_model->set_itemswhQnty($wareArray);
                    // print_r($manager_model->get_itemswhQnty($wareArray)); die;
                    $pic_url = '';
                    //- Uploading Profile Pic 
                    if(isset($_FILES['item_pic']['tmp_name']) && $_FILES['item_pic']['tmp_name'] != '' && $_POST['pic_exiting'] != ''){
                        $filename = explode('.',$_FILES['item_pic']['name']);
                        $file_size = $_FILES['item_pic']['size'];
                        $file_tmp  = $_FILES['item_pic']['tmp_name'];
                        $file_type = $_FILES['item_pic']['type'];
                        $file_name = strtolower(array_shift($filename));
                        $file_ext  = strtolower(end($filename));
                        $expensions1= array("jpg", "jpeg","jpg","png");
                        $expensions2= array("pdf","doc","docx");
                        //echo "Profile pic Extension is $file_ext and Size is $file_size in byte<br/>";
                        if(in_array($file_ext,$expensions1)!== false){
                            $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                            $pic_url = uploadImageOnS3($filename,$file_tmp, "products");
                        } 
                    }else{
                        $pic_url = $_POST['pic_exiting'];
                    }

                    if($pic_url){
                        //-- Set All Value in Setter 
                        $manager_model->set_categories($this->input->post('categories'));
                        $manager_model->set_itemname($this->input->post('itemname'));
                        $manager_model->set_picUrl(trim($pic_url));
                        $manager_model->set_itemunit($this->input->post('itemunit'));
                        $manager_model->set_itemfamily($this->input->post('itemfamily'));
                        $manager_model->set_ounce8price($this->input->post('ounce8price'));
                        $manager_model->set_anounceprice($this->input->post('anounceprice'));
                        $manager_model->set_anounceprice($this->input->post('deducted_price'));
                        $manager_model->set_itemrecommends($this->input->post('itemrecommends'));
                        $manager_model->set_itemeffects($this->input->post('itemeffects'));
                        $manager_model->set_itemreview($this->input->post('itemreview'));
                        $manager_model->set_itemcolor($this->input->post('itemcolor'));
                        $manager_model->set_itemflavour($this->input->post('itemflavour'));


                        $this->input->post('biweekly') ? $manager_model->set_itembiweekly('1') : $manager_model->set_itembiweekly('0');
                        $this->input->post('hot') ? $manager_model->set_itemhot('1') : $manager_model->set_itemhot('0');
                        $this->input->post('luxurious') ? $manager_model->set_itemluxurious('1') : $manager_model->set_itemluxurious('0');

                        $this->input->post('thc') ? $manager_model->set_itemthc($this->input->post('thc')) : $manager_model->set_itemthc('');
                        $this->input->post('cbg') ? $manager_model->set_itemcbg($this->input->post('cbg')) : $manager_model->set_itemcbg('');
                        $this->input->post('cbc') ? $manager_model->set_itemcbc($this->input->post('cbc')) : $manager_model->set_itemcbc('');
                        $this->input->post('cbn') ? $manager_model->set_itemcbn($this->input->post('cbn')) : $manager_model->set_itemcbn('');
                        $this->input->post('cbd') ? $manager_model->set_itemcbd($this->input->post('cbd')) : $manager_model->set_itemcbd('');
                        $this->input->post('thcv') ? $manager_model->set_itemthcv($this->input->post('thcv')) : $manager_model->set_itemthcv('');
                        
                        $resData = $manager_model->updateProduct();
                        if($resData == '-1'){
                            echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                            redirect("products",'refresh');
                        }else{
                            echo "<script type='text/javascript'>alert('Product has been updated successfully.')</script>";  
                            redirect("products",'refresh');
                        } 

                    }else{
                        echo "<script type='text/javascript'>alert('Please choose product image..')</script>";  
                    }

                }    


            $body['warehouses']     = $manager_model->product_quantity_wareHouseWise("");
            $body['categories']     = $manager_model->fetch_items_categories();
            $body['itemcategories'] = $manager_model->fetch_product_categories();
            $body['itemfamilies']   = $manager_model->fetch_items_families();

            // echo "<pre>";print_r($body['categories']);die;             

            // echo "<pre>";print_r($body['itemfamilies']);die;
            $data['title']          = 'Product detail';
            $data['header']         = array('view' => 'templates/header', 'data' => $data);
            $data['sidebar']        = array('view' => 'templates/common_sidebar');
            $data['main_content']   = array('view' => 'products/view_product', 'data' => $body);
            $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data);  
        }else{
            //echo "<script type='text/javascript'>alert('Please choose product image..')</script>";  
            ?>
                <script type='text/javascript'>
                    alert('Invalid product information');
                    window.location = "<?php echo base_url(); ?>products";
                </script>
            <?php
        }
            
    }
    
    public function deleteProduct()
    {
        $response = array('error' => null, 'success' => false, 'status' => 200);

        $managerModel = new Manager_model();
        
        // catch the item ID
        $itemID = $this->uri->segment('2');

        // delete the product
        try
        {
            $affectedRows = $managerModel->deleteProduct($itemID);

            if ( $affectedRows >= 1 )
            {
                $response['success'] = true;
            }
            else
            {
                $response['error'] = "Now items has been deleted, if you think this is wrong please report it to our support.";
                $response['status'] = 304;
            }
        }
        catch (\Exception $e)
        {
            $response['error'] = $e->getMessage();
            $response['success'] = false;
            $response['status'] = 500;
        }

        // set header response
        $this->output->set_header('HTTP/1.0 200 OK');
        $this->output->set_header('HTTP/1.1 200 OK');
        $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        // send result alongside with headers
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
        exit();
    }
    
    public function edit_care_giver_details(){
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        echo $this->uri->segment('2');exit;
        $manager_model->edit_a_caregiver($this->uri->segment('2'));
         
    }
    
    
 
    
    /** ******************************
     *  All Category Section 
     ** ******************************/
    
    /*
     * Admin Category Section
     * @author : niraj
     * @admin panel 
     * @function for : Categories List ()
     */
    public function categories(){ 
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
            if($this->input->post('searchText') != ''){ 
                $manager_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
            }
            
            $totalPage      = $manager_model->categoriesCount();
            $baseUrl        = base_url() ."categories";
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
            if($this->input->post('all') != ''){ 
                $all = true;
                $body['result'] = $manager_model->getAllcategories(RECORDS_PERPAGE,$pageFrom,$all);
            }elseif($this->input->get('searchText') != ''){
                $all = false;
                $body['result'] = $manager_model->getAllcategories(RECORDS_PERPAGE,$pageFrom,$all);
            }
            else{
                $body['result'] = $manager_model->getAllcategories(RECORDS_PERPAGE,$pageFrom,false);
            }
        //echo $manager_model->fetchItemCount(1);die;
        // echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Categories List';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'categories/all_categories', 'data' => []);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    
    /*
     * Admin Category Section
     * @author : niraj
     * @admin panel 
     * @function for : Add New Category
     */
    public function add_category(){
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        $body['warehouses']   = $manager_model->fetch_warehouses_detail();
        //-- Add Doctor If Post Data 

        if($this->input->post('catname')){ 


            $manager_model->set_categoryName($this->input->post('catname'));

            $resData = $manager_model->addNewCategory();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('add-product','refresh');
            }else{

                echo "<script type='text/javascript'>alert('New category has been added successfully.')</script>";  
                redirect('categories','refresh');
            } 

        }
  

        $body['warehouses']   = $manager_model->fetch_warehouses_detail();
        $body['categories']   = $manager_model->fetch_items_categories();
        $body['itemfamilies'] = $manager_model->fetch_items_families();
        
        // echo "<pre>";print_r($body['categories']);die;             

        // echo "<pre>";print_r($body['itemfamilies']);die;
        $data['title']          = 'Add Category';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar');
        $data['main_content']   = array('view' => 'categories/add_category', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);  
    }
    
    function check_category(){
        if(isset($_POST['catname']) && $_POST['catname'] != ''){        
            $manager_model = new Manager_model();//-- Model Object 
            $res = $manager_model->check_category_name($_POST['catname']);
            
            echo $res ? 'true' : 'false' ;
        }else{
            echo "false";
        }
    }

    
    
    
    /** ******************************
     *  All Messsages Section 
     ** ******************************/
    
    /*
     * Admin Messages Section
     * @author : niraj
     * @admin panel 
     * @function for : Messages List ()
     */
    public function messages(){ 
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
            if($this->input->post('searchText') != ''){ 
                $manager_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
            }
            
            $totalPage      = $manager_model->messagesCount();
            $baseUrl        = base_url() ."messages";
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
            if($this->input->post('all') != ''){ 
                $all = true;
                $body['result'] = $manager_model->getAllMessages(RECORDS_PERPAGE,$pageFrom,$all);
            }elseif($this->input->get('searchText') != ''){
                $all = false;
                $body['result'] = $manager_model->getAllMessages(RECORDS_PERPAGE,$pageFrom,$all);
            }
            else{
                $body['result'] = $manager_model->getAllMessages(RECORDS_PERPAGE,$pageFrom,false);
            }
        //echo $manager_model->fetchItemCount(1);die;
        // echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Messages details';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'messages/all_messages', 'data' => []);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Admin Category Section
     * @author : niraj
     * @admin panel 
     * @function for : Add New Category
     */
    public function add_message(){
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- Add Doctor If Post Data 

        if(isset($_FILES['message_pic']) && $this->input->post('message') && $this->input->post('link')){ 
            
            $pic_url = '';
            //- Uploading Profile Pic 
            if(isset($_FILES['message_pic'])){
                $file_size = $_FILES['message_pic']['size'];
                $file_tmp  = $_FILES['message_pic']['tmp_name'];
                $file_type = $_FILES['message_pic']['type'];
                $file_name = strtolower(array_shift(explode('.',$_FILES['message_pic']['name'])));
                $file_ext  = strtolower(end(explode('.',$_FILES['message_pic']['name'])));
                $expensions1= array("jpg", "jpeg","jpg","png");
                $expensions2= array("pdf","doc","docx");
                //echo "Profile pic Extension is $file_ext and Size is $file_size in byte<br/>";
                if(in_array($file_ext,$expensions1)!== false){
                    $filename = $file_name.rand(11,99)."_".time().".".$file_ext;
                    $pic_url = uploadImageOnS3($filename,$file_tmp);
                } 
            }
                
            if($pic_url){
                $manager_model->set_picUrl($pic_url);
                $manager_model->set_link($this->input->post('link'));
                $manager_model->set_message($this->input->post('message'));

                $resData = $manager_model->addNewMessage();
                //echo $this->db->last_query(); die;
                if($resData === -1){
                    echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                }else{
                    echo "<script type='text/javascript'>alert('New Message has been sent successfully.')</script>";
                    redirect('add-message','refresh');
                } 

            }else{
                echo "<script type='text/javascript'>alert('Please choose Message image..')</script>";  
            }           
        }

        // echo "<pre>";print_r($body['categories']);die;             

        $data['title']          = 'Add Message';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar');
        $data['main_content']   = array('view' => 'messages/add_message', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);  
    }
    
    
    /** ******************************
     *  All Coupons Section 
     ** ******************************/
    
    
    /*
     * Admin Coupons Section
     * @author : niraj
     * @admin panel 
     * @function for : Coupons List ()
     */
    public function coupons(){ 
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
            if($this->input->post('searchText') != ''){ 
                $manager_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
            }
            
            $totalPage      = $manager_model->couponsCount();
            $baseUrl        = base_url() ."coupons";
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
            if($this->input->post('all') != ''){ 
                $all = true;
                $body['result'] = $manager_model->getAllcoupons(RECORDS_PERPAGE,$pageFrom,$all);
            }elseif($this->input->get('searchText') != ''){
                $all = false;
                $body['result'] = $manager_model->getAllcoupons(RECORDS_PERPAGE,$pageFrom,$all);
            }
            else{
                $body['result'] = $manager_model->getAllcoupons(RECORDS_PERPAGE,$pageFrom,false);
            }
        //echo $manager_model->fetchItemCount(1);die;
        // echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Messages details';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'coupons/all_coupons', 'data' => []);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Admin Coupon Section
     * @author : niraj
     * @admin panel 
     * @function for : Add Coupon Category
     */
    public function add_coupon(){
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        //-- Add Doctor If Post Data 
        // cname, cminorder_price, code, validity, points, discount, distype, categoryid
        if(     $this->input->post('cname') 
                && $this->input->post('cminorder_price')
                && $this->input->post('code')
                && $this->input->post('validity')
                && $this->input->post('points')
                && $this->input->post('discount')
                && $this->input->post('distype')
                && $this->input->post('categoryid')
          ){ 
            //--  Setter Data 
            // couponName, couponMinOrderPrice, couponCode, couponValidity, couponPoints
            // couponDiscount, couponDistype, couponCategoryid 
            $manager_model->set_couponName(trim($this->input->post('cname')));
            $manager_model->set_couponMinOrderPrice($this->input->post('cminorder_price'));
            $manager_model->set_couponCode($this->input->post('code'));
            $manager_model->set_couponValidity($this->input->post('validity'));
            $manager_model->set_couponPoints($this->input->post('points'));
            $manager_model->set_couponDiscount($this->input->post('discount'));
            $manager_model->set_couponDistype($this->input->post('distype'));
            $manager_model->set_couponCategoryid($this->input->post('categoryid'));
            // echo $manager_model->get_couponCategoryid();die;
            $resData = $manager_model->addNewCoupon();
            //echo $this->db->last_query(); die;
            if($resData === -1){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            }else{
                echo "<script type='text/javascript'>alert('New Coupon has been added successfully.')</script>";
                redirect('coupons','refresh');
            } 
          
        }

        $body['categories']     = $manager_model->fetch_items_categories();
        
        $data['title']          = 'Add Message';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar']        = array('view' => 'templates/common_sidebar');
        $data['main_content']   = array('view' => 'coupons/add_coupon', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);  
    }
    
    /*
     * Admin Coupon Section
     * @author : niraj
     * @admin panel 
     * @function for : View/ Edit Coupon 
     */
    public function view_coupon(){
        sessionChk();                        //-- Validating session
        $manager_model = new Manager_model();//-- Model Object 
        $body['couponinfo'] = $manager_model->fetch_coupon_details($this->uri->segment('2'));
        //echo "<pre>";print_r($body['couponinfo']);die;
        
        if(count($body['couponinfo']) > 0){
                if(     $this->input->post('cid') 
                        && $this->input->post('cname') 
                        && $this->input->post('cminorder_price')
                        && $this->input->post('code')
                        && $this->input->post('validity')
                        && $this->input->post('points')
                        && $this->input->post('discount')
                        && $this->input->post('distype')
                        && $this->input->post('categoryid')
                  ){ 
                    //--  Setter Data 
                    $manager_model->set_customid($this->input->post('cid'));
                    $manager_model->set_couponName(trim($this->input->post('cname')));
                    $manager_model->set_couponMinOrderPrice($this->input->post('cminorder_price'));
                    $manager_model->set_couponCode($this->input->post('code'));
                    $manager_model->set_couponValidity($this->input->post('validity'));
                    $manager_model->set_couponPoints($this->input->post('points'));
                    $manager_model->set_couponDiscount($this->input->post('discount'));
                    $manager_model->set_couponDistype($this->input->post('distype'));
                    $manager_model->set_couponCategoryid($this->input->post('categoryid'));
                    // echo $manager_model->get_couponCategoryid();die;
                    $resData = $manager_model->updateExistCoupon();
                    //echo $this->db->last_query(); die;
                    if($resData === -1){
                        echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                    }else{
                        echo "<script type='text/javascript'>alert('Coupon has been updated successfully.')</script>";
                        redirect('coupons','refresh');
                    } 

                }

                $body['categories']     = $manager_model->fetch_items_categories();

                $data['title']          = 'Add Message';
                $data['header']         = array('view' => 'templates/header', 'data' => $data);
                $data['sidebar']        = array('view' => 'templates/common_sidebar');
                $data['main_content']   = array('view' => 'coupons/view_coupon', 'data' => $body);
                $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
                $this->load->view('templates/common_template', $data);  
        }else{
            //echo "<script type='text/javascript'>alert('Please choose product image..')</script>";  
            ?>
                <script type='text/javascript'>
                    alert('Invalid product information');
                    window.location = "<?php echo base_url(); ?>products";
                </script>
            <?php
        }
        
                
    }
    
    public function updatePrescriptionVerification(){
        //$result = array();
        $prescriptionObj = new Prescription_model();
        $prescriptionObj->setId($this->uri->segment('2'));
        $prescriptionObj->setIs_approved('1');
        $data = $prescriptionObj->updatePrescriptionStatus();
       
        $result = array('result'=>1,'data'=>$data,'message'=>'Approved Successfuly');  
        
        echo json_encode($result);
        exit();
    }
    
    public function rejectPrescriptionStatus(){
       // $result = array();
        extract($_POST);
        $prescriptionObj = new Prescription_model();
        $prescriptionObj->setId($prescription_Id);
        $prescriptionObj->setReason($reject_reason);
        $prescriptionObj->setIs_approved('0');
        $data = $prescriptionObj->updatePrescriptionStatus();
       
        $result = array('result'=>1,'data'=>$data,'message'=>'Rejected Successfuly');  
        
        echo json_encode($result);
        exit();
    }
    
    public function addCouponToUserAccount(){
        extract($_POST);
       
        if($_POST['coupon_id']== '' || $_POST['user_id']=='' ) {
            $result = array('result'=>0,'data'=>array(),'message'=>'Error - Please try again');  
        }else{
             $userCouponMode = new User_coupons_model();
             $userCouponMode->setCoupon_id($_POST['coupon_id']);
             $userCouponMode->setUser_id($_POST['user_id']);
             
            $couponData = $userCouponMode->getCouponDetails();
             $userCouponMode->setCoupon_code($couponData['code']);
              $userCouponMode->setExpiry($couponData['coupan_expiry']);
              $userCouponMode->setDiscount_in_percent($couponData['discount']);
             
             $userCouponMode->insertUpdateCouponInUser();
             $result = array('result'=>1,'data'=>array(),'message'=>'Coupon Assigned Successfuly');  
        }
        echo json_encode($result);
    }
    
    
    
    
}

