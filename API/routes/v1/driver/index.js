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


//     app.use(function (req, res, next) {
//
//        var language = req.param('language') || req.headers['language'];
//
//        if (language) {
//            if (config.LANG.avail_lang[req.headers.language]) {
//                app.set('lang', language);
//            } else {
//                app.set('lang', '1');// 1=> English, 2=>Chinese , 3 => Korean
//            }
//        } else {
//            // global.lng='en';
//            app.set('lang', '1');
//        }
//        next();
//    });





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
     * @apiDescription http://203.123.36.134:7777/api/v1/check
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
        Util.makeResponse(res, true, 200, 'Welcome to the coolest API of Driver app!',appVersion, []);
    });



    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i)
            result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }





    /***************************************************************************************************************************************************************/
    /************************************************************************ /login ************************************************************************/
    /**
     * @api {post} /login login
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/login/
     * @apiGroup Driver
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
     *     @apiSuccess {Object}                Result             {
     *     "success": true,
     *     "status": 200,
     *     "message": "Logged in successfully",
     *     "api_version": "1.0",
     *     "data":
     *    {
     *    "driverId": 1,
     *    "fullName": "ramnivash singh",
     *    "deviceToken": "43234dvdsv",
     *    "deviceType": "1",
     *    "email": "ram@gmail.com",
     *    "contactNumber":2147483647,
     *    "profileImage":"http:google.com",
     *    "token":"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicmFtbml2YXNoIHNpbmdoIiwiZW1haWwiOiJyYW1AZ21haWwuY29tIiwiaWF0IjoxNTAzMzE0MzgwLCJleHAiOjE1MDM0MDA3ODB9.6jQRn5vG9Tg7Nwruave97SoTnNYhNAqsZHVYOs8vOkY","shiftId": 9,
     "expiresIn":86400
     *   }
     
     * }
     * @apiVersion 1.0.0
     **/

    api.post('/login', function (req, res) {
        var date = moment.utc().format('YYYY-MM-DD');
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
            client.query("select * from driver where email=? OR contact_number=?", [username, username], function (error, result, fields) {
                if (error) {
                    console.log(error)
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, {});
                } else if (req.body.email == '' || req.body.password == '') {
                    Util.makeResponse(res, false, 200, "Email or Password cannot be empty", appVersion, {});
                } else if (result.length == 0) {
                    Util.makeResponse(res, false, 200, " Email/Mobile does not exist",appVersion, {});
                } else if (result[0].is_email_verified == '0') {
                    Util.makeResponse(res, false, 200, "Sorry, your email id is not verified .", appVersion, {});
                } else if (result[0].is_approved == '0') {
                    Util.makeResponse(res, false, 200, "Sorry, your Account is pending for approval .",appVersion, {});
                } else {
                    client.query("select *,driverAvgRating(driver_id) as driver_avg_rating from driver where (email=? OR contact_number=?) AND password=? limit 1", [username, username, password], function (error2, result2, fields2) {
                        if (error2) {
                            Util.makeResponse(res, false, 500, "Something went wrongs",appVersion, {});

                        } else if (result2.length == 0) {
                            Util.makeResponse(res, false, 200, "Password is Incorrect", appVersion, {});

                        } else {
                            client.query('UPDATE driver SET device_token = ?, device_type=? WHERE id = ? ', [req.body.device_token, req.body.device_type, result2[0].driver_id], function (error3, result3) {
                                var curdate = moment(new Date()).format("YYYY-MM-DD HH:mm:ss");

                                var token_keys = {
                                    "name": Util.checknull(result2[0].full_name),
                                    "email": Util.checknull(result2[0].email)
                                }
                                var token = jwt.sign(token_keys, app.get('superSecret'), {
                                    expiresIn: 86400 // expires in 24 hours
                                });

                                //shift id if shift is started for current date otherwise it is blank
                                client.query("select * from shift_clock where driver_id=? and date=?", [result2[0].driver_id, date], function (error, shiftresult) {
                                    if (error)
                                    {
                                        Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                                    }
                                    else if (shiftresult.length > 0)
                                    {
                                        var shift_id = shiftresult[0].shift_id;
                                    }
                                    else {
                                        var shift_id = 0;
                                    }


                                    var newData = {
                                        "driverId": Util.checknull(result2[0].driver_id),
                                        "fullName": Util.checknull(result2[0].full_name),
                                        "deviceToken": Util.checknull(req.body.device_token),
                                        "deviceType": Util.checknull(req.body.device_type),
                                        "email": Util.checknull(result2[0].email),
                                        "contactNumber": Util.checknull(result2[0].contact_number),
                                        "profileImage": Util.checknull(result2[0].profile_image),
                                        "dob": Util.checknull(result2[0].date_of_birth),
                                        "gender": Util.checknull(result2[0].gender),
                                        "location": Util.checknull(result2[0].location),
                                        "token": token,
                                        "shiftId": shift_id,
                                        "driver_avg_rating": Util.checknull(result2[0].driver_avg_rating),
                                        "notification_status":result[0].notification_status,
                                        "expiresIn": 86400
                                    };

                                    Util.makeResponse(res, true, 200, "login successfuly", appVersion, newData);
                                });



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
    /************************************************************************ /forgotPassword ************************************************************************/
    /**
     * @api {post} /forgotPassword forgotPassword
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription forgotPassword
     * @apiGroup Driver
     * @apiName forgotPassword
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      email              Email Id string
     * 
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( 0 for error, 1 for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
   * {
   * "success": true,
   * "status": 200,
   * "message": "For furthur steps please check your email.",
   * "api_version": "1.0.0",
   * "data": {}
   * }
     * @apiVersion 1.0.0
     **/

    api.post('/forgotPassword', function (req, res) {
        var data = req.body;
        var email = data.email;
        client.query("select * from driver where email=?", [email], function (error, result, fields)     {
            if (error)
            {
                Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
            }
            else if (result.length == 0)
            {
                Util.makeResponse(res, false, 404, "Sorry, user is not found.", appVersion,{});
            }
            else
            {
                //send change password link to the registered email id
                var rand = require('random-seed').create();
                var token = md5(rand(9999)); // generate a random number between 0 - 9999 
                console.log("string== :" + token);
                //save token in database for respective driver
                client.query('UPDATE driver SET token = ? where driver_id = ?', [token, result[0].driver_id], function (err2, result2) {
                    if (err2) {
                        Util.makeResponse(res, success, status, message, appVersion, data);
                    } else {
                        //send email
                        var activationUrl = req.protocol + '://' + req.get('host') + '/recovery/?email=' + result[0].email + '&activkey=' + token;           //send mail
                        //var from="register@gogivet.com";
                        var from = "ramnivash@tecaheadcorp.com";
                        var res2 = Util.sendMailSMTP(email, 'You have requested the password recovery', 'You have requested the password recovery. To receive a new password, please click on the link <a href="' + activationUrl + '">Click Here</a>', from);
                        Util.makeResponse(res, true, 200, "For furthur steps please check your email.", appVersion, {});

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

        var token = req.param('x-driverapp-token') || req.headers['x-driverapp-token'];
        // decode token
        if (token) {
            // verifies secret and checks expf.
            jwt.verify(token, app.get('superSecret'), function (err, decoded) {
                if (err) {
                    console.log(err)
                    Util.makeResponse(res, false, 401, 'Authentication failed. Invalid Token.', appVersion, [])
                } else {
                    // if everything is good, save to request for use in other routes
                    req.decoded = decoded;
                    next();
                }
            });
        } else {
            Util.makeResponse(res, false, 403, 'No token provided.', appVersion, [])
        }
    });


    // ---------------------------------------------------------
    // authenticated routes
    // ---------------------------------------------------------


    /***************************************************************************************************************************************************************/
    /************************************************************************ /startShift ************************************************************************/
    /**
     * @api {post} /startShift startShift
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/startShift/
     * @apiGroup Manage Shift
     * @apiName startShift
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiVersion 1.0.0
     **/

    api.post('/startShift', function (req, res) {
        var data = req.body;
        // timestamp with UTC time
        //console.log(moment.utc().format('ddd MMM DD YYYY HH:mm:ss z'));
        var date = moment.utc().format('YYYY-MM-DD');
        var start_time = moment.utc().format('HH:mm');
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Invalid driver id' // Error message for the parameter 
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select * from driver where driver_id=?", [data.driver_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 404, "Sorry, user is not found.", appVersion, {});
                }
                else {
                    client.query("select * from shift_clock where driver_id=? and date=?", [data.driver_id, date], function (error, result, fields) {
                        if (error)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                        }
                        else if (result.length > 0)
                        {
                            Util.makeResponse(res, false, 404, "Sorry,you already started the shift for today.", appVersion, {});
                        }
                        else {
                            client.query("INSERT INTO shift_clock SET ?", {'start_time': start_time, 'driver_id': data.driver_id, 'date': date, }, function (error2, result2, fields2) {
                                if (error2) {
                                    Util.makeResponse(res, success, status, message, appVersion, data);
                                } else {

                                    var finaldata=
                                            {"start_time": start_time, "end_time": "00:00", "date": date, "shift_id": result2.insertId, "driver_id": data.driver_id,"total_break_time":'',"breakDetails": []}


                                    Util.makeResponse(res, true, 200, "Your shift is started.", appVersion, finaldata);

                                }
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
    /************************************************************************ /endShift ************************************************************************/
    /**
     * @api {post} /endShift endShift
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/endShift/
     * @apiGroup Manage Shift
     * @apiName endShift
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiVersion 1.0.0
     **/

    api.post('/endShift', function (req, res) {
        var data = req.body;
        // timestamp with UTC time
        //console.log(moment.utc().format('ddd MMM DD YYYY HH:mm:ss z'));
        var date = moment.utc().format('YYYY-MM-DD');
        var end_time = moment.utc().format('HH:mm');
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Invalid driver id' // Error message for the parameter 
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select * from driver where driver_id=?", [data.driver_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 404, "Sorry, user is not found.", appVersion, {});
                }
                else {
                    client.query("select * from shift_clock where driver_id=? and date=? and end_time!='00:00:00'", [data.driver_id, date], function (error, result, fields) {
                        if (error)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
                        }
                        else if (result.length > 0)
                        {
                            Util.makeResponse(res, false, 404, "Sorry,you already end the shift for today.", appVersion, {});
                        }
                        else {

                            client.query("select start_time from shift_clock where driver_id=? and date=? and end_time='00:00:00'", [data.driver_id, date], function (error, result1) {
                                var startTime = result1[0].start_time;
                                var endTime = end_time;
                                var total_time = moment.utc(moment(endTime, "HH:mm").diff(moment(startTime, "HH:mm"))).format("HH:mm:ss");
                                client.query('UPDATE shift_clock SET end_time =?,total_time=? where driver_id = ? and date=?', [end_time, total_time, data.driver_id, date], function (err2, result2) {
                                    if (err2) {
                                        Util.makeResponse(res, success, status, message, appVersion, result2);
                                    } else {
                                    //remove this code after shift start api done
    //client.query('DELETE FROM shift_clock where driver_id = ? and date=?', [data.driver_id, date], function (err2, result2) {
                                        
    //});

                                    //remove this code after shift start api done
                                        Util.makeResponse(res, true, 200, "Your shift is ended.", appVersion, {});

                                    }
                                });


                            });



                        }

                    });

                }


            });
        }, function (errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });
    });




    /***************************************************************************************************************************************************************/
    /************************************************************************ /getBreakInterval ************************************************************************/
    /**
     * @api {get} /getBreakInterval getBreakInterval
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getBreakInterval/
     * @apiGroup Manage Shift
     * @apiName getBreakInterval
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiSuccess {json} Success-Response
     {
    "success": true,
    "status": 200,
    "message": "Success",
    "api_version": "1.0.0",
    "data": [
      {
    "id": 1,
    "time_minute": "00:05:00"
    },
      {
    "id": 2,
    "time_minute": "00:10:00"
    },
      {
    "id": 3,
    "time_minute": "00:15:00"
    }
    ],
    }
     * @apiVersion 1.0.0
     **/

    api.get('/getBreakInterval', function (req, res) {
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select id,time_minute from break_interval where status='1'", function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);

                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found",appVersion, []);
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Success",appVersion, result);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /startBreak************************************************************************/
    /**
     * @api {post} /startBreak startBreak
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/startBreak/
     * @apiGroup Manage Shift
     * @apiName startBreak
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id             driver_id string
     * @apiParam (Expected parameters) {String}      shift_id              shift_id string
     * @apiParam (Expected parameters) {String}      break_type            shift_id(5,10,15) string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiVersion 1.0.0
     **/

    api.post('/startBreak', function (req, res) {
        var data = req.body;
        var date = moment.utc().format('YYYY-MM-DD');
        var start_time = moment.utc().format('HH:mm');
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Invalid driver id'
                        // Error message for the parameter 
            },
            'shift_id': {
                notEmpty: true,
                errorMessage: 'Invalid Shift Id' // Error message for the parameter 
            },
            'break_type': {
                notEmpty: true,
                errorMessage: 'Invalid Break Type' // Error message for the parameter 
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            //get break type by break id
            
             getbreakType(client, data.break_type).then(function (time) {
               //console.log(time); return false;  
            client.query("select * from shift_clock where shift_id=? and date=?", [data.shift_id, date], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong1",appVersion, {});
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 404, "Sorry, shift id is not found.",appVersion, {});
                }
                else {
                    client.query("select * from break_clock where shift_id=? and date=?", [data.shift_id, date], function (error, result, fields) {
                        if (error)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong2",appVersion, {});
                        }
                        else if (result.length <= 0)
                        {

                     client.query("INSERT INTO break_clock SET ?", {'start_time': start_time, 'date': date, shift_id: data.shift_id, break_type:time, driver_id: data.driver_id}, function (error2, result2, fields2) {
                                if (error2) {
                                     console.log(error2);
                                    Util.makeResponse(res, success, status, message, appVersion, data);
                                } else {
                                    Util.makeResponse(res, true, 200, "Your Break is started.", appVersion, {});

                                }
                            });


                        }
                        else {
                            client.query("select * from break_clock where shift_id=? and date=? and end_time='00:00:00'", [data.shift_id, date], function (error3, result3, fields) {
                                if (error3) {
                                  
                                    Util.makeResponse(res, success, status, message, appVersion, data);
                                }
                                else {
                                    if (result3.length > 0) {
                                        Util.makeResponse(res, true, 200, "Sorry,Your break is already started.",appVersion, {});
                                    }
                                    else {
                                        client.query("INSERT INTO break_clock SET ?", {'start_time': start_time, 'date': date, shift_id: data.shift_id, break_type:time, driver_id: data.driver_id}, function (error2, result2, fields2) {
                                            if (error2) {
                                                 
                                                Util.makeResponse(res, success, status, message, appVersion, data);
                                            } else {
                                                Util.makeResponse(res, true, 200, "Your break is  started.",appVersion, {});

                                            }
                                        });


                                    }


                                }
                            });



                        }

                    });

                }


            });
             });
        }, function (errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });
    });





    /***************************************************************************************************************************************************************/
    /************************************************************************ /endBreak************************************************************************/
    /**
     * @api {post} /endBreak endBreak
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/endBreak/
     * @apiGroup Manage Shift
     * @apiName endBreak
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id             driver_id string
     * @apiParam (Expected parameters) {String}      shift_id              shift_id string
     * @apiParam (Expected parameters) {String}      break_type            shift_id(5,10,15) string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status (false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiVersion 1.0.0
     **/
    api.post('/endBreak', function (req, res) {
        var data = req.body;
        var date = moment.utc().format('YYYY-MM-DD');
        var end_time = moment.utc().format('HH:mm');
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Invalid driver id' // Error message for the parameter 
            },
            'shift_id': {
                notEmpty: true,
                errorMessage: 'Invalid Shift Id' // Error message for the parameter 
            },
           
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select * from shift_clock where shift_id=? and date=?", [data.shift_id, date], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, {});
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 404, "Sorry, shift id is not found.", appVersion, {});
                }
                else {
                    client.query("select * from break_clock where shift_id=? and date=? and end_time='00:00:00' order by break_id desc limit 1", [data.shift_id, date], function (error, result, fields) {
                        if (error)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, {});
                        }
                        else {
                            if (result.length > 0) {

                                var startTime = result[0].start_time;
                                var endTime = end_time;
                                var total_time = moment.utc(moment(endTime, "HH:mm").diff(moment(startTime, "HH:mm"))).format("HH:mm:ss");
                                client.query("UPDATE break_clock SET end_time=?,total_time=? WHERE break_id=?", [end_time, total_time, result[0].break_id], function (error1, result1, fields1) {
                                    if (error1) {
                                        Util.makeResponse(res, false, 500, "Something went wrong",appVersion);
                                    }
                                    else {
                                        Util.makeResponse(res, true, 200, "Your break is  ended.",appVersion, {});
                                    }

                                });
                            }
                            else {
                                Util.makeResponse(res, false, 200, "Please start your break first.",appVersion, {});
                            }

                            //console.log(result); return false;
                        }


                    });

                }


            });
        }, function (errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });
    });



   
    /***************************************************************************************************************************************************************/
    /************************************************************************ /currentBreakDetails ************************************************************************/
    /**
     * @api {post} /currentBreakDetails currentBreakDetails
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/currentBreakDetails/
     * @apiGroup Manage Shift
     * @apiName currentBreakDetails
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     * @apiParam (Expected parameters) {String}      shift_id               shift_id string
     
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
    "start_time": "11:40",
    "end_time": "00:00",
    "date": "2017-12-22",
    "break_type": "15"
    }
    }
     * @apiVersion 1.0.0
     **/

    api.post('/currentBreakDetails', function (req, res) {
        var shiftData = {};
         var date = moment.utc().format('YYYY-MM-DD');
        var data = req.body;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
            'shift_id': {
                notEmpty: true,
                errorMessage: 'Shift Id is Required'
            }
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            
            
//            console.log("select DATE_FORMAT(start_time,'%H:%i') AS start_time,DATE_FORMAT(end_time,'%H:%i') AS end_time from break_clock where shift_id=? and driver_id=? and date=? and end_time='00:00:00' order by break_id desc", [data.shift_id,data.driver_id,date]);return false;
        client.query("select DATE_FORMAT(start_time,'%H:%i') AS start_time,DATE_FORMAT(end_time,'%H:%i') AS end_time,DATE_FORMAT(date,'%Y-%l-%d') AS date,DATE_FORMAT(break_type,'%H:%i') AS break_type from break_clock where shift_id=? and driver_id=? and date=? and end_time='00:00:00' order by break_id desc", [data.shift_id,data.driver_id,date], function (err, result1) {
            if(err){
            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});    
            }else if(result1.length==0){
             Util.makeResponse(res, false, 200, "No data found",appVersion,{});   
            }
            else{
             Util.makeResponse(res, true, 200, "Success",appVersion,result1[0]);
            }
});    
           
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });





    /***************************************************************************************************************************************************************/
    /************************************************************************ /getShiftDetails ************************************************************************/
    /**
     * @api {get} /getShiftDetails getShiftDetails
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getShiftDetails/
     * @apiGroup Manage Shift
     * @apiName getShiftDetails
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     * @apiParam (Expected parameters) {String}      shift_id               shift_id string
     
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
    "start_time": "12:37",
    "end_time": "20:00",
    "date": "2017-12-11",
    "shift_id": 9,
    "driver_id": 1,
    "total_break_time": "00:03:20",
    "breakDetails": [
      {
    "start_time": "11:09",
    "end_time": "11:10"
    },
      {
    "start_time": "11:40",
    "end_time": "11:41"
    }
    ],
    }
    }
     
     * @apiVersion 1.0.0
     **/

    api.get('/getShiftDetails', function (req, res) {
        var shiftData = {};
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
            'shift_id': {
                notEmpty: true,
                errorMessage: 'Shift Id is Required'
            },
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            //var userData=[];
            client.query("select DATE_FORMAT(start_time,'%H:%i') AS start_time,DATE_FORMAT(end_time,'%H:%i') AS end_time,date,shift_id,driver_id,(select IFNULL(SEC_TO_TIME(SUM(total_time)),'') from break_clock where shift_id='"+data.shift_id+"') as total_break_time from shift_clock where shift_id=? and driver_id=?", [data.shift_id,data.driver_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found",appVersion, {});
                }
                else
                {
                    shiftData = result[0];
                    client.query("select DATE_FORMAT(start_time,'%H:%i') AS start_time,DATE_FORMAT(end_time,'%H:%i') AS end_time from break_clock where shift_id=?", [data.shift_id], function (err, result1) {
                        shiftData.breakDetails = result1;
                        Util.makeResponse(res, true, 200, "Success",appVersion, shiftData);
                           });
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });


    });





    /***************************************************************************************************************************************************************/
    /************************************************************************ /getOrderDetails ************************************************************************/
    /**
     * @api {get} /getOrderDetails getOrderDetails
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getOrderDetails/
     * @apiGroup Order
     * @apiName getOrderDetails
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     * @apiParam (Expected parameters) {String}      order_id               order_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
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
    "order_id": 123,
    "driver_id": 1,
    "delivery_time": "13:30",
    "pickup_location": "new delhi",
    "drop_location": "noida sector 62",
    "order_date": "2017-08-27T18:30:00.000Z",
    "order_status": "2",
    "orderItems": [
      {
    "driverHoldQty": 100,
    "order_qty": 1,
    "item_id": 1,
    "item_name": "Digital Dream",
    "item_unit": "1",
    "item_image": "http://instacraft1.s3.amazonaws.com//get-in-touch-red85_1507024856.png",
    "price_one": "800",
    "price_eigth": "800",
    "weight": "100",
    "categories": " Flowers, THC, Flowers"
    },
      {
    "driverHoldQty": 22,
    "order_qty": 2,
    "item_id": 2,
    "item_name": "Digital Dreem edited",
    "item_unit": "1",
    "item_image": "http://instacraft1.s3.amazonaws.com//erica-louise25_1507027094.jpg",
    "price_one": "1200",
    "price_eigth": "1200",
    "weight": "30",
    "categories": " Sativa, THC, Flowers"
    }
    ],
    }
    } 
     * @apiVersion 1.0.0
     **/
    api.get('/getOrderDetails', function (req, res) {
        var orderData = {};
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
            'order_id': {
                notEmpty: true,
                errorMessage: 'Order Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            //var userData=[];
            client.query("select users.first_name,users.last_name,users.profile_pic,order_id,driver_id,DATE_FORMAT(delivery_time,'%H:%i') as delivery_time,pickup_location,drop_location,order_date as order_date,order_status from driver_assigned_order left join users on driver_assigned_order.user_id=users.id where order_id=? and driver_id=?", [data.order_id, data.driver_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);

                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found",appVersion, {});
                }
                else
                {
                    orderData = result[0];
                    client.query("select itemQtyIsAvailable(" + data.driver_id + ",orderitem.item_id) as driverHoldQty,orderitem.order_qty as order_qty,items.item_id,items.item_name,items.item_unit,items.item_image,items.price_one,items.price_eigth,items.weight,categoryNamesByItemId(items.item_id) as categories from order_items as orderitem left join items on orderitem.item_id=items.item_id where orderitem.order_id=?", [data.order_id], function (err, result1) {
                        orderData.orderItems = result1;
                        Util.makeResponse(res, true, 200, "Success",appVersion, orderData);
                    });
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /getDriverInventory ************************************************************************/
    /**
     * @api {get} /getDriverInventory getDriverInventory
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getDriverInventory/
     * @apiGroup Inventory
     * @apiName getDriverInventory
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiSuccess {json} Success-Response
     *{
    *"success": true,
    *"status": 200,
    *"message": "Success",
    *"api_version": "1.0",
    *"data": [
     * {
    *"warehose_name": "Warehouse1",
    *"warehouse_id": 1,
    *"items": [
     * {
    *"item_id": 1,
    *"hold_qty": 90,
    *"warehouse_id": 1,
    *"category_name": "category1",
    *"item_unit": "1",
    *"item_name": "Digital Dream"
    *},
     * {
    *"item_id": 2,
    *"hold_qty": 10,
    *"warehouse_id": 1,
    *"category_name": "category2",
    *"item_unit": "1",
    *"item_name": "Digital Dreem1"
    *}
    *],
    *},
     * {
    *"warehose_name": "Warehose2",
    *"warehouse_id": 2,
    *"items": [
     * {
    *"item_id": 2,
    *"hold_qty": 10,
    *"warehouse_id": 2,
    *"category_name": "category2",
    *"item_unit": "1",
    *"item_name": "Digital Dreem1"
    *}
    *],
    *}
    *],
    *}
     * @apiVersion 1.0.0
     **/
    api.get('/getDriverInventory', function (req, res) {
        var orderData = {};
        var dataasync = [];
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            var dataRecord = [];
            waterfall([
                function (callback) {
                    client.query("select driver_inventory.warehouse_id,warehouse.name from driver_inventory left join warehouse on driver_inventory.warehouse_id=warehouse.id where driver_id=? group by driver_inventory.warehouse_id", [data.driver_id], function (err, result) {
                        if (err)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);

                        }
                        else if (result.length == 0)
                        {
                            //console.log(result); return false;
                            Util.makeResponse(res, false, 200, "No record found",appVersion, []);
                        }
                        else
                        {

                            dataasync.warehoseDetails = result;
                            callback(null, dataasync);
                        }
                    });
                },
                function (arg1, callback) {
                    var warehose = [];
                    //console.log(dataasync.warehoseDetails);

                    each(dataasync.warehoseDetails, function (item, next) {
                   //console.log("select driver_inventory.item_id,driver_inventory.item_quantity as hold_qty,driver_inventory.warehouse_id,category.name as category_name,items.item_unit as item_unit,items.item_name from driver_inventory left join items on driver_inventory.item_id=items.item_id join category on category.category_id=items.category_id where warehouse_id=?", [item.warehouse_id]);return false;
     client.query("select driver_inventory.item_id,driver_inventory.item_quantity as hold_qty,driver_inventory.warehouse_id,items.item_unit as item_unit,items.item_name,items.weight,categoryNamesByItemId(items.item_id) as category,items.item_image from driver_inventory left join items on driver_inventory.item_id=items.item_id where warehouse_id=?", [item.warehouse_id], function (err, result1) {
                            console.log(item);
                            var total = {
                                warehose_name: item.name,
                                warehouse_id: item.warehouse_id,
                                items: result1
                            };
                            warehose.push(total);
                            next("", total);
                        });

                    }, function (err, transformedItems) {
                        if (err)
                            throw err;
                        callback(null, warehose);
                    });
                }
            ],
                    function (err, result)
                    {
                        if (err)
                        {
                            console.log(err);
                            Util.makeResponse(res, false, 500, 'Something went wrong.', '1.0', []);
                        }
                        else
                        {

                            if ((result).length > 0)
                            {
                                Util.makeResponse(res, true, 200, 'Success', '1.0', result);
                            }
                            else
                            {
                                Util.makeResponse(res, true, 404, 'No Item Found.', '1.0', []);
                            }
                        }
                    });


        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });


    });





    /***************************************************************************************************************************************************************/
    /************************************************************************ /getDeliveryHistory ************************************************************************/
    /**
     * @api {get} /getDeliveryHistory getDeliveryHistory
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getDeliveryHistory/
     * @apiGroup Order
     * @apiName getDeliveryHistory
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiSuccess {json} Success-Response
     * {
     * "success": true,
     * "status": 200,
     * "message": "Success",
     * "api_version": "1.0.0",
     * "data": [
     *{
     * "order_id": 123,
     * "driver_id": 1,
     * "delivery_time": "13:30",
     * "pickup_location": "new delhi",
     * "drop_location": "noida sector 62",
     * "order_date": "2017-12-28",
     * "order_status": "6"
     * }
     * ],
     * }
     
     * @apiVersion 1.0.0
     **/
    api.get('/getDeliveryHistory', function (req, res) {
        var orderData = {};
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            }
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            //var userData=[];      
            client.query("select order_id,driver_id,DATE_FORMAT(delivery_time,'%H:%i') as delivery_time,pickup_location,drop_location,order_date as order_date,order_status from driver_assigned_order where driver_id=? and order_status=?", [data.driver_id, '6'], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);

                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found", appVersion, []);
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Success",appVersion, result);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });





    /***************************************************************************************************************************************************************/
    /************************************************************************ /getMyStats ************************************************************************/
    /**
     * @api {get} /getMyStats getMyStats
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getMyStats/
     * @apiGroup Order
     * @apiName getMyStats
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     * @apiParam (Expected parameters) {String}      from_date              from_date(UTC) string
     * @apiParam (Expected parameters) {String}      to_date                to_date(UTC) string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiSuccess {json} Success-Response
     *{
     *"success": true,
     *"status": 200,
     *"message": "Success",
     *"api_version": "1.0.0",
     *"data": [
     *  {
     *"total_delivery": "2",
     *"total_shift_time": "08:30:00",
     *"total_break_time": "00:03:20",
     *"total_break_taken": "2"
     *}
     *],
     *}
     
     * @apiVersion 1.0.0
     **/

    api.get('/getMyStats', function (req, res) {
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
            'from_date': {
                notEmpty: true,
                errorMessage: 'From Date is Required'
            },
            'to_date': {
                notEmpty: true,
                errorMessage: 'To Date is Required'
            },
        };
       
        req.checkQuery(schema);
        console.log("select totalDeliveredOrder('" + data.from_date + "','" + data.to_date + "','" + data.driver_id + "') as total_delivery,totalShiftTime('" + data.from_date + "','" + data.to_date + "','" + data.driver_id + "') as total_shift_time,totalBreakTime('" + data.from_date + "','" + data.to_date + "','" + data.driver_id + "') as total_break_time,totalBreakCount('" + data.from_date + "','" + data.to_date + "','" + data.driver_id + "') as total_break_taken,deliveredOnTimePercentage('" + data.driver_id + "') as delivered_on_time,driverActivePercentage('" + data.driver_id + "') as driver_active_percentage,driverAvgRating('" + data.driver_id + "') as driver_avg_rating,driverAvgDeliveryTime('" + data.driver_id + "') as avg_delivery_time,driverAvgStopTime('" + data.driver_id + "') as avg_stop_time,getDriverGrade('" + data.driver_id + "') as driver_grade from driver_assigned_order where order_status='6' and (order_date BETWEEN '" + data.from_date + "' AND '" + data.to_date + "') and driver_id=? group by order_date", [data.driver_id]);
        req.asyncValidationErrors().then(function () {
            client.query("select totalDeliveredOrder('" + data.from_date + "','" + data.to_date + "','" + data.driver_id + "') as total_delivery,totalShiftTime('" + data.from_date + "','" + data.to_date + "','" + data.driver_id + "') as total_shift_time,totalBreakTime('" + data.from_date + "','" + data.to_date + "','" + data.driver_id + "') as total_break_time,totalBreakCount('" + data.from_date + "','" + data.to_date + "','" + data.driver_id + "') as total_break_taken,deliveredOnTimePercentage('" + data.driver_id + "') as delivered_on_time,driverActivePercentage('" + data.driver_id + "') as driver_active_percentage,driverAvgRating('" + data.driver_id + "') as driver_avg_rating,driverAvgDeliveryTime('" + data.driver_id + "') as avg_delivery_time,driverAvgStopTime('" + data.driver_id + "') as avg_stop_time,getDriverGrade('" + data.driver_id + "') as driver_grade from driver_assigned_order where order_status='6' and (order_date BETWEEN '" + data.from_date + "' AND '" + data.to_date + "') and driver_id=? group by order_date", [data.driver_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);

                }
                else if (result.length == 0)
                {
                    
                    Util.makeResponse(res, false, 200, "No record found",appVersion, []);
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Success",appVersion, result);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });


    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /startOrder ************************************************************************/
    /**
     * @api {post} /startOrder startOrder
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription startOrder
     * @apiGroup Order
     * @apiName startOrder
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id             User Id string
     * @apiParam (Expected parameters) {String}      order_id              Order Id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     *{
     *"success": true,
     *"status": 200,
     *"message": "Start successfully",
     *"api_version": "1.0.0",
     *"data": {
     *"driver_id": "1",
     *"order_id": "123"
     *}
     *}
     
     * * @apiVersion 1.0.0
     **/
    api.post('/startOrder', function (req, res) {
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver ID is Required' // Error message for the parameter 
            },
            'order_id': {
                notEmpty: true,
                errorMessage: 'Order ID is Required' // Error message for the parameter 
            }

        };
        
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            var driver_id = data.driver_id;
            var order_id = data.order_id;
            var status = data.status;
            
            //update driver lat long
             var driverLat =req.headers['driverLat'];
             var driverLat =req.headers['driverLong'];
             var latlongField={
             latitude:driverLat,
             longitude:driverLat
             };
            client.query("UPDATE driver SET ? WHERE driver_id =?", [latlongField, data.driver_id], function (ltlongerr,latlongResult) {
           if (ltlongerr)
          {
            Util.makeResponse(res, false, 500, "Something went wrong on lat long updation", appVersion, []);
          }           
          });
            

            client.query("select * from driver where driver_id=?", [data.driver_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid Driver ID ",appVersion, []);
                }
                else
                {
                    var regFields = {
                        order_status: '2',
                    };
                    //console.log(regFields);
                    client.query("UPDATE driver_assigned_order SET ? WHERE driver_id =? and order_id=?", [regFields, data.driver_id, data.order_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else
                        {
                            
              client.query("UPDATE orders SET ? WHERE order_id=?", [regFields,data.order_id], function (error1, orderresult) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res, false, 500, "Something went wrong on inserting order table",appVersion, []);
                        }
                       
                    });  
                        
                            
                 Util.makeResponse(res, true, 200, "Start successfully", appVersion, req.body);
                        }
                    });
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });
    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /holdOrder ************************************************************************/
    /**
     * @api {post} /holdOrder holdOrder
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription holdOrder
     * @apiGroup Order
     * @apiName holdOrder
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              User Id string
     * @apiParam (Expected parameters) {String}      order_id               Order Id string
     * @apiParam (Expected parameters) {String}      reason_id              Reson Id string
     * @apiParam (Expected parameters) {String}      comment                Comment string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     *{
     *"success": true,
     *"status": 200,
     *"message": "Order have Hold successfully",
     *"api_version": "1.0.0",
     *"data": {
     *"driver_id": "1",
     *"order_id": "123"
     *}
     *}
     
     * * @apiVersion 1.0.0
     **/
    api.post('/holdOrder', function (req, res) {
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver ID is Required' // Error message for the parameter 
            },
            'order_id': {
                notEmpty: true,
                errorMessage: 'Order ID is Required' // Error message for the parameter 
            },
            'reason_id': {
                notEmpty: true,
                errorMessage: 'Reason ID is Required' // Error message for the parameter 
            },
            'comment': {
                notEmpty: true,
                errorMessage: 'Comment is Required' // Error message for the parameter 
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            var driver_id = data.driver_id;
            var order_id = data.order_id;
            var reason_id = data.reason_id;
            var comment = data.comment;

            client.query("select * from driver where driver_id=?", [data.driver_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid Driver ID ", appVersion, []);
                }
                else
                {
                    var regFields = {
                        order_status: '3',
                        hold_reason: data.reason_id,
                        hold_comment: data.comment,
                    };
                    //console.log(regFields);
                    client.query("UPDATE driver_assigned_order SET ? WHERE driver_id =? and order_id=?", [regFields, data.driver_id, data.order_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                        }
                        else
                        {
                            //notify to customer for hold code here
                            client.query("select user_id from orders WHERE order_id =? ", [data.order_id], function (error2, result2, fields2) {
                                if (error2) {
                                    console.log('error in query');
                                }
                                else {
                                    client.query("select device_type,device_token,phone_number,first_name from users WHERE id =? ", [result2[0].user_id], function (error3, result3, fields3) {
                                        var notification = {
                                            deviceToken: result3[0].device_token,
                                            messagePush: "Your order is hold by Driver",
                                            push_type: "3",
                                            count: 0
                                                    //notificationType:"hold",
                                                    //notificationTypeId:"dfdfdsfdsfds"
                                        }

                                        //Util.sendAndroidPush(notification);


                                    });

                                }

                            });
                            //end notification
                            //update order status in order table
                            client.query("UPDATE orders SET order_status=? WHERE order_id=?", [regFields.order_status,data.order_id], function (error2, result2, fields2) {
                        if (error2)
                        {
                            console.log(error2);
                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                        }
                        
                           Util.makeResponse(res, true, 200, "Hold successfully",appVersion, req.body);  
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
    /************************************************************************ /reachedOrder ************************************************************************/
    /**
     * @api {post} /reachedOrder reachedOrder
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription reachedOrder
     * @apiGroup Order
     * @apiName reachedOrder
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              User Id string
     * @apiParam (Expected parameters) {String}      order_id               Order Id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     *{
     *"success": true,
     *"status": 200,
     *"message": "Reached successfully",
     *"api_version": "1.0.0",
     *"data": {
     *"driver_id": "1",
     *"order_id": "123"
     *}
     *}
     
     * * @apiVersion 1.0.0
     **/
    api.post('/reachedOrder', function (req, res) {
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver ID is Required' // Error message for the parameter 
            },
            'order_id': {
                notEmpty: true,
                errorMessage: 'Order ID is Required' // Error message for the parameter 
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            var driver_id = data.driver_id;
            var order_id = data.order_id;
            client.query("select * from driver where driver_id=?", [data.driver_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid Driver ID ", appVersion, []);
                }
                else
                {
                    var regFields = {
                        order_status: '4'
                    };
                    //console.log(regFields);
                    client.query("UPDATE driver_assigned_order SET ? WHERE driver_id =? and order_id=?", [regFields, data.driver_id, data.order_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                        else
                        {
                            //notify to customer reached soon
                            
                            //update status in order table
                client.query("UPDATE orders SET ? WHERE order_id=?", [regFields,data.order_id], function (error2, result2, fields2) {
                        if (error2)
                        {
                            console.log(error2);
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                            
                            Util.makeResponse(res, true, 200, "Reached successfully", appVersion, req.body);
                        });
                        }
                    });
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });
    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /returnOrder ************************************************************************/
    /**
     * @api {post} /returnOrder returnOrder
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription returnOrder
     * @apiGroup Order
     * @apiName returnOrder
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              User Id string
     * @apiParam (Expected parameters) {String}      order_id               Order Id string
     * @apiParam (Expected parameters) {String}      reason                 Reason string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     *{
     *"success": true,
     *"status": 200,
     *"message": "Order Returned",
     *"api_version": "1.0.0",
     *"data": {
     *"driver_id": "1",
     *"order_id": "123"
     *}
     *}
     
     * * @apiVersion 1.0.0
     **/
    api.post('/returnOrder', function (req, res) {
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver ID is Required' // Error message for the parameter 
            },
            'order_id': {
                notEmpty: true,
                errorMessage: 'Order ID is Required' // Error message for the parameter 
            },
            'reason': {
                notEmpty: true,
                errorMessage: 'Reason is Required' // Error message for the parameter 
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            var driver_id = data.driver_id;
            var order_id = data.order_id;
            client.query("select * from driver where driver_id=?", [data.driver_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid Driver ID ", appVersion, []);
                }
                else
                {
                    var regFields = {
                        order_status: '5',
                        return_reason: data.reason
                    };
                    //console.log(regFields);
                    client.query("UPDATE driver_assigned_order SET ? WHERE driver_id =? and order_id=?", [regFields, data.driver_id, data.order_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                        }
                        else
                        {
                            
                        //update order status
                  client.query("UPDATE orders SET order_status=? WHERE order_id=?", [regFields.order_status,data.order_id], function (error2, result2) {
                        if (error2)
                        {
                            console.log(error2);
                            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);
                        }
                            Util.makeResponse(res, true, 200, "Return successfully",appVersion, req.body);
                             });
                        }
                    });
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });
    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /deliveredOrder ************************************************************************/
    /**
     * @api {post} /deliveredOrder deliveredOrder
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription deliveredOrder
     * @apiGroup Order
     * @apiName deliveredOrder
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              User Id string
     * @apiParam (Expected parameters) {String}      order_id               Order Id string
     * @apiParam (Expected parameters) {String}      idproof_url            Id Proof Url string
     * @apiParam (Expected parameters) {String}      cannabis_url           Cannabis Url string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     *{
     *"success": true,
     *"status": 200,
     *"message": "Order Returned",
     *"api_version": "1.0.0",
     *"data": {
     *"driver_id": "1",
     *"order_id": "123"
     *}
     *}
     
     * * @apiVersion 1.0.0
     **/
    api.post('/deliveredOrder', function (req, res) {
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver ID is Required' // Error message for the parameter 
            },
            'order_id': {
                notEmpty: true,
                errorMessage: 'Order ID is Required' // Error message for the parameter 
            },
            'idproof_url': {
                notEmpty: true,
                errorMessage: 'Document Url is Required' // Error message for the parameter 
            },
            'cannabis_url': {
                notEmpty: true,
                errorMessage: 'cannabis Url Url is Required' // Error message for the parameter 
            }

        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            var driver_id = data.driver_id;
            var order_id = data.order_id;
            client.query("select * from driver where driver_id=?", [data.driver_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid Driver ID ",appVersion, []);
                }
                else
                {
                    var regFields = {
                        order_status: '6',
                        idproof_url: data.idproof_url,
                        cannabis_url: data.cannabis_url
                    };
                    //console.log(regFields);
                    client.query("UPDATE driver_assigned_order SET ? WHERE driver_id =? and order_id=?", [regFields, data.driver_id, data.order_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                        }
                        else
                        {
                         //update order status
                          client.query("UPDATE orders SET order_status=? WHERE order_id=?", [regFields.order_status, data.order_id], function (error2,result2) {
                        if (error2)
                        {
                            console.log(error2);
                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                        }
                            Util.makeResponse(res, true, 200, "Delivered successfully",appVersion, req.body);
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
    /************************************************************************ /getStopList ************************************************************************/
    /**
     * @api {get} /getStopList getStopList
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getStopList/
     * @apiGroup Order
     * @apiName getStopList
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiSuccess {json} Success-Response
     {
    "success": true,
    "status": 200,
    "message": "Success",
    "api_version": "1.0.0",
    "data": [
      {
    "order_id": 123,
    "driver_id": 1,
    "delivery_time": "13:30",
    "pickup_location": "new delhi",
    "drop_location": "noida sector 62",
    "order_date": "2017-12-28",
    "first_name": "ram",
    "order_status": "1"
    },
      {
    "order_id": 124,
    "driver_id": 1,
    "delivery_time": "18:05",
    "pickup_location": "noida sector 62",
    "drop_location": "noida sector 15",
    "order_date": "2017-12-28",
    "first_name": "ram",
    "last_name": "nivash",
    "order_status": "1"
    }
    ],
    }
     
     * @apiVersion 1.0.0
     **/
    api.get('/getStopList', function (req, res) {
        var orderData = {};
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            }

        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            //var status = 'CASE order_status when "0" then "assigned" when "1"  then "Accepted" when "2"  then "Start" when "3" then "Hold" when "4" then "Reached" when "5" then "Return" when "6" then "Delivered" END as order_status';
            client.query("select order_id,driver_id,DATE_FORMAT(delivery_time,'%H:%i') as delivery_time,DATE_FORMAT(delivery_time,'%H:%i') as delivered_time,pickup_location,drop_location,drop_location_lat,drop_location_lang,pickup_location_lat,pickup_location_lang,order_date as order_date,users.first_name,users.last_name,users.profile_pic,order_status from driver_assigned_order left join users on driver_assigned_order.user_id=users.id  where driver_id="+data.driver_id+" and order_status !='3' and order_status !='5' and order_status !='6' order by order_status desc", function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something  1 went wrong",appVersion,[]);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res,false, 200, "No record found", appVersion, []);
                }
                else
                {
                    orderData= result;
                    Util.makeResponse(res, true, 200, "Success",appVersion, orderData);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });


    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /updateDriverInventory ************************************************************************/
    /**
     * @api {post} /updateDriverInventory updateDriverInventory
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription updateDriverInventory
     * @apiGroup Driver
     * @apiName updateDriverInventory
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id             User Id string
     * @apiParam (Expected parameters) {String}      items                 Array  string

     
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
    "message": "Qty updated successfully",
    "api_version": "1.0.0",
    "data": {
    "driver_id": "1",
    "item_id": "1",
    "warehouse_id": "1",
    "qty": "2"
    }
    }
     
     * * @apiVersion 1.0.0
     **/
//    api.post('/updateDriverInventory', function (req, res) {
//        var schema = {
//            'driver_id': {
//                notEmpty: true,
//                errorMessage: 'Driver ID is Required' // Error message for the parameter 
//            },
//            'item_id': {
//                notEmpty: true,
//                errorMessage: 'Item ID is Required' // Error message for the parameter 
//            },
//            'warehouse_id': {
//                notEmpty: true,
//                errorMessage: 'Warehouse ID is Required' // Error message for the parameter 
//            },
//            'qty': {
//                notEmpty: true,
//                errorMessage: 'Qty is Required' // Error message for the parameter 
//            }
//        };
//        req.checkBody(schema);
//        req.asyncValidationErrors().then(function () {
//            // all good here 
//            var data = req.body;
//            var driver_id = data.driver_id;
//            var item_id = data.item_id;
//            var warehouse_id = data.warehouse_id;
//
//            var qty = data.qty;
//            client.query("select * from driver_inventory where driver_id=? and warehouse_id=? and item_id=?", [data.driver_id, data.warehouse_id, data.item_id], function (error, result, fields) {
//                if (error)
//                {
//                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
//                }
//                else if (result.length == 0)
//                {
//                    Util.makeResponse(res, false, 200, "Sorry, Invalid Details ",appVersion, []);
//                }
//                else
//                {
//                    var date = moment.utc().format('YYYY-MM-DD MM:ss');
//                    var regFields = {
//                        item_quantity: parseInt(qty) + parseInt(result[0].item_quantity),
//                        approve_by_admin: '0',
//                        updated_at: date
//                    };
//                    //console.log(regFields);
//                    client.query("UPDATE driver_inventory SET ? WHERE driver_id = ? and warehouse_id=? and item_id=?", [regFields, data.driver_id, data.warehouse_id, data.item_id], function (error1, result1, fields1) {
//                        if (error1)
//                        {
//                            console.log(error1);
//                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
//                        }
//                        else
//                        {
//                            Util.makeResponse(res, true, 200, "Qty updated successfully",appVersion, req.body);
//                        }
//                    });
//                }
//            });
//        }, function (errors) {
//            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
//        });
//    });




 api.post('/updateDriverInventory', function (req, res) {
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver ID is Required' // Error message for the parameter 
            },
            'items': {
                notEmpty: true,
                errorMessage: 'Items is Required' // Error message for the parameter 
            }
            
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            var driver_id = data.driver_id;
            //var items=[{"item_id": "1","warehouse_id": "1",qty:"1"},{"item_id": "2","warehouse_id": "1",qty:"1"}]
                    each(data.items, function (item, next) {
                    client.query("select * from driver_inventory where driver_id=? and warehouse_id=? and item_id=?",[data.driver_id, item.warehouse_id, item.item_id], function (error, result, fields) {
                if (error)
                {
                Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid Details ",appVersion, []);
                }
                else
                {
                    var date = moment.utc().format('YYYY-MM-DD MM:ss');
                    var regFields = {
                        item_quantity: parseInt(item.qty) + parseInt(result[0].item_quantity),
                        approve_by_admin: '0',
                        updated_at: date
                    };
                    client.query("UPDATE driver_inventory SET ? WHERE driver_id = ? and warehouse_id=? and item_id=?", [regFields, data.driver_id, item.warehouse_id, item.item_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res,false,500,"Something went wrong",appVersion,[]);
                        }
                        else
                        {
                         next("", item);
                        }
                         
                    });
                }
            });
                   }, function (err, transformedItems) {
                            if (err)
                                throw err;
                            // callback(null, '');
                  Util.makeResponse(res, true, 200, "Quantity updated successfully",appVersion, req.body);
                 });

        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });
    });







    /***************************************************************************************************************************************************************/
    /************************************************************************ /getProfile ************************************************************************/
    /** 
     * @api {get} /getProfile getProfile
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getProfile/
     * @apiGroup Driver
     * @apiName getProfile
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
    * {
    * "success": true,
    *"status": 200,
    * "message": "Success",
    * "api_version": "1.0.0",
    * "data": {
    * "personalInfo": {
    * "email": "ramnivash@techaheadcorp.com",
    * "contact_number": 2147483647,
    * "full_name": "ram nivash",
    * "date_of_birth": "1987-09-07T18:30:00.000Z",
    * "gender": "1",
    * "location": "delhi"
    * },
    * "professionalInfo": {
    * "document_type": "Licence",
    * "document_id": "",
    * "vehicle_make": "878LKI",
    * "vehicle_model_type": "123",
    * "registration_number": "1112245",
    * "license_number": "sdfdsf44545",
    * "expiration_date": "2017-08-07T18:30:00.000Z"
    * }
    * }
    * }
     
     * @apiVersion 1.0.0
     **/

    api.get('/getProfile', function (req, res) {
        var userData = {};
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            //var userData=[];
            client.query("select email,contact_number,full_name,date_of_birth as dob,gender,location,profile_image from driver where driver_id=?", [data.driver_id], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);

                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found",appVersion, []);
                }
                else
                {
                    var personalInfo = {};
                    userData.personalInfo = result[0];
                    client.query("select document_name as document_type,document_id,vehicle_make,vehicle_model_type,registration_number,license_number,expiration_date from driver_professional_detail where driver_id=?", [data.driver_id], function (err, result1) {
                        userData.professionalInfo = result1[0];
                        Util.makeResponse(res, true, 200, "Success", appVersion, userData);
                    });


                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });


    });

    /***************************************************************************************************************************************************************/
    /************************************************************************ /editProfile ************************************************************************/
    /**
     * @api {post} /editProfile editProfile
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription editProfile
     * @apiGroup Driver
     * @apiName editProfile
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id             User Id string
     * @apiParam (Expected parameters) {String}      full_name             Full Name string
     * @apiParam (Expected parameters) {String}      phone_number          phone_number string
     * @apiParam (Expected parameters) {String}      location              Address string
     * @apiParam (Expected parameters) {String}      date_of_birth         date_of_birth(1987-09-09) string
     * @apiParam (Expected parameters) {Number}      gender                0=nil 1=male 2=female 3=other
     
     
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {Number=0,1}            Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
        * {
        * "success": true,
        * "status": 200,
        * "message": "Profile updated successfully",
        * "api_version": "1.0.0",
        * "data": {
        * "personalInfo": {
        * "email": "ramnivash@techaheadcorp.com",
        * "contact_number": 2147483647,
        * "full_name": "ram nivash",
        * "date_of_birth": "1987-09-07T18:30:00.000Z",
        * "gender": "1",
        * "location": "delhi"
        * },
        * "professionalInfo": {
        * "document_type": "Licence",
        * "document_id": "",
        * "vehicle_make": "878LKI",
        * "vehicle_model_type": "123",
        * "registration_number": "1112245",
        * "license_number": "sdfdsf44545",
        * "expiration_date": "2017-08-07"
        * }
        * }
        * }
     
     * * @apiVersion 1.0.0
     **/
    api.post('/editProfile', function (req, res) {
       var userData = {};
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver ID is Required' // Error message for the parameter 
            }
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            // all good here 
            var data = req.body;
            var driver_id = data.driver_id;
            var full_name = data.full_name;
            var contact_number = data.phone_number;
            var location = data.location;
            var gender = data.gender;
            var date_of_birth = data.date_of_birth;
            var device_token = data.device_token || "";
            var device_type = data.device_type || 1;
            client.query("select * from driver where driver_id=?", [data.driver_id], function (error, result, fields) {
                if (error)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "Sorry, Invalid Driver ID ",appVersion, []);
                }
                else
                {
                    var regFields = {
                        'full_name': full_name,
                        'contact_number': contact_number,
                        'location': location,
                        'gender': gender,
                        'date_of_birth': date_of_birth
                    };
                    //console.log(regFields);
                    client.query("UPDATE driver SET ? WHERE driver_id = ?", [regFields, data.driver_id], function (error1, result1, fields1) {
                        if (error1)
                        {
                            console.log(error1);
                            Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                        }
                        else
                        {
                            
                           client.query("select email,contact_number,full_name,date_of_birth,gender,location from driver where driver_id=?", [data.driver_id], function (err, profileresult) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion,[]);

                }
                else if (profileresult.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found", appVersion, []);
                }
                else
                {
                    var personalInfo = {};
                    userData.personalInfo = profileresult[0];
                    
                    client.query("select document_name as document_type,document_id,vehicle_make,vehicle_model_type,registration_number,license_number,expiration_date from driver_professional_detail where driver_id=?", [data.driver_id], function (err, proresult) {
                        userData.professionalInfo = proresult[0];
                        Util.makeResponse(res, true, 200, "Profile updated successfully", appVersion, userData);
                    });


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
    /************************************************************************ /changePassword ************************************************************************/
    /**
     * @api {post} /changePassword changePassword
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/api/v1/changePassword/
     * @apiGroup Driver
     * @apiName changePassword
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      current_password     password string
     * @apiParam (Expected parameters) {String}      new_password         password string
     * @apiParam (Expected parameters) {String}      driver_id            driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success           response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     *  {
     *  "success": true,
     *  "status": 200,
     *  "message": "Password Updated Successfully",
     *  "api_version": "1.0.0",
     *  "data": {
     *  "driver_id": 1,
     *  "expiresIn": 86400
     *  }
     *  }
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
            'driver_id': {
                notEmpty: true,
                errorMessage: 'please enter userId' // Error message for the parameter 
            }


        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            //for checking password
            var data = req.body;
            client.query("select * from driver where driver_id=? ", [data.driver_id], function (error, result) {
                if (error) {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});

                } else {
                    var token_keys = {
                        'driver_id': data.driver_id,
                    }
                    var token = jwt.sign(token_keys, app.get('superSecret'), {
                        expiresIn: 86400 // expires in 24 hours
                    });

                    if (result[0].password == md5(data.current_password)) {
                        client.query('UPDATE driver SET password = ? WHERE driver_id = ? ', [(md5(data.new_password, 'hex')).toString(), result[0].driver_id], function (error1, result1) {
                            if (error1) {
                                Util.makeResponse(res, false, 500, "Something went wrong",appVersion, {});
                            } else {
                                var response = {
                                    "driver_id": result[0].driver_id,
                                    "expiresIn": 86400
                                };
                                Util.makeResponse(res, true, 200, "Password  Updated  Successfully",appVersion, response);
                            }

                        }
                        );

                    } else {
                        Util.makeResponse(res, false, 200, "Old password does not match ",appVersion, {});

                    }
                }
            });

        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });



    /***************************************************************************************************************************************************************/
    /************************************************************************ /contactUs ************************************************************************/
    /**
     * @api {get} /contactUs contactUs
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/contactUs/
     * @apiGroup Support
     * @apiName contactUs
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     * {
     * "success": true,
     * "status": 200,
     * "message": "Success",
     * "api_version": "1.0.0",
     *"data": {
     * "email": "support@gmail.com",
     * "contact_number": "8112314653"
     * }
     * }
     
     * @apiVersion 1.0.0
     **/

    api.get('/contactUs', function (req, res) {
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select email,contact_number from contact_support", function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, []);

                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found", appVersion, []);
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Success",appVersion, result[0]);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /contactUsQuery ************************************************************************/
    /**
     * @api {post} /contactUsQuery contactUsQuery
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/contactUsQuery/
     * @apiGroup Support
     * @apiName contactUsQuery
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     * @apiParam (Expected parameters) {String}      message                message string
     
     ****************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {json} Success-Response
     * {
     * "success": true,
     * "status": 200,
     * "message": "Your Query successfully inserted",
     * "api_version": "1.0.0",
     * "data": [],
     * }
     
     * @apiVersion 1.0.0
     **/

    api.post('/contactUsQuery', function (req, res) {
        var data = req.body;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
            'message': {
                notEmpty: true,
                errorMessage: 'Message is Required'
            },
        };
        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            client.query("INSERT INTO contact_us SET ?", {'message': data.message, 'driver_id': data.driver_id}, function (err, result, fields2) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Your Query successfully inserted", appVersion, []);
                }
            });
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request",appVersion, errors);
        });

    });

    /*****************************************************************************************/
    /***********************changeNotificationStatus******************************************/
    /*****************************************************************************************/
    /**
     * @api {post} /changeNotificationStatus changeNotificationStatus
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/api/v1/changeNotificationStatus/
     * @apiGroup Driver
     * @apiName changeNotificationStatus
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      status           status(0=>Off,1=>On) 
     * @apiParam (Expected parameters) {String}      driver_id        driver_id string
     
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
    api.post('/changeNotificationStatus', function (req, res) {
        var data = req.body;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
            'status': {
                notEmpty: true,
                errorMessage: 'Status is Required'
            }
        };

        req.checkBody(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select * from driver where driver_id=? ", [data.driver_id], function (error, result) {
                if (error) {
                    Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});

                } else {
                    if (result.length == 0) {
                        Util.makeResponse(res, false, 200, "This Driver is not exist",appVersion, {});
                    } else {
                        client.query('UPDATE driver SET notification_status = ? WHERE driver_id = ? ', [data.status, data.driver_id], function (error1, result1) {
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
    /************************************************************************ /reviewListing ************************************************************************/
    /**
     * @api {get} /reviewListing reviewListing
     * @apiHeader {String} Content-Type application/x-www-form-urlencoded.
     * @apiDescription http://203.123.36.134:30010/api/v1/reviewListing 
     * @apiGroup Driver
     * @apiName reviewListing
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              Driver id string
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
    "api_version": "1.0.0",
    "data": [
      {
    "avg_rating": 5,
    "title": "Current Month",
    "service_feedback": "Very good service"
    },
      {
    "avg_rating": 3,
    "title": "August",
    "service_feedback": "Very good service"
    }
    ],
    }
     * @apiVersion 1.0.0
     **/

    api.get('/reviewListing', function (req, res) {
        var data = req.query;
        var totaldata=[];
        //console.log(data); return false;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver ID is Required'
            },
        };

        /*** set page limit ***/
        var limit = 10;
        /*** Get Offset ***/
        var offset = 0;
        if (data.page && data.page != 0)
        {
            offset = (data.page * limit);
        }
        /*** Get Offset ***/
        req.checkQuery(schema);
        var currentutctime = moment(moment().add(320, 's')).unix() * 1000;
        var currenttime = moment(currentutctime).format('H:mm');
         var current_month = moment.utc().format('MM');
        //console.log(current_month); return false;
        req.asyncValidationErrors().then(function () {
            client.query("SELECT AVG(rating) AS avg, MONTHNAME(created_at) as month,MONTH(created_at) as monthdigit from driver_review_rating where is_deleted='0' and driver_id='" + data.driver_id + "' GROUP BY month order by created_at desc", function (err, result1) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);

                }
                else if (result1.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found", appVersion, []);
                }
                else
                {
                    
                 
                 each(result1, function (item, next) {
                 //console.log(item); return false;    
                 var totalitem={
                 avg_rating:item.avg,
                 title:item.monthdigit==current_month?'Current Month':item.month,
                 service_feedback:"Very good service"
                 };
                 totaldata.push(totalitem);
                 
                        
                 next("", item);        
                }, function (err, transformedItems) {
                if (err)
                throw err;
               // callback(null, '');
                });
                   
                   
               Util.makeResponse(res, true, 200, "Success",appVersion, totaldata);
                }
            });
        }, function (errors) {
            //console.log(errors)
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });
    });

    /***************************************************************************************************************************************************************/
    /************************************************************************ /getWeekDay ************************************************************************/
    /**
     * @api {get} /getWeekDay getWeekDay
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getWeekDay/
     * @apiGroup Support
     * @apiName getWeekDay
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
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
        "message": "Week start day",
        "api_version": "1.0.0",
        "data": {
        "name": "sunday",
        "value": "1"
        }
        }
     * @apiVersion 1.0.0
     **/

    api.get('/getWeekDay', function (req, res) {
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            }
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
           //
           var weekStartDay={name:"sunday",value:"1"};
           
           Util.makeResponse(res, true, 200, "Week start day",appVersion,weekStartDay);
           
        }, function (errors) {
            Util.makeResponse(res, false, 400, "Bad Request", appVersion, errors);
        });


    });



/***************************************************************************************************************************************************************/
    /************************************************************************ /getHoldReason ************************************************************************/
    /**
     * @api {get} /getHoldReason getHoldReason
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getHoldReason/
     * @apiGroup Order
     * @apiName getHoldReason
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiSuccess {json} Success-Response
     
     * @apiVersion 1.0.0
     **/

    api.get('/getHoldReason', function (req, res) {
        var data = req.query;
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
            client.query("select reason_id,reason from hold_reason", function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);

                }
                else if (result.length == 0)
                {
                    Util.makeResponse(res, false, 200, "No record found",appVersion, []);
                }
                else
                {
                    Util.makeResponse(res, true, 200, "Success",appVersion, result);
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
      * @apiDescription Logout
      * @apiGroup Driver
      * @apiName logout
      * ***************************************************************************************************************************************************************
      * @apiParam (Expected parameters) {String}      driver_id             Driver id string

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
      var data=req.body;
      client.query("select * from driver where driver_id="+data.driver_id+"",function (error, result) {
         if(error) 
         {
            Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
         }
         else if(result.length==0){
          Util.makeResponse(res, false, 500, "driver is not exist", appVersion, {});   
         }
         else
         { 
            client.query('UPDATE driver SET device_token = ? WHERE driver_id = ? ', ['',data.driver_id], function(error1, result1) {
               if(error1) 
               {
                  console.log(error1);
                  Util.makeResponse(res, false, 500, "Something went wrong", appVersion, {});
               } 
               else
               {
                  Util.makeResponse(res, true, 200, "Logged out successfully", appVersion,{});
               }
            });
                               
         }
      });         
   });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /getLaunchApi ************************************************************************/
    /**
     * @api {get} /getLaunchApi getLaunchApi
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:30010/api/v1/getLaunchApi/
     * @apiGroup Launch
     * @apiName getLaunchApi
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      driver_id              driver_id string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * @apiSuccess {json} Success-Response
     
     * @apiVersion 1.0.0
     **/

    api.get('/getLaunchApi', function (req, res) {
        var data = req.query;
        var totaldata={};
        var date = moment.utc().format('YYYY-MM-DD');
        var schema = {
            'driver_id': {
                notEmpty: true,
                errorMessage: 'Driver Id is Required'
            },
        };
        req.checkQuery(schema);
        req.asyncValidationErrors().then(function () {
     client.query("select shift_id,end_time,driverAvgRating('"+data.driver_id+"') as driver_avg_rating from shift_clock where driver_id=? and date=?",[data.driver_id,date], function (err, result) {
                if (err)
                {
                    Util.makeResponse(res, false, 500, "Something went wrong",appVersion, []);
                }
                else if (result.length == 0)
                {
                totaldata.shift_id=0;
                totaldata.end_time='00:00:00';
                }
                else
                {
               totaldata.shift_id=result[0].shift_id;
               totaldata.end_time=result[0].end_time;
               totaldata.driver_avg_rating=result[0].driver_avg_rating;
               
                }
               Util.makeResponse(res, true, 200, "Success",appVersion,totaldata);
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





    return api;
};


/*
 * get order status by order  id
 */
function getOrderStatus(client,order_id)
{
    return new Promise(function (resolve, reject) {
        client.query("select * from orders where order_id=?", [order_id], function (error,status) {
            if (error) {
                reject(error);
            }
            else {
                resolve(status);
            }

        });


    });
}


/*
 * get break type by break type id
 */
function getbreakType(client,type_id)
{
    return new Promise(function (resolve, reject) {
        client.query("select time_minute from break_interval where id	=?", [type_id], function (error,timeresult) {
            if (error) {
                reject(error);
            }
            else {
                var time= timeresult[0].time_minute;
                resolve(time);
            }

        });


    });
}








