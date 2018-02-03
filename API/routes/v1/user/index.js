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
        expressValidator = require('express-validator'),
        twilio = require('twilio');

var fs = require("fs");
var md5 = require("md5");
var moment = require("moment");
var emailjs = require("emailjs");
var each = require('sync-each');
var waterfall = require('async-waterfall');
var forEach = require('async-foreach').forEach;



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
        Util.makeResponse(res, true, 200, 'Welcome11 to the coolest API on earth!', appVersion, [])
    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /check ************************************************************************/
    /**
     * @api {get} /check check
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/check
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
        Util.makeResponse(res, true, 200, 'Welcome to the coolest API of customer app!', appVersion, []);
    });



    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i)
            result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }




    /***************************************************************************************************************************************************************/
    /************************************************************************ /guestuserRegister ************************************************************************/
    /**
     * @api {post} /guestuserRegister guestuserRegister
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/guestuserRegister/
     * @apiGroup Customer
     * @apiName guestuserRegister
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      device_id          device id string
     * @apiParam (Expected parameters) {String}      device_type           device type string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     *@apiSuccess {Object}                Result  
     
     *************************************************************************************************************************************************************      
     {
     "success": true,
     "status": 200,
     "message": " Guest User Registered Successfully",
     "api_version": "1.0.0",
     "data": {
     "user_id": 10,
     "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkZXZpY2VfdG9rZW4iOiIzNDMyNDIzNDMyZ2ZkZ2RnZjFkZGQiLCJpYXQiOjE1MDUzMDIyODEsImV4cCI6MTUwNTM4ODY4MX0.3c1l9Gf3pD00gtiFZBRsQ_AITaqsvxtAgWHalmylEwA",
     "expiresIn": 86400
     }
     }
     
     * @apiVersion 1.0.0
     **/

