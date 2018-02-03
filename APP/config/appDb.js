'use strict';

//set NODE_ENV=production
if (process.env.NODE_ENV === "prod") {
//    console.log("prod")
    var dbinfo = {
        'url': '',
        'port': '',
        'username': '',
        'password': '',
        'database': '',
    }
} else if (process.env.NODE_ENV === "uts") {
//    console.log("UTS")
    var dbinfo = {
        'url': '203.123.36.134',
        'port': '3306',
        'username': 'root',
        'password': 'Ev@s!0n#zO16',
        'database': 'instacraft',
    }

} else {
//    console.log("Hi")
    var dbinfo = {
        'url': 'localhost',
        'port': '3306',
        'username': 'root',
        'password': 'Tech@123',
        'database': 'instacraft',
    }
}

//
// var dbinfo = {
//        'url': '127.0.0.1',
//        'port': '3306',
//        'username': 'root',
//        'password': 'tech@head',
//        'database': 'food_ordering_app',
//    }

module.exports = dbinfo;
