@extends('solutionlayout')

@section('main_context')
aaaaaaaaa

<script> 
  Parse.initialize("EWPPdrDVaAIqhRazWp8K0ZlmafAAPt93JiOAonvX", "US6Lheio8PGcBdIpwGFhFSQVpi5GKunGf6hGq5Ze");

 function RegistFbGraphData(){
   FB.api(
      "/me?fields=picture,first_name,last_name,timezone,gender,languages,link,religion",
      function (response) {
        if (response && !response.error) {
          /* handle the result */

          var currentUser = Parse.User.current();

          console.log(response);
          alert("User has been registered");
          currentUser.set("FirstName", response.first_name);
          currentUser.set("LastName", response.last_name);
          currentUser.set("timezone", response.timezone);
          currentUser.set("languages", response.languages);
          currentUser.set("link", response.link);
          currentUser.set("religion", response.religion);
          currentUser.set("Profile_picture", response.picture.data.url);
          currentUser.save(null, {
            success: function(){
              alert("saved");
              window.location.href = "./";
            },
            error: function(){
              alert("fail to save");
              window.location.href = "./";
            }
          });
        }
      }
  );
 }

  function checkLoginState() {
    Parse.FacebookUtils.logIn(null, {
      success: function(user) {
        if (!user.existed()) {
          this.RegistFbGraphData();


        } else {
          alert("User logged in through Facebook!");

          window.location.href = "./";
        }
      },
      error: function(user, error) {
        alert("User cancelled the Facebook login or did not fully authorize.");
      }
    });
  }

  window.fbAsyncInit = function() {
    Parse.FacebookUtils.init({
      appId      : '1569012059986130',
      cookie     : true,  
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.3' // use version 2.1
    });
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

</script>

@stop


