<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?= $this->config->item('flashPhonerAssets') ?>video-chat.css">
    <title>Two Way Video Chat</title>
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
    <style>
        /*Video Call*/
.main_video_container{width: 90%; margin:0 auto;}
.main_video_container .fp-remoteVideo{width: 100%; height: 400px; position: relative !important; padding: 0 10px; border-radius:30px; overflow: hidden; }
.main_video_container .fp-localVideo{width: 125px; height: 156px; bottom: -10px; right: -10px; border-radius:15px; overflow: hidden;}
#joinBtn{width: 70px; height: 70px; margin:15px auto 15px auto; border-radius: 50%; border:5px solid #e4f3fa; font-size: 30px;}
.appointment_info{ color: #444444; width: 90%; margin: 0 auto 15px auto; }
.appointment_info h2{font-size: 20px;}
.appointment_info h2 + p{margin:10px 0; text-align: left;}
.main_video_container video{width: auto; height: 100%;}
        </style>
</head>
<body onload="init_page()">
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
                        <input type="hidden" class="form-control" id="appoint_id" value="<?= $appointment_id?>">
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

        
        <div class="col-sm-4 text-right">
            <button id="joinBtn" type="button" class="btn btn-default icon-end-call gradient"></button>
            <label id="statuss"></label>
        </div>

   
</div>
    <script>
        $(document).on('click',".doctor",function(){
            window.location = siteurl+'dashboard';
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
    <title>Two Way Video Chat</title>
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
<div class="container">
    <div class="row">

        <h2 id="notifyFlash" class="text-danger"></h2>
        
        <div class="col-sm-7 text-center">
            <h2>Two Way Video Chat</h2>
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
                        <input type="hidden" class="form-control" id="appoint_id" value="<?= $appointment_id?>">
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

        <div class="col-sm-7">
            <div class="col-sm-6">
                <button id="localAudioToggle" type="button" class="btn btn-default">Mute A</button>
                <button id="localVideoToggle" type="button" class="btn btn-default">Mute V</button>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="col-sm-6" style="margin: 5px auto auto auto;">
                <button id="localStopBtn" type="button" class="btn btn-default">Publish</button>
                <label id="localStatus"></label>
            </div>
        </div>
        <div class="col-sm-7" style="margin-top: 20px">
            <div class="form-group">
                <div id="chat" style="overflow-y: scroll; height: 100px;" class="text-left form-control"></div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="form-group">
                <textarea id="message" class="form-control" rows="1" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="pull-right">
                <button id="sendMessageBtn" type="button" class="btn btn-default">Send</button>
            </div>
        </div>

        <div class="col-sm-7" style="margin-top: 20px">
            <span class="text-muted text-left">Invite</span>
            <div id="inviteAddress" class="text-muted text-center" style="border: 1px solid">Not connected</div>
        </div>
    </div>
    <div class="row" style="margin-top: 70px;">
        <div class="col-sm-4"">
            <a href="https://play.google.com/store/apps/details?id=com.flashphoner.wcsexample.video_chat"><img src="../../dependencies/img/google_play.jpg" title="Google Play" alt="Google Play"></a>
        </div>
    </div>
</div>
    <script>
        $(document).on('click',".doctor",function(){
            window.location = siteurl+'dashboard';
        });
    </script>
</body>
</html>-->