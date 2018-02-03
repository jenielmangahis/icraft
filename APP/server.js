'use strict';
// get the packages we need 
var fs = require('fs'), // use to handle file I/O opreations 
    express = require('express'), //use to define framework 
    app = express(), //taking express object for whole project
    bodyParser = require('body-parser'), //it is use to handle post reuqests
    morgan = require('morgan'), //use morgan to for development env
    md5 = require("crypto-js/md5"), //use to encryt-decrypt
    mysql = require('mysql'), //used to manage mysql 
    jwt = require('jsonwebtoken'), // use to create, sign, and verify tokens
    config = require('./config/config'), // get our config file
    Util = require('./util/custom_functions'), // used custom function 
    path = require('path');
    
    
var db_client = mysql.createPool({
    connectionLimit: 40,
    host: config.DB.url,
    user: config.DB.username,
    password: config.DB.password,
    database: config.DB.database,
});

//this is used to make your files static inside the public directory
app.use(express.static('./public'))
app.set('superSecret',config.CONSTANTS.secret); // secret variable


/* Webservices route start */

//for home
app.get('/', function(req, res) {
    res.send('<center><h2><b>Hi, This is Instacraft Server.<br><i> How can I help you ;)</i></b></h2></center>');
});

// for api docs documentation for driver
//app.get('/doc',function(req,res){
//    res.sendFile('./public/doc/index.html');
//})


// for api docs documentation for User
app.get('/userdoc',function(req,res){
    res.sendFile('./public/userdoc/index.html');
})



// define api for version v1 api routes and require routes based file for driver
//var api = require('./routes/v1/driver/index')(app, express, db_client);
////adding middleware for api v1
//app.use('/api/v1',api);


// define api for version v1 api routes and require routes based file for user
var apiuser = require('./routes/v1/user/index')(app, express, db_client);
//adding middleware for api v1
app.use('/apiuser/v1',apiuser);


console.log(config.CONSTANTS.PORT);
// starting server at define port
app.listen(config.CONSTANTS.PORT);
console.log('Node JS Server running on http://34.214.5.64:' + config.CONSTANTS.PORT);



  app.get('/recovery', function (req, res) {
      app.set('views', __dirname + '/public/views');
      app.set('view engine', 'ejs');
      var data = req.query;
      if(data.email !="" && data.activkey !="")
      {
         db_client.query("select * from driver where email=?", [data.email], function (error, result, fields) {
            if (error)
            {
               var msg = "Something went wrong.";
               res.render('./email', {data: msg});               
            } 
            else if(result[0].token != data.activkey)
            {
               var msg = "Sorry, incorrect activation URL.";
               res.render('./email', {data: msg});
            }
            else
            {
               res.render('./recovery', {data: result[0].driver_id});
            }            
         });
      }
      else
      {
         var msg = "Sorry, incorrect activation URL.";
         res.render('./email', {data: msg});
      }      
   });
   
   app.post('/resetPassword', function (req, res) {
      app.set('views', __dirname + '/public/views');
      app.set('view engine', 'ejs');
      var data = req.body;
      //console.log(md5(data.password,'hex'));
      db_client.query('UPDATE driver SET password = ? WHERE driver_id = ? ', [(md5(data.password,'hex')).toString(), data.user_id], function (error2, result2) {
         if(error2)
         {
            console.log(error2);
            var msg = "Something went wrong.";
         } 
         else
         {
            var msg = "Congratulations, your passoword has been chnaged successfully.";
         }
         res.render('./email', {data: msg});
      });
   });


 app.get('/customerRecovery', function (req, res) {
      app.set('views', __dirname + '/public/views');
      app.set('view engine', 'ejs');
      var data = req.query;
      if(data.email !="" && data.activkey !="")
      {
         db_client.query("select * from users where email=?", [data.email], function (error, result, fields) {
            if (error)
            {
               var msg = "Something went wrong.";
               res.render('./customerEmail', {data: msg});               
            } 
            else if(result[0].token != data.activkey)
            {
               var msg = "Sorry, incorrect activation URL.";
               res.render('./customerEmail', {data: msg});
            }
            else
            {
               res.render('./customerRecovery', {data: result[0].id});
            }            
         });
      }
      else
      {
         var msg = "Sorry, incorrect activation URL.";
         res.render('./customerEmail', {data: msg});
      }      
   });
   
      app.post('/customerResetPassword', function (req, res) {
      app.set('views', __dirname + '/public/views');
      app.set('view engine', 'ejs');
      var data = req.body;
      //console.log(md5(data.password,'hex'));
      db_client.query('UPDATE users SET password = ? WHERE id = ? ', [(md5(data.password,'hex')).toString(), data.user_id], function (error2, result2) {
         if(error2)
         {
            console.log(error2);
            var msg = "Something went wrong.";
         } 
         else
         {
            var msg = "Congratulations, your passoword has been chnaged successfully.";
         }
         res.render('./customerEmail', {data: msg});
      });
   });
