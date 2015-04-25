require('cloud/test.js');

Parse.Cloud.define("cxense_dac_home", function(request, response) {

	console.log("------cxense_dac_home start--------------");
	console.log("------cxense_dac_home start--------------");
	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');

	var groups_array = ["concept"];
//	var filter = { "type":"keyword","group":"pageclass","item":"article"};
//	var filters_array = [filter];

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
	  	groups: groups_array,
	//  	filters: filters_array
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
	     var i=0;
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

	console.log("Save_TrafficInfo_OnParse" +str_concept);
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
		  console.log("parse data save failure");
		});

	  },
	  error: function(httpResponse) {
	//    response.error('Request failed with response code ' + httpResponse.status);
	    console.log('Request failed with response code ' + httpResponse.status);
	  }
	});
}

function RetrieveURL_list(site_concept_parse_id, str_concept, response){

//	console.log("RetrieveURL_list---------" + str_concept);

	var  crypto = require('crypto');
	var username = 'cxense-team@dac.co.jp';
	var apiKey = 'api&user&Qkc0a6QqYvTPjOsYbhR7Sg==';
	var date = new Date().toISOString();
	var hmac = crypto.createHmac('sha256', apiKey).update(date).digest('hex');
	var groups_array = new Array("url");
	var filter1 = { "type":"keyword","group":"concept","item":str_concept};
	var filter2 = { "type":"keyword","group":"site","item":"dac.co.jp"};
//	var filter3 = { "type":"keyword","group":"pageclass","item":"article"};
	var filters_array = [filter1,filter2 /*,filter3 */];

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
	 // 	orderBy: 'uniqueUsers'
	  },
	  success: function(httpResponse) {
	  	console.log("str concept is " + str_concept + "url list is" + httpResponse.text);
	// 	response.success(httpResponse.text);

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
	    // console.log("url_array is" + URL_item_array);
	     for(var k=0; k<URL_item_array.length; k++ ){
			 Save_EachPageInfo_OnParse(URL_item_array[k],str_concept,site_concept_parse_id);
		 }
	  },
	  error: function(httpResponse) {
	//    response.error('Request failed with response code ' + httpResponse.status);
	    console.log('Request failed with response code ' + httpResponse.status);
	  }
	});
}


function Save_EachPageInfo_OnParse(in_url, str_concept, parse_site_concept_id ){

//	console.log("save each page info  " + in_url);
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
	  	url: in_url,
	  	groups: groups_array
	  },
	  success: function(httpResponse) {
		var data_obj = JSON.parse(httpResponse.text);
		var site_url = data_obj.url;
		var site_title = data_obj.title;
		var image_height = 0;
		var image_width = 0;
		var image_url = "";

		var SiteProfile = Parse.Object.extend("SiteProfile");
		var site_profile = new SiteProfile();
		site_profile.set("concept", str_concept);
		site_profile.set("url", site_url);
		site_profile.set("title", site_title);

		var thumbnail_array = data_obj.thumbnails;
		for(var l=0; l<thumbnail_array.length; l++){
			if( thumbnail_array[l].type == "dominant"){
				image_height = thumbnail_array[l].height;
				image_width = thumbnail_array[l].width;	
				image_url = thumbnail_array[l].url;
				site_profile.set("image_height", image_height);
				site_profile.set("image_width", image_width);
				site_profile.set("image_url", image_url);
			}
		}
		site_profile.save().then(function(obj) {

		//	console.log("profile context save succeed");
			var SiteConcept = Parse.Object.extend("SiteConcept");
			var siteconcept_query = new Parse.Query(SiteConcept);
		
			return siteconcept_query.get(parse_site_concept_id);

		}).then(function(site_concept_obj){
			site_concept_obj.add("child",site_profile);

			return site_concept_obj.save();
		}).then(function(){
		//	console.log("succeed");
		}),function(error){
			console.log("site profile save fail or adding child on site conceptfail" + error);
		};
	  },
	  error: function(httpResponse) {
	//    response.error('Request failed with response code ' + httpResponse.status);
	    console.log('Request failed with response code ' + httpResponse.status);
	  }
	});
}


Parse.Cloud.afterSave("SiteConcept", function(request) {

  console.log("-----------site concept after save---------");
  var update_time = request.object.updatedAt;
//  console.log("update time of site concept saved: " + update_time);

  var year = update_time.getFullYear();
  var month = update_time.getMonth();
  var date = update_time.getDate();
  var hour = update_time.getHours();
  var minutes = update_time.getMinutes();
  var num_minute_before = minutes-1;
  var second = update_time.getSeconds();
  var num_second_before = second-20;

  var one_minu_before = new Date(year,month,date,hour,minutes,num_second_before);


 var destroy_site_concept_list = new Array();
 var destroy_site_profile_list = new Array();

 var SiteConcept = Parse.Object.extend("SiteConcept");
 var siteconcept_query = new Parse.Query(SiteConcept);
 siteconcept_query.find({
  success: function(results){
    for (var i = 0; i < results.length; i++) {
      var site_concept_object = results[i];
      if(site_concept_object.updatedAt < one_minu_before){
        destroy_site_concept_list.push(site_concept_object);
        site_profile_list = site_concept_object.get("child");
        for(var j=0; j < site_profile_list.length; j++ ){
          destroy_site_profile_list.push(site_profile_list[j])
        }
      }
    }
    for(var k=0; k< destroy_site_profile_list.length; k++){
        var SiteProfile = Parse.Object.extend("SiteProfile");
        var site_profile_query = new Parse.Query(SiteProfile); 
        console.log("site profile to be destroyed" + destroy_site_profile_list[k].id);
        site_profile_query.get(destroy_site_profile_list[k].id, {
          success: function(site_profile_obj){
            site_profile_obj.destroy().then(function(profile_obj){
              console.log(profile_obj.id + " profile obj has been destroyed")
            },function(error){
              console.log("profile obj destroy failed");
            });
          },error: function(obj,error){
            console.log("profile get fail" + error);
          }
        });
    }

    for(var k=0; k< destroy_site_concept_list.length; k++){
        var SiteConcept = Parse.Object.extend("SiteConcept");
        var site_concept_query = new Parse.Query(SiteConcept);
        console.log("site concept to be destroyed is " + destroy_site_concept_list[k].id); 
        site_concept_query.get(destroy_site_concept_list[k].id, {
          success: function(site_concept_obj){
            site_concept_obj.destroy().then(function(concept_obj){
              console.log(concept_obj.id + " profile obj has been destroyed")
            },function(error){
              console.log("profile obj destroy failed");
            });
          },error: function(obj,error){
            console.log("profile get fail" + error);
          }
        });
    }
  },
  error: function(error){
    console.log("SiteConcept query find fail" +error);
  }
 });
});

