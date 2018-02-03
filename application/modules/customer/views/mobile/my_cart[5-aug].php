<section class="container">
    <div class="my_cart product_list">
        <?php if(sizeof($products) > 0) {?>
        <?php $totalCartValue = 0; foreach($products as $product) {
            $totalCartValue =   $product->total+$totalCartValue;
            if ($product->item_unit == '1')
                $weight_in = 'ounce';
            if ($product->item_unit == '2')
                $weight_in = 'gram';
            if ($product->item_unit == '3')
                $weight_in = 'ml';
            if ($product->item_unit == '4')
                $weight_in = 'piece';
        ?>
            <div class="product_card product_card_small clearfix" id="product_card_<?=$product->cart_id;?>">
                <div class="product_detail clearfix" style="background:<?= $product->color_code ?> ">
                    <a class="delete_ico icon-delete delete_cart_item" data-value="<?= $product->cart_id;?>"></a>
                    <div class="pro_img left"><img src="<?= $product->item_image?>" alt="product"></div>					
                    <div class="product_info right">
                        <h3><?= $product->item_name?></h3>
                        <p><b>Price:</b> $<?= $product->price_one ?>/1 <?= $weight_in?></p>
                        <div class="qty"><b>Qty :</b> <input type="text" name="quantity" value="<?= $product->quantity?>" disabled=""></div>
                        <h4 class="right">$<?= $product->total?></h4>
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
                    <span class="right" id="total_cart_value">$<?= $totalCartValue?></span>
                </li>
            </ul>
            <div class="form-container">
                <button class="btn gradient change_pass cart_checkout">
                    <span class="btn-txt">Check Out</span>
                </button>
            </div>
        </div>
        <?php } else {?>
            Nothing in cart...
        <?php }?>
    </div>
</section>
