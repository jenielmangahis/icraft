<!--popup to ask questions before making the appointment-->
  <section class="popup_overlay" data-pop="appointment-question">
      <div class="popup popup-new">
          <div class="pop_head">
              <div class="popup-title cart-popup"></div>
              <span class="icon-close"></span>
          </div>
          <div class="popup_body">
              <div class="popup_form clearfix">
                  <div class="price-wrapper price-textarea">
                    <textarea name="other_prescription" id="other_prescription" placeholder="What else have you done so far to treat the medical condition(s) you selected?"><?=$this->session->userdata('other_prescription')?$this->session->userdata('other_prescription'):""?></textarea>
                    <textarea name="other_doctor" id="other_doctor" placeholder="Who is your usual or primary doctor?"><?=$this->session->userdata('other_doctor')?$this->session->userdata('other_doctor'):""?></textarea>
                      <button class="btn btn-lg btn-purle saveSelected">Submit</button>
                  </div>
              </div>
          </div>
      </div>
  </section>

<!--popup add to cart-->
  <section class="popup_overlay" data-pop="addtocart-pop">
      <div class="popup popup-new">
          <div class="pop_head">
              <div class="popup-title cart-popup"></div>
              <span class="icon-close"></span>
              <!--<h2 class="item-name" id="popup_product_name">Product Name</h2>-->
          </div>
          <div class="popup_body">
              <div class="popup_form clearfix">
                  <div class="price-wrapper">
                      <input type="hidden" id="product_id" name="product_id" value="">
                      <input type="hidden" id="limit" name="limit" value="">
                      <div class="price-row radio_container">
                        <label class="parent-label">
                          <input type="radio" checked="checked" name="price" class="radio_license"> <span class="radio_box"> <span class="radio_bullet bg-black"></span></span>
                        </label>
                        <span class="sale-price gram-span" data-quantity="1" data-type="gram" data-price=""></span>
                        <span class="old-price gram-price"></span>
                      </div>
                      <div class="price-row radio_container">
                        <label class="parent-label">
                          <input type="radio" name="price" class="radio_license"> <span class="radio_box"> <span class="radio_bullet bg-black"></span></span>
                        </label>
                        <span class="sale-price eight-span" data-quantity="1" data-type="eight" data-price=""></span>
                        <span class="old-price eight-price"></span>
                      </div>
                      <div class="price-row radio_container">
                        <label class="parent-label">
                          <input type="radio" name="price" class="radio_license"> <span class="radio_box"> <span class="radio_bullet bg-black"></span></span>
                        </label>
                        <span class="sale-price ounce-span" data-quantity="1" data-type="ounce" data-price=""></span>
                        <span class="old-price ounce-price"></span>
                      </div>
                      <div class="price-row item-total mb-30">
                        <span class="item-plus icon icon-minus"></span>
                        <span class="item-number">(1)</span>
                        <span class="item-minus icon icon-plus"></span>
                      </div>
                      <button class="btn btn-lg btn-purle save-add-to-cart pop-up-purple-btn">Add to Cart</button>
                  </div>
              </div>
          </div>
      </div>
  </section>

