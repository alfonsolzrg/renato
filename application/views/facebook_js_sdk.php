<div id="fb-root"></div>
<script>
$(document).ready(function() {
	  $.ajaxSetup({ cache: true });
	  $.getScript('//connect.facebook.net/es_LA/all.js', function(){
	    FB.init({
	        appId      : '992145724134115',
	        xfbml      : true,
	        status : true,
	        cookie : true,
	        version    : 'v2.2'
	    });
	    /* Login validation 
		   ------------------------------------------------------ */
	    FB.getLoginStatus( function(response) {
	    	console.log("User status:"+response.status);
	        if (response.status === 'connected') {
	        } else if (response.status === 'not_authorized') {
	    		$.removeCookie('campo-ciudad.user');
	        } else {
	    		$.removeCookie('campo-ciudad.user');
	        }
	    });
	    /* Events 
		 ------------------------------------------------------ */
	    FB.Event.subscribe('auth.authResponseChange', auth_response_change_callback);
 		FB.Event.subscribe('auth.statusChange', auth_status_change_callback);
	    
	});
});
</script>