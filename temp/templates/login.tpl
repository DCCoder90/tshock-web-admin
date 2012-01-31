{include file='inc/header.tpl'}
<br /><br /><br />
<center>

<div id="loginform">
<form action="{$url}/action.php?act=login" method="post">

Username: <input type="text" name="user" value="" /><br />
Password: <input type="password" name="pass" value="" /><br />
<input type="submit" name="login" value="Login!" />

</form>
</div>

</center>
{include file='inc/footer.tpl'}