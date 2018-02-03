<link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/owl.carousel.min.css">
<script src="<?= $this->config->item('customerassets') ?>js/owl.carousel.min.js" type="text/javascript"></script>
<section class="splash_container">
    <div class="splash_logo"><img src="<?= $this->config->item('customerassets') ?>images/splash_logo.png" alt="logo"></div>
</section>
<section class="container hidden">
    <div class="owl-carousel owl-theme demo">
        <div class="item">
            <div class="slide-cotent">
                <div class="slide-cotent-inner">
                    <h3>After 10pm?</h3>
                    <p>We’ll still deliver <br>Right to you :) <br>See our driver on the way <br>Just like an Uber.</p>
                </div>
            </div>
            <img src="<?= $this->config->item('customerassets') ?>images/image_1@2x.png" alt="">
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
            <div class="slide-cotent">
                <div class="slide-cotent-inner">
                    <p>Tired of bad weed? <br>That’s weak, old, harsh, or ineffective? <br>We got the good stuff. All lab-tested, fresh
                        Craft Cannabis... <br>Like craft beer, made in small batches <br>By caring true craftsmen, <br>Not cold corporations. <br>It’s Farm to Table, made with pride.</p>
                </div>
            </div>
            <img src="<?= $this->config->item('customerassets') ?>images/image_3@2x.png" alt="">
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
            <div class="slide-cotent">
                <div class="slide-cotent-inner">
                    <p>Like a craft beer bar, <br>We’ll feature "exotics of the month". New strains. New edibles. Rare items. 
                        Brought to you by pastry chefs with culinary degrees &amp; years of experience.</p>
                </div>
            </div>
            <img src="<?= $this->config->item('customerassets') ?>images/image_5@2x.png" alt="">
        </div>
        <div class="item">
            <div class="slide-cotent">
                <div class="slide-cotent-inner">
                    <p>We believe in challenging the status quo. 1% of profits will go to charity, funding cancer research &amp; making the world better. <br><br>We want to set the industry standard for quality, customer service, and social responsibility. Help us make that dream a reality…</p>
                </div>
            </div>
            <img src="<?= $this->config->item('customerassets') ?>images/image_6@2x.png" alt="">
        </div>
    </div>
    <P class="skip-btn">
        <a href="<?=base_url()?>cus-our-products">
            <i class="fas fa-arrow-right"></i>
            <span class="text">Menu</span>
        </a>
    </P>
</section>

</div>

</div>
</section>
<script type="text/javascript">
    document.onreadystatechange = function(e)
    {
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
                $(".splash_container").addClass('hidden');
                $(".container").removeClass('hidden');
            }, 3000);
        }
    };

    // check if the current visitor is a new visitor or not
    var currentCustomer = (event) => {
        new Fingerprint2().get(function(result, components)
        {
            let fingerprint = result
            let ip = ""
            let item = event.item.index
            let items = event.item.count

            // get the url of menu
            let menuUrl = $('.skip-btn a').attr('href')

            if ( item + 1 < items )
                return

            // get the client IP first
            axios.get('https://api.ipify.org/?format=json').then( _ => {
                if ( typeof _.data.ip === "undefined" )
                    return
                // send an xhr request
                axios.get(siteurl + "cus-visit?fp=" + fingerprint + "&ip=" + (_.ip || "0.0.0.0")).then( _ => {
                    if ( _.data.visitor == "null" )
                        window.location = menuUrl

                    // redirect to register
                    window.location.href = "cus-signup"
                    
                }).catch( _ => { console.log(_.error.message) })
            })
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
            // call the xhr method and see to where this visitor should be redirected
            currentCustomer(event)
        }
    });
</script>
</body>
</html>