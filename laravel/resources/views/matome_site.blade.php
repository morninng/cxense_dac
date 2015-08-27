@extends('Matomelayout')

@section('main_context')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


<script src="//www.parsecdn.com/js/parse-1.4.2.min.js"></script>

<script type="text/javascript">
  Parse.initialize("ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o", "xzNZRy8xJsxKda2snnLcx9xsAo49DQrKnbIQ7CPH");
</script>


 Matome site link of {{$keyword}}<br>
<hr>

<ul style="list-style:none;" id="matome_list"></ul>


<style>
.matome_each_item{
  border: 1px solid #000000;
  display:flex;
  align-items:stretch;
}


.matome_image{
  border: 1px solid #000000;
  width: 120px;
}
.matome_text{
  border: 1px;
  solid #000000;
  flex:1;
}

</style>


<script type="text/template" data-template="matome_context_template">
  <li>
    <div class="matome_each_item">
      <div class="matome_image">
        <img src="<%= img_src %>" style="max-width:100px">
      </div>
      <div class="matome_text">
        <p><strong><a href="<%= url %>" target="_blank"> <%= title %> </a></strong><br>
          <%= descript %><br>
        </p>
      </div>
    </div
  </li>
</script>


<script type="text/javascript">

    var matome_keyword = "{{$keyword}}";
    

    var MatomeContext = Parse.Object.extend("MatomeContext");
    var matome_query = new Parse.Query(MatomeContext);
    matome_query.equalTo("context_keyword", matome_keyword);
    matome_query.find({
      success: function(results) {
        for(var i=0; i<results.length; i++){
          var object = results[i];
          var context_img_src = object.get("img_src");
          var context_title = object.get("title");
          var context_url = object.get("url");
          var context_descript = object.get("descript");
          var object = {
                        img_src:context_img_src,
                        title:context_title,
                        url:context_url,
                        descript:context_descript
                          };
          console.log(object);
          add_link(object);

        }
      },
      error: function(error) {
        alert("Error: " + error.code + " " + error.message);
      }
    });

function add_link(object){

  var matome_context_template = _.template($('[data-template="matome_context_template"]').html());
  matome_context_html = matome_context_template(object);
  $("#matome_list").append(matome_context_html);

}



</script>

@stop


