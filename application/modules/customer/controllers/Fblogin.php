<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fblogin extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('customer/Customer_model');
        $this->load->helper('common_helper');
    }

    function index() {
        $custObj = new Customer_model();
        $fb_config = array(
            'appId' => $this->config->item('facebook_api_key'), // $this->config->item('facebook_api_key'),
            'secret' => $this->config->item('facebook_api_secret') // $this->config->item('facebook_api_secret')
        );
        
        $this->load->library('facebook', $fb_config);
        $user = $this->facebook->getUser();
        if ($user) {
            try {
                $this->load->library('user_agent');
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser();
                }
                $facebookData = $this->facebook->api('/me');
                if (!$facebookData['email']) {
                    echo '<h2 style="text-align:center"><img style="width: 70px; float: left;margin-left:24% " src="' . $this->config->item('templateassets') . 'img/notification_warning.png" /><span style="float: left; margin-top: 25px;">&nbsp;&nbsp;Sorry! Facebook not returned your email id.</span></h2>';
                    die();
                }
                if ($facebookData) {
                    $custObj->set_email($facebookData['email']);
                    $memData = $custObj->getRecordByEmailId();
                    if ($memData) {
                        $this->session->set_userdata('CUSTOMER-ID', $memData->mem_id);
                        $this->session->set_userdata('CUSTOMER-SL', $memData->slug);
                    }else {
                        $member_id = $this->member_model->registerFromFaceBook($facebookData);
                        $custObj->set_email($facebookData['email']);
                        $custObj->set_first_name($facebookData['first_name']);
                        $shuff2  = str_shuffle($facebookData['first_name']);
                        $slug=substr($shuff2,0,8);
                        $custObj->set_slug(create_unique_slug_for_common($slug, 'users'));
                        
                        
//                        $image_url = "https://graph.facebook.com/" . $facebookData['id'] . "/picture?type=large";
//                        $file_name = $facebookData['id'] . '.jpg';
//                        $savepath = './assets/uploads/member/' . $member_id . '/profile_images/' . $file_name;
//                        file_put_contents($savepath, file_get_contents($image_url));
                        //update user image from fb
                        
                        $insertedId =   $custObj->register();
                        
                        $custObj->set_email($insertedId);
                        $memData = $custObj->getRecordByEmailId();
                        
                        $this->session->set_userdata('CUSTOMER-ID', $memData->mem_id);
                        $this->session->set_userdata('CUSTOMER-SL', $memData->slug);
                    }
                    
                    ?>
                    <script type="text/javascript">
                        var browserName = '<?= $agent ?>';
                        if (browserName == 'Firefox')
                        {
                            var loc = '<?= site_url('') ?>';
                            window.opener.location.href = loc;
                            setTimeout(function () {
                                window.close();
                            }, 1000);
                        } else
                        {
                            window.opener.location.reload(true);
                            window.close();
                        }

                    </script>
                    <?php
                }
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }

        if ($user) {
//echo "<pre>";print_($this->facebook->getLogoutUrl())."<br>";
//echo "<pre>";print_r($user);die('hi');
            $data['logout_url'] = $this->facebook->getLogoutUrl();
        } else {
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'scope' => 'email,user_location,user_hometown'
//'redirect_uri' => site_url('dashboard')
            ));
//echo "<pre>";print_r($data);die('login url'); 
            //$this->load->view($this->config->item('template') . '/fblogin', $data);
            ?>
            <script type="text/javascript">
                window.open('<?php echo $data['login_url']; ?>', '_parent');
            //window.location.reload();
            </script>
            <?php
        }
    }

}
?>
