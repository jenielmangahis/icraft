<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Setting extends MX_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('Setting_model');
        $this->load->model('Taxes_model');
        
    }
    

    
    /** ******************************
     *  All Setting Section : Manage Users 
     ** ******************************/
    
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Admin users List ()
     */
    public function manage_users(){ 
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
            if($this->input->post('searchText') != ''){ 
                $setting_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
            }
            
            $totalPage      = $setting_model->usersCount();
            $baseUrl        = base_url() ."manage-users";
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
            if($this->input->post('all') != ''){ 
                $all = true;
                $body['result'] = $setting_model->getAllUsers(RECORDS_PERPAGE,$pageFrom,$all);
            }elseif($this->input->get('searchText') != ''){
                $all = false;
                $body['result'] = $setting_model->getAllUsers(RECORDS_PERPAGE,$pageFrom,$all);
            }
            else{
                $body['result'] = $setting_model->getAllUsers(RECORDS_PERPAGE,$pageFrom,false);
            }
        //echo $setting_model->fetchItemCount(1);die;
        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Manage Products';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/all_users', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Add User in admin
     */
    public function add_user(){
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object  
        //-- Add Doctor If Post Data  
        if($this->input->post('selectedModules') && $this->input->post('email') && $this->input->post('fname') && $this->input->post('lname') && $this->input->post('contact')){ 

            $setting_model->set_modules($this->input->post('modules'));
            $setting_model->set_firstname($this->input->post('fname'));
            $setting_model->set_lastname($this->input->post('lname'));
            $setting_model->set_phone($this->input->post('contact'));
            $setting_model->set_email($this->input->post('email'));

            $resData = $setting_model->addAdminUser();
            //echo $this->db->last_query(); die;
            if($resData === -1){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            }else{
                echo "<script type='text/javascript'>alert('New User has been created successfully.')</script>";
                redirect('manage-users','refresh');
            } 
          
        }

        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Manage Products';
        $data['requiredcss']    = 'setting';
        $data['modules'] = $this->db->select('*')->from('modules')->get()->result_array();
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['module'] = $this->db->select('*')->from('modules')->get()->result_array();
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/add_user', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data); 
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : View/Edit Admin User 
     */
    public function view_admin_user(){
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object  
        
        $setting_model->set_userid($this->uri->segment('2'));
        $body['userinfo'] = $setting_model->fetch_admin_user_details();
        if(isset($body['userinfo']['user_id']) && $body['userinfo']['user_id'] != ''){
            //-- Add Doctor If Post Data  
            if($this->input->post('user_id') && $this->input->post('selectedModules') && $this->input->post('email') && $this->input->post('fname') && $this->input->post('lname') && $this->input->post('contact')){ 

                $setting_model->set_modules($this->input->post('modules'));
                $setting_model->set_firstname($this->input->post('fname'));
                $setting_model->set_lastname($this->input->post('lname'));
                $setting_model->set_phone($this->input->post('contact'));
                $setting_model->set_userid($this->input->post('user_id'));

                $resData = $setting_model->updateAdminUser();
//                echo $this->db->last_query(); die;
                if($resData === -1){
                    echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                }else{
                    echo "<script type='text/javascript'>alert('User information has been updated successfully.')</script>";
                    redirect('manage-users','refresh');
                }

            }

            //echo"<pre>";print_r($body['userinfo']);die;
            $data['title']          = 'View User';
            $data['requiredcss']    = 'setting';
            $data['header']         = array('view' => 'templates/header', 'data' => $data);
            $data['modules'] = $this->db->select('*')->from('modules')->get()->result_array();
            //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
            $data['main_content']   = array('view' => 'setting/view_user', 'data' => $body);
            $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data); 
        }else{
            redirect('manage-users','refresh');
        }
            
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Delete Admin User 
     */
    public function delete_user(){
        if($this->uri->segment('2') !=''){
            $userId = $this->uri->segment('2'); 
            $setting_model = new Setting_model();
            
            $setting_model->set_userid($userId);
            $resData = $setting_model->delete_admin_user();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('manage-users','refresh');
            }else{
                echo "<script type='text/javascript'>alert('User has been deleted successfully..')</script>";
                redirect('manage-users','refresh');
            }
        }else{
            redirect('manage-users','refresh');
        }             
    }
    
    /** ******************************
     *  All Setting Section : Manage Products 
     ** ******************************/
    /*
     * Manage Products Input |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : List All Product Family ()
     */
    public function manage_products(){ 
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
        if($this->input->post('searchText') != ''){ 
            $setting_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
        }
        
        $totalPage      = $setting_model->productFamilyCount();
        $baseUrl        = base_url() ."manage-products";
        $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
        //echo $totalPage;die;
        if($this->input->post('all') != ''){ 
            $all = true;
            $body['result'] = $setting_model->getAllProductFamily(RECORDS_PERPAGE,$pageFrom,$all);
        }elseif($this->input->get('searchText') != ''){
            $all = false;
            $body['result'] = $setting_model->getAllProductFamily(RECORDS_PERPAGE,$pageFrom,$all);
        }
        else{
            $body['result'] = $setting_model->getAllProductFamily(RECORDS_PERPAGE,$pageFrom,false);
        }
        //echo $setting_model->fetchItemCount(1);die;
        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Messages Products';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['main_content']   = array('view' => 'setting/all_products', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Manage Products | Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Change Family Status 
     */
    public function change_family_status(){  
        if($this->uri->segment('2') !=''){
            $userId = $this->uri->segment('2'); 
            $setting_model = new Setting_model();
            
            $setting_model->set_familyId($userId);
            $resData = $setting_model->changeFamilyStatus($userId);
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('manage-products','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Products family status has been updated successfully.')</script>";
                redirect('manage-products','refresh');
            }
        }else{
            echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            redirect('manage-products','refresh');
        }   
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Delete Admin User 
     */
    public function delete_product_family(){
        if($this->uri->segment('2') !=''){
            $userId = $this->uri->segment('2'); 
            $setting_model = new Setting_model();
            
            $setting_model->set_userid($userId);
            $resData = $setting_model->delete_productFamily();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('manage-products','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Product family has been deleted successfully.')</script>";
                redirect('manage-products','refresh');
            }
        }else{
            redirect('manage-products','refresh');
        }            
    }
    
    /*
     * Manage Products |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Add Products Family
     */
    public function add_product_family(){
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object  
        //-- Add Doctor If Post Data  
        if($this->input->post('familyname')){ 
            $setting_model->set_familyname($this->input->post('familyname'));
            $resData = $setting_model->addNewProductFamily();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('manage-products','refresh');
            }else{

                echo "<script type='text/javascript'>alert('New Product Family has been added successfully.')</script>";
                redirect('manage-products','refresh');
            } 

        }

        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Manage Products';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/add_product_family', 'data' => []);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data); 
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : View/Edit Admin User 
     */
    public function view_product_family(){
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object  
        
        $setting_model->set_familyId($this->uri->segment('2'));
        $body['productinfo'] = $setting_model->fetch_product_family_details($this->uri->segment('2'));
        if(isset($body['productinfo']['family_id']) && $body['productinfo']['family_id'] != ''){
            
            //-- Add Doctor If Post Data  
            if($this->input->post('family_id') && $this->input->post('familyname')){ 
                $setting_model->set_familyId($this->input->post('family_id'));
                $setting_model->set_familyname($this->input->post('familyname'));
                
                $resData = $setting_model->updateProductFamilyDetails();
                if($resData == '-1'){
                    echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                    redirect('manage-products','refresh');
                }else{

                    echo "<script type='text/javascript'>alert('Product Family Details has been updated successfully.')</script>";
                    redirect('manage-products','refresh');
                } 

            }

            // echo"<pre>";print_r($body['productinfo']);die;
            $data['title']          = 'View Product Family';
            $data['requiredcss']    = 'setting';
            $data['header']         = array('view' => 'templates/header', 'data' => $data);
            //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
            $data['main_content']   = array('view' => 'setting/view_product_family', 'data' => $body);
            $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data); 
        }else{
            redirect('manage-users','refresh');
        }
            
    }
    
    /*
     * Add Product family |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Check Product family existance
     */
    function check_product_family(){
        if(isset($_POST['familyname']) && $_POST['familyname'] != ''){   
            $setting_model = new Setting_model();//-- Model Object  
            $res = $setting_model->check_family_name($_POST['familyname']);
            
            echo $res ? 'true' : 'false' ;
        }else{
            echo "false";
        }
    }
    
    
    /** ****************************************
     *  All Setting Section : Manage Warehouse *
     ** ****************************************/    
    /*
     * Manage Warehouses |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Admin ware-houses List ()
     */
    public function manage_warehouses(){ 
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
            if($this->input->post('searchText') != ''){ 
                $setting_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
            }
            
            $totalPage      = $setting_model->WareHosesCount();
            $baseUrl        = base_url() ."manage-warehouse";
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
            if($this->input->post('all') != ''){ 
                $all = true;
                $body['result'] = $setting_model->getAllWareHouses(RECORDS_PERPAGE,$pageFrom,$all);
            }elseif($this->input->get('searchText') != ''){
                $all = false;
                $body['result'] = $setting_model->getAllWareHouses(RECORDS_PERPAGE,$pageFrom,$all);
            }
            else{
                $body['result'] = $setting_model->getAllWareHouses(RECORDS_PERPAGE,$pageFrom,false);
            }
        //echo $setting_model->fetchItemCount(1);die;
        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Manage Ware-houses';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/all_warehouses', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Manage Warehouses |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Change Warehouse Status  ()
     */
    public function change_warehouse_status(){  
        if($this->uri->segment('2') !=''){
            $userId = $this->uri->segment('2'); 
            $setting_model = new Setting_model();
            
            $setting_model->set_whid($userId);
            $resData = $setting_model->changeWareHouseStatus();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('manage-warehouses','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Ware House status has been updated successfully.')</script>";
                redirect('manage-warehouses','refresh');
            }
        }else{
            echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            redirect('manage-warehouses','refresh');
        }   
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Add Ware House
     */
    public function add_warehouse(){
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object  
        //-- Add Ware House  If Post Data  
        if($this->input->post('address') && $this->input->post('warename') && $this->input->post('latlng')){ 
            $latlng = explode(',', $this->input->post('latlng'));
            
            $setting_model->set_whaddress($this->input->post('address'));
            $setting_model->set_whname($this->input->post('warename'));
            $setting_model->set_lat($latlng[0]);
            $setting_model->set_lng($latlng[1]);

            $resData = $setting_model->addWareHouse();
            //echo $this->db->last_query(); die;
            if($resData === -1){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            }else{
                echo "<script type='text/javascript'>alert('New Ware House has been added successfully.')</script>";
                redirect('manage-users','refresh');
            } 
          
        }

        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Add Ware House';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/add_warehouse', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data); 
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : View/Edit Ware House
     */
    public function view_warehouse(){
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object  
        
        $setting_model->set_whid($this->uri->segment('2'));
        $body['whinfo'] = $setting_model->fetch_warehouse_details($this->uri->segment('2'));
        if(isset($body['whinfo']['warehouse_id']) && $body['whinfo']['warehouse_id'] != ''){
            //-- Add Ware House  If Post Data  
            if($this->input->post('address') && $this->input->post('warename') && $this->input->post('latlng') && $this->input->post('whid')){ 
                $latlng = explode(',', $this->input->post('latlng'));

                $setting_model->set_whid($this->input->post('whid'));
                $setting_model->set_whaddress($this->input->post('address'));
                $setting_model->set_whname($this->input->post('warename'));
                $setting_model->set_lat($latlng[0]);
                $setting_model->set_lng($latlng[1]);

                $resData = $setting_model->updateWareHouse();
                //echo $this->db->last_query(); die;
                if($resData === -1){
                    echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                }else{
                    echo "<script type='text/javascript'>alert('Ware House has been updated successfully.')</script>";
                    redirect('manage-warehouses','refresh');
                } 

            }

            //echo"<pre>";print_r($body['whinfo']);die;
            $data['title']          = 'View Ware House';
            $data['requiredcss']    = 'setting';
            $data['header']         = array('view' => 'templates/header', 'data' => $data);
            //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
            $data['main_content']   = array('view' => 'setting/view_warehouse', 'data' => $body);
            $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data); 
        }else{
            redirect('manage-warehouses','refresh');
        }
            
    }
    
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Delete Ware House
     */
    public function delete_warehouse(){
        if($this->uri->segment('2') !=''){
            $warehouseId = $this->uri->segment('2'); 
            $setting_model = new Setting_model();
            
            $setting_model->set_whid($warehouseId);
            $resData = $setting_model->delete_wareHouse($this->uri->segment('2'));
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('manage-warehouses','refresh');
            }else{
                echo "<script type='text/javascript'>alert('New Warehouse has been deleted successfully.')</script>";
                redirect('manage-warehouses','refresh');
            }
        }else{
            redirect('manage-warehouses','refresh');
        }            
    }
    
    /** ****************************************
     *  All Setting Section : Restricted Area  *
     ** ****************************************/    
    /*
     * Manage Warehouses |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Admin ware-houses List ()
     */
    public function manage_restricted_areas(){ 
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
        if($this->input->post('searchText') != ''){ 
            $setting_model->setSearchData(strtolower(trim($this->input->post('searchText'))));
        }
        
        $totalPage      = $setting_model->RestrictedAreasCount();
        $baseUrl        = base_url() ."restricted-areas";
        $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
        //echo $totalPage;die;
        if($this->input->post('all') != ''){ 
            $all = true;
            $body['result'] = $setting_model->getAllRestrictedAreas(RECORDS_PERPAGE,$pageFrom,$all);
        }elseif($this->input->get('searchText') != ''){
            $all = false;
            $body['result'] = $setting_model->getAllRestrictedAreas(RECORDS_PERPAGE,$pageFrom,$all);
        }
        else{
            $body['result'] = $setting_model->getAllRestrictedAreas(RECORDS_PERPAGE,$pageFrom,false);
        }
        //echo $setting_model->fetchItemCount(1);die;
        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Reastricted Areas';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/all_areas', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }
    
    /*
     * Manage Warehouses |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Change Warehouse Status  ()
     */
    public function change_banarea_status(){  
        if($this->uri->segment('2') !=''){
            $userId = $this->uri->segment('2'); 
            $setting_model = new Setting_model();
            
            $setting_model->set_whid($userId);
            $resData = $setting_model->changeWareHouseStatus();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('manage-warehouses','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Ware House status has been updated successfully.')</script>";
                redirect('manage-warehouses','refresh');
            }
        }else{
            echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            redirect('manage-warehouses','refresh');
        }   
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Add Ware House
     */
    public function add_restricted_area(){
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object  
        //-- Add Ware House  If Post Data 
        if($this->input->post('resname')){ 
            $setting_model->set_customname($this->input->post('resname'));

            if($this->input->post('week1') && count($this->input->post('week1')) > 0){
                $setting_model->set_customarray($this->input->post('week1'));
                $setting_model->set_customid('1');
                $setting_model->set_zipcode($this->input->post('allowedCode'));
                $resData = $setting_model->addRestrictedArea();
            }else{
                $setting_model->set_customarray($this->input->post('week1'));
                $setting_model->set_customid('1');
                $setting_model->set_zipcode($this->input->post('allowedCode'));
                $resData = $setting_model->addRestrictedArea('0');
            }
            
            if($this->input->post('week2') && count($this->input->post('week2')) > 0){
                $setting_model->set_customarray($this->input->post('week2'));
                $setting_model->set_customid('2');
                $setting_model->set_zipcode($this->input->post('restrictedCode'));
                $resData = $setting_model->addRestrictedArea();
            }else{
                $setting_model->set_customarray($this->input->post('week2'));
                $setting_model->set_customid('2');
                $setting_model->set_zipcode($this->input->post('restrictedCode'));
                $resData = $setting_model->addRestrictedArea('0');
            }
            
            if($this->input->post('week3') && count($this->input->post('week3')) > 0){
                $setting_model->set_customarray($this->input->post('week3'));
                $setting_model->set_customid('3');
                $setting_model->set_zipcode($this->input->post('resDelCode'));
                $resData = $setting_model->addRestrictedArea();
            }else{
                $setting_model->set_customid('3');
                $setting_model->set_zipcode($this->input->post('resDelCode'));
                $resData = $setting_model->addRestrictedArea('0');
            }

            if($resData === -1){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            }else{
                echo "<script type='text/javascript'>alert('New Restricted Area has been updated successfully.')</script>";
                redirect('restricted-areas','refresh');
            } 

        }
        $body['areainfo'] = $setting_model->fetch_restricted_area_details();
        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Add Ware House';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/add_restricted_area', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data); 
    }
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : View/Edit Ware House
     */
    public function view_restricted_area(){
        sessionChk();                        //-- Validating session
        $setting_model = new Setting_model();//-- Model Object  
        
        $setting_model->set_customid($this->uri->segment('2'));
        $body['areainfo'] = $setting_model->fetch_restricted_area_details($this->uri->segment('2'));
        if(isset($body['areainfo']) && count(['areainfo']) > 0){
            //-- Add Ware House  If Post Data  
            if($this->input->post('resname')){ 
                $setting_model->set_customname($this->input->post('resname'));
                
                if($this->input->post('week1') && count($this->input->post('week1')) > 0 && $this->input->post('allowedid')){
                    $setting_model->set_customarray($this->input->post('week1'));
                    $setting_model->set_customid($this->input->post('allowedid'));
                    $setting_model->set_zipcode($this->input->post('allowedCode'));

                    $resData = $setting_model->updateRestrictedArea();
                }
                if($this->input->post('week2') && count($this->input->post('week2')) > 0 && $this->input->post('restrictedid')){
                    $setting_model->set_customarray($this->input->post('week2'));
                    $setting_model->set_customid($this->input->post('restrictedid'));
                    $setting_model->set_zipcode($this->input->post('restrictedCode'));

                    $resData = $setting_model->updateRestrictedArea();
                }
                if($this->input->post('week3') && count($this->input->post('week3')) > 0 && $this->input->post('resDelid')){
                    $setting_model->set_customarray($this->input->post('week3'));
                    $setting_model->set_customid($this->input->post('resDelid'));
                    $setting_model->set_zipcode($this->input->post('resDelCode'));

                    $resData = $setting_model->updateRestrictedArea();
                }


                if($resData === -1){
                    echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                }else{
                    echo "<script type='text/javascript'>alert('Restricted area Statics has been updated successfully.')</script>";
                    redirect('restricted-areas','refresh');
                } 

            }
            // echo"<pre>";print_r($body['areainfo']);die;
            $data['title']          = 'View Restricted Area Detail';
            $data['requiredcss']    = 'setting';
            $data['header']         = array('view' => 'templates/header', 'data' => $data);
            //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
            $data['main_content']   = array('view' => 'setting/view_restricted_area', 'data' => $body);
            $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data); 
        }else{
            redirect('restricted-areas','refresh');
        }
            
    }
    
    
    /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Delete Ware House
     */
    public function delete_restricted_area(){
        if($this->uri->segment('2') !=''){
            $resAreaID = $this->uri->segment('2'); 
            $setting_model = new Setting_model();
            
            $setting_model->set_customid($resAreaID);
            $resData = $setting_model->delete_reatricted_area_record();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('restricted-areas','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Restricted Area record has been deleted successfully.')</script>";
                redirect('restricted-areas','refresh');
            }
        }else{
            redirect('restricted-areas','refresh');
        }            
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
    public function minimum_delivery_prices(){ 
        sessionChk();                        
        $setting_model = new Setting_model();

        //-- All Minimum Delivery Prices
        $body['result'] = $setting_model->fetch_minimum_delivery_prices_records();
        //
        // echo"<pre>";print_r($body['areainfo']);die;
        $data['title']          = 'Minimum Delivery Prices';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/all_min_delivery_prices', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data); 
    }
    
    /*
     * Manage Minimum Prices |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Update Minimum price Row data through Ajax()
     */
    public function update_minimum_delivery_price(){ 
        if( 
            isset($_POST['id']) && $_POST['id'] != '' &&
            isset($_POST['name']) && $_POST['name'] != '' &&
            isset($_POST['rate']) && $_POST['rate'] != '' &&
            isset($_POST['old_rate']) && $_POST['old_rate'] != '' 
          )
        {   
            $setting_model = new Setting_model();//-- Model Object  
            $res = $setting_model->update_min_delivery_prices_record($_POST);
            
            echo $res ? 'true' : 'false' ;
        }else{
            echo "false";
        }
    }
    
    
    /*
     * Manage Minimum Prices |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Update Minimum price Row data through Ajax()
     */
    public function change_min_dvry_price_status(){  
        if($this->uri->segment('2') !=''){
            $userId = $this->uri->segment('2'); 
            $setting_model = new Setting_model();
            
            $setting_model->set_customid($userId);
            $resData = $setting_model->changeMinDelPriceStatus();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('minimum-delivery-prices','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Min. Del. Price Record status has been updated successfully.')</script>";
                redirect('minimum-delivery-prices','refresh');
            }
        }else{
            echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            redirect('minimum-delivery-prices','refresh');
        }   
    }
    
    
    public function manage_taxes(){
         sessionChk();                        //-- Validating session
        $taxes_model = new Taxes_model();//-- Model Object 
        //-- IF SEARCH TEXT EXIST 
            
            
            $totalPage      = $taxes_model->selectTotalRecordCount();
            
            if(is_null($totalPage) || $totalPage=='' ){
                $totalPage =0;
            }
            
            $baseUrl        = base_url() ."taxes";
            $pageFrom       = globalPagination($totalPage,$baseUrl,RECORDS_PERPAGE);
            //echo $totalPage;die;
           
                $all = true;
                $body['result'] = $taxes_model->selectAllTaxex();
           
        //echo $setting_model->fetchItemCount(1);die;
        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Messages Taxes';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        $data['main_content']   = array('view' => 'setting/all_taxes', 'data' => $body);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }

     public function add_tax(){
        sessionChk();                        //-- Validating session
        $taxes_model = new Taxes_model();//-- Model Object  
        //-- Add Doctor If Post Data  
        if($this->input->post()){ 
            $taxes_model->setTax_name($this->input->post('tax_name'));
            $taxes_model->setTax_type($this->input->post('tax_type'));
            $taxes_model->setAmt_value($this->input->post('amt_value'));
            
            $resData = $taxes_model->addNewTax();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('taxes','refresh');
            }else{

                echo "<script type='text/javascript'>alert('New Tax has been added successfully.')</script>";
                redirect('taxes','refresh');
            } 

        }

        //echo"<pre>";print_r($body['result']);die;
        $data['title']          = 'Manage Taxes';
        $data['requiredcss']    = 'setting';
        $data['header']         = array('view' => 'templates/header', 'data' => $data);
        //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
        $data['main_content']   = array('view' => 'setting/add_tax', 'data' => []);
        $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data); 
    }
    
        /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : View/Edit tax 
     */
    public function view_tax(){
        sessionChk();                        //-- Validating session
         $taxes_model = new Taxes_model();//-- Model Object  
        
        $taxes_model->setId($this->uri->segment('2'));
        $body['taxinfo'] = $taxes_model->fetch_tax_details();
        
            //-- Add Doctor If Post Data  
            if($this->input->post()){ 
                $taxes_model->setId($this->input->post('tax_id'));
                $taxes_model->setTax_name($this->input->post('tax_name'));
                $taxes_model->setTax_type($this->input->post('tax_type'));
                $taxes_model->setAmt_value($this->input->post('amt_value'));
                
                $resData = $taxes_model->updateTaxDetails();
                if($resData == '-1'){
                    echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                    redirect('taxes','refresh');
                }else{

                    echo "<script type='text/javascript'>alert('Tax Details has been updated successfully.')</script>";
                    redirect('taxes','refresh');
                } 

            }

            // echo"<pre>";print_r($body['productinfo']);die;
            $data['title']          = 'View Tax Details';
            $data['requiredcss']    = 'setting';
            $data['header']         = array('view' => 'templates/header', 'data' => $data);
            //$data['sidebar']        = array('view' => 'templates/common_sidebar', 'data' => $body);
            $data['main_content']   = array('view' => 'setting/view_tax', 'data' => $body);
            $data['footer']         = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data); 
        
    }
      /*
     * Manage Products | Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Change Tax Status 
     */
    public function change_tax_status(){  
        if($this->uri->segment('2') !=''){
            $taxId = $this->uri->segment('2'); 
            $taxes_model = new Taxes_model();
            
            $taxes_model->setId($taxId);
            $resData = $taxes_model->changeTaxStatus();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('taxes','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Tax status has been updated successfully.')</script>";
                redirect('taxes','refresh');
            }
        }else{
            echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
            redirect('taxes','refresh');
        }   
    }
    
     /*
     * Manage Users |  Setting Section
     * @author : niraj
     * @admin panel 
     * @function for : Delete Tax
     */
    public function delete_tax(){
        
        if($this->uri->segment('2') !=''){
            $taxId = $this->uri->segment('2'); 
            
            $taxes_model = new Taxes_model();
            
            $taxes_model->setId($taxId);
            $resData = $taxes_model->delete_tax();
            if($resData == '-1'){
                echo "<script type='text/javascript'>alert('Something went wrong, please try later.')</script>";
                redirect('taxes','refresh');
            }else{
                echo "<script type='text/javascript'>alert('Tax has been deleted successfully..')</script>";
                redirect('taxes','refresh');
            }
        }else{
            redirect('taxes','refresh');
        }             
    }
}

