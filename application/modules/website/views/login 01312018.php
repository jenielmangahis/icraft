<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Instacraft</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url() ?>assets/css/instastyle.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/developer.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/mobile.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    
</head>
<body>
   <div class="logo-login"><img src="<?php echo base_url(); ?>assets/images/logo.png" />
       <p>Partner Doctor Platform</p>
    </div>
    
    <?php if($this->session->flashdata('error')){?>
        <div class="alert alert-danger">      
          <?php echo $this->session->flashdata('error')?>
        </div>
    <?php } ?>
    
    
    <form class="login-form-check" id="loginForm" action="<?php echo base_url(); ?>loginCheckWeb" method="post">
        <div class="login-form">
            <h1>SIGN IN</h1>
            <input type="email" name="email" placeholder="Email ID" />
            <input type="password" name="password" placeholder="Password" />
            <a href="#" class="fg-password">Forgot Password ?</a>

            <div class="btn-bg-grad-login">
                <!--<a href="#" class="btn-insta">Login</a>-->
                <input type="submit" class="btn-insta-sub" name="login" style="display: block;text-align: center;padding-left: 0px !important;padding-right: 0px !important;padding-top: 13px !important;padding-bottom: 13px !important;"  />
            </div>
            <a href="#" class="cont-adm">Contact Admin</a>
        </div>
    </form>    
    
    <script>
        
        $('.login-form-check').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },

            messages: {
                email: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });
        
        
    </script>
    
    
</body>
</html>
