
window.onload=CXENSE_content_rec;

function CXENSE_content_rec(){

	var persisted_url = 'https://api.cxense.com/public/widget/data';
	var callback_content_rec_fetch = '&callback=onGotContentRec&media=json';
	var content_recommend_query =  {"widgetId":"d982dacf1e822be0c5ccb3f9799de9b637edc2ab"};
	var request_url = persisted_url + '?json=' + encodeURIComponent(cX.JSON.stringify(content_recommend_query)) + callback_content_rec_fetch;
	console.log(request_url);

	cX.library.loadScript(request_url);
}



function onGotContentRec(data){
	console.log("call back");
	console.log(data);
	var items_array = data.response.items;

	var cxense_content_array_kannrenn = new Array();
	var cxense_content_array_userlike = new Array();
	var cxense_content_array_ranking = new Array();
	var ranking_array = ["一位","二位","三位","四位","五位"];

	for(var i=0; i<items_array.length; i++){
		var cxense_img_src = items_array[i].dominantimage;
		var cxense_link_url = items_array[i].click_url;
		var title_array = items_array[i].title.split("【");
		var cxense_title = title_array[0];
		if(i<5){
			var link_obj = {link_url:cxense_link_url,img_src_url:cxense_img_src,link_title:cxense_title};
			cxense_content_array_kannrenn.push(link_obj);
		}else if(5<=i && i<15){
			var link_obj = {link_url:cxense_link_url,img_src_url:cxense_img_src,link_title:cxense_title};
			cxense_content_array_userlike.push(link_obj);
		}else if(15<=i && i<20){
			var link_obj = {link_url:cxense_link_url ,link_title:cxense_title, ranking:ranking_array[0]};
			ranking_array.shift();
			cxense_content_array_ranking.push(link_obj);
		}
	}

	userlike_template = _.template($('[data-template="cxense_userlike_template"]').html());
	userlike_html = userlike_template({list:cxense_content_array_userlike});
	$("#cxense_user_like").html(userlike_html);


	kannrenn_template = _.template($('[data-template="cxense_kannrenn_template"]').html());
	kannrenn_html = kannrenn_template({list:cxense_content_array_kannrenn});
	$("#cxense_kannrenn").html(kannrenn_html);


	ranking_template = _.template($('[data-template="cxense_ranking_template"]').html());
	ranking_html = ranking_template({list:cxense_content_array_ranking});
	$("#cxense_latest").html(ranking_html);

	slide_start();
}



function slide_start() {
  $("#slider").simplyScroll({
  	orientation: 'vertical',
  	auto: true,
  	manualMode: 'loop',
  	frameRate: 20,
  	speed: 1
  });
}