<link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/owl.carousel.min.css">
<script src="<?= $this->config->item('customerassets') ?>js/owl.carousel.min.js" type="text/javascript"></script>
<section class="container hidden position-absolute d-flex flex-wrap splash-content-slider align-items-center justify-content-end gradient-bg">
    <div class="owl-carousel owl-theme demo">
        <div class="item">
            <div class="slide-cotent px-0">
                <div class="slide-cotent-inner">
                    <h3>After 10pm?</h3>
                    <p>We’ll still deliver <br>Right to you :) <br>See our driver on the way <br>Just like an Uber.</p>
                </div>
            </div>
            <div>
                <img class="col-11 mx-auto" src="<?= $this->config->item('customerassets') ?>images/image_1@2x.png" alt="">
            </div>
        </div>
        <!--<div class="item">
            <div class="slide-cotent">
                <div class="slide-cotent-inner">
                    <p>We use a special drying &amp; curing method which boosts the flavor, essential oils, and medicinal value of our products.
                        For an unparalleled clean high</p>
                </div>
            </div>
            <img src="<?= $this->config->item('customerassets') ?>images/image_2@2x.png" alt="">
        </div>-->
        <div class="item">
            <div class="slide-cotent px-0">
                <div class="slide-cotent-inner">
                    <p>Tired of bad weed? <br>That’s weak, old, harsh, or ineffective? <br>We got the good stuff. All lab-tested, fresh
                        Craft Cannabis... <br>Like craft beer, made in small batches <br>By caring true craftsmen, <br>Not cold corporations. <br>It’s Farm to Table, made with pride.</p>
                </div>
            </div>
            <div>
                <img class="col-11 mx-auto" src="<?= $this->config->item('customerassets') ?>images/image_3@2x.png" alt="">
            </div>
        </div>
        <!--<div class="item">
            <div class="slide-cotent">
                <div class="slide-cotent-inner">
                    <p>Like a craft beer bar, <br>We’ll feature "exotics of the month". New strains. New edibles. Rare items. 
                        Brought to you by pastry chefs with culinary degrees &amp; years of experience.</p>
                </div>
            </div>
            <img src="<?= $this->config->item('customerassets') ?>images/image_4@2x.png" alt="">
        </div>-->
        <div class="item">
            <div class="slide-cotent px-0">
                <div class="slide-cotent-inner">
                    <p>Like a craft beer bar, <br>We’ll feature "exotics of the month". New strains. New edibles. Rare items. 
                        Brought to you by pastry chefs with culinary degrees &amp; years of experience.</p>
                </div>
            </div>
            <div>
                <img class="col-11 mx-auto" src="<?= $this->config->item('customerassets') ?>images/image_5@2x.png" alt="">
            </div>
        </div>
        <div class="item">
            <div class="slide-cotent px-0">
                <div class="slide-cotent-inner">
                    <p>We believe in challenging the status quo. 1% of profits will go to charity, funding cancer research &amp; making the world better.<br>We want to set the industry standard for quality, customer service, and social responsibility. Help us make that dream a reality…</p>
                </div>
            </div>
            <div>
                <img class="col-11 mx-auto" src="<?= $this->config->item('customerassets') ?>images/image_6@2x.png" alt="">
            </div>
        </div>
    </div>
    <div class="skip-btn hide">
        <a class="d-flex align-items-center flex-wrap justify-content-center" href="<?=base_url()?>cus-our-products">
            <i class="fas fa-arrow-right col-6 px-0 d-block mr-1"></i>
            <span class="text px-0 col-6 d-block">Menu</span>
        </a>
    </div>
</section>
<section class="splash_container">
    <div class="splash_logo col-8">
        <img class="rounded mx-auto d-block" src="<?= $this->config->item('customerassets') ?>images/splash_logo.png" alt="logo">
    </div>
</section>
</div>
</div>
</section>
<script type="text/javascript">
    document.onreadystatechange = function(e)
    {
        window.dragcount = 0
        window.client = {ip: "0.0.0.0", fp: ""}

        if (document.readyState === 'complete')
        {
            var cookieValue = 'yes';
            var cookieName = 'splash_shown';
            var nDays = 30;
            var today = new Date();
            var expire = new Date();
            if (nDays == null || nDays == 0)
                nDays = 1;
            expire.setTime(today.getTime() + 3600000 * 24 * nDays);
            document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=" + expire.toGMTString();

            window.setTimeout(function () {
                $(".splash_container").addClass('d-none');
                $(".container").removeClass('hidden');
            }, 3000);
        }

        // get the client IP first
        axios.get('https://api.ipify.org/?format=json').then( _ => {
            if ( typeof _.data.ip === "undefined" )
                return
            
            // set the ip
            window.client.ip = _.data.ip
        })
    };

    // check if the current visitor is a new visitor or not
    var currentCustomer = (event) => {
        new Fingerprint2().get(function(result, components)
        {
            let fingerprint = result
            let ip = ""

            // get the url of menu
            let menuUrl = $('.skip-btn a').attr('href')

            if ( window.dragcount < 4 )
                return

            // redirect to register
            window.location.href = menuUrl
            
            // send an xhr request
            /*axios.get(siteurl + "cus-visit?fp=" + fingerprint + "&ip=" + (window.client.ip || "0.0.0.0")).then( _ => {
                if ( _.data.visitor == "null" )
                    window.location = menuUrl

                // redirect to register
                window.location.href = "cus-signup"
                
            }).catch( _ => { console.log(_.error.message) })*/
        })
    }

    $('.owl-carousel').owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplayHoverPause: true,
        items: 1,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        },
        callbacks: true,
        onDragged: function (event)
        {
            let iti = event.item.index
            let itc = event.item.count

            // increment
            window.dragcount += 1

            if ( iti + 1 === itc )
            {
                // call the xhr method and see to where this visitor should be redirected
                currentCustomer(event)
                $('.skip-btn').removeClass('hide')
            }
        }
    });
</script>
</body>
</html>