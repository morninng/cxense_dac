


function Show_Cxense_Link_from_Parse(){

	Parse.initialize("ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o", "xzNZRy8xJsxKda2snnLcx9xsAo49DQrKnbIQ7CPH");

	var SiteConcept = Parse.Object.extend("SiteConcept");
	var siteconcept_query = new Parse.Query(SiteConcept);
	siteconcept_query.ascending("active_time");
	siteconcept_query.find({
		success: function(results){	

			for (var i=0; i < results.length; i++) {
		 		var site_concept_object = results[i];
		 		site_concept = site_concept_object.get("concept");
		 		site_pv = site_concept_object.get("pv");
		 		construct_dom_site_concept(site_concept, site_pv);
			}

		},
		error: function(error){
			console.log("SiteConcept query find fail" + error );
		}
 	});
}

function construct_dom_site_concept(concept_keyword,pv_num){

	var dom_tr = $('<tr>');
	var dom_td_concept_keyword = $('<td>');
	var dom_td_pv_num = $('<td>');

	dom_td_pv_num.text(pv_num);

	var dom_a = $('<a>');
	dom_a.attr("href","/keyword_matome2/?keyword=" + concept_keyword + "&cx_keywordclick=" + concept_keyword);
	dom_a.text(concept_keyword);
	dom_td_concept_keyword.append(dom_a);
	dom_tr.append(dom_td_concept_keyword);
	dom_tr.append(dom_td_pv_num);

	$("#trend_keyword_table").append(dom_tr);
}

//window.onload=Show_Cxense_Link_from_Parse;


(function sokuji_jikkkou() {
  Show_Cxense_Link_from_Parse();
})();