<script>
    $(document).on('click', '.add_add_to_cart', function () {
        checkUserLogin();
        var productId = $(this).data('productid');
        var productPriceOunce = $(this).data('productprice');
        var productPriceEigth = $(this).data('productpriceeigth');
        var productPriceGram = $(this).data('productpricegram');
        var limit = $(this).data('limited');
        
        var productPriceOunceOff = $(this).data('productpriceoff');
        var productPriceEigthOff = $(this).data('productpriceeigthoff');
        var productPriceGramOff = $(this).data('productpricegramoff');
        
        var isearlyadopter = $(this).data('isearlyadopter');
        
        if(isearlyadopter == '1'){
            $('.cart-popup').html('On Sale For Early Adopters');
        }else{
            $('.cart-popup').html('Add To Cart');
        }
        // Reset previous values
        $('.ounce-price').html('');
        $('.eight-price').html('');
        $('.gram-price').html('');
        $('div.price-row').find('span.sale-price').attr('data-price','');
        $('div.price-row').find('span.sale-price').attr('data-quantity','1');
        $('.item-number').html('(1)');
        /////////////////////////////////////////////////////
        
        if(productPriceOunceOff > 0){
            $('.ounce-span').html('1 Ounce, $'+productPriceOunceOff);  
            $('.ounce-span').attr('data-actual-price',productPriceOunceOff);
            $('.ounce-price').html('$'+productPriceOunce);
        }else{
            $('.ounce-span').html('1 Ounce, $'+productPriceOunce);  
            $('.ounce-span').attr('data-actual-price',productPriceOunce);
            $('.ounce-price').html();
        }
        if(productPriceEigthOff > 0){
            $('.eight-span').html('1 Eigth, $'+productPriceEigthOff);  
            $('.eight-span').attr('data-actual-price',productPriceEigthOff);
            $('.eight-price').html('$'+productPriceEigth);
        }else{
            $('.eight-span').html('1 Eigth, $'+productPriceEigth);  
            $('.eight-span').attr('data-actual-price',productPriceEigth);
            $('.eight-price').html();
        }
        if(productPriceGramOff > 0){
            $('.gram-span').html('1 Gram, $'+productPriceGramOff);  
            $('.gram-span').attr('data-actual-price',productPriceGramOff);
            $('.gram-price').html('$'+productPriceGram);
        }else{
            $('.gram-span').html('1 Gram, $'+productPriceGram);  
            $('.gram-span').attr('data-actual-price',productPriceGram);
            $('.gram-price').html();
        }
        $("#product_id").val(productId);
        $("#limit").val(limit);

    });
    
    $(document).on('click', '.icon-plus', function () {
        var quantity   =   $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-quantity');
        var type   =   $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-type');
        var limit   =   $("#limit").val();
        // 1 ounce = 28 gram, 1/8 ounce = 3.5 gram
        var gramToOunce =   '';
        var eighthToOunce =   '';
        var new_quantity    =   parseInt(quantity) + parseInt(1);
        
        if(type == 'ounce' && new_quantity > limit){
            alert('This product is limited to '+limit+' ounce a day');
            $('.item-number').html('('+limit+')');
            return false;
        }
        if(type == 'gram'){
            gramToOunce =   (new_quantity/28);
            if(gramToOunce > limit){
                alert('This product is limited to '+parseInt(new_quantity-1)+' Grams a day');
                $('.item-number').html('('+parseInt(new_quantity-1)+')');
                return false;
            }
        }
        if(type == 'eight'){
            eighthToOunce =   ((new_quantity*3.5)/28);
            if(eighthToOunce > limit){
                alert('This product is limited to '+limit+' Ounce a day');
                $('.item-number').html('('+parseInt(new_quantity-1)+')');
                return false;
            }
        }
        var actual_price   =   $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-actual-price');
        $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-price',parseInt(actual_price) * new_quantity);
        $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-quantity',new_quantity);
        $('.item-number').html('('+new_quantity+')');
    });
    
    $(document).on('click', '.icon-minus', function () {
        var quantity   =   $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-quantity');
        var new_quantity    =   parseInt(quantity) - parseInt(1);
        if(new_quantity == 0){
            return false;
        }
        var actual_price   =   $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-actual-price');
        $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-price',parseInt(actual_price) * new_quantity);
        $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-quantity',new_quantity);
        $('.item-number').html('('+new_quantity+')')
    });
    
    $(document).on('click','.save-add-to-cart',function(){
        var item_id     =   $('#product_id').val();
        var quantity    =   $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-quantity');
        var price       =   $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-price');
        var type        =   $('input[name=price]:checked').closest('div.price-row').find('span.sale-price').attr('data-type');
        $.ajax({
            type: 'POST',
            data: {item_id: item_id, quantity:quantity, type:type},
            url: siteurl + 'cus-add-tocart-products',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (data) {
                
                $('.wait-div').hide();
                if (data != null) {
                    if(data.success){
                       $('.cart_valu').html(data.quantity); 
                       $('.main_header').click(); 
                    }
                }
            }
        });
    });
</script>    

<!-- Forgot password popup starts here -->
<section class="popup_overlay forgot_password" data-pop="forgot-pop">
    <div class="popup">
        <div class="pop_head">
            <h2 class="pop_head_txt">Forgot Password</h2>
            <span class="icon-close"></span>
        </div>
        <div class="popup_body">
            <div class="body_txt ">
                <p>Please enter you registered email address you use to access your account.</p>
                <p>An Email will be sent to the provided address with a link to change your password.</p>	
            </div>
            <div class="popup_form clearfix">
                <?= form_open_multipart('cus-forgot-password', array('class' => 'clearfix ajaxform', 'id' => '')) ?>    
                <div class="alert alert-info wait-div " style="display:none;"> <strong>Please wait! </strong> Your action is in proccess... </div>
                <div id="jGrowl" class="top-right jGrowl col-md-12"  style="display: none;">
                    <button class="close" aria-hidden="true" data-dismiss="alert" style="padding:10px;" type="button">&times;</button>
                    <div class="jGrowl-notification ">
                        <div class="jGrowl-message ajax_message"></div>
                    </div>
                </div>
                <label>
                    <input type="text" class="gradient_border" name="email" placeholder="Email ID"> 
                </label>
                <button class="btn gradient">Done</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>



