<!DOCTYPE html> 
<html> 
	<head> 
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="apple-touch-icon" href="apple-touch-icon.jpg"/>
<link rel="apple-touch-startup-image" href="apple-touch-startup-image.jpg">
<meta name = "viewport" content = "user-scalable=no, width=device-width">
	<title>Cinema with friends</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script>
	$(document).bind("mobileinit", function(){
	  $.extend(  $.mobile , {
	    defaultDialogTransition: 'pop',
	   	defaultPageTransition: 'slide'
	  });
	});
	</script>
	<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
</head> 
<body> 


<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '230435950418177', // App ID
      channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    FB.Event.subscribe('auth.statusChange', handleStatusChange);
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));


   function handleStatusChange(response) {
     document.head.className = response.authResponse ? 'connected' : 'not_connected';

  if (response.authResponse) 
  {
 	 $('#login1').hide();
 	$('#friends1').show();
	$('#logout1').show();
	
     updateUserInfo(response);
     getUserFriends();

  }
  else
  {
    $('#login1').show();
  	$('#friends1').hide();
	$('#logout1').hide();
  }
  
  $('#lista').listview ("refresh");


   }

</script>


<div data-role="page" id="home">

	<div data-role="header">
		<h1>Cinema with friends</h1>
	</div><!-- /header -->

	<div data-role="content">	
		<p>Options</p>	
		
		
<ul id="lista" data-role="listview" data-inset="true">
	<li id="login1"><a id="login2" href="#" onclick="fb_login();">Login with Facebook</a></li>
	<li id="friends1"><a href="#friends">See a movie with your friend</a></li>
	<li id="logout1"><a id="logout2" href="#" onclick="fb_logout();">Log out</a></li>
	
</ul>


	</div><!-- /content -->

</div><!-- /page -->


<div data-role="page" id="friends">

	<div data-role="header">
		<a href="#home" data-icon="arrow-l" class="ui-btn-left" data-direction="reverse">Back</a>
		<h1>Friends</h1>
	</div><!-- /header -->

	<div data-role="content">	
		<h2 id="user-info">Friends of </h2>	
		
		
<ul id="lista3" data-role="listview" data-inset="true">
</ul>

	</div><!-- /content -->

</div><!-- /page -->


<div data-role="dialog" id="dialog">

	<div data-role="header">
		<h1 id="friend_name"></h1>
	</div><!-- /header -->

	<div data-role="content">	
<div data-role="fieldcontain">
    <label for="name" id="label"></label>
    <input type="text" name="name" id="desc" value=""/>
</div>	

<form action="#" method="post">
<label for="foo">
<select onchange="insert_film(film_names.options[film_names.selectedIndex].text, film_names.value)" name="film_names" id="film_names">
</select>
<a onclick="sendRequest(film_names.options[film_names.selectedIndex].text, film_names.value);" href="#friends" data-role="button" data-theme="b">Invite</a>
<a href="#friends" data-role="button">Cancel</a>
</form>


<div id="friend_id" style="display:none"></div>
<div id="current_permalink" style="display:none"></div>
	</div><!-- /content -->

</div><!-- /page -->



<script>
$(document).bind('pageshow',function(event, ui){

//alert(document.head.className);

  if (document.head.className == 'connected') 
  {
  	$('#login1').hide();
 	$('#friends1').show();
	$('#logout1').show();

  }
  else
  {
    $('#login1').show();
  	$('#friends1').hide();
	$('#logout1').hide();
  }
  
  $('#lista').listview ("refresh");
 
});

	function fb_login()
    {
		FB.login(function(response) { 
		
//		console.log(response);
//		alert(9); 
		
		if (response.authResponse)
		{
			$('#login1').hide();
			$('#lista').listview ("refresh");
		}
		else
		{
			//$('#login2').html('Login failed, try again');
		}
		
		}, {scope:'email,friends_location,user_location,publish_actions'});
		return false;
    }


	function fb_logout()
	{
		//alert(document.head.className);
		
		if(document.head.className == 'connected')
    	{
    		$('#logout2').html('Logging out...');
    		
			//console.log($(this).data('referrer'));
			FB.logout(function(response) {
		    $('#login1').show();
		  	$('#friends1').hide();
			$('#logout2').html('Log out');
			$('#logout1').hide();
			$('#lista').listview ("refresh");

			});
    	}
	}

