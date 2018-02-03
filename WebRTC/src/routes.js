'use strict'
module.exports = (app, db) => {
	app.get("/rtc", function (request, response){
		// render the tempalte
		response.send({})
	})
}