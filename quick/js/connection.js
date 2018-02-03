'use strict';
var currentUser,
    token;
function login(){
    $('#loginForm').modal('show');
    $('#loginForm .progress').hide();
    
}
$(function() { 
    //alert('hjghkjdhgk');
    $(document).on('click',"#user1",function(){
     
        currentUser = QBUser1;
        connectToChat(QBUser1);
    });

    $(document).on('click',"#user2",function(){	
        currentUser = QBUser2;
        connectToChat(QBUser2);
    });
    
  $(document).on('click',"#user3",function(){
        currentUser = QBUser3;
        connectToChat(QBUser3);
    });

    var niceScrollSettings = {
        cursorcolor:'#02B923',
        cursorwidth:'7',
        zindex:'99999'
    };

    $('html').niceScroll(niceScrollSettings);
    $('.nice-scroll').niceScroll(niceScrollSettings);
});

function connectToChat(user) {
    //alert('connectToChat'); 
    $('#loginForm button').hide();
    $('#loginForm .progress').show();
    
    QB.createSession({login:user.login,password:user.pass}, function(err,res) {
        if (res) {
            token = res.token;
            user.id = res.user_id;

            mergeUsers([{user: user}]);
            
            QB.chat.connect({userId: user.id, password: user.pass}, function(err,roster) {
                
                if (err) {
                     //alert(JSON.stringify(err));
                   // console.log(err);
                } else {
                     //alert('success');
                    // setup scroll stickerpipe module
                    setupStickerPipe();
		 // createNewDialog1();
                    retrieveChatDialogs();
                     
                    // setup message listeners
                    setupAllListeners();

                    // setup scroll events handler
                    setupMsgScrollHandler();
                }
            });
        }
    });
}

function setupAllListeners() {
  QB.chat.onMessageListener=onMessage;
  QB.chat.onSystemMessageListener=onSystemMessageListener;
  QB.chat.onDeliveredStatusListener=onDeliveredStatusListener;
  QB.chat.onReadStatusListener=onReadStatusListener;

  setupIsTypingHandler();
}
// reconnection listeners
function onDisconnectedListener(){
  console.log("onDisconnectedListener");
}

function onReconnectListener(){
  console.log("onReconnectListener");
}


// niceScroll() - ON
$(document).ready(
    function() {
    
    }
);
