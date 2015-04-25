
// Use Parse.Cloud.define to define as many cloud functions as you want.
// For example:
Parse.Cloud.define("hello", function(request, response) {
  response.success("Hello world!");
});

Parse.Cloud.define("cxense_traffic1", function(request, response) {

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



Parse.Cloud.define("cxense_traffic2", function(request, response) {

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




Parse.Cloud.define("cxense_traffic_keywordfilter", function(request, response) {
	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');

	Parse.Cloud.httpRequest({
	  method: 'post',
	  url: 'https://api.cxense.com/traffic/keyword',
	  headers: { 
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	start: -86400, 
	  	siteId: '1128275557251903601',
	  	historyResolution: 'minute',
	  },
	  success: function(httpResponse) {
	     //response.success(httpResponse.text);
	     var data_obj = JSON.parse(httpResponse.text);
	     var groups_array = data_obj.groups;
	     var concept_item = new Array();
	     var concept_items = new Array();
	     for(var i=0; i<groups_array.length; i++ ){
	     	if(groups_array[i].group == "concept"){
	     		concept_items = groups_array[i].items;
	     		for(var j=0; j<concept_items.length; j++){
	     			concept_item.push(concept_items[j].item);
	     		}
	     	}
	     }
	     response.success(concept_item);

	  },
	  error: function(httpResponse) {
	    response.error('Request failed with response code ' + httpResponse.status);
	  }
	});
});




Parse.Cloud.define("cxense_traffic_event_RetrieveURL", function(request, response) {

	console.log("cxense_traffic_event_RetrieveURL");

	var str_concept = "dac";

	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');
	var groups_array = new Array("url");
	var filter1 = { "type":"keyword","group":"concept","item":str_concept};
	var filter2 = { "type":"keyword","group":"site","item":"www.dac.co.jp"};
//	var filter3 = { "type":"keyword","group":"pageclass","item":"article"};
	var filters_array = [filter1/*,filter2/, filter3 */];

	Parse.Cloud.httpRequest({
	  method: 'POST',
	  url: 'https://api.cxense.com/traffic/event',
	  headers: {
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	siteId: '1128275557251903601',
	  	start: -1728000,
	  	groups: groups_array,
	  	count: 20,
	  	filters: filters_array
	 // 	orderBy: 'uniqueUsers'
	  },
	  success: function(httpResponse) {
	  	console.log("str concept is " + str_concept + " url list is" + httpResponse.text);
	     var data_obj = JSON.parse(httpResponse.text);
	     var groups_array = data_obj.groups;
	     var URL_item_array = new Array();
	     var URL_items_array = new Array();
	     for(var i=0; i<groups_array.length; i++ ){
	     	if(groups_array[i].group == "url"){
	     		URL_items_array = groups_array[i].items;
	     		for(var j=0; j<URL_items_array.length; j++){
	     			URL_item_array.push(URL_items_array[j].item);
	     		}
	     	}
	     }
	     console.log("url_array is" + URL_item_array);

	  },
	  error: function(httpResponse) {
	//    response.error('Request failed with response code ' + httpResponse.status);
	    console.log('Request failed with response code ' + httpResponse.status);
	  }
	});
});




Parse.Cloud.define("traffic_filter", function(request, response) {
	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');
	var fields_array = ["events","urls","activeTime"];
	var filter2 = { "type":"keyword","group":"site","item":"dac.co.jp"};
	var filters_array = new Array(filter2);

	Parse.Cloud.httpRequest({
	  method: 'POST',
	  url: 'https://api.cxense.com/traffic',
	  headers: {
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	siteId: '1128275557251903601',
	  	start: -864000,
	  	fields: fields_array,
	  	filters: filters_array
	  },
	  success: function(httpResponse) {
	  	response.success(httpResponse.text);
	  },
	  error: function(httpResponse) {
	  	response.error(httpResponse.text);
	  }
	});
});



Parse.Cloud.define("traffic_keyword", function(request, response) {
	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');

	var groups_array = ["concept"];
	var filter = { "type":"keyword","group":"pageclass","item":"article"};
	var filters_array = [filter];

	Parse.Cloud.httpRequest({
	  method: 'POST',
	  url: 'https://api.cxense.com/traffic/keyword',
	  headers: {
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	siteId: '1128275557251903601',
	  	start: -864000,
	  	groups: groups_array,
	 // 	filters: filters_array
	  },
	  success: function(httpResponse) {
	  	response.success(httpResponse.text);
	  },
	  error: function(httpResponse) {
	  	response.error(httpResponse.text);
	  }
	});
});




Parse.Cloud.define("profile_content_fetch", function(request, response) {
    console.log("profile_content_fetch");

	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');
	var groups_array = ["url","title","thumbnails"];

	Parse.Cloud.httpRequest({
	  method: 'post',
	  url: 'https://api.cxense.com/profile/content/fetch',
	  headers: { 
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	url: 'http://m.dac.co.jp/group/president.html',
	  	groups: groups_array
	  },
	  success: function(httpResponse) {

		var data_obj = JSON.parse(httpResponse.text);
		console.log(data_obj);
		var site_url = data_obj.url;
		var site_title = data_obj.title;
		var image_height = 0;
		var image_width = 0;
		var image_url = "";

		//var profile_content_array = new Array(data_obj);
		
		//for(var m=0; m<profile_content_array.length; m++){
			//var thumbnail_array = profile_content_array[m].thumbnails;

			var thumbnail_array = data_obj.thumbnails;
			console.log("thumbnail array" + thumbnail_array);
			
			for(var l=0; l<thumbnail_array.length; l++){
				console.log(thumbnail_array[l]);
				if( thumbnail_array[l].type == "dominant"){
					console.log("dominant thumbnail found");
					image_height = thumbnail_array[l].height;
					image_width = thumbnail_array[l].width;	
					console.log(thumbnail_array[l].width);
					console.log(thumbnail_array[l].height);
					console.log(thumbnail_array[l].url);
				}
			}
		//}
	  },

	  error: function(httpResponse) {
	//    response.error('Request failed with response code ' + httpResponse.status);
	    console.log('Request failed with response code ' + httpResponse.status);
	  }
	});
});


Parse.Cloud.define("file_create_test", function(request, status) {

	var bytes = [ 0xBE, 0xEF, 0xCA, 0xFE ];
	var file = new Parse.File("myfile.txt", bytes);

	file.save().then(function() {
	  // The file has been saved to Parse.
	  console.log("file save success");
	}, function(error) {
	  // The file either could not be read, or could not be saved to Parse.
	  console.log("file save fail");
	});
});
