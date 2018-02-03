var apn = require('apn');
var options = {
    token: {
        key: "ios2.p8",
        keyId: "M8T254B7J7",
        teamId: "HAUBT87TF7",
    },
    production: false,
};

module.exports = {
   newBookingRequest: function(deviceToken,pushType,rentalId,client) {
      var apnProvider = new apn.Provider(options);         
      var note = new apn.Notification();          
      note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now. 
      note.badge = 1;
      note.sound = "ping.aiff";
      note.alert = "You have a new booking request.";
//    note.pushType = pushType;
//    note.rentalId = rentalId;
      note.payload = {'pushType': pushType,'rentalId':rentalId};
      note.topic = "com.rydr.com";
      apnProvider.send(note, deviceToken).then(function(result) {
          // see documentation for an explanation of result 
          console.log(result);
          console.log(result.failed);
      });
   },   
   
   bookingRequestRejectedOwner: function(deviceToken,pushType,rentalId,client) {
      var apnProvider = new apn.Provider(options);         
      var note = new apn.Notification();          
      note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now. 
      note.badge = 1;
      note.sound = "ping.aiff";
      note.alert = "Your booking request have been rejected.";
      note.payload = {'pushType': pushType,'rentalId':rentalId};
      note.topic = "com.rydr.com";
      apnProvider.send(note, deviceToken).then(function(result) {
          // see documentation for an explanation of result 
          console.log(result);
          console.log(result.failed);
      });
   },
   
   bookingRequestAccepted: function(deviceToken,pushType,rentalId,client) {
      var apnProvider = new apn.Provider(options);         
      var note = new apn.Notification();          
      note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now. 
      note.badge = 1;
      note.sound = "ping.aiff";
      note.alert = "Your booking request have been accepted.";
      note.payload = {'pushType': pushType,'rentalId':rentalId};
      note.topic = "com.rydr.com";
      apnProvider.send(note, deviceToken).then(function(result) {
          // see documentation for an explanation of result 
          console.log(result);
          console.log(result.failed);
      });
   },
   
   carKeysHandovered: function(deviceToken,pushType,rentalId,client) {
      var apnProvider = new apn.Provider(options);         
      var note = new apn.Notification();          
      note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now. 
      note.badge = 1;
      note.sound = "ping.aiff";
      note.alert = "Car keys has been handovered.";
      note.payload = {'pushType': pushType,'rentalId':rentalId};
      note.topic = "com.rydr.com";
      apnProvider.send(note, deviceToken).then(function(result) {
          // see documentation for an explanation of result 
          console.log(result);
          console.log(result.failed);
      });
   },
   
   
   carKeysReturned: function(deviceToken,pushType,rentalId,client) {
      var apnProvider = new apn.Provider(options);         
      var note = new apn.Notification();          
      note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now. 
      note.badge = 1;
      note.sound = "ping.aiff";
      note.alert = "Car keys has been returned.";
      note.payload = {'pushType': pushType,'rentalId':rentalId};
      note.topic = "com.rydr.com";
      apnProvider.send(note, deviceToken).then(function(result) {
          // see documentation for an explanation of result 
          console.log(result);
          console.log(result.failed);
      });
   },
   
   
   bookingRequestRejectedRydr: function(deviceToken,pushType,rentalId,client) {
      var apnProvider = new apn.Provider(options);         
      var note = new apn.Notification();          
      note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now. 
      note.badge = 1;
      note.sound = "ping.aiff";
      note.alert = "Car keys has been returned.";
      note.payload = {'pushType': pushType,'rentalId':rentalId};
      note.topic = "com.rydr.com";
      apnProvider.send(note, deviceToken).then(function(result) {
          // see documentation for an explanation of result 
          console.log(result);
          console.log(result.failed);
      });
   },
   
   
   
   
}