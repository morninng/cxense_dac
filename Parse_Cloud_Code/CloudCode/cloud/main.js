
Parse.Cloud.define("cxense_dac_home", function(request, response) {
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
	     console.log("groups_array array: " + groups_array);
	     console.log("concept items object: " + concept_items);
	     console.log("concept items array: " + concept_item);


	     
	     for(i=0;i<concept_item.length; i++){
	     	Save_TrafficInfo_OnParse(concept_item[i],i,concept_item.length, response);
	     }

	   // response.success(concept_item);

	  },
	  error: function(httpResponse) {
	    response.error('Request failed with response code ' + httpResponse.status);
	  }
	});
});


//{"siteId":"1128275557251903601","start":"-86400",
//"fields":["events","urls","activeTime"],
//"filters":[{"type":"keyword","group":"concept","item":"dac"}]}

function Save_TrafficInfo_OnParse(str_concept, response){
	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');

	var filter_obj = { "type":"keyword","group":"concept","item":str_concept };
	var filters_array = new Array(filter_obj);
	var fields_array = new Array("events","urls","activeTime");

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
	    console.log("traffic is" + httpResponse.text);
	    var data = data_obj.data;
	    console.log("data is " + data);
	    var event_num = data.events;
	    var average_activeTime = data.activeTime;
	    var site_urls = data.urls;
	    console.log("event num is" + event_num);
	    console.log("activeTime num is" + average_activeTime);
	    console.log("urls num is" + site_urls);

		var SiteConcept = Parse.Object.extend("SiteConcept");
		var site_concept = new SiteConcept();
		site_concept.set("concept", str_concept);
		site_concept.set("pv", event_num);
		site_concept.set("active_time", average_activeTime);
		site_concept.set("url_num", site_urls);
		site_concept.save().then(function(obj) {
		  // the object was saved successfully.
		  console.log("site concept is saved");

		  Save_EachPageInfo_OnParse(site_concept.id, str_concept);

		}, function(error) {
		  // the save failed.
		});

	 //   response.success(httpResponse.text);

	  },
	  error: function(httpResponse) {
	    response.error('Request failed with response code ' + httpResponse.status);
	  }
	});


}

function Save_EachPageInfo_OnParse(site_concept_id, str_concept){
	console.log(site_concept_id);
	console.log(str_concept);
}