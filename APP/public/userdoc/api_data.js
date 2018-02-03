define({ "api": [
  {
    "type": "post",
    "url": "/deleteNotification",
    "title": "deleteNotification",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30020/apiuser/v1/deleteNotification/</p>",
    "group": "Notification",
    "name": "deleteNotification________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>Notification Id string</p> <hr>"
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
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Deleted successfully&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;user_id&quot;: &quot;2&quot;, &quot;id&quot;: &quot;1&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "Notification"
  },
  {
    "type": "get",
    "url": "/getNotification",
    "title": "getNotification",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30020/apiuser/v1/getNotification/</p>",
    "group": "Notification",
    "name": "getNotification________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>user_id string</p> <hr>"
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
            "description": ""
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "Notification"
  },
  {
    "type": "get",
    "url": "/check",
    "title": "check",
    "description": "<p>http://203.123.36.134:30020/apiuser/v1/check</p>",
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
    "filename": "routes/v1/user/index.js",
    "groupTitle": "Test"
  },
  {
    "type": "post",
    "url": "/dashboard",
    "title": "dashboard",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>home</p>",
    "group": "dashboard",
    "name": "dashboard________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id string</p> <hr>"
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
            "description": "<p>result</p> <hr> <pre><code> {  &quot;success&quot;: true,  &quot;status&quot;: 200,  &quot;message&quot;: &quot;Your dashboard listing.&quot;,  &quot;api_version&quot;: &quot;1.0.0&quot;,  &quot;data&quot;: {}  }</code></pre>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "dashboard"
  },
  {
    "type": "get",
    "url": "/getPrescriptionList",
    "title": "getPrescriptionList",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30020/apiuser/v1/getPrescriptionList/</p>",
    "group": "dashboard",
    "name": "getPrescriptionList________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>user_id string</p> <hr>"
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
            "description": ""
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "dashboard"
  },
  {
    "type": "post",
    "url": "/uploadIdentityProof",
    "title": "uploadIdentityProof",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>uploadIdentityProof</p>",
    "group": "dashboard",
    "name": "uploadIdentityProof________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "prescription_image_front",
            "description": "<p>Proof Image string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "prescription_image_back",
            "description": "<p>Proof Image string</p> <hr>"
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
            "description": "<p>result</p> <hr> <pre><code> {  &quot;success&quot;: true,  &quot;status&quot;: 200,  &quot;message&quot;: &quot;Your Proof is uploaded Successfully.&quot;,  &quot;api_version&quot;: &quot;1.0.0&quot;,  &quot;data&quot;: {}  }</code></pre>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "dashboard"
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
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30020/apiuser/v1/changePassword/</p>",
    "group": "user",
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
            "description": "<p>new password string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>user_id string</p> <hr>"
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
            "description": "<p>result</p> <hr> <pre><code> {  &quot;success&quot;: true,  &quot;status&quot;: 200,  &quot;message&quot;: &quot;Password Updated Successfully&quot;,  &quot;api_version&quot;: &quot;1.0.0&quot;,  &quot;data&quot;: {  &quot;driver_id&quot;: 1,  &quot;expiresIn&quot;: 86400  }  }</code></pre>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/forgetPassword",
    "title": "forgetPassword",
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
    "group": "user",
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
            "description": "<p>result</p> <hr> <pre><code> {  &quot;success&quot;: true,  &quot;status&quot;: 200,  &quot;message&quot;: &quot;For furthur steps please check your email.&quot;,  &quot;api_version&quot;: &quot;1.0.0&quot;,  &quot;data&quot;: {}  }</code></pre>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  },
  {
    "type": "get",
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
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>http://203.123.36.134:30020/apiuser/v1/getProfile/</p>",
    "group": "user",
    "name": "getProfile________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>user_id string</p> <hr>"
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
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;Success&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;first_name&quot;: &quot;ram&quot;, &quot;last_name&quot;: &quot;nivash&quot;, &quot;profile_pic&quot;: &quot;&quot;, &quot;gender&quot;: &quot;1&quot;, &quot;email&quot;: &quot;ramnivash@techaheadcorp.com&quot;, &quot;phone_number&quot;: &quot;8750024109&quot;, &quot;dob&quot;: &quot;2016-04-04T18:30:00.000Z&quot;, &quot;is_termcondition_accepted&quot;: &quot;0&quot;, &quot;is_medical_prescription&quot;: &quot;0&quot;, &quot;state&quot;: &quot;&quot;, &quot;city&quot;: &quot;&quot;, &quot;address&quot;: &quot;&quot;, &quot;street1&quot;: &quot;&quot;, &quot;street2&quot;: &quot;&quot; } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
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
    "description": "<p>http://203.123.36.134:30020/apiuser/v1/login/</p>",
    "group": "user",
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
            "description": "<p>login_time UTC Seconds</p> <hr>"
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
            "description": "<p>{ &quot;success&quot;: true, &quot;status&quot;: 200, &quot;message&quot;: &quot;login successfuly&quot;, &quot;api_version&quot;: &quot;1.0.0&quot;, &quot;data&quot;: { &quot;user_id&quot;: 2, &quot;full_name&quot;: &quot;ram nivash&quot;, &quot;device_token&quot;: &quot;43234dvdsv5654&quot;, &quot;device_type&quot;: &quot;1&quot;, &quot;email&quot;: &quot;ramnivash@techaheadcorp.com&quot;, &quot;phone_number&quot;: &quot;8750024109&quot;, &quot;profile_pic&quot;: &quot;&quot;, &quot;token&quot;: &quot;eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoicmFtIiwiZW1haWwiOiJyYW1uaXZhc2hAdGVjaGFoZWFkY29ycC5jb20iLCJpYXQiOjE1MDUzMDYwMzYsImV4cCI6MTUwNTM5MjQzNn0.bATy62tPXrTyJu34IzkM93XYQmPev4fT6I9J05lJsfk&quot;, &quot;expiresIn&quot;: 86400 } }</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/logout",
    "title": "logout",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>Logout</p>",
    "group": "user",
    "name": "logout________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id string</p> <hr>"
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
            "description": "<p>result</p> <hr> <pre><code> {  &quot;success&quot;: true,  &quot;status&quot;: 200,  &quot;message&quot;: &quot;Logout successfully&quot;,  &quot;api_version&quot;: &quot;1.0.0&quot;,  &quot;data&quot;: {}  }</code></pre>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/register",
    "title": "register",
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
    "description": "<p>http://203.123.36.134:30020/api/v1/register/</p>",
    "group": "user",
    "name": "register________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email string</p>"
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
            "description": "<p>device token string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "device_type",
            "description": "<p>device type 0=android,1=IOs it would be also a string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "phone_number",
            "description": "<p>phone_number string</p> <hr>"
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
            "description": "<p>result</p> <hr> <pre><code> {  &quot;success&quot;: true,  &quot;status&quot;: 200,  &quot;message&quot;: &quot;Sign Up Successfully&quot;,  &quot;api_version&quot;: &quot;1.0.0&quot;,  &quot;data&quot;: {  &quot;user_id&quot;: 9,  &quot;email&quot;: &quot;ankit.chavhan@techaheadcorp.com&quot;,  &quot;expiresIn&quot;: 86400  }  }</code></pre>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/updateProfile",
    "title": "updateProfile",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>updateProfile</p>",
    "group": "user",
    "name": "updateProfile________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "first_name",
            "description": "<p>First Name string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "last_name",
            "description": "<p>Last Name string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "dob",
            "description": "<p>date_of_birth(1987-09-24) string</p>"
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
            "description": ""
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/uploadPrescription",
    "title": "uploadPrescription",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/x-www-form-urlencoded.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-instacraft-token",
            "description": "<p>Provided token.</p>"
          }
        ]
      }
    },
    "description": "<p>uploadPrescription</p>",
    "group": "user",
    "name": "uploadPrescription________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "prescription_image_front",
            "description": "<p>Prescription Image string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "prescription_image_back",
            "description": "<p>Prescription Image string</p> <hr>"
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
            "description": "<p>result</p> <hr> <pre><code> {  &quot;success&quot;: true,  &quot;status&quot;: 200,  &quot;message&quot;: &quot;Your Prescription is uploaded Successfully.&quot;,  &quot;api_version&quot;: &quot;1.0.0&quot;,  &quot;data&quot;: {}  }</code></pre>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/verifyOtp",
    "title": "verifyOtp",
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
    "description": "<p>http://203.123.36.134:30020/api/v1/verifyOtp/</p>",
    "group": "user",
    "name": "verifyOtp________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>user_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "otp",
            "description": "<p>otp string</p> <hr>"
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
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  },
  {
    "type": "post",
    "url": "/verifyPhone",
    "title": "verifyPhone",
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
    "description": "<p>http://203.123.36.134:30020/api/v1/user/verifyPhone/</p>",
    "group": "user",
    "name": "verifyPhone________________________________________________________________________________________________________________________________________________________________",
    "parameter": {
      "fields": {
        "Expected parameters": [
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>user_id string</p>"
          },
          {
            "group": "Expected parameters",
            "type": "String",
            "optional": false,
            "field": "phone_number",
            "description": "<p>phone_number string</p> <hr>"
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
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "routes/v1/user/index.js",
    "groupTitle": "user"
  }
] });
