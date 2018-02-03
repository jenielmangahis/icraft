<?php

//-- iOS Push Function 
function sendPush($deviceType, $deviceToken, $message, $push_certificate, $push_type, $badge_count) {
    
   if ($push_certificate == '1') { 
        //development push
        $apnsHost = 'gateway.sandbox.push.apple.com';
        $apnsCert = "ck_dev.pem";
    }elseif ($push_certificate == '0') { 
        //distribution push
        $apnsHost = 'gateway.push.apple.com';
        //$apnsHost = 'gateway.sandbox.push.apple.com';
        $apnsCert = "ck_dis.pem";
    }
    
    //$apnsHost = 'gateway.sandbox.push.apple.com';
    //$apnsCert = "ck_dev.pem";
 
    $apnsPort   = '2195';
    $passPhrase = '123456';
    
    $streamContext = stream_context_create();
    
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    $apnsConnection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
//    if ($apnsConnection == false) {
//        echo "Failed to connect {$error} {$errorString}\n";
//      // print "Failed to connect {$error} {$errorString}\n";
//        return;
//    } else {
//        echo "Connection successful";       
//    }

    $payload['aps'] =   array( "mutable-content" => "1" , "riskName" => $message->riskName, "countryName" => $message->countryName , 'badge' => $badge_count);
    $payload['aps']['alert'] = array('title' => $message->countryName." - ".$message->riskName , "body" => $message->categoryName." : ".$message->title);   
    

    $payload = json_encode($payload);
    
    //$deviceToken = "dfe587d02a99d57fa7d785c1901409d408dfa920fa90890fbe3fed1fc090c7ee";
    //$deviceToken = $deviceToken;//"dfe587d02a99d57fa7d785c1901409d408dfa920fa90890fbe3fed1fc090c7ee";

    try {

        $apnsMessage = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
        
            if (fwrite($apnsConnection, $apnsMessage)) {
               echo "Success" ; echo "true";
            } else {
                echo "failed" ; //echo "false";
            }
        //echo "<pre>";print_r($apnsMessage); die;
    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
}


//-- Android Push Function 
function sendAndroidPush($deviceType, $deviceToken, $message, $push_certificate , $push_type, $badge_count) {
    if (is_array($deviceToken)) {
        $registrationIDs = $deviceToken;
    } else {
        $registrationIDs = array($deviceToken);
    }

    // Message to be sent
    $id = rand(1, 100);
    //Set POST variables
    //$url = 'https://android.googleapis.com/gcm/send';
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
        'registration_ids' => $registrationIDs,
        'data' => array('alert' => $message, 'sound' => 'default','badge' => $badge_count, 'push_type' => $push_type)  

    );
    
    $headers = array(
        //'Authorization: key=AAAA4QVuc5M:APA91bEoscctvLX2LG-ys_3l7ISaPgH3GHCOVo3G2bqTL1FXOJrNd8dCFsjmkNhvqlyMFnLESRGMYKc8tOmOBBlzZXqf2DoupJfOy-tJg8SdSuiCAi4flA8N5LQpa_RkZKssjLjacSOnT-kKzN7fPrXJ8J3oL9epTw',
        'Authorization: key=AAAA7o2Mb2s:APA91bFZeTbhvPFzFhg2tl17aOkKqKhEnzhtjDhpSdRBb6C6ckji6_etfAqafOG9QgBVy29iAaiZmR_3UfSy-Y9kcurtnYY_R_6f4pxSaRCxMhwFHHnc2qp3UCyqJMqIayWKiLQjaiZY',
        'Content-Type: application/json'
    );
    //Open connection
    $ch = curl_init();
    //Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    print_r($result);echo "<hr/>";
}




function generatePush($deviceType, $deviceToken, $message, $push_certificate, $push_type, $badge_count_val) {
//    echo "<pre>";print_r($message);die;
    if ($deviceType == 'apk') {
        sendAndroidPush($deviceType, $deviceToken, $message, $push_certificate, $push_type, $badge_count_val);        
        echo "<br>android push<br><br>";
    } else if ($deviceType == 'ios') {
        sendPush($deviceType, $deviceToken, $message, $push_certificate, $push_type, $badge_count_val);                
        echo "<br>iOS push<br><br>";
    } 
}












?>