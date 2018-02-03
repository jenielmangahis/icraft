<section class="container mobile-view-container">
    <div class="my_order_container">
        <?php foreach($orders as $order) {?>
        <a class="border_box clearfix order_detail" href="<?=base_url()?>cus-order-detail?order_id=<?=$order->order_id?>">
            <ul class="opposite_detail">
                <li>
                    <span class="label">Order ID Number:</span>
                    <span class="value"><?=$order->order_id?></span>
                </li>
                <li>
                    <span class="label">Cost:</span>
                    <span class="value">$<?=$order->amount?></span>
                </li>
                <li>
                    <span class="label">Status:</span>
                    <span class="value"><?=$order->order_status?></span>
                </li>
                <li>
                    <span class="label">Bill Type:</span>
                    <span class="value">Self</span>
                </li>
                <li>
                    <span class="label">Date Deliverd:</span>
                    <span class="value"><?=$order->delivery_date?></span>
                </li>
                <li>
                    <span class="label">Date Ordered:</span>
                    <span class="value"><?=$order->created_at?></span>
                </li>
            </ul>
        </a>
        <?php }?>
    </div> 
</section>
