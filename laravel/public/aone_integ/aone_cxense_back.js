(function(d){
	var expire = 24; // set expire hour

	var callback = function(segs){

		if(current_user_id){
			var aone_obj = 
			{
				id : current_user_id,
				segments: segs
			}
			console.log(aone_obj);
			var xmlHttpRequest = new XMLHttpRequest();
			xmlHttpRequest.open( 'POST', 'http://mixidea.org/dac/aone_cxense_v2.php' );
			xmlHttpRequest.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
			xmlHttpRequest.send( EncodeHTMLForm( aone_obj ));
		}
	};
	var isexpired = function(){
		var a = d.cookie;
		if(a){
			for(var b = a.split("; "), i=0; i < b.length;i++){
				var c = b[i].split("=");
				if(c[0] === "_aocall"){
					return false;
				}
			}
		}
		return true;
	};
	var setexpire = function(){
		var dt = new Date();
		dt.setTime(dt.getTime() + 3600000 * expire);
		d.cookie = '_aocall=1; expires=' + dt.toGMTString() + '; path=/';
	};
//	if(isexpired()){    //for the easiness of test, it should be changed later
	if(true){
		window._aone_dd = window._aone_dd || {
			cb : callback
		};
		var base = document.getElementsByTagName("script")[0];
		var obj = document.createElement("script");
		obj.async = !0;
		obj.src= "http://a.one.impact-ad.jp/dd?oid=c7fa75350a4dace7&rft=j&jsonp=_aone_dd.cb";
		base.parentNode.insertBefore(obj,base);
		setexpire();
	}
})(document)


function EncodeHTMLForm( data )
{
    var params = [];
    for( var name in data )
    {
        var value = data[ name ];
        var param = encodeURIComponent( name ).replace( /%20/g, '+' )
            + '=' + encodeURIComponent( value ).replace( /%20/g, '+' );
        params.push( param );
    }
    return params.join( '&' );
} 