<?php
function readJson($json) {
    if (isset($json) && !empty($json)) {
        $dataArray = json_decode($json, true);
        return $dataArray;
    } else {
        return FALSE;
    }
}

function resultJson($jsonData="",$status="",$bool="",$message="",$code=""){
    $CI = & get_instance();
    $setParams = [
            'Success' => $bool,
            'Status'  => $status,
            'Message' => $message,
            'Result'  => $jsonData,
        ];

    $CI->set_response($setParams, $code);
}
?>