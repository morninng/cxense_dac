@extends('videolayout')

@section('header_area')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Laravel</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/video') }}">Video</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if($login_status==0){ ?>
                        <li><a href="{{ url('/parselogin') }}">Login</a></li>
                        <li><a href="{{ url('/parsesignin') }}">Signin</a></li>
                    <?php }else{ ?>
                        <li><a href="{{ url('/parselogout') }}">Logout</a></li>
                        <li><a href="{{ url('/editprofile') }}">edit profile</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
@stop

@section('left_area_context')
	<?php echo $leftbar_context_converted ?>
@stop

@section('video_main')


{{$media_id}}


    <!-- Start of Brightcove Player -->
    <div style="display:none">
    </div>

    

    <object id="myExperience{{$media_id}}" class="BrightcoveExperience">
      <!-- smart player api params -->
      <param name="includeAPI" value="true" />
     <param name="templateLoadHandler" value="BCL.onTemplateLoad" />
      <param name="templateReadyHandler" value="BCL.onTemplateReady" />

      <param name="bgcolor" value="#FFFFFF" />
      <param name="width" value="480" />
      <param name="height" value="270" />
      <param name="playerID" value="4237079302001" />
      <param name="playerKey" value="AQ~~,AAADu4Qr6XE~,lZqdgeQnXx4kqESpPjmS9ZumSjw-glGC" />
      <param name="isVid" value="true" />
      <param name="isUI" value="true" />
      <param name="dynamicStreaming" value="true" />
      <param name="@videoPlayer" value="{{$media_id}}" />
    </object>





@stop


@section('brightcove_cxense_script')

    <script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>


    <script type="text/javascript">

    var BCL = {};
    var player;
    var APIModules;
    var videoPlayer;
    var meta_str = "";
    var tracked25 = false
    var tracked50 = false
    var tracked75 = false
    var completed = false;


    BCL.onTemplateLoad = function(experienceID){
        player = brightcove.api.getExperience(experienceID);
        APIModules = brightcove.api.modules.APIModules;
    };

    BCL.onTemplateReady = function(evt){
            videoPlayer = player.getModule(APIModules.VIDEO_PLAYER);
        videoPlayer.addEventListener(brightcove.api.events.MediaEvent.BEGIN, BCL.onBegin);
        videoPlayer.addEventListener(brightcove.api.events.MediaEvent.COMPLETE, BCL.onComplete);
        videoPlayer.addEventListener(brightcove.api.events.MediaEvent.PROGRESS, BCL.onProgress);
        console.log("on template ready has been called");
    }

    BCL.onBegin = function(){
        console.log("video start");
            videoPlayer.getCurrentVideo(BCL.start_callback);
        tracked25 = tracked50 = tracked75 = completed = false;
    };

    BCL.start_callback = function(videoDTO){
        console.log(videoDTO);
        BCL.generate_MetaString(videoDTO);
        console.log(meta_str + "_start");
        CallCxense(meta_str, "start");

    }

    BCL.onComplete = function(){
            if(!completed) {
            completed = true;
            console.log(meta_str + "_complete");
            CallCxense(meta_str, "complete");
        }
    };

    BCL.onProgress = function(evt){
        var percent = (evt.position * 100)/evt.duration;
        if((percent >= 25 && percent < 35) && !tracked25) {
            tracked25 = true;
            console.log(meta_str + "_25");
           CallCxense(meta_str, "25");
        }
        else if((percent >= 50 && percent < 60) && !tracked50) {
            tracked50 = true;
            console.log(meta_str + "_50");
           CallCxense(meta_str, "50");
        }
        else if((percent >= 75 && percent < 85) && !tracked75) {
            tracked75 = true;
            console.log(meta_str + "_75");
           CallCxense(meta_str, "75");
        }
    }

    BCL.generate_MetaString = function(videoDTO){
        var tags_array = videoDTO.tags;
        meta_str="";
        for(var i=0; i < tags_array.length; i++){
            console.log(tags_array[i]);
            meta_str = meta_str +"_" + tags_array[i];
        }
    }

    </script>


    <!-- 
    This script tag will cause the Brightcove Players defined above it to be created as soon
    as the line is read by the browser. If you wish to have the player instantiated only after
    the rest of the HTML is processed and the page load is complete, remove the line.
    -->
    <script type="text/javascript">brightcove.createExperiences();</script>

    <!-- End of Brightcove Player -->




    <script type="text/javascript">
        function CallCxense( meta_added, time ) {
           var hashArgs = cX.parseHashArgs();
           var location_url = window.location;
          //var video_url = window.location + meta_added;
           var hashArgs = cX.parseHashArgs();
           meta_added = "Content" + meta_added;
            $.ajax({
                url: hashArgs.page,
                success: function(pageContent, textStatus, jqXHR) {
                    cX.initializePage();
                cX.setCustomParameters({ 'meta': meta_added, 'time': time });
                    cX.setSiteId('1128275557251903601'); // <- Replace with correct site id
                    cX.sendPageViewEvent({'location': location_url});
                }
            });
        }
    </script>

@stop