/**
 * Script de funciones generales del app.
 */


/* Configuracion 
 ------------------------------------------------------ */
$.cookie.json = true;
$.cookie.raw = true;
$.cookie.defaults.path = '/';
/* Utils 
 ------------------------------------------------------ */
var isCookieDefined = function(name) {
	return !(typeof $.cookie(name) == 'undefined');
}
var saveLoginData = function(response){
	user = {};
	user.name = response.name;
	user.picture = response.picture.data.url;
	$.cookie('campo-ciudad.user', user);
}
/* Templater 
------------------------------------------------------ */
var loadUserMenu=function(){
	var context = {};
	var source = $("#user-menu-template").html();
	var userMenu = $("#nav-right");
	var template = Handlebars.compile(source);
	if(isCookieDefined('campo-ciudad.user')){
		context.isLogged = true;
		context.user = $.parseJSON($.cookie('campo-ciudad.user'));
		console.debug(context);
	}else{
		context.isLogged = false;
	}
	userMenu.html(template(context));

	$("#colaborador-btn").click(function() {
		console.log("colaborador solicita inicio de  session. ");
		FB.Event.unsubscribe('auth.authResponseChange', auth_response_change_callback);
		FB.Event.unsubscribe('auth.statusChange', auth_status_change_callback);
		FB.login(function(response) {
			window.location.reload(true);
		},{scope: 'email,user_likes'});
	});
	
	$("#logout-button").click(function(){
		FB.Event.unsubscribe('auth.authResponseChange', auth_response_change_callback);
		FB.Event.unsubscribe('auth.statusChange', auth_status_change_callback);
		$.removeCookie('campo-ciudad.user');
		FB.logout(function(response) {
			window.location.reload(true);
	    });
	});
}


/* Login 
 ------------------------------------------------------ */
var auth_response_change_callback = function(response) {
	console.log("auth_response_change_callback: "+response.status);
	if($('.auth_error').length){
		$.event.trigger('unsynchronized');
	}
	
}

var auth_status_change_callback = function(response) {
	console.log("auth_status_change_callback: " + response.status);
	console.log(response);
	if (response.status === 'connected') {
		FB.api('me?fields=name, picture.type(square){url}', function(response) {
			var event = jQuery.Event( 'connected' );
			event.response = response;
			$.event.trigger(event); 
		});
	} else if (response.status === 'not_authorized') {
		$.removeCookie('campo-ciudad.user');
	} else {
		$.removeCookie('campo-ciudad.user');
	}

}
/* Events 
------------------------------------------------------ */
$(document).on('connected', function(event){
	saveLoginData(event.response);
	loadUserMenu();
});
/* Facebook Api 
------------------------------------------------------ */


/* View init 
------------------------------------------------------ */
$(document).ready(function() {	
	loadUserMenu();
})
