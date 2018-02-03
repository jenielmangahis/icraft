'use strict';

// // =================================================================
// get the packages we need ========================================like
// =================================================================

var User = require('../user/auth'),
        jwt = require('jsonwebtoken'),
        Util = require('../../../util/custom_functions'),
        inspector = require('schema-inspector'),
        bcrypt = require('bcryptjs'),
        config = require('../../../config/config'), // get our config file
        success = false,
        status = 400,
        appVersion = '1.0.0',
        message = 'Something went wrong',
        data = {},
        /*
         * 
         * @type Module body-parser|Module body-parser
         * Parse incoming request bodies in a middleware before your handlers, available under the req.body property.
         */
        bodyParser = require('body-parser'),
        fs = require('fs'),
        //NPM = require('npm-helper'),

        /*
         * 
         * @type Module express-validator|Module express-validator
         * An express.js middleware for node-validator.
         */
        expressValidator = require('express-validator');
        

var fs = require("fs");
var md5 = require("md5");
var moment = require("moment");
var emailjs = require("emailjs");
var each = require('sync-each');
var waterfall = require('async-waterfall');
var forEach = require('async-foreach').forEach;
var parallel = require('run-parallel');
var twilio = require('twilio');
        var accountSid = 'AC1f44b1d4dd2669c75a3abeb3e74ef15b'; // Your Account SID from www.twilio.com/console
        var authToken = 'fc649f5575e5f14f1b57cc517796c753';   // Your Auth Token from www.twilio.com/console
        // var accountSidCall = 'AC4dbee511093e5f70e5a0948f815a5c21'; // Your Account SID from www.twilio.com/console
        //var authTokenCall = '7359a0060b273f81d5a77dcf6a0ee28d';   // Your Auth Token from www.twilio.com/console
         
         var clientTwilio = new twilio(accountSid, authToken);



//taking a instance of Util class
Util = new Util();

//tracer
var logger = require('tracer').colorConsole({
    format: [
        '{{timestamp}} (in line: {{line}}) >> {{message}}', //default format
        {
            error: '{{timestamp}} <{{title}}> {{message}} (in {{file}}:{{line}})\nCall Stack:\n{{stack}}' // error format
        }
    ],
    dateformat: 'HH:MM:ss.L',
    preprocess: function (data) {
        data.title = data.title.toUpperCase();
    }
});


//Send Mesage
function sendTwilioMessage(mobile, otp)
{ 
   return new Promise(function (resolve, reject)
   {

     clientTwilio.messages.create({
         body: 'Please use ' + otp + ' as a one time password to verify your mobile number.',
         to: mobile, // Text this number
         from: '+13103417226' // From a valid Twilio number
      },
         function (err, message)
         {
//            console.log(err);
            if (err)
            {
               reject(false);
            }
            else
            {
//               console.log(message);
//               console.log(message.sid);
               resolve(message.sid);
            }
         });
   });
}

function createOtp(length)
{
   //var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   var chars = '123456789';
   var result = '';
   for (var i = length;i > 0;--i)
   {
      result += chars[Math.floor(Math.random() * chars.length)];
   }
   return result;
}

