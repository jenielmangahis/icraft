<?php

require_once('vendor/autoload.php');
session_start();
if(!empty($_POST)){
\Stripe\Stripe::setApiKey("sk_test_xz7rdQAbcdqZ9wL9mYhQa8Sn");
// Token submitted by the plan form:
//print_r($_POST);
if($_POST['stripeFunding'] == 'credit'){
    $amoutnToBePaid =   (2900+(((29*3)/100)* 100));
}else{
    $amoutnToBePaid =    2900;
}
//echo $amoutnToBePaid;die;
// Charge the user card:
$charge = \Stripe\Charge::create(array(
            "amount" => $amoutnToBePaid,
            "currency" => "usd",
            "description" => "Appointment",
            "source" => $_POST['stripeSource']
        ));


if ($charge->amount_refunded == 0) {
    $data['id']   =   $charge->id;
    $data['amount_refunded']   =   $charge->amount_refunded;
    $data['amount']   =   '29';
    $data['processing_fee']   =   ((29*3)/100);
    $data['amount_refunded']   =   $charge->amount_refunded;
    $data['balance_transaction']   =   $charge->balance_transaction;
    $data['captured']   =   $charge->captured;
    $data['created']   =   $charge->created;
    $data['currency']   =   $charge->currency;
    $data['description']   =   $charge->description;
    $data['failure_code']   =   $charge->failure_code;
    $data['failure_message']   =   $charge->failure_message;
    $data['fraud_details']   =   $charge->fraud_details;
    $data['invoice']   =   $charge->invoice;
    $data['card_type']   =   $_POST['stripeFunding'];
    //$chargeJson = json_decode($charge);
    
    if ($charge->amount_refunded == 0) {
        echo "Transaction completed successfully";
    } else {
        echo "Transaction has been failed";
    }
    
    header('Location: https://instacraftcannabis.com/instacraftgit/cus-prescription-payment?data='.serialize($data));
    echo "Transaction completed successfully";
} else {
    echo "Transaction has been failed";
}
}else{
    echo "Something went wrong, Please try again.";
    header('Location: https://instacraftcannabis.com/instacraftgit/cus-home');
}
// header('Location: http://localhost/instacraft/cus-prescription-payment?data='.serialize($data));
?>