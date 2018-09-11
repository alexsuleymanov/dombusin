<script>
window.fbAsyncInit = function() {
	FB.init({
		appId      : '191063148108572',
		cookie     : true,                        
		xfbml      : true,
		version    : 'v2.8'
	});
};

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
  
function ASwebFacebookLogin() {
	console.log('ASwebFacebookLogin');
	
	FB.api('/me', function(response) {
		$.post('/auth/facebook', {"id": response.id, "name": response.name}, function (data){
			if (data == 'login' || data == 'register'){
				location.href = '<?=$this->url->mk("/user")?>';
			}
		});
	});
}
</script>

<a id="bx_socserv_icon_Facebook" class="soc-link soc-link__fb" href="javascript:void(0)" onclick="FB.login(function(response) {ASwebFacebookLogin();}, {scope: 'public_profile,email'});">
	<span class="s-icon"><i class="icon-st__fb"></i></span>
	<span class="s-text">Facebook</span>
</a>