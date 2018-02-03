<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>InstaCraft</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <script src="<?= $this->config->item('customerassets') ?>js/jquery-1.11.1.min.js"></script>
        <script src="<?= $this->config->item('customerassets') ?>js/jquery-ui.js"></script>
        <script src="<?= $this->config->item('customerassets') ?>js/enscroll.min.js"></script>
        <script src="<?= $this->config->item('customerassets'); ?>js/jquery.form.js" type="text/javascript"></script>
        <script src="<?= $this->config->item('customerassets') ?>js/formclass.js"></script>
        <script src="<?= $this->config->item('customerassets') ?>js/custom.js"></script>

        <!-- OneSignal notifications -->
        <link rel="manifest" href="<?= $this->config->item('base_url') ?>manifest.json" />
        <!-- CSS files -->
        <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="<?= $this->config->item('globalassets') ?>plugins/icheck/skins/all.css" rel="stylesheet">
        <link type="text/css" href="<?= $this->config->item('globalassets') ?>plugins/datetimepicker-master/build/jquery.datetimepicker.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/style.css">
        <!--<link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/jquery-ui.css">-->

        <script>
            var pageckeditor = false;
            var siteurl = "<?= site_url(); ?>";

            function loginWithFaceBook()
            {
                window.open(siteurl + 'cus-facebook-login', "popupWindow", ", top=500,left=500,width=600,height=600,scrollbars=yes");
            }
        </script>
        
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script src="<?php echo $this->config->item('customerassets') ?>js/notifications.js" type="text/javascript"></script>
        <script src="https://unpkg.com/sweetalert2@7.4.0/dist/sweetalert2.all.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fingerprintjs2@1.6.1/dist/fingerprint2.min.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="<?= $this->config->item('globalassets') ?>plugins/icheck/icheck.min.js"></script>
        <script src="<?= $this->config->item('globalassets') ?>plugins/datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Facebook -->
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId            : '1553864924904393',
              autoLogAppEvents : true,
              xfbml            : true,
              version          : 'v2.11'
            });
          };

          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "https://connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        </script>
    </head>
    <body>
        <section class="mobile_wrapper">
            <img src="<?= $this->config->item('customerassets') ?>images/iPhone-Mockup.png" class="desk_img" alt="iphone">
            <div class="mobile_elements <?= isset($bodyClass) ? $bodyClass : '' ?>">
                <div id="wait-div" class="wait-div">
                    <div class="wait-divin"><img src="<?= $this->config->item('customerassets'); ?>images/loading-x.gif"></div>
                </div>
                <nav class="side_menu" style="display:<?= isset($nav_display) ?>">
                    <ul>
                        <li class="clearfix"><a href="<?= base_url() ?>cus-profile-view"><i class="icon-profile"></i><span>My Profile</span></a></li>
                        <li><a href="<?= base_url() ?>cus-my-prescription"><i class="icon-prescription"></i><span>My Prescriptions</span></a></li>
                        <li><a href="<?= base_url() ?>cus-home"><i class="icon-home"></i><span>Home</span></a></li>
                        <li><a href="<?= base_url() ?>cus-medical-license"><i class="icon-status"></i><span>Medical License</span></a></li>
                        <li><a href="javascript:;"><i class="icon-status"></i><span>Status</span></a></li>
                        <li><a href="<?= base_url() ?>cus-add-tocart"><i class="icon-cart"></i><span>My Cart</span></a></li>
                        <li><a href="<?= base_url() ?>cus-my-orders"><i class="icon-menu"></i><span>My Orders</span></a></li>
                        <li><a href="javascript:;"><i class="icon-bonuses"></i><span>Bonuses</span></a></li>
                        <li><a href="<?= base_url() ?>cus-settings"><i class="icon-settings"></i><span>Settings</span></a></li>
                        <li><a href="<?= base_url() ?>cus-social-share"><i class="icon-bonuses"></i><span>Share & Save</span></a></li>
                        <li><a href="<?= base_url() ?>cus-page/about-us"><i class="icon-about_us"></i><span>About Us</span></a></li>
                        <li><a href="javascript:;"><i class="icon-faq"></i><span>FAQ</span></a></li>
                        <li><a href="<?= base_url() ?>cus-page/terms-conditions"><i class="icon-tnc"></i><span>Terms &amp; Conditions</span></a></li>
                        <li><a href="<?= base_url() ?>cus-log-out"><i class="icon-log_out"></i><span>Log Out</span></a></li>
                    </ul>
                </nav>

                <?php if ($pageName != 'Register' && $pageName != 'Login' && $pageName != 'Splash') {
                    $headerArr = explode(',', $header_class); ?>
                    <header class="gradient main_header d-flex flex-nowrap justify-content-start align-items-center">
                        <a href="<?= $headerArr[1] ?>" class="back-screen px-0 col-1 <?= $headerArr[0] ?> left"></a>
                        <h1 id="page_name_header" class="m-0 pl-0 col-7"><?= $pageName ?></h1>
                        <?php if (isset($header_class_right) && sizeof($header_class_right) > 0) { ?>
                        <div class="header_panel col-4 d-flex justify-content-end">
                            <?php foreach ($header_class_right as $key => $right_class) {
                                $arr = explode(',', $right_class);
                            ?>
                                <a href="<?= $arr[1] ?>" class="<?= $arr[0] ?>"> <?= !isset($arr[2]) ?"": $arr[2] ?></a>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </header>
                <?php } ?>
        