<section class="container mobile-view-container">
    <ul class="product_filters cats-container clearfix align-items-center">
        <?php foreach ($category as $cat) { 
            if($cat->category_id != '37') {
        ?>
            <li class="col-4 main-cat <?php if($cat->category_id == '39') {?>all_products<?php }?> <?php if($cat->category_id == '38') {?>rare_products<?php }?>" data-value="<?= $cat->category_id ?>">
                <span class="cbc"><?= $cat->name ?></span>
            </li> 
        <?php }else { ?> 
            <li class="col-4 by-purpose" data-value="<?= $cat->category_id ?>">
                <span class="cbc"><?= $cat->name ?></span>
            </li>
        <?php } }?>
    </ul>
    <ul class="product_filters sub-cats clearfix" style="display:none">

    </ul>
    <div class="filter_container" style="display: none">
        <i class="icon-filter"></i>
        <select id="search_product_family" name="search_product_family">
            <option value=''>Select product family</option>
            <?php foreach ($families as $family) { ?>
                <option value="<?= $family->family_id ?>"><?= $family->family_name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="product_list">
        
    </div>
    <div id="moods_purpose" style="display:none">
        <div class="activity-sec mood-sec">
            <h2>Moods & Activities</h2>
            <div class="activity-gallery">
                <div class="activity-img" data-value="1" data-text="Lift Your Spirits">
                    <img src="<?= $this->config->item('customerassets') ?>images/pic1.png">
                    <p>Lift Your Spirits</p>
                </div>
                <div class="activity-img" data-value="2" data-text="Stay Productive">
                    <img src="<?= $this->config->item('customerassets') ?>images/pic2.png">
                    <p>Stay Productive</p>
                </div>
                <div class="activity-img" data-value="3" data-text="Good Night Sleep">
                    <img src="<?= $this->config->item('customerassets') ?>images/pic3.png">
                    <p>Good Night Sleep</p>
                </div>
                <div class="activity-img" data-value="4" data-text="Conquer Social Anxiety">
                    <img src="<?= $this->config->item('customerassets') ?>images/pic6.png">
                    <p>Conquer Social Anxiety</p>
                </div>
                <div class="activity-img" data-value="5" data-text="Motivate The Mind">
                    <img src="<?= $this->config->item('customerassets') ?>images/pic4.png">
                    <p>Motivate The Mind</p>
                </div>
                <div class="activity-img" data-value="6" data-text="Get Active">
                    <img src="<?= $this->config->item('customerassets') ?>images/pic7.png">
                    <p>Get Active</p>
                </div>
            </div>
        </div>
        <div class="activity-sec">
            <h2>Medical</h2>
            <div class="activity-gallery">
                <div class="activity-img" data-value="7" data-text="Fight Fatigue">
                    <img src="<?= $this->config->item('customerassets') ?>images/pic5.png">
                    <p>Fight Fatigue</p>
                </div>
                <div class="activity-img" data-value="8" data-text="Manage Migraines">
                    <img src="<?= $this->config->item('customerassets') ?>images/pic8.png">
                    <p>Manage Migraines</p>
                </div>
            </div>
        </div>
    </div>	
</section>
