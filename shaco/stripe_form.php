<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

<?php
require_once('vendor/autoload.php');
if (!empty($_POST['stripeToken'])) {
    \Stripe\Stripe::setApiKey("sk_test_xz7rdQAbcdqZ9wL9mYhQa8Sn");
    // Token submitted by the plan form:
    $stripetoken = $_POST['stripeToken'];
    // Charge the user card:
    $charge = \Stripe\Charge::create(array(
                "amount" => 2900,
                "currency" => "usd",
                "description" => "Appointment",
                "source" => $stripetoken,
                "metadata" => array("purchase_order_id" => "SKA123456") // Custom parameter
    ));
    
    $data['id']   =   $charge->id;
    $data['amount_refunded']   =   $charge->amount_refunded;
    $data['amount']   =   $charge->amount;
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
    //$chargeJson = json_decode($charge);
    
    if ($charge->amount_refunded == 0) {
        echo "Transaction completed successfully";
    } else {
        echo "Transaction has been failed";
    }
    
    header('Location: http://localhost/instacraft/cus-prescription-payment?data='.serialize($data));

    //redirect('http://localhost/instacraft/cus-prescription-payment');
} else {
    echo "Transaction has been failed Token Emp";
}
?>

<form action="stripe_form.php" method="post">
    <script
    	src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    	data-key="pk_test_bsurFIJUqWZllRz2lqjTcwKq"
    	data-amount="2900"
    	data-locale="us-en"
    	data-name="Product Plan Demo"
    	data-description="Product description ($10)"
    	data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    	>
    </script>
</form>
<!--<form id="send_back" action="http://localhost/instacraft/cus-prescription-payment" method="post">
    <input type="hidden" name="stripe_data[]" id="stripe_data" value="">
</form>
$(document).ready(function(){
    if(<?=$data['amount_refunded']?> != 0){
        $('#stripe_data').val('<?=$$data?>');
        $('#send_back').submit();
    }
});-->