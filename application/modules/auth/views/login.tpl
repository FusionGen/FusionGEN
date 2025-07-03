<div class="page-subbody mt-0">
<div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
    <form onSubmit="Auth.login(true); return false;">
        <div class="card-body">
            <div class="alert alert-danger text-center error-feedback d-none" role="alert"></div>

            <div class="input-group p-0 flex-row">
                <label for="floatingUser" class="input-group-text" id="username" style="width:45px;"><i class="fas fa-user"></i></label>
                <input type="text" class="form-control username-input border-0" id="floatingUser" autocomplete="username" placeholder="{lang('login_label_user', 'auth')}" aria-describedby="username" required>
            </div>

            <div class="input-group p-0 mt-3 flex-row">
                <label class="input-group-text cursor-pointer" id="password" style="width:45px;" data-input-id="floatingPassword" data-show="false" onClick="Auth.showPassword(this);"><i class="fas fa-eye-slash"></i></label>
                <input type="password" class="form-control password-input border-0" id="floatingPassword" autocomplete="current-password" placeholder="{lang('login_label_password', 'auth')}" aria-describedby="password" required>
            </div>

            {if $use_captcha && $captcha_type == 'inbuilt'}
            <div class="captcha-field">
                <div class="input-group mt-3">
                    <label for="floatingCaptcha" class="input-group-text w-100 text-center d-block">
                        <img src="{$url}auth/getCaptcha?{time()}" class="img-fluid pe-none user-select-none" alt="captcha" id="captchaImage">
                    </label>

                    <div class="input-group p-0 flex-row ms-0 flex-grow-1">
                    <label for="floatingCaptcha" class="input-group-text cursor-pointer" id="captcha" style="width:45px; cursor:pointer;" data-captcha-id="captchaImage" onclick="Auth.refreshCaptcha(this);"><i class="fas fa-rotate"></i></label>
                        <input type="text" id="floatingCaptcha" class="form-control captcha-input border-0" name="floatingCaptcha" placeholder="CAPTCHA" aria-describedby="captcha" required>
                    </div>
                </div>
            </div>
            {/if}

            <div class="card-links mt-3 d-flex justify-content-between">
                <div class="form-check form-switch">
                    <input class="form-check-input remember-check" type="checkbox" id="checkRemember">
                    <label class="form-check-label" for="checkRemember">{lang("login_label_remember", "auth")}</label>
                </div>

                {if $has_smtp}
                    <a href="{$url}password_recovery" class="card-link">{lang("login_link_password_forgot", "auth")}</a>
                {/if}
            </div>
        </div>

        <div class="form-group text-center mt-4">
        <button class="nice_button rounded">
            {lang("login_button", "auth")}
        </button>
        </div>
    </form>
</div>
</div>

{if $use_captcha && $captcha_type == 'inbuilt'}
<script>
    $(window).on("load", function() {
        Auth.useCaptcha = true;
    });
</script>
{/if}
