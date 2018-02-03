var QBApp = {
  appId: 50196,
  authKey: 'hMOEHajqT7GqY9K',
  authSecret: 'S7nLJaCDDhheKeC'
};

var config = {
  chatProtocol: {
    active: 2
  },
  debug: {
    mode: 1,
    file: null
  },
  stickerpipe: {
    elId: 'stickers_btn',

    apiKey: '847b82c49db21ecec88c510e377b452c',

    enableEmojiTab: false,
    enableHistoryTab: true,
    enableStoreTab: true,

    userId: null,

    priceB: '0.99 $',
    priceC: '1.99 $'
  }
};
 
var QBUser1 = {
        id: 20986426,
        name: 'Bigdeals',
        login: 'Support',
        pass: '12345678'
    }, 
    QBUser2 = {
        id: 19402138,
        name: 'Test First',
        login: 'test',
        pass: '12345678'
    },
    QBUser3 = {
        id: 19402138,
        name: 'Test Second',
        login: 'test2',
        pass: '12345678'
    };

QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret, config);
console.log(QB);
