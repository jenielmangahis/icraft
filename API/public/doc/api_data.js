define({ "api": [
  {
    "type": "post",
    "url": "/changeNotificationStatus",
    "title": "changeNotificationStatus",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/changeNotificationStatus/</p>",
    "group": "Driver",
    "name": "changeNotificationStatus________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>status(0=&gt;Off,1=&gt;On)</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Driver"
  },
  {
    "type": "post",
    "url": "/changePassword",
    "title": "changePassword",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/changePassword/</p>",
    "group": "Driver",
    "name": "changePassword________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "current_password",
            "description": "<p>password string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>password string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Driver"
  },
  {
    "type": "post",
    "url": "/editProfile",
    "title": "editProfile",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>editProfile</p>",
    "group": "Driver",
    "name": "editProfile________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "full_name",
            "description": "<p>Full Name string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "phone_number",
            "description": "<p>phone_number string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "location",
            "description": "<p>Address string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "date_of_birth",
            "description": "<p>date_of_birth(1987-09-09) string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "Number",
            "optional": false,
            "field": "gender",
            "description": "<p>0=nil 1=male 2=female 3=other</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Profile updated successfully&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;driver_id&quot;: &quot;1&quot;, &quot;full_name&quot;: &quot;ram nivash&quot;, &quot;phone_number&quot;: &quot;8750024109&quot;, &quot;location&quot;: &quot;delhi&quot;, &quot;date_of_birth&quot;: &quot;1987-09-08&quot;, &quot;gender&quot;: &quot;1&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Driver"
  },
  {
    "type": "post",
    "url": "/forgotPassword",
    "title": "forgotPassword",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>forgotPassword</p>",
    "group": "Driver",
    "name": "forgotPassword________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email Id string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( 0 for error, 1 for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Driver"
  },
  {
    "type": "post",
    "url": "/getProfile",
    "title": "getProfile",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/getProfile/</p>",
    "group": "Driver",
    "name": "getProfile________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "Object",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;personalInfo&quot;: { &quot;email&quot;: &quot;ramnivash@techaheadcorp.com&quot;, &quot;contact_number&quot;: 2147483647, &quot;full_name&quot;: &quot;ramnivash singh&quot;, &quot;date_of_birth&quot;: &quot;1987-09-18T18:30:00.000Z&quot;, &quot;gender&quot;: &quot;male&quot;, &quot;location&quot;: &quot;delhi&quot; }, &quot;professionalInfo&quot;: { &quot;document_type&quot;: &quot;Licence&quot;, &quot;document_id&quot;: &quot;44AMBG45&quot;, &quot;vehicke_make&quot;: &quot;878LKI&quot;, &quot;vehicle_model_type&quot;: &quot;123&quot;, &quot;registration_number&quot;: &quot;1112245&quot;, &quot;license_number&quot;: &quot;sdfdsf44545&quot;, &quot;expiration_date&quot;: &quot;2017-08-07T18:30:00.000Z&quot; } } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Driver"
  },
  {
    "type": "post",
    "url": "/login",
    "title": "login",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/login/</p>",
    "group": "Driver",
    "name": "login________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>email/phone_number string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>password string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "device_token",
            "description": "<p>device_token string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "device_type",
            "description": "<p>device_type string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "login_time",
            "description": "<p>login_time UTC Seconds</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Logged in successfully&quot;, &quot;api_version&quot;: &quot;1.0&quot;, &quot;data&quot;: { &quot;driverId&quot;: 1, &quot;fullName&quot;: &quot;ramnivash singh&quot;, &quot;deviceToken&quot;: &quot;43234dvdsv&quot;, &quot;deviceType&quot;: &quot;1&quot;, &quot;email&quot;: &quot;ram@gmail.com&quot;, &quot;contactNumber&quot;: 2147483647, &quot;profileImage&quot;: &quot;http:google.com&quot;, &quot;token&quot;: &quot;eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicmFtbml2YXNoIHNpbmdoIiwiZW1haWwiOiJyYW1AZ21haWwuY29tIiwiaWF0IjoxNTAzMzE0MzgwLCJleHAiOjE1MDM0MDA3ODB9.6jQRn5vG9Tg7Nwruave97SoTnNYhNAqsZHVYOs8vOkY&quot;, &quot;expiresIn&quot;: 86400 } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Driver"
  },
  {
    "type": "get",
    "url": "/reviewListing",
    "title": "reviewListing",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/reviewListing</p>",
    "group": "Driver",
    "name": "reviewListing________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>Driver id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>Page no. string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( 0 for error, 1 for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": ""
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Driver"
  },
  {
    "type": "post",
    "url": "/getDriverInventory",
    "title": "getDriverInventory",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/getDriverInventory/</p>",
    "group": "Inventory",
    "name": "getDriverInventory________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": ""
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Inventory"
  },
  {
    "type": "post",
    "url": "/endBreak",
    "title": "endBreak",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/endBreak/</p>",
    "group": "Manage_Shift",
    "name": "endBreak________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "shift_id",
            "description": "<p>shift_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "break_type",
            "description": "<p>shift_id(5,10,15) string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status (false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Manage_Shift"
  },
  {
    "type": "post",
    "url": "/endShift",
    "title": "endShift",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/endShift/</p>",
    "group": "Manage_Shift",
    "name": "endShift________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Manage_Shift"
  },
  {
    "type": "post",
    "url": "/getBreakInterval",
    "title": "getBreakInterval",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/getBreakInterval/</p>",
    "group": "Manage_Shift",
    "name": "getBreakInterval________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: [ { &quot;id&quot;: 1, &quot;time_minute&quot;: 5 }, { &quot;id&quot;: 2, &quot;time_minute&quot;: 10 }, { &quot;id&quot;: 3, &quot;time_minute&quot;: 15 } ], }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Manage_Shift"
  },
  {
    "type": "post",
    "url": "/getShiftDetails",
    "title": "getShiftDetails",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/getShiftDetails/</p>",
    "group": "Manage_Shift",
    "name": "getShiftDetails________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "shift_id",
            "description": "<p>shift_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "Object",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;shiftDetails&quot;: [ { &quot;start_time&quot;: &quot;04:52&quot;, &quot;end_time&quot;: &quot;00:00&quot;, &quot;date&quot;: &quot;2017-12-28&quot;, &quot;shift_id&quot;: 6, &quot;driver_id&quot;: 1 } ], &quot;breakDetails&quot;: [ { &quot;start_time&quot;: &quot;12:24&quot;, &quot;end_time&quot;: &quot;12:26&quot; }, { &quot;start_time&quot;: &quot;12:26&quot;, &quot;end_time&quot;: &quot;00:00&quot; } ], } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Manage_Shift"
  },
  {
    "type": "post",
    "url": "/startBreak",
    "title": "startBreak",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/startBreak/</p>",
    "group": "Manage_Shift",
    "name": "startBreak________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "shift_id",
            "description": "<p>shift_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "break_type",
            "description": "<p>shift_id(5,10,15) string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Manage_Shift"
  },
  {
    "type": "post",
    "url": "/startShift",
    "title": "startShift",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/startShift/</p>",
    "group": "Manage_Shift",
    "name": "startShift________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Manage_Shift"
  },
  {
    "type": "post",
    "url": "/deliveredOrder",
    "title": "deliveredOrder",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>deliveredOrder</p>",
    "group": "Order",
    "name": "deliveredOrder________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "order_id",
            "description": "<p>Order Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "reason",
            "description": "<p>Reason string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Order Returned&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;driver_id&quot;: &quot;1&quot;, &quot;order_id&quot;: &quot;123&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/getDeliveryHistory",
    "title": "getDeliveryHistory",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/getDeliveryHistory/</p>",
    "group": "Order",
    "name": "getDeliveryHistory________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: [ { &quot;order_id&quot;: 123, &quot;driver_id&quot;: 1, &quot;delivery_time&quot;: &quot;13:30&quot;, &quot;pickup_location&quot;: &quot;new delhi&quot;, &quot;drop_location&quot;: &quot;noida sector 62&quot;, &quot;order_date&quot;: &quot;2017-12-28&quot;, &quot;order_status&quot;: &quot;6&quot; } ], }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/getMyStats",
    "title": "getMyStats",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/getMyStats/</p>",
    "group": "Order",
    "name": "getMyStats________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "from_date",
            "description": "<p>from_date(UTC) string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "to_date",
            "description": "<p>to_date(UTC) string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: [ { &quot;total_delivery&quot;: &quot;2&quot;, &quot;total_shift_time&quot;: &quot;08:30:00&quot;, &quot;total_break_time&quot;: &quot;00:03:20&quot;, &quot;total_break_taken&quot;: &quot;2&quot; } ], }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/getOrderDetails",
    "title": "getOrderDetails",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/getOrderDetails/</p>",
    "group": "Order",
    "name": "getOrderDetails________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "order_id",
            "description": "<p>order_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;orderDetails&quot;: { &quot;order_id&quot;: 123, &quot;driver_id&quot;: 1, &quot;delivery_time&quot;: &quot;13:30&quot;, &quot;pickup_location&quot;: &quot;new delhi&quot;, &quot;drop_location&quot;: &quot;noida sector 62&quot;, &quot;order_date&quot;: &quot;2017-12-28&quot;, &quot;order_status&quot;: &quot;0&quot; }, &quot;orderItems&quot;: [ { &quot;order_qty&quot;: 1, &quot;item_name&quot;: &quot;Digital Dream&quot;, &quot;item_unit&quot;: &quot;1&quot;, &quot;item_image&quot;: &quot;http://s3.com/image1.jpg&quot;, &quot;price_one&quot;: &quot;290&quot;, &quot;price_eigth&quot;: &quot;30&quot;, &quot;weight&quot;: &quot;100&quot;, &quot;name&quot;: &quot;category1&quot; }, { &quot;order_qty&quot;: 2, &quot;item_name&quot;: &quot;Digital Dreem1&quot;, &quot;item_unit&quot;: &quot;1&quot;, &quot;item_image&quot;: &quot;http://s3.com/image.png&quot;, &quot;price_one&quot;: &quot;160&quot;, &quot;price_eigth&quot;: &quot;20&quot;, &quot;weight&quot;: &quot;30&quot;, &quot;name&quot;: &quot;category2&quot; } ], } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "get",
    "url": "/getStopList",
    "title": "getStopList",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/getStopList/</p>",
    "group": "Order",
    "name": "getStopList________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;orderDetails&quot;: [ { &quot;order_id&quot;: 123, &quot;driver_id&quot;: 1, &quot;delivery_time&quot;: &quot;13:30&quot;, &quot;pickup_location&quot;: &quot;new delhi&quot;, &quot;drop_location&quot;: &quot;noida sector 62&quot;, &quot;order_date&quot;: &quot;2017-12-28&quot;, &quot;first_name&quot;: &quot;ram&quot;, &quot;order_status&quot;: &quot;Start&quot; }, { &quot;order_id&quot;: 124, &quot;driver_id&quot;: 1, &quot;delivery_time&quot;: &quot;18:05&quot;, &quot;pickup_location&quot;: &quot;noida sector 62&quot;, &quot;drop_location&quot;: &quot;noida sector 15&quot;, &quot;order_date&quot;: &quot;2017-12-28&quot;, &quot;first_name&quot;: &quot;ram&quot;, &quot;order_status&quot;: &quot;Accepted&quot; } ], } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/holdOrder",
    "title": "holdOrder",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>startOrder</p>",
    "group": "Order",
    "name": "holdOrder________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "order_id",
            "description": "<p>Order Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "reason_id",
            "description": "<p>Reson Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "comment",
            "description": "<p>Comment string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Order have Hold successfully&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;driver_id&quot;: &quot;1&quot;, &quot;order_id&quot;: &quot;123&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/reachedOrder",
    "title": "reachedOrder",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>reachedOrder</p>",
    "group": "Order",
    "name": "reachedOrder________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "order_id",
            "description": "<p>Order Id string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Reached successfully&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;driver_id&quot;: &quot;1&quot;, &quot;order_id&quot;: &quot;123&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/returnOrder",
    "title": "returnOrder",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>returnOrder</p>",
    "group": "Order",
    "name": "returnOrder________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "order_id",
            "description": "<p>Order Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "reason",
            "description": "<p>Reason string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Order Returned&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;driver_id&quot;: &quot;1&quot;, &quot;order_id&quot;: &quot;123&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/startOrder",
    "title": "startOrder",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          }
        ]
      }
    },
    "description": "<p>startOrder</p>",
    "group": "Order",
    "name": "startOrder________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "order_id",
            "description": "<p>Order Id string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Start successfully&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;driver_id&quot;: &quot;1&quot;, &quot;order_id&quot;: &quot;123&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Order"
  },
  {
    "type": "post",
    "url": "/contactUsQuery",
    "title": "contactUsQuery",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/contactUsQuery/</p>",
    "group": "Support",
    "name": "contactUsQuery________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>message string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Your Query successfully inserted&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: [], }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Support"
  },
  {
    "type": "post",
    "url": "/contactUs",
    "title": "contactUs",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30010/api/v1/contactUs/</p>",
    "group": "Support",
    "name": "contactUs________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "driver_id",
            "description": "<p>driver_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>lang string</p> <hr>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "Success-Response",
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;email&quot;: &quot;support@gmail.com&quot;, &quot;contact_number&quot;: &quot;8112314653&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Support"
  },
  {
    "type": "get",
    "url": "/check",
    "title": "check",
    "description": "<p>http://203.123.36.134:7777/api/v1/check</p>",
    "group": "Test",
    "name": "check________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "allowedValues": [
              "false",
              "true"
            ],
            "optional": false,
            "field": "Success",
            "description": "<p>response status ( false for error, true for success )</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Status",
            "description": "<p>status code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>response message string</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "AppVersion",
            "description": "<p>APP version</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "Result",
            "description": "<p>result</p> <hr>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/driver/index.js",
    "groupTitle": "Test"
  }
] });
