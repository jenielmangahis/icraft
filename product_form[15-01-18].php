<?php
require_once('vendor/autoload.php');
session_start();
if (!empty($_POST['stripeToken'])) {
    
    \Stripe\Stripe::setApiKey("sk_test_xz7rdQAbcdqZ9wL9mYhQa8Sn");
    // Token submitted by the plan form:
    $stripetoken = $_POST['stripeToken'];
    // Charge the user card:
    $charge = \Stripe\Charge::create(array(
                "amount" => ($_SESSION['amount']*100),
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
        /********* update order table against this order in db ******************/
        $conn = mysqli_connect('instacraftdb.c7mkioq7chm7.us-west-2.rds.amazonaws.com','instacraftdb','Hd5Kgj2wfS3','instacraft')
        or die('Error connecting to MySQL server.');
        if($charge->failure_code == ''){
            $status =    'success';
        }else{
            $status =    'fail';
        }
        $sqll = "UPDATE orders SET "
                . "transaction_id='".$charge->id."',"
                . "transaction_no='".$charge->balance_transaction."',"
                . "amount_refunded='".$charge->amount_refunded."' ,"
                . "captured='".$charge->captured."' ,"
                . "currency='".$charge->currency."' ,"
                . "description='".$charge->description."' ,"
                . "failure_code='".$charge->failure_code."' ,"
                . "failure_message='".$charge->failure_message."' ,"
                . "invoice='".$charge->invoice."' ,"
                . "status='".$status."' ,"
                . "pay_status='1'"
                . "WHERE order_id='".$_SESSION['order_id']."'";

        if ($conn->query($sqll) === TRUE) {
            $deleteCart = "delete from cart where user_id ='".$_SESSION['user_id']."'";
            if ($conn->query($deleteCart) === TRUE) {
                header('Location: https://instacraftcannabis.com/instacraft/cus-order-status?order_id='.$_SESSION['order_id']);
            }
        } else {
        }
        echo "Transaction completed successfully";
    } else {
        echo "Transaction has been failed";
    }
    
   // header('Location: http://localhost/instacraft/cus-prescription-payment?data='.serialize($data));

} else {
    if($_POST['payable_amount'] != '' && $_POST['order_id'] != ''){
        $_SESSION['amount']     =   $_POST['payable_amount'];   
        $_SESSION['order_id']   =   $_POST['order_id'];   
        $_SESSION['user_id']    =   $_POST['user_id'];   
    }
    //echo "Transaction has been failed Token Emp";
}
?>

<form action="product_form.php" method="post">
    <script
    	src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    	data-key="pk_test_bsurFIJUqWZllRz2lqjTcwKq"
    	data-amount="$<?=($_SESSION['amount']*100)?>"
    	data-locale="us-en"
    	data-name="Product Plan Demo"
    	data-description="Product description (<?=($_SESSION['amount'])?>)"
    	data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    	>
    </script>
</form>
