
//iniatiate a Object
function custom_func() {

}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ randomString - START  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

custom_func.prototype.randomString = function() {
        var text = "";
        //var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 9; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ randomString - END  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/




/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ makeResponse - START  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
custom_func.prototype.makeResponse = function(res, success, status, message, appVersion, result) {
    // response

//    res.set('Access-Control-Allow-Origin', '*');
//    res.statusCode = status;
//    res.statusMessage = message;
//    res.status(status).send({ "Success": successStatus, "Status": status, "Message": message, "AppVersion": appVersion, "Result": result });
    res.set('Access-Control-Allow-Origin', '*');
    res.status(status).json({ 
        success: success,
        status: status, 
        message: message,
        api_version : appVersion,
        data: result 
    });


}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ makeResponse - END  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ checkArray - START  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
custom_func.prototype.checkArrayResponse = function(arr) {
    var res = {
        status: (arr.length > 0) ? 200 : 200,
        message: (arr.length > 0) ? "Success" : "Data not found",
        result: arr
    }
    return res;

}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ customHeaders - START  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
custom_func.prototype.customHeaders = function(app, req, res, next) {
    // Switch off the default 'X-Powered-By: Express' header
    app.disable('x-powered-by');
    // OR set your own header here
    res.setHeader('X-driver-App-Version', 'v1.0.0');
    // .. other headers here
    next();
}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ customHeaders - END  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ checknull - START  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

custom_func.prototype.checknull = function(value) {
        return (value == null) ? "" : value
    }
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ checknull - END  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/




/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ convertToBool - START  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

custom_func.prototype.convertToBool = function(value) {
        return (value === 0 || value === '0' || value === "true" || value === true) ? 1 : 0
    }
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ checknull - END  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/



/* custom function to send Message 
 * twilio integration
 * */
custom_func.prototype.sendMessage = function(to_number,body){
    var config = require("../config/config");
    var accountSid = config.CONSTANTS.TWILIO_SID; // Your Account SID from www.twilio.com/console
    var authToken = config.CONSTANTS.TWILIO_TOKEN;  // Your Auth Token from www.twilio.com/console

    var twilio = require('twilio');
    var client = new twilio(accountSid, authToken);
//console.log(config.CONSTANTS.FROM);
    client.messages.create({
        from: config.CONSTANTS.FROM,
        //to:   '+919540227049',
        to:to_number,
        body:body
      }, function(err, message) {
            if(err) {
              console.error(err.message);
              return false;
            }else{
                //console.log(message);
                console.log("message sent successfully .........");
                return true;
            }
        });
        return true;
    }



/* custom function to send otp 
 * twilio integration
 * */
custom_func.prototype.sendCode = function(to_number,otp){
    var config = require("../config/config");
    var accountSid = config.CONSTANTS.TWILIO_SID; // Your Account SID from www.twilio.com/console
    var authToken = config.CONSTANTS.TWILIO_TOKEN;  // Your Auth Token from www.twilio.com/console

    var twilio = require('twilio');
    var client = new twilio(accountSid, authToken);

    client.messages.create({
        from: config.CONSTANTS.FROM,
        to:   '+91 99537 15253',
        body: "Your verification code is " + otp + ". Please enter this code to complete this step."
      }, function(err, message) {
            if(err) {
              console.error(err.message);
              return false;
            }else{
                console.log("message .........");
                return true;
            }
        });
        return true;
    }
    
    
    /*
     * 
     * generate random number
     */
    custom_func.prototype.generateRandomNumber = function(){
        
        var promise = require('promise');
        return new Promise(function(resolve, reject){
            
            var rand = require('random-seed').create();
            var token=rand(9999);
            resolve(token);
        });      
    }
    
    /*
     * send mail by smtp
     */
    
    custom_func.prototype.sendMailSMTP=function(to, subject, message,from){
    var config = require("../config/config");
    var user = config.CONSTANTS.SMTP_USER; 
    var password = config.CONSTANTS.SMTP_PASSWORD; 
    var host = config.CONSTANTS.SMTP_HOST; 
    var ssl = config.CONSTANTS.SMTP_SSL;  
    var emailjs = require("emailjs");
    var server = emailjs.server.connect({
    user: user,
    password: password,
    host: host,
    ssl: ssl
    });

    server.send({
      text: subject,
      from: from,
      to: to,
//      bcc: "ram <support@getinstacraft.com>",
      subject: subject,
      attachment:
              [
                  {data: message, alternative: true},
              ]
    }, function (err, message) {
      console.log(err || message);
    });

    } 
   
custom_func.prototype.sendPushNotifiction = function (data) {
    return new promise(function (resolve, reject) {
        if (data.deviceType == "1") {
            sendMessageIos(data);

        } else {
            sendAndroidPush(data);
        }
        resolve(true);
   
    });
};   
   
   
   
function sendAndroidPush(reqObj){
    var config = require("../config/config");
    var FCM = require('fcm-node');
    var fcm = new FCM(config.CONSTANTS.androidKey);
    
    var deviceToken          =   reqObj.deviceToken;
    var messagePush          =   reqObj.messagePush;
    var push_type            =   reqObj.push_type;
    var count                =   0;
    //var notificationType     = reqObj.notificationType;
    //var notificationTypeId   =   reqObj.notificationTypeId;

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
    //message.data.notification.notificationId=notificationType;
    //message.data.notification.notificationTypeId=notificationTypeId;
    // console.log(message);
        fcm.send(message, function(err, response){
            if (err) {
                 console.log(err);
                return true;
            } else {
                // console.log(response);   
                return true;    
            }
        });
} 



function sendMessageIos(reqObj) {
    
    var deviceToken          =   reqObj.deviceToken;
    var pushMessage          =   reqObj.messagePush;
    var pushType            =   reqObj.push_type;
    var count                =   0;
    
    var apnProvider = new apn.Provider(apnOptions);

    var note = new apn.Notification();
    note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now. 
    note.badge = count;
    note.sound = "ping.aiff";
    note.alert = pushMessage;
    note.payload = {'messageFrom': 'instacraft'};
    // Replace this with your app bundle ID:
    note.topic = "instacraft";
    apnProvider.send(note, deviceToken).then((result) => {
    console.log(result);
            return true;
    });
}





custom_func.prototype.diff_minutes=function(dt2, dt1)
 {

  var diff =(dt2.getTime() - dt1.getTime()) / 1000;
  diff /= 60;
  return Math.abs(Math.round(diff));
  
 }
    
    
    
    
    
    
module.exports = custom_func;