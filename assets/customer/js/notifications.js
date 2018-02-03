const Enviromnment = "development"

var OneSignal = window.OneSignal || []
var OneSignalAppID = "83985ef4-4787-4e6e-b260-971d1e4c18a6"

if ( Enviromnment == "production" )
{
  OneSignalAppID = "6e80fed6-fd71-48d2-add4-de8436eab710"
}

OneSignal.push(function() {
  OneSignal.init({
    appId: OneSignalAppID,
    autoRegister: false,
    notifyButton: {
      enable: true,
    },
    welcomeNotification: {
      "title": "InstaCraft Notifications",
      "message": "Welcome to our website.",
    }
  })
})