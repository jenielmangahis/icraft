'use strict'

const express = require('express')
const mysql = require('mysql')
const path = require('path')
const bundle = require('browserify')({ standalone: 'getUserMedia' })
const fs = require('fs')
const ExpressPeerServer = require('peer').ExpressPeerServer;

// local modules
const settings = require('./src/settings')
const routes = require('./src/routes')

// Change this in production server
const Environment = process.env.NODE_ENV || "production"

const app = express()
app.set('view engine', 'html')
app.use(express.static(path.join(__dirname, '')))

// load the getMedia into the browser
/*bundle.add('./src/modules/media')
bundle.bundle().pipe(fs.createWriteStream('./dist/media.bundle.js'))*/

// connect the database
var connection = mysql.createConnection(settings.db[Environment])

// fire all routes
routes(app, connection)

// run the server
var server = app.listen(settings.port, () => {
	console.log("Listening on port %s", settings.port)
})

// configure the peer server
app.use('/api', ExpressPeerServer(server, {debug: true}))

server.on('connection', function(id) {
	console.log(id)
	console.log(server._clients)
});

server.on('disconnect', function(id) {
    console.log(id + "deconnected")
});