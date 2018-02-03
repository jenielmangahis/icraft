<?php
require APPPATH . 'third_party/jwt/vendor/autoload.php';
use \Firebase\JWT\JWT;
define('FROM_EMAIL', "support@getinstacraft.com");


    function authenticate_get() {
        
        $secretkey = secretKey;
        $token = array(
            "username" => "CoMmU^eC@!N",
            "password" => "CoMmU^eC@!N@El4512008",
            "iat" => currentUTCTime,
            "exp" => nextOneHourTime
        );

        try {
            $jwt['token'] = JWT::encode($token, $secretkey);

            $jsonData = $jwt;
            $message = 'Auth token generated successfully.';
            $bool = 1;
            $status = 200;
            $code = 200;
        } catch (Exception $e) {

            $jwt['token'] = "";
            $jsonData = $jwt;
            $message = 'Something went wrong, Please try again.';
            $bool = 0;
            $status = 400;
            $code = 400;
        }

        $message = [
            'Success' => $bool,
            'Status' => $status,
            'Message' => $message,
            'Result' => $jsonData,
        ];

        return $message;
    }

//function to decode the auth token key provided from headers
function verifyTokenValidity($authToken) { 
    try {
        $decoded = JWT::decode($authToken, secretKey, array('HS256'));
        if(count($decoded) > 0){
            return TRUE;
        }
    
    } catch (Exception $ex) { 
        $jsonData = new stdClass();
        //$message  = 'Caught exception: '.$ex->getMessage();
        $message  = currentUTCTime.','.nextOneHourTime;
        $bool     = 0;
        $status   = 401;
        //$code = REST_Controller::HTTP_OK;
        $setParams = [
                'success' => $bool,
                'status'  => $status,
                'message' => $message,
                'result'  => $jsonData
            ];
        // echo json_encode($setParams);die;
        return json_encode($setParams); 
    exit();
    }
}

//generate token and save into some session variable
function generateAuthTokenSession($url,$params=""){
    $CI = & get_instance();
    $ch = curl_init();
    $CI->load->library('session');

    curl_setopt($ch, CURLOPT_URL, $url.'?'.$params ); //Url together with parameters
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    
    $contents = curl_exec($ch);
    $headers = curl_getinfo($ch);

    $token = json_decode($contents, TRUE);
    $authToken = $token['Result']['token'];
    $CI->session->set_userdata('token',$authToken);
}


function sendEmailGlobal($from_email_subject, $email,$name,$subject, $emailMessage, $attachment) {
	//ini_set('max_execution_time', '0');
    $CI = & get_instance();
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
    $CI->load->library('email');
    //$CI->email->initialize($config);
    $CI->email->from(FROM_EMAIL, $from_email_subject);
    $CI->email->to($email, $name);
    $CI->email->subject($subject);
    $CI->email->message($emailMessage);
    //$CI->email->attach($attachment);

    if ($CI->email->send() == true) {
		//echo 'mail sent';
        return true;
    } else {
       // echo '<pre>2hh';print_r($CI->email->print_debugger());die;
        return false;
    }
}

function uploadImageOnS3($new_name,$fileTempName,$directory){
   if (S3::putObjectFile($fileTempName,"instacraft1",$directory."/".$new_name,S3::ACL_PUBLIC_READ)) {
      $furl = "http://instacraft1.s3.amazonaws.com/".$directory.'/'.$new_name;
      return $furl;
               
            } else {
             
            return FALSE;

            }       
}

function uploadpdfOnS3($new_name,$fileTempName,$directory){
   if (S3::putObjectFile($fileTempName,"instacraft1",$directory."/".$new_name,S3::ACL_PUBLIC_READ)) {
      $furl = "http://instacraft1.s3.amazonaws.com/".$directory.'/'.$new_name;
      return $furl;
               
            } else {
             
            return FALSE;

            }       
}
    
    


?>
