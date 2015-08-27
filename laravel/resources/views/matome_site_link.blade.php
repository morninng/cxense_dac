@extends('Matomelayout')

@section('main_context')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


<script src="//www.parsecdn.com/js/parse-1.4.2.min.js"></script>

<script type="text/javascript">
  Parse.initialize("ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o", "xzNZRy8xJsxKda2snnLcx9xsAo49DQrKnbIQ7CPH");
</script>


 Matome site link<br>
<hr>

<ul id="matome_list"></ul>

<script type="text/template" data-template="matome_keyword_link">
  <li>
    <a href="/matome_site/<%= keyword %>"><%= keyword %></a>
  </li>
</script>


<script type="text/javascript">
    var MatomeKeyword = Parse.Object.extend("MatomeKeyword");
    var matome_query = new Parse.Query(MatomeKeyword);
    matome_query.find({
      success: function(results) {
        for(var i=0; i<results.length; i++){
          var object = results[i];
          var keyword = object.get("keywordlist");
          console.log(keyword);
          add_link(keyword);

        }
      },
      error: function(error) {
        alert("Error: " + error.code + " " + error.message);
      }
    });

function add_link(in_keyword){

  var link_template = _.template($('[data-template="matome_keyword_link"]').html());
  var data = {keyword:in_keyword};
  link_html_list = link_template(data);
  $("#matome_list").append(link_html_list);



}



</script>

@stop


