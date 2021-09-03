<style>
#recovery > :last-child {
  display: none;
}
#recovery.switched > :last-child {
  display: block;
}
#recovery.switched > :first-child {
  display: none;
}
</style>

<div id="recovery">
	<div>
		{form_open('password_recovery', $class)}
			<table style="width: 80%">
				<tr>
					<td><label for="recover_username">{lang('username', 'recovery')}</label></td>
					<td><input type="text" id="recover_username" name="recover_username" value="" /></td>
				</tr>
			</table>

			<div style="text-align: center; margin-bottom: 10px">
				<input type="submit" name="change_submit" value="{lang('recover', 'recovery')}" />
			</div>
		</form>
	</div>
	<div>
		{form_open('password_recovery/email', $class)}
			<table style="width:80%">
				<tr>
					<td><label for="recover_email">Email</label></td>
					<td><input type="text" id="recover_email" name="recover_email" /></td>
				</tr>
			</table>

			<center style="margin-bottom:10px;">
				<input type="submit" name="change_submit" value="{lang("recover_username", "recovery")}" />
			</center>
		</form>
	</div>
</div>

<input id="switch_recovery" type="submit" value="Change recovery mode" />

<script>
var wrapper = document.getElementById('recovery');
function switchVisible() {
  wrapper.classList.toggle('switched');
}
document.getElementById('switch_recovery').addEventListener('click', switchVisible);
</script>