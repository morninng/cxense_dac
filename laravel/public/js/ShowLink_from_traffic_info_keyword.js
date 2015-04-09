

window.onload=Show_Cxense_Link;

function Show_Cxense_Link(){
	var i;
	for(i=0;i<site_concept_array.length;i++){
		var site_concept = site_concept_array[i];
		CXENSE_traffic_fromKeyword(site_concept);
	}
}

function CXENSE_traffic_fromKeyword(site_concept){

	var request_url;
	var persisted_url_content_fetch = 'https://api.cxense.com/traffic?persisted=';
	var persisted_id = "d40479dabd63c6745aac772fb9ead84c5d3879c8";
	var callback_content_fetch = '&callback=onGotTrafficFromKeywordFetch&media=json';
	this.counter=0;
	var traffic_fromKeyword_query =  {"filters":[{ "type":"keyword","group":"concept","item":site_concept }]};
	request_url = persisted_url_content_fetch + persisted_id + '&json=' + encodeURIComponent(cX.JSON.stringify(traffic_fromKeyword_query)) + callback_content_fetch;
	$.ajax({
		type: "GET",
		url: request_url,
		dataType: 'jsonp',
		context : this,
		async:true
	})
}

function onGotTrafficFromKeywordFetch(data){

	console.log("call back");
	console.log(site_concept_array[this.counter]);
	var keyword = site_concept_array[this.counter];
	console.log(this.counter);
	this.counter++;

	var response = data.response;
	var active_time = response.data.activeTime;
	var pv_num = response.data.events;
	var urls_num = response.data.urls;
	console.log(active_time);
	console.log(pv_num);
	console.log(urls_num);

	var dom_tr = $('<tr>');
	var dom_td_keyword = $('<td>');
	var dom_td_pv_num = $('<td>');
	var dom_td_url_num = $('<td>');


	dom_td_pv_num.text(pv_num);
	dom_td_url_num.text(urls_num);

	var dom_a = $('<a>');
	dom_a.attr("href","/keyword_matome2/" + keyword);
	dom_a.text(keyword);
	dom_td_keyword.append(dom_a);

	dom_tr.append(dom_td_keyword);
	dom_tr.append(dom_td_pv_num);
	dom_tr.append(dom_td_url_num);

	$("#trend_keyword_table").append(dom_tr);


}
