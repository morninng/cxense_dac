
// Use Parse.Cloud.define to define as many cloud functions as you want.
// For example:
Parse.Cloud.define("hello", function(request, response) {
  response.success("Hello world!");
});




Parse.Cloud.define("cxense_traffic", function(request, response) {

	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');
	 
	Parse.Cloud.httpRequest({
	  method: 'POST',
	  url: 'https://api.cxense.com/traffic',
	  headers: { 
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	start: -3600, 
	  	siteId: '1128275557251903601'
	  },
	  success: function(httpResponse) {
	     response.success(httpResponse.text);
	  },
	  error: function(httpResponse) {
	    response.error('Request failed with response code ' + httpResponse.status);
	  }
	});

});



Parse.Cloud.define("cxense_traffic_keywordfilter", function(request, response) {

	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');
	 

	var fields_array = new Array("events", "urls","activeTime");
	var obj = { type:"keyword" , group:"concept", item:"広告配信"};
	var filters_array = new Array(obj);

	Parse.Cloud.httpRequest({
	  method: 'post',
	  url: 'https://api.cxense.com/traffic',
	  headers: { 
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	start: -86400, 
	  	siteId: '1128275557251903601',
	  	fields: fields_array,
	  	filters: filters_array
	  },
	  success: function(httpResponse) {
	     response.success(httpResponse.text);
	  },
	  error: function(httpResponse) {
	    response.error('Request failed with response code ' + httpResponse.status);
	  }
	});

});
