;(function(window) {
    'use strict';

    var CONFIG = {
        debug: true,
        webrtc: {
            answerTimeInterval: 30,
            dialingTimeInterval: 5,
            disconnectTimeInterval: 35,
            statsReportTimeInterval: 5
        }
    };

    var CREDENTIALS = {
        'prod': {
            'appId': 40718,
            'authKey': 'AnB-JpA6r4y6RmS',
            'authSecret': '3O7Sr5Pg4Qjexwn'
        },
        'test': {
            'appId': 39854,
            'authKey': 'JtensAa9y4AM5Yk',
            'authSecret': 'AsDFwwwxpr3LN5w'
        }
    };

//    var QBApp = {
//    'appId': 62528,
//    'authKey': 'cjdsWfshQkx7rO-',
//    'authSecret': 'FNhwgCOfx6JsP7P'
//  };
//
//  var config = {
//    chatProtocol: {
//      active: 2
//    },
//    debug: {
//      mode: 1,
//      file: null
//    },
//    stickerpipe: {
//      elId: 'stickers_btn',
//
//      apiKey: '847b82c49db21ecec88c510e377b452c',
//
//      enableEmojiTab: false,
//      enableHistoryTab: true,
//      enableStoreTab: true,
//
//      userId: null,
//
//      priceB: '0.99 $',
//      priceC: '1.99 $'
//    }
//  };
// 
//var QBUser1 = {
//        id: 33209134,
//        name: 'ankit',
//        login: 'ankit',
//        pass: '12345678'
//    },
// QBUser2 = {
//        id: 33209134,
//        name: 'ankit',
//        login: 'ankit',
//        pass: '12345678'
//    },
// QBUser3 = {
//        id: 33209134,
//        name: 'ankit',
//        login: 'ankit',
//        pass: '12345678'
//    };
//
//QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret, config);
//console.log(QB);    
    

    var MESSAGES = {
        'login': 'Login as any user on this computer and another user on another computer.',
        'create_session': 'Creating a session...',
        'connect': 'Connecting...',
        'connect_error': 'Something went wrong with the connection. Check internet connection or user info and try again.',
        'login_as': 'Logged in as ',
        'title_login': 'Choose a user to login with:',
        'title_callee': 'Choose users to call:',
        'calling': 'Calling...',
        'webrtc_not_avaible': 'WebRTC is not available in your browser',
        'no_internet': 'Please check your Internet connection and try again'
    };

    window.CONFIG = {
        'CREDENTIALS': CREDENTIALS,
        'APP_CONFIG': CONFIG,
        'MESSAGES': MESSAGES
    };
}(window));
