<section class="container">
    <ul class="product_filters cats-container clearfix">
        <?php foreach($category as $cat){?>
        <li class="main-cat" data-value="<?=$cat->category_id?>"><?=$cat->name?></li> 
        <?php }?>
    </ul>
    <ul class="product_filters sub-cats clearfix" style="display:none">
        
    </ul>
    <div class="filter_container" style="display: none">
        <i class="icon-filter"></i>
        <select id="search_product_family" name="search_product_family">
            <option value=''>Select product family</option>
            <?php foreach($families as $family) {?>
            <option value="<?= $family->family_id?>"><?= $family->family_name?></option>
            <?php }?>
        </select>
    </div>
    <p class="help_txt">Our Products</p>
    <div class="product_list">
        <?php
        foreach ($allProducts as $product) {
           // echo"<pre/>"; print_r($product); die;
            if ($product->item_unit == '1')
                $weight_in = 'ounce';
            if ($product->item_unit == '2')
                $weight_in = 'gram';
            if ($product->item_unit == '3')
                $weight_in = 'ml';
            if ($product->item_unit == '4')
                $weight_in = 'piece';
            ?>
            <div class="product_card clearfix">
                <div class="product_detail clearfix" style="background:<?= $product->color_code ?> ">
                    <span class="certificate_ico icon-badge"></span>
                    <div class="pro_img left"><img src="<?= $product->item_image ?>" alt="product"></div>					
                    <div class="product_info right">
                        <h3><?= $product->item_name ?></h3>
                        <p><b>Price:</b> $<?= $product->price_one ?>/1 <?= $weight_in ?></p>
                        <p class="about"><?= $product->family ?></p>
                        <h4>In Stock</h4>
                        <p><b>Amount:</b> $20/g- $200/ ounce</p>
                    </div>
                </div>
                <div class="card_buttons clearfix">
                    <a href="javascript:;" data-productId="<?= $product->item_id ?>" data-productimage="<?= $product->item_image ?>" data-productname="<?= $product->item_name ?>" data-productprice="<?= $product->price_one ?>" data-productweight="<?= $weight_in ?>" class="add_to_cart add_add_to_cart" data-attribute="addtocart-pop" >Add to Cart</a>
                    <a href="<?= base_url()?>cus-product-detail/<?= $product->item_id ?>" class="add_to_cart">More Info</a>					
                </div>
            </div>
<?php } ?>
    </div>
    <div>
		<div class="activity-sec mood-sec">
			<h2>Moods & Activities</h2>
			<div class="activity-gallery">
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Lift Your Spirits</p>
				</div>
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Stay Productive</p>
				</div>
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Good Night Sleep</p>
				</div>
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Motivate The Mind</p>
				</div>
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Get Active</p>
				</div>
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Get Active</p>
				</div>
			</div>
		</div>
		<div class="activity-sec">
			<h2>Medical</h2>
			<div class="activity-gallery">
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Fight Fatigue</p>
				</div>
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Manage Migraines</p>
				</div>
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Fight Fatigue</p>
				</div>
				<div class="activity-img">
					<img src="images/sleep.png">
					<p>Manage Migraines</p>
				</div>
			</div>
		</div>
    </div>	
</section>
