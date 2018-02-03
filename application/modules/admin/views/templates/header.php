<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title><?php echo isset($title) ? $title : ""; ?> | InstaCraft Admin</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <meta name="theme-color" content="#ffffff">
        
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
        <link id="style_color" href="<?php echo base_url(); ?>assets/admin/ninjaDate/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<!--        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>-->
<!--        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/css/multi-select.css"/>

        <link href="<?php echo base_url(); ?>assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/layout/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/dev.css" rel="stylesheet" type="text/css"/>
        
<?php if(isset($requiredcss) && $requiredcss == 'setting'): ?>
        <link href="<?php echo base_url(); ?>assets/admin/pages/css/setting.css" rel="stylesheet" type="text/css"/>
<?php endif; ?>
     
        
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://unpkg.com/sweetalert2@7.4.0/dist/sweetalert2.all.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!--<script src="<?php echo base_url(); ?>assets/admin/maps/dist/locationpicker.jquery.min.js"></script>-->
          
          <!-- Start : All Conditional Css Js -->
            <?php if($this->uri->segment(1) == 'aaaaaaaaaaa'): ?>
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUn6xFIhZMUHF7A9uquTkYThIZFN2KQBo&libraries=places" type="text/javascript"></script>
            <?php endif; ?>
            <?php if($this->uri->segment(1) == 'termsCondition' || $this->uri->segment(1) == 'privacyPolicy' || $this->uri->segment(1) == 'addHealthInfo' || $this->uri->segment(1) == 'editHealthInfo'):?>
                <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=cyptem6osx7jtedqurx6m5tzb5g1d00k2qa6gy9nsngdian7"></script>
                <script>
                    tinyMCE.init({
                            // General options
                            mode : "specific_textareas",
                            editor_selector : "mceEditor",
                            plugins: 'link image code',
                            //content_css: ['//fonts.googleapis.com/css?family=Lato:300,300i,400,400i','//www.tinymce.com/css/codepen.min.css']
                    });
                </script>
            <?php endif; ?> 
          <!-- End   : All Conditional Css Js -->
              
     </head>

    <body class="page-header page-quick-sidebar-over-content bg">
        <!-- BEGIN HEADER -->

        <div class="page-header navbar navbar-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner">
                <!-- BEGIN LOGO -->
                <div class="page-logo left">
                    <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" class="logo-default">
                    <div class="txt-cont">
                    <h2 class="theme-color">InstaCraft</h2>
                    <p class="theme-color">System Management Console</p>
                    </div>
                    <div class="menu-toggler sidebar-toggler hide">
                    </div>
                </div>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <a href="#">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?><?php echo isset($header['data']['requiredcss']) ? 'admin-dashboard' : 'manage-users'; ?>">
                                <i class="<?php echo isset($header['data']['requiredcss']) ? 'glyphicon glyphicon-home' : 'fa fa-cog'; ?>" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Username</span>
                            </a>
                        </li>
<!--                        <li <?php echo $this->uri->segment(1) == "change_password" ? "class='active'" : "class=''"; ?>>
                                <a href="<?php echo $this->config->base_url();?>change_password"/>
                                    <p class="white">Change Password</p>
                                </a>
                        </li>-->
<!--                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username username-hide-on-mobile">
                                    <?php echo "Admin";  ?>
                                </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="<?php echo base_url() ?>logout">
                                        <i class="icon-key"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>-->
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
        <div class="page-container"> 
