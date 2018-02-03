'use strict';

// // =================================================================
// get the packages we need ========================================like
// =================================================================

var User = require('../user/auth'),
        Util = require('../../../util/custom_functions'),
        inspector = require('schema-inspector'),
        bcrypt = require('bcrypt'),
        config = require('../../../config/config'), // get our config file
        success = false, 
        status = 400, 
        appVersion = '1.0',
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
        Util.makeResponse(res, true, 200, 'Welcome11 to the coolest API on earth!', '1.0.0', [])
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
        Util.makeResponse(res, true, 200, 'Welcome to the coolest API on earth!', '1.0.0', []);
    });


    /***************************************************************************************************************************************************************/
    /************************************************************************ /signUp ************************************************************************/
    /**
     * @api {post} /sign_up sign_up
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:7777/api/v1/sign_up/
     * @apiGroup User
     * @apiName sign_up
     * ***************************************************************************************************************************************************************
     * @apiParam (Expected parameters) {String}      profile_url            profile_url string
     * @apiParam (Expected parameters) {String}      first_name             first_name string
     * @apiParam (Expected parameters) {String}      last_name              last_name string
     * @apiParam (Expected parameters) {String}      country_code           country_code integer
     * @apiParam (Expected parameters) {String}      contact                contact number number
     * @apiParam (Expected parameters) {String}      email                  email string
     * @apiParam (Expected parameters) {String}      phone_number           phone_number number
     * @apiParam (Expected parameters) {String}      driver_type_id         driver_type_id string
     * @apiParam (Expected parameters) {String}      device_token           device_token string
     * @apiParam (Expected parameters) {String}      device_type            device_type string
     * @apiParam (Expected parameters) {String}      login_type             login_type string
     * @apiParam (Expected parameters) {String}      latitude               latitude string
     * @apiParam (Expected parameters) {String}      longitude              longitude string
     * @apiParam (Expected parameters) {Object}      lang                   lang enum
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             {
"success": true,
"status": 200,
"message": "Driver is registered successfully",
"api_version": "1.0",
"data": {
"profile_url": "profileImage.jpg",
"first_name": "Ankit",
"last_name": "Chavhan",
"country_code": 91,
"contact": 9827292977,
"email": "ankit.chavhan@techaheahcorp.com",
"login_type": "0",
"driver_type_id": "1",
"device_type": "1",
"device_token": "we4wfdfgdf",
"latitude": "45.54465",
"longitude": "67.5658788",
"lang": "1",
"phone_number": 12357845,
"image_url": [
  "1.jpg",
  "2.jpg"
],
"user_id": "26"
}
}
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/

    api.post('/sign_up', function (req, res) {
        var success = false, status = 400, message, appVersion = '1.0';
        var data = req.body;
        var schema = {type: 'object',
            properties: {
                first_name: {type: 'string'},
                last_name: {type: 'string'},
                country_code: {type: 'integer'},
                contact: {type: 'number'},
                login_type: {type: 'string', eq: ["0", "1"]},
                email: {type: 'string'},
                phone_number: {type: 'number'},
                profile_url: {type: 'string'},
                driver_type_id: {type: 'string', eq: ['1', '2', '3', '4']},
                device_type: {type: 'string', eq: ["0", "1"]},
                device_token: {type: 'string'},
                latitude: {type: 'string'},
                longitude: {type: 'string'},
                lang: {type: 'string', eq: ['1', '2', '3']}
            }
        };
        var validationresult = inspector.validate(schema, data);
        if (!validationresult.valid) {
            // INVALID            
            var message = validationresult.format();
            Util.makeResponse(res, success, status, message, appVersion, data);
        } else {
            //validate image_url count 
            if (data.image_url.length < 2) {
                message = "Driver should provide atleast 2 Id proofs";

                Util.makeResponse(res, success, status, message, appVersion, data);
            } else {
                var saltRounds = 10;
                //var password = Math.floor(Math.random() * 20).toString();
                var password = "123456";
                bcrypt.genSalt(saltRounds, function (err, salt) {
                    bcrypt.hash(password, salt, function (err, hash) {
                        if (err) {
                            console.log(err);
                            
                        }
                        console.log("here" + hash);

                        if (data.login_type == '0') {
                            client.query("select * from drivers where email=?", [data.email], function (error, result) {
                                if (error) {
                                    console.log(error);
                                    Util.makeResponse(res, success, status, message, appVersion, data);
                                } else {
                                    //if email already exists
                                    if (result.length > 0) {
                                        message = "Email already exists";
                                        
                                        Util.makeResponse(res, success, status, message, appVersion, data);
                                    } else {
                                        var jsonRequest = {
                                            'login_id': data.email,
                                            'password': hash,
                                            'first_name': data.first_name,
                                            'last_name': data.last_name,
                                            'country_code': data.country_code,
                                            'contact': data.contact,
                                            'email': data.email,
                                            'login_type': data.login_type,
                                            'driver_type_id': data.driver_type_id,
                                            'device_type': data.device_type,
                                            'device_token': data.device_token,
                                            'profile_url': data.profile_url,
                                            'latitude': data.latitude,
                                            'longitude': data.longitude,
                                            'lang': data.lang
                                        }
                                        client.query('INSERT INTO drivers SET ?', jsonRequest, function (err, result) {
                                            if (err) {
                                                console.log(err);
                                                
                                                Util.makeResponse(res, success, status, message, appVersion, data);
                                            } else {

                                                req.body.user_id = result.insertId.toString();
                                                //insert into the driver id proofs table
                                                var imageArray = req.body.image_url;
                                                for (var i = 0; i < imageArray.length; i++) {
                                                    var driverProofRequest = {
                                                        'driver_id': req.body.user_id,
                                                        'image_url': imageArray[i]
                                                    };
                                                    client.query('INSERT into driver_proofs SET ?', driverProofRequest, function (err1, result1) {
                                                        if (err) {
//                                                        console.log(err);
//                                                        var success=false,status=500,message="Something went wrong",appVersion='1.0',data={};
//                                                        Util.makeResponse(res, success, status, message, appVersion, data);
                                                        } else {

                                                        }
                                                    });
                                                }
                                                
                                                message = "Driver is registered successfully";
                                                success = true;
                                                status = 200;
                                                Util.makeResponse(res, success, status, message, appVersion, req.body);
                                            }
                                        });//insert
                                    }
                                }
                            });
                        } else if (data.login_type == '1') {
                            client.query("select * from drivers where phone_number=?", [data.phone_number], function (error, result) {
                                if (error) {
                                    console.log(error);
                                    Util.makeResponse(res, success, status, message, appVersion, data);
                                } else {
                                    //if email already exists
                                    if (result.length > 0) {
                                        message = "Phone number already exists";

                                        Util.makeResponse(res, success, status, message, appVersion, data);
                                    } else {

                                        var jsonRequest = {
                                            'login_id': data.phone_number,
                                            'password': hash,
                                            'first_name': data.first_name,
                                            'last_name': data.last_name,
                                            'country_code': data.country_code,
                                            'contact': data.contact,
                                            'phone_number': data.phone_number,
                                            'login_type': data.login_type,
                                            'driver_type_id': data.driver_type_id,
                                            'device_type': data.device_type,
                                            'device_token': data.device_token,
                                            'profile_url': data.profile_url,
                                            'latitude': data.latitude,
                                            'longitude': data.longitude,
                                            'lang': data.lang
                                        }
                                        client.query('INSERT INTO drivers SET ?', jsonRequest, function (err, result) {
                                            if (err) {
                                                console.log(err);
                                               
                                                Util.makeResponse(res, success, status, message, appVersion, data);
                                            } else {

                                                req.body.user_id = result.insertId.toString();
                                                //insert into the driver id proofs table
                                                var imageArray = req.body.image_url;
                                                for (var i = 0; i < imageArray.length; i++) {
                                                    var driverProofRequest = {
                                                        'driver_id': req.body.user_id,
                                                        'image_url': imageArray[i]
                                                    };
                                                    client.query('INSERT into driver_proofs SET ?', driverProofRequest, function (err1, result1) {
                                                        if (err) {
//                                                        console.log(err);
//                                                        var success=false,status=500,message="Something went wrong",appVersion='1.0',data={};
//                                                        Util.makeResponse(res, success, status, message, appVersion, data);
                                                        } else {

                                                        }
                                                    });
                                                }

                                                message = "Driver is registered successfully";
                                                success = true;
                                                status = 200;
                                                Util.makeResponse(res, success, status, message, appVersion, req.body);
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    });
                });

            }//final
        }

//}, function (errors) {
//        console.log(errors)
//            Util.makeResponse(res, false, 400, "Bad Request", '1.0.0', errors);
//        });
    });

    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i)
            result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }


    /***************************************************************************************************************************************************************/
    /************************************************************************ /change_password ************************************************************************/
    /**
     * @api {post} /change_password change_password
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:7777/api/v1/change_password/
     * @apiGroup User
     * @apiName change_password
     * ***************************************************************************************************************************************************************
     
     * @apiParam (Expected parameters) {String}      user_id                user_id string
     * @apiParam (Expected parameters) {String}      current_password       current_password string
     * @apiParam (Expected parameters) {String}      new_password           new_password string
     * @apiParam (Expected parameters) {String}      confirm_password       confirm_password string
     * @apiParam (Expected parameters) {Object}      lang                   lang enum
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             {
"success": true,
"status": 200,
"message": "Password is changed successfully",
"api_version": "1.0",
"data": {}
}
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/
    api.post('/change_password', function (req, res) {
        var data = req.body;
        var schema = { type: 'object',
            properties: {
                user_id: {type: 'string'},
                current_password: {type: 'string'},
                new_password: {type: 'string'},
                confirm_password: {type: 'string'},
                lang: {type: 'string', eq: ['1', '2', '3']}
            }
        };

        var validationresult = inspector.validate(schema, data);
        if (!validationresult.valid) {
            // INVALID            
            var message = validationresult.format();
            Util.makeResponse(res, success, status, message, appVersion, data);
        } else {
            client.query('SELECT * from drivers where id = ?',data.user_id , function(err,result) {
                if (err) {
                        console.log(err);
                        Util.makeResponse(res, success, status, message, appVersion, data);
                } else {
                    if(result.length > 0){
                        console.log("password :"+result[0].password);
                        
                        //compare user password
                        bcrypt.compare(data.current_password, result[0].password, function(err1, res1) {
                            if(err1){
                                
                                var success = false, status = 500, message, appVersion = '1.0';
                                message = "Something went wrong";
                                data = {};
                                Util.makeResponse(res, success, status, message, appVersion, data);
                            }else{
                                
                                if(!res1){
                                    var success = false, status = 400, message, appVersion = '1.0';
                                    message = "Current password is incorrect";
                                    data = {};
                                    
                                    Util.makeResponse(res, success, status, message, appVersion, data);
                                }else{
                                    var saltRounds = 10;
                                    bcrypt.genSalt(saltRounds, function (err2, salt) {
                                        bcrypt.hash(data.current_password, salt, function (err3, hash) {
                                            if (err3) {
                                                console.log("errorr "+err3);
                                            }
                                            
                                            client.query('UPDATE drivers SET password = ? where id = ?', [hash,data.user_id],function(err4,res4){
                                                    if(err4){
                                                        var success = false, status = 500, message, appVersion = '1.0';
                                                        message = "Something went wrong";
                                                        data = {};
                                                        Util.makeResponse(res, success, status, message, appVersion, data);
                                                    }else{
                                                        var success = true, status = 200, message, appVersion = '1.0';
                                                        message = "Password is changed successfully";
                                                        data = {};
                                                        Util.makeResponse(res, success, status, message, appVersion, data);
                                                    }
                                            });
                                        });
                                    });
                                }
                            }
                        });
                        return false;
                    }else{
                        var success = true, status = 200, message, appVersion = '1.0';
                        message = "Driver does not exist";
                        data = {};
                        Util.makeResponse(res, success, status, message, appVersion, data);
                    }
                }
            });
        }
    });
    

    /***************************************************************************************************************************************************************/
    /************************************************************************ /forget_password ************************************************************************/
    /**
     * @api {post} /forget_password forget_password
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:7777/api/v1/forget_password/
     * @apiGroup User
     * @apiName forget_password
     * ***************************************************************************************************************************************************************
     
     * @apiParam (Expected parameters) {String}      user_id                user_id string
     * @apiParam (Expected parameters) {String}      email                  email string
     * @apiParam (Expected parameters) {String}      country_code           country_code integer
     * @apiParam (Expected parameters) {String}      phone_number           phone_number number
     * @apiParam (Expected parameters) {String}      login_type             login_type string
     * @apiParam (Expected parameters) {Object}      lang                   lang enum
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             result
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/

    api.post('/forgot_password', function (req,res){
        var data = req.body;
        var schema = {
            type : 'object',
            properties: {
                user_id: {type: 'string'},
                email: {type: 'string'},
                phone_number: {type: 'number'},
                country_code: {type: 'integer'},
                login_type: {type: 'string',eq: ["0" , "1"]},
                lang: {type: 'string', eq: ['1', '2', '3']}
            }
        }
        var validationresult = inspector.validate(schema, data);
        if (!validationresult.valid) {
            // INVALID            
            var message = validationresult.format();
            Util.makeResponse(res, success, status, message, appVersion, data);
        }else{
            //email 
            if(data.login_type == '0'){
                client.query('Select * from drivers where email = ?', data.email , function(err,result){
                    if(err){
                        console.log(err);
                        message = "Something went wrong";
                        data = {};
                        Util.makeResponse(res, success, status, message, appVersion, data);
                    }else{
                        if(result.length > 0){
                            //send change password link to the registered email id
                            var rand = require('random-seed').create();
                            var token = rand(9999); // generate a random number between 0 - 9999 
                            console.log("string== :"+token);
                            
                            //save token in database for respective driver
                            client.query('UPDATE drivers SET token = ? where id = ?', [token,data.user_id],function(err2,result2){
                                if(err2){
                                    Util.makeResponse(res, success, status, message, appVersion, data);
                                }else{
                                    var link = config.CONSTANTS.HTTP_PORT+"reset_password?token="+token;
                                    
                                    //send email
                                }
                            });
                            
                            
                        }else{
                            //email is not registered
                            message = "There is no user registered with the provided credentials.Please signup to create your account.";
                            data = {};
                            Util.makeResponse(res, success, status, message, appVersion, data);
                        }
                    }
                });
            }else{
                
                //if entered phone number along with country code
                client.query('Select * from drivers where country_code = ? and phone_number = ?', [data.country_code,data.phone_number] , function(err1,result1){
                    if(err1){
                        console.log(err1);
                        message = "Something went wrong";
                        data = {};
                        Util.makeResponse(res, success, status, message, appVersion, data);
                    }else{
                        
                        if(result1.length > 0){
                            
                            //call random function 
                            //Util.generateRandomNumber.then(function(fulfilled){
                                //save token in database for respective driver
                                var rand = require('random-seed').create();
                                var token=rand(9999);
                                client.query('UPDATE drivers SET otp = ? where id = ?', [token,data.user_id],function(err2,result2){
                                    if(err2){
                                        Util.makeResponse(res, success, status, message, appVersion, data);
                                    }else{
                                        var to_number = "+"+result1[0].country_code+result1[0].phone_number;
                                       //send otp to driver
                                        Util.sendCode(to_number,token)
                                        console.log("herer");return false;
                                    }
                                });
//                            })
//                                    .catch(function(error){
//                                       console.log("error in promise "+error) ;
//                                    });
                        }else{
                            //email is not registered
                            message = "There is no user registered with the provided credentials.Please signup to create your account.";
                            data = {};
                            Util.makeResponse(res, success, status, message, appVersion, data);
                        }
                    }
                });
            }
        }
    });
    
    
    /*Send email */
    

    /***************************************************************************************************************************************************************/
    /************************************************************************ /login ************************************************************************/
    /**
     * @api {post} /login login
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:7777/api/v1/login/
     * @apiGroup User
     * @apiName login
     * ***************************************************************************************************************************************************************
     
     * @apiParam (Expected parameters) {String}      email                  email string
     * @apiParam (Expected parameters) {String}      phone_number           phone_number number
     * @apiParam (Expected parameters) {String}      password               password string
     * @apiParam (Expected parameters) {String}      device_token           device_token string
     * @apiParam (Expected parameters) {String}      device_type            device_type string
     * @apiParam (Expected parameters) {String}      login_type             login_type string
     * @apiParam (Expected parameters) {String}      login_time             login_time UTC Seconds
     * @apiParam (Expected parameters) {Object}      lang                   lang string
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             {
  "success": true,
  "status": 200,
  "message": "Logged in successfully",
  "api_version": "1.0",
  "data": [
    {
      "id": 1,
      "login_id": "ankit.chavhan@techaheadcorp.com",
      "password": "123456",
      "first_name": "Ankit",
      "last_name": "chavhan",
      "country_code": 91,
      "contact": 2147483647,
      "email": "ankit.chavhan@techaheadcorp.com",
      "phone_number": 2147483647,
      "otp": 1111,
      "login_type": "0",
      "driver_type_id": "1",
      "profile_url": "www.google.com",
      "link_active": "0",
      "is_verified": "0",
      "is_approved": "0",
      "device_token": "adfgdgb567n4k56yj3jh45",
      "device_type": "0",
      "online": "0",
      "logout": null,
      "latitude": 27,
      "longitude": 47,
      "lang": "1",
      "is_deleted": "0",
      "is_blocked": "0",
      "token": "hdgfdg87gfh5gd567hd76g57h6g",
      "created_at": "2017-08-16T15:02:54.000Z",
      "updated_at": "0000-00-00 00:00:00"
    }
  ]
}
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/
    
    api.post('/login', function (req, res) {
        var data = req.body;
        var schema = { type: 'object',
            properties: {
                email: {type : 'string'},
                password: {type: 'string'},
                login_type: {type: 'string'},
                device_type: {type: 'string', eq: ["0", "1"]},
                device_token: {type: 'string'},
                lang: {type: 'string', eq: ["0", "1"]}
            }
        };
        
        var validationresult = inspector.validate(schema, data);
        if (!validationresult.valid) {
            
            // INVALID            
            var message = validationresult.format();
            Util.makeResponse(res, success, status, message, appVersion, data);
        } else {
           
            var is_deleted = '0';//defining is_deleted so that we can pass in sql
            var is_blocked = '0';//defining is_blocked so that we can pass in sql
            if(req.body.login_type == "1"){//for contact
                var emailSql = 'SELECT * from drivers where phone_number = ? AND password = ? AND is_deleted = ? AND is_blocked = ?';
                client.query(emailSql,[data.phone_number,data.password,is_deleted,is_blocked] , function(err,ress) {
                if (err) {
                    console.log(err);
                        var success = false, status = 500, message, appVersion = '1.0';
                        message = "Something went wrong";
                        data = {};
                        Util.makeResponse(res, success, status, message, appVersion, data);
                } else {
                        console.log('test');
                        return false;
                }
            });
                
            } else {//for email
                
                var emailSql = 'SELECT * from drivers where email = ? AND password = ? AND is_deleted = ? AND is_blocked = ?';
                client.query(emailSql,[data.email,data.password,is_deleted,is_blocked] , function(err,ress) {
                if (err) {
                        console.log(err);
                        var success = false, status = 500, message, appVersion = '1.0';
                        message = "Something went wrong";
                        data = {};
                        Util.makeResponse(res, success, status, message, appVersion, data);
                } else {
                    //update token and online field
                    var updateParams = 'UPDATE drivers SET ? WHERE ?';
                    client.query(updateParams,[{device_token: data.device_token, online: '1'}, { id: ress[0].id }] , function(err,resUpdate) {
                    if (err) {
                        console.log(err);
                        var success = false, status = 500, message, appVersion = '1.0';
                        message = "Something went wrong";
                        data = {};
                        Util.makeResponse(res, success, status, message, appVersion, data);
                    } else {
                        //insert the login logs
                        
                        var insertdriver_login_logs = 'INSERT INTO driver_login_logs SET ?';
                        client.query(insertdriver_login_logs,[{	driver_id: ress[0].id, sign_in_time: data.login_time}] , function(err,resUpdateq) {
                        if (err) {
                                console.log(err);
                                var success = false, status = 500, message, appVersion = '1.0';
                                message = "Something went wrong";
                                data = {};
                                Util.makeResponse(res, success, status, message, appVersion, data);
                        }else{
                            //insert the online logs
                                var insertdriver_online_logs = 'INSERT INTO driver_online_logs SET ?';
                                client.query(insertdriver_online_logs,[{	driver_id: ress[0].id, sign_in_time: data.login_time}] , function(err,resUpdatep) {
                                if (err) {
                                        console.log(err);
                                        var success = false, status = 500, message, appVersion = '1.0';
                                        message = "Something went wrong";
                                        data = {};
                                        Util.makeResponse(res, success, status, message, appVersion, data);
                                }else{
                                    
                                    var success = true, status = 200, message, appVersion = '1.0';
                                    message = "Logged in successfully";
                                    Util.makeResponse(res, success, status, message, appVersion, ress);
                                }
                                });
                            
                        }
                        });
                    }
                    });
                }
            
                });
    
            }
        }
    });

    
    /***************************************************************************************************************************************************************/
    /************************************************************************ /update_token ************************************************************************/
    /**
     * @api {post} /update_token update_token
     * @apiHeader {String} Content-Type application/json.
     * @apiDescription http://203.123.36.134:7777/api/v1/update_token/
     * @apiGroup User
     * @apiName update_token
     * ***************************************************************************************************************************************************************
     
     * @apiParam (Expected parameters) {String}      id                     id integer
     * @apiParam (Expected parameters) {String}      device_token           device_token string
     * @apiParam (Expected parameters) {String}      lang                   lang enum
     
     
     * ***************************************************************************************************************************************************************
     * @apiSuccess {boolean=false,true}    Success            response status ( false for error, true for success )
     * @apiSuccess {Number}                Status             status code
     * @apiSuccess {String}                Message            response message string
     * @apiSuccess {String}                AppVersion         APP version
     * @apiSuccess {Object}                Result             {
  "success": true,
  "status": 200,
  "message": "Device token updated successfully",
  "api_version": "1.0",
  "data": {} }
     * ***************************************************************************************************************************************************************
     * @apiVersion 1.0.0
     **/

     api.post('/update_token', function (req, res) {
        var data = req.body;
        var schema = { type: 'object',
            properties: {
                id: {type : 'integer'},
                device_token: {type: 'string'},
                lang: {type: 'string', eq: ['1', '2', '3']}
            }
        };
        
        var validationresult = inspector.validate(schema, data);
        if (!validationresult.valid) {
            
            // INVALID            
            var message = validationresult.format();
            Util.makeResponse(res, success, status, message, appVersion, data);
        } else {
            
                var updateParams = 'UPDATE drivers SET ? WHERE ?';
                client.query(updateParams,[{device_token: data.device_token,lang: data.lang}, { id: data.id }] , function(err,resUpdate) {
                if (err) {
                    console.log(err);
                    var success = false, status = 500, message, appVersion = '1.0';
                    message = "Something went wrong";
                    data = {};
                    Util.makeResponse(res, success, status, message, appVersion, data);
                } else {
                    var success = true, status = 200, message, appVersion = '1.0';
                    message = "Device token updated successfully";
                    data = {};
                    Util.makeResponse(res, success, status, message, appVersion, data);
                }
            });
                
            
        }
    });


    return api;
};











