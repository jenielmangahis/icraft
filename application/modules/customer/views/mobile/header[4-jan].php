<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>InstaCraft</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <script src="<?= $this->config->item('customerassets') ?>js/jquery-1.11.1.min.js"></script>
        <script src="<?= $this->config->item('customerassets') ?>js/jquery-ui.js"></script>
        <script src="<?= $this->config->item('customerassets') ?>js/enscroll.min.js"></script>
        <script src="<?= $this->config->item('customerassets'); ?>js/jquery.form.js" type="text/javascript"></script>
        <script src="<?= $this->config->item('customerassets') ?>js/formclass.js"></script>
        <script src="<?= $this->config->item('customerassets') ?>js/custom.js"></script>

        <!-- CSS files -->
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
    </head>
    <body>
        <section class="mobile_wrapper">
            <img src="<?= $this->config->item('customerassets') ?>images/iPhone-Mockup.png" class="desk_img" alt="iphone">
            <div class="mobile_elements <?=$bodyClass?>">
                <div id="wait-div" class="wait-div">
                    <div class="wait-divin"><img src="<?= $this->config->item('customerassets'); ?>images/loading-x.gif"></div>
                </div>
                <nav class="side_menu" style="display:<?= $nav_display ?>">
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
                        <li><a href="<?= base_url() ?>cus-social-share"><i class="icon-bonuses"></i><span>Share</span></a></li>
                        <li><a href="<?= base_url() ?>cus-page/about-us"><i class="icon-about_us"></i><span>About Us</span></a></li>
                        <li><a href="javascript:;"><i class="icon-faq"></i><span>FAQ</span></a></li>
                        <li><a href="<?= base_url() ?>cus-page/terms-conditions"><i class="icon-tnc"></i><span>Terms &amp; Conditions</span></a></li>
                        <li><a href="<?= base_url() ?>cus-log-out"><i class="icon-log_out"></i><span>Log Out</span></a></li>
                    </ul>
                </nav>

                <?php if ($pageName != 'Register' && $pageName != 'Login' && $pageName != 'Splash') {
                    $headerArr = explode(',', $header_class); ?>
                    <header class="gradient main_header">
                        <a href="<?= $headerArr[1] ?>" class="back-screen <?= $headerArr[0] ?> left"></a>
                        <h1 id="page_name_header"><?= $pageName ?></h1>
                            <?php if (sizeof($header_class_right) > 0) { ?>
                            <div class="header_panel right">
                                <?php foreach ($header_class_right as $key => $right_class) {
                                    $arr = explode(',', $right_class);
                                    ?>
                                <a href="<?= $arr[1] ?>" class="<?= $arr[0] ?>"> <?= $arr[2] ?></a>
                            <?php } ?>
                            </div>
                    <?php } ?>
                    </header>
<?php } ?>
        