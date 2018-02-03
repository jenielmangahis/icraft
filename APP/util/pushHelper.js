var config          =   require('../config/config.js');
var apn             =   require("apn")
var FCM             =   require('fcm-node');
var async           = require("async");

// var serverKey = ;
var fcm = new FCM(config.androidKey);

    // Set up apn with the APNs Auth Key
var apnProvider = new apn.Provider({  
    token: {
        key: config.key,      // Path to the key p8 file
        keyId: config.keyId,  // The Key ID of the p8 file (available at https://developer.apple.com/account/ios/certificate/key)
        teamId: config.teamId, // The Team ID of your Apple Developer Account (available at https://developer.apple.com/account/#/membership/)
    },
    production: false // Set to true if sending a notification to a production iOS app
});

// var deviceToken = '2DEC61A06D18809E939A69CDE16F8A018BB504A40B12278D7472FC6F80B5A6CC';

var note = new apn.Notification();
// var process = require('process'); 
// process.setMaxListeners(0);
module.exports  =   {
    sendPushToAll: function(userId,message,push_type,notificationTypeId,notificationType){
        // if(notificationType!=0){
            userTbl.getAllUserId(userId,0,function(err,resp){
                if(err)
                console.log(err)
                else{
                    resp.forEach(function(element) {
                        var reqObj  =   {
                            deviceToken          :      element.deviceToken,
                            messagePush          :      message,
                            push_type            :      push_type,
                            count                :      element.batch_count+1,
                            notificationType     :      notificationType,
                            notificationTypeId   :      notificationTypeId,
                            userId               :      element.userId  
                        }
                        userTbl.addNotification(reqObj);
                        
                    }, this);  
                } 
            })
        // }       
        
        userTbl.getAllDeviceToken('1',function(err,resp){
            if(err)
            console.log(err)
            else{
                // console.log(resp)
                // Max devices per request    
                var batchLimit = 1000;

                // Batches will be added to this array
                var tokenBatches = [];

                // Traverse tokens and split them up into batches of 1,000 devices each  
                for (var start = 0; start < resp.length; start += batchLimit) {
                    // Get next 1,000 tokens
                    var slicedTokens = resp.slice(start, start + batchLimit);

                    // Add to batches array
                    tokenBatches.push(slicedTokens);
                }

                if(start>=resp.length){
                    async.forEach(tokenBatches,function (batch) {
                        var reqObj1  =   {
                            deviceToken          :      batch,
                            messagePush          :      message,
                            push_type            :      push_type,
                            // count                :      element.batch_count+1,
                            notificationType     :      notificationType,
                            notificationTypeId   :      notificationTypeId,
                            // userId               :      element.userId  
                        }
                        // console.log(reqObj1)
                        sendIphonePush(reqObj1)
                    })
                }
            } 
        })  

        userTbl.getAllDeviceToken('2',function(err,resp1){
            if(err)
            console.log(err)
            else{
                // console.log(resp1)
                // Max devices per request    
                var batchLimit = 1000;

                // Batches will be added to this array
                var tokenBatches2 = [];

                // Traverse tokens and split them up into batches of 1,000 devices each  
                for (var start = 0; start < resp1.length; start += batchLimit) {
                    // Get next 1,000 tokens
                    var slicedTokens = resp1.slice(start, start + batchLimit);

                    // Add to batches array
                    tokenBatches2.push(slicedTokens);
                }

                if(start>=resp1.length){
                    async.forEach(tokenBatches2,function (batch) {
                        var reqObj2  =   {
                            deviceToken          :      batch,
                            messagePush          :      message,
                            push_type            :      push_type,
                            // count                :      element.batch_count+1,
                            notificationType     :      notificationType,
                            notificationTypeId   :      notificationTypeId,
                            // userId               :      element.userId  
                        }
                    
                        // console.log(reqObj2)
                        sendAndroidPush(reqObj2)
                    })
                }
            } 
        })       
    
    }
}

// function androidPush(deviceToken,message,push_type,count,date,notificationId){
function sendAndroidPush(reqObj){
    var deviceToken          =   reqObj.deviceToken;
    var messagePush          =   reqObj.messagePush;
    var push_type            =   reqObj.push_type;
    var count                =   0;
    var notificationType       =   reqObj.notificationType;
    var notificationTypeId   =   reqObj.notificationTypeId;

    var message = { //this may vary according to the message type (single recipient, multicast, topic, et cetera)
        // registration_ids: ['eSdtT6-qDJ0:APA91bElW0KzgbHTlPy-QXEjaipzKvhbxjdXlNZgV-6nI1FSMaI_jXAxYHtYx_suV7ZYgrh8JbzehXGlW20z10DALGWPoAC6uqPoSc0qZHuIqkg3-AcXJCOj2BmdCypTNLZL080FW4YN'], 
        registration_ids:deviceToken,
        collapse_key: '',
        data:{}
    };
    
    message.data.notification = {};
    message.data.notification.alert=messagePush;
    message.data.notification.pushType= parseInt(push_type);
    message.data.notification.badge=0;
    message.data.notification.notificationId=notificationType;
    message.data.notification.notificationTypeId=notificationTypeId;

    // console.log(message);

        fcm.send(message, function(err, response){
            if (err) {
                // console.log(err);
                return true;
            } else {
                // console.log(response);   
                return true;    
            }
        });
}    
   
// function iphonePush(deviceToken,message,push_type,count,date,notificationId){
function sendIphonePush(reqObj){
    
    var deviceToken             =   reqObj.deviceToken;
    var message                 =   reqObj.messagePush;
    var push_type               =   reqObj.push_type;
    var count                   =   0;
    var notificationType          =   reqObj.notificationType;
    var notificationTypeId      =   reqObj.notificationTypeId;

   
    
        note.topic = config.topic;
        note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now. 
        note.badge = 0;
        note.sound = "default";
        note.alert = message;   
        note.pushType = parseInt(push_type);
        // note.date = date;
        note.payload = {};
        note.aps = {};
        // notificationId=86;
        note.aps.notificationId=notificationType;
        note.aps.notificationTypeId=notificationTypeId;
    //    note.payload.alert = 'hey';
    //    note.payload.sound = 'default';
    //    note.payload.badge = '1';
    //    note.payload.pushType   = '1';
        note.aps.alert = message;
        note.aps.sound = 'default';
        note.aps.badge = parseInt(0);
        note.aps.pushType = parseInt(push_type);
        // note.aps.date = date;

        // console.log(note);
        // console.log('resultpush');
        var result;
        apnProvider.send(note, deviceToken).then((result) => {  
        // Check the result for any failed devices
        // console.log(result);
        if(result.failed.length >0){
            // console.log(result.failed);
            return true;
        }
        });
    // console.log(JSON.stringify(result));
        return true; 
}

