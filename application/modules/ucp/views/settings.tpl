<div class="container">
    <div class="row">
        {$link_active = "settings"}
        {include file="../../ucp/views/ucp_navigation.tpl"}

        <div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
            <div class="section-header">{lang("settings", "ucp")}</div>
            <div class="section-body">

                <form onSubmit="Settings.submitInfo(); return false" id="settings_info" class="page_form">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="username_field">{lang("username", "ucp")}</label>
                        <div class="col-sm-9">
                            <input class="form-control pe-none" type="text" id="username_field" name="username_field" placeholder="{lang("username", "ucp")}" value="{$username}" readonly>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-sm-3 col-form-label" for="nickname_field">{lang("nickname", "ucp")}</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="nickname_field" name="nickname_field" placeholder="{lang("nickname", "ucp")}" value="{$nickname}" oninput="Settings.validateNickname()" required>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-sm-3 col-form-label" for="location_field">{lang("location", "ucp")}</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="location_field" name="location_field" placeholder="{lang("location", "ucp")}" value="{$location}" oninput="Settings.validateLocation()">
                        </div>
                    </div>

                    {if $show_language_chooser}
                        <div class="form-group row mt-3">
                            <label class="col-sm-3 col-form-label" for="language_field">Website Language</label>
                            <div class="col-sm-9">
                                <select aria-label="Website Language" name="language_field" id="language_field">
                                    {foreach from=$languages item=language}
                                        <option value="{$language}" {if $userLanguage == $language}selected="selected"{/if}>{ucfirst($language)}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    {/if}

                    <div class="form-group text-center mt-3">
                        <input class="nice_button rounded" type="submit" value="{lang("change_information", "ucp")}">
                    </div>
                </form>

                <hr>

                <form onSubmit="Settings.submit(); return false" id="settings" class="page_form">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="old_password">{lang("old_password", "ucp")}</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" id="old_password" name="old_password" placeholder="{lang("old_password", "ucp")}" autocomplete="current-password" required>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-sm-3 col-form-label" for="new_password">{lang("new_password", "ucp")}</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" id="new_password" name="new_password" placeholder="{lang("new_password", "ucp")}" autocomplete="new-password" oninput="Settings.validateNewPassword()" required>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-sm-3 col-form-label" for="new_password_confirm">{lang("new_password_confirm", "ucp")}</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" id="new_password_confirm" name="new_password_confirm" placeholder="{lang("new_password_confirm", "ucp")}" autocomplete="new-password" oninput="Settings.validatePasswordConfirm()" required>
                        </div>
                    </div>

                    <div class="form-group text-center mt-4">
                        <input class="nice_button rounded" type="submit" value="{lang("change_password", "ucp")}">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
