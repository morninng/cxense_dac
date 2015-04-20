require('cloud/test.js');


Parse.Cloud.define("cxense_dac_home", function(request, response) {

	console.log("------cxense_dac_home start--------------");
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
	     
	     for(i=0;i<concept_item.length; i++){
	     	Save_TrafficInfo_OnParse(concept_item[i],i,concept_item.length, response);
	     }
	  },
	  error: function(httpResponse) {
	    //response.error('Request failed with response code ' + httpResponse.status);
	    console.log('Request failed with response code ' + httpResponse.status);
	  }
	});
});

//{"siteId":"1128275557251903601","start":"-86400",
//"fields":["events","urls","activeTime"],
//"filters":[{"type":"keyword","group":"concept","item":"dac"}]}

function Save_TrafficInfo_OnParse(str_concept, n,nn, response){
	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');
	var filter_obj = { "type":"keyword","group":"concept","item":str_concept };
	var filters_array = new Array(filter_obj);
	var fields_array = ["events","urls","activeTime"];

	Parse.Cloud.httpRequest({
	  method: 'post',
	  url: 'https://api.cxense.com/traffic',
	  headers: { 
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	siteId: '1128275557251903601',
	  	start: -86400,
	  	fields: fields_array,
	  	filters: filters_array
	  },
	  success: function(httpResponse) {
	    var data_obj = JSON.parse(httpResponse.text);
	    var data = data_obj.data;
	    var event_num = data.events;
	    var average_activeTime = data.activeTime;
	    var site_urls = data.urls;
		var SiteConcept = Parse.Object.extend("SiteConcept");
		var site_concept = new SiteConcept();

		site_concept.set("concept", str_concept);
		site_concept.set("pv", event_num);
		site_concept.set("active_time", average_activeTime);
		site_concept.set("url_num", site_urls);
		site_concept.save().then(function(obj) {
		  // the object was saved successfully.
		  console.log("--site concept is saved --");

		  RetrieveURL_list(site_concept.id, str_concept, response);

		}, function(error) {
		  // the save failed.
		});

	 //   response.success(httpResponse.text);

	  },
	  error: function(httpResponse) {
	//    response.error('Request failed with response code ' + httpResponse.status);
	    console.log('Request failed with response code ' + httpResponse.status);
	  }
	});
}

function RetrieveURL_list(site_concept_parse_id, str_concept, response){

	console.log("RetrieveURL_list---------");
	console.log(str_concept + "---");

	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');
	var groups_array = new Array("url");
	var filter1 = { "type":"keyword","group":"concept","item":str_concept};
	var filter2 = { "type":"keyword","group":"site","item":"dac.co.jp"};
	var filter3 = { "type":"keyword","group":"pageclass","item":"article"};
	var filters_array = [filter1,filter2,filter3];

	Parse.Cloud.httpRequest({
	  method: 'POST',
	  url: 'https://api.cxense.com/traffic/event',
	  headers: {
	  	'X-cXense-Authentication': 'username=' + username + ' date=' + date + ' hmac-sha256-hex=' + hmac,
	  	'Content-Type': 'application/json;charset=utf-8'
	  },
	  body: { 
	  	siteId: '1128275557251903601',
	  	start: -864000,
	  	groups: groups_array,
	  	count: 20,
	  	filters: filters_array
	  },
	  success: function(httpResponse) {
	  	console.log("str concept is " + str_concept + "url list is" + httpResponse.text);
	// 	response.success(httpResponse.text);
	  },
	  error: function(httpResponse) {
	//    response.error('Request failed with response code ' + httpResponse.status);
	    console.log('Request failed with response code ' + httpResponse.status);
	  }
	});
}


/*
<Retrieve each context info>
var content_fetch_query =  {"url":url};
{"url":"","groups":["url","title","thumbnails"]}
*/


function Save_EachPageInfo_OnParse(site_concept_id, str_concept){
	console.log(site_concept_id);
	console.log(str_concept);
}

