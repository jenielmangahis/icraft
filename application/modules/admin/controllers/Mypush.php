<?php
class Mypush extends MX_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('Push_model');
        $this->load->helper('push_helper');
    }

        
    /********************************************************
    *                Push Notification Code Block           *
    *********************************************************/

    /*_______________= Send Push Notification : cron job  =____________*/
    public function sendpush(){   

        $pushModel = new Push_model();
        
        $allusersData = $pushModel->get_usersRecordWithTokens();
        //$allusers     = $pushModel->get_usersRecordWithTokens_plateformWise($allusersData);
        
        //-- Distinct Countries -- Andriod / iOS - Hittable country list Plateform-wise    
        $distinct_countries   = $pushModel->get_all_distinct_countries_from_usersdata($allusersData);
        /*****************************
         *  Push Logic               *
         *****************************/
        if(is_array($distinct_countries) && count($distinct_countries) > 0){
            foreach($distinct_countries as $country){
                //-- hit alert for country > 10 records per hit
                $alertdatas = $pushModel->countryAlerts($country, 3);
                // echo "<pre>";print_r($alertdatas);die;
                // Check if Country Alert results exist
                if(is_array($alertdatas)){
                    $country_users = $pushModel->get_countrywise_users($allusersData, $country);
                    echo "Total Receivers for $country- ";echo count($country_users);echo"<hr>";
                    foreach ($country_users as $user) {
                        $last_push_time = $user['pushtime'];
                        $push_time = strtotime($last_push_time);

                        $badge = $user['push_count'] + 1; //-- Badge Count Increase
                        foreach ($alertdatas as $pushMsg) {
                            $push_alert_time  = str_replace("T"," ",$pushMsg->createdDate);
                            $alert_time       = strtotime($push_alert_time);
                            $update_push_time =  str_replace("T"," ",$alertdatas[0]->createdDate);

                            //--If last push time is less than alert info time then hit push
                            //if($alert_time > $push_time){
                                echo "<b>".$user['dev_type']." : ".$user['email']."[".$badge."](".$update_push_time.")</b>-".$user['token']."-";

                                $push_type         =   1; //- for furure logic
                                /*fccI6hfBH8g:APA91bGH3qfYFmQujqnFiyy1PG_hb8sGVA3G3Uh56IR2VFOgOty1-sxcax-B4uvdd75iKJ5abMWIq2yp2uouCV9GD1y0xl8e9wtlZZWDN-WLF2_08SAgNCjUbQD_99nEzm-uMf8l7v9q*/
                                generatePush($user['dev_type'] , $user['token'], $pushMsg, $user['certificate'], $push_type, $badge);
                                $badge++;
                            //}                        
                        } 
                        //-- Update User Last Push Time                    
                        $pushModel->setPushTime($user['token'],$update_push_time); 
                        
                        //--- Use below func for update user session table with this 
                        //--$pushModel->setPushCountTimeUpdated($user['token'],$update_push_time, $badgeCount)

                    }
                }         
            }
        }else{
            echo "No user Logged into the app.";
        }
            
    }



    /*_______________= Send Push Notification : cron job  =____________*/
    public function alertscountryWise(){ 
        $countryName = 'India';
        $pushModel = new Push_model();
        $response  = $pushModel->countryAlerts($countryName,5);

        $last_push_time = '2017-08-19 14:32:00';
        $push_time = new DateTime($last_push_time);
        

        if(is_array($response)){
            foreach($response as $row){ 
                $push_alert_time = str_replace("T"," ",$row->createdDate);
                $alert_time = new DateTime($push_alert_time);
                if($alert_time > $push_time){
                    echo "Need to be sent";
                }
                echo "<pre>";print_r($row);                

                echo "<hr />";
                // Compare User Last Pust Time 
            }
        }else{
            echo "Country name is not accordingly rules";
        }
    }
    
    
    
    /********************************************************
    *                Country Std Code Block                 *
    *********************************************************/
    
    
    /*_______________= Send Push Notification : cron job  =____________*/
    public function updateCountryStdCode(){ 
        $pushModel = new Push_model();
        $countryWithStd  = $pushModel->get_all_isd();
        $databaseCountryList = $pushModel->getAllCountriesList();
        $i = 0;
        foreach ($databaseCountryList as $dbCountry) {
            $c_code = $dbCountry['countrycode'];
            if (array_key_exists("$c_code", $countryWithStd)){
                $pushModel->setCountryStdcode($c_code, $countryWithStd[$c_code][1]);
                $i++ ;
            }
        }
        echo "<strong>$i times called setStdCode function ";        
    }

    /*_______________= Send Push Notification : cron job  =____________*/
    public function showAllCountry(){ 
        
        $pushModel = new Push_model();
        $response  = $pushModel->getSolaceContryList();
        $response  = json_decode($response);
        //print_r($response[0]);echo "<hr />";
        foreach($response as $row){
            echo "<pre>";print_r($row);echo "<hr />";
        }        
    }




    
}