<!-- delivery date time popup -->
<section class="popup_overlay" data-pop="deliveryDateTime-pop">
    <div class="popup">
        <div class="pop_head">
            <h2 class="pop_head_txt">Select scheduled delivery date &amp; time</h2>
            <span class="icon-close"></span>
        </div>
        <div class="popup_body">

            <div class="popup_form clearfix">
                <form>
                    <div class="splited_field clearfix">
                        <i class="icon-calendar"></i>
                        <input type="text" name=""> <span>/</span> <input type="text" name=""> <span>/</span> <input type="text" name="">
                    </div>

                    <div class="splited_field clearfix">
                        <i class="icon-clock"></i>
                        <input type="text" name=""> <span>/</span> <input type="text" name=""> <span>/</span> <input type="text" name="">
                    </div>

                    <button class="btn gradient">Done</button>
                </form>
           </div>
        </div>
    </div>
</section>

<!-- Splash container -->
<!--<section class="splash_container">
    <div class="splash_logo"><img src="<?= $this->config->item('customerassets') ?>images/splash_logo.png" alt="logo"></div>
</section>-->


</div>

</div>
</section>
<!-- Forgot password popup end here -->
<script>
    document.onreadystatechange = function(e)
    {
        if (document.readyState === 'complete')
        {
            var cookie = ReadCookie('splash_shown');
            if (cookie == null)
            {
                window.location.href = 'cus-splash';
            }
        }
    };
    $(document).ready(function () {
        //$('.icon-cart').attr('cart-value',<?= $this->session->userdata('total_item') ?>); 
        var cart_val    =   "<?php echo $this->session->userdata('total_item'); ?>";
        if(cart_val > 0){
            $('.cart-badge').html('<span class="cart_valu">'+cart_val+'</span> ');
        }
    });
    function ReadCookie(name)
    {
        name += '=';
        var parts = document.cookie.split(/;\s*/);
        for (var i = 0; i < parts.length; i++)
        {
            var part = parts[i];
            if (part.indexOf(name) == 0)
                return part.substring(name.length)
        }
        return null;
    }

    $(document).on('click', '.social_share', function () {
        //var isLogin = '<?= $this->session->userdata('CUSTOMER-SL') ?>';
        window.location.href = 'cus-social-share';

    });
    $(document).on('click', '#login', function () {
        $(this).addClass('active');
        $('#register').removeClass('active');
        $('.login_section').show();
        $('.register_section').hide();
    });
    $(document).on('click', '#register', function () {
        $(this).addClass('active');
        $('#login').removeClass('active');
        $('.login_section').hide();
        $('.register_section').show();
    });
    //code to show/hide nav bar
    $('.back-screen.icon-menu').click(function () {
        $('nav').addClass('open');
    });
    $(document).on('click', function (e) {
        if (!$(e.target).is('nav , nav *, .back-screen.icon-menu , .back-screen.icon-menu *')) {
            $('nav').removeClass('open');
        }
    });
    $(document).on('click', function (e) {
        if (!$(e.target).is('nav , nav *, .back-screen.icon-menu , .back-screen.icon-menu *')) {
            $('nav').removeClass('open');
        }
    });


