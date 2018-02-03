<?php
class Login extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }


    /*
     * Admin Login Section
     * @author : niraj
     * @admin panel
     * redirects to loginChk if click on submit
     * @All needs the sign in first 
     * @function for : Show login View
     */
    public function login() {
        if ( sessionChk() === true )
        {
            redirect(base_url().'admin-dashboard');
        }
        $data = array();
        $data['header'] = array('view' => 'templates/login_header',$data);
        $data['main_content'] = array('view' => 'login/login',$data);
        $data['footer'] = array('view' => 'templates/login_footer',$data);
        $this->load->view('templates/login_template',$data);
    }
    
    /*
     * Admin Login Section
     * @author : niraj
     * @admin panel
     * @All needs the sign in first 
     * @function for : Validate Login
     */
    public function signIn() {
        
        $adminObj = new Admin_model();
        $emailId  = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        $data = $adminObj->adminLogin($emailId,$password,false); // true if remember
        
        if(count($data) > 1){
            //-- id,email,password,user_right,allowed_menus,created_from,deleted_from,created_date,deleted_time,active
            $session = array('logged_in'=>TRUE,'userdata'=>array('email'=>$data['email'],'loginId'=>$data['id'],'right'=>$data['user_right'],'menus'=>$data['allowed_menus']));
            
            $this->session->set_userdata($session);
            redirect(base_url().'admin-dashboard');
        }
        else
        {
            //echo "<pre>1";print_r($data);die;
            $this->session->set_flashdata('error','Sorry, Invalid email or password');
            $this->session->flashdata('error');
            redirect(base_url().'admin');
        }
    }

    
   /*
    * Forgot Password - Verify & Mail 
    * the admin panel
    * @author Niraj
    */

    public function forgetPassword() {
        //echo "You are here ";die;

        if ($this->input->post('submit') == 'Submit') {

            $adminObj = new Admin_model();
            $emailId = trim($this->input->post('forgetpsw_email'));

            $adminObj->setAdmin($emailId);
            $data = $adminObj->chkUserEmail();
            if($data)
            {
                $name = "there";
                $encodedEmail = base64_encode($email);
                $link = $this->config->base_url() . "forgot_password/" . $encodedEmail;
                $from_email = 'niraj@techaheadcorp.com';
                $email = $email;
                $subject = 'Password Reset Link';
                $emailMessage = '<div style="max-width:640px; margin:auto; padding:0 20px;border:1px solid #d4d2d2;">
                                    <p style="text-align:center;margin:30px 0 30px 0;">
                                            <p style="color:#c51225;font-weight:bold;   font-size:25px; text-align:center; margin:0px;">RESET PASSWORD - TRAVEL ASSIST<span style="color:#256d95; font-size:25px;"></span></p>
                                    </p>  
                                    <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;">Hello <strong>'.$name.'</strong>,</p>
                                    <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;"></p>     
                                    <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;"><a href="'. $link . '" style="padding:4px;background-color:cyan;text-decoration:none;">Click Here To Reset</a></b></p>
                                    <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;">OR copy the link given below in you web browser address bar.</p>  
                                    <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;"><a href="' . $link . '">' . $link . '</a></p>      
                                    <p style="font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#202020; margin:20px 0;">Warm Regards,<br />Travel Assist Support</p>
                                </div>';
                
                sendEmailGlobal($from_email, $email, $name, $subject, $emailMessage, $attachment);
                //echo "Check point 1";die;
                                
                $this->session->set_userdata('SuccessForgotMsg', $this->lang->line('FORGET_PASSWORD_MAIL_SENT'));
                $msg =  $this->lang->line('FORGET_PASSWORD_MAIL_SENT');
                //echo '<script type="text/javascript">alert('.$msg.')</script>';
                redirect(base_url() . "?forget=1");
            } else {
                $this->session->set_userdata('errorForgotMsg', $this->lang->line('EMAIL_NOT_EXIST'));
                $msg =  $this->lang->line('EMAIL_NOT_EXIST');
                //echo '<script type="text/javascript">alert('.$msg.')</script>';
                redirect(base_url() . "?forget=0");
            }
        }else{
            redirect(base_url().'admin');   
        }
    }

    

    /*
    * Reset Password View & Mail
    * the admin panel
    * @author Niraj
    */
    public function changePassword() {
        echo "You are here right";die;
        if ($this->input->post('submit') == 'Save') {
            $this->load->model('Admin_model');
            $adminLoginObj = new Admin_model();

            $adminLoginObj->setId($this->session->userdata('loginId'));
            $adminLoginObj->setPassword($this->input->post('current_password'));
            $adminLoginObj->setNew_password($this->input->post('new_password'));
            $adminLoginObj->setConfirm_password($this->input->post('confirm_password'));

            $this->form_validation->set_rules('current_password', 'current_password', 'required');
            $this->form_validation->set_rules('new_password', 'new_password', 'required');
            $this->form_validation->set_rules('confirm_password', 'confirm_password', 'required');
            if ($this->form_validation->run() == FALSE) {
                redirect(base_url() . "change_password");
            } else {
                if (!$adminLoginObj->checkOldPassword()) {
                    $this->session->set_userdata('errorMsg', $this->lang->line('invalid_curr_password'));
                    redirect('change_password');
                } else {
                    if ($adminLoginObj->changePassword()) {
                        $this->session->set_userdata('SuccessMsg', $this->lang->line('password_changed'));
                        redirect('change_password');
                    } else {
                        $this->session->set_userdata('errorMsg', $this->lang->line('error_msg'));
                        redirect('change_password');
                    }
                }
            }
        }
        $data['header'] = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar'] = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content'] = array('view' => 'login/change_password', 'data' => $data);
        $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }


    /*
     * Admin Log out section where admin/editor/author logout from 
     *  the admin panel
     * @author Ankit
     * @functionName signOut
     * @access Public
     * @return string as TRUE or False
     * @return $data
     */

    public function signOut() {
        $array_items = array('email' => '', 'loginId' => '', 'logged_in' => '');
        $this->session->unset_userdata($array_items);
        $this->session->sess_destroy();
        redirect('admin');
    }

    

    public function underconstruction() {
        $data['header'] = array('view' => 'templates/header', 'data' => $data);
        $data['sidebar'] = array('view' => 'templates/common_sidebar', 'data' => $data);
        $data['main_content'] = array('view' => 'underconstruction', 'data' => $data);
        $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
        $this->load->view('templates/common_template', $data);
    }


    /*
    * Reset Password View & Mail
    * for travel app
    * @author Niraj
    */
    public function resetPassword() {
        //echo "You are here right-1";die;
        if($this->input->get('cp') != ''){
            $this->session->unset_userdata('change_password_success');
            $coded_email = trim($this->input->get('cp'));
            $adminObj = new Admin_model();
            $alluserdata  = $adminObj->check_forgot_password_user($email);

            //print_r($alluserdata);die;

            if(isset($alluserdata[$coded_email])){
                $gotEmail = $alluserdata[$coded_email];
                $rawChkData = explode("&", $alluserdata[$gotEmail]);
                //print_r($rawChkData);die;
                $psw_apply_chk = $rawChkData[0];
                $psw_time_ckk  = $rawChkData[1];
                if($psw_apply_chk == '1'){
                    $sidebar_data['pageError']  = "valid_uri";
                    $sidebar_data['user_email'] = $alluserdata[$coded_email];
                    $data['header'] = array('view' => 'templates/header', 'data' => $data);
                    $data['sidebar'] = array('view' => 'templates/common_forgot_password_sidebar', 'data' => $sidebar_data);
                    //$data['sidebar'] = array('view' => 'templates/sidebar_forget_password', 'data' => $data);
                    $data['main_content'] = array('view' => 'login/change_password', 'data' => $data);
                    $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
                    $this->load->view('templates/common_template', $data);
                }else{
                    $sidebar_data['pageError'] = "expired_uri";
                    $data['header'] = array('view' => 'templates/header', 'data' => $data);
                    $data['sidebar'] = array('view' => 'templates/common_forgot_password_sidebar', 'data' => $sidebar_data);
                    //$data['sidebar'] = array('view' => 'templates/sidebar_forget_password', 'data' => $data);
                    $data['main_content'] = array('view' => 'login/change_password', 'data' => $data);
                    $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
                    $this->load->view('templates/common_template', $data);
                }

                    
            }else{
                $sidebar_data['pageError'] = "invalid_uri";
                $data['header'] = array('view' => 'templates/header', 'data' => $data);
                $data['sidebar'] = array('view' => 'templates/common_forgot_password_sidebar', 'data' => $sidebar_data);
                //$data['sidebar'] = array('view' => 'templates/sidebar_forget_password', 'data' => $data);
                $data['main_content'] = array('view' => 'login/change_password', 'data' => $data);
                $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
                $this->load->view('templates/common_template', $data);
            }
        }elseif($this->input->post('submit') == 'Update'){


            if($this->input->post('user_email',true) && $this->input->post('new_password',true) && $this->input->post('confirm_password',true)){
                
                if(!$this->session->userdata('change_password_success')){
                    $email    = $this->input->post('user_email');
                    $newpsw   = $this->input->post('new_password');
                    $cnfrmpsw = $this->input->post('confirm_password');

                    if($newpsw == $cnfrmpsw){
                        //--- Set TUser Password 
                        $adminObj = new Admin_model();
                        $res = $adminObj->update_userPassword($email, $newpsw);
                        if($res){
                            $this->session->set_userdata('change_password_success',true);

                            $sidebar_data['pageError'] = "password_change_success";
                            $data['header'] = array('view' => 'templates/header', 'data' => $data);
                            $data['sidebar'] = array('view' => 'templates/common_forgot_password_sidebar', 'data' => $sidebar_data);
                            //$data['sidebar'] = array('view' => 'templates/sidebar_forget_password', 'data' => $data);
                            $data['main_content'] = array('view' => 'login/change_password', 'data' => $data);
                            $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
                            $this->load->view('templates/common_template', $data);
                        }else{
                            echo "right check";die;
                        }
                        
                    }else{
                        $this->session->unset_userdata('change_password_success');
                        $sidebar_data['pageError']  = "password_not_match";
                        $sidebar_data['user_email'] = $adminObj->getUserEmail();
                        $data['header'] = array('view' => 'templates/header', 'data' => $data);
                        $data['sidebar'] = array('view' => 'templates/common_forgot_password_sidebar', 'data' => $sidebar_data);
                        //$data['sidebar'] = array('view' => 'templates/sidebar_forget_password', 'data' => $data);
                        $data['main_content'] = array('view' => 'login/change_password', 'data' => $data);
                        $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
                        $this->load->view('templates/common_template', $data);
                    }


                }else{
                    $sidebar_data['pageError'] = "password_change_success";
                    $data['header'] = array('view' => 'templates/header', 'data' => $data);
                    $data['sidebar'] = array('view' => 'templates/common_forgot_password_sidebar', 'data' => $sidebar_data);
                    //$data['sidebar'] = array('view' => 'templates/sidebar_forget_password', 'data' => $data);
                    $data['main_content'] = array('view' => 'login/change_password', 'data' => $data);
                    $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
                    $this->load->view('templates/common_template', $data);
                }
                
                
            }else{
                redirect('change_password');   
            }

            
        }else{
            $sidebar_data['pageError'] = "invalid_link";
            $data['header'] = array('view' => 'templates/header', 'data' => $data);
            $data['sidebar'] = array('view' => 'templates/common_forgot_password_sidebar', 'data' => $sidebar_data);
            //$data['sidebar'] = array('view' => 'templates/sidebar_forget_password', 'data' => $data);
            $data['main_content'] = array('view' => 'login/change_password', 'data' => $data);
            $data['footer'] = array('view' => 'templates/footer', 'data' => $data);
            $this->load->view('templates/common_template', $data);
        }  
    }

}
?>