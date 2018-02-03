// config/passport.js
				
// load all the things we need
var LocalStrategy   = require('passport-local').Strategy;

var mysql = require('mysql');
var  md5 = require("crypto-js/md5");
var config = require('../../API/config/config');

var connection = mysql.createConnection({
    connectionLimit: 40,
   // waitForConnections: true,
    //queueLimit: 0,
    host: config.DB.url,
    user: config.DB.username,
    password: config.DB.password,
    database: config.DB.database,
    //debug: true,
    //wait_timeout: 28800,
    //connect_timeout: 10
});

// expose this function to our app using module.exports
module.exports = function(passport) {

	// =========================================================================
    // passport session setup ==================================================
    // =========================================================================
    // required for persistent login sessions
    // passport needs ability to serialize and unserialize users out of session

    // used to serialize the user for the session
    passport.serializeUser(function(user, done) {
		done(null, user.id);
    });

    // used to deserialize the user
    passport.deserializeUser(function(id, done) {
		connection.query("select * from tbl_admin where id = "+id,function(err,rows){	
			done(err, rows[0]);
		});
    });
	

 	

    // =========================================================================
    // LOCAL LOGIN =============================================================
    // =========================================================================
    // we are using named strategies since we have one for login and one for signup
    // by default, if there was no name, it would just be called 'local'

    passport.use('local-login', new LocalStrategy({
        // by default, local strategy uses username and password, we will override with email
        usernameField : 'email',
        passwordField : 'password',
        passReqToCallback : true // allows us to pass back the entire request to the callback
    },
    function(req, email, password, done) { 
        var pass =(md5(password, 'hex')).toString();	// callback with email and password from our form
console.log("SELECT * FROM `tbl_admin` WHERE `email` = '" + email + "'");
         connection.query("SELECT * FROM `tbl_admin` WHERE `email` = '" + email + "'",function(err,rows){
			if (err)
                            
                return done(err);
			 if (!rows.length) {
                             console.log(rows)
                return done(null, false, req.flash('loginMessage', 'No user found.')); // req.flash is the way to set flashdata using connect-flash
            } 
		
             // if the user is found but the password is wrong
            if (!( rows[0].password == pass))
                return done(null, false, req.flash('loginMessage', 'Oops! Wrong password.')); // create the loginMessage and save it to session as flashdata
			
            // all is well, return successful user
            return done(null, rows[0]);			
		
		});
		


    }));

};