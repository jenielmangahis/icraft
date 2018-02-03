<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("Login_model");
         //$this->load->library('upload');
       
    }
    
    
    
    public function login() {
        $this->load->view('login.php');
    }
    
    public function signIn() {
        
        $webObj = new Login_model();
        $emailId = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        $data = $webObj->webLogin($emailId,$password);
        
        if(count($data) > 0){
            
            if($data['doctor']['user_type'] == '1'){
                $session = array(
                                    'doctor_id'=>$data['doctor']['id'],
                                    'email'=>$data['doctor']['email'],
                                    'first_name'=>$data['doctor']['first_name'],
                                    'last_name'=>$data['doctor']['last_name'],
                                    'profile_pic'=>$data['doctor']['profile_pic'],
                                    'phone_number'=>$data['doctor']['phone_number'],
                                    'gender'=>$data['doctor']['gender']
                                );

                
                $this->session->set_userdata($session);
                redirect(base_url().'dashboard');

                
            }else{
                $this->session->set_flashdata('error','You are not registered doctor');
                $this->session->flashdata('error');
                redirect(base_url().'login');
            }
            
        }else{
            $this->session->set_flashdata('error','Sorry, Invalid email or password');
            $this->session->flashdata('error');
            redirect(base_url().'login');
        }

        
        
    }
    
    
    public function doctor_login(){
        $webObj = new WebLogin_model();
        $urlAuth = $this->config->item("base_url_api").'auth';
        
        $authParams = array (
            'userid' => $this->session->userdata('userId')
        );
        
        $params = '';
        foreach($authParams as $key => $value){
            $params .= $key.'='.$value;
        }
        
        generateAuthTokenSession($urlAuth,$params);
        $data['userdetails'] = $webObj->getUserData($this->session->userdata('userId'));
        $data['profession'] = $webObj->getAllProfessionalList();
        $data['header'] = array('view' => 'templates/header', 'data' => $data);//calls header.php file
        $data['main_content'] = array('view' => 'Studentlogin/StudLogin', 'data' => $data);//calls main content/body
        $data['footer'] = array('view' => 'templates/footer', 'data' => $data);//calls footer.php file
        $this->load->view('templates/common_templates', $data);//load all the three sections in view from here
    }

    

    
    public function signOut() {
        //every element of session is unset seperately so that it wont effect admin login session
        $this->session->unset_userdata('doctor_id');
        $this->session->unset_userdata('first_name');
        $this->session->unset_userdata('last_name');
        $this->session->unset_userdata('profile_pic');
        $this->session->unset_userdata('phone_number');
        $this->session->unset_userdata('gender');
        //$this->session->sess_destroy();
        redirect($this->config->base_url());
       
    }
    
    public function registerSubmit(){
        
        $obj = new WebLogin_model();
         if (isset($_FILES['signup_img']) && $_FILES['signup_img']['error'] == 0){
                 $folderName='images';
                $imgname=fileImageUploadPic($folderName,'signup_img');
         }
        

//          $cropped_path = $_SERVER['DOCUMENT_ROOT'] . "/learn_ent/assets/images/".$imgname;
//            if ($this->s3->putObjectFile($cropped_path, "learnent", "profile_pic/" . $imgname,$this->s3->ACL_PUBLIC_READ)) {
//                $_POST['profile_image'] = "https://s3-us-west-2.amazonaws.com/learnent/profile_pic/" . $imgname;
//            }else if($imgname == ''){
//
//              $_POST['profile_image']="";
//            }else{
//
//              $_POST['profile_image']="52.36.77.5/learn_ent/assets/images/".$imgname;
//            }
                 



       
         
        $id = $obj->registrationData($_POST);//post all the form data to database and get id.
        if($id){
            $getuserdata = $obj->getUserData($id);//fetch userdata by insert Id/
            
                $id = $getuserdata[0]['id'];//fetch id to send mail.
                $emailId = $getuserdata[0]['email'];//fetch emailId to send mail.
                $first_name = $getuserdata[0]['first_name'];//fetch id to send mail.
                $last_name = $getuserdata[0]['last_name'];//fetch emailId to send mail.
            
            
            $mailMe = $obj->sendMail($id,$emailId,$first_name,$last_name);//need to check the condition wehter the mail is send on not. 
            
            if($mailMe){
                $result=array('result'=>$id,'success'=>'ok','message'=>'Record inserted successfully','status_code'=>200);
            }else{
                $result=array('result'=>$emailId,'success'=>'fail','message'=>'Mail not sent','status_code'=>400);
            }
            
        }else{
            $result=array('result'=>'','success'=>'fail','message'=>'somthing went wrong','status_code'=>400);  
        }
        echo json_encode($result); 
        exit;
    }
    
    
    

    public function updateimg(){
        $obj = new WebLogin_model();
        $profileData = array();
            if (!empty($_FILES['profilePic']['name'])) { 
                    if ($_FILES['profilePic']['error'] == 0) {

                        //upload and update the file
                        $folderName = 'image';
                        $pathToUpload = 'assets/' . $folderName;
                        if (!is_dir($pathToUpload)) {
                            mkdir($pathToUpload, 0777, TRUE);
                        }

                        $config['upload_path'] = './assets/image/';
                        // Location to save the image
                        $config['allowed_types'] = '*';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = true;
                        $config['maintain_ratio'] = TRUE;
                        $config['max_size'] = '0';
                        
                        $imgName = date("Y-m-d");

                        $config['file_name'] = $imgName . time() . $_FILES['profilePic']['name'];
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('profilePic')) { echo $this->upload->display_errors();die;
                            $jsonData = array();
                            $message = strip_tags($this->upload->display_errors());
                            $bool = 0;
                            $status = 400;

                            $setParams = [
                                'Success' => $bool,
                                'Status' => $status,
                                'Message' => $message,
                                'Result' => $jsonData,
                            ];

                            $this->set_response($setParams, $code);
                        } else { 

                            $relative_url = base_url().'assets/image/' . $this->upload->file_name;
                            $sess_array = array('profilePic' => $relative_url);
                            $this->session->set_userdata($sess_array);
                        }
                    }
                }
            
            
            //upload and update the file
            
            
        //}
        
        $URL =  $this->config->item("base_url_api").'updateProfile';
        
        $postdata = array('userId'=>$_POST['userId'],
           'firstName'=> $_POST['firstName'],
           'lastName'=> $_POST['lastName'],
           'countryCode'=>$_POST['countryCode'],
           'mobileNo'=> $_POST['mobileNo'],
           'professionId'=>$_POST['professionId']
        );
        $this->session->userdata('profilePic');
        $token = $this->session->userdata('token');
        $urlAuth = $this->config->item("base_url_api").'auth';
        
        $authParams = array (
            'userid' => $this->session->userdata('userId')
        );
        
        $params = '';
        foreach($authParams as $key => $value){
            $params .= $key.'='.$value;
        }
        
        $header = array(
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded',
                    'token: '.$token
                );
        
        $contents = getContent($URL,$postdata,$header);
        
        $profileData['json'] = json_decode($contents, true);
        if($profileData['json']['Status'] == 401){
            generateAuthTokenSession($urlAuth,$params);
            $token   = $this->session->userdata('token');
            $header = array(
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded',
                    'token: '.$token
            );
            $contents = getContent($URL,$postdata,$header); 
            $profileData['json'] = json_decode($contents, true);
        }
        
        $profileData['json'] = json_decode($contents,true);
        
        $sess_array = array(
               'profilePic' => $targetFile,
               'firstName' => $profileData['json']['Result']['firstName'],
               'lastName' => $profileData['json']['Result']['lastName'],
               'mobileNo' => $profileData['json']['Result']['mobileNo']
               );
        echo $contents;

    }
    
    public function Crop(){
        $data['profilePic'] = $this->input->post('profilePic');
        $data['userId'] = $this->input->post('userId');
        
        $this->load->view('Studentlogin/Crop',$data);
        
    }
    
    public function cropAndSave(){
        
        $targ_w = $this->input->post('w');
        $targ_h = $this->input->post('h');
        $jpeg_quality = 90;

        $src = $this->input->post('image');
        
        $imginfo = pathinfo($src);
       
        switch ($imginfo['extension']) {
            case "GIF"  : $img_r = imagecreatefromgif($src);  break;
            case "gif"  : $img_r = imagecreatefromgif($src);  break;
            case "JPEG" : $img_r = imagecreatefromjpeg($src); break;
            case "jpeg" : $img_r = imagecreatefromjpeg($src); break;
            case "JPG" : $img_r = imagecreatefromjpeg($src); break;
            case "jpg" : $img_r = imagecreatefromjpeg($src); break;
            case "PNG"  : $img_r = imagecreatefrompng($src);  break;
            case "png"  : $img_r = imagecreatefrompng($src);  break;
          }
            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
            $image_name = $this->session->userdata('userId').'_'.time()."upload_image.jpg";
            $dbImageURL = 'assets/images/'.$image_name;
            
            $cropped_path = $_SERVER['DOCUMENT_ROOT'] . "/learn_ent_web/assets/image/" . $image_name;

            imagejpeg($dst_r, $cropped_path);

//            if ($this->s3->putObjectFile($cropped_path, "learnent", "profile_pic/" . $image_name, $this->s3->ACL_PUBLIC_READ)) {
//                $furl = "https://s3-us-west-2.amazonaws.com/learnent/profile_pic/" . $image_name;
//            }
            if ($this->s3->putObjectFile($cropped_path, "learnent", "profile_pic/" . $image_name,$this->s3->ACL_PUBLIC_READ)) {
                $furl = "https://s3-us-west-2.amazonaws.com/learnent/profile_pic/" . $image_name;
            }

            foreach(glob($_SERVER['DOCUMENT_ROOT'] . "/learn_ent/assets/images/profile_pic/".$this->session->userdata('userId').'_*') as $image)   
            {  
    //            echo "Filename: " . $image . "<br />";  
                unlink($image);
            }

            
            $upImage = updateImageandCreateSession($furl);
            if($upImage){
                $relURL = $image_name;
                $sess_array = array('profilePic'=>$furl);
                $this->session->set_userdata($sess_array);
                redirect('website/WebLogin/editprofile'); 
            }
           
            
            
       
    }

    
    public function forgotpassword(){
        $data['header'] = array('view' => 'templates/header', 'data' => $data);//calls header.php file
        $data['main_content'] = array('view' => 'Studentlogin/ForgotPassword', 'data' => $data);//calls main content/body
        $data['footer'] = array('view' => 'templates/footer', 'data' => $data);//calls footer.php file
        $this->load->view('templates/common_templates', $data);//load all the three sections in view from here
    }
    
    
    public function Changepwd(){
        $webObj = new Login_model();
        $data['userdetails'] = $webObj->getUserData();
        $oldPassword = md5($this->input->post('current_password'));
        $data['userdetails']['password'];
        if($oldPassword == $data['userdetails']['password']){
            $data = $webObj->setNewPassword($this->input->post('new_password'));
            echo $data;
        }else{
            echo 0;
        }
        
       
   
    }
 }       