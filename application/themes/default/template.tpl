{include file="{$theme_path}config/global.tpl" scope="parent"}
{include file="{$theme_path}views/header.tpl" scope="parent"}

<body class="gb ltr is-homepage is-compact is-fullwidth has-padding has-slider">
	{include file="{$theme_path}views/parts/topbar.tpl"}
	{include file="{$theme_path}views/parts/header.tpl"}

	{if $show_slider}{include file="{$theme_path}views/parts/slider.tpl"}{/if}

	<section class="section section-content" content>
		{$showSidebox = in_array($moduleName, $sidebox_modules)}
		{if isset($is404) && in_array("errors", $sidebox_modules)}{$showSidebox = true}{/if}
		<div class="container">
			<div class="row">
				<div id="left" class="col-sm-12 col{if $showSidebox}-lg-8{/if}" mainbar="">
					{$page}
				</div>

				{if $showSidebox}
				<div id="right" class="col-sm-12 col-lg-4" sidebar="">
					<nav class="navbar navbar-side">
					<ul class="navbar-nav">
						{foreach from=$menu_side item=menu}
							<li class="nav-item">
								<a {$menu.link} class="nav-link {if $menu.active}nav-active{/if}" title="{$menu.name}" data-hasevent="1">
									<i class="arrow"></i>
									<span>{$menu.name}</span>
								</a>
							</li>
						{/foreach}
					</ul>
					</nav>

					{include file="{$theme_path}views/parts/sidebox.tpl"}
				</div>
				{/if}
			</div>
		</div>
	</section>

	{include file="{$theme_path}views/parts/footer.tpl"}

</body>
</html>

<script>
var App = function() {
	var captchaTime = Date.now();
	var popupLogin = function(e)
	{
        e.preventDefault();
		Swal.fire({
			html: '<form onKeyUp="Popup.login(); return false;" onSubmit="Popup.login(true); return false;">' +
					'<div class="input-group p-0 flex-row">' +
						'<label for="floatingUser" class="input-group-text justify-content-center" id="username" style="width:50px;"><i class="fas fa-user"></i></label>' +
						"<input type='text' class='form-control username-input2 border-0' id='floatingUser' placeholder='Username' aria-describedby='username'>" +
					'</div>' +
					
					'<div class="username-feedback2 ps-2"></div>' +
					
					'<div class="input-group mt-3">' +
						'<label class="input-group-text justify-content-center cursor-pointer" id="password" style="width:50px;" data-input-id="floatingPassword" data-show="false" onClick="Popup.showPassword(this);"><i class="fas fa-eye-slash"></i></label>' +
						'<input type="password" class="form-control password-input2 border-0" id="floatingPassword" placeholder="Password" aria-describedby="password">' +
					'</div>' +
					
					'<div class="password-feedback2 ps-2"></div>' +
					
					'<div class="captcha-field2 {if !$use_captcha && $captcha_type == 'inbuilt'}d-none{/if}">' +
						'<div class="input-group mt-3">' +
							'<label for="floatingCaptcha" class="input-group-text w-100 rounded-0 rounded-top text-center d-block" id="captcha">' +
								'<img src="'+Config.URL+'auth/getCaptcha?{time()}" alt="captcha" width="150" height="30" id="captchaImage">' +
							'</label>' +
		
							'<span class="input-group-text justify-content-center cursor-pointer ms-0 rounded-0 rounded-bottom-start" id="captcha" style="width:50px;" data-captcha-id="captchaImage" onClick="Popup.refreshCaptcha(this);">' +
								'<i class="fas fa-rotate"></i>' +
							'</span>' +
		
							'<div class="form-floating ms-0 flex-grow-1">' +
								'<input type="text" class="form-control captcha-input2 border-0 rounded-0 rounded-bottom-end" id="floatingCaptcha" placeholder="Captcha" aria-describedby="captcha">' +
								'<label for="floatingCaptcha">Captcha</label>' +
							'</div>' +
						'</div>' +
		
						'<div class="captcha-feedback ps-2"></div>' +
					'</div>' +
					
					'<div class="card-links mt-3 d-flex justify-content-between">' +
						'<div class="form-check form-switch">' +
							'<input class="form-check-input remember-check2" type="checkbox" id="checkRemember">' +
							'<label class="form-check-label" for="checkRemember">Remember me</label>' +
						'</div>' +
						
						'<a href="'+Config.URL+'password_recovery" class="card-link">Forgot Password?</a' +
					'</div>' +
						
					'<div class="form-group text-center mt-4">' +
					'<button class="card-footer nice_button">Login</button>' +
					'</div>' +
				'</form>',
			showDenyButton: false,
			showCancelButton: false,
			showConfirmButton: false,
			confirmButtonText: 'Accept',
			denyButtonText: 'Cancel',
			backdrop: true,
			allowOutsideClick: true
			
		})
    }
	
	return {
		initPopupLogin: function(e) {
			popupLogin(e);
		}
	}
}();
</script>
