<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Instacraft</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link href="<?php echo base_url() ?>assets/css/instastyle-mobile.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/developer.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/mobile.css" rel="stylesheet" />
 <script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>
     
    
</head>
<body id="body" data-spy="scroll" data-target=".header">
    <!--========== HEADER ==========-->
    <header class="header navbar-fixed-top header-mobile">
        <!-- Navbar -->
        <nav class="navbar" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="menu-container js_nav-item">
                </div>
                <!-- HAMBURGUER MENU ICON -->
                <span class="profile" style="position: absolute;top: 22px;">
                    <img class="profile-snap" src="<?php echo base_url() ?>assets/images/prof.jpg" />
                 </span>
                <input type="checkbox" name="toggle" id="toggle"/>
                <label for="toggle"  class="hamburger"></label>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="menu-mobile">
                    <div class="collapse navbar-collapse nav-collapse">
                        <div class="menu-container">
                            <ul class="nav navbar-nav container-right ">
                                <li class="js_nav-item nav-item"><a class="nav-item-child" href="<?php echo base_url() ?>dashboard">DashBoard</a></li>
                                <li class="js_nav-item nav-item"><a class="nav-item-child" href="<?php echo base_url() ?>appointments">My Appointments</a></li>
                                <li class="js_nav-item nav-item"><a class="nav-item-child" href="<?php echo base_url() ?>prescriptions">Prescriptions</a></li>
                                <li class="js_nav-item nav-item"><a class="nav-item-child" href="<?php echo base_url() ?>profile">Profile</a></li>
                                <li class="js_nav-item nav-item"><a class="nav-item-child" data-attribute="forgo-pass" id="chnagepass" data-href="#">Change password</a></li>
                                <li class="js_nav-item nav-item"><a class="nav-item-child" href="<?php echo base_url() ?>webLogout">Log Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>  
            </div>
        </nav>
    </header>
    <header class="header-desktop">
        <p class="title">Partner Doctor Platform</p>
        <span class="profile">
            <img class="profile-snap" src="<?php echo base_url() ?>assets/images/prof.jpg" />
            <span class="profile-pik"></span>
            <strong>Doctor profile</strong>
            <i class="icon-drop"></i>
        </span>
        <div class="profile-dropdown menu-desktop">
            <ul>
                <li><a data-attribute="forgo-pass" id="chnagepass" data-href="#"><i class="icon-lock"></i>Change password</a></li>
                <li><a href="<?php echo base_url() ?>webLogout"><i class="icon-icon2"></i>Log Out</a></li>
            </ul>
        </div>
    </header>
    
    <form id="changepasswordform"  >
    <div class="insta-pop" id="" data-pop="forgo-pass">
            <h1>Change Password</h1>
            
            <div class="alert alert-danger" style="display:none">      
                Password not set
              </div>
              <div class="alert alert-Success"  style="display:none">      
                Password set successfully
              </div>
            <div class="input-group">
                <input type="text" placeholder="Current Password" name="current_password" id="current_password" />
            </div>
            <div class="input-group">
                <input type="text" placeholder="New Password" name="new_password" id="new_password" />
            </div>
            <div class="input-group">
                <input type="text" placeholder="Confirm Password" name="confirm_password" />
            </div>
            <div class="btn-bg-grad">
                <!--<a href="#" data-attribute="cancel" id="chnagepass1" class="btn-insta">Submit</a>-->
                <input type="submit"  class="btn-insta-sub" name="save" id="chnagepass1"  value="Submit" />
            </div>
            <span class="close close_model"><i class="icon-cross"></i></span>
        </div>
    </form>
    <script src="<?php echo base_url() ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
   <script src="<?php echo base_url() ?>assets/js/custom.js" type="text/javascript"></script>
    <script>
        var siteurl =   '<?= site_url(); ?>';
    $(document).ready(function() {
        $('#chnagepass1').on('click', function() {
          
       //   e.preventDefault();
            $("#changepasswordform").validate({
                rules: {
                    current_password: {
                        required: true,
                        minlength: 6,
                    },
                    new_password: {
                        required: true,
                        minlength: 6,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password"
                    }
                },
                messages: {
                    current_password: {
                        required: "Please Enter Current password",
                    },
                    new_password: {
                        required: "Please Enter New Password",
                    },
                    confirm_password: {
                        required: "New Password and Current Password are not same",
                    }
                },
            submitHandler: function () {
            
            var fr = {};
                fr.current_password = $('#current_password').val();
                fr.new_password = $('#new_password').val();
                jsonString = JSON.stringify(fr);
                

                $.post( 
                  "<?php echo base_url(); ?>changePassword",{current_password:fr.current_password,new_password:fr.new_password},
                  function(data) {
                     
                     if(data ==1){
                        $('.alert-danger').hide();
                        $('.alert-Success').show();
                        setTimeout(function () {//remove pop up after 1.5 seconds
                            $('body').removeClass('overlaypop');
                            $('.insta-pop').removeClass('opend-pop');
                            $('.insta-pop').fadeOut();
                        }, 1500);
                         
                         
                     }else if(data == 0){
                         $('.alert-Success').hide();
                         $('.alert-danger').show();
                         
                     }
                  }
                );
					

                }

            });
        
        });
    });
    </script>
    
    