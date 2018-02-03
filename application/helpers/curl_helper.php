<?php
function resultData($apiUrl,$parameters,$headers) {
    
    $ch = curl_init();

    //Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $apiUrl);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));

    //Execute post
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result,true);
}

?>