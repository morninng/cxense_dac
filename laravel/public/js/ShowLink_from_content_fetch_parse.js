
window.onload=Show_Cxense_Link_fromParse;

function Show_Cxense_Link_fromParse(){

	var concept_keyword = get_keyword();

	construct_dom_site_concept(concept_keyword);

	Parse.initialize("ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o", "xzNZRy8xJsxKda2snnLcx9xsAo49DQrKnbIQ7CPH");
	var SiteProfile = Parse.Object.extend("SiteProfile");
	var site_profile_query = new Parse.Query(SiteProfile);
	site_profile_query.equalTo("concept",concept_keyword);

	site_profile_query.find({
		success: function(results){	
			for (var i=0; i < results.length; i++) {
		 		var site_concept_object = results[i];
		 		site_concept = site_concept_object.get("concept");
		 		site_title = site_concept_object.get("title");
		 		site_img_height = site_concept_object.get("image_height");
		 		site_img_width = site_concept_object.get("image_width");
		 		site_img_url = site_concept_object.get("image_url");
		 		site_content_url = site_concept_object.get("url");
		 		construct_dom_site_link(site_title,site_img_height,site_img_width,site_img_url,site_content_url);
			}
		},
		error: function(error){
			console.log("SiteConcept query find fail" + error );
		}
 	});
}

function get_keyword(){
	var keyword="d";
	var query = window.location.search;

	hash_array  = query.slice(1).split('&');
	for(var i=0; i<hash_array.length;i++){
		array = hash_array[i].split("=");
		if(array[0]=="keyword"){
			keyword =  decodeURIComponent(array[1]);
		}
	}
	return keyword;
}


function construct_dom_site_concept(concept){

	var concept_keyword = "keyword : " + concept;

	var dom_span_concept = $('<span>');
	dom_span_concept.text(concept_keyword);

	$("#concept_keyword").append(dom_span_concept);

}

function construct_dom_site_link(title,img_height,img_width, img_url, content_url){

	console.log(title);
	console.log(img_height);
	console.log(img_width);
	console.log(img_url);
	console.log(content_url);
	console.log("-------");


	var dom_li = $('<li>');
	var dom_a = $('<a>');
	var dom_span_title = $('<span>');
	dom_span_title.text(title);

	var dom_span_image = $('<span>');
	var dom_image = $('<img>');
	dom_image.attr("src",img_url);

	dom_a.attr("href",content_url);
	dom_a.append(dom_span_title);
	dom_a.append(dom_image);
	dom_li.append(dom_a);

	$("#feed_concept_keyword").append(dom_li);

}