//    api.post('/guestuserRegister', function (req, res) {
//        var data = req.body;
//        var schema = {
//            'device_id': {
//                notEmpty: true,
//                errorMessage: 'Invalid Device Id' // Error message for the parameter
//            }
//
//        };
//        req.checkBody(schema);
//
//        req.asyncValidationErrors().then(function () {
//            var device_token = req.body.device_token;
//            client.query("select id from users where device_id=?", [data.device_id], function (error, result) {
//                if (error) {
//                    Util.makeResponse(res, false, 500, "Something went wrong1", '1.0.0', []);
//
//                } else {
//                    // console.log(result);
//                    var token_keys = {
//                        device_id: data.device_id
//                    }
//                    var token = jwt.sign(token_keys, app.get('superSecret'), {
//                        expiresIn: 86400 // expires in 24 hours
//                    });
//                    if (result.length > 0)
//                    {
//                        var response = {
//                            "user_id": result[0].id,
//                            "expiresIn": 86400
//
//                        };
//
//                        Util.makeResponse(res, true, 200, " User already registered", '1.0.0', response);
//
//                    } else
//                    {
//                        //var random = require("random-js")(); // uses the nativeMath engine
//                        var rand = require('random-seed').create();
//                        var refferal_code = rand(999999);
//                        client.query("INSERT INTO users SET ?", {
//                            device_id: data.device_id,
//                            refferal_code: refferal_code
//                        }, function (error1, result1) {
//                            if (error1) {
//                                Util.makeResponse(res, false, 500, "Something went wrong", '1.0.0', {});
//                            } else {
//                                var response = {
//                                    "user_id": result1.insertId,
//                                    "refferal_code": result1.refferal_code,
//                                    "token": token,
//                                    "expiresIn": 86400
//                                };
//                                Util.makeResponse(res, true, 200, " Guest User Registered  Successfully", '1.0.0', response);
//                            }
//
//                        }
//                        );
//
//                    }
//                }
//            });
//
//
//
//        }, function (errors) {
//            //console.log(errors)
//            Util.makeResponse(res, false, 400, "Bad Request", '1.0.0', errors);
//        });
//    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /register ************************************************************************/
    /**
     * @api {post} /register register
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:10020/api/v1/register/
     * @apiGroup Customer
     * @apiName register
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      email                       Email string
     * @apiParam (Expected parameters) {String}      registration_type           Registration Type(1=>email,2=>facebook) string
     * @apiParam (Expected parameters) {String}      is_termcondition_accepted   is_termcondition_accepted (1=>accepted,0=>not accepted) string
     * @apiParam (Expected parameters) {String}      social_id                   social_id string
     * @apiParam (Expected parameters) {String}      refferal_code               refferal_code string
     * @apiParam (Expected parameters) {String}      password                    password string
     * @apiParam (Expected parameters) {String}      device_token                device token string
     * @apiParam (Expected parameters) {String}      device_type                 device type 0=android,1=IOs it would be also a string
     
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
     "email": "ramnsdsisvsdfgsdfasfgh@techaheadcorp.com",
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
            registration_type: {
                notEmpty: true,
                errorMessage: 'Invalid Registration Type' // Error message for the parameter 
            },
            is_termcondition_accepted: {
                notEmpty: true,
                errorMessage: 'Invalid Term & Condition' // Error message for the parameter 
            },
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            var data = req.body;
            var registration_type = data.registration_type;
            var email = data.email;
            var password = data.password;
            var refferal_code = data.refferal_code;
            var device_token = data.device_token || "";
            var device_type = data.device_type || 1;
            //registration by email and password 

            //Util.sendMessage('+918750024108','google.com','123456'); return false;
            if (registration_type == 1) {
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

                        var rand = require('random-seed').create();
                        var refferal_code = rand(999999);

                        var regFields = {
                            'email': data.email,
                            'password': (md5(data.password, 'hex')).toString(),
                            'registration_type': data.registration_type,
                            'refferal_code': refferal_code,
                            'device_token': data.device_token || "",
                            'device_type': data.device_type || 1,
                            'is_termcondition_accepted': '1'
                        };
                        //if refferal code is not blank
                        if (data.refferal_code != '') {
                            validateRefferalCode(client, data.refferal_code).then(function (status) {
                                if (status) {
                                    client.query("INSERT INTO users SET ?", regFields, function (error1, result1) {
                                        if (error1) {
                                            console.log(error1);
                                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                                        } else {
                                            var response = {
                                                "user_id": result1.insertId,
                                                "refferal_code": refferal_code,
                                                "is_refferal_code_applied": 1,
                                                "token": token,
                                                "email": data.email,
                                                "expiresIn": 86400
                                            };

                                            //point activity
                                            pointDetails(client, '3').then(function (db_point) {
                                                client.query("select id from users where refferal_code=?", [data.refferal_code], function (error, refresult) {
                                                    var reffered_by = refresult[0].id;

                                                    //update reffered_by in users table
                                                    client.query('UPDATE users SET reffered_by=? WHERE id = ?', [refresult[0].id, result1.insertId], function (error2, upresult2) {

                                                    });

                                                    //insert point on user_points table
                                                    client.query("select * from user_points where user_id=? order by id desc limit 1", [reffered_by], function (error, pointresult) {
                                                        if (pointresult.length > 0) {
                                                            //insert
                                                            var available_total_point = pointresult[0].total_point;
                                                            var point = db_point;
                                                            var total_point = available_total_point + point;
                                                            var user_id = reffered_by;
                                                            var point_source = '3';
                                                            var transaction_type = '1';
                                                            client.query("INSERT INTO user_points SET ?", {
                                                                user_id: user_id,
                                                                point_source: '3',
                                                                transaction_type: '1',
                                                                point: point,
                                                                total_point: total_point,
                                                            }, function (error1, insresult1) {
                                                                if (error1) {
                                                                    console.log('error in point tranaction');
                                                                } else {
                                                                    console.log('success full point transaction');
                                                                }

                                                            });

                                                        }
                                                        else {
                                                            //insert
                                                            var available_total_point = 0;
                                                            var point = db_point;
                                                            var total_point = available_total_point + point;
                                                            var user_id = reffered_by;
                                                            var point_source = '3';
                                                            var transaction_type = '1';

                                                            client.query("INSERT INTO user_points SET ?", {
                                                                user_id: user_id,
                                                                point_source: '3',
                                                                transaction_type: '1',
                                                                point: point,
                                                                total_point: total_point,
                                                            }, function (error1, insresult1) {
                                                                if (error1) {
                                                                    console.log('error in point tranaction');
                                                                } else {
                                                                    console.log('success full point transaction');
                                                                }

                                                            });

                                                        }

                                                    });

                                                });
                                                Util.makeResponse(res, true, 200, "Signed up successfully", appVersion, response);
                                            });
                                            //end promis

                                        }

                                    });
                                } else {
                                    Util.makeResponse(res, false, 500, "Your Refferal code is not correct", appVersion, []);
                                }

                            });
                        }
                        //if refferal code is blank
                        else {
                            client.query("INSERT INTO users SET ?", regFields, function (error1, result1) {
                                if (error1) {
                                    console.log(error1);
                                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                                } else {
                                    var response = {
                                        "user_id": result1.insertId,
                                        "refferal_code": refferal_code,
                                        "is_refferal_code_applied": 0,
                                        "token": token,
                                        "email": data.email,
                                        "expiresIn": 86400
                                    };

                                    Util.makeResponse(res, true, 200, "Signed up successfully", appVersion, response);
                                }
                            });

                        }



                    }
                });
            }

            //register with facebook
            else {
                client.query("select * from users where email=?", [email], function (error, result) {
                    if (error) {
                        Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                    }
                    else if (result.length > 0) {
                        Util.makeResponse(res, false, 200, "Sorry, that email ID already exists. Please try with different email.", appVersion, {});
                    } else {
                        var token_keys = {
                            'email': email
                        }
                        var token = jwt.sign(token_keys, app.get('superSecret'), {
                            expiresIn: 86400 // expires in 24 hours
                        });

                        var rand = require('random-seed').create();
                        var refferal_code = rand(999999);

                        var regFields = {
                            'email': email,
                            'registration_type': data.registration_type,
                            'facebook_social_id': data.social_id,
                            'refferal_code': refferal_code,
                            'device_token': device_token || "",
                            'device_type': device_type || 1,
                            'is_termcondition_accepted': '1'
                        };


                        //if refferal code is not blank
                        if (data.refferal_code != '') {
                            validateRefferalCode(client, data.refferal_code).then(function (status) {
                                if (status) {
                                    client.query("INSERT INTO users SET ?", regFields, function (error1, result1) {
                                        if (error1) {
                                            console.log(error1);
                                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                                        } else {
                                            var response = {
                                                "user_id": result1.insertId,
                                                "refferal_code": refferal_code,
                                                "is_refferal_code_applied": 1,
                                                "token": token,
                                                "email": data.email,
                                                "expiresIn": 86400
                                            };

                                            //point activity
                                            pointDetails(client, '3').then(function (db_point) {
                                                client.query("select id from users where refferal_code=?", [data.refferal_code], function (error, refresult) {
                                                    var reffered_by = refresult[0].id;

                                                    //update reffered_by in users table
                                                    client.query('UPDATE users SET reffered_by=? WHERE id = ?', [refresult[0].id, result1.insertId], function (error2, upresult2) {

                                                    });

                                                    //insert point on user_points table
                                                    client.query("select * from user_points where user_id=? order by id desc limit 1", [reffered_by], function (error, pointresult) {
                                                        if (pointresult.length > 0) {
                                                            //insert
                                                            var available_total_point = pointresult[0].total_point;
                                                            var point = db_point;
                                                            var total_point = available_total_point + point;
                                                            var user_id = reffered_by;
                                                            var point_source = '3';
                                                            var transaction_type = '1';
                                                            client.query("INSERT INTO user_points SET ?", {
                                                                user_id: user_id,
                                                                point_source: '3',
                                                                transaction_type: '1',
                                                                point: point,
                                                                total_point: total_point,
                                                            }, function (error1, insresult1) {
                                                                if (error1) {
                                                                    console.log('error in point tranaction');
                                                                } else {
                                                                    console.log('success full point transaction');
                                                                }

                                                            });

                                                        }
                                                        else {
                                                            //insert
                                                            var available_total_point = 0;
                                                            var point = db_point;
                                                            var total_point = available_total_point + point;
                                                            var user_id = reffered_by;
                                                            var point_source = '3';
                                                            var transaction_type = '1';

                                                            client.query("INSERT INTO user_points SET ?", {
                                                                user_id: user_id,
                                                                point_source: '3',
                                                                transaction_type: '1',
                                                                point: point,
                                                                total_point: total_point,
                                                            }, function (error1, insresult1) {
                                                                if (error1) {
                                                                    console.log('error in point tranaction');
                                                                } else {
                                                                    console.log('success full point transaction');
                                                                }

                                                            });

                                                        }

                                                    });

                                                });
                                                Util.makeResponse(res, true, 200, "Signed up successfully", appVersion, response);
                                            });
                                            //end promis

                                        }

                                    });
                                } else {
                                    Util.makeResponse(res, false, 500, "Your Refferal code is not correct", appVersion, []);
                                }

                            });
                        }
                        //if refferal code is blank
                        else {
                            client.query("INSERT INTO users SET ?", regFields, function (error1, result1) {
                                if (error1) {
                                    console.log(error1);
                                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                                } else {
                                    var response = {
                                        "user_id": result1.insertId,
                                        "refferal_code": refferal_code,
                                        "is_refferal_code_applied": 0,
                                        "token": token,
                                        "email": data.email,
                                        "expiresIn": 86400
                                    };

                                    Util.makeResponse(res, true, 200, "Signed up successfully", appVersion, response);
                                }
                            });

                        }



                    }
                });
            }



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
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/login/
     * @apiGroup Customer
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
    /************************************************************************ /loginWithSocial ************************************************************************/
    /**
     * @api {post} /loginWithSocial loginWithSocial
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/loginWithSocial/
     * @apiGroup Customer
     * @apiName loginWithSocial
     * ***************************************************************************************************************************************************************
     
     * @apiParam (Expected parameters) {String}      social_id              Social Id string
     * @apiParam (Expected parameters) {String}      social_type            Social Type(1=>facebook,2=>google) string
     * @apiParam (Expected parameters) {String}      device_token           device_token string
     * @apiParam (Expected parameters) {String}      device_type            device_type string
     * @apiParam (Expected parameters) {String}      login_time             login_time UTC Seconds
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             Result
     
     {
     "success": true,
     "status": 200,
     "message": "login successfuly",
     "api_version": "1.0.0",
     "data": {
     "user_id": 2,
     "full_name": " nivash",
     "device_token": "3432423432gfdgdgf",
     "device_type": "1",
     "email": "ramnivash@techaheadcorp.com",
     "phone_number": "8750024108",
     "profile_pic": "",
     "isProfileUpdated": true,
     "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiIiwiZW1haWwiOiJyYW1uaXZhc2hAdGVjaGFoZWFkY29ycC5jb20iLCJpYXQiOjE1MDUzMDYxNTksImV4cCI6MTUwNTM5MjU1OX0.kDKfS6TgNcTd_5QmdffZQtBQJKvMBiDolQ8RZVA-5pg",
     "expiresIn": 86400
     }
     }
     * @apiVersion 1.0.0
     **/

    api.post('/loginWithSocial', function (req, res) {
        var data = req.body;
        var schema = {
            'social_id': {
                notEmpty: true,
                errorMessage: 'Invalid Social Id' // Error message for the parameter 
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            var social_id = req.body.social_id;
            //var social_type = req.body.social_type;

            client.query("select * from users where facebook_social_id=?", [social_id], function (error, result, fields) {
                if (error) {
                    console.log(error)
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                } else if (result.length == 0) {
                    //Util.makeResponse(res, false, 200, " Social Id does not exist",appVersion, {});
                    Util.makeResponse(res, false, 200, "User does not exist", appVersion, {});
                } else if (result[0].is_deleted == '1') {
                    Util.makeResponse(res, false, 200, "Sorry, your Account is Deleted .", appVersion, {});
                } else if (result[0].is_blocked == '1') {
                    Util.makeResponse(res, false, 200, "Sorry, your Account is Blocked by admin .", appVersion, {});
                } else {
                    client.query("select * from users where facebook_social_id=? limit 1", [social_id], function (error2, result2, fields2) {
                        if (error2) {

                            Util.makeResponse(res, false, 500, "Something went wrongs", appVersion, {});

                        } else if (result2.length == 0) {
                            Util.makeResponse(res, false, 200, "Social Id is Incorrect", appVersion, {});

                        } else {
                            client.query('UPDATE users SET device_token = ?, device_type=? WHERE id = ? ', [req.body.device_token, req.body.device_type, result2[0].id], function (error3, result3) {

                                var curdate = moment(new Date()).format("YYYY-MM-DD HH:mm:ss");

                                var token_keys = {
                                    "name": Util.checknull(result2[0].full_name),
                                    "email": Util.checknull(result2[0].email)
                                }
                                var token = jwt.sign(token_keys, app.get('superSecret'), {
                                    expiresIn: 86400 // expires in 24 hours
                                });

                                var newData = {
                                    "user_id": Util.checknull(result2[0].id),
                                    "full_name": Util.checknull(result2[0].full_name) + ' ' + Util.checknull(result2[0].last_name),
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
    /************************************************************************ /forgetPassword ************************************************************************/
    /**
     * @api {post} /forgetPassword forgetPassword
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription forgotPassword
     * @apiGroup Customer
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
                        //var from = "ramnivash@tecaheadcorp.com";
                        var res2 = Util.sendMailSMTP(email, 'You have requested the password recovery', 'You have requested the password recovery. To receive a new password, please click on the link <a href="' + activationUrl + '">Click Here</a>', from);
                        Util.makeResponse(res, true, 200, "For furthur steps please check your email.", appVersion, {});

                    }
                });



            }
        });
    });


    /***************************************************************************************************************************************************************/
    /************************************ /checkPreOrderAvailability ************************************************************************/
    /**
     * @api {get} /checkPreOrderAvailability checkPreOrderAvailability
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/checkPreOrderAvailability/
     * @apiGroup Order
     * @apiName checkPreOrderAvailability
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
     "success": false,
     "status": 200,
     "message": "You have already placed your order",
     "api_version": "1.0.0",
     "data": {
     "user_id": "2"
     }
     }
     * @apiVersion 1.0.0
     **/

    api.get('/checkPreOrderAvailability', function (req, res) {
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
            client.query("select * from orders where user_id=?", [data.user_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Success", appVersion, req.query);
                }
                else
                {
                    var check = {
                        order_id: result[0].order_id,
                        user_id: data.user_id
                    }

                    Util.makeResponse(res, true, 200, "You have already placed your order", appVersion, check);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });





    // ---------------------------------------------------------
    // route middleware to authenticate and check token
    // ---------------------------------------------------------
    /*
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
     */

    // ---------------------------------------------------------
    // authenticated routes
    // ---------------------------------------------------------


    /***************************************************************************************************************************************************************/
    /************************************ /getProfile ************************************************************************/
    /**
     * @api {get} /getProfile getProfile
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getProfile/
     * @apiGroup Customer
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
     * @apiDescription updateProfile
     * @apiGroup Customer
     * @apiName updateProfile
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id                    User Id string
     * @apiParam (Expected parameters) {String}      first_name                 First Name string
     * @apiParam (Expected parameters) {String}      last_name                  Last Name string
     * @apiParam (Expected parameters) {String}      is_medical_prescription    is_medical_prescription(0=>unchecked,1=>checked) string
     * @apiParam (Expected parameters) {String}      state                    State string
     * @apiParam (Expected parameters) {String}      city                     City string
     * @apiParam (Expected parameters) {String}      street1                  Street1 string
     * @apiParam (Expected parameters) {String}      street2                  Street2 string
     * @apiParam (Expected parameters) {String}      address                  Address string
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
            user_id: {
                notEmpty: true,
                errorMessage: 'user ID is Required' // Error message for the parameter 
            },
            first_name: {
                notEmpty: true,
                errorMessage: 'First Name is Required'
            },
            last_name: {
                notEmpty: true,
                errorMessage: 'Last Name is Required'
            },
            is_medical_prescription: {
                notEmpty: true,
                errorMessage: 'Check box is required'
            },
            state: {
                notEmpty: true,
                errorMessage: 'State is Required'
            },
            city: {
                notEmpty: true,
                errorMessage: 'City is Required'
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
                        'first_name': data.first_name,
                        'last_name': data.last_name,
                        'is_medical_prescription': data.is_medical_prescription,
                        'state': data.state,
                        'city': data.city,
                        'address': data.address,
                        'gender': data.gender,
                        'dob': data.dob,
                        'street1': data.street1,
                        'street2': data.street2
                    };
                    //console.log(regFields);
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
    /************************************************************************ /applyRefferalCode ************************************************************************/
    /**
     * @api {post} /applyRefferalCode applyRefferalCode
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription applyRefferalCode
     * @apiGroup Customer
     * @apiName applyRefferalCode
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id                    User Id string
     * @apiParam (Expected parameters) {String}      refferal_code              Refferal Code string
     
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
     "message": "Applied successfully",
     "api_version": "1.0.0",
     "data": {
     "user_id": "9",
     "refferal_code": "123456"
     }
     }
     
     * * @apiVersion 1.0.0
     **/
    api.post('/applyRefferalCode', function (req, res) {
        var schema = {
            user_id: {
                notEmpty: true,
                errorMessage: 'user ID is Required' // Error message for the parameter 
            },
            refferal_code: {
                notEmpty: true,
                errorMessage: 'Refferal Code is Required'
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            client.query("select id from users where refferal_code=?", [data.refferal_code], function (error, result) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid Refferal Code", appVersion, {});
                }
                else
                {
                    waterfall([
                        function (callback) {
                            client.query("select id from users where id=? and refferal_code=?", [data.user_id, data.refferal_code], function (error, sameusrresult) {

                                if (sameusrresult.length > 0) {
                                    var sameuser = 1;
                                }
                                else {
                                    var sameuser = 0;
                                }
                                callback(null, sameuser);
                            });

                        },
                        function (sameuser, callback) {
                            client.query("select id from users where id=? and reffered_by!=?", [data.user_id, 0], function (error, refferedchkresult) {
                                if (refferedchkresult.length > 0) {
                                    var already_reffered = 1;
                                }
                                else {
                                    var already_reffered = 0;
                                }

                                callback(null, sameuser, already_reffered);
                            });

                        },
                        function (sameuser, already_reffered, callback) {
                            callback(null, sameuser, already_reffered);
                        }
                    ], function (err, sameuser, already_reffered) {
                        //console.log(sameuser); return false;
                        if (already_reffered === 1) {
                            Util.makeResponse(res, false, 200, "Sorry,You are already reffered", appVersion, {});
                        }

                        else if (sameuser === 1) {
                            Util.makeResponse(res, false, 200, "Sorry,This code is not allowed", appVersion, {});
                        }
                        else {
                            //update reffered by user id on current user
                            var regFields = {
                                'reffered_by': result[0].id
                            };
                            client.query("UPDATE users SET ? WHERE id=?", [regFields, data.user_id], function (error1, result1) {
                                if (error1)
                                {
                                    console.log(error1);
                                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                                }
                                else
                                {
                                    //point activity
                                    pointDetails(client, '3').then(function (db_point) {
                                        var reffered_by = result[0].id;
                                        //insert point on user_points table
                                        client.query("select * from user_points where user_id=? order by id desc limit 1", [reffered_by], function (error, pointresult) {
                                            if (pointresult.length > 0) {
                                                //insert
                                                var available_total_point = pointresult[0].total_point;
                                                var point = db_point;
                                                var total_point = available_total_point + point;
                                                var user_id = reffered_by;
                                                var point_source = '3';
                                                var transaction_type = '1';
                                                client.query("INSERT INTO user_points SET ?", {
                                                    user_id: user_id,
                                                    point_source: '3',
                                                    transaction_type: '1',
                                                    point: point,
                                                    total_point: total_point,
                                                }, function (error1, insresult1) {
                                                    if (error1) {
                                                        console.log('error in point tranaction');
                                                    } else {
                                                        console.log('success full point transaction');
                                                    }

                                                });

                                            }
                                            else {
                                                //insert
                                                var available_total_point = 0;
                                                var point = db_point;
                                                var total_point = available_total_point + point;
                                                var user_id = reffered_by;
                                                var point_source = '3';
                                                var transaction_type = '1';
                                                client.query("INSERT INTO user_points SET ?", {
                                                    user_id: user_id,
                                                    point_source: '3',
                                                    transaction_type: '1',
                                                    point: point,
                                                    total_point: total_point,
                                                }, function (error1, insresult1) {
                                                    if (error1) {
                                                        console.log('error in point tranaction');
                                                    } else {
                                                        console.log('success full point transaction');
                                                    }
                                                });
                                            }
                                        });

                                        Util.makeResponse(res, true, 200, "Applied successfully", appVersion, req.body);
                                    });
                                    //end promis


                                }

                            });


                        }

                    });


                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });

    /***************************************************************************************************************************************************************/
    /************************************************************************ /checkProductAvailability ************************************************************************/
    /**
     * @api {get} /checkProductAvailability checkProductAvailability
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/checkProductAvailability/
     * @apiGroup Product
     * @apiName checkProductAvailability
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               user_id string
     * @apiParam (Expected parameters) {String}      zip_code               zip_code string
     
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

    api.get('/checkProductAvailability', function (req, res) {
        var userData = {};
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            zip_code: {
                notEmpty: true,
                errorMessage: 'Zip Code is required'
            }
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            //var userData=[];
            client.query("select * from zip_codes where zip_code=?", [data.zip_code], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "we can not deliver this product on this location", appVersion, []);
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Success", appVersion, "");
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });





    /***************************************************************************************************************************************************************/
    /************************************************************************ /userPreferredZipCode ************************************************************************/
    /**
     * @api {post} /userPreferredZipCode userPreferredZipCode
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription userPreferredZipCode
     * @apiGroup Customer
     * @apiName userPreferredZipCode
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      zip_code              Zip Code string
     * @apiParam (Expected parameters) {String}      user_id               User Id string
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
     "message": "Your Preferrence is updated Successfully.",
     "api_version": "1.0.0",
     "data": {}
     }
     * @apiVersion 1.0.0
     **/

    api.post('/userPreferredZipCode', function (req, res) {
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            zip_code: {
                notEmpty: true,
                errorMessage: 'Zip Code is required'
            }
        };
        var data = req.body;
        var email = data.email;
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

                    var zip_code = data.zip_code
                    //save zip_code  in database for respective user
                    client.query('UPDATE users SET preferred_zip_code=? where id = ?', [zip_code, result[0].id], function (err2, result2) {
                        if (err2) {
                            Util.makeResponse(res, success, status, message, appVersion, data);
                        } else {

                            Util.makeResponse(res, true, 200, "Your Preferrence is updated Successfully.", appVersion, {});

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
    /************************************************************************ /shareWithContact ************************************************************************/
    /**
     * @api {post} /shareWithContact shareWithContact
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/shareWithContact/
     * @apiGroup Share
     * @apiName shareWithContact
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               user_id string
     * @apiParam (Expected parameters) {Array}      contact_list          Contact List Array([{"mobile": "+918750024108","name": "ram"},{"mobile": "+918750024109","name":"JD"}])
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result           
     
     * @apiVersion 1.0.0
     **/

    api.post('/shareWithContact', function (req, res) {
        var data = req.body;

        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'Invalid User Id' // Error message for the parameter
            },
            'contact_list': {
                notEmpty: true,
                errorMessage: 'Invalid Contact list' // Error message for the parameter
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            var user_id = req.body.user_id;
            client.query("select id,first_name,refferal_code from users where id=?", [data.user_id], function (error, result) {
                if (error) {
                    Util.makeResponse(res, false, 500, "Something went wrong111", appVersion, []);

                } else {

                    if (result.length == 0)
                    {
                        Util.makeResponse(res, false, 200, "Sorry, Invalid user ", appVersion, []);
                    }
                    else
                    {
                        //var contact_list=[{"mobile": "+918750024108","name": "ram"},{"mobile": "+918750024109","name":"manoj"}];
                        //var contact_list=[{"mobile": "+918800383755","name": "ram"}];
                        var url = "google.com";
                        var message = "download app by url" + url + ".Please enter refferal " + result[0].refferal_code + " code at a time of registration.";

                        each(data.contact_list, function (item, next) {
                            client.query("INSERT INTO user_contact_share_list SET ?", {'to_name': item.name, 'user_id': data.user_id, 'to_mobile': item.mobile}, function (err, insertresult) {
                                console.log(item);
                                //send message to list of contact number
                                Util.sendMessage(item.mobile, message);
                                next("", item);
                            });
                        }, function (err, transformedItems) {
                            if (err)
                                throw err;
                            // callback(null, '');
                        });

                        Util.makeResponse(res, true, 200, "Shared successfully", appVersion, req.body);
                    }
                }
            });

        }, function (errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });



    /***************************************************************************************************************************************************************/
    /************************************ /getShareHistory ************************************************************************/
    /**
     * @api {get} /getShareHistory getShareHistory
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getShareHistory/
     * @apiGroup Share
     * @apiName getShareHistory
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
     "message": "Result",
     "api_version": "1.0.0",
     "data": {
     "isFacebookShare": 0,
     "isTwitterShare": 0,
     "isInstagramShare": 0,
     "usedRefferalCount": 1
     }
     }
     * @apiVersion 1.0.0
     **/

    api.get('/getShareHistory', function (req, res) {
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

            waterfall([
                function (callback) {
                    var resultdata = {};
                    client.query("select id from user_points where user_id=? and point_source=?", [data.user_id, '0'], function (err, result) {
                        //console.log(result); return false;
                        if ((result.length) > 0) {
                            resultdata.isFacebookShare = 1;
                        }
                        else {
                            resultdata.isFacebookShare = 0;
                        }
                        callback(null, resultdata);
                    });
                },
                function (resultdata, callback) {

                    client.query("select id from user_points where user_id=? and point_source=?", [data.user_id, '1'], function (err, result) {
                        if ((result.length) > 0) {
                            resultdata.isTwitterShare = 1;
                        }
                        else {
                            resultdata.isTwitterShare = 0;
                        }
                        callback(null, resultdata);
                    });


                },
                function (resultdata, callback) {
                    // arg1 now equals 'three' 

                    client.query("select id from user_points where user_id=? and point_source=?", [data.user_id, '2'], function (err, result) {
                        if ((result.length) > 0) {
                            resultdata.isInstagramShare = 1;
                        }
                        else {
                            resultdata.isInstagramShare = 0;
                        }
                        callback(null, resultdata);
                    });


                },
                function (resultdata, callback) {
                    //used refferal count
                    usedRefferalCodeCount(client, data.user_id).then(function (shareCount) {
                        resultdata.usedRefferalCount = shareCount;
                        callback(null, resultdata);
                    });

                }
            ], function (err, result) {
                //console.log(resultdata);return false;  
                Util.makeResponse(res, true, 200, "Result", appVersion, result);
                // result now equals 'done' 
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
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/changePassword/
     * @apiGroup Customer
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
    /************************************************************************ /shareOnSocialMedia ************************************************************************/
    /**
     * @api {post} /shareOnSocialMedia shareOnSocialMedia
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/shareOnSocialMedia/
     * @apiGroup Share
     * @apiName shareOnSocialMedia
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      social_type          social_type(0=>Share on Facebook,1=>Share on Twitter,2=>Share on Instagram) string
     * @apiParam (Expected parameters) {String}      user_id              user_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/

    api.post('/shareOnSocialMedia', function (req, res) {
        var schema = {
            'social_type': {
                notEmpty: true,
                errorMessage: 'please enter Social Type' // Error message for the parameter 
            },
            'user_id': {
                notEmpty: true,
                errorMessage: 'please enter User Id' // Error message for the parameter 
            }
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            //for checking password
            var data = req.body;
            client.query("select id from users where id=? ", [data.user_id], function (error, result) {
                //console.log(result); return false;
                if (error) {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});

                } else {


                    if (result.length == 0) {
                        Util.makeResponse(res, false, 200, "User is not exist", appVersion, {});
                    }
                    else {
                        client.query("select * from user_points where user_id=? and point_source=?", [data.user_id, data.social_type], function (error, pointresult) {
                            if (pointresult.length > 0) {
                                //no any transaction,one time transaction for each social media sharing
                            }
                            else {
                                //insert point on user_points table
                                client.query("select * from user_points where user_id=? order by id desc limit 1", [data.user_id], function (error, pointresults) {
                                    pointDetails(client, data.social_type).then(function (db_point) {
                                        console.log(db_point);
                                        if (pointresults.length > 0) {
                                            //insert
                                            var available_total_point = pointresults[0].total_point;
                                            var point = db_point;
                                            var total_point = available_total_point + point;
                                            var user_id = data.user_id;
                                            var point_source = data.social_type;
                                            var transaction_type = '1';

                                            client.query("INSERT INTO user_points SET ?", {
                                                user_id: user_id,
                                                point_source: point_source,
                                                transaction_type: '1',
                                                point: point,
                                                total_point: total_point,
                                            }, function (error1, insresult1) {
                                                if (error1) {
                                                    console.log('error in point tranaction');
                                                } else {
                                                    console.log('success full point transaction');
                                                }

                                            });

                                        }
                                        else {
                                            //insert
                                            var available_total_point = 0;
                                            var point = db_point;
                                            var total_point = available_total_point + point;
                                            var user_id = data.user_id;
                                            var point_source = data.social_type;
                                            var transaction_type = '1';
                                            client.query("INSERT INTO user_points SET ?", {
                                                user_id: user_id,
                                                point_source: point_source,
                                                transaction_type: '1',
                                                point: point,
                                                total_point: total_point,
                                            }, function (error1, insresult1) {
                                                if (error1) {
                                                    console.log('error in point tranaction');
                                                } else {
                                                    console.log('success full point transaction');
                                                }

                                            });

                                        }
                                    });



                                });

                            }

                        });


                    }

                    Util.makeResponse(res, true, 200, "Successfully", appVersion, {});
                }
            });

        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /preOrder ************************************************************************/
    /**
     * @api {post} /preOrder preOrder
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/preOrder/
     * @apiGroup Order
     * @apiName preOrder
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               user id string
     * @apiParam (Expected parameters) {String}      transaction_no        transaction_no string
     * @apiParam (Expected parameters) {String}      order_type            order_type(0=>scheduled,1=>ASAP,2=>pre order) string
     * @apiParam (Expected parameters) {String}      pay_status            pay_status(0=>pending,1=>paid) string
     * @apiParam (Expected parameters) {String}      amount                amount string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     *@apiSuccess {Object}                Result  
     
     *************************************************************************************************************************************************************      
     {
     "success": true,
     "status": 200,
     "message": "Successfully completed",
     "api_version": "1.0.0",
     "data": {
     "user_id": "9",
     "transaction_no": "121212",
     "order_type": "2",
     "pay_status": "1",
     "amount": "2563"
     }
     }
     
     * @apiVersion 1.0.0
     **/

    api.post('/preOrder', function (req, res) {
        var data = req.body;
        var schema = {
            user_id: {
                notEmpty: true,
                errorMessage: 'Invalid User Id' // Error message for the parameter
            },
            transaction_no: {
                notEmpty: true,
                errorMessage: 'Invalid Transaction Number' // Error message for the parameter
            },
            order_type: {
                notEmpty: true,
                errorMessage: 'Invalid Order Type' // Error message for the parameter
            },
            pay_status: {
                notEmpty: true,
                errorMessage: 'Invalid Pay Status' // Error message for the parameter
            },
            amount: {
                notEmpty: true,
                errorMessage: 'Invalid Amount' // Error message for the parameter
            }

        };
        req.checkBody(schema);

        req.asyncValidationErrors().then(function () {
            var device_token = req.body.device_token;
            client.query("select id from users where id=?", [data.user_id], function (error, result) {
                if (error) {
                    Util.makeResponse(res, false, 500, "Something went wrong1", appVersion, []);

                } else {
                    // console.log(result);
                    if (result.length == 0)
                    {

                        Util.makeResponse(res, true, 200, " User Not Exist", appVersion, []);

                    } else
                    {
                        client.query("INSERT INTO orders SET ?", {
                            user_id: data.user_id,
                            transaction_no: data.transaction_no,
                            order_type: data.order_type,
                            pay_status: data.pay_status,
                            amount: data.amount
                        }, function (error1, result1) {
                            if (error1) {
                                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                            } else {


                                var order_data = {
                                    order_id: result1.insertId,
                                    user_id: data.user_id,
                                    transaction_no: data.transaction_no,
                                    order_type: data.order_type,
                                    pay_status: data.pay_status,
                                    amount: data.amount
                                }

                                Util.makeResponse(res, true, 200, "Successfully completed", appVersion, order_data);
                            }

                        }
                        );

                    }
                }
            });



        }, function (errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });



    /***************************************************************************************************************************************************************/
    /************************************ /home ************************************************************************/
    /**
     * @api {get} /home home
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/home/
     * @apiGroup Home
     * @apiName home
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
     "api_version": "1.0",
     "data": {
     "appointment": [
     {
     "appointment_date": "2017-10-09T18:30:00.000Z",
     "appointment_time": "10:30:00",
     "status": "Approved"
     }
     ],
     "newProduct": [
     {
     "item_id": 1,
     "item_familly": 1,
     "item_name": "Digital Dream",
     "item_unit": "Ounce",
     "item_image": "http://s3.com/image1.jpg",
     "price_one": "290",
     "price_eigth": "30",
     "weight": "100",
     "description": "Lorazepam may also be used for purposes not listed in this medication guide."
     },
     {
     "item_id": 2,
     "item_familly": 2,
     "item_name": "Digital Dreem1",
     "item_unit": "Ounce",
     "item_image": "http://s3.com/image.png",
     "price_one": "160",
     "price_eigth": "20",
     "weight": "30",
     "description": "Lorem Ipsum, ad? bilinmeyen bir matbaac?n?n bir hurufat numune kitab? olu?turmak üzere bir yaz? galerisini alarak."
     }
     ],
     "biweeklyProduct": [
     {
     "item_id": 2,
     "item_familly": 2,
     "item_name": "Digital Dreem1",
     "item_unit": "Ounce",
     "item_image": "http://s3.com/image.png",
     "price_one": "160",
     "price_eigth": "20",
     "weight": "30",
     "description": "Lorem Ipsum, ad? bilinmeyen bir matbaac?n?n bir hurufat numune kitab? olu?turmak üzere bir yaz? galerisini alarak."
     }
     ],
     "userData": [],
     }
     }
     * @apiVersion 1.0.0
     **/

    api.get('/home', function (req, res) {
        var totalData = {};
        var date = moment.utc().format('YYYY-MM-DD');
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            waterfall([
                function (callback) {
                    //upcomming appointment
                    var status = 'CASE status when "0" then "Pending" when "1"  then "Approved" when "2"  then "Reschedule" when "3" then "Cancel" END as status';
                    client.query("select CONCAT_WS(' ',appointment_date,appointment_time) AS datetime,appointment_date,appointment_time," + status + " from appointment_details where user_id=? and appointment_date>=? and status=?", [data.user_id, date, '1'], function (err, result) {
                        if (err)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else {
                            totalData.appointment = result;
                            callback(null, totalData);
                        }

                    });

                },
                function (totalData, callback) {
                    //new product
                    var unit = 'CASE item_unit when "1" then "Ounce" when "2"  then "Gram" when "3"  then "ml" when "4" then "Piece" END as item_unit';

                    client.query("select items.item_id,items.item_familly,items.item_name," + unit + ",items.item_image,items.price_one,items.price_eigth,items.weight,items.review as description from items where items.status=? order by items.created_at desc limit 3", ['1'], function (err, result) {
                        if (err) {
                            Util.makeResponse(res, false, 500, "Something went1 wrong", appVersion, []);
                        }
                        else {
                            totalData.newProduct = result;
                            callback(null, totalData);
                        }

                    });

                },
                function (totalData, callback) {
                    // biweekly products
                    var unit = 'CASE item_unit when "1" then "Ounce" when "2"  then "Gram" when "3"  then "ml" when "4" then "Piece" END as item_unit';
                    client.query("select items.item_id,items.item_familly,items.item_name," + unit + ",items.item_image,items.price_one,items.price_eigth,items.weight,items.review as description from items where items.status=? and is_biweekly=?", ['1', '1'], function (err, biweeklyresult) {
                        if (err) {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else {
                            totalData.biweeklyProduct = biweeklyresult;
                            callback(null, totalData);
                        }

                    });

                },
                function (totalData, callback) {
                    //user details
             client.query("select first_name,last_name,profile_pic,email,phone_number,address,gender,(select total_point from user_points where user_id='" + data.user_id + "' order by id desc limit 1) as reward_point from users where id=?", [data.user_id], function (err, userresult) {
                        if (err)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else {
                            //console.log(userresult); return false;
                            var first_name=userresult[0].first_name=='' || userresult[0].first_name=='NULL'?0:1;
                            var last_name=userresult[0].last_name=='' || userresult[0].last_name=='NULL'?0:1;
                            var email=userresult[0].email=='' || userresult[0].email=='NULL'?0:1;
                            var profile_pic=userresult[0].profile_pic=='' || userresult[0].profile_pic=='NULL'?0:1;
                            var gender=userresult[0].gender=='' || userresult[0].gender=='NULL'?0:1;
                            var phone_number=userresult[0].phone_number=='' || userresult[0].phone_number=='NULL'?0:1;
                            var dob=userresult[0].dob=='' || userresult[0].dob=='NULL'?0:1;
                            var address=userresult[0].address=='' || userresult[0].address=='NULL'?0:1;
                            
                            var total=parseInt(first_name)+parseInt(last_name)+parseInt(email)+parseInt(profile_pic)+parseInt(gender)+parseInt(phone_number)+parseInt(dob)+parseInt(address);
                            var percentage=parseInt(total*100)/parseInt(8); 
                             //console.log(percentage); return false;
                             var profile_percentage={percentage:percentage};
                             userresult.push(profile_percentage);
                            totalData.userData = userresult;
                            callback(null, totalData);
                        }

                    });

                }

            ], function (err, wholeresult) {
                // result now equals 'done' 
                Util.makeResponse(res, true, 200, 'Success', '1.0', wholeresult);

            });



        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });







    /***************************************************************************************************************************************************************/
    /************************************************************************ /categoryList ************************************************************************/
    /**
     * @api {get} /categoryList categoryList
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/categoryList 
     * @apiGroup Category
     * @apiName categoryList
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               user id string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
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
     "api_version": "1.0",
     "data": [
     {
     "category_name": "category1",
     "category_id": 1,
     "subcategory": [
     {
     "category_id": 3,
     "name": "subcat1",
     "status": "1"
     }
     ],
     },
     {
     "category_name": "category2",
     "category_id": 2,
     "subcategory": [],
     }
     ],
     }
     
     * @apiVersion 1.0.0
     **/
    api.get('/categoryList', function (req, res) {
        var categorydata = [];
        waterfall([
            function (callback) {
                client.query("select category_id,name,status from category where status=? and parent_id='0'", ['1'], function (error, category) {
                    callback(null, category);
                });

            },
            function (category, callback) {
                each(category, function (item, next) {
                    //console.log(item.category_id); return false;
                    client.query("select category_id,name,status from category where parent_id=?", [item.category_id], function (err, result1) {

                        var total = {
                            category_name: item.name,
                            category_id: item.category_id,
                            subcategory: result1
                        };
                        categorydata.push(total);
                        next("", total);
                    });

                }, function (err, transformedItems) {
                    if (err)
                        throw err;
                    callback(null, categorydata);
                });


                //callback(null,result);
            }
        ], function (err, result) {
            if (result.length == 0) {
                Util.makeResponse(res, true, 200, 'Category is not available', appVersion, result);
            } else {
                Util.makeResponse(res, true, 200, 'Success', appVersion, result);
            }

        });

    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /itemList ************************************************************************/
    /**
     * @api {get} /itemList itemList
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/itemList 
     * @apiGroup Item
     * @apiName itemList
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      category_id               category id string
     * @apiParam (Expected parameters) {String}      sub_cat_id                sub Category id Array ([{"sub_cat_id":"12"},{"sub_cat_id":"10"}])
     * @apiParam (Expected parameters) {String}      page                      page no.(first time it will be 0)  string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     {
     "success": true,
     "status": 200,
     "message": "Item List",
     "api_version": "1.0",
     "data": {
     "itemList": [
     {
     "item_id": 1,
     "item_name": "Digital Dream",
     "item_unit": "Ounce",
     "item_image": "http://s3.com/image1.jpg",
     "price_one": "290",
     "price_eigth": "30",
     "weight": "100",
     "categories": "category1,category2",
     "familly_type": "sativa"
     }
     ],
     }
     }
     * @apiVersion 1.0.0
     **/
    api.get('/itemList', function (req, res) {
        var data = req.query;
        var alldata = {};


        /*** set page limit ***/
        var limit = 10;
        /*** Get Offset ***/
        var offset = 0;
        if (data.page && data.page != 0)
        {
            offset = (data.page * limit);
        }
        /*** Get Offset ***/

        var unit = 'CASE item_unit when "1" then "Ounce" when "2"  then "Gram" when "3"  then "ml" when "4" then "Piece" END as item_unit';


        client.query("select items.item_id,items.item_familly,items.item_name," + unit + ",items.item_image,items.price_one,items.price_eigth,items.weight,items.review as description,items.flavor,items.recommended_uses,items.smell,items.effect,items.color_code,items.thc,items.cbg,items.cbc,items.cbn,items.cbd,items.thcv,categoryNamesByItemId(items.item_id) as categories,getFamillyType(items.item_familly) as familly_type from items right join item_category_mapping as mapping on mapping.item_id=items.item_id  where mapping.category_id=? and items.status=? limit " + offset + "," + limit + "", [data.category_id, '1'], function (err, result) {
            if (result.length == 0) {
                Util.makeResponse(res, true, 200, 'No data found', appVersion, []);
            }
            else {
                alldata.itemList = result;
                Util.makeResponse(res, true, 200, 'Item List', appVersion, alldata);
            }

        });

    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /itemDetail ************************************************************************/
    /**
     * @api {get} /itemDetail itemDetail
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/itemDetail 
     * @apiGroup Item
     * @apiName itemDetail
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      item_id                   item id string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     {
     "success": true,
     "status": 200,
     "message": "Data List",
     "api_version": "1.0",
     "data": [
     {
     "item_id": 1,
     "item_familly": 1,
     "item_name": "Digital Dream",
     "item_unit": "Ounce",
     "item_image": "http://s3.com/image1.jpg",
     "price_one": "290",
     "price_eigth": "30",
     "weight": "100",
     "description": "Lorazepam may also be used for purposes not listed in this medication guide.",
     "flavor": "sweet lemany",
     "recommended_uses": "abc,xyz",
     "smell": "hint of fruet",
     "effect": "effect1,effect2",
     "color_code": "#6495ED",
     "thc": 10,
     "cbg": 20,
     "cbc": 30,
     "cbn": 40,
     "cbd": 50,
     "thcv": 60,
     "categories": null,
     "familly_type": "sativa"
     }
     ],
     }
     * @apiVersion 1.0.0
     **/
    api.get('/itemDetail', function (req, res) {
        var data = req.query;

        var unit = 'CASE item_unit when "1" then "Ounce" when "2"  then "Gram" when "3"  then "ml" when "4" then "Piece" END as item_unit';
        client.query("select items.item_id,items.item_familly,items.item_name," + unit + ",items.item_image,items.price_one,items.price_eigth,items.weight,items.review as description,items.flavor,items.recommended_uses,items.smell,items.effect,items.color_code,items.thc,items.cbg,items.cbc,items.cbn,items.cbd,items.thcv,categoryNamesByItemId('" + data.item_id + "') as categories,getFamillyType(items.item_familly) as familly_type from items where item_id=? and status=?", [data.item_id, '1'], function (err, result) {
            if (result.length == 0) {
                Util.makeResponse(res, true, 200, 'No data found', appVersion, []);
            }
            else {

                Util.makeResponse(res, true, 200, 'Data List', appVersion, result);
            }

        });



    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /uploadPrescription ************************************************************************/
    /**
     * @api {post} /uploadPrescription uploadPrescription
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription uploadPrescription
     * @apiGroup Order
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
    /************************************ /getConsultationType ************************************************************************/
    /**
     * @api {get} /getConsultationType getConsultationType
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getConsultationType/
     * @apiGroup Customer
     * @apiName getConsultationType
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
     "message": "Result",
     "api_version": "1.0",
     "data": {
     "main": [
     {
     "id": 1,
     "name": "AIDS"
     },
     {
     "id": 2,
     "name": "Cancer"
     }
     ],
     "other": [
     {
     "id": 3,
     "name": "other1"
     },
     {
     "id": 4,
     "name": "other2"
     }
     ],
     }
     }
     
     * @apiVersion 1.0.0
     **/

    api.get('/getConsultationType', function (req, res) {
        var consultationData = {};
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            waterfall([
                function (callback) {
                    client.query("select id,name from consultation_type where is_other=?", ['0'], function (error, result) {
                        if (error)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                        }
                        else {
                            consultationData.main = result;
                            callback(null, consultationData);
                        }

                    });
                },
                function (consultationData, callback) {
                    client.query("select id,name from consultation_type where is_other=?", ['1'], function (err, otherresult) {
                        if (err)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                        }
                        else {
                            consultationData.other = otherresult;
                            callback(null, consultationData);
                        }
                    });

                }

            ], function (err, consultationData) {
                Util.makeResponse(res, true, 200, 'Result', '1.0', consultationData);
                // result now equals 'done' 
            });

        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /timeAvailability ************************************************************************/
    /**
     * @api {get} /timeAvailability timeAvailability
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/timeAvailability 
     * @apiGroup Time
     * @apiName timeAvailability
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      date               date(2017-10-15) string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     {
     "success": true,
     "status": 200,
     "message": "Result",
     "api_version": "1.0",
     "data": {
     "appointmentFee": 100,
     "timeSlot": [
     {
     "id": 1,
     "time": "10:00:00"
     },
     {
     "id": 2,
     "time": "10:15:00"
     },
     {
     "id": 3,
     "time": "10:30:00"
     },
     {
     "id": 4,
     "time": "10:45:00"
     },
     {
     "id": 5,
     "time": "11:00:00"
     },
     {
     "id": 6,
     "time": "11:15:00"
     }
     ],
     }
     }
     * @apiVersion 1.0.0
     **/
    api.get('/timeAvailability', function (req, res) {
        var data = req.query;
        var current_time = moment.utc().format('HH:mm');
        //console.log(current_time); return false;
        var finaldata = {};
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            'date': {
                notEmpty: true,
                errorMessage: 'Date is Required'
            }
        };
        req.asyncValidationErrors().then(function () {

            client.query("select fee as appointmentFee from appointment_fee_details", function (error, appointmentresult) {
                if (error) {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else {
                    finaldata = appointmentresult[0];
                    client.query("select id,time from time_slots", function (err, result) {
                        if (err)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                        }
                        else {
                            finaldata.timeSlot = result;
                            Util.makeResponse(res, true, 200, 'Result', '1.0', finaldata);

                        }
                    });
                }
            });


        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });




    /***************************************************************************************************************************************************************/
    /************************************************************************ /setAppointment ************************************************************************/
    /**
     * @api {post} /setAppointment setAppointment
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription setAppointment
     * @apiGroup Order
     * @apiName setAppointment
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               User Id string
     * @apiParam (Expected parameters) {String}      consultation_type     Consultation Type Array(Array({"id":"1"},{"id":"2"}))
     * @apiParam (Expected parameters) {String}      appointment_time      Appointmen time string
     * @apiParam (Expected parameters) {String}      time_id               Time Id string
     * @apiParam (Expected parameters) {String}      date                  date(2017-02-22) string
     * @apiParam (Expected parameters) {String}      other_consultation_request               other_consultation_request string
     * @apiParam (Expected parameters) {String}      transaction_id               transaction_id string
     * @apiParam (Expected parameters) {String}      paid_amount                  Paid amount string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status            status code
     * @apiSuccess {String}                Message           response message string
     * @apiSuccess {String}                AppVersion        APP version
     * @apiSuccess {Object}                Result            result
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/

    api.post('/setAppointment', function (req, res) {
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            consultation_type: {
                notEmpty: true,
                errorMessage: 'Consultation Type is required'
            },
            appointment_time: {
                notEmpty: true,
                errorMessage: 'Time is required'
            },
            transaction_id: {
                notEmpty: true,
                errorMessage: 'Transaction id is required'
            },
            paid_amount: {
                notEmpty: true,
                errorMessage: 'Paid amount is required'
            },
            date: {
                notEmpty: true,
                errorMessage: 'Date is required'
            }

        };
        var data = req.body;
        req.checkBody(schema);
        //console.log(data.consultation_type); return false;
        //var date = moment.utc().format('YYYY-MM-DD');
        req.asyncValidationErrors().then(function () {

            client.query("select users.id,first_name from users left join appointment_details on users.id=appointment_details.doctor_id where user_type='1' ORDER BY RAND()", function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else {
                    //insert on appointment details
                    //console.log(result[0].id); return false;
                    var doctorid = result[0].id;
                    client.query("INSERT INTO appointment_details SET ?", {user_id: data.user_id, doctor_id: doctorid, appointment_time: data.appointment_time, other_consultation_request: data.other_consultation_request, appointment_date: data.date, paid_amount: data.paid_amount, transaction_no: data.transaction_id}, function (err, result, fields2) {
                        if (err)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else {
                            //insert other request
                            console.log("appointmentid" + result.insertId);
                            //var consultation_type=[{"id":"1"},{"id": "2"}];
                            each(data.consultation_type, function (item, next) {
                                //console.log(item); return false;
                                client.query("INSERT INTO user_consultation_request SET ?", {'appointment_id': result.insertId, 'user_id': data.user_id, 'consultation_type_id': item.id}, function (error, insertresult) {
                                    //console.log(item);
                                    next("", item);
                                });
                            }, function (err, transformedItems) {
                                if (err)
                                    throw err;
                                // callback(null, '');
                            });


                            Util.makeResponse(res, true, 200, "Appointment set successfully", appVersion, {});
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
    /************************************ /getMinimumOrderAmount ************************************************************************/
    /**
     * @api {get} /getMinimumOrderAmount getMinimumOrderAmount
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getMinimumOrderAmount/
     * @apiGroup Order
     * @apiName getMinimumOrderAmount
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
     "message": "result",
     "api_version": "1.0.0",
     "data": {
     "min_order_ondemond": 140,
     "min_amount": 50
     }
     }
     * @apiVersion 1.0.0
     **/

    api.get('/getMinimumOrderAmount', function (req, res) {
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            var userData = {"min_order_ondemond": 140, "min_amount": 50};


            Util.makeResponse(res, true, 200, "result", appVersion, userData);
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });




    /***************************************************************************************************************************************************************/
    /************************************ /getCouponList ************************************************************************/
    /**
     * @api {get} /getCouponList getCouponList
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getCouponList/
     * @apiGroup Coupons
     * @apiName getCouponList
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
     "message": "Result",
     "api_version": "1.0.0",
     "data": {
     "couponList": [
     {
     "name": "Boom your wishes into reality",
     "id": 1,
     "coupon_code": "BOOM5",
     "points": 110,
     "discount": 30,
     "discount_type": "2"
     },
     {
     "name": "Boom your wishes alnight",
     "id": 2,
     "coupon_code": "BOOM5",
     "points": 150,
     "discount": 18,
     "discount_type": "1"
     }
     ],
     "totalPoint": 100
     }
     }
     * @apiVersion 1.0.0
     **/

    api.get('/getCouponList', function (req, res) {
        var finaldata = {};
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select name,id,code as coupon_code,points,discount,discount_type from coupons where status='1'", function (err, result) {
                if (err) {

                }
                else {
                    finaldata.couponList = result;
                    client.query("select total_point from user_points where user_id=? order by id desc limit 1", [data.user_id], function (error, pointresult) {
                        if (error) {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else {
                            //console.log(pointresult.length);return false;
                            if (pointresult.length > 0) {
                                finaldata.totalPoint = pointresult[0].total_point;
                            }
                            else {
                                finaldata.totalPoint = 0;
                            }

                            Util.makeResponse(res, true, 200, "Result", appVersion, finaldata);
                        }

                    });


                }


            });

        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });



    /***************************************************************************************************************************************************************/
    /************************************ /getCustomerProfile ************************************************************************/
    /**
     * @api {get} /getCustomerProfile getCustomerProfile
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getCustomerProfile/
     * @apiGroup Customer
     * @apiName getCustomerProfile
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
     "gender": "",
     "email": "ramnivash@techaheadcorp.com",
     "phone_number": "8750024108",
     "dob": "2016-04-04T18:30:00.000Z",
     "location": "Saffron Colony",
     "refferal_code": 123456,
     "reward_point": 900
     }
     }
     * @apiVersion 1.0.0
     **/

    api.get('/getCustomerProfile', function (req, res) {
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
            client.query("select first_name,last_name,profile_pic,gender,email,phone_number,dob,address as location,refferal_code,(select total_point from user_points where user_id='" + data.user_id + "' order by id desc limit 1) as reward_point from users where id=?", [data.user_id], function (err, result) {
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
    /************************************************************************ /updateCustomerProfile ************************************************************************/
    /**
     * @api {post} /updateCustomerProfile updateCustomerProfile
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription updateCustomerProfile
     * @apiGroup Customer
     * @apiName updateCustomerProfile
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id                    User Id string
     * @apiParam (Expected parameters) {String}      first_name                 First Name string
     * @apiParam (Expected parameters) {String}      last_name                  Last Name string
     * @apiParam (Expected parameters) {String}      phone_number               Phone number string
     * @apiParam (Expected parameters) {String}      profile_pic                Profile Pic string
     * @apiParam (Expected parameters) {String}      address                   Address/Location string
     * @apiParam (Expected parameters) {String}      latitude                  latitude string
     * @apiParam (Expected parameters) {String}      longitude                 longitude string
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
    api.post('/updateCustomerProfile', function (req, res) {
        var schema = {
            user_id: {
                notEmpty: true,
                errorMessage: 'user ID is Required' // Error message for the parameter 
            },
            first_name: {
                notEmpty: true,
                errorMessage: 'First Name is Required'
            },
            last_name: {
                notEmpty: true,
                errorMessage: 'Last Name is Required'
            },
            phone_number: {
                notEmpty: true,
                errorMessage: 'Phone Number is Required'
            },
            dob: {
                notEmpty: true,
                errorMessage: 'Date of birth is Required'
            },
            gender: {
                notEmpty: true,
                errorMessage: 'Gender is Required'
            },
            address: {
                notEmpty: true,
                errorMessage: 'Address is Required'
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
                        'first_name': data.first_name,
                        'last_name': data.last_name,
                        'phone_number': data.phone_number,
                        'address': data.address,
                        'gender': data.gender,
                        'dob': data.dob,
                        //'profile_pic':data.profile_pic
                    };
                    if (data.profile_pic) {
                        regFields.profile_pic = data.profile_pic;
                    }

                    // console.log(regFields); return false;
                    client.query("UPDATE users SET ? WHERE id = ?", [regFields, data.user_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else
                        {
                          client.query("select first_name,last_name,phone_number,address,gender,dob,profile_pic,email from users where id=?", [data.user_id], function (error, updateresult) {
                           if(error){
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);   
                           }   
                              
                           Util.makeResponse(res, true, 200, "Profile updated successfully", appVersion,updateresult[0]);   
                          });   
                            
                            
                        }
                    });
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });




    /***************************************************************************************************************************************************************/
    /************************************ /checkPrescriptionExpiration ************************************************************************/
    /**
     * @api {get} /checkPrescriptionExpiration checkPrescriptionExpiration
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/checkPrescriptionExpiration/
     * @apiGroup Order
     * @apiName checkPrescriptionExpiration
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
     "expire_date": "2017-10-05T18:30:00.000Z"
     }
     }
     * @apiVersion 1.0.0
     **/

    api.get('/checkPrescriptionExpiration', function (req, res) {
        var date = moment.utc().format('YYYY-MM-DD');
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
            client.query("select expire_date from prescriptions where user_id=? and expire_date>=? limit 1", [data.user_id, date], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Success", appVersion, 'prescription is not valid');
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
    /************************************ /getPrescriptionList ************************************************************************/
    /**
     * @api {get} /getPrescriptionList getPrescriptionList
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getPrescriptionList/
     * @apiGroup Customer
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
    /************************************************************************ /addtoCart ************************************************************************/
    /**
     * @api {post} /addtoCart addtoCart
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription addtoCart
     * @apiGroup Cart
     * @apiName addtoCart
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id                    User Id string
     * @apiParam (Expected parameters) {String}      item_id                    Item Id string
     * @apiParam (Expected parameters) {String}      cart_item_qty              Cart Item Qty string
     
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
    "message": "Item successfully added into cart",
    "api_version": "1.0.0",
    "data": [],
    }
     
     * * @apiVersion 1.0.0
     **/
    api.post('/addtoCart', function (req, res) {
        var schema = {
            user_id: {
                notEmpty: true,
                errorMessage: 'user ID is Required' // Error message for the parameter 
            },
            item_id: {
                notEmpty: true,
                errorMessage: 'Item Id is Required'
            },
            cart_item_qty: {
                notEmpty: true,
                errorMessage: 'Cart Item Quantity is Required'
            }
           
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
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
             client.query("select id,item_id,cart_item_qty from cart where item_id=? and user_id=?", [data.item_id,data.user_id],function (error, itemresult) {
             if(error){
              Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);     
             }
             else{
             if(itemresult.length>0){
             //update cart item
              var arr = {
              'cart_item_qty': parseInt(itemresult[0].cart_item_qty) + parseInt(data.cart_item_qty),
              };
              //console.log(itemresult[0].id); return false;
             //console.log(arr)
          client.query("UPDATE cart SET ? WHERE id=?", [arr,itemresult[0].id], function(err, result) {
         if (err) {
          Util.makeResponse(res, false, 500, "Something went wrong while updating in tbl_cart",appVersion, []);

            } else {
            //console.log(result)
           Util.makeResponse(res, true, 200, "Item successfully added into cart", appVersion, []);

            }
            })
             
             
             }
             else{
             //insert item in cart
              var regFields = {
                 'item_id': data.item_id,
                 'cart_item_qty':data.cart_item_qty,
                 'user_id': data.user_id
                 };
                 
                client.query("INSERT INTO cart SET ?", regFields, function (error, inserresult) {
                if(error){
                 Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else{
                 Util.makeResponse(res, true, 200, "Item successfully added into cart", appVersion,[]);
                }
                });
             
             }
                 
                 
             }
                  
             });

                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });

   
   



/***************************************************************************************************************************************************************/
    /************************************ /getCart ************************************************************************/
    /**
     * @api {get} /getCart getCart
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getCart/
     * @apiGroup Cart
     * @apiName getCart
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
    "message": "Result",
    "api_version": "1.0.0",
    "data": [
      {
    "cart_item_qty": 2,
    "item_id": 1,
    "item_name": "Digital Dream",
    "item_unit": "Ounce",
    "item_image": "http://s3.com/image1.jpg",
    "price_eigth": "30",
    "price_one": "290",
    "weight": "100"
    }
    ],
    }
     * @apiVersion 1.0.0
     **/

    api.get('/getCart', function (req, res) {
        var finaldata = {};
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
             var unit = 'CASE item_unit when "1" then "Ounce" when "2"  then "Gram" when "3"  then "ml" when "4" then "Piece" END as item_unit';
            client.query("select id as cart_id,cart.cart_item_qty,items.item_id,items.item_name,"+unit+",items.item_image,items.price_eigth,items.price_one,weight from cart left join items on cart.item_id=items.item_id where cart.user_id=?",[data.user_id], function (err, result) {
                if (err) {
                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else {
                    Util.makeResponse(res, true, 200, "Result", appVersion,result);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });

    });
        
    /***************************************************************************************************************************************************************/
    /************************************************************************ /deleteCart ************************************************************************/
    /**
     * @api {delete} /deleteCart deleteCart
     * @apiHeader {String} x-medme-token Users unique x-instacraft-token.
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/api/v1/deleteCart 
     * @apiGroup Cart
     * @apiName deleteCart
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      userId                User ID string
     * @apiParam (Expected parameters) {String}      cart_id               Cart ID string
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/

    api.delete('/deleteCart', function(req, res) {
        var data = req.query;
        //console.log(data)
        var schema = {
            'cart_id': {
                notEmpty: true,
                errorMessage: 'Cart ID is Required'
            },
            'user_id': {
                notEmpty: true,
                errorMessage: 'User ID is Required'
            },
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function() {
            client.query("select id from cart WHERE id=?", [data.cart_id], function(err, result) {
                //console.log(result)
                if (err) {
                    Util.makeResponse(res, false, 500, "Something went wrong while fetching cart details ",appVersion, []);
                } else if (result.length === 0) {
                    Util.makeResponse(res, false, 200, "Cart not found", '1.0.0', []);
                } else {
                    client.query("delete  from cart WHERE id=?", [data.cart_id])
                    Util.makeResponse(res, true, 200, "Success", '1.0.0', []);
                }
            })
        }, function(errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request", '1.0.0', errors);
        });
    });






    /***************************************************************************************************************************************************************/
    /************************************ /getCaregiverDetails ************************************************************************/
    /**
     * @api {get} /getConsultationType getCaregiverDetails
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getCaregiverDetails/
     * @apiGroup Order
     * @apiName getCaregiverDetail
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id               user_id string
     * @apiParam (Expected parameters) {String}      item_ids              item_ids Array([{"item_id": "1"},{"item_id": "2"}])
     
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
     "message": "Result",
     "api_version": "1.0",
     "data": {
     "full_name": "ram nivash",
     "dob": "2016-04-04T18:30:00.000Z",
     "phone_number": "8750024109",
     "home_address": "",
     "city": "",
     "state": "",
     "country": "",
     "zip": 0,
     "caregiverInfo": [
     {
     "item_id": 1,
     "caregiver_id": 1,
     "name": "caregiver1",
     "telephone_number": "5236589875",
     "email": "caregiver1@gmail.com",
     "city": "delhi",
     "state": "delhi",
     "country": "india",
     "zip_code": 123654
     },
     {
     "item_id": 2,
     "caregiver_id": 1,
     "name": "caregiver1",
     "telephone_number": "5236589875",
     "email": "caregiver1@gmail.com",
     "city": "delhi",
     "state": "delhi",
     "country": "india",
     "zip_code": 123654
     }
     ],
     }
     }
     
     * @apiVersion 1.0.0
     **/

    api.get('/getCaregiverDetails', function (req, res) {
        var totalData = {};
        var itemData = [];
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            'item_ids': {
                notEmpty: true,
                errorMessage: 'Item Ids is Required'
            }
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            waterfall([
                function (callback) {
                    client.query("select CONCAT_WS(' ',first_name,last_name) AS full_name,dob,phone_number,address as home_address,city,state,country,zip  from users where id=?", [data.user_id], function (error, result) {
                        if (error)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                        }
                        else {
                            totalData = result[0];
                            callback(null, totalData);
                        }

                    });
                },
                function (totalData, callback) {
                    //get caregiver by item id
                    //var item_ids=[{"item_id": "1"},{"item_id": "2"}]
                    each(data.item_ids, function (item, next) {
                        client.query("select items.item_id,items.caregiver_id,caregiver.name,caregiver.telephone_number,caregiver.email,caregiver.city,caregiver.state,caregiver.country,caregiver.zip_code from items left join caregiver_details as caregiver on items.caregiver_id=caregiver.id  where item_id=?", [item.item_id], function (err, careresult) {
                            if (err)
                            {
                                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                            }
                            else {
                                itemData.push(careresult[0]);
                                totalData.caregiverInfo = itemData;
                                next("", item);
                            }

                        });

                    }, function (err, transformedItems) {
                        if (err)
                            throw err;
                        callback(null, totalData);
                    });


                }

            ], function (err, totalData) {
                Util.makeResponse(res, true, 200, 'Result', '1.0', totalData);
                // result now equals 'done' 
            });

        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });

    });
    
    
    


    /***************************************************************************************************************************************************************/
    /************************************ /myOrders ************************************************************************/
    /**
     * @api {get} /myOrders myOrders
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/myOrders/
     * @apiGroup Order
     * @apiName myOrders
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
     "message": "Data",
     "api_version": "1.0.0",
     "data": [
     {
     "order_id": 123,
     "order_status": "Assigned",
     "amount": 2000,
     "order_date": "2017-08-31T18:30:00.000Z",
     "delivered_date": "2017-08-27T18:30:00.000Z"
     },
     {
     "order_id": 124,
     "order_status": "Assigned",
     "amount": 200,
     "order_date": "2017-09-03T18:30:00.000Z",
     "delivered_date": "0000-00-00"
     }
     ],
     }
     * @apiVersion 1.0.0
     **/

    api.get('/myOrders', function (req, res) {
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {

            var status = 'CASE orders.order_status when "0" then "Un Assigned" when "1"  then "Assigned" when "2"  then "Start" when "3" then "Hold" when "4" then "Reached" when "5" then "Return" when "6" then "Delivered" END as order_status';
            
            client.query("select orders.order_id,orders.order_status,orders.amount,orders.created_at as order_date,assign.delivered_date," + status + " from orders left join  driver_assigned_order as assign on assign.order_id=orders.order_id where orders.user_id=?", [data.user_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }

                else
                {
                    Util.makeResponse(res, true, 200, "Data", appVersion, result);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /getOrderDetails ************************************************************************/
    /**
     * @api {get} /getOrderDetails getOrderDetails
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getOrderDetails/
     * @apiGroup Order
     * @apiName getOrderDetails
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      user_id              user_id string
     * @apiParam (Expected parameters) {String}      order_id             order_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiSuccess {json} Success-Response
     
     * @apiVersion 1.0.0
     **/
    api.get('/getOrderDetails', function (req, res) {
        var orderData = {};
        var data = req.query;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            'order_id': {
                notEmpty: true,
                errorMessage: 'Order Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            waterfall([
                function (callback) {
                    //order details
                    var status = 'CASE orders.order_status when "0" then "Un Assigned" when "1"  then "Assigned" when "2"  then "Start" when "3" then "Hold" when "4" then "Reached" when "5" then "Return" when "6" then "Delivered" END as order_status';

                    client.query("select orders.order_id,orders.order_status,orders.amount,orders.created_at as order_date,assign.delivered_date," + status + " from orders left join  driver_assigned_order as assign on assign.order_id=orders.order_id where orders.user_id=? and orders.order_id=?", [data.user_id, data.order_id], function (err, result) {
                        if (err)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else
                        {
                            orderData = result[0];
                            callback(null, orderData);
                        }
                    });

                    //
                },
                function (orderData, callback) {
                    //ordered items
                    client.query("select orderitem.order_qty as order_qty,items.item_id,items.item_name,items.item_unit,items.item_image,items.price_one,items.price_eigth,items.weight,categoryNamesByItemId(items.item_id) as categories from order_items as orderitem left join items on orderitem.item_id=items.item_id where orderitem.order_id=?", [data.order_id], function (itemerr, itemresult) {
                        if (itemerr)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else {
                            orderData.items = itemresult;
                            callback(null, orderData);
                        }

                    });

                },
                function (orderData, callback) {
                    //driver details
                    client.query("select orders.driver_id,orders.drop_location as drop_loation,delivery_date as drop_date,delivery_time as drop_time,driver.first_name,driver.last_name,driver.profile_image from orders left join  driver as driver on driver.driver_id=orders.driver_id where orders.user_id=? and orders.order_id=?", [data.user_id, data.order_id], function (drivererr, driverresult) {
                        if (drivererr) {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else {
                            orderData.driver = driverresult;
                            callback(null, orderData);
                        }

                    });

                }
            ], function (err, result) {
                Util.makeResponse(res, true, 200, "Data", appVersion, result);
            });


        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });





    /***************************************************************************************************************************************************************/
    /************************************ /getSetting ************************************************************************/
    /**
     * @api {get} /getSetting getSetting
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getSetting/
     * @apiGroup Customer
     * @apiName getSetting
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
     * {
     "success": true,
     "status": 200,
     "message": "Data",
     "api_version": "1.0.0",
     "data": [
     {
     "is_notification": "1",
     "is_location": "0"
     }
     ],
     }
     * @apiVersion 1.0.0
     **/

    api.get('/getSetting', function (req, res) {
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
            client.query("select is_notification,is_location from users where id=?", [data.user_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }

                else
                {
                    Util.makeResponse(res, true, 200, "Data", appVersion, result[0]);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });








    /*****************************************************************************************/
    /***********************updateSetting******************************************/
    /*****************************************************************************************/
    /**
     * @api {post} /updateSetting updateSetting
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/updateSetting/
     * @apiGroup Customer
     * @apiName updateSetting
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      notification_status           status(0=>Off,1=>On) 
     * @apiParam (Expected parameters) {String}      location_status               status(0=>Off,1=>On)
     * @apiParam (Expected parameters) {String}      user_id          user_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * {
     * "success": true,
     * "status": 200,
     * "message": "Status updated successfully",
     * "api_version": "1.0.0",
     * "data":[]
     * }
     * @apiVersion 1.0.0
     **/
    api.post('/updateSetting', function (req, res) {
        var data = req.body;
        var schema = {
            'user_id': {
                notEmpty: true,
                errorMessage: 'User Id is Required'
            },
            'notification_status': {
                notEmpty: true,
                errorMessage: ' Notification Status is Required'
            },
            'location_status': {
                notEmpty: true,
                errorMessage: ' Location Status is Required'
            }
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select * from users where id=? ", [data.user_id], function (error, result) {
                if (error) {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                } else {
                    if (result.length == 0) {
                        Util.makeResponse(res, false, 200, "This User is not exist", appVersion, {});
                    } else {

                        var field = {
                            is_notification: data.notification_status,
                            is_location: data.location_status
                        }
                        client.query('UPDATE users SET ? WHERE id = ? ', [field, data.user_id], function (error1, result1) {
                            if (error1) {
                                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                            } else {
                                Util.makeResponse(res, true, 200, "Status  Updated  Successfully", appVersion, []);
                            }
                        }
                        );
                    }

                }
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
     * @apiDescription http://203.123.36.134:30010/apiuser/v1/getNotification/
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
            client.query("select id,user_id,push_type,title,message,created_at from notification where user_id=? and is_deleted=?", [data.user_id,'0'], function (err, result) {
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
     * @apiDescription deleteNotification
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
    /************************************************************************ /getInfoPages ************************************************************************/
    /**
     * @api {get} /getInfoPages getInfoPages
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/api/v1/getInfoPages 
     * @apiGroup Static Page
     * @apiName getInfoPages
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      slug            page slug string (Terms & Condition=>'terms-and-condition' )
     * 
     *
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     * @apiVersion 1.0.0
     **/
    api.get('/getInfoPages', function (req, res) {
        var data = req.params;

        client.query("select id,title,content,is_active from tbl_info_pages where slug='" + data.slug + "'", function (error, result, fields) {
            if (error)
            {
                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
            }
            else if (result.length == 0)
            {
                Util.makeResponse(res, false, 404, "Sorry, no page found.", appVersion, {});
            }
            else if (result[0].is_active == '0')
            {
                Util.makeResponse(res, false, 404, "Sorry, You can't access this page.", appVersion, {});
            }
            else
            {
                Util.makeResponse(res, true, 200, "Page Found ", appVersion, result[0]);
            }
        });
    });

    /***************************************************************************************************************************************************************/
    /************************************************************************ /logout ************************************************************************/
    /**
     * @api {post} /logout logout
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription Logout
     * @apiGroup Customer
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

/*
 * get point details of particular social type
 */
function pointDetails(client, social_type)
{
    return new Promise(function (resolve, reject) {
        client.query("select * from points_details where source_of_point=?", [social_type], function (error, point_det) {


            if (error) {
                reject(error);
            }
            else {
                if (point_det.length > 0) {
                    var db_point = point_det[0].points;
                }
                else {
                    return false;
                }

                resolve(db_point);
            }

        });


    });
}

/*
 * This function is used to extract the count of user register with refferal code of particular user
 */

function usedRefferalCodeCount(client, user_id)
{

    return new Promise(function (resolve, reject) {
        client.query("select count(id) as user_count from users where reffered_by=?", [user_id], function (error, refferalCount) {
            if (error) {
                reject(error);
            }
            else {
                if (refferalCount.length > 0) {
                    var count = refferalCount[0].user_count;
                }
                else {
                    return false;
                }

                resolve(count);
            }

        });


    });
}




/*
 * This function is used to validate refferal code
 */

function validateRefferalCode(client, refferal_code)
{
    return new Promise(function (resolve, reject) {
        //console.log("select count(id) as user_count from users where refferal_code=?", [refferal_code]); return false;
        client.query("select id as user_id from users where refferal_code=?", [refferal_code], function (error, refferalCount) {
            if (error) {
                reject(error);
            }
            else {
                //console.log(refferalCount.length);return false;
                if ((refferalCount.length) == 0) {

                    var count = false;
                }
                else {
                    var count = true;
                }

                resolve(count);
            }

        });


    });
}


/*
 * get point details of particular social type
 */
function getUserConsultationType(client, appointmentId)
{
    return new Promise(function (resolve, reject) {
        client.query("select * from user_consultation_request where appointment_id=?", [appointmentId], function (error, consult_det) {


            if (error) {
                reject(error);
            }
            else {

                resolve(consult_det);
            }

        });


    });
}







