<section class="container mobile-view-container">
    <div class="order_status_container">
        <ul class="opposite_detail">
            <?php
                if($orderDetail[0]->order_status == 0){
                    $orderStatus    =   'Unsigned';
                }elseif($orderDetail[0]->order_status == 1){
                    $orderStatus    =   'Assigned';
                }elseif($orderDetail[0]->order_status == 2){
                    $orderStatus    =   'in-transit';
                }elseif($orderDetail[0]->order_status == 3){
                    $orderStatus    =   'Hold';
                }elseif($orderDetail[0]->order_status == 4){
                    $orderStatus    =   'Reached';
                }elseif($orderDetail[0]->order_status == 5){
                    $orderStatus    =   'Return';
                }elseif($orderDetail[0]->order_status == 6){
                    $orderStatus    =   'Delivered';
                }elseif($orderDetail[0]->order_status == 7){
                    $orderStatus    =   'Delayed';
                }
            ?>
            <li>
                <span class="label">Order ID:</span>
                <span class="value"><?=$orderDetail[0]->order_id?></span>
            </li>

            <li>
                <span class="label">Ordered On:</span>
                <span class="value"><?=$orderDetail[0]->created_at?></span>
            </li>

            <li>
                <span class="label">Status:</span>
                <span class="value"><?=$orderStatus?></span>
            </li>

            <li>
                <span class="label">Cost:</span>
                <span class="value">$<?=$orderDetail[0]->amount?></span>
            </li>

<!--            <li>
                <span class="label">Bill Type:</span>
                <span class="value">Self</span>
            </li>-->

<!--            <li>
                <span class="label">Payment ID:</span>
                <span class="value"><?=$orderDetail[0]->transaction_id?></span>
            </li>-->
        </ul>
        <p class="status_txt">Your order has been placed successfully! <br> We will keep you updated about your order's status!</p><br><br>
        <p class="beta_text">*** This is the app’s beta version 1.0. We're rapidly improving every week. We'd love it if you sent us feedback and are forgiving as we enhance the app. We reply to everyone. We're dedicated to making InstaCraft an amazing experience for the cannabis community. A journey of a thousand miles begins with one step.</p>
    </div> 
</section>
