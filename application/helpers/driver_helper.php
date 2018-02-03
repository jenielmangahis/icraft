<?php

require APPPATH . 'third_party/jwt/vendor/autoload.php';


    /*     * check user exists */

    function checkDoctorStatus($doctorId) {
        $CI = & get_instance();
        $doctorDetail = $CI->db->select('availablity')
                                ->from('users')
                                ->where('id', $doctorId)
                                ->get();
        if ($doctorDetail->num_rows() > 0) {
            $data = $doctorDetail->row_array();
            return $data;
        }
    }
    
    function checkDoctorDashBoardAvail($doctorId) {
        $CI = & get_instance();
        $doctorDetail = $CI->db->select('*')
                                ->from('doctor_availability')
                                ->where('doctor_id', $doctorId)
                                ->get();
        if ($doctorDetail->num_rows() > 0) {
            $data = $doctorDetail->row_array();
            return $data;
        }
    }
    
    function getUsers($userId) {
        $CI = & get_instance();
        $userDetail = $CI->db->select('*')
                                ->from('users')
                                ->where('id', $userId)
                                ->get();
//        echo $CI->db->last_query();exit;
        if ($userDetail->num_rows() > 0) {
            $data = $userDetail->row_array();
            return $data;
        }
    }
    
     /*     * check user exists */

    function checkDriverLoginStatus($driverEmail,$socialMediaType,$emailId) {
        $CI = & get_instance();
        $CI->db->select('*')->from('tbl_drivers');
        if($socialMediaType == 0){
            $CI->db->where('emailId', trim($driverEmail));
        }else if($socialMediaType == 1){
            $CI->db->where('fbSocialMediaId',$socialMediaId);
        }else if ($socialMediaType == 2){
            $CI->db->where('googleSocialMediaId',$socialMediaId);
        }
       
        $driverDetail = $CI->db->get();
        if ($driverDetail->num_rows() > 0) {
            $data = $driverDetail->row_array();

            if ($data['isDeleted'] == '1') {
                $jsonData = new stdClass();
                $message = $CI->lang->line("driver_delete");
                $bool = FALSE;
                $status = 401;
                $code = REST_Controller::HTTP_OK;
                
                resultJson($jsonData, $status, $bool, $message, $code);
                
            } else if ($data['status'] == '0') {
                $jsonData = new stdClass();
                $message = $CI->lang->line("driver_block");
                $bool = FALSE;
                $status = 402;
                $code = REST_Controller::HTTP_OK;
                
                resultJson($jsonData, $status, $bool, $message, $code);
                
            } else {
                return True;
            }
        } else {
            $jsonData = new stdClass();
            $message = $CI->lang->line("wrong_driver_detail");
            $bool = FALSE;
            $status = 406;
            $code = REST_Controller::HTTP_OK;
            
            resultJson($jsonData, $status, $bool, $message, $code);
        }
    }
    
   

    function pr($array, $opt = 0) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        if ($opt == 1) {
            die;
        }
    }

    function fileImageUploadPic($folderName, $file_name) {
        $config = array();
        $CI = & get_instance();
        $image = '';

        if ($_FILES["$file_name"]['error'] == 0) {

            $pathToUpload = $_SERVER["DOCUMENT_ROOT"].'learn_ent_web/assets/'.$folderName.'/';
            if (!is_dir($pathToUpload)) {
                mkdir($pathToUpload, 0777, TRUE);
            }
            $config['upload_path'] = $_SERVER["DOCUMENT_ROOT"].'/learn_ent_web/assets/'.$folderName.'/';
            //Location to save the image
            $config['allowed_types'] = '*';
            $config['overwrite'] = FALSE;
            $config['remove_spaces'] = true;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 400;
            $config['height'] = 400;

            $config['file_name'] = time() . "_" . str_replace(' ', '_', $_FILES["$file_name"]['name']);

            $CI->load->library('upload', $config);
            $errorsUpload = '';
            $errorResize = '';
            $CI->upload->initialize($config);
            if (!$CI->upload->do_upload("$file_name")) {
                print_r($CI->upload->display_errors());die;
                return "FALSE";
            } else {
    //            $image = "assets/$folderName/" . $CI->upload->file_name;
                return $CI->upload->file_name;
            }

    //        return $image;
        }
    }
    
    function warehouseList(){
        $CI = & get_instance();
        $wareHouseDetail = $CI->db->select('*')
                                ->from('warehouse')
                                ->get();
        if ($wareHouseDetail->num_rows() > 0) {
            $data['warehouseList'] = $wareHouseDetail->result_array();
            //echo "<pre>";print_r($data);die;
            return $data;
        }
    }
    
    function calculateDistanceAndTime($value,$latitude,$longitude){
        $offerDetail = array();
            //Initiate curl
            $ch = curl_init();
            // Disable SSL verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Set the url
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=$latitude,$longitude&destinations=".$value['latitude'].",".$value['longitude']."&key=AIzaSyB3QMmKo-HKVS6WZTwVUAIvrTL-Eq9W61c";
            
            curl_setopt($ch, CURLOPT_URL, $url);
            // Execute
            $result = curl_exec($ch);
            
            // Closing
            curl_close($ch);
            
            $informationData = json_decode($result, true);
            return $informationData;
    }
    
    function distanceTravelled($lat1, $lon1, $lat2, $lon2, $unit) {
        
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        
        if ($unit == "K") {
          return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
        
        

  }
  
    
?>
