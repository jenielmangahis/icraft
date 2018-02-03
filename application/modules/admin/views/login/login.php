<!-- BEGIN LOGIN -->

<div class="content" style="margin-top:-10px;">
    <!-- BEGIN LOGIN FORM -->
    
    <h3 class="form-title" style="margin-top: 10px;margin-bottom: 10px;">Sign in</h3>
        <?php 
            //$message = $this->uri->segment('1');
            if(isset($_GET['forget'])){
                if($_GET['forget'] == '1'){
                    echo '<script type="text/javascript">alert("A reset password mail has been sent successfully, Please check your mail");</script>';
                }
                if($_GET['forget'] == '0'){
                    echo '<script type="text/javascript">alert("Invalid emailid , please proceed again");</script>';
                }
            }
            
            if($this->session->flashdata('error')){?>
            <div class="alert alert-danger">      
              <?php echo $this->session->flashdata('error')?>
            </div>
        <?php } ?>
            
       <form class="login-form" id="loginForm" action="<?php echo base_url(); ?>login_check" method="post">
            <div class="form-group">
                
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <input class="form-control form-control-solid placeholder-no-fix" maxlength="50" type="text" autocomplete="off" placeholder="Username" id="email" name="email"/>
                <span id="email-error" class="help-block hide"></span>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" maxlength="20" placeholder="Password" id="password" name="password"/>
                <span id="password-error" class="help-block hide">sdadasdasdas</span>
            </div>
            
            <div class="form-actions log_btn">
                <input type="submit" class="btn btn-success uppercase" id="loginsubmit" name="login"  value="Login"> 
            </div>
        </form>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        <!--
        <div class="row">
            <div class="col-md-6">
                <a id="forget_password">Lost your password?</a>
            </div>
        </div>
        -->
    <!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->


<div class="modal fade in" id="forgetPopUp" tabindex="-1" role="basic" aria-hidden="true" style="padding-right: 15px;">
    <div class="modal-dialog">
        <form id="forgetpswForm" action="forgot_password" method="post" >
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePop" style="border:1px solid grey;"></a>
                <h4 class="modal-title red">Please enter your email id</h4>
            </div>
            <div class="modal-body"><input type="text" class="form-control" id="forgetpsw_email" name="forgetpsw_email" placeholder="example123@domain.com" /></div>
            <div class="modal-footer">
<!--                <a href="" id="writeDeactivateURL"  class="btn green">Yes</a>-->
                <input type="submit" class="btn green" name="submit" >
                <a class="btn red"  id="closePop">Cancel</a>
            </div>
        </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>