<section class="container clearfix">
    <header class="clearfix post">
        <a href="javascript:;" id="login" class="left <?php if ($pageName == 'Login') { ?>active<?php }?>">Sign In</a>
        <a href="javascript:;" id="register" class="right <?php if ($pageName == 'Register') { ?>active<?php }?>">Register</a>
        <div class="logo_img">
            <img src="<?= $this->config->item('customerassets') ?>images/new_logo.png" alt="logo" class="col">
        </div>
    </header>
    
    
    <div class="form-container clearfix login_section" style="display:<?php if ($pageName == 'Login') { ?>block<?php } else { ?>none<?php } ?>; width:100% " >
        <?= form_open_multipart('cus-login', array('class' => 'clearfix ajaxform')) ?>    
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
        <a href="<?php if(isset($authUrl) && !empty($authUrl)) { echo $authUrl;}else{echo"javascript:void(0)";}?>" class="social-btn btn">
            <span class="icon-facebook left"></span>
            <span class="btn-txt left" onclick="">Sign Up with Facebook</span>
        </a>
        <button class="btn gradient login-bth">
            <span class="btn-txt left">Sign In</span>
            <span class="icon-right-arrow right"></span>
        </button>
        <?= form_close() ?>
    </div>
    
    
    
    <div class="form-container clearfix register_section" style="display:<?php if ($pageName == 'Register') { ?>block<?php } else { ?>none<?php } ?>">
        <?= form_open_multipart('cus-signup', array('class' => 'clearfix ajaxform')) ?>
        <input type="hidden" name="fingerprint" value="">   
        <input type="hidden" name="ip" value="">   
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
        <a href="<?php if(isset($authUrl) && !empty($authUrl)) { echo $authUrl;}else{echo"javascript:void(0)";}?>" class="social-btn btn">
            <span class="icon-facebook left"></span>
            <span class="btn-txt left">Sign Up with Facebook</span>
        </a>
        <button class="btn gradient login-bth">
            <span class="btn-txt left">Sign Up</span>
            <span class="icon-right-arrow right"></span>
        </button>
        <?= form_close() ?>
    </div>
    
    
</section>
<p class="note hide">We will never post to your social media without your permission.</p>
<script type="text/javascript">
    // set the finger print
    new Fingerprint2().get(function(result, components){
        $('input[name=fingerprint]').val(result)
    })
    // set the correct client ip
    axios.get('https://api.ipify.org/?format=json').then(_ => {
        $('input[name=ip]').val(_.data.ip)
    }).catch(_ => {
        return
    })
</script>