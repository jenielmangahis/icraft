'use strict'

module.exports = {
	port: 3000,
	env: "production",
	db: {
		development: {
			host: "instacraftdb.c7mkioq7chm7.us-west-2.rds.amazonaws.com",
			port: 3306,
			user: "instacraftdb",
			password: "Hd5Kgj2wfS3",
			database: "instacraft",
			debug: true
		},
		production: {
			host: "localhost",
			port: 3306,
			user: "root",
			password: "",
			database: "instacraft",
			debug: false
		}
	},
	peer: {
		port: 9000,
		path: '/peer',
		proxied: false,
		debug:true
	}
}