<div class="page-content-wrapper" style="width:100%;">
    <div class="page-content" style="min-height:895px;width:100% !important;margin-left:0px;" > 
        <form action ="<?php echo $this->config->base_url(); ?>change_password" id="changePassword" name="userChangePassword" method="POST">
            
            <div class="TableContent">
                <div class="content_wrapper pwd" style="width:35% !important;">
                   <?php if ($this->session->userdata('SuccessMsg') != "") {  ?>
                    <div class="success alert-info toBeHidden custom-success" role="alert">
                        <?php echo $this->session->userdata('SuccessMsg');
                            $this->session->unset_userdata('SuccessMsg');
                        ?>
                    </div>
                <?php }
                        if ($this->session->userdata('errorMsg') != "") { 
                        ?>
                        <div class="alert alert-danger toBeHidden custom-danger" role="alert"> 
                            <?php echo $this->session->userdata('errorMsg');
                            $this->session->unset_userdata('errorMsg');
                            ?>
                        </div>
                <?php  } ?>
                <?php if($sidebar['data']['pageError'] == 'valid_uri'): ?>
                    <div class="password_change_wrap">
                        <h4 class="text-left">Change Password</h4>
                        <input type="hidden" name="user_email" value="<?php echo $sidebar['data']['user_email']; ?>" />
                        <div class="cp-input">
                        <!--
                            <div class="input_row">
                                <label>Current Password</label>
                                <input type="password" name="current_password" placeholder="">
                            </div>
                        -->
                            <div class="input_row">
                                <label>New Password</label>
                                <input type="password" name="new_password" id="new_password" placeholder="">
                                <span id="new_psw-error" class="help-block"  style="color:#d40e0e;">Please enter new password</span>
                            </div>
                            <br/>
                            <div class="input_row">
                                <label>Re-enter Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="">
                                <span id="cnfrm_psw-error" class="help-block"  style="color:#d40e0e;">Please enter confirm password</span>
                            </div>

                            <div class="input_row">
                                <input class="lh_btn cp-submit" type="submit" name="submit" value="Update">
                            </div>
                        </div>
                    </div>
                <?php elseif($sidebar['data']['pageError'] == 'invalid_uri'): ?>
                        <div class="password_change_wrap">
                            <h4 class="text-left">Change Password</h4>
                            <div class="cp-input">
                                <h5 class="alert" style="color:red;border: 1px solid rgba(185, 57, 57, 0.76);"><b>Reset Pasword link is not valid.</b></h5>
                            </div>
                        </div>
                <?php elseif($sidebar['data']['pageError'] == 'expired_uri'): ?>
                        <div class="password_change_wrap">
                            <h4 class="text-left">Change Password</h4>
                            <div class="cp-input">
                                <h5 class="alert" style="color:red;border: 1px solid rgba(185, 57, 57, 0.76);"><b>Reset Password link is expired.</b></h5>
                            </div>
                        </div>
                <?php elseif($sidebar['data']['pageError'] == 'password_change_success'): ?>
                        <div class="password_change_wrap">
                            <h4 class="text-left">Change Password</h4>
                            <div class="cp-input">
                                <h5 class="alert" style="color:#1283ca;border: 1px solid rgba(96, 204, 78, 0.76);"><b>Password has been updated successfully.</b></h5>
                            </div>
                        </div>
                <?php else: ?>
                        <div class="password_change_wrap">
                            <h4 class="text-left">Change Password</h4>
                            <div class="cp-input">
                                <h5 class="alert" style="color:red;border: 1px solid rgba(185, 57, 57, 0.76);"><b>Something went wrong.</b></h5>
                            </div>
                        </div>
                <?php endif; ?>
                    

                </div>

            </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script type="text/javascript">
    
//-- Created By N.K.
    function setFeedError(ele, dpart) {
        var element = $("span#"+ele);
        
        if(element.hasClass('hide')){
            element.removeClass("hide");
            element.html(dpart);
        }else{
            element.html(dpart);
        }
    }
    
    //-- Created By N.K.
    function washFeedError(ele) {
        var element = $("span#"+ele);
        
        if(element.hasClass('hide')){
            element.html("");
        }else{
            element.addClass("hide");
            element.html("");
        }
    }


    $("#changePassword").submit(function(){
        var error = [];
        var new_psw    = $("#changePassword").contents().find('input[name="new_password"]').val();
        var cnfrm_psw  = $("#changePassword").contents().find('input[name="confirm_password"]').val();
        
        //--- New Password Validation
        if(new_psw == ''){
            setFeedError('new_psw-error','<b>New Password is required</b>');
            error['new_psw'] = true;
        }else if(new_psw.length <= 5){
            setFeedError('new_psw-error','<b>New Password must be between 6 and 20 characters</b>');
            error['new_psw'] = true;
        }else if(new_psw.length >= 20){
            setFeedError('new_psw-error','<b>New Password must be between 6 and 20 characters</b>');
            error['new_psw'] = true;
        }          
        else{
            washFeedError('new_psw-error');
            error['new_psw'] = false;
        }

        //--- New Password Validation
        if(cnfrm_psw == ''){
            setFeedError('cnfrm_psw-error','<b>Confirm Password is required</b>');
            error['cnfrm_psw'] = true;
        }else if(new_psw != cnfrm_psw){
            setFeedError('cnfrm_psw-error',"<b>New Password and Confirm password didn't match</b>");
            error['cnfrm_psw'] = true;
        }           
        else{
            washFeedError('cnfrm_psw-error');
            error['cnfrm_psw'] = false;
        }


        if(error['new_psw'] == true || error['cnfrm_psw'] == true){
            return false;
        }else{
            return true;
        }
        
    });
</script>
</body>
</html>
