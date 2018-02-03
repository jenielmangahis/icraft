<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?= $this->config->item('flashPhonerAssets') ?>video-chat.css">
    <!-- CSS files -->
        <link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/style.css">
        <link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/jquery-ui.css">
    <title>Video Consultation</title>
    <script type="text/javascript" src="<?= $this->config->item('flashPhonerAssets') ?>flashphoner.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('flashPhonerAssets') ?>dependencies/jquery/jquery-1.12.0.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('flashPhonerAssets') ?>dependencies/js/utils.js"></script>

    <script type="text/javascript" src="<?= $this->config->item('flashPhonerAssets') ?>conference.js"></script>
    <!-- Bootstrap JS -->
    <script src="<?= $this->config->item('flashPhonerAssets') ?>dependencies/bootstrap/js/bootstrap.js"></script>
    <script>
        var _participants = 2;
        var siteurl = "<?= site_url(); ?>";
    </script>
</head>
<body onload="init_page()">
    <header class="gradient main_header">
        <a href="<?= $headerArr[1] ?>" class="back-screen <?= $headerArr[0] ?> left"></a>
        <h1><?= $pageName ?></h1>
        <?php if (sizeof($header_class_right) > 0) { ?>
                <div class="header_panel right">
                    <?php foreach ($header_class_right as $key => $right_class) {
                        $arr = explode(',', $right_class); ?>
                        <a href="<?= $arr[1] ?>" class="<?= $arr[0] ?>"><?= $arr[2] ?></a>
                <?php } ?>
                </div>
        <?php } ?>
    </header>
    <div id="wait-div" class="wait-div">
        <div class="wait-divin"><img src="<?= $this->config->item('customerassets'); ?>images/loading-x.gif"></div>
    </div>
<div class="container">
    <h2 id="notifyFlash" class="text-danger"></h2>
    

        <div class="col-sm-7">
            <form class="form-horizontal" role="form">
                <div id="connForm" class="form-group">
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="url">
                    </div>
                </div>
                <div class="form-group" id="loginForm">
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="login" value="<?= $userRecord->email?>">
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="call_initiator" value="<?= $userRecord->email?>">
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="appointment_id" value="<?= $appointment_id?>">
                    </div>
                    
                    <div class="col-sm-4 text-left text-danger">
                        <div id="failedInfo"></div>
                    </div>
                </div>
            </form>
        </div>

        <div class="main_video_container">
            <div class="pos_rel">
                <div class="fp-remoteVideo">
                    <div id="participant1Display" class="display"></div>
                </div>
                <div class="fp-localVideo">
                    <div id="localDisplay" class="display"></div>
                </div>
            </div>
            <div id="participant1Name" class="text-center text-muted">NONE</div>
            <div class="text-center" style="margin-top: 20px">
                <div id="participant1Status"></div>
            </div>
        </div>

        <div class="call_btn">
            <button id="joinBtn" type="button" class="btn btn-default icon-end-call gradient"></button>
            <label id="statuss"></label>
        </div>

<!--        <div class="appointment_info">
            <h2>Doctor Name</h2>
            <p>Appointment Date: July 23rd, 2017</p>
            <p>Appointment Time: 10:30 to 10:45</p>
        </div>-->

</div>
    <script>
        $(document).on('click',".owner",function(){
            $.ajax({
                type: 'POST',
                data: {},
                url: siteurl + 'end-call-status',
                dataType: "json",
                beforeSend: function () {
                    $('.wait-div').show();
                },
                success: function (data) {
                    $('.wait-div').hide();
                    window.location = siteurl+'cus-home';
                }
            });
            
        });
    </script>
</body>
</html>




<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= $this->config->item('flashPhonerAssets') ?>dependencies/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= $this->config->item('flashPhonerAssets') ?>dependencies/bootstrap/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $this->config->item('flashPhonerAssets') ?>video-chat.css">
     CSS files 
        <link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/style.css">
        <link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/jquery-ui.css">
    <title>Video Consultation</title>
    <script type="text/javascript" src="<?= $this->config->item('flashPhonerAssets') ?>flashphoner.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('flashPhonerAssets') ?>dependencies/jquery/jquery-1.12.0.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('flashPhonerAssets') ?>dependencies/js/utils.js"></script>

    <script type="text/javascript" src="<?= $this->config->item('flashPhonerAssets') ?>conference.js"></script>
     Bootstrap JS 
    <script src="<?= $this->config->item('flashPhonerAssets') ?>dependencies/bootstrap/js/bootstrap.js"></script>
    <script>
        var _participants = 2;
        var siteurl = "<?= site_url(); ?>";
    </script>
</head>
<body onload="init_page()">
    <header class="gradient main_header">
        <a href="<?= $headerArr[1] ?>" class="back-screen <?= $headerArr[0] ?> left"></a>
        <h1><?= $pageName ?></h1>
        <?php if (sizeof($header_class_right) > 0) { ?>
                <div class="header_panel right">
                    <?php foreach ($header_class_right as $key => $right_class) {
                        $arr = explode(',', $right_class); ?>
                        <a href="<?= $arr[1] ?>" class="<?= $arr[0] ?>"><?= $arr[2] ?></a>
                <?php } ?>
                </div>
        <?php } ?>
    </header>
<div class="container">
    <div class="row">

        <h2 id="notifyFlash" class="text-danger"></h2>

        <div class="col-sm-7 text-center">
            <h2> </h2>
        </div>
        <div class="col-sm-7">
            <form class="form-horizontal" role="form" style="margin-top: 10px">
                <div id="connForm" class="form-group">
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="url">
                    </div>
                </div>
                <div class="form-group" id="loginForm">
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="login" value="<?= $userRecord->email?>">
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="call_initiator" value="<?= $userRecord->email?>">
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="appointment_id" value="<?= $appointment_id?>">
                    </div>
                    <div class="col-sm-4 text-right">
                        <button id="joinBtn" type="button" class="btn btn-default">Call</button>
                        <label id="statuss"></label>
                    </div>
                    <div class="col-sm-4 text-left text-danger">
                        <div id="failedInfo"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-7">
            <div style="width: 642px; height: 482px;">
                <div class="fp-remoteVideo">
                    <div id="participant1Display" class="display"></div>
                </div>
                <div class="fp-localVideo">
                    <div id="localDisplay" class="display"></div>
                </div>
            </div>
            <div id="participant1Name" class="text-center text-muted">NONE</div>
            <div class="text-center" style="margin-top: 20px">
                <div id="participant1Status"></div>
            </div>
        </div>

    </div>

</div>
    <script>
        <script>
        $(document).on('click',".owner",function(){
            window.location = siteurl+'cus-home';
        });
    </script>
</body>
</html>-->