//    check for upcoming appointments
    window.setInterval(function () {
        var userId = '<?= $this->session->userdata('CUSTOMER-ID') ?>';
        if(userId !=''){
            checkForUpcomingAppointment();
        }
    }, 60000);

    function checkForUpcomingAppointment() {
        checkUserLogin();
        var userId = '<?= $this->session->userdata('CUSTOMER-ID') ?>';
        $.ajax({
            type: 'POST',
            data: {userId: userId},
            url: siteurl + 'check-upcoming-appointment',
            dataType: "json",
            beforeSend: function () {
                //$('.wait-div').show();
            },
            success: function (data) {

                //$('.wait-div').hide();
                if (data != null) {
                    if (data.appointment_id != '') {
                        if (data.status == '0')
                            var status = 'Pending';
                        if (data.status == '1')
                            var status = 'Confirm';
                        if (data.status == '2')
                            var status = 'Rescheduled';
                        if (data.status == '3')
                            var status = 'Cancel';
                        $('#upcoming_appointment').show();
                        $('#appointment_time').text(data.appointment_time);
                        $('#appointment_date').text(data.appointment_date);
                        $('#status').text(status);
                        $('#make_video_call').attr('data-appointmentId', data.appointment_id);
                        $('#appointment_id_video').val(data.appointment_id);
                    } else {

                    }
                }
            }
        });

    }
    $(document).on('click', '#make_video_call', function () {
        var appointment_id = $('#make_video_call').attr('data-appointmentId');
        document.getElementById("form_for_video_call").submit();
    });

    $(document).on('click', '#add_to_cart', function () {
        checkUserLogin();
    });

    $(document).on('click', '#more_info', function () {
        checkUserLogin();
    });

    $(document).on('click', '#download_prescription', function () {
        checkUserLogin();
        var appointment_id = $(this).attr('data-value');
        $.ajax({
            type: 'POST',
            data: {appointment_id: appointment_id},
            url: siteurl + 'download-recommended-prescription',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (data) {
                $('.wait-div').hide();
                // alert(data);
            }
        });

    });

    $(document).on('click', '.facebook_btn', function () {
        shareOnFacebook();
    });
    $(document).on('click', '.insta_btn', function () {
        insta_click(this);
    });
    $(document).on('click', '.twitter_btn', function () {
        twt_click(this);
    });

    function fbs_click($this)
    {
        u = $($this).attr('data-url');
        t = $($this).attr('data-title');

        window.open('https://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t),
                'sharer',
                'toolbar=0,status=0,top=150,left=200,width=626,height=400');

        return false;
    }

    function shareOnFacebook() {
        FB.ui(
        {
            method: 'share',
            href: siteurl
        },
        function(response) {
            if (response && !response.error_message) {
                // HERE YOU CAN DO WHAT YOU NEED
                alert('OK! User has published on Facebook.');
            }
            else
            {
                return
            }
        });
    }

    function insta_click($this)
    {
        u = $($this).attr('data-url');
        t = $($this).attr('data-title');

        window.open('https://www.instagram.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t),
                'sharer',
                'toolbar=0,status=0,top=150,left=200,width=626,height=400');

        return false;
    }


    function twt_click($this)
    {
        u = $($this).attr('data-url');
        t = $($this).attr('data-title');
        window.open('https://www.twitter.com/share?url=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t),
                'sharer',
                'toolbar=0,status=0,top=150,left=200,width=626,height=400');

        return false;
    }

    $(document).on('click', '.by-purpose', function () {
        $('.cats-container').hide();
        $('#page_name_header').text('By Purpose');
        $('.back-screen').attr('href', siteurl + 'cus-our-products');
        $('#moods_purpose').show();
    });
    
    $(document).on('click', '.back-to-our-products', function () {
        $('.back-to-our-products').attr('href', siteurl + 'cus-our-products');
    });
    
    $(document).on('click', '.back_to_by_purpose', function () {
        $('.cats-container').hide();
        $('.filter_container').hide();
        $('.product_list').hide();
        $('#page_name_header').text('By Purpose');
        $('.back_to_by_purpose').addClass('back-to-our-products');
        $('.back-to-our-products').removeClass('back_to_by_purpose');
        $('#moods_purpose').show();
    });
    
    $(document).on('click','.activity-img',function(){
        $('#page_name_header').text($(this).attr('data-text'));
        $('#page_name_header').attr('data-value',$(this).attr('data-value'));
        var mood_id =   $(this).attr('data-value');
        $('.back-to-our-products').addClass('back-screen');
        $('.back-screen').attr('href', 'javascript:;');
        $('.back-screen').addClass('back_to_by_purpose');
        $('.back_to_by_purpose').removeClass('back-screen');
        $('.back_to_by_purpose').removeClass('back-to-our-products');
        $('#moods_purpose').hide();
        $('.cats-container').hide();
        $('.sub-cats').hide();
        $.ajax({
            type: 'POST',
            data: {by_mood: 'yes', by_mood_id: mood_id},
            url: siteurl + 'get-sub-categories',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (data) {
                $('.wait-div').hide();
                var product_html = '';
                
                if (data.products.length > 0) {
                    var weight_in = '';
                    var previous = '';
                    $.each(data.products, function (i, j) {
                        if (j.item_unit == '1')
                            weight_in = 'ounce';
                        if (j.item_unit == '2')
                            weight_in = 'gram';
                        if (j.item_unit == '3')
                            weight_in = 'ml';
                        if (j.item_unit == '4')
                            weight_in = 'piece';
                        if (previous != j.cat_name) { 
                            product_html += '<p class="help_txt">'+j.cat_name+'</p>';
                        }
                        
                        product_html += '<div class="product_card">';
                        product_html += '<div class="product_detail d-flex flex-nowrap align-items-center justify-content-start" style="background:' + j.color_code + '">';
                        if(j.limited != 0 && j.limited != '' && j.limited != null){
                            product_html += '<div class="pro_img col-5 px-0"><img src="' + j.item_image + '" alt="product"><span class="limite_tag">LIMITED SUPPLY</span></div>';
                        }else{
                            product_html += '<div class="pro_img col-5 px-0"><img src="' + j.item_image + '" alt="product"></div>';
                        }
                        product_html += '<div class="product_info col-7 px-0 pl-2">';
                        product_html += '<h3>' + j.item_name + '</h3>';
                        product_html += '<div class="about_prdo clearfix">';
                        product_html += '<p><b>Effect : </b><span class="txt_description">'+j.effect+'</span></p>';
                        product_html += '<p><b>Flavor : </b><span class="txt_description">'+j.flavor+'</span> </p>';
                        product_html += '<p class="price_product">$'+j.price_one+' /'+weight_in+'</p>';
                        product_html += '</div>';
                        product_html += '</div>';
                        product_html += '</div>';
                        product_html += '<div class="card_buttons clearfix">';
                        product_html += '<a href="javascript:;" data-productId="' + j.item_id + '" data-productname="' + j.item_name + '" data-productprice="' + j.price_one + '" data-productpriceeigth="'+j.price_eigth+'" data-productpricegram="'+j.price_gram+'" data-productpriceoff="' + j.price_one_off + '" data-productpriceeigthoff="'+j.price_eight_off+'" data-productpricegramoff="'+j.price_gram_off+'" data-isearlyadopter="'+j.is_early_adopter+'" data-limited="'+j.limited+'" class="add_to_cart add_add_to_cart" data-attribute="addtocart-pop" >ADD TO CART</a>';
                        product_html += '<a href="' + siteurl + 'cus-product-detail/' + j.item_id + '" class="add_to_cart">VIEW DETAILS</a>';
                        product_html += '</div>';
                        product_html += '</div>';
                        
                        previous = j.cat_name;
                    });
                    //$('#moods_purpose').show();
                } else {
                    product_html += 'No products';
                }
                $('.filter_container').show();
                $('.product_list').show();
                $('.product_list').html();
                $('.product_list').html(product_html);
            }
        });
    });


    $(document).on('click', '.main-cat', function () {
        var all_products     =   'no';
        var rare_products    =   'no';
        $('.main-cat').removeClass('active');
        $(this).addClass('active');
        if($(this).hasClass('all_products')){
            all_products =   'yes';
        }
        if($(this).hasClass('rare_products')){
            rare_products =   'yes';
        }
        $('#page_name_header').text($(this).text());
        $('.back-screen').attr('href', siteurl + 'cus-our-products');
        var cat_id = $(this).attr('data-value');
        $.ajax({
            type: 'POST',
            data: {cat_id: cat_id, is_main: 'yes', all_products:all_products, rare_products:rare_products},
            url: siteurl + 'get-sub-categories',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (data) {
                $('.wait-div').hide();
                var cat_html = '';
                var product_html = '';
                var isSelected = '';
                var is_main = '';
                if (data.subCats.length > 0) {
                    $.each(data.subCats, function (i, j) {
                        if (i == 0) {
                            isSelected = 'active';
                        } else {
                            isSelected = '';
                        }
                        if(j.category_id == cat_id){
                            is_main =   'yes';
                        }else{
                            is_main =   'no';
                        }
                        cat_html += '<li class="col-4 sub-cat ' + isSelected + '" data-value=' + j.category_id + ' data-is-main='+is_main+'><span class="cbc">' + j.name + '</span></li>';
                    });
                } else {
                    cat_html += 'No further categories...';
                }
                if (data.products.length > 0) {
                    var weight_in = '';
                    var previous = '';
                    var cssClass = '';

                    $.each(data.products, function (i, j) {
                        if (j.item_unit == '1')
                            weight_in = 'ounce';
                        if (j.item_unit == '2')
                            weight_in = 'gram';
                        if (j.item_unit == '3')
                            weight_in = 'ml';
                        if (j.item_unit == '4')
                            weight_in = 'piece';
                        if (previous != j.cat_name) { 
                            product_html += '<p class="help_txt">'+j.cat_name+'</p>';
                        }
                        if(j.limited != 0 && j.limited != '' && j.limited != null)
                        {
                            cssClass = "limited";
                        }

                        product_html += '<div class="product_card position-relative '+ cssClass +'">';
                        //product_html += '<i class="far fa-clock text-danger ico"></i>';
                        product_html += '<div class="product_detail d-flex flex-nowrap align-items-center justify-content-start" style="background:' + j.color_code + '">';

                        product_html += '<div class="pro_img col-4 px-0"><img src="' + j.item_image + '" alt="product"></div>';
                        product_html += '<div class="product_info col-8 px-2">';
                        product_html += '<h3 class="mb-2">' + j.item_name + '</h3>';
                        product_html += '<div class="about_prdo clearfix">';
                        product_html += '<p class="text-truncate mb-2"><b>Effect : </b><span class="txt_description">'+j.effect+'</span></p>';
                        product_html += '<p class="text-truncate mb-2"><b>Flavor : </b><span class="txt_description">'+j.flavor+'</span> </p>';
                        product_html += '<p class="price_product mt-2 pr-1 text-right mb-0">$'+j.price_one+' / '+weight_in+'</p>';
                        //product_html += '<p class="mb-0"><span class="txt_description text-truncate">'+j.effect+'</span></p>';
                        //product_html += '<p class="mb-0 text-white font-weight-bold">In Stock</p>';
                        product_html += '</div>';
                        product_html += '</div>';
                        product_html += '</div>';
                        product_html += '<div class="card_buttons clearfix">';
                        product_html += '<a href="javascript:;" data-productId="' + j.item_id + '" data-productname="' + j.item_name + '" data-productprice="' + j.price_one + '" data-productpriceeigth="'+j.price_eigth+'" data-productpricegram="'+j.price_gram+'" data-productpriceoff="' + j.price_one_off + '" data-productpriceeigthoff="'+j.price_eight_off+'" data-productpricegramoff="'+j.price_gram_off+'" data-isearlyadopter="'+j.is_early_adopter+'" data-limited="'+j.limited+'" class="add_to_cart add_add_to_cart" data-attribute="addtocart-pop" >ADD TO CART</a>';
                        product_html += '<a href="' + siteurl + 'cus-product-detail/' + j.item_id + '" class="add_to_cart">VIEW DETAILS</a>';
                        product_html += '</div>';
                        product_html += '</div>';
                        
                        previous = j.cat_name;
                    });
                    $('#moods_purpose').show();
                } else {
                    product_html += 'No products';
                }
                if(all_products == 'no' && rare_products == 'no'){
                    $('.cats-container').hide();
                    $('.sub-cats').html();
                    $('.sub-cats').html(cat_html);
                    $('.sub-cats').show();
                    $('.filter_container').show();
                }
                $('.product_list').html();
                $('.product_list').html(product_html);
            }
        });
    });

    $(document).on('click', '.sub-cat', function () {
        var cat_id = '';
        $('.sub-cat').removeClass('active');
        $(this).addClass('active');
        var is_main = $(this).attr('data-is-main');
        if(is_main == 'no'){
            cat_id = $(this).attr('data-value');
        }
        var family_id = $('#search_product_family').val();
        var main_cat_id = $('.main-cat.active').attr('data-value');
        $.ajax({
            type: 'POST',
            data: {cat_id: main_cat_id, sub_cat_id: cat_id, family_id: family_id, is_main: is_main,all_products:'no'},
            url: siteurl + 'get-products-by-subcat',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (data) {
                $('.wait-div').hide();
                var product_html = '';
                if (data.products.length > 0) {
                    var weight_in = '';
                    var previous = '';
                    var cssClass = '';
                    $.each(data.products, function (i, j) {
                        if (j.item_unit == '1')
                            weight_in = 'ounce';
                        if (j.item_unit == '2')
                            weight_in = 'gram';
                        if (j.item_unit == '3')
                            weight_in = 'ml';
                        if (j.item_unit == '4')
                            weight_in = 'piece';
                        if (previous != j.cat_name) { 
                            product_html += '<p class="help_txt">'+j.cat_name+'</p>';
                        }
                        if(j.limited != 0 && j.limited != '' && j.limited != null)
                        {
                            cssClass = "limited";
                        }

                        product_html += '<div class="product_card position-relative '+ cssClass +'">';
                        //product_html += '<i class="far fa-clock text-danger ico"></i>';
                        product_html += '<div class="product_detail d-flex flex-nowrap align-items-center justify-content-start" style="background:' + j.color_code + '">';

                        product_html += '<div class="pro_img col-4 px-0"><img src="' + j.item_image + '" alt="product"></div>';
                        product_html += '<div class="product_info col-8 px-2">';
                        product_html += '<h3 class="mb-2">' + j.item_name + '</h3>';
                        product_html += '<div class="about_prdo clearfix">';
                        product_html += '<p class="text-truncate mb-2"><b>Effect : </b><span class="txt_description">'+j.effect+'</span></p>';
                        product_html += '<p class="text-truncate mb-2"><b>Flavor : </b><span class="txt_description">'+j.flavor+'</span> </p>';
                        product_html += '<p class="price_product mt-2 pr-1 text-right mb-0">$'+j.price_one+' / '+weight_in+'</p>';
                        //product_html += '<p class="mb-0"><span class="txt_description text-truncate">'+j.effect+'</span></p>';
                        //product_html += '<p class="mb-0 text-white font-weight-bold">In Stock</p>';
                        product_html += '</div>';
                        product_html += '</div>';
                        product_html += '</div>';
                        product_html += '<div class="card_buttons clearfix">';
                        product_html += '<a href="javascript:;" data-productId="' + j.item_id + '" data-productname="' + j.item_name + '" data-productprice="' + j.price_one + '" data-productpriceeigth="'+j.price_eigth+'" data-productpricegram="'+j.price_gram+'" data-productpriceoff="' + j.price_one_off + '" data-productpriceeigthoff="'+j.price_eight_off+'" data-productpricegramoff="'+j.price_gram_off+'" data-isearlyadopter="'+j.is_early_adopter+'" data-limited="'+j.limited+'" class="add_to_cart add_add_to_cart" data-attribute="addtocart-pop" >ADD TO CART</a>';
                        product_html += '<a href="' + siteurl + 'cus-product-detail/' + j.item_id + '" class="add_to_cart">VIEW DETAILS</a>';
                        product_html += '</div>';
                        product_html += '</div>';
                        
                        previous = j.cat_name;
                    });
                    $('#moods_purpose').show();
                } else {
                    product_html += 'No products';
                }

                $('.product_list').html();
                $('.product_list').html(product_html);
            }
        });
    });

    $(document).on('click', '#search_product_family', function () {
        var mood_id =   $('#page_name_header').attr('data-value');
        var by_mood = 'no';
        if(mood_id != '' && mood_id != undefined){
            by_mood =   'yes';
        }
        var cat_id  =   '';
        var main_cat_id = $('.main-cat.active').attr('data-value');
        var is_main = $('.sub-cat.active').attr('data-is-main');
        if(is_main == 'no'){
            cat_id = $('.sub-cat.active').attr('data-value');
        }
        
        var family_id = $(this).val();
        $.ajax({
            type: 'POST',
            data: {cat_id: main_cat_id, sub_cat_id: cat_id, family_id: family_id, by_mood_id:mood_id, by_mood:by_mood},
            url: siteurl + 'get-products-by-subcat',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (data) {
                $('.wait-div').hide();
                var product_html = '';
                if (data.products.length > 0) {
                    var weight_in = '';
                    var previous = '';
                    var cssClass = '';
                    $.each(data.products, function (i, j) {
                        if (j.item_unit == '1')
                            weight_in = 'ounce';
                        if (j.item_unit == '2')
                            weight_in = 'gram';
                        if (j.item_unit == '3')
                            weight_in = 'ml';
                        if (j.item_unit == '4')
                            weight_in = 'piece';
                        if (previous != j.cat_name) { 
                            product_html += '<p class="help_txt">'+j.cat_name+'</p>';
                        }
                        if(j.limited != 0 && j.limited != '' && j.limited != null)
                        {
                            cssClass = "limited";
                        }

                        product_html += '<div class="product_card position-relative '+ cssClass +'">';
                        //product_html += '<i class="far fa-clock text-danger ico"></i>';
                        product_html += '<div class="product_detail d-flex flex-nowrap align-items-center justify-content-start" style="background:' + j.color_code + '">';

                        product_html += '<div class="pro_img col-4 px-0"><img src="' + j.item_image + '" alt="product"></div>';
                        product_html += '<div class="product_info col-8 px-2">';
                        product_html += '<h3 class="mb-2">' + j.item_name + '</h3>';
                        product_html += '<div class="about_prdo clearfix">';
                        product_html += '<p class="text-truncate mb-2"><b>Effect : </b><span class="txt_description">'+j.effect+'</span></p>';
                        product_html += '<p class="text-truncate mb-2"><b>Flavor : </b><span class="txt_description">'+j.flavor+'</span> </p>';
                        product_html += '<p class="price_product mt-2 pr-1 text-right mb-0">$'+j.price_one+' / '+weight_in+'</p>';
                        //product_html += '<p class="mb-0"><span class="txt_description text-truncate">'+j.effect+'</span></p>';
                        //product_html += '<p class="mb-0 text-white font-weight-bold">In Stock</p>';
                        product_html += '</div>';
                        product_html += '</div>';
                        product_html += '</div>';
                        product_html += '<div class="card_buttons clearfix">';
                        product_html += '<a href="javascript:;" data-productId="' + j.item_id + '" data-productname="' + j.item_name + '" data-productprice="' + j.price_one + '" data-productpriceeigth="'+j.price_eigth+'" data-productpricegram="'+j.price_gram+'" data-productpriceoff="' + j.price_one_off + '" data-productpriceeigthoff="'+j.price_eight_off+'" data-productpricegramoff="'+j.price_gram_off+'" data-isearlyadopter="'+j.is_early_adopter+'" data-limited="'+j.limited+'" class="add_to_cart add_add_to_cart" data-attribute="addtocart-pop" >ADD TO CART</a>';
                        product_html += '<a href="' + siteurl + 'cus-product-detail/' + j.item_id + '" class="add_to_cart">VIEW DETAILS</a>';
                        product_html += '</div>';
                        product_html += '</div>';
                        
                        previous = j.cat_name;
                    });
                    if(by_mood == 'no'){
                        $('#moods_purpose').show();
                    }
                } else {
                    product_html += 'No products';
                }

                $('.product_list').html();
                $('.product_list').html(product_html);
            }
        });
    });

    $(document).on('click', '.cart_checkout', function () {
        var total_amount = $('#total_cart_value').text();
        window.location.href = 'cus-delivery-datetime';
    });

    $(document).on('click', '.redirect_to_caregiver', function () {
        var delivery_date_time = $('#delivery_date_time').val();
        var delivery_address = $('#delivery_address').val();
        var delivery_lat_lng = $('#delivery_lat_lng').val();
        var delivery_type = $('input[name=order_type]:checked').val();

        //if ( delivery_type == "scheduled"  && delivery_address != '' ) 
        if ( delivery_type == "scheduled"  && delivery_address != '' ){
            if (delivery_date_time != '') {
                $.ajax({
                    type: 'POST',
                    data: {delivery_date_time: delivery_date_time, delivery_address: delivery_address, delivery_lat_lng: delivery_lat_lng},
                    url: siteurl + 'cus-delivery-datetime',
                    dataType: "json",
                    beforeSend: function () {
                        $('.wait-div').show();
                    },
                    success: function (data) {
                        $('.wait-div').hide();
                        if (data.success == '1') {
                            window.location.href = 'cus-caregiver-step1';
                        } else {
                            swal('Something went wrong, Please try again.', 'error');
                        }
                    }
                });
            } else {
                swal('Warning..!','Please select Delivery address and date time.', 'warning');                
            }
        }else{
            if ( delivery_address != '' ){
                delivery_date_time = "0000-00-00";
                $.ajax({
                    type: 'POST',
                    data: {delivery_date_time: delivery_date_time, delivery_address: delivery_address, delivery_lat_lng: delivery_lat_lng},
                    url: siteurl + 'cus-delivery-datetime',
                    dataType: "json",
                    beforeSend: function () {
                        $('.wait-div').show();
                    },
                    success: function (data) {
                        $('.wait-div').hide();
                        if (data.success == '1') {
                            window.location.href = 'cus-caregiver-step1';
                        } else {
                            swal('Something went wrong, Please try again.', 'error');
                        }
                    }
                });
            }else{
                swal('Warning..!','Please select Delivery address', 'warning');
            }
        }
    });
    $(function () {
        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        if (!isMobile) {
            $('.container').enscroll({scrollIncrement:40});
            $('.container').width('auto');
        }

    })
    function checkUserLogin() {
        var isLogin = '<?= $this->session->userdata('CUSTOMER-SL') ?>';
        if (isLogin == '' || isLogin == undefined) {
            window.location.href = 'cus-login';
        }
    }

    $(document).on('click', '.get_cannabis_now', function () {
        window.location.href = 'cus-our-products';
    });

    $(document).on('click', '.delete_cart_item', function () {
        var cart_id = $(this).attr('data-value');
        $.ajax({
            type: 'POST',
            data: {cart_item_id: cart_id},
            url: siteurl + 'cus-delete-from-cart',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (data) {
                $('.wait-div').hide();
//                var item_total_price    =   $('.total_val_'+cart_id).data('value');
//                var updatedTotal    =   parseInt($('#total_cart_value').data('value'))-parseInt(item_total_price);
//                $('#total_cart_value').attr('data-value',updatedTotal);
//                $('#total_cart_value').html('$'+updatedTotal);
//                $('#product_card_' + cart_id).remove();
//                var numItems = $('.product_card_small').length;
//                if (numItems <= 0) {
//                    $('.my_cart.product_list').html('Nothing in cart...');
//                }
                location.reload();
            }
        });
    });

    $(document).on('click', '.empty-cart', function () {
        $.ajax({
            type: 'POST',
            url: siteurl + 'cus-delete-all-cart',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (data) {
                $('.wait-div').hide();
                $('.my_cart.product_list').html('Nothing in cart...');
            }
        });
    });
    
    $(document).on('click', '.saveSelected', function () {
        var selectedValues = [];
        $("input:checkbox[name=prescription]:checked").each(function () {
            selectedValues.push($(this).val());

        });
        if (selectedValues.length <= 0) {
            alert('Please select at least one consultation.');
            location.reload();
        }

        var other_reason = $('#other_reason').val();
        var other_prescription = $('#other_prescription').val();
        var other_doctor = $('#other_doctor').val();
        if(other_prescription == ''){
            document.getElementById("other_prescription").style.borderColor = "red";
            return false;
        }else{
            document.getElementById("other_prescription").style.borderColor = "";
        }
        
        if(other_doctor == ''){
            document.getElementById("other_doctor").style.borderColor = "red";
            return false;
        }else{
            document.getElementById("other_doctor").style.borderColor = "";
        }
        
        $.ajax({
            type: 'POST',
            data: {selectedValues: selectedValues, other_reason: other_reason, other_prescription:other_prescription, other_doctor:other_doctor},
            url: siteurl + 'save-selected-consultations',
            dataType: "json",
            success: function (data) {
                if(data.success){
                    window.location.href = 'cus-time-availability';
                }else{
                    alert('Please upload Id proofs first.');
                    window.location.href = 'cus-upload-proof';
                }
            }
        });
    });

</script>
</body>
</html>

