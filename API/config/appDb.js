'use strict';

//set NODE_ENV=production
if (process.env.NODE_ENV === "prod") {
     
     var dbinfo = {
        'url': 'instacraftdb.c7mkioq7chm7.us-west-2.rds.amazonaws.com',
        'port': '3306',
        'username': 'instacraftdb',
        'password': 'Hd5Kgj2wfS3',
        'database': 'instacraft',
    }
} else if (process.env.NODE_ENV === "uts") {
    console.log("######1");
    var dbinfo = {
        'url': 'instacraftdb.c7mkioq7chm7.us-west-2.rds.amazonaws.com',
        'port': '3306',
        'username': 'instacraftdb',
        'password': 'Hd5Kgj2wfS3',
        'database': 'instacraft',
    }

} else {
    console.log("######2");
    var dbinfo = {
        'url': 'instacraftdb.c7mkioq7chm7.us-west-2.rds.amazonaws.com',
        'port': '3306',
        'username': 'instacraftdb',
        'password': 'Hd5Kgj2wfS3',
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
