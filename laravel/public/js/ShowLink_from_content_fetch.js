
window.onload=Show_Cxense_Link;


function Show_Cxense_Link(){

	var i;
	for(i=0;i<keyword_matome_array.length;i++){
		var url = keyword_matome_array[i];
		CXENSE_fetch_context_request(url)
	}
}

function CXENSE_fetch_context_request(url){
	var request_url;
	var persisted_url_content_fetch = 'https://api.cxense.com/profile/content/fetch?persisted=';
	var persisted_id_content_fetch = "83fe6407b98582b8065bad01b0d94704187f6ca0";
	var callback_content_fetch = '&callback=onGotContentFetch&media=json';
	var content_fetch_query =  {"url":url};
	var request_url = persisted_url_content_fetch + persisted_id_content_fetch + '&json=' + encodeURIComponent(cX.JSON.stringify(content_fetch_query)) + callback_content_fetch;
	console.log(request_url);

	cX.library.loadScript(request_url);
	console.log("request sent");
}



function onGotContentFetch(data){

	console.log("call back");
	console.log(data);
	var response = data.response;
	var thumbnails_array = response.thumbnails;
	var i;
	var link_url = response.url;
	var link_title = response.title;
	var thumbnail_url = null;
	var thumbnail_width=0;
	var thumbnail_height=0;
	for(i=0;i<thumbnails_array.length; i++){
		if(thumbnails_array[i].type=="dominant"){
			thumbnail_url = thumbnails_array[i].url;
			thumbnail_width = thumbnails_array[i].width;
			thumbnail_height = thumbnails_array[i].height;
			if(thumbnail_height > 100){
				thumbnail_width = thumbnail_width * 100 / thumbnail_height;
				thumbnail_height = 100;
			}
		}
	}
	console.log(thumbnail_url);
	console.log(thumbnail_width);
	console.log(thumbnail_height);

	var dom_img = $('<img>');
	dom_img.attr("src",thumbnail_url);
	dom_img.attr("width",thumbnail_width);
	dom_img.attr("height",thumbnail_height);
	var dom_a = $('<a>');
	dom_a.attr("href",link_url);
	var dom_li = $('<li>');
	dom_li.attr("class","matome_link");
	dom_a.append(dom_img);
	dom_a.append(link_title);
	dom_br = $('<br>');
	dom_a.after(dom_br);
	dom_li.append(dom_a);
	$("#matome").append(dom_li);

}

