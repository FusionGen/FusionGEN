{form_open('login')}
	<center id="sidebox_login">
		<input type="text" name="login_username" id="login_username" value="" placeholder="{lang("username", "sidebox_info")}">
		<input type="password" name="login_password" id="login_password" value="" placeholder="{lang("password", "sidebox_info")}">
		<center><input type="submit" name="login_submit" value="{lang("log_in", "sidebox_info")}">
		</br></br> <a href="{$url}register">Register an Account</a></center>
	</center>
</form>