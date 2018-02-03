<section class="container clearfix">
    <header class="clearfix post">
        <a href="javascript:;" id="login" class="left <?php if ($pageName == 'Login') { ?>active<?php }?>">Sign In</a>
        <a href="javascript:;" id="register" class="right <?php if ($pageName == 'Register') { ?>active<?php }?>">Register</a>
        <img src="<?= $this->config->item('customerassets') ?>images/logo_new.png" alt="logo" class="logo_img">
    </header>
    
    
    <div class="form-container clearfix login_section" style="display:<?php if ($pageName == 'Login') { ?>block<?php } else { ?>none<?php } ?>">
        <?= form_open_multipart('cus-login', array('class' => 'clearfix ajaxform', 'id' => '')) ?>    
        <div class="alert alert-info wait-div " style="display:none;"> <strong>Please wait! </strong> Your action is in proccess... </div>
        <div id="jGrowl" class="top-right jGrowl col-md-12"  style="display: none;">
            <button class="close" aria-hidden="true" data-dismiss="alert" style="padding:10px;" type="button">&times;</button>
            <div class="jGrowl-notification ">
                <div class="jGrowl-message ajax_message"></div>
            </div>
        </div>
        <label class="txt_input left_ico">
            <input type="text" name="email" placeholder="Email">
            <span class="input_ico icon-user"></span>
        </label>
        <label class="txt_input input-pass left_ico">
            <input type="Password" name="password" placeholder="Password">
            <span class="input_ico icon-lock"></span>
            <span class="icon-view view_input"></span>
        </label>
        <a href="javascript:;" class="right forgot-pass" id="forgot_password" data-attribute="forgot-pop">Forgot Password</a>
        <button class="btn gradient login-bth">
            <span class="btn-txt left">SIGN IN</span>
            <span class="icon-right-arrow right"></span>
        </button>
        <?= form_close() ?>
        <a href="<?php if(isset($authUrl) && !empty($authUrl)) { echo $authUrl;}else{echo"javascript:void(0)";}?>" class="social-btn btn">
            <span class="icon-facebook left"></span>
            <span class="btn-txt left" onclick="">Sign Up with Facebook</span>
        </a>
    </div>
    
    
    
    <div class="form-container clearfix register_section" style="display:<?php if ($pageName == 'Register') { ?>block<?php } else { ?>none<?php } ?>">
        <?= form_open_multipart('cus-signup', array('class' => 'clearfix ajaxform', 'id' => '')) ?>    
        <div class="alert alert-info wait-div " style="display:none;"> <strong>Please wait! </strong> Your action is in proccess... </div>
        <div id="jGrowl" class="top-right jGrowl col-md-12"  style="display: none;">
            <button class="close" aria-hidden="true" data-dismiss="alert" style="padding:10px;" type="button">&times;</button>
            <div class="jGrowl-notification msg">
                <div class="jGrowl-message ajax_message"></div>
            </div>
        </div>
        <label class="txt_input left_ico">
            <input type="text" name="email" placeholder="Email">
            <span class="input_ico icon-user"></span>
        </label>
        <label class="txt_input input-pass left_ico">
            <input type="Password" name="password" placeholder="Password">
            <span class="input_ico icon-lock"></span>
            <span class="icon-view view_input"></span>
        </label>
        <label class="txt_input input-promo">
            <input type="text" name="referrel_code" placeholder="Friend Referral Code">

        </label>
        <button class="btn gradient login-bth">
            <span class="btn-txt left">SIGN UP</span>
            <span class="icon-right-arrow right"></span>
        </button>
        <?= form_close() ?>
       
   
        <a href="<?php if(isset($authUrl) && !empty($authUrl)) { echo $authUrl;}else{echo"javascript:void(0)";}?>" class="social-btn btn">
            <span class="icon-facebook left"></span>
            <span class="btn-txt left">Sign Up with Facebook</span>
        </a>
    </div>
    
    
</section>
<p class="note" style="display:<?php if ($pageName == 'Register') { ?>block<?php } else { ?>none<?php } ?>">We will never post to your social media without your permission.</p>