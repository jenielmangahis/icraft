'use strict';

//import add db credentials 
const appDb=require("./appDb");
//import app Constant
const appConstants=require("./appConstants");

//exporting in a single object 
module.exports = {
	'CONSTANTS': appConstants,
	'DB':appDb
};