function sendRequest(film,permalink) {
//  	  alert(uid);

call_phone('Piotr Zgodziński','Kraków',film);


open_graph(permalink);	

  FB.ui({
    method: 'apprequests',
    message: $('#desc').val(),
    suggestions: $('#friend_id').html(),
  }, 
  function(response) {
    //console.log('sendRequest response: ', response);
  });
}

//

   function updateUserInfo(response) {
     FB.api('/me', function(response) {
     	$('#user-info').append(response.name);
     	$('#label').append(response.name+' ');
       //document.getElementById('user-info').innerHTML = response.name; // + '<br><img src="https://graph.facebook.com/' + response.id + '/picture">';
     });
   }

function sortByName(a, b) {
    var x = a.name.toLowerCase();
    var y = b.name.toLowerCase();
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
}


function getUserFriends() {
   FB.api('/me/friends&fields=name,picture,location', function(response) {
     if (!response.error) {
       var markup = '';
       var markup2 = '';

       var friends = response.data.sort(sortByName);




       for (var i=0; i < friends.length; i++) 
       {
         var friend = friends[i];

		if(friend.location)
		{
         //if(friend.name == 'Tomasz Piotrowski')
		 //console.log(friend.location.name);
         markup += '<li><a onclick="prepare_dialog(\''+friend.name+'\', '+friend.id+', \''+friend.location.name+'\');" data-rel="dialog" href="#dialog"><img src="' + friend.picture.data.url + '"> ' + friend.name + '</a></li>';
         //markup += '<li class="arrow" id="' + friend.id + '"><a href="#friend'+ friend.id +'"><img src="' + friend.picture.data.url + '"> ' + friend.name + '</a></li>';
         //markup2 += '<div id="friend'+ friend.id +'"><div class="toolbar"><h1>'+ friend.name +'</h1><a class="back" href="#">Back</a></div><ul class="rounded" id="friends"><li>'+ friend.name +'<br><img src="' + friend.picture.data.url + '"></li></ul></div>';
		}
	   }

		$('#lista3').html(markup);
		$('#lista3').listview ("refresh");
		//$('body').append(markup2);

       //document.getElementById('user-friends').innerHTML = markup;
     }
   });
 }


function prepare_dialog(friend, id, city)
{
	//console.log(city);
	$('#friend_name').html('With: '+friend);
	$('#friend_id').html(id);
	
	
		var page = $.ajax({url: "film.php?city="+city, 
					   type: "GET",
					   success: function(r){
	//
	//console.log('aaa');
	myObject = JSON.parse(r);
	
	//console.log(myObject);
$.each(myObject, function(key, value) { 

	//console.log(value);
	$('#film_names').append('<option value="'+value.permalink+'">'+value.title+'</option>');
  
});
$('#desc').val('wants to see '+ myObject[0].title +' with you!');
var myselect = $("#film_names");
myselect[0].selectedIndex = 0;
myselect.selectmenu("refresh");



}
					  });
}

function insert_film(film, permalink)
{
	console.log(film);
	console.log(permalink);
	$('#desc').val('wants to see '+ film +' with you!');
	$('#current_permalink').val(permalink);
	
}

function call_phone(who,city,film)
{
//console.log(film);
//		return 1;

		var page = $.ajax({url: 'http://dev.szeldon.pl/rest/call-request.php?fromwho='+who+'&city='+city+'&film='+film+'&phoneToCall=48698669790', 
					   type: "GET",
					   success: function(r){
}
					  });
//http://dev.szeldon.pl/rest/call-request.php?fromwho=Tomek&city=Warszawa&film=Sex&phoneToCall=48698669790

}

function open_graph(permalink)
{

FB.api(
            '/me/ganymedektwo:suggest?movie=http://filmaster.pl/film/'+ permalink +'/', ///+postUrl,
            'post',
            function(response) {
                if (!response || response.error) {
                    console.info(response);
                } else {
                    //jQuery(idElement).append(' '+response.id);
                }
            });

}


</script>






</body>
</html>