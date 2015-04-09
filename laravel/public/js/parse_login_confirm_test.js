
(function parse_confirmation() {

	Parse.initialize("ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o", "xzNZRy8xJsxKda2snnLcx9xsAo49DQrKnbIQ7CPH");
	var currentuser = Parse.User.current();
	if(currentuser){
		console.log("current user is ");
		console.log(currentuser.id);
	} else{
		console.log("current user cannot be recognized from javascript");
	}


})();
