{include file='inc/header.tpl'}

<u>Please choose what you want to do:</u><br />

<form action="{$url}/users_edit.php" method="post" id="validateform">
<input type="hidden" name="act" value="add" />
Username: <input type="text" name="user" value="" class="required" /><br />
Email: <input type="text" name="email" value="" class="required email" /><br />

Password: <input type="password" name="pass1" id="ps1" value="" class="required" /><br />
Verify : <input type="password" name="pass2" value="" equalTo="#ps1" class="required" /><br />

<input type="submit" name="submit" value="Add user" />
</form>

{include file='inc/footer.tpl'}