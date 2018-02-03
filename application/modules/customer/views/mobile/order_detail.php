<section class="container mobile-view-container">
    <div class="order_detail_container">
        <ul class="opposite_detail"><?php
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
                <span class="label">Date Ordered:</span>
                <span class="value"><?=$orderDetail[0]->created_at?></span>
            </li>
            <li>
                <span class="label">Date Delivered:</span>
                <span class="value"><?=$orderDetail[0]->delivery_date?></span>
            </li>
            <li>
                <span class="label">Status:</span>
                <span class="value"><?=$orderStatus?></span>
            </li>
<!--            <li>
                <span class="label">Bill Type:</span>
                <span class="value">Self</span>
            </li>-->
            <li>
                <span class="label">Cost:</span>
                <span class="value">$<?=$orderDetail[0]->amount?></span>
            </li>
        </ul>
        <ul class="tabs_menu">
            <li class="active">Products</li>
            <li>Driver</li>
        </ul>
        <div class="detail_tab">
            <div class="product_container">
                <div class="product_list">
                    <?php foreach($orderDetail as $order) {
                        if ($order->item_unit == '1')
                            $weight_in = 'ounce';
                        if ($order->item_unit == '2')
                            $weight_in = 'gram';
                        if ($order->item_unit == '3')
                            $weight_in = 'ml';
                        if ($order->item_unit == '4')
                            $weight_in = 'piece';    

                    ?>
                    <div class="product_card clearfix" style="background:<?= $order->color_code ?> ">
                        <div class="product_detail clearfix green">
                            <div class="pro_img left"><img src="<?=$order->item_image?>" alt="product"></div>
                            <div class="product_info right">
                                <h3><?=$order->item_name?></h3>
                                <div class="about_prdo clearfix">
                                    <p><b>Effect : </b><span class="txt_description"> <?=$order->effect?$order->effect:"-NA-"?></span></p>
                                    <p><b>Flavor : </b><span class="txt_description"><?=$order->flavor?$order->flavor:"-NA-"?></span> </p>
                                    <p class="price_product">$<?= $order->price_one ?>/1 <?= $weight_in ?></p>
                                </div>
                            </div>
                        </div>
<!--                        <div class="card_buttons clearfix">
                            <a href="#" class="add_to_cart">Add to Cart</a>
                            <a href="#" class="add_to_cart">More Info</a>
                        </div>-->
                    </div>
                    <?php }?>
                </div>
            </div>
            <div class="driver_detail">
                <?php if($orderDetail[0]->driver_name != ''){?>
                <div class="profile_overview">
                    <div class="profile_img">
                        <img src="<?=$orderDetail[0]->driver_image?>" alt="user">
                    </div>
                    <div class="user_info">
                        <h2 class="user_name"><?=$orderDetail[0]->driver_name?></h2>
                    </div>
                </div>
                <ul class="opposite_detail">
                    <li>
                        <span class="label">Location</span>
                        <span class="value"><?=$orderDetail[0]->drop_location?></span>
                    </li>
                    <li>
                        <span class="label">Drop Off Date:</span>
                        <span class="value"><?=$orderDetail[0]->delivery_date?></span>
                    </li>
                    <li>
                        <span class="label">Drop Off Time:</span>
                        <span class="value"><?=$orderDetail[0]->delivery_time?></span>
                    </li>
                </ul>
                <?php } else {?>
                    Hasn't assigned any driver...
                <?php }?>
<!--                <button class="btn gradient change_pass">
                    <span class="btn-txt">SUBMIT</span>
                </button>-->
            </div>
        </div>

    </div>
</section>
<script type="text/javascript">
    $(function () {
        $('.tabs_menu li').click(function () {
            $(this).addClass('active').siblings().removeClass('active');
            $(".detail_tab > div").eq($(this).index()).show().siblings().hide()
        });
        if ($('.profile_img img').length && $('.profile_img img').get(0).naturalWidth > $('.profile_img img').get(0).naturalHeight) {
            $('.profile_img').addClass('vertical');
        } else {
            $('.profile_img').addClass('horizontal');
        }
        $('.container').enscroll();
    });
</script>