<section class="container mobile-view-container">
    <div class="my_cart product_list">
        <?php if(sizeof($products) > 0) {?>
        <?php $totalCartValue = 0; foreach($products as $product) {
            // gram
            if ($product->saved_type == 'gram'){
                if($product->price_gram_off > 0){
                    $product_price  =   $product->price_gram_off;
                    $total  =    ($product->quantity*$product->price_gram_off);
                }else{
                    $product_price  =   $product->price_gram;
                    $total  =    ($product->quantity*$product->price_gram);
                }
            }
            // ounce
            if ($product->saved_type == 'ounce'){
                if($product->price_one_off > 0){
                    $product_price  =   $product->price_one_off;
                    $total  =    ($product->quantity*$product->price_one_off);
                }else{
                    $product_price  =   $product->price_one;
                    $total  =    ($product->quantity*$product->price_one);
                }
            }
            // eight
            if ($product->saved_type == 'eight'){
                if($product->price_eight_off > 0){
                    $product_price  =   $product->price_eight_off;
                    $total  =    ($product->quantity*$product->price_eight_off);
                }else{
                    $product_price  =   $product->price_eigth;
                    $total  =    ($product->quantity*$product->price_eigth);
                }
            }
            $totalCartValue =   $total+$totalCartValue;
        ?>
            <div class="product_card product_card_small" id="product_card_<?=$product->cart_id;?>">
                <div class="product_detail d-flex flex-nowrap align-items-center justify-content-start" style="background:<?= $product->color_code ?> ">
                    <a class="delete_ico icon-delete delete_cart_item" data-value="<?= $product->cart_id;?>"></a>
                    <div class="pro_img col-5 px-0"><img src="<?= $product->item_image?>" alt="product"></div>					
                    <div class="product_info col-7 px-0 pl-2">
                        <h3><?= $product->item_name?></h3>
                        <p><b>Price:</b> $<?= $product_price?>/1 <?= $product->saved_type?></p>
                        <div class="qty"><b>Qty :</b> <input type="text" name="quantity" value="<?= $product->quantity?>" disabled=""></div>
                        <h4 class="total_val_<?=$product->cart_id;?>" data-value="<?= $total?>">Total : $<?= $total?></h4>
                    </div>
                </div>
            </div>
        <?php }?>
        <div class="cart_info">
            <ul class="opposite_detail">
                <li>
                    <span class="label">**Min Order for On Demand Delivery:</span>
                    <span class="right">$140</span>
                </li>
                <li>
                    <span class="label">**Min Order Amount:</span>
                    <span class="right">$50</span>
                </li>
                <li class="border_top">
                    <span class="label">Total:</span>
                    <span class="right" id="total_cart_value" data-value="<?= $totalCartValue?>">$<?= $totalCartValue?></span>
                </li>
            </ul>
            <div class="form-container">
                <input type="text" class="gradient_border" name="friend_referral" placeholder="Friend Referral Code">
                <button class="btn gradient change_pass cart_checkout">
                    <span class="btn-txt">Check Out</span>
                </button>
            </div>
        </div>
        
        <?php } else {?>
            Nothing in cart...
        <?php }?>
    </div>
    <?php if ( isset($firstOrder) && $firstOrder == true ): ?>
    <div class="alert alert-container alert-info float-left">
        <div class="alert-content">
            <div class="alert-body">
                <p class="alert-text">The first order has a specially reduced minimum order size of $<?php echo isset($minimumDeliveryAmount) ? $minimumDeliveryAmount->rate : 35 ?>, so you can try out the best of craft cannabis. After that, we still maintain a reasonable order minimum of $70. That saves gas fumes and preserves the earth.</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>