// =================================================================
// Export API V1================================================
// =================================================================
module.exports = function (app, express, client) {
    var api = express.Router();
    app.use(expressValidator());
    app.use(bodyParser.json({
        limit: "50mb",
        type: 'application/json'
    }));
    app.use(bodyParser.urlencoded({
        extended: true,
        limit: '50mb'
    }));


    // ---------------------------------------------------------
    // route not need to check access token
    // ---------------------------------------------------------   

    api.get('/', function (req, res) {
        Util.makeResponse(res, true, 200, 'Welcome to the Instacraft API!', appVersion, [])
    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /check ************************************************************************/
    /**
     * @api {get} /check check
     * @apiDescription http://203.123.36.134:30020/apiuser/v1/check
     * @apiGroup Test
     * @apiName check
     * ***************************************************************************************************************************************************************
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/

    api.get('/check', function (req, res) {
        Util.makeResponse(res, true, 200, 'Welcome to the coolest API of Promo app!', appVersion, []);
    });



    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i)
            result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }






    /***************************************************************************************************************************************************************/
    /************************************************************************ /register ************************************************************************/
    /**
     * @api {post} /register register
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30020/api/v1/register/
     * @apiGroup user
     * @apiName register
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      email                       Email string
     * @apiParam (Expected parameters) {String}      password                    password string
     * @apiParam (Expected parameters) {String}      device_token                device token string
     * @apiParam (Expected parameters) {String}      device_type                 device type 0=android,1=IOs it would be also a string
     * @apiParam (Expected parameters) {String}      phone_number                 phone_number string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     {
     "success": true,
     "status": 200,
     "message": "Sign Up Successfully",
     "api_version": "1.0.0",
     "data": {
     "user_id": 9,
     "email": "ankit.chavhan@techaheadcorp.com",
     "expiresIn": 86400
     }
     } 
     
     * @apiVersion 1.0.0
     **/
    api.post('/register', function (req, res) {
        var schema = {
            'email': {
                notEmpty: true,
                isEmail: {
                    errorMessage: 'Invalid Email format'
                }
            },
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            var data = req.body;
//            var registration_type = data.registration_type;
            var email = data.email;
            var password = data.password;
            var device_token = data.device_token || "";
            var device_type = data.device_type || 1;
            var phone_number = data.phone_number || 1;
            //registration by email and password 
            //Util.sendMessage('+918750024108','google.com','123456'); return false;
                client.query("select * from users where email=?", [email], function (error, result) {
                    if (error) {
                        Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                    }
                    else if (email === "" || password === "") {
                        Util.makeResponse(res, false, 500, "Email or Password cannot be empty", appVersion, {});
                    } else if (result.length > 0) {
                        Util.makeResponse(res, false, 200, "Sorry,that email ID already exists. Please try with different email.", appVersion, {});
                    } else {
                        var token_keys = {
                            'email': email
                        }
                        var token = jwt.sign(token_keys, app.get('superSecret'), {
                            expiresIn: 86400 // expires in 24 hours
                        });

                        //var rand = require('random-seed').create();
                        var otp = createOtp(4);
//                        console.log(otp);
                        var regFields = {
                            'email': data.email,
                            'password': (md5(data.password, 'hex')).toString(),
                            'device_token': data.device_token || "",
                            'device_type': data.device_type || 1,
                            'phone_number': data.phone_number,
                            'otp':otp
                        };
                        console.log(regFields)
                            client.query("INSERT INTO users SET ?", regFields, function (error1, result1) {
                                if (error1) {
                                    console.log(error1);
                                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                                } else {
                                    var response = {
                                        "user_id": result1.insertId,
                                        "token": token,
                                        "email": data.email,
                                        "expiresIn": 86400,
                                        "otp":otp
                                    };
                                    
                                    sendTwilioMessage('+91'+data.phone_number,otp).then(function(Twilioresult){
//                                        console.log(Twilioresult);
                                    });

                                    Util.makeResponse(res, true, 200, "Sign up successfuly", appVersion, response);

                                }

                            });

                    }    
                });
                        
                                         
    
        }, function (errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /login ************************************************************************/
    /**
     * @api {post} /login login
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30020/apiuser/v1/login/
     * @apiGroup user
     * @apiName login
     * ***************************************************************************************************************************************************************
     
     * @apiParam (Expected parameters) {String}      username     email/phone_number string
     * @apiParam (Expected parameters) {String}      password               password string
     * @apiParam (Expected parameters) {String}      device_token           device_token string
     * @apiParam (Expected parameters) {String}      device_type            device_type string
     * @apiParam (Expected parameters) {String}      login_time             login_time UTC Seconds
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result           
     {
     "success": true,
     "status": 200,
     "message": "login successfuly",
     "api_version": "1.0.0",
     "data": {
     "user_id": 2,
     "full_name": "ram nivash",
     "device_token": "43234dvdsv5654",
     "device_type": "1",
     "email": "ramnivash@techaheadcorp.com",
     "phone_number": "8750024109",
     "profile_pic": "",
     "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicmFtIiwiZW1haWwiOiJyYW1uaXZhc2hAdGVjaGFoZWFkY29ycC5jb20iLCJpYXQiOjE1MDUzMDYwMzYsImV4cCI6MTUwNTM5MjQzNn0.bATy62tPXrTyJu34IzkM93XYQmPev4fT6I9J05lJsfk",
     "expiresIn": 86400
     }
     }
     * @apiVersion 1.0.0
     **/

    api.post('/login', function (req, res) {
        var data = req.body;
        var schema = {
            'username': {
                notEmpty: true,
                errorMessage: 'Invalid Username' // Error message for the parameter 
            },
            'password': {
                notEmpty: true,
                errorMessage: 'Invalid Password' // Error message for the parameter 
            },
            'device_type': {
                notEmpty: true,
                errorMessage: 'Invalid Device Type' // Error message for the parameter 
            },
            'device_token': {
                notEmpty: true,
                errorMessage: 'Invalid Device Token' // Error message for the parameter 
            }


        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            var username = req.body.username;
            var password = (md5(req.body.password, 'hex')).toString();
            client.query("select * from users where email=? OR phone_number=?", [username, username], function (error, result, fields) {
                if (error) {
                    console.log(error)
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                } else if (req.body.email == '' || req.body.password == '') {
                    Util.makeResponse(res, false, 200, "Email or Password cannot be empty", appVersion, {});
                } else if (result.length == 0) {
                    Util.makeResponse(res, false, 200, " Email/Mobile does not exist", appVersion, {});
                } else if (result[0].is_deleted == '1') {
                    Util.makeResponse(res, false, 200, "Sorry, your Account is Deleted .", appVersion, {});
                } else if (result[0].is_blocked == '1') {
                    Util.makeResponse(res, false, 200, "Sorry, your Account is Blocked by admin .", appVersion, {});
                } else if (result[0].is_verified == '0') {
                    Util.makeResponse(res, false, 200, "Sorry, your otp is not verified .", appVersion, {user_id: result[0].id,is_verified:result[0].is_verified });
                } else {
                    client.query("select * from users where (email=? OR phone_number=?) AND password=? limit 1", [username, username, password], function (error2, result2, fields2) {
                        if (error2) {

                            Util.makeResponse(res, false, 500, "Something went wrongs", appVersion, {});

                        } else if (result2.length == 0) {
                            Util.makeResponse(res, false, 200, "Password is Incorrect", appVersion, {});

                        } else {
                            client.query('UPDATE users SET device_token = ?, device_type=? WHERE id = ? ', [req.body.device_token, req.body.device_type, result2[0].id], function (error3, result3) {

                                var curdate = moment(new Date()).format("YYYY-MM-DD HH:mm:ss");

                                var token_keys = {
                                    "name": Util.checknull(result2[0].first_name),
                                    "email": Util.checknull(result2[0].email)
                                }
                                var token = jwt.sign(token_keys, app.get('superSecret'), {
                                    expiresIn: 86400 // expires in 24 hours
                                });


                                var newData = {
                                    "user_id": Util.checknull(result2[0].id),
                                    "full_name": Util.checknull(result2[0].first_name) + ' ' + Util.checknull(result2[0].last_name),
                                    "device_token": Util.checknull(req.body.device_token),
                                    "device_type": Util.checknull(req.body.device_type),
                                    "email": Util.checknull(result2[0].email),
                                    "phone_number": Util.checknull(result2[0].phone_number),
                                    "refferal_code": Util.checknull(result2[0].refferal_code),
                                    "is_refferal_code_applied": result2[0].reffered_by > 0 ? 1 : 0,
                                    "profile_pic": Util.checknull(result2[0].profile_pic),
                                    "token": token,
                                    "expiresIn": 86400
                                };

                                Util.makeResponse(res, true, 200, "login successfuly", appVersion, newData);
                            });
                        }
                    });
                }
            });
        }, function (errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });
    
    /***************************************************************************************************************************************************************/
    /************************************************************************ /verifyOtp ************************************************************************/
    /**
     * @api {post} /verifyOtp verifyOtp
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30020/api/v1/verifyOtp/
     * @apiGroup user
     * @apiName verifyOtp
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id            user_id string
     * @apiParam (Expected parameters) {String}      otp                    otp string
     *
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     **/
    api.post('/verifyOtp', function (req, res) {
        var schema = {
            'otp': {
                notEmpty: true,
                otp: {
                    errorMessage: 'Please add Otp'
                }
            },
            'user_id': {
                notEmpty: true,
                user_id: {
                    errorMessage: 'Please add UserId'
                }
            },
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            var data = req.body;
            console.log(data)
//            var registration_type = data.registration_type;
            var otp = data.otp;
            var user_id = data.user_id;
            
            //registration by email and password 
            //Util.sendMessage('+918750024108','google.com','123456'); return false;
                client.query("select * from users where id=?", [user_id], function (error, result) {
                    if (error) {
                        Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                    }
                    else if (user_id === "" || otp === "") {
                        Util.makeResponse(res, true, 200, "User Id and Otp cannot be empty", appVersion, {});
                    } else {
                        console.log(otp);
                        console.log(result[0].otp);
                        console.log(result)
                        if(result[0].otp == otp){
                            client.query('UPDATE users SET is_verified = ? WHERE id = ? ', ["1",result[0].id], function (error3, result3) {
                                Util.makeResponse(res, true, 200, "Otp is verified", appVersion, {});
                            });
                        }else{
                            Util.makeResponse(res, false, 200, "Otp donot matches", appVersion, {});
 
                        }
                    }
                });
            });
    });






/***************************************************************************************************************************************************************/
    /************************************************************************ /verifyPhone ************************************************************************/
    /**
     * @api {post} /verifyPhone verifyPhone
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30020/api/v1/user/verifyPhone/
     * @apiGroup user
     * @apiName verifyPhone
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}    user_id            user_id string
     * @apiParam (Expected parameters) {String}    phone_number       phone_number string
  
     *
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     **/
    api.post('/verifyPhone', function (req, res) {
        var schema = {
            'user_id': {
                notEmpty: true,
                user_id: {
                    errorMessage: 'Please add user Id'
                }
            },
            'phone_number': {
                notEmpty: true,
                phone_number: {
                    errorMessage: 'Please add phone number'
                }
            },
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            var data = req.body;
            console.log(data);
            
            var user_id = data.user_id;
            var phone_number = data.phone_number;
            //registration by email and password 
            //Util.sendMessage('+918750024108','google.com','123456'); return false;
                client.query("select * from users where id=?", [user_id], function (error, result) {
                    if (error) {
                        Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                    }
                    else if (user_id === "" || phone_number === "") {
                        Util.makeResponse(res, true, 200, "User Id and phone number cannot be empty", appVersion, {});
                    } else {
                        console.log(phone_number);                        
                        client.query('UPDATE users SET phone_number = ? WHERE id = ?', [phone_number,result[0].id], function (error3, result3) {
                            sendTwilioMessage('+91'+phone_number,result[0].otp).then(function(Twilioresult){
//                            console.log(Twilioresult);
                            });
                            Util.makeResponse(res, true, 200, "Otp sent of your phone number", appVersion, {});
                        });
                        
                    }
                });
            });
    });




    /***************************************************************************************************************************************************************/
    /************************************************************************ /forgetPassword ************************************************************************/
    /**
     * @api {post} /forgetPassword forgetPassword
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription forgotPassword
     * @apiGroup user
     * @apiName forgotPassword
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      email              Email Id string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status            status code
     * @apiSuccess {String}                Message           response message string
     * @apiSuccess {String}                AppVersion        APP version
     * @apiSuccess {Object}                Result            result
     * ***************************************************************************************************************************************************************
     {
     "success": true,
     "status": 200,
     "message": "For furthur steps please check your email.",
     "api_version": "1.0.0",
     "data": {}
     }
     * @apiVersion 1.0.0
     **/

    api.post('/forgetPassword', function (req, res) {
        var data = req.body;
        var email = data.email;
        client.query("select * from users where email=?", [email], function (error, result, fields) {
            if (error)
            {
                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
            }
            else if (result.length == 0)
            {
                Util.makeResponse(res, false, 200, "Sorry, user is not found.", appVersion, {});
            }
            else
            {
                //send change password link to the registered email id
                var rand = require('random-seed').create();
                var token = md5(rand(9999)); // generate a random number between 0 - 9999 
                console.log("string== :" + token);
                //save token in database for respective driver
                client.query('UPDATE users SET token = ? where id = ?', [token, result[0].id], function (err2, result2) {
                    if (err2) {
                        Util.makeResponse(res, success, status, message, appVersion, data);
                    } else {
                        //send email
                        var activationUrl = req.protocol + '://' + req.get('host') + '/customerRecovery/?email=' + result[0].email + '&activkey=' + token;           //send mail
                        var from = "support@getinstacraft.com";
                        var res2 = Util.sendMailSMTP(email, 'You have requested the password recovery', 'You have requested the password recovery. To receive a new password, please click on the link <a href="' + activationUrl + '">Click Here</a>', from);
                        Util.makeResponse(res, true, 200, "For furthur steps please check your email.", appVersion, res2);

                    }
                });



            }
        });
    });


      // ---------------------------------------------------------
    // route middleware to authenticate and check token
    // ---------------------------------------------------------
    
     api.use(function (req, res, next) {
     // check header or url parameters or post parameters for token
     //console.log(req.param('x-driverapp-token'));
     var token = req.param('x-instacraft-token') || req.headers['x-instacraft-token'];
     // decode token
     if (token) {
     // verifies secret and checks expf.
     jwt.verify(token, app.get('superSecret'), function (err, decoded) {
     if (err) {
     console.log(err)
     Util.makeResponse(res, false, 401, 'Authentication failed. Invalid Token.', '1.0.0', [])
     } else {
     // if everything is good, save to request for use in other routes
     req.decoded = decoded;
     next();
     }
     });
     } else {
     Util.makeResponse(res, false, 403, 'No token provided.', '1.0.0', [])
     }
     });
     

    // ---------------------------------------------------------
    // authenticated routes
    // ---------------------------------------------------------


    /***************************************************************************************************************************************************************/
    /************************************ /getProfile ************************************************************************/
    /**
     * @api {get} /getProfile getProfile
     * @apiHeader {String} Content-Type application/json.
     * @apiHeader {String} x-instacraft-token Provided token.
     * @apiDescription http://203.123.36.134:30020/apiuser/v1/getProfile/
     * @apiGroup user
     * @apiName getProfile
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               user_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     {
     "success": true,
     "status": 200,
     "message": "Success",
     "api_version": "1.0.0",
     "data": {
     "first_name": "ram",
     "last_name": "nivash",
     "profile_pic": "",
     "gender": "1",
     "email": "ramnivash@techaheadcorp.com",
     "phone_number": "8750024109",
     "dob": "2016-04-04T18:30:00.000Z",
     "is_termcondition_accepted": "0",
     "is_medical_prescription": "0",
     "state": "",
     "city": "",
     "address": "",
     "street1": "",
     "street2": ""
     }
     }
     * @apiVersion 1.0.0
     **/

    api.get('/getProfile', function (req, res) {
        var userData = {};
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            //var userData=[];
            client.query("select first_name,last_name,profile_pic,gender,email,phone_number,dob,is_termcondition_accepted,is_medical_prescription,state,city,address,street1,street2 from users where id=?", [data.user_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, true, 200, "Success", appVersion, 'data is not available');
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Success", appVersion, result[0]);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });




    /***************************************************************************************************************************************************************/
    /************************************************************************ /updateProfile ************************************************************************/
    /**
     * @api {post} /updateProfile updateProfile
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiHeader {String} x-instacraft-token Provided token.

     * @apiDescription updateProfile
     * @apiGroup user
     * @apiName updateProfile
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id                    User Id string
     * @apiParam (Expected parameters) {String}      first_name                 First Name string
     * @apiParam (Expected parameters) {String}      last_name                  Last Name string
     * @apiParam (Expected parameters) {String}      dob            date_of_birth(1987-09-24) string
     * @apiParam (Expected parameters) {Number}      gender                   0=nil 1=male 2=female 3=other
     
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     
     
     * * @apiVersion 1.0.0
     **/
    api.post('/updateProfile', function (req, res) {
        var schema = {
//            email: {
//                notEmpty: true,
//                errorMessage: 'email is Required' // Error message for the parameter 
//            },
//            phone_number: {
//                notEmpty: true,
//                errorMessage: 'phone is Required' // Error message for the parameter 
//            },
            first_name: {
                notEmpty: true,
                errorMessage: 'First Name is Required'
            },
            last_name: {
                notEmpty: true,
                errorMessage: 'Last Name is Required'
            },
            dob: {
                notEmpty: true,
                errorMessage: 'Date of birth is Required'
            },
            gender: {
                notEmpty: true,
                errorMessage: 'Gender is Required'
            }
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            //console.log(data); return false;
            client.query("select * from users where id=?", [data.user_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid user ID ", appVersion, []);
                }
                else
                {
                    var regFields = {
                        'id': data.user_id,
                        //'email': data.email,
                        'first_name': data.first_name,
                        'last_name': data.last_name,
                        'gender': data.gender,
                        'dob': data.dob
                        //'phone_number':data.phone_number
                        
                    };
                   console.log(regFields);
                    client.query("UPDATE users SET ? WHERE id = ?", [regFields, data.user_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else
                        {
                            Util.makeResponse(res, true, 200, "Profile updated successfully", appVersion, req.body);
                        }
                    });
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });


  


    /***************************************************************************************************************************************************************/
    /************************************************************************ /changePassword ************************************************************************/
    /**
     * @api {post} /changePassword changePassword
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiHeader {String} x-instacraft-token Provided token.

     * @apiDescription http://203.123.36.134:30020/apiuser/v1/changePassword/
     * @apiGroup user
     * @apiName changePassword
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      current_password     password string
     * @apiParam (Expected parameters) {String}      new_password         new password string
     * @apiParam (Expected parameters) {String}      user_id              user_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     {
     "success": true,
     "status": 200,
     "message": "Password Updated Successfully",
     "api_version": "1.0.0",
     "data": {
     "driver_id": 1,
     "expiresIn": 86400
     }
     }
     * @apiVersion 1.0.0
     **/

    api.post('/changePassword', function (req, res) {
        var schema = {
            'current_password': {
                notEmpty: true,
                errorMessage: 'please enter current password' // Error message for the parameter 
            },
            'new_password': {
                notEmpty: true,
                errorMessage: 'please enter new password' // Error message for the parameter 
            },
            'user_id': {
                notEmpty: true,
                errorMessage: 'please enter userId' // Error message for the parameter 
            }
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            //for checking password
            var data = req.body;
            client.query("select * from users where id=? ", [data.user_id], function (error, result) {
                if (error) {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});

                } else {
                    var token_keys = {
                        'id': data.user_id,
                    }
                    var token = jwt.sign(token_keys, app.get('superSecret'), {
                        expiresIn: 86400 // expires in 24 hours
                    });
                    if (result[0].password == md5(data.current_password)) {
                        client.query('UPDATE users SET password = ? WHERE id = ? ', [(md5(data.new_password, 'hex')).toString(), result[0].id], function (error1, result1) {
                            if (error1) {
                                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                            } else {
                                var response = {
                                    "id": result[0].id,
                                    "expiresIn": 86400
                                };
                                Util.makeResponse(res, true, 200, "Password  Updated  Successfully", appVersion, response);
                            }
                        });

                    } else {
                        Util.makeResponse(res, false, 200, "Old password does not match ", appVersion, {});
                    }
                }
            });

        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });






    /***************************************************************************************************************************************************************/
    /************************************************************************ /uploadPrescription ************************************************************************/
    /**
     * @api {post} /uploadPrescription uploadPrescription
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiHeader {String} x-instacraft-token Provided token.
     * @apiDescription uploadPrescription
     * @apiGroup user
     * @apiName uploadPrescription
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               User Id string
     * @apiParam (Expected parameters) {String}      prescription_image_front    Prescription Image string
     * @apiParam (Expected parameters) {String}      prescription_image_back     Prescription Image string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status            status code
     * @apiSuccess {String}                Message           response message string
     * @apiSuccess {String}                AppVersion        APP version
     * @apiSuccess {Object}                Result            result
     * ***************************************************************************************************************************************************************
     {
     "success": true,
     "status": 200,
     "message": "Your Prescription is uploaded Successfully.",
     "api_version": "1.0.0",
     "data": {}
     }
     * @apiVersion 1.0.0
     **/

    api.post('/uploadPrescription', function (req, res) {
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            prescription_image_front: {
                notEmpty: true,
                errorMessage: 'Prescription front image is required'
            },
            prescription_image_back: {
                notEmpty: true,
                errorMessage: 'Prescription back image is required'
            }
        };
        var data = req.body;
        
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select * from users where id=?", [data.user_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 404, "Sorry, user is not found.", appVersion, {});
                }
                else
                {
                    client.query('INSERT INTO prescriptions SET prescription_front_image=?,prescription_back_image=?,user_id =?,uploaded_by=?', [data.prescription_image_front, data.prescription_image_back, data.user_id, '1'], function (err2, result2) {
                        if (err2) {                                
                            Util.makeResponse(res, success, status, message, appVersion, data);
                        } else {
                            Util.makeResponse(res, true, 200, "Your Prescription is uploaded Successfully.", appVersion, {});
                        }
                    });
                }
            });
        },
                function (errors) {
                    Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
                });

    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /dashboard ************************************************************************/
    /**
     * @api {post} /dashboard dashboard
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiHeader {String} x-instacraft-token Provided token.
     * @apiDescription home
     * @apiGroup dashboard
     * @apiName dashboard
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               User Id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status            status code
     * @apiSuccess {String}                Message           response message string
     * @apiSuccess {String}                AppVersion        APP version
     * @apiSuccess {Object}                Result            result
     * ***************************************************************************************************************************************************************
     {
     "success": true,
     "status": 200,
     "message": "Your dashboard listing.",
     "api_version": "1.0.0",
     "data": {}
     }
     * @apiVersion 1.0.0
     **/

    api.post('/dashboard', function (req, res) {
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }
        };
        var data = req.body;
        req.checkBody(schema);
        console.log(data)
        req.asyncValidationErrors().then(function () {
            client.query("select * from users where id=?", [data.user_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 404, "Sorry, user is not found.", appVersion, {});
                }
                else
                {
//                    client.query('select a.prescription_front_image,a.prescription_back_image,a.expire_date as prescExpiry,a.is_approved as prescApproved, b.proof_front_image,b.proof_back_image, b.expire_date as proofExpiry,b.is_approved as proofApproved from prescriptions as a LEFT JOIN proof b ON a.user_id = b.user_id where a.user_id=?', [data.user_id], function (err2, result2) {
//                        if (err2) {  
//                             console.log(err2)
//                            Util.makeResponse(res, success, status, message, appVersion, data);
//                        } else {
//                            Util.makeResponse(res, true, 200, "Your dashboard listing", appVersion, result2);
//                        }
//                    });
                    parallel([
                                function (callback) {
                                    client.query("select prescription_front_image,prescription_back_image,expire_date,is_approved from prescriptions where user_id=?", [data.user_id], function (error, prescriptionList) {
                                        if (error)
                                        {
                                            Util.makeResponse(res, false, 500, "Something went wrong", '1.0.0', []);
                                        } else
                                        {
                                            callback(null, prescriptionList[0]);

                                        }
                                    });
                                },
                                function (callback) {

                                    client.query("select proof_front_image,proof_back_image, expire_date,is_approved from proof where user_id=?", [data.user_id], function (error, proofList) {
                                        if (error) {
                                            console.log(error)

                                            Util.makeResponse(res, false, 500, "Something went wrong", '1.0.0', {});
                                        } else
                                        {
                                            
                                                callback(null, proofList);
                                            
                                        }
                                    });
                                }
                            ],
                            function (err, results) {
                                var response = {
                                    "prescriptionList": results[0],
                                    "proofList": results[1]
                                }
                                Util.makeResponse(res, true, 200, "Post list found", '1.0.0', response);
                            }
                    )
                }
            });
        },
                function (errors) {
                    Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
                });

    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /uploadIdentityProof ************************************************************************/
    /**
     * @api {post} /uploadIdentityProof uploadIdentityProof
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiHeader {String} x-instacraft-token Provided token.
     * @apiDescription uploadIdentityProof
     * @apiGroup dashboard
     * @apiName uploadIdentityProof
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               User Id string
     * @apiParam (Expected parameters) {String}      prescription_image_front    Proof Image string
     * @apiParam (Expected parameters) {String}      prescription_image_back     Proof Image string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status            status code
     * @apiSuccess {String}                Message           response message string
     * @apiSuccess {String}                AppVersion        APP version
     * @apiSuccess {Object}                Result            result
     * ***************************************************************************************************************************************************************
     {
     "success": true,
     "status": 200,
     "message": "Your Proof is uploaded Successfully.",
     "api_version": "1.0.0",
     "data": {}
     }
     * @apiVersion 1.0.0
     **/

    api.post('/uploadIdentityProof', function (req, res) {
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            proof_image_front: {
                notEmpty: true,
                errorMessage: 'Proof front image is required'
            },
            proof_image_back: {
                notEmpty: true,
                errorMessage: 'Proof back image is required'
            }
        };
        var data = req.body;
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select * from users where id=?", [data.user_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 404, "Sorry, user is not found.", appVersion, {});
                }
                else
                {
                    client.query('INSERT INTO proof SET proof_front_image=?,proof_back_image=?,user_id =?,uploaded_by=?', [data.proof_image_front, data.proof_image_back, data.user_id, '1'], function (err2, result2) {
                        if (err2) {
                            Util.makeResponse(res, success, status, message, appVersion, data);
                        } else {
                            Util.makeResponse(res, true, 200, "Your Proof is uploaded Successfully.", appVersion, {});
                        }
                    });
                }
            });
        },
                function (errors) {
                    Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
                });

    });



    /***************************************************************************************************************************************************************/
    /************************************ /getPrescriptionList ************************************************************************/
    /**
     * @api {get} /getPrescriptionList getPrescriptionList
     * @apiHeader {String} Content-Type application/json.
     * @apiHeader {String} x-instacraft-token Provided token.
     * @apiDescription http://203.123.36.134:30020/apiuser/v1/getPrescriptionList/
     * @apiGroup dashboard
     * @apiName getPrescriptionList
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               user_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     
     * @apiVersion 1.0.0
     **/

    api.get('/getPrescriptionList', function (req, res) {
        var userData = {};
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            var userData = [];
            //prescriptions uploaded by user at a time of item order       
            client.query("select * from prescriptions where user_id=? and appointment_id=0", [data.user_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else
                {
                    //userData=result;    
                    each(result, function (item, next) {
                        var totalitem = {
                            "doctor_name": "",
                            "qualification": "",
                            "expiration_date": item.expire_date,
                            "prescription_date": "",
                            "prescription_front_image": item.prescription_front_image,
                            "prescription_back_image": item.prescription_back_image,
                        };
                        totalitem.consultation_condition = [];
                        userData.push(totalitem);
                        //console.log(userData); 
                        next("", item);
                    }, function (err, transformedItems) {
                        if (err)
                            throw err;
                        //Util.makeResponse(res, true, 200, "Success",appVersion, userData); 
                    });

                    //prescriptions uploaded by doctor         
                    client.query("select prescriptions.*,users.first_name,professional.specialization from prescriptions left join users on prescriptions.doctor_id=users.id left join doctor_professional_information as professional on professional.doctor_id=prescriptions.doctor_id where user_id=? and appointment_id>0", [data.user_id], function (err, presresult) {

                        each(presresult, function (items, next) {
                            // console.log(items.appointment_id);return false;
                            getUserConsultationType(client, items.appointment_id).then(function (consultation) {
                                //console.log(consultation);return false;
                                var totalitems = {
                                    doctor_name: items.first_name,
                                    qualification: items.specialization,
                                    expiration_date: items.expire_date,
                                    prescription_date: "",
                                    //consultation_condition:consultation_condition1,
                                    "prescription_front_image": items.prescription_front_image,
                                    "prescription_back_image": items.prescription_back_image,
                                };

                                totalitems.consultation_condition = consultation;
                                //console.log(totalitems); return false;
                                //Util.makeResponse(res, true, 200, "Success",appVersion, totalitems); 
                                userData.push(totalitems);
                            });



                            //console.log(userData); 
                            next("", items);
                        }, function (err, transformedItems) {
                            if (err)
                                throw err;
                            Util.makeResponse(res, true, 200, "Success", appVersion, userData);
                        });



                    });

                }

                // console.log(userData); return false;  

            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });




    /***************************************************************************************************************************************************************/
    /************************************ /getNotification **************************************************************/
    /**
     * @api {get} /getNotification getNotification
     * @apiHeader {String} Content-Type application/json.
     * @apiHeader {String} x-instacraft-token Provided token.
     * @apiDescription http://203.123.36.134:30020/apiuser/v1/getNotification/
     * @apiGroup Notification
     * @apiName getNotification
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               user_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     
     * @apiVersion 1.0.0
     **/

    api.get('/getNotification', function (req, res) {
        var userData = {};
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            //var userData=[];
            client.query("select id,user_id,push_type,title,message,created_at from notification where user_id=? and is_deleted=?", [data.user_id,'1'], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, true, 200, "Success", appVersion, 'No notifications found');
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Success", appVersion, result);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });



     /***************************************************************************************************************************************************************/
    /************************************************************************ /deleteNotification ************************************************************************/
    /**
     * @api {post} /deleteNotification deleteNotification
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiHeader {String} x-instacraft-token Provided token.
     * @apiDescription http://203.123.36.134:30020/apiuser/v1/deleteNotification/
     * @apiGroup Notification
     * @apiName deleteNotification
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id                    User Id string
     * @apiParam (Expected parameters) {String}      id                         Notification Id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     {
    "success": true,
    "status": 200,
    "message": "Deleted successfully",
    "api_version": "1.0.0",
    "data": {
    "user_id": "2",
    "id": "1"
    }
    }
     * * @apiVersion 1.0.0
     **/
    api.post('/deleteNotification', function (req, res) {
        var schema = {
            user_id: {
                notEmpty: true,
                errorMessage: 'user ID is Required' // Error message for the parameter 
            },
            id: {
                notEmpty: true,
                errorMessage: 'Notification ID is Required' // Error message for the parameter 
            }  
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            //console.log(data); return false;
            client.query("select * from users where id=?", [data.user_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid user ID ", appVersion, []);
                }
                else
                {
                    var regFields = {
                        'is_deleted':'1',
                    };
                    //console.log(regFields);
                    client.query("UPDATE notification SET ? WHERE user_id = ? and id=?", [regFields, data.user_id,data.id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else
                        {
                            Util.makeResponse(res, true, 200, "Deleted successfully", appVersion, req.body);
                        }
                    });
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });





    /***************************************************************************************************************************************************************/
    /************************************************************************ /logout ************************************************************************/
    /**
     * @api {post} /logout logout
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiHeader {String} x-instacraft-token Provided token.
     * @apiDescription Logout
     * @apiGroup user
     * @apiName logout
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id             User id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     {
     "success": true,
     "status": 200,
     "message": "Logout successfully",
     "api_version": "1.0.0",
     "data": {}
     }
     * @apiVersion 1.0.0
     **/

    api.post('/logout', function (req, res) {
        var data = req.body;
        client.query("select * from users where id=" + data.user_id + "", function (error, result) {
            if (error)
            {
                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
            }
            else if (result.length == 0) {
                Util.makeResponse(res, false, 500, "user is not exist", appVersion, {});
            }
            else
            {
                client.query('UPDATE users SET device_token = ? WHERE id = ? ', ['', data.user_id], function (error1, result1) {
                    if (error1)
                    {
                        console.log(error1);
                        Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                    }
                    else
                    {
                        Util.makeResponse(res, true, 200, "Logged out successfully", appVersion, {});
                    }
                });

            }
        });
    });



    return api;
